@php
use Illuminate\Support\Str;

function fotoUrl($path)
{
    if (empty($path)) {
        return asset('images/no-image.png');
    }

    return Str::startsWith($path, ['http://', 'https://'])
        ? $path
        : asset('storage/'.$path);
}
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <script src="https://app.sandbox.midtrans.com/snap/snap.js"
    data-client-key="{{ config('services.midtrans.client_key') }}">
    </script>
    <meta charset="UTF-8">
    <title>{{ $mobil->merk }} {{ $mobil->nama_mobil }}</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .main-wrapper {
            width: 100%;
        }

        .main-img {
            border-radius: 10px;
            cursor: pointer;
            width: 100%;
            height: 420px;
            object-fit: cover;
        }

  
        .thumb-container {
            margin-top: 10px;
            overflow-x: auto;
            white-space: nowrap;
            padding-bottom: 5px;
        }

     
        .thumb-container::-webkit-scrollbar {
            height: 6px;
        }

        .thumb-container::-webkit-scrollbar-thumb {
            background: #ccc;
            border-radius: 10px;
        }

        .thumb-img {
            width: 100px;
            height: 70px;
            object-fit: cover;
            cursor: pointer;
            border-radius: 6px;
            border: 2px solid transparent;
            display: inline-block;
            margin-right: 6px;
            opacity: 0.7;
        }

        .thumb-img.active,
        .thumb-img:hover {
            opacity: 1;
            border-color: #0d6efd;
        }

        .grade-box {
            border-top: 1px solid #ddd;
            border-bottom: 1px solid #ddd;
            padding: 15px 0;
        }
        .fitur-table th {
        background: #111827;
        color: white;
        vertical-align: middle;
        }

        .fitur-table td {
            vertical-align: middle;
        }

        .icon-check {
            color: #16a34a;
            font-size: 20px;
            font-weight: bold;
        }

        .icon-cross {
            color: #dc2626;
            font-size: 20px;
            font-weight: bold;
        }

        .fitur-card {
            border-radius: 14px;
            overflow: hidden;
            box-shadow: 0 4px 14px rgba(0,0,0,0.08);
            
        }
        
    </style>
</head>

<body class="bg-white">

@php
    use App\Models\Mobil;

    $jumlahMenunggu = 0;
    $jumlahTersedia = 0;

    if(auth()->check()){
        $jumlahMenunggu = Mobil::where('user_id', auth()->id())
            ->where('status', 'menunggu')
            ->count();

        $jumlahTersedia = Mobil::where('user_id', auth()->id())
            ->where('status', 'tersedia')
            ->count();
    }
@endphp

<nav class="navbar navbar-expand-lg navbar-dark bg-black px-4">

    <a class="navbar-brand d-flex align-items-center gap-2" href="/">
        <img src="{{ asset('images/logo.png') }}"
             alt="MasterCars"
             height="36">
    </a>

    <div class="ms-auto d-flex align-items-center gap-3">

        <a href="{{ route('user.profile') }}"
           class="nav-link text-white">
            Profil
        </a>

        @auth
            @if($jumlahMenunggu > 0)
                <a href="{{ route('user.inspeksi') }}"
                   class="nav-link text-white">
                    Inspeksi
                </a>
            @endif

            @if($jumlahTersedia > 0)
                <a href="{{ route('user.mobilSaya') }}"
                   class="nav-link text-white fw-bold">
                    Mobil Saya
                </a>
            @endif
        @endauth

        @php
        $punyaReinspeksi = DB::table('reinspeksi')
            ->where('user_id', auth()->id())
            ->exists();
        @endphp

        @if($punyaReinspeksi)
            <a href="{{ route('laporan.reinspeksi') }}"
               class="nav-link text-white">
                Laporan Inspeksi
            </a>
        @endif

        @auth
            <a href="{{ route('jual1') }}"
               class="nav-link text-white">
                Jual
            </a>
        @else
            <a href="{{ route('login') }}"
               class="nav-link text-white">
                Jual
            </a>
        @endauth

        @auth
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="btn btn-danger btn-sm">
                    Logout
                </button>
            </form>
        @else
            <a href="{{ route('login') }}"
               class="btn btn-light btn-sm">
                Login
            </a>
        @endauth

    </div>

