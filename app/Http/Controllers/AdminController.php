<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JadwalInspeksi;
use App\Models\User; 
use Carbon\Carbon; 
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
public function dashboard()
{
    $jadwal = JadwalInspeksi::with('staff')
        ->where('status', 1)
        ->where('order_id', 'like', 'INSPEKSI-%')
        ->orderBy('jadwal')
        ->orderBy('jam')
        ->get();

    return view('admin.dashboard', compact('jadwal'));
}
public function assignStaff(Request $request, $id)
{
    $request->validate([
        'staff_id' => 'required|exists:users,id'
    ]);
    $jadwal = JadwalInspeksi::findOrFail($id);
    if ($jadwal->status == 3) {
        return back()->with('error', 'Inspeksi sudah selesai');
    }
    $staffId = $request->staff_id;
    $jamMulai   = $jadwal->jam;
    $jamSelesai = date('H:i:s', strtotime($jamMulai . ' +2 hours'));

    $bentrok = JadwalInspeksi::where('staff_id', $staffId)
        ->where('jadwal', $jadwal->jadwal)
        ->where('status', 2)
        ->where(function ($q) use ($jamMulai, $jamSelesai) {

            $q->where('jam', '<', $jamSelesai)
              ->whereRaw(
                  "ADDTIME(jam,'02:00:00') > ?",
                  [$jamMulai]
              );
        })
        ->where('id', '!=', $jadwal->id)
        ->exists();

    if ($bentrok) {
        return back()->with(
            'error',
            'Staff sudah memiliki jadwal di jam tersebut'
        );
    }
    $jadwal->update([
        'staff_id' => $staffId,
        'status'   => 2
    ]);
    if ($jadwal->tipe == 'reinspeksi') {

        DB::table('reinspeksi')
            ->where('jadwal_id', $jadwal->id)
            ->update([
                'status' => 'proses'
            ]);
    }
    return redirect()
        ->route('admin.dashboard')
        ->with('success', 'Staff berhasil di-assign');
}
    public function getAvailableStaff($jadwal)
{
    $jamMulai   = Carbon::parse($jadwal->jam);
    $jamSelesai = $jamMulai->copy()->addHours(2);

    return User::where('role', 2)
        ->whereNotIn('id', function ($q) use ($jadwal, $jamMulai, $jamSelesai) {
            $q->select('staff_id')
              ->from('jadwal_inspeksi')
              ->where('jadwal', $jadwal->jadwal)
              ->where('status', 2)
              ->where(function ($q2) use ($jamMulai, $jamSelesai) {
                  $q2->whereTime('jam', '<', $jamSelesai)
                     ->whereRaw("ADDTIME(jam,'02:00:00') > ?", [$jamMulai]);
              });
        })
        ->get();
}
public function storeAssign(Request $request, $id)
{
    $request->validate([
        'staff_id' => 'required|exists:users,id'
    ]);

    $jadwal = JadwalInspeksi::findOrFail($id);

    $jadwal->update([
        'staff_id' => $request->staff_id,
        'status'   => 2
    ]);

    return back()->with('success','Staff berhasil di-assign');
}
public function createStaff()
{
    return view('admin.addStaff');
}
public function storeStaff(Request $request)
{
    $request->validate([
        'nama'     => 'required|string|max:255',
        'email'    => 'required|email|unique:users,email',
        'password' => 'required|min:6',
        'no_hp'    => 'required',
        'alamat'   => 'required',
    ]);

    User::create([
        'nama'     => $request->nama,
        'email'    => $request->email,
        'password' => Hash::make($request->password), 
        'no_hp'    => $request->no_hp,
        'alamat'   => $request->alamat,
        'role'     => 2 
    ]);

    return redirect()->route('admin.dashboard')
        ->with('success', 'Staff berhasil ditambahkan');
}
public function assignBooking()
{
    $bookings = DB::table('jadwal_booking')
        ->where('status', 0)
        ->orderBy('jadwal')
        ->orderBy('jam')
        ->get();

    return view('admin.assignBooking', compact('bookings'));
}
public function getAvailableStaffDelivery($booking)
{
    $jamMulai   = Carbon::parse($booking->jam);
    $jamSelesai = $jamMulai->copy()->addHours(2);

    return User::where('role', 2)
        ->whereNotIn('id', function ($q) use ($booking, $jamMulai, $jamSelesai) {

           
            $q->select('staff_id')
              ->from('jadwal_inspeksi')
              ->where('jadwal', $booking->jadwal)
              ->where('status', 2)
              ->where(function ($q2) use ($jamMulai, $jamSelesai) {
                  $q2->whereTime('jam', '<', $jamSelesai)
                     ->whereRaw("ADDTIME(jam,'02:00:00') > ?", [$jamMulai]);
              });

        })
        ->whereNotIn('id', function ($q) use ($booking, $jamMulai, $jamSelesai) {

       
            $q->select('staff_id')
              ->from('jadwal_booking')
              ->where('jadwal', $booking->jadwal)
              ->where('status', 1)
              ->where(function ($q2) use ($jamMulai, $jamSelesai) {
                  $q2->whereTime('jam', '<', $jamSelesai)
                     ->whereRaw("ADDTIME(jam,'02:00:00') > ?", [$jamMulai]);
              });

        })
        ->get();
}
public function assignDelivery(Request $request, $id)
{
    $request->validate([
        'staff_id' => 'required|exists:users,id'
    ]);

    $booking = DB::table('jadwal_booking')->where('id', $id)->first();

    DB::table('jadwal_booking')
        ->where('id', $id)
        ->update([
            'staff_id' => $request->staff_id,
            'status' => 1
        ]);

    return back()->with('success', 'Delivery berhasil di-assign');
}
public function reinspeksiList()
{
    $jadwal = JadwalInspeksi::where('tipe', 'reinspeksi')
        ->whereIn('status', [0,1])

        ->orderBy('jadwal')
        ->orderBy('jam')
        ->get();

    return view('admin.reinspeksi', compact('jadwal'));
}

