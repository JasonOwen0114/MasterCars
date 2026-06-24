@php
function checkedRadio($last, $relation, $field, $value){
    return isset($last?->$relation?->$field) && $last->$relation->$field == $value
        ? 'checked' : '';
}
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Form Inspeksi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

@php
function radioAD($name){
    return "
        <label class='me-2'><input type='radio' name='{$name}' value='A' required> A</label>
        <label class='me-2'><input type='radio' name='{$name}' value='B'> B</label>
        <label class='me-2'><input type='radio' name='{$name}' value='C'> C</label>
        <label><input type='radio' name='{$name}' value='D'> D</label>
    ";
}
@endphp

<div class="container my-4">
<h3 class="text-center fw-bold mb-4">Form Inspeksi Mobil</h3>

<form method="POST" action="{{ route('staff.inspeksi.simpan', $jadwal->id) }}" enctype="multipart/form-data">
@csrf


<div class="card mb-4 shadow-sm">
<div class="card-header fw-bold bg-warning">Data Mobil</div>
<div class="card-body row">

<div class="col-md-4 mb-3">
<label>Merk</label>
<input type="text" name="mobil[merk]" class="form-control"
value="{{ old('mobil.merk', $lastInspeksi->mobil->merk ?? $jadwal->merk) }}" required>
</div>

<div class="col-md-4 mb-3">
<label>Nama Mobil</label>
<input type="text" name="mobil[nama_mobil]" class="form-control"
value="{{ old('mobil.nama_mobil', $lastInspeksi->mobil->nama_mobil ?? $jadwal->model_mobil) }}" required>
</div>

<div class="col-md-4 mb-3">
<label>Tipe</label>
<input type="text" name="mobil[tipe]" class="form-control"
value="{{ old('mobil.tipe', $lastInspeksi->mobil->tipe ?? '') }}" required>
</div>

<div class="col-md-3 mb-3">
<label>Tahun</label>
<input type="number" name="mobil[tahun]" class="form-control"
value="{{ old('mobil.tahun', $lastInspeksi->mobil->tahun ?? $jadwal->tahun) }}" required>
</div>

<div class="col-md-3 mb-3">
<label>Kilometer</label>
<input type="number" name="mobil[kilometer]" class="form-control"
value="{{ old('mobil.kilometer', $lastInspeksi->mobil->kilometer ?? $jadwal->kilometer ?? '') }}" required>
</div>

<div class="col-md-3 mb-3">
<label>Warna</label>
<input type="text" name="mobil[warna]" class="form-control"
value="{{ old('mobil.warna', $lastInspeksi->mobil->warna ?? '') }}" required>
</div>

<div class="col-md-3 mb-3">
<label>Kapasitas Kursi</label>
<input type="number" name="mobil[kapasitas_kursi]" class="form-control"
value="{{ old('mobil.kapasitas_kursi', $lastInspeksi->mobil->kapasitas_kursi ?? '') }}" required>
</div>

<div class="col-md-3 mb-3">
<label>Kapasitas Mesin</label>
<input type="number" name="mobil[kapasitas_mesin]" class="form-control"
value="{{ old('mobil.kapasitas_mesin', $lastInspeksi->mobil->kapasitas_mesin ?? '') }}" required>
</div>
<div class="col-md-3 mb-3">
<label>Transmisi</label>
<select name="mobil[transmisi]" class="form-control" required>
    <option value="">-- Pilih Transmisi --</option>

    <option value="Automatic"
        {{ old('mobil.transmisi',
            $lastInspeksi->mobil->transmisi
            ?? $jadwal->transmisi
            ?? '') == 'Automatic' ? 'selected' : '' }}>
        Automatic
    </option>

    <option value="Manual"
        {{ old('mobil.transmisi',
            $lastInspeksi->mobil->transmisi
            ?? $jadwal->transmisi
            ?? '') == 'Manual' ? 'selected' : '' }}>
        Manual
    </option>
</select>
</div>