</nav>

<div class="container my-5">

<div class="row g-5">

  
    <div class="col-md-7">

        @if(count($fotos))

        <div class="main-wrapper">

            <div id="mobilCarousel" class="carousel slide" data-bs-ride="false">
                <div class="carousel-inner">

                    @foreach($fotos as $index => $foto)
                        <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                            <img src="{{ fotoUrl($foto) }}"
                                class="d-block main-img"
                                data-bs-toggle="modal"
                                data-bs-target="#galleryModal">
                        </div>
                    @endforeach

                </div>

                <button class="carousel-control-prev" type="button" data-bs-target="#mobilCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                </button>

                <button class="carousel-control-next" type="button" data-bs-target="#mobilCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon"></span>
                </button>
            </div>

     
            <div class="thumb-container">
                @foreach($fotos as $index => $foto)
                    <img src="{{ fotoUrl($foto) }}"
                        class="thumb-img {{ $index === 0 ? 'active' : '' }}"
                        data-bs-target="#mobilCarousel"
                        data-bs-slide-to="{{ $index }}">
                @endforeach
            </div>

        </div>

        @else
            <div class="text-muted">Foto belum tersedia</div>
        @endif

    </div>

    <div class="col-md-5">

        <h2 class="fw-bold mb-2">
            {{ $mobil->merk }} {{ $mobil->nama_mobil }}
        </h2>

        <h4 class="text-primary fw-semibold mb-4">
            Rp {{ number_format($mobil->harga, 0, ',', '.') }}
        </h4>

        <div class="text-muted">
            <p>Tipe: {{ $mobil->tipe }}</p>
            <p>Kapasitas Mesin: {{ $mobil->kapasitas_mesin }} cc</p>
            <p>Tipe Mesin: {{ $mobil->tipe_mesin }}</p>
            <p>Transmisi: {{ $mobil->transmisi }}</p>
            <p>Warna: {{ $mobil->warna }}</p>
            <p>Kapasitas Kursi: {{ $mobil->kapasitas_kursi }}</p>
            <p>Kilometer: {{ $mobil->kilometer }}</p>
            <p>Tahun: {{ $mobil->tahun }}</p>
            
            <p>
                Terakhir Inspeksi: 
                {{ $mobil->inspeksi?->tanggal_inspeksi 
                    ? \Carbon\Carbon::parse($mobil->inspeksi->tanggal_inspeksi)->format('d M Y')
                    : '-' }}
            </p>
        </div>

    </div>

</div>

<div class="mt-4">

    @auth
        <button class="btn btn-dark w-100" data-bs-toggle="modal" data-bs-target="#bookingModal">
            Booking Sekarang
        </button>
    @else
        <a href="{{ route('login') }}" class="btn btn-dark w-100">
            Booking Sekarang
        </a>
    @endauth
    <div class="mt-3">
@auth
<button class="btn btn-warning w-100 mt-2" id="btnReinspeksi">
    Inspeksi Ulang (Rp 300.000)
</button>
@endauth
</div>

