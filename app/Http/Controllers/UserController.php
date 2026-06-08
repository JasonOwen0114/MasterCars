<?php

namespace App\Http\Controllers;

use App\Models\Mobil;
use App\Models\Inspeksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\JadwalInspeksi;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Midtrans\Snap;
use Midtrans\Config;


class UserController extends Controller
{

    public function index()
    {


    $mobils = Mobil::where('user_id', auth()->id())
        ->where('status','menunggu')
        ->get();

    return view('inspeksi', compact('mobils'));
    }


public function hasil(Mobil $mobil)
{
    if ($mobil->user_id !== auth()->id()) {
        abort(403);
    }

    $mobil->load([
        'inspeksi.eksterior',
        'inspeksi.interior',
        'inspeksi.mesin',
        'inspeksi.kelengkapan'
    ]);

    return view('hasilInspeksi', compact('mobil'));
}
    public function inspeksi()
    {
        $mobils = Mobil::where('user_id', Auth::id())
            ->where('status','menunggu')
            ->get();

        return view('inspeksi', compact('mobils'));
    }

    public function profile()
    {
        return view('profile');
    }

public function updateProfile(Request $request)
{
    $request->validate([
        'nama'      => 'required|string|max:255',
        'email'     => 'required|email|max:255',
        'no_hp'     => 'required|string|max:20',
        'alamat'    => 'nullable|string|max:255',
        'kecamatan' => 'nullable|string|max:100',
    ]);

    $user = auth()->user();

    $user->update([
        'nama'      => $request->nama,
        'email'     => $request->email,
        'no_hp'     => $request->no_hp,
        'alamat'    => $request->alamat,
        'kecamatan' => $request->kecamatan,
    ]);

    return back()->with('success', 'Profil berhasil diperbarui');
}

