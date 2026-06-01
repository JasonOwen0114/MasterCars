<?php

namespace App\Http\Controllers;

use App\Models\{
    JadwalInspeksi,
    Inspeksi,
    Mobil,
    InspeksiEksterior,
    InspeksiInterior,
    InspeksiKelengkapan,
    InspeksiMesin,
    FiturMobil
};
use App\Models\JadwalBooking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class StaffController extends Controller
{
    public function dashboard()
    {
        $jadwal = JadwalInspeksi::where('staff_id', auth()->id())
            ->where('status', 2)
            ->where('order_id', 'NOT LIKE', 'INSPEKSI-ULANG%')
            ->orderBy('jadwal')
            ->orderBy('jam')
            ->get();

        $reinspeksi = JadwalInspeksi::where('staff_id', auth()->id())
            ->where('status', 2)
            ->where('order_id', 'like', 'INSPEKSI-ULANG%')
            ->orderBy('jadwal')
            ->orderBy('jam')
            ->get();

        return view('staff.dashboard', compact('jadwal', 'reinspeksi'));
    }

public function formInspeksi($id)
{
    $jadwal = JadwalInspeksi::findOrFail($id);

    $mobil = null;

    if ($jadwal->tipe == 'inspeksi_ulang') {

        if ($jadwal->mobil_id) {

            $mobil = Mobil::find($jadwal->mobil_id);
        }
    }


    elseif ($jadwal->tipe == 'reinspeksi') {

        $reinspeksi = DB::table('reinspeksi')
            ->where('jadwal_id', $jadwal->id)
            ->first();

        if ($reinspeksi && $reinspeksi->mobil_id) {

            $mobil = Mobil::find($reinspeksi->mobil_id);
        }
    }

    $lastInspeksi = null;

    if ($mobil) {

        $lastInspeksi = Inspeksi::with([
                'mobil',
                'eksterior',
                'interior',
                'mesin',
                'kelengkapan'
            ])
            ->where('mobil_id', $mobil->id)
            ->latest()
            ->first();
    }

    return view('staff.form', compact(
        'jadwal',
        'mobil',
        'lastInspeksi'
    ));
}

public function simpanInspeksi(Request $request, $id)
{
    DB::transaction(function () use ($request, $id) {

        $jadwal = JadwalInspeksi::findOrFail($id);

        $isInspeksiBaru  = $jadwal->tipe == 'inspeksi';
        $isInspeksiUlang = $jadwal->tipe == 'inspeksi_ulang';
        $isReinspeksi    = $jadwal->tipe == 'reinspeksi';

        $mobil = null;

        if ($isInspeksiBaru) {

            $mobil = Mobil::create(array_merge(
                [
                    'user_id' => $jadwal->user_id,
                    'status' => 'menunggu'
                ],
                $request->mobil ?? []
            ));

            foreach ($request->file('mobil', []) as $key => $file) {

                if ($file) {

                    $mobil->$key = $file->store('mobil', 'public');
                }
            }

            $mobil->save();
        }
        elseif ($isInspeksiUlang) {

            if (!$jadwal->mobil_id) {
                throw new \Exception('mobil_id inspeksi ulang kosong');
            }

            $mobil = Mobil::find($jadwal->mobil_id);

            if (!$mobil) {
                throw new \Exception('Mobil inspeksi ulang tidak ditemukan');
            }

            $mobil->update(array_merge(
                $request->mobil ?? [],
                [
                    'reinspeksi_used' => 2
                ]
            ));

            foreach ($request->file('mobil', []) as $key => $file) {

                if ($file) {

                    $mobil->$key = $file->store('mobil', 'public');
                }
            }

            $mobil->save();
        }


elseif ($isReinspeksi) {

    $reinspeksi = DB::table('reinspeksi')
        ->where('jadwal_id', $jadwal->id)
        ->first();

    if (!$reinspeksi) {
        throw new \Exception('Data reinspeksi tidak ditemukan');
    }
    $mobil = Mobil::findOrFail($reinspeksi->mobil_id);

}

        if (!$mobil) {
            throw new \Exception('Data mobil gagal diproses');
        }

$inspeksi = Inspeksi::create([

    'mobil_id' => $mobil->id,

    'staff_id' => auth()->id(),
    'tanggal_inspeksi' => now(),
]);

        $this->simpanDetail(
            InspeksiEksterior::class,
            $request->eksterior,
            $request,
            $inspeksi->id,
            'eksterior',
            'eksterior'
        );

        $this->simpanDetail(
            InspeksiInterior::class,
            $request->interior,
            $request,
            $inspeksi->id,
            'interior',
            'interior'
        );

        $this->simpanDetail(
            InspeksiMesin::class,
            $request->mesin,
            $request,
            $inspeksi->id,
            'mesin',
            'mesin'
        );

        $this->simpanDetail(
            InspeksiKelengkapan::class,
            $request->kelengkapan,
            $request,
            $inspeksi->id,
            'kelengkapan',
            'kelengkapan'
        );

        $nilaiEksterior   = $this->ambilNilai($request->eksterior);
        $nilaiInterior    = $this->ambilNilai($request->interior);
        $nilaiMesin       = $this->ambilNilai($request->mesin);
        $nilaiKelengkapan = $this->ambilNilai($request->kelengkapan);

        $inspeksi->update([
            'grade_eksterior'   => $this->hitungGrade($nilaiEksterior),
            'grade_interior'    => $this->hitungGrade($nilaiInterior),
            'grade_mesin'       => $this->hitungGrade($nilaiMesin),
            'grade_kelengkapan' => $this->hitungGrade($nilaiKelengkapan),
            'grade_keseluruhan' => $this->hitungGrade(array_merge(
                $nilaiEksterior,
                $nilaiInterior,
                $nilaiMesin,
                $nilaiKelengkapan
            )),
        ]);

        if (!$isReinspeksi) {

            FiturMobil::updateOrCreate(
                ['mobil_id' => $mobil->id],
                ($request->fitur ?? [])
            );
        }

        $jadwal->update([
            'status' => 3
        ]);

        if ($isReinspeksi) {

            $fotoData = [];

            foreach ($request->file('mobil', []) as $key => $file) {

                if ($file) {

                    $fotoData[$key] = $file->store('reinspeksi', 'public');
                }
            }

            DB::table('reinspeksi')
                ->where('jadwal_id', $jadwal->id)
                ->update(array_merge([

                    'status' => 'selesai',
                    'inspeksi_id' => $inspeksi->id,
                    'merk' => $request->mobil['merk'] ?? null,
                    'nama_mobil' => $request->mobil['nama_mobil'] ?? null,
                    'tipe' => $request->mobil['tipe'] ?? null,
                    'tahun' => $request->mobil['tahun'] ?? null,
                    'warna' => $request->mobil['warna'] ?? null,
                    'transmisi' => $request->mobil['transmisi'] ?? null,
                    'tipe_mesin' => $request->mobil['tipe_mesin'] ?? null,
                    'kapasitas_kursi' => $request->mobil['kapasitas_kursi'] ?? null,
                    'kapasitas_mesin' => $request->mobil['kapasitas_mesin'] ?? null,
                    'alamat' => $request->mobil['alamat'] ?? null,

                ], $fotoData));
        }
    });

    return redirect()
        ->route('staff.dashboard')
        ->with('success', 'Inspeksi berhasil disimpan');
}

    // private function uploadResize($file, $folder, $w, $h)
    // {
    //     $image = imagecreatefromstring(file_get_contents($file));
    //     $width  = imagesx($image);
    //     $height = imagesy($image);

    //     $thumb = imagecreatetruecolor($w, $h);

    //     imagecopyresampled($thumb, $image, 0, 0, 0, 0, $w, $h, $width, $height);

    //     $filename = $folder . '/' . Str::random(40) . '.jpg';
    //     $path = storage_path('app/public/' . $filename);

    //     imagejpeg($thumb, $path, 80);

    //     imagedestroy($image);
    //     imagedestroy($thumb);

    //     return $filename;
    // }

    private function ambilNilai($data)
    {
        $nilai = [];

        foreach ($data ?? [] as $key => $val) {
            if (str_starts_with($key, 'note_') || str_starts_with($key, 'foto_')) {
                continue;
            }

            if (in_array($val, ['A', 'B', 'C', 'D'])) {
                $nilai[] = $val;
            }
        }

        return $nilai;
    }

    private function hitungGrade(array $nilai)
    {
        $count = array_count_values($nilai + ['A'=>0,'B'=>0,'C'=>0,'D'=>0]);

        if (($count['D'] ?? 0) >= 1) return 'D';
        if (($count['C'] ?? 0) >= 3) return 'C';
        if (($count['C'] ?? 0) === 0 && ($count['B'] ?? 0) <= 1) return 'A';

        return 'B';
    }

private function simpanDetail($model, $data, $request, $inspeksiId, $folder, $prefix)
{
    $payload = ['inspeksi_id' => $inspeksiId];
    $fotoMap = [
        'kebersihan_kabin' => 'foto_kebersihan_kabin',
        'kondisi_jok' => 'foto_kondisi_jok',
        'dashboard' => 'foto_dashboard',
        'audio' => 'foto_audio',
        'ac' => 'foto_ac',
        'speedometer' => 'foto_speedometer',
        'karpet' => 'foto_karpet',
        'power_window' => 'foto_power_window',
        'sunroof' => 'foto_sunroof',
        'sabuk_pengaman' => 'foto_sabuk_pengaman',
        'setir_transmisi' => 'foto_setir_transmisi',
        'kondisi_cat' => 'foto_kondisi_cat',
        'panel_bodi' => 'foto_panel_bodi',
        'lampu_depan' => 'foto_lampu_depan',
        'lampu_belakang' => 'foto_lampu_belakang',
        'velg' => 'foto_velg',
        'ban' => 'foto_ban',
        'kaca' => 'foto_kaca',
        'wiper' => 'foto_wiper',
        'suara_mesin' => 'foto_mesin',
        'getaran_mesin' => 'foto_getaran_mesin', 
        'kebocoran_oli' => 'foto_kebocoran_oli',
        'asap_knalpot' => 'foto_asap_knalpot',
        'transmisi' => 'foto_transmisi',
        'rem' => 'foto_rem',
        'power_steering' => 'foto_power_steering',
        'suspensi' => 'foto_suspensi',
        'radiator' => 'foto_radiator',
        'aki' => 'foto_aki',
        'indikator_dashboard' => 'foto_indikator_dashboard',
        'stnk' => 'foto_stnk',
        'bpkb' => 'foto_bpkb',
        'faktur' => 'foto_faktur',
        'surat_pelepasan' => 'foto_surat_pelepasan',
        'dokumen_tambahan' => 'foto_dokumen_tambahan',
    ];

    foreach ($data ?? [] as $key => $val) {

        if (str_starts_with($key, 'note_') || str_starts_with($key, 'foto_')) {
            continue;
        }

        $payload[$key] = $val;
        $payload["note_$key"] = $data["note_$key"] ?? null;
        $fotoKey = $fotoMap[$key] ?? null;

        if (!$fotoKey) continue;

        $files = $request->file($prefix, []);

        if (isset($files[$fotoKey]) && $files[$fotoKey] instanceof \Illuminate\Http\UploadedFile) {
                $payload[$fotoKey] = $files[$fotoKey]->store($folder, 'public');
        }
}

$model::create($payload);
}


public function booking()
{
    $booking = JadwalBooking::where('staff_id', auth()->id())
        ->whereIn('status', [1, 2]) 
        ->orderBy('jadwal')
        ->orderBy('jam')
        ->get();

    return view('staff.jadwalBooking', compact('booking'));
}

public function acceptBooking($id)
{
    $booking = JadwalBooking::findOrFail($id);

    if ($booking->staff_id != auth()->id()) {
        abort(403);
    }

    if ($booking->status == 1) {
        $booking->update([
            'status' => 2
        ]);
    }

    return back()->with('success', 'Booking di-accept');
}

public function kirimBooking($id)
{
    $booking = JadwalBooking::findOrFail($id);

    if ($booking->staff_id != auth()->id()) {
        abort(403);
    }

    DB::beginTransaction();

    try {

        if ($booking->status == 2) {

            $booking->update([
                'status' => 3
            ]);

            $mobil = Mobil::find($booking->mobil_id);

            if ($mobil) {

                $mobil->update([
                    'status' => 'terjual'
                ]);
            }
        }

        DB::commit();

    } catch (\Exception $e) {

        DB::rollBack();

        return back()->with(
            'error',
            'Gagal kirim mobil'
        );
    }

    return redirect()->route('staff.booking')
        ->with('success', 'Mobil berhasil dikirim & status menjadi terjual');
}
}