</div>
<div class="mt-5">
    <div class="fitur-card">


        <div class="table-responsive">

            @php
                $fitur = $mobil->fitur;

                $fiturList = [

                    'abs' => [
                        'nama' => 'ABS',
                        'kepanjangan' => 'Anti Lock Braking System',
                        'deskripsi' => 'Menjaga roda tidak terkunci saat pengereman mendadak.'
                    ],

                    'ebd' => [
                        'nama' => 'EBD',
                        'kepanjangan' => 'Electronic Brakeforce Distribution',
                        'deskripsi' => 'Membagi tekanan rem secara otomatis ke tiap roda.'
                    ],

                    'ba' => [
                        'nama' => 'BA',
                        'kepanjangan' => 'Brake Assist',
                        'deskripsi' => 'Membantu meningkatkan kekuatan pengereman saat darurat.'
                    ],

                    'esc' => [
                        'nama' => 'ESC',
                        'kepanjangan' => 'Electronic Stability Control',
                        'deskripsi' => 'Menjaga kestabilan mobil saat menikung atau licin.'
                    ],

                    'tcs' => [
                        'nama' => 'TCS',
                        'kepanjangan' => 'Traction Control System',
                        'deskripsi' => 'Mencegah roda selip saat akselerasi.'
                    ],

                    'hsa' => [
                        'nama' => 'HSA',
                        'kepanjangan' => 'Hill Start Assist',
                        'deskripsi' => 'Menahan mobil sesaat saat berhenti di tanjakan.'
                    ],

                    'hdc' => [
                        'nama' => 'HDC',
                        'kepanjangan' => 'Hill Descent Control',
                        'deskripsi' => 'Membantu menjaga kecepatan saat turunan curam.'
                    ],

                    'vsc' => [
                        'nama' => 'VSC',
                        'kepanjangan' => 'Vehicle Stability Control',
                        'deskripsi' => 'Menjaga kontrol kendaraan agar tidak oversteer.'
                    ],

                    'ebs' => [
                        'nama' => 'EBS',
                        'kepanjangan' => 'Electronic Braking System',
                        'deskripsi' => 'Sistem pengereman elektronik untuk pengereman lebih optimal.'
                    ],

                    'isofix' => [
                        'nama' => 'ISOFIX',
                        'kepanjangan' => 'ISOFIX',
                        'deskripsi' => 'Pengunci kursi bayi standar internasional.'
                    ],

                    'immobilizer' => [
                        'nama' => 'Immobilizer',
                        'kepanjangan' => 'Engine Immobilizer',
                        'deskripsi' => 'Mencegah mesin menyala tanpa kunci asli.'
                    ],

                    'alarm' => [
                        'nama' => 'Alarm',
                        'kepanjangan' => 'Security Alarm',
                        'deskripsi' => 'Memberi peringatan saat ada percobaan pencurian.'
                    ],

                    'bsm' => [
                        'nama' => 'BSM',
                        'kepanjangan' => 'Blind Spot Monitor',
                        'deskripsi' => 'Mendeteksi kendaraan di titik buta.'
                    ],

                    'rcta' => [
                        'nama' => 'RCTA',
                        'kepanjangan' => 'Rear Cross Traffic Alert',
                        'deskripsi' => 'Mendeteksi kendaraan saat mundur dari parkiran.'
                    ],

                    'ldw' => [
                        'nama' => 'LDW',
                        'kepanjangan' => 'Lane Departure Warning',
                        'deskripsi' => 'Memberi peringatan saat mobil keluar jalur.'
                    ],

                    'lka' => [
                        'nama' => 'LKA',
                        'kepanjangan' => 'Lane Keep Assist',
                        'deskripsi' => 'Membantu menjaga mobil tetap di jalur.'
                    ],

                    'fcw' => [
                        'nama' => 'FCW',
                        'kepanjangan' => 'Forward Collision Warning',
                        'deskripsi' => 'Memberi peringatan potensi tabrakan depan.'
                    ],

                    'aeb' => [
                        'nama' => 'AEB',
                        'kepanjangan' => 'Autonomous Emergency Braking',
                        'deskripsi' => 'Rem otomatis saat terdeteksi potensi tabrakan.'
                    ],

                    'acc' => [
                        'nama' => 'ACC',
                        'kepanjangan' => 'Adaptive Cruise Control',
                        'deskripsi' => 'Cruise control otomatis mengikuti kendaraan depan.'
                    ],

                    'tpms' => [
                        'nama' => 'TPMS',
                        'kepanjangan' => 'Tire Pressure Monitoring System',
                        'deskripsi' => 'Memantau tekanan ban secara otomatis.'
                    ],

                    'camera_360' => [
                        'nama' => '360 Camera',
                        'kepanjangan' => '360 Around View Camera',
                        'deskripsi' => 'Menampilkan kondisi sekitar mobil dari atas.'
                    ],

                    'rear_view_camera' => [
                        'nama' => 'Rear Camera',
                        'kepanjangan' => 'Rear View Camera',
                        'deskripsi' => 'Kamera belakang untuk membantu parkir.'
                    ],
                ];
            @endphp

            <table class="table table-bordered table-hover mb-0 fitur-table">

                <thead>
                    <tr class="text-center">
                        <th width="8%">Status</th>
                        <th width="18%">Fitur</th>
                        <th width="24%">Nama Lengkap</th>
                        <th>Penjelasan</th>
                    </tr>
                </thead>

                <tbody>

                    @foreach($fiturList as $field => $item)

                    <tr>

                        <td class="text-center">

                            @if($fitur && $fitur->$field)
                                <span class="icon-check">✔</span>
                            @else
                                <span class="icon-cross">✘</span>
                            @endif

                        </td>

                        <td class="fw-semibold">
                            {{ $item['nama'] }}
                        </td>

                        <td>
                            {{ $item['kepanjangan'] }}
                        </td>

                        <td class="text-muted small">
                            {{ $item['deskripsi'] }}
                        </td>

                    </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    </div>