public function laporanKinerjaStaff(Request $request)
{
    $bulan = $request->bulan;
    $tahun = $request->tahun ?? now()->year;
    $sort = $request->sort ?? 'desc';

    $query = DB::table('inspeksi')
        ->join('users', 'inspeksi.staff_id', '=', 'users.id')

        ->select(
            'users.nama',
            DB::raw('COUNT(inspeksi.id) as total_inspeksi')
        )

        ->whereYear('tanggal_inspeksi', $tahun);


    if($bulan){

        $query->whereMonth('tanggal_inspeksi', $bulan);

    }

    $data = $query

        ->groupBy('users.nama')

        ->orderBy('total_inspeksi', $sort)

        ->get();

    return view('admin.laporan.kinerja_staff', compact(
        'data',
        'bulan',
        'tahun',
        'sort'
    ));
}
public function laporanPendapatanBulanan(Request $request)
{
    $tahun = $request->tahun ?? now()->year;

    $data = [];

    for ($i = 1; $i <= 12; $i++) {

        $komisi = DB::table('transaksi')
            ->whereMonth('tanggal_transaksi', $i)
            ->whereYear('tanggal_transaksi', $tahun)
            ->sum('total_komisi');

        $jasa = DB::table('biaya_inspeksi')
            ->whereMonth('tanggal_bayar', $i)
            ->whereYear('tanggal_bayar', $tahun)
            ->sum('jumlah');

        $data[] = (object)[
            'bulan' => $i,
            'komisi' => $komisi,
            'jasa' => $jasa,
            'total' => $komisi + $jasa
        ];
    }

    return view('admin.laporan.pendapatan_bulanan', compact(
        'data',
        'tahun'
    ));
}
public function laporanJadwalTerpadat(Request $request)
{
    $bulan = $request->bulan;
    $tahun = $request->tahun ?? now()->year;
    $sort = $request->sort ?? 'desc';

    $query = DB::table('jadwal_inspeksi')

        ->select(
            'jadwal',
            DB::raw('COUNT(*) as total_jadwal')
        )

        ->whereYear('jadwal', $tahun);
    if($bulan){

        $query->whereMonth('jadwal', $bulan);

    }
    $data = $query
        ->groupBy('jadwal')

        ->orderBy('total_jadwal', $sort)

        ->get();
    return view('admin.laporan.jadwal_terpadat', compact(
        'data',
        'bulan',
        'tahun',
        'sort'
    ));
}

