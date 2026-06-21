@php
use Illuminate\Support\Str;

function fotoUrl($path)
{
    if (!$path) {
        return asset('images/no-image.png');
    }

    if (Str::startsWith($path, ['http://', 'https://'])) {
        return $path;
    }

    return asset('storage/'.$path);
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
@php
$approvalCount = DB::table('jadwal_inspeksi')
    ->where('user_id', auth()->id())
    ->where(function($q){
        $q->whereNull('status_approval')
          ->orWhere('status_approval', 0);
    })
    ->exists();
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
            @if($approvalCount)
                <a href="{{ route('user.approval') }}"
                class="nav-link text-white">
                    Approval
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
@php
function score($value)
{
    if($value === null) return 0;

    return match($value) {
        'A', 'Baik', 'Normal', 'Ada', 'Lengkap' => 1,
        'B' => 0.75,
        'C' => 0.5,
        'D' => 0.25,
        default => 0
    };
}
@endphp
@php
function nilaiItem($value)
{
    if ($value === null) return 0;

    return match($value) {
        'A', 'Baik', 'Normal', 'Ada', 'Lengkap' => 1,
        'B' => 0.75,
        'C' => 0.5,
        'D' => 0.25,
        default => 0
    };
}
@endphp
@php
$bobotEksterior = [
    'kondisi_cat' => 10,
    'panel_bodi' => 10,
    'lampu_depan' => 8,
    'lampu_belakang' => 8,
    'velg' => 7,
    'ban' => 10,
    'kaca' => 7,
    'wiper' => 3, 
];

$bobotInterior = [
    'kebersihan_kabin' => 6,
    'kondisi_jok' => 8,
    'dashboard' => 6,
    'audio' => 4,
    'ac' => 10,
    'speedometer' => 6,
    'karpet' => 3,
    'power_window' => 5,
    'sunroof' => 6,
    'sabuk_pengaman' => 10,
    'setir_transmisi' => 6,
];

$bobotMesin = [
    'suara_mesin' => 12,
    'getaran_mesin' => 10,
    'kebocoran_oli' => 12,
    'asap_knalpot' => 10,
    'transmisi' => 12,
    'rem' => 12,
    'power_steering' => 6,
    'suspensi' => 8,
    'radiator' => 8,
    'aki' => 5,
    'indikator_dashboard' => 5,
];

$bobotKelengkapan = [
    'stnk' => 15,
    'bpkb' => 15,
    'faktur' => 10,
    'surat_pelepasan' => 5,
    'dokumen_tambahan' => 5,
];
@endphp
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

            @php
                $e = $mobil->inspeksi->eksterior ?? null;
                $total = 0;
                $max = array_sum($bobotEksterior);
            @endphp

            @foreach($bobotEksterior as $field => $bobot)
                @php
                    $nilai = $e ? nilaiInspeksi($e->$field ?? null) : 0;
                    $score = $nilai * $bobot;
                    $total += $score;
                @endphp

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
                            <div class="d-flex justify-content-between">
                                <strong>{{ ucfirst(str_replace('_',' ',$field)) }}</strong>

                                <span class="badge bg-secondary">
                                    {{ $e->$field ?? '-' }}
                                </span>
                            </div>

                            <small class="text-muted">
                                Bobot: {{ $bobot }} | Score: {{ number_format($score,1) }}
                            </small>
                        </div>

                    </div>
                </div>
            @endforeach

            <hr>
            <div class="fw-bold">
                Nilai Eksterior: {{ round(($total / $max) * 100, 2) }} / 100
            </div>

        </div>
    </div>
</div>

  
@php
$i = $mobil->inspeksi->interior ?? null;
$total = 0;
$max = array_sum($bobotInterior);
@endphp

@foreach($bobotInterior as $field => $bobot)
    @php
        $nilai = $i ? nilaiInspeksi($i->$field ?? null) : 0;
        $score = $nilai * $bobot;
        $total += $score;
    @endphp

    <div class="border rounded p-3 mb-3">
        <div class="d-flex justify-content-between">
            <strong>{{ ucfirst(str_replace('_',' ',$field)) }}</strong>
            <span class="badge bg-secondary">
                {{ $i->$field ?? '-' }}
            </span>
        </div>

        <small class="text-muted">
            Bobot: {{ $bobot }} | Score: {{ number_format($score,1) }}
        </small>
    </div>
@endforeach

<hr>
<div class="fw-bold">
    Nilai Interior: {{ round(($total / $max) * 100, 2) }} / 100
</div>

@php
$m = $mobil->inspeksi->mesin ?? null;
$total = 0;
$max = array_sum($bobotMesin);
@endphp

@foreach($bobotMesin as $field => $bobot)
    @php
        $nilai = $m ? nilaiInspeksi($m->$field ?? null) : 0;
        $score = $nilai * $bobot;
        $total += $score;
    @endphp

    <div class="border rounded p-3 mb-3">
        <div class="d-flex justify-content-between">
            <strong>{{ ucfirst(str_replace('_',' ',$field)) }}</strong>
            <span class="badge bg-secondary">
                {{ $m->$field ?? '-' }}
            </span>
        </div>

        <small class="text-muted">
            Bobot: {{ $bobot }} | Score: {{ number_format($score,1) }}
        </small>
    </div>
@endforeach

<hr>
<div class="fw-bold">
    Nilai Mesin: {{ round(($total / $max) * 100, 2) }} / 100
</div>


@php
$k = $mobil->inspeksi->kelengkapan ?? null;
$total = 0;
$max = array_sum($bobotKelengkapan);
@endphp

@foreach($bobotKelengkapan as $field => $bobot)
    @php
        $nilai = $k ? nilaiInspeksi($k->$field ?? null) : 0;
        $score = $nilai * $bobot;
        $total += $score;
    @endphp

    <div class="border rounded p-3 mb-3">
        <div class="d-flex justify-content-between">
            <strong>{{ ucfirst($field) }}</strong>
            <span class="badge bg-secondary">
                {{ $k->$field ?? '-' }}
            </span>
        </div>

        <small class="text-muted">
            Bobot: {{ $bobot }} | Score: {{ number_format($score,1) }}
        </small>
    </div>
@endforeach

<hr>
<div class="fw-bold">
    Nilai Kelengkapan: {{ round(($total / $max) * 100, 2) }} / 100
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
            alert('Menunggu pembayaran');
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