</div>
<div class="mt-5">
    <h4 class="fw-bold mb-4 text-center">Detail Inspeksi Mobil</h4>

    <div class="accordion" id="accordionInspeksi">

     
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button collapsed"
                        data-bs-toggle="collapse"
                        data-bs-target="#eksterior">
                    Eksterior :
                    <span class="badge bg-primary ms-2">
                        {{ $mobil->inspeksi->grade_eksterior ?? '-' }}
                    </span>
                </button>
            </h2>

            <div id="eksterior" class="accordion-collapse collapse">
                <div class="accordion-body">

                    @php $e = $mobil->inspeksi->eksterior ?? null; @endphp

@foreach([
    'kondisi_cat' => 'Kondisi Cat',
    'panel_bodi' => 'Panel Bodi',
    'lampu_depan' => 'Lampu Depan',
    'lampu_belakang' => 'Lampu Belakang',
    'velg' => 'Velg',
    'ban' => 'Ban',
    'kaca' => 'Kaca',
    'wiper' => 'Wiper',
] as $field => $label)

<div class="border rounded p-3 mb-3">
    <div class="row align-items-center">

        <div class="col-md-4 text-center">
            @if(!empty($e->{'foto_'.$field}))
                <img src="{{ fotoUrl($e->{'foto_'.$field}) }}"
                     class="img-fluid rounded shadow-sm"
                     style="max-height:150px; cursor:pointer">
            @else
                <div class="text-muted small">Tidak ada foto</div>
            @endif
        </div>

        <div class="col-md-8">
            <div class="d-flex justify-content-between align-items-center">
                <strong>{{ $label }}</strong>
                <span class="badge bg-secondary">
                    {{ $e->$field ?? '-' }}
                </span>
            </div>

            @if(!empty($e->{'note_'.$field}))
                <p class="mt-2 mb-0 text-muted small">
                    {{ $e->{'note_'.$field} }}
                </p>
            @endif
        </div>

    </div>
</div>

@endforeach

                </div>
            </div>
        </div>

  
<div class="accordion-item">
    <h2 class="accordion-header">
        <button class="accordion-button collapsed"
                data-bs-toggle="collapse"
                data-bs-target="#interior">
            Interior :
            <span class="badge bg-primary ms-2">
                {{ $mobil->inspeksi->grade_interior ?? '-' }}
            </span>
        </button>
    </h2>

    <div id="interior" class="accordion-collapse collapse">
        <div class="accordion-body">

            @php $i = $mobil->inspeksi->interior ?? null; @endphp

            @if($i)
                @foreach([
                    'kebersihan_kabin' => 'Kebersihan Kabin',
                    'kondisi_jok' => 'Kondisi Jok',
                    'dashboard' => 'Dashboard',
                    'audio' => 'Audio',
                    'ac' => 'AC',
                    'speedometer' => 'Speedometer',
                    'karpet' => 'Karpet',
                    'power_window' => 'Power Window',
                    'sunroof' => 'Sunroof',
                    'sabuk_pengaman' => 'Sabuk Pengaman',
                    'setir_transmisi' => 'Setir Transmisi'
                ] as $field => $label)

                <div class="border rounded p-3 mb-3">
                    <div class="row align-items-center">

                        <div class="col-md-4 text-center">
                            @if(!empty($i->{'foto_'.$field}))
                                <img src="{{ fotoUrl($i->{'foto_'.$field}) }}"
                                     class="img-fluid rounded shadow-sm"
                                     style="max-height:150px; cursor:pointer">
                            @else
                                <div class="text-muted small">Tidak ada foto</div>
                            @endif
                        </div>

                        <div class="col-md-8">
                            <div class="d-flex justify-content-between align-items-center">
                                <strong>{{ $label }}</strong>
                                <span class="badge bg-secondary">
                                    {{ $i->$field ?? '-' }}
                                </span>
                            </div>

                            @if(!empty($i->{'note_'.$field}))
                                <p class="mt-2 mb-0 text-muted small">
                                    {{ $i->{'note_'.$field} }}
                                </p>
                            @endif
                        </div>

                    </div>
                </div>

                @endforeach
            @else
                <p class="text-muted">Data tidak tersedia</p>
            @endif

        </div>
    </div>