public function laporanJadwalInspeksi(Request $request)
{
    $merk = $request->merk;
    $model = $request->model;
    $bulan = $request->bulan;
    $tahun = $request->tahun;
    $sort = $request->sort ?? 'desc';

    $merks = DB::table('data_mobil')
        ->select('merk')
        ->distinct()
        ->orderBy('merk')
        ->pluck('merk');

    $data = DB::table('jadwal_inspeksi')
        ->join('users as staff', 'jadwal_inspeksi.staff_id', '=', 'staff.id')

        ->when($merk, function($q) use ($merk){
            $q->where('jadwal_inspeksi.merk', $merk);
        })

        ->when($model, function($q) use ($model){
            $q->where('jadwal_inspeksi.model_mobil', $model);
        })

        ->when($bulan, function($q) use ($bulan){
            $q->whereMonth('jadwal', $bulan);
        })

        ->when($tahun, function($q) use ($tahun){
            $q->whereYear('jadwal', $tahun);
        })

        ->select(
            'jadwal_inspeksi.*',
            'staff.nama as staff'
        )

        ->orderBy('jadwal', $sort)

        ->get();

    return view('admin.laporan.jadwal_inspeksi', compact(
        'data',
        'merk',
        'model',
        'bulan',
        'tahun',
        'sort',
        'merks'
    ));
}

