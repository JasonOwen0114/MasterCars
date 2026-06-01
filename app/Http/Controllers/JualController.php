<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\JadwalInspeksi;
use App\Models\BiayaInspeksi;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Transaction;
use Carbon\Carbon;

class JualController extends Controller
{
    public function jual1()
    {
        $merks = DB::table('data_mobil')
            ->select('merk')
            ->distinct()
            ->pluck('merk');

        return view('jual1', compact('merks'));
    }

    public function getModelByMerk($merk)
    {
        return DB::table('data_mobil')
            ->where('merk', $merk)
            ->pluck('model');
    }

    public function storeStep1(Request $request)
    {
        $request->validate([
            'merk' => 'required',
            'model' => 'required',
            'tahun' => 'required|integer',
            'kilometer' => 'required|integer|min:0',
            'transmisi' => 'required',
            'warna' => 'required',
            'tipe_mesin' => 'required',
        ]);

        session(['jual_mobil' => $request->all()]);

        return redirect()->route('jual2');
    }
    public function storeStep2(Request $request)
    {
        $request->validate([
            'nomor_kontak' => 'required',
            'alamat' => 'required',
            'kecamatan' => 'required',
            'jadwal' => 'required|date',
            'jam' => 'required',
        ]);
        $tanggal = Carbon::parse($request->jadwal);
        $jam = $request->jam;

        $besok = Carbon::now()->addDay()->startOfDay();
        $batas = Carbon::now()->addDays(7)->endOfDay();

        if ($tanggal->lt($besok) || $tanggal->gt($batas)) {
            return back()->with('error', 'Tanggal inspeksi hanya boleh H+1 sampai H+7');
        }

        $jamCarbon = Carbon::parse($jam);

        if ($jamCarbon->lt(Carbon::createFromTime(8,0)) || $jamCarbon->gt(Carbon::createFromTime(14,0))) {
            return back()->with('error', 'Jam inspeksi hanya 08:00 - 14:00');
        }

        if (!$this->cekSlotAvailable($request->jadwal, $request->jam)) {
            return back()->with('error', 'Jadwal sudah penuh, silakan pilih jam lain');
        }

        $step1 = session('jual_mobil');

        if (!$step1) {
            return redirect()->route('jual1')
                ->with('error', 'Data mobil tidak ditemukan');
        }

        DB::beginTransaction();

        try {

            $inspeksi = JadwalInspeksi::create([
                'user_id' => auth()->id(),
                'staff_id' => null,
                'status' => 0, 
                'merk' => $step1['merk'],
                'model_mobil' => $step1['model'],
                'tahun' => $step1['tahun'],
                'kilometer' => $step1['kilometer'],
                'transmisi' => $step1['transmisi'],
                'warna' => $step1['warna'],
                'tipe_mesin' => $step1['tipe_mesin'],
                'nomor_kontak' => $request->nomor_kontak,
                'alamat' => $request->alamat,
                'kecamatan' => $request->kecamatan,
                'jadwal' => $request->jadwal,
                'jam' => $request->jam,
            ]);

            $order_id = 'INSPEKSI-' . $inspeksi->id . '-' . uniqid();

            $inspeksi->update([
                'order_id' => $order_id
            ]);

            DB::commit();

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal membuat jadwal');
        }


        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = config('services.midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;

        $params = [
            'transaction_details' => [
                'order_id' => $order_id,
                'gross_amount' => 300000,
            ],
            'customer_details' => [
                'first_name' => auth()->user()->name ?? 'Customer',
                'email' => auth()->user()->email ?? 'customer@email.com',
            ],
        ];

        $snapToken = Snap::getSnapToken($params);

        return view('pembayaran', compact('snapToken'));
    }



    public function paymentFinish(Request $request)
    {
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = config('services.midtrans.is_production');

        $order_id = $request->order_id;

        if (!$order_id) {
            return redirect()->route('dashboard')
                ->with('error', 'Order ID tidak ditemukan');
        }

        $inspeksi = JadwalInspeksi::where('order_id', $order_id)->first();

        if (!$inspeksi) {
            return redirect()->route('dashboard')
                ->with('error', 'Data inspeksi tidak ditemukan');
        }

        if ($inspeksi->status == 1) {
            return redirect()->route('dashboard')
                ->with('success', 'Pembayaran sudah diproses');
        }

        $status = Transaction::status($order_id);

        if (in_array($status->transaction_status, ['settlement', 'capture'])) {

            DB::beginTransaction();

            try {


                $inspeksi->update([
                    'status' => 1 
                ]);

                if (!BiayaInspeksi::where('inspeksi_id', $inspeksi->id)->exists()) {
                    BiayaInspeksi::create([
                        'inspeksi_id' => $inspeksi->id,
                        'jumlah' => 300000,
                        'tanggal_bayar' => Carbon::today(),
                    ]);
                }

                DB::commit();

            } catch (\Exception $e) {
                DB::rollBack();
                return redirect()->route('dashboard')
                    ->with('error', 'Gagal update pembayaran');
            }

            return redirect()->route('dashboard')
                ->with('success', 'Pembayaran berhasil');
        }

        return redirect()->route('dashboard')
            ->with('error', 'Pembayaran belum selesai');
    }

    public function paymentFailed()
    {
        return redirect()->route('dashboard')
            ->with('error', 'Pembayaran gagal atau dibatalkan');
    }

    public function cekSlot($tanggal)
{

    $staffCount = DB::table('users')
        ->where('role',2)
        ->count();

    $slots = [
        '08:00:00',
        '11:00:00',
        '14:00:00'
    ];

    $available = [];

    foreach($slots as $slot){

        $count = JadwalInspeksi::where('jadwal',$tanggal)
                    ->where('jam',$slot)
                    ->count();

        if($count < $staffCount){
            $available[] = $slot;
        }

    }

    return response()->json($available);
}
public function cekSlotAvailable($tanggal,$jam)
{

    $staffCount = DB::table('users')
        ->where('role',2)
        ->count();

    $count = JadwalInspeksi::where('jadwal',$tanggal)
            ->where('jam',$jam)
            ->count();

    return $count < $staffCount;
}
}