</div>

<div class="accordion-item">
    <h2 class="accordion-header">
        <button class="accordion-button collapsed"
                data-bs-toggle="collapse"
                data-bs-target="#mesin">
            Mesin :
            <span class="badge bg-primary ms-2">
                {{ $mobil->inspeksi->grade_mesin ?? '-' }}
            </span>
        </button>
    </h2>

    <div id="mesin" class="accordion-collapse collapse">
        <div class="accordion-body">

            @php $m = $mobil->inspeksi->mesin ?? null; @endphp

            @foreach([
                'suara_mesin' => 'Suara Mesin',
                'getaran_mesin' => 'Getaran Mesin',
                'kebocoran_oli' => 'Kebocoran Oli',
                'asap_knalpot' => 'Asap Knalpot',
                'transmisi' => 'Transmisi',
                'rem' => 'Rem',
                'power_steering' => 'Power Steering',
                'suspensi' => 'Suspensi',
                'radiator' => 'Radiator',
                'aki' => 'Aki',
                'indikator_dashboard' => 'Indikator Dashboard',

            ] as $field => $label)

            <div class="border rounded p-3 mb-3">
                <div class="row align-items-center">

                    <div class="col-md-4 text-center">
                        @if(!empty($m->{'foto_'.$field}))
                            <img src="{{ fotoUrl($m->{'foto_'.$field}) }}"
                                 class="img-fluid rounded shadow-sm"
                                 style="max-height:150px; cursor:pointer">
                        @else
                            <div class="text-muted small">Tidak ada foto</div>
                        @endif
                    </div>

                    <div class="col-md-8">
                        <div class="d-flex justify-content-between align-items-center">
                            <strong>{{ $label }}</strong>
                            <span class="badge bg-secondary">
                                {{ $m->$field ?? '-' }}
                            </span>
                        </div>

                        @if(!empty($m->{'note_'.$field}))
                            <p class="mt-2 mb-0 text-muted small">
                                {{ $m->{'note_'.$field} }}
                            </p>
                        @endif
                    </div>

                </div>
            </div>

            @endforeach

        </div>
    </div>
</div>


<div class="accordion-item">
    <h2 class="accordion-header">
        <button class="accordion-button collapsed"
                data-bs-toggle="collapse"
                data-bs-target="#kelengkapan">
            Kelengkapan :
            <span class="badge bg-primary ms-2">
                {{ $mobil->inspeksi->grade_kelengkapan ?? '-' }}
            </span>
        </button>
    </h2>

    <div id="kelengkapan" class="accordion-collapse collapse">
        <div class="accordion-body">

            @php $k = $mobil->inspeksi->kelengkapan ?? null; @endphp

            @foreach([
                'stnk' => 'STNK',
                'bpkb' => 'BPKB',
                'faktur' => 'Faktur',
                'surat_pelepasan' => 'Surat Pelepasan',
                'dokumen_tambahan' => 'Dokumen Tambahan'
            ] as $field => $label)

            <div class="border rounded p-3 mb-3">
                <div class="row align-items-center">

                    <div class="col-md-4 text-center">
                        @if(!empty($k->{'foto_'.$field}))
                            <img src="{{ fotoUrl($k->{'foto_'.$field}) }}"
                                 class="img-fluid rounded shadow-sm"
                                 style="max-height:150px; cursor:pointer">
                        @else
                            <div class="text-muted small">Tidak ada foto</div>
                        @endif
                    </div>

                    <div class="col-md-8">
                        <div class="d-flex justify-content-between align-items-center">
                            <strong>{{ $label }}</strong>
                            <span class="badge bg-secondary">
                                {{ $k->$field ?? '-' }}
                            </span>
                        </div>

                        @if(!empty($k->{'note_'.$field}))
                            <p class="mt-2 mb-0 text-muted small">
                                {{ $k->{'note_'.$field} }}
                            </p>
                        @endif
                    </div>

                </div>
            </div>

            @endforeach

        </div>
    </div>