<div class="col-md-3 mb-3">
<label>Tipe Mesin</label>
<select name="mobil[tipe_mesin]" class="form-control" required>
    <option value="">-- Pilih Tipe Mesin --</option>

    <option value="Hybrid"
        {{ old('mobil.tipe_mesin',
            $lastInspeksi->mobil->tipe_mesin
            ?? $jadwal->tipe_mesin
            ?? '') == 'Hybrid' ? 'selected' : '' }}>
        Hybrid
    </option>

    <option value="Electric"
        {{ old('mobil.tipe_mesin',
            $lastInspeksi->mobil->tipe_mesin
            ?? $jadwal->tipe_mesin
            ?? '') == 'Electric' ? 'selected' : '' }}>
        Electric
    </option>

    <option value="Bensin"
        {{ old('mobil.tipe_mesin',
            $lastInspeksi->mobil->tipe_mesin
            ?? $jadwal->tipe_mesin
            ?? '') == 'Bensin' ? 'selected' : '' }}>
        Bensin
    </option>

    <option value="Diesel"
        {{ old('mobil.tipe_mesin',
            $lastInspeksi->mobil->tipe_mesin
            ?? $jadwal->tipe_mesin
            ?? '') == 'Diesel' ? 'selected' : '' }}>
        Diesel
    </option>
</select>
</div>

<div class="col-md-12 mb-3">
<label>Alamat</label>
<input type="text" name="mobil[alamat]" class="form-control"
value="{{ old('mobil.alamat', $lastInspeksi->mobil->alamat ?? $jadwal->alamat) }}" required>
</div>

<div class="col-md-6 mb-3">
<label>Kecamatan</label>
<input type="text" name="mobil[kecamatan]" class="form-control"
value="{{ old('mobil.kecamatan', $lastInspeksi->mobil->kecamatan ?? $jadwal->kecamatan) }}" required>
</div>

</div>
</div>


        @php
        $fotoMobil = ['foto_thumbnail','foto_depan','foto_kanan','foto_belakang','foto_kiri','foto_dashboard','foto_kursi_depan','foto_kursi_belakang','foto_bagasi_belakang'];
        @endphp

        <div class="card mb-4">
        <div class="card-header fw-bold">Foto Mobil</div>
        <div class="card-body row">
        @foreach ($fotoMobil as $foto)
        <div class="col-md-4 mb-3">
        <label>{{ str_replace('_',' ', $foto) }}</label>
        <input type="file" name="mobil[{{ $foto }}]" class="form-control" required>
        </div>
        @endforeach
        </div>
        </div>


        <div class="card mb-4">
        <div class="card-header fw-bold bg-info text-white">Fitur Mobil</div>
        <div class="card-body row">

        @php
        $fiturMobil = ['abs','ebd','ba','esc','tcs','hsa','hdc','vsc','ebs','isofix','immobilizer','alarm','bsm','rcta','ldw','lka','fcw','aeb','acc','tpms','camera_360','rear_view_camera'];
        @endphp
@foreach ($fiturMobil as $fitur)
<div class="col-md-4 mb-3">
<label>{{ str_replace('_',' ', $fitur) }}</label><br>

<input type="radio"
name="fitur[{{ $fitur }}]"
value="1"
{{ isset($lastInspeksi?->fiturMobil?->$fitur) && $lastInspeksi->fiturMobil->$fitur == 1 ? 'checked' : '' }}
required> Ada

<input type="radio"
name="fitur[{{ $fitur }}]"
value="0"
{{ isset($lastInspeksi?->fiturMobil?->$fitur) && $lastInspeksi->fiturMobil->$fitur == 0 ? 'checked' : '' }}>
Tidak
</div>
@endforeach
<div class="col-12 mt-4">

    <label class="fw-bold">
        Catatan Fitur Mobil
    </label>

    <textarea
        name="fitur[note]"
        class="form-control"
        rows="3"
        placeholder="Masukkan catatan fitur mobil">{{ old('fitur.note', $lastInspeksi?->fiturMobil?->note) }}</textarea>

