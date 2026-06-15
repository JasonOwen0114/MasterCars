<?php

namespace App\Http\Controllers;

use App\Models\Mobil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\JadwalInspeksi;
use Carbon\Carbon;

use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Transaction;

class MobilController extends Controller
{
    public function detail(Mobil $mobil)
    {
        if ($mobil->status !== 'tersedia') {
            abort(404);
        }

        $mobil->load([
            'inspeksi.eksterior',
            'inspeksi.interior',
            'inspeksi.mesin',
            'inspeksi.kelengkapan',
            'fitur'
        ]);

        $fotos = collect([
            $mobil->foto_thumbnail,
            $mobil->foto_depan,
            $mobil->foto_kanan,
            $mobil->foto_kiri,
            $mobil->foto_belakang,
            $mobil->foto_dashboard,
            $mobil->foto_kursi_depan,
            $mobil->foto_kursi_belakang,
            $mobil->foto_bagasi_belakang,
        ])
        ->filter()
        ->values();

        return view('detailMobil', compact('mobil', 'fotos'));
    }

public function booking(Request $request, Mobil $mobil)
{
    $request->validate([
        'nomor_kontak' => 'required',
        'alamat' => 'required',
        'kecamatan' => 'required',
        'jadwal' => 'required|date',
        'jam' => 'required'
    ]);

    if ($mobil->status != 'tersedia') {
        return back()->with('error', 'Mobil tidak tersedia');
    }

    DB::beginTransaction();

    try {

        $dp = 5000000;

        $order_id = 'BOOKING-' . $mobil->id . '-' . uniqid();

$penjual = DB::table('users')
    ->where('id', $mobil->user_id)
    ->first();

DB::table('jadwal_booking')->insert([

    'mobil_id' => $mobil->id,
    'order_id' => $order_id,

    'user_id' => auth()->id(),
    'pembeli_id' => auth()->id(),

    'staff_id' => null,
    'status' => 0,

    'merk' => $mobil->merk,
    'model_mobil' => $mobil->nama_mobil,
    'tahun' => $mobil->tahun,
    'transmisi' => $mobil->transmisi,
    'warna' => $mobil->warna,
    'tipe_mesin' => $mobil->tipe_mesin ?? '-',

    'nomor_kontak' => $request->nomor_kontak,


    'alamat_asal' => $mobil->alamat ?? '-',
    'kecamatan_asal' => $mobil->kecamatan ?? '-',


    'alamat_tujuan' => $request->alamat,
    'kecamatan_tujuan' => $request->kecamatan,

    'jadwal' => $request->jadwal,
    'jam' => $request->jam,

    'note' => null,

    'kilometer' => $mobil->kilometer,

    'created_at' => now(),
    'updated_at' => now(),
]);

        DB::commit();

    } catch (\Exception $e) {

        DB::rollBack();

        return back()->with('error', 'Gagal booking');
    }

    Config::$serverKey = config('services.midtrans.server_key');
    Config::$isProduction = false;
    Config::$isSanitized = true;
    Config::$is3ds = true;

$params = [
    'transaction_details' => [
        'order_id' => $order_id,
        'gross_amount' => $dp,
    ],

    'customer_details' => [
        'first_name' => auth()->user()->nama,
        'email' => auth()->user()->email,
    ],

    'callbacks' => [
        'finish' => route('payment.finish.booking')
    ]
];

    $snapToken = Snap::getSnapToken($params);

    return back()->with('snapToken', $snapToken);
}





    private function cekSlotAvailable($tanggal, $jam)
    {
        $staffCount = DB::table('users')
            ->where('role', 2)
            ->count();

        $count = JadwalInspeksi::where('jadwal', $tanggal)
            ->where('jam', $jam)
            ->count();

        return $count < $staffCount;
    }

public function paymentFinishBooking(Request $request)
{
    Config::$serverKey = config('services.midtrans.server_key');
    Config::$isProduction = false;

    $order_id = $request->order_id;

    $booking = DB::table('jadwal_booking')
        ->where('order_id', $order_id)
        ->first();

    if (!$booking) {
        return redirect()->route('dashboard')
            ->with('error', 'Booking tidak ditemukan');
    }

   
    if ($booking->status != 0) {
        return redirect()->route('dashboard')
            ->with('success', 'Booking sudah dibayar');
    }

    $status = Transaction::status($order_id);

    if (in_array($status->transaction_status, ['settlement', 'capture'])) {

        DB::beginTransaction();

        try {

         


         
            $mobil = Mobil::find($booking->mobil_id);

            if ($mobil) {

        
                $mobil->update([
                    'status' => 'terbooking'
                ]);

            
                DB::table('transaksi')->insert([
                    'mobil_id' => $mobil->id,
                    'pembeli_id' => $booking->user_id,
                    'penjual_id' => $mobil->user_id,
                    'harga' => $mobil->harga,
                    'total_komisi' => 5000000,
                    'tanggal_transaksi' => now()
                ]);
            }

            DB::commit();

        } catch (\Exception $e) {

            DB::rollBack();

            return redirect()->route('dashboard')
                ->with('error', 'Gagal update: ' . $e->getMessage());
        }

        return redirect()->route('dashboard')
            ->with('success', 'Pembayaran berhasil & mobil terbooking');
    }

    return redirect()->route('dashboard')
        ->with('error', 'Pembayaran belum selesai');
}

    public function paymentFailedBooking()
    {
        return redirect()->route('dashboard')
            ->with('error', 'Pembayaran dibatalkan');
    }

}