</div>

<div class="modal fade" id="galleryModal" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content bg-black">
            <div class="modal-body p-0">

                <div id="modalCarousel" class="carousel slide" data-bs-ride="false">
                    <div class="carousel-inner">

                        @foreach($fotos as $index => $foto)
                            <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                <img src="{{ fotoUrl($foto) }}" class="d-block w-100 img-fluid">
                            </div>
                        @endforeach

                    </div>

                    <button class="carousel-control-prev" type="button" data-bs-target="#modalCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon"></span>
                    </button>

                    <button class="carousel-control-next" type="button" data-bs-target="#modalCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon"></span>
                    </button>
                </div>

            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
@auth
<div class="modal fade" id="bookingModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <form action="{{ route('booking.store', $mobil->id) }}" method="POST">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title">Booking Mobil</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <div class="mb-3">
                        <label>Nomor Kontak</label>
                        <input type="text" name="nomor_kontak"
                               class="form-control"
                               value="{{ auth()->user()->no_hp }}">
                    </div>

                    <div class="mb-3">
                        <label>Alamat</label>
                        <input type="text" name="alamat"
                               class="form-control"
                               value="{{ auth()->user()->alamat }}">
                    </div>

                    <div class="mb-3">
                        <label>Kecamatan</label>
                        <input type="text" name="kecamatan"
                               class="form-control"
                               value="{{ auth()->user()->kecamatan }}">
                    </div>

                    <div class="mb-3">
                        <label>Tanggal</label>
                        <input type="date"
                               name="jadwal"
                               id="tanggalBooking"
                               class="form-control"
                               min="{{ now()->addDay()->format('Y-m-d') }}"
                               max="{{ now()->addDays(7)->format('Y-m-d') }}">
                    </div>

                    <div class="mb-3">
                        <label>Jam</label>
                        <select name="jam" id="jamBooking" class="form-control">
                            <option>Pilih tanggal dahulu</option>
                        </select>
                    </div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-dark w-100">Booking</button>
                </div>

            </form>

        </div>
    </div>
</div>
@endauth
<script>
document.getElementById('tanggalBooking')?.addEventListener('change', function(){

    let tanggal = this.value;

    fetch('/cek-slot/' + tanggal)
    .then(res => res.json())
    .then(data => {

        let jam = document.getElementById('jamBooking');
        jam.innerHTML = '';

        if(data.length === 0){
            jam.innerHTML = '<option>Jadwal penuh</option>';
            return;
        }

        data.forEach(function(j){
            let opt = document.createElement('option');
            opt.value = j;
            opt.text = j;
            jam.appendChild(opt);
        });

    });

});
</script>
@if(session('snapToken'))
<script>
    snap.pay('{{ session('snapToken') }}', {
        onSuccess: function(result){
            window.location.href = "/booking/finish?order_id=" + result.order_id;
        },
        onPending: function(result){
            window.location.href = "/booking/finish?order_id=" + result.order_id;
        },
        onError: function(result){
            window.location.href = "/booking/failed";
        },
        onClose: function(){
            window.location.href = "/booking/failed";
        }
    });
</script>
@endif
<script>
document.getElementById('btnReinspeksi')?.addEventListener('click', function(){

    fetch("/reinspeksi/bayar/{{ $mobil->id }}")
    .then(res => res.json())
    .then(data => {
        snap.pay(data.snapToken, {
            onSuccess: function(result){
                window.location.href = "/reinspeksi/finish?order_id=" + result.order_id;
            },
            onPending: function(result){
                window.location.href = "/reinspeksi/finish?order_id=" + result.order_id;
            },
            onError: function(){
                alert("Pembayaran gagal");
            }
        });
    });

});
</script>

</body>
</html>