</div>
        </div>
        </div>


        @php
        $eksterior = [
        'kondisi_cat'=>['A'=>'Cat mulus','B'=>'Baret halus','C'=>'Baret dalam','D'=>'Cat ulang'],
        'panel_bodi'=>['A'=>'Normal','B'=>'Penyok kecil','C'=>'Banyak','D'=>'Tidak sejajar'],
        'lampu_depan'=>['A'=>'Terang','B'=>'Kusam','C'=>'Retak','D'=>'Mati'],
        'lampu_belakang'=>['A'=>'Terang','B'=>'Kusam','C'=>'Retak','D'=>'Mati'],
        'velg'=>['A'=>'Normal','B'=>'Ringan','C'=>'Parah','D'=>'Peyang'],
        'ban'=>['A'=>'Baru','B'=>'75%','C'=>'50%','D'=>'Gundul'],
        'kaca'=>['A'=>'Utuh','B'=>'Jamur','C'=>'Retak','D'=>'Pecah'],
        'wiper'=>['A'=>'Normal','B'=>'Aus','C'=>'Seret','D'=>'Mati'],
        ];
        @endphp

        <div class="card mb-4">
        <div class="card-header fw-bold">Inspeksi Eksterior</div>
        <div class="card-body">

        @foreach ($eksterior as $item => $g)
        <div class="row mb-3 border-bottom pb-2">

        <div class="col-md-3">{{ str_replace('_',' ', $item) }}</div>

        <div class="col-md-4">

        <input type="radio"
name="eksterior[{{ $item }}]"
value="A"
{{ isset($lastInspeksi?->eksterior?->$item) && $lastInspeksi->eksterior->$item == 'A' ? 'checked' : '' }}
required> A

<input type="radio"
name="eksterior[{{ $item }}]"
value="B"
{{ isset($lastInspeksi?->eksterior?->$item) && $lastInspeksi->eksterior->$item == 'B' ? 'checked' : '' }}> B

<input type="radio"
name="eksterior[{{ $item }}]"
value="C"
{{ isset($lastInspeksi?->eksterior?->$item) && $lastInspeksi->eksterior->$item == 'C' ? 'checked' : '' }}> C

<input type="radio"
name="eksterior[{{ $item }}]"
value="D"
{{ isset($lastInspeksi?->eksterior?->$item) && $lastInspeksi->eksterior->$item == 'D' ? 'checked' : '' }}> D
        <input type="file" name="eksterior[foto_{{ $item }}]" class="form-control mt-2">
        <textarea name="eksterior[note_{{ $item }}]" class="form-control mt-2"></textarea>
        </div>

        <div class="col-md-5 small">
        A: {{ $g['A'] }}<br>
        B: {{ $g['B'] }}<br>
        C: {{ $g['C'] }}<br>
        D: {{ $g['D'] }}
        </div>

        </div>
        @endforeach

        </div>
        </div>

        @php
        $interior = [
        'kebersihan_kabin'=>['A'=>'Sangat bersih','B'=>'Debu','C'=>'Kotor','D'=>'Bau'],
        'kondisi_jok'=>['A'=>'Normal','B'=>'Noda','C'=>'Sobek kecil','D'=>'Parah'],
        'dashboard'=>['A'=>'Normal','B'=>'Kurang','C'=>'Retak','D'=>'Rusak'],
        'audio'=>['A'=>'Normal','B'=>'Error','C'=>'Rusak','D'=>'Mati'],
        'ac'=>['A'=>'Dingin','B'=>'Lambat','C'=>'Kurang','D'=>'Tidak'],
        'speedometer'=>['A'=>'Normal','B'=>'Kurang','C'=>'Error','D'=>'Mati'],
        'karpet'=>['A'=>'Bersih','B'=>'Noda','C'=>'Besar','D'=>'Sobek'],
        'power_window'=>['A'=>'Normal','B'=>'1 mati','C'=>'2-3','D'=>'Rusak'],
        'sunroof'=>['A'=>'Lancar','B'=>'Lambat','C'=>'Macet','D'=>'Mati'],
        'sabuk_pengaman'=>['A'=>'Normal','B'=>'Longgar','C'=>'Tidak balik','D'=>'Rusak'],
        'setir_transmisi'=>['A'=>'Kokoh','B'=>'Aus','C'=>'Longgar','D'=>'Rusak'],
        ];
        @endphp

        <div class="card mb-4">
        <div class="card-header fw-bold">Inspeksi Interior</div>
        <div class="card-body">

        @foreach ($interior as $item => $g)
        <div class="row mb-3 border-bottom pb-2">

        <div class="col-md-3">{{ str_replace('_',' ', $item) }}</div>

        <div class="col-md-4">
        <input type="radio"