public function laporanWaktuPenjualan(Request $request)
{
    $merk = $request->merk;
    $model = $request->model;
    $sort = $request->sort ?? 'asc';

   
    $merks = DB::table('data_mobil')
        ->select('merk')
        ->distinct()
        ->orderBy('merk')
        ->pluck('merk');



    $data = DB::table('transaksi')

        ->join('mobil', 'transaksi.mobil_id', '=', 'mobil.id')

        ->select(
            'mobil.nama_mobil',
            'mobil.merk',
            'mobil.created_at',
            'transaksi.tanggal_transaksi',

            DB::raw('DATEDIFF(
                transaksi.tanggal_transaksi,
                mobil.created_at
            ) as lama_hari')
        )

        ->when($merk, function($q) use ($merk){

            $q->where('mobil.merk', $merk);

        })

        ->when($model, function($q) use ($model){

            $q->where('mobil.nama_mobil', 'like', "%$model%");

        })

        ->orderBy('lama_hari', $sort)

        ->get();



    return view('admin.laporan.waktu_penjualan', compact(
        'data',
        'merk',
        'model',
        'sort',
        'merks'
    ));
}
public function laporanPendapatanInspeksi(Request $request)
{
    $tahun = $request->tahun ?? now()->year;

    $tipe = $request->tipe ?? 'bulan';



    if($tipe == 'bulan'){

        $data = DB::table('biaya_inspeksi')

            ->selectRaw('
                MONTH(tanggal_bayar) as bulan,
                SUM(jumlah) as total_pendapatan
            ')

            ->whereYear('tanggal_bayar', $tahun)

            ->groupByRaw('MONTH(tanggal_bayar)')

            ->orderByRaw('MONTH(tanggal_bayar)')

            ->get();

    }


    else{

        $total = DB::table('biaya_inspeksi')

            ->whereYear('tanggal_bayar', $tahun)

            ->sum('jumlah');

        $data = collect([
            (object)[
                'total_pendapatan' => $total
            ]
        ]);

    }


    return view('admin.laporan.pendapatan_inspeksi', compact(
        'data',
        'tahun',
        'tipe'
    ));
}
public function laporanMobilPerTahun(Request $request)
{
    $merk = $request->merk;
    $model = $request->model;
    $tahun = $request->tahun;
    $sort = $request->sort ?? 'desc';


    $merks = DB::table('data_mobil')
        ->select('merk')
        ->distinct()
        ->orderBy('merk')
        ->pluck('merk');

    $data = DB::table('jadwal_inspeksi')

        ->when($merk, function($q) use ($merk){

            $q->where('merk', $merk);

        })

        ->when($model, function($q) use ($model){

            $q->where('model_mobil', $model);

        })

        ->when($tahun, function($q) use ($tahun){

            $q->where('tahun', $tahun);

        })

        ->select(
            'merk',
            'model_mobil',
            'tahun',
            'transmisi',
            'tipe_mesin'
        )

        ->orderBy('tahun', $sort)

        ->get();

    return view('admin.laporan.mobil_per_tahun', compact(
        'data',
        'merk',
        'model',
        'tahun',
        'sort',
        'merks'
    ));
}
public function laporanHasilInspeksi(Request $request)
{
    $merk = $request->merk;
    $grade = $request->grade;

    $merks = DB::table('data_mobil')
        ->distinct()
        ->pluck('merk');

    $data = DB::table('inspeksi')

        ->join('mobil', 'inspeksi.mobil_id', '=', 'mobil.id')

        ->when($merk, function($q) use ($merk){
            $q->where('mobil.merk', $merk);
        })

        ->when($grade, function($q) use ($grade){

            $q->where(function($qq) use ($grade){

                $qq->where('grade_eksterior', $grade)
                   ->orWhere('grade_interior', $grade)
                   ->orWhere('grade_mesin', $grade)
                   ->orWhere('grade_kelengkapan', $grade);

            });

        })

        ->select(
            'mobil.nama_mobil',
            'mobil.merk',
            'mobil.tahun',
            'inspeksi.grade_eksterior',
            'inspeksi.grade_interior',
            'inspeksi.grade_mesin',
            'inspeksi.grade_kelengkapan'
        )

        ->get();

    return view('admin.laporan.hasil_inspeksi', compact(
        'data',
        'merk',
        'grade',
        'merks'
    ));
}

public function laporanPenjualanMobil(Request $request)
{
    $bulan = $request->bulan;
    $tahun = $request->tahun;
    $sort = $request->sort ?? 'desc';

    $data = DB::table('transaksi')
        ->join('mobil', 'transaksi.mobil_id', '=', 'mobil.id')
        ->join('users as pembeli', 'transaksi.pembeli_id', '=', 'pembeli.id')
        ->join('users as penjual', 'transaksi.penjual_id', '=', 'penjual.id')

        ->when($bulan, function($q) use ($bulan){
            $q->whereMonth('tanggal_transaksi', $bulan);
        })

        ->when($tahun, function($q) use ($tahun){
            $q->whereYear('tanggal_transaksi', $tahun);
        })

        ->select(
            'mobil.nama_mobil',
            'mobil.merk',
            'transaksi.harga',
            'transaksi.tanggal_transaksi',
            'pembeli.nama as pembeli',
            'penjual.nama as penjual'
        )

        ->orderBy('tanggal_transaksi', $sort)

        ->get();

    return view('admin.laporan.penjualan_mobil', compact(
        'data',
        'bulan',
        'tahun',
        'sort'
    ));
}
public function laporanMobilAktif(Request $request)
{
    $merk = $request->merk;
    $model = $request->model;
    $tahun = $request->tahun;
    $sort = $request->sort ?? 'desc';

    $merks = DB::table('data_mobil')
        ->select('merk')
        ->distinct()
        ->pluck('merk');

    $data = DB::table('mobil')

        ->where('status', 'tersedia')

        ->when($merk, function($q) use ($merk){
            $q->where('merk', $merk);
        })

        ->when($model, function($q) use ($model){
            $q->where('nama_mobil', 'like', "%$model%");
        })

        ->when($tahun, function($q) use ($tahun){
            $q->where('tahun', $tahun);
        })

        ->orderBy('created_at', $sort)

        ->get();

    return view('admin.laporan.mobil_aktif', compact(
        'data',
        'merk',
        'model',
        'tahun',
        'sort',
        'merks'
    ));
}
public function getModelsByMerk($merk)
{
    $models = DB::table('data_mobil')
        ->where('merk', $merk)
        ->pluck('model');

    return response()->json($models);
}

}