    public function updatePassword(Request $request)
    {
        $request->validate([
            'password_lama' => 'required',
            'password'      => 'required|min:6|confirmed',
        ]);

        $user = auth()->user();

        if (!Hash::check($request->password_lama, $user->password)) {
            return back()->withErrors([
                'password_lama' => 'Password lama tidak sesuai'
            ]);
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Password berhasil diubah');
    }
    public function pilihStatusJual(Request $request, Mobil $mobil)
    {

        if ($mobil->user_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'status_jual' => 'required|in:1,2'
        ]);

        $mobil->update([
            'status_jual' => $request->status_jual
        ]);

        return back()->with('success', 'Metode penjualan berhasil dipilih');
    }
public function simpanJual(Request $request, Mobil $mobil)
{
    if ($mobil->user_id !== auth()->id()) {
        abort(403);
    }

    $request->validate([
        'status_jual' => 'required|in:1,2',
        'harga'       => 'required|numeric|min:1000000'
    ]);

    $mobil->update([
        'status_jual' => $request->status_jual,
        'harga'       => $request->harga,
        'status'      => 'tersedia' 
    ]);

    return redirect()->route('dashboard')
    ->with('success', 'Mobil berhasil diposting');
}

public function mobilSaya()
{
    $mobils = Mobil::where('user_id', auth()->id())
        ->where('status', 'tersedia')
        ->get();

    return view('mobilSaya', compact('mobils'));
}



public function detailMobilSaya(Mobil $mobil)
{
    if ($mobil->user_id !== auth()->id()) {
        abort(403);
    }

    $mobil->load([
        'inspeksi.eksterior',
        'inspeksi.interior',
        'inspeksi.mesin',
        'inspeksi.kelengkapan'
    ]);


    $lastInspeksi = JadwalInspeksi::where('user_id', auth()->id())
        ->where('merk', $mobil->merk)
        ->where('model_mobil', $mobil->nama_mobil)
        ->where('status', 3) 
        ->latest()
        ->first();

    return view('lihatDetailMobil', compact('mobil','lastInspeksi'));
}

public function reinspeksi(Request $request, Mobil $mobil)
{
    if ($mobil->user_id !== auth()->id()) {
        abort(403);
    }

    $request->validate([
        'nomor_kontak' => 'required',
        'alamat'       => 'required',
        'kecamatan'    => 'required',
        'jadwal'       => 'required|date',
        'jam'          => 'required',
    ]);

    DB::beginTransaction();

    try {

        $jadwal = JadwalInspeksi::create([
            'user_id'      => auth()->id(),
            'status'       => 0,
            'merk'         => $mobil->merk,
            'model_mobil'  => $mobil->nama_mobil,
            'tahun'        => $mobil->tahun,
            'kilometer'    => $mobil->kilometer,
            'warna'        => $mobil->warna,
            'nomor_kontak' => $request->nomor_kontak,
            'alamat'       => $request->alamat,
            'kecamatan'    => $request->kecamatan,
            'jadwal'       => $request->jadwal,
            'jam'          => $request->jam,
        ]);

        $jadwal->update([
            'order_id' => 'INSPEKSI-ULANG-' . $jadwal->id
        ]);

        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = false;
        Config::$isSanitized = true;
        Config::$is3ds = true;

        $params = [
            'transaction_details' => [
                'order_id'    => $jadwal->order_id,
                'gross_amount'=> 300000,
            ],
            'customer_details' => [
                'first_name' => auth()->user()->nama ?? auth()->user()->name ?? 'Customer',
                'email'      => auth()->user()->email,
            ],
        ];

  
        $snapToken = Snap::getSnapToken($params);

        dd([
            'order_id' => $jadwal->order_id,
            'snapToken' => $snapToken
        ]);

        DB::commit();

        return view('pembayaran', compact('snapToken'));

    } catch (\Exception $e) {

        DB::rollBack();

        dd($e->getMessage());
    }
}
public function detail($id)
{
    $mobil = Mobil::with('inspeksi')->findOrFail($id);

    $lastInspeksi = JadwalInspeksi::where('user_id', $mobil->user_id)
        ->where('merk', $mobil->merk)
        ->where('model_mobil', $mobil->nama_mobil)
        ->orderByDesc('jadwal')
        ->first();

    return view('lihatDetailMobil', compact('mobil','lastInspeksi'));
}
public function hasilReinspeksi($id)
{
    $reinspeksi = \App\Models\Reinspeksi::with([
        'inspeksi.eksterior',
        'inspeksi.interior',
        'inspeksi.mesin',
        'inspeksi.kelengkapan'
    ])->where('jadwal_id', $id)->firstOrFail();

    if ($reinspeksi->user_id !== auth()->id()) {
        abort(403);
    }

    if ($reinspeksi->status !== 'selesai') {
        return back()->with('error', 'Inspeksi belum selesai');
    }

    return view('hasilReinspeksi', compact('reinspeksi'));
}
public function cekSlot($tanggal)
{
    $jamList = ['08:00:00', '11:00:00', '14:00:00'];

    $available = [];

    foreach ($jamList as $jam) {

      
        $totalStaff = \App\Models\User::where('role', 2)->count();

   
        $usedStaff = JadwalInspeksi::where('jadwal', $tanggal)
            ->where('jam', $jam)
            ->where('status', 2)
            ->count();

        if ($usedStaff < $totalStaff) {
            $available[] = $jam;
        }
    }

    return response()->json($available);
}
public function bayarReinspeksi(Mobil $mobil)
{
    Config::$serverKey = config('services.midtrans.server_key');
    Config::$isProduction = false;

    $order_id = 'REINSPEKSI-' . uniqid();

    $params = [
        'transaction_details' => [
            'order_id' => $order_id,
            'gross_amount' => 300000,
        ],
    ];

    $snapToken = Snap::getSnapToken($params);

    session([
        'reinspeksi_mobil_id' => $mobil->id,
        'reinspeksi_order_id' => $order_id
    ]);

    return response()->json([
        'snapToken' => $snapToken
    ]);
}
public function finishReinspeksi(Request $request)
{
    $mobil_id = session('reinspeksi_mobil_id');

    DB::beginTransaction();

    try {

        $mobil = Mobil::with('user')->findOrFail($mobil_id);

        $owner = $mobil->user;

        $jadwal = JadwalInspeksi::create([

            'user_id' => auth()->id(),

            'status' => 0,

            'tipe' => 'reinspeksi',

            'mobil_id' => $mobil->id,
            'merk' => $mobil->merk,
            'model_mobil' => $mobil->nama_mobil,
            'tahun' => $mobil->tahun,
            'transmisi' => $mobil->transmisi,
            'warna' => $mobil->warna,
            'tipe_mesin' => $mobil->tipe_mesin,
            'kilometer' => $mobil->kilometer,

            'nomor_kontak' => $owner->no_hp,
            'alamat' => $mobil->alamat,
            'kecamatan' => $mobil->kecamatan,
            'jadwal' => now()->addDay(),
            'jam' => '08:00:00'
        ]);

        $jadwal->update([
            'order_id' => 'REINSPEKSI-' . $jadwal->id . '-' . uniqid()
        ]);

        \App\Models\Reinspeksi::create([

            'mobil_id' => $mobil->id,

            'user_id' => auth()->id(),

            'jadwal_id' => $jadwal->id,

            'status' => 'pending'
        ]);

        DB::commit();

    } catch (\Exception $e){

        DB::rollBack();

        return back()->with(
            'error',
            'Reinspeksi gagal : ' . $e->getMessage()
        );
    }

    return redirect('/')
        ->with('success','Reinspeksi berhasil');
}
public function laporanReinspeksi()
{
    $data = \App\Models\Reinspeksi::with('mobil')
        ->where('user_id', auth()->id())
        ->get();

    return view('laporanInspeksi', compact('data'));
}
public function inspeksiUlang(Request $request, Mobil $mobil)
{
    dd('MASUK INSPEKSI ULANG');
    if ($mobil->user_id !== auth()->id()) {
        abort(403);
    }

    $request->validate([
        'nomor_kontak' => 'required',
        'alamat'       => 'required',
        'kecamatan'    => 'required',
        'jadwal'       => 'required|date',
        'jam'          => 'required',
    ]);

    DB::beginTransaction();

    try {

        JadwalInspeksi::where('user_id', auth()->id())
            ->where('mobil_id', $mobil->id)
            ->where('status', '!=', 3)
            ->delete();

        $jadwal = JadwalInspeksi::create([

            'user_id' => auth()->id(),
            'staff_id' => null,

            'mobil_id' => $mobil->id,

            'status' => 1,
            'tipe' => 'inspeksi_ulang',
            'merk' => $mobil->merk,
            'model_mobil' => $mobil->nama_mobil,
            'tahun' => $mobil->tahun,
            'warna' => $mobil->warna,
            'kilometer' => $mobil->kilometer,
            'tipe_mesin' => $mobil->tipe_mesin,
            'nomor_kontak' => $request->nomor_kontak,
            'alamat' => $request->alamat,
            'kecamatan' => $request->kecamatan,
            'transmisi' => $mobil->transmisi,
            'jadwal' => $request->jadwal,
            'jam' => $request->jam,

            'note' => $request->note,
            'tipe' => 'inspeksi_ulang',
            'mobil_id' => $mobil->id
        ]);


        $jadwal->update([
            'order_id' => 'INSPEKSI-ULANG-' . $jadwal->id . '-' . uniqid()
        ]);

        $mobil->update([
            'reinspeksi_used' => 1
        ]);

        DB::commit();

    } catch (\Exception $e) {

        DB::rollBack();

        return back()->with(
            'error',
            'Gagal booking inspeksi ulang : ' . $e->getMessage()
        );
    }

    return back()->with(
        'success',
        'Inspeksi ulang berhasil dibooking'
    );
}
public function hapusMobil(Mobil $mobil)
{
    if ($mobil->user_id !== auth()->id()) {
        abort(403);
    }

    $mobil->update([
        'status' => 'terhapus'
    ]);

    return redirect()
        ->route('user.mobilSaya')
        ->with('success', 'Mobil berhasil dihapus');
}
}