name="interior[{{ $item }}]"
value="A"
{{ isset($lastInspeksi?->interior?->$item) && $lastInspeksi->interior->$item == 'A' ? 'checked' : '' }}
required> A

<input type="radio"
name="interior[{{ $item }}]"
value="B"
{{ isset($lastInspeksi?->interior?->$item) && $lastInspeksi->interior->$item == 'B' ? 'checked' : '' }}> B

<input type="radio"
name="interior[{{ $item }}]"
value="C"
{{ isset($lastInspeksi?->interior?->$item) && $lastInspeksi->interior->$item == 'C' ? 'checked' : '' }}> C

<input type="radio"
name="interior[{{ $item }}]"
value="D"
{{ isset($lastInspeksi?->interior?->$item) && $lastInspeksi->interior->$item == 'D' ? 'checked' : '' }}> D
        <input type="file" name="interior[foto_{{ $item }}]" class="form-control mt-2">
        <textarea name="interior[note_{{ $item }}]" class="form-control mt-2"></textarea>
        </div>

        <div class="col-md-5 small">
        A: {{ $g['A'] }}<br>
        B: {{ $g['B'] }}<br>
        C: {{ $g['C'] }}<br>
        D: {{ $g['D'] }}
        </div>

        </div>
        @endforeach

        </div>
        </div>

        @php
        $mesin = [
        'suara_mesin'=>['A'=>'Halus','B'=>'Agak','C'=>'Kasar','D'=>'Parah'],
        'getaran_mesin'=>['A'=>'Stabil','B'=>'Sedikit','C'=>'Getar','D'=>'Keras'],
        'kebocoran_oli'=>['A'=>'Tidak','B'=>'Rembes','C'=>'Tetes','D'=>'Bocor'],
        'asap_knalpot'=>['A'=>'Normal','B'=>'Tipis','C'=>'Hitam','D'=>'Biru'],
        'transmisi'=>['A'=>'Halus','B'=>'Hentakan','C'=>'Susah','D'=>'Rusak'],
        'rem'=>['A'=>'Normal','B'=>'Keras','C'=>'Dalam','D'=>'Blong'],
        'power_steering'=>['A'=>'Ringan','B'=>'Berat','C'=>'Sangat','D'=>'Mati'],
        'suspensi'=>['A'=>'Nyaman','B'=>'Bunyi','C'=>'Keras','D'=>'Tidak stabil'],
        'radiator'=>['A'=>'Normal','B'=>'Rembes','C'=>'Bocor','D'=>'Parah'],
        'aki'=>['A'=>'Normal','B'=>'Lemah','C'=>'Drop','D'=>'Mati'],
        'indikator_dashboard'=>['A'=>'Normal','B'=>'1-2','C'=>'Banyak','D'=>'Semua'],
        ];
        @endphp

        <div class="card mb-4">
        <div class="card-header fw-bold">Inspeksi Mesin</div>
        <div class="card-body">

        @foreach ($mesin as $item => $g)
        <div class="row mb-3 border-bottom pb-2">

        <div class="col-md-3">{{ str_replace('_',' ', $item) }}</div>

        <div class="col-md-4">
        <input type="radio"
name="mesin[{{ $item }}]"
value="A"
{{ isset($lastInspeksi?->mesin?->$item) && $lastInspeksi->mesin->$item == 'A' ? 'checked' : '' }}
required> A

<input type="radio"
name="mesin[{{ $item }}]"
value="B"
{{ isset($lastInspeksi?->mesin?->$item) && $lastInspeksi->mesin->$item == 'B' ? 'checked' : '' }}> B

<input type="radio"
name="mesin[{{ $item }}]"
value="C"
{{ isset($lastInspeksi?->mesin?->$item) && $lastInspeksi->mesin->$item == 'C' ? 'checked' : '' }}> C

<input type="radio"
name="mesin[{{ $item }}]"
value="D"
{{ isset($lastInspeksi?->mesin?->$item) && $lastInspeksi->mesin->$item == 'D' ? 'checked' : '' }}> D
        <input type="file" name="mesin[foto_{{ $item }}]" class="form-control mt-2">
        <textarea name="mesin[note_{{ $item }}]" class="form-control mt-2"></textarea>
        </div>

        <div class="col-md-5 small">
        A: {{ $g['A'] }}<br>
        B: {{ $g['B'] }}<br>
        C: {{ $g['C'] }}<br>
        D: {{ $g['D'] }}
        </div>

        </div>
        @endforeach

        </div>
        </div>

        @php
        $dokumen = [
        'stnk'=>['A'=>'Aktif','B'=>'<6 bulan','C'=>'>6 bulan','D'=>'Tidak ada'],
        'bpkb'=>['A'=>'Sesuai','B'=>'Belum balik','C'=>'Beda','D'=>'Tidak ada'],
        'faktur'=>['A'=>'Asli','B'=>'Lengkap','C'=>'Copy','D'=>'Tidak ada'],
        'surat_pelepasan'=>['A'=>'Notaris','B'=>'Ada','C'=>'Kurang','D'=>'Tidak ada'],
        'dokumen_tambahan'=>['A'=>'Lengkap','B'=>'Sebagian','C'=>'Copy','D'=>'Tidak ada'],
        ];
        @endphp

        <div class="card mb-4">
        <div class="card-header fw-bold">Dokumen</div>
        <div class="card-body">

        @foreach ($dokumen as $item => $g)
        <div class="row mb-3 border-bottom pb-2">

        <div class="col-md-3">{{ strtoupper(str_replace('_',' ', $item)) }}</div>

        <div class="col-md-4">
        <input type="radio"
name="kelengkapan[{{ $item }}]"
value="A"
{{ isset($lastInspeksi?->kelengkapan?->$item) && $lastInspeksi->kelengkapan->$item == 'A' ? 'checked' : '' }}
required> A

<input type="radio"
name="kelengkapan[{{ $item }}]"
value="B"
{{ isset($lastInspeksi?->kelengkapan?->$item) && $lastInspeksi->kelengkapan->$item == 'B' ? 'checked' : '' }}> B

<input type="radio"
name="kelengkapan[{{ $item }}]"
value="C"
{{ isset($lastInspeksi?->kelengkapan?->$item) && $lastInspeksi->kelengkapan->$item == 'C' ? 'checked' : '' }}> C

<input type="radio"
name="kelengkapan[{{ $item }}]"
value="D"
{{ isset($lastInspeksi?->kelengkapan?->$item) && $lastInspeksi->kelengkapan->$item == 'D' ? 'checked' : '' }}> D
        <input type="file" name="kelengkapan[foto_{{ $item }}]" class="form-control mt-2">
        <textarea name="kelengkapan[note_{{ $item }}]" class="form-control mt-2"></textarea>
        </div>

        <div class="col-md-5 small">
        A: {{ $g['A'] }}<br>
        B: {{ $g['B'] }}<br>
        C: {{ $g['C'] }}<br>
        D: {{ $g['D'] }}
        </div>

        </div>
        @endforeach

        </div>
        </div>

        <div class="d-grid">
        <button type="submit" class="btn btn-success btn-lg">
        Simpan Hasil Inspeksi
        </button>
        </div>

        </form>
        </div>

        </body>
        </html>