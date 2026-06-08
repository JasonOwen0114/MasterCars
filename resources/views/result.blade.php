<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Compare Mobil</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
    
.car-img {
    width:100%;
    height:200px;
    object-fit:cover;
    border-radius:10px;
}
.photo-box {
    height: 120px; 
    display: flex;
    align-items: center;
    justify-content: center;
    background: #f8f9fa;
    border-radius: 8px;
}

.photo-box img {
    max-height: 100%;
    max-width: 100%;
    object-fit: cover;
    border-radius: 6px;
}

.thumb-item {
    width:100%;
    max-height:140px;
    object-fit:cover;
    border-radius:8px;
    cursor:pointer;
}

.viewer-img {
    width:100%;
    max-height:80vh;
    object-fit:contain;
    background:#000;
}

.main-img {
    height:320px;
    width:100%;
    object-fit:contain;
    background:#f8f9fa;
}

.thumb-container {
    display:flex;
    overflow-x:auto;
    gap:8px;
    padding-bottom:5px;
}

.thumb-img {
    width:90px;
    height:60px;
    object-fit:cover;
    border-radius:6px;
    cursor:pointer;
    opacity:.7;
    border:2px solid transparent;
    flex:0 0 auto;
}

.thumb-img:hover {
    opacity:1;
    border-color:#0d6efd;
}
</style>
</head>

<body class="bg-light">

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
                   class="nav-link text-white">
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

<div class="container py-4">
    <h3 class="fw-bold text-center mb-4">Perbandingan Mobil</h3>

    <div class="row g-4">

@foreach($mobils as $mobil)

@php
$fotos = collect([
    $mobil->foto_thumbnail,
    $mobil->foto_depan,
    $mobil->foto_kanan,
    $mobil->foto_belakang,
    $mobil->foto_kiri,
    $mobil->foto_dashboard,
    $mobil->foto_kursi_depan,
    $mobil->foto_kursi_belakang,
    $mobil->foto_bagasi_belakang,
])->filter()->values();
@endphp

<div class="col-md-6">
<div class="card shadow-sm">

    <div class="p-2">
        @if(count($fotos))
        <div id="mobilCarousel{{$mobil->id}}" class="carousel slide" data-bs-ride="false">
            <div class="carousel-inner">
                @foreach($fotos as $index => $foto)
                <div class="carousel-item {{ $index==0 ? 'active' : '' }}">
                    <img src="{{ fotoUrl($foto) }}"
                         class="d-block main-img"
                         onclick="openSingleImage('{{ fotoUrl($foto) }}')">
                </div>
                @endforeach
            </div>

            <button class="carousel-control-prev" type="button"
                    data-bs-target="#mobilCarousel{{$mobil->id}}" data-bs-slide="prev">
                <span class="carousel-control-prev-icon"></span>
            </button>

            <button class="carousel-control-next" type="button"
                    data-bs-target="#mobilCarousel{{$mobil->id}}" data-bs-slide="next">
                <span class="carousel-control-next-icon"></span>
            </button>
        </div>

        <div class="thumb-container mt-2">
            @foreach($fotos as $index => $foto)
            <img src="{{ fotoUrl($foto) }}"
                 class="thumb-img"
                 data-bs-target="#mobilCarousel{{$mobil->id}}"
                 data-bs-slide-to="{{ $index }}">
            @endforeach
        </div>
        @else
            <div class="text-muted">Foto belum tersedia</div>
        @endif
    </div>

    <div class="card-body">
        <h5 class="fw-bold">{{ $mobil->merk }} {{ $mobil->nama_mobil }}</h5>
        <p class="text-muted">{{ $mobil->tipe }} • {{ $mobil->tahun }}</p>

        <h6 class="text-primary fw-bold">
            Rp {{ number_format($mobil->harga,0,',','.') }}
        </h6>

        <span class="badge bg-dark">
            Overall: {{ $mobil->inspeksi->grade_keseluruhan ?? '-' }}
        </span>

        <div class="accordion mt-3" id="acc{{$mobil->id}}">

            
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed"
                            data-bs-toggle="collapse"
                            data-bs-target="#ek{{$mobil->id}}">
                        Eksterior ({{ $mobil->inspeksi->grade_eksterior ?? '-' }})
                    </button>
                </h2>

                <div id="ek{{$mobil->id}}" class="accordion-collapse collapse">
                    <div class="accordion-body">
                        @php $e = $mobil->inspeksi->eksterior ?? null; @endphp

                        @if($e)
                        @foreach([
                            'kondisi_cat'=>'Kondisi Cat',
                            'panel_bodi'=>'Panel Bodi',
                            'lampu_depan'=>'Lampu Depan',
                            'lampu_belakang'=>'Lampu Belakang',
                            'velg'=>'Velg',
                            'ban'=>'Ban',
                            'kaca'=>'Kaca',
                            'wiper'=>'Wiper'
                        ] as $field => $label)

                        <div class="border rounded p-2 mb-2">
                            <div class="row align-items-center">

                                <div class="col-md-4">
                                <div class="photo-box">
                                    @if(!empty($e->{'foto_'.$field}))
                                    <img src="{{ fotoUrl($e->{'foto_'.$field}) }}"
                                        onclick="openSingleImage('{{ fotoUrl($e->{'foto_'.$field}) }}')">
                                    @else
                                    <small class="text-muted">Tidak ada foto</small>
                                    @endif
                                </div>
                            </div>
                                                            <div class="col-md-8">
                                    <strong>{{ $label }}</strong><br>
                                    <span class="badge bg-secondary">
                                        {{ $e->$field ?? '-' }}
                                    </span>

                                    @if(!empty($e->{'note_'.$field}))
                                    <p class="small text-muted mb-0">
                                        {{ $e->{'note_'.$field} }}
                                    </p>
                                    @endif
                                </div>

                            </div>
                        </div>

                        @endforeach
                        @endif
                    </div>
                </div>
            </div>

            
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed"
                            data-bs-toggle="collapse"
                            data-bs-target="#in{{$mobil->id}}">
                        Interior ({{ $mobil->inspeksi->grade_interior ?? '-' }})
                    </button>
                </h2>

                <div id="in{{$mobil->id}}" class="accordion-collapse collapse">
                    <div class="accordion-body">
                        @php $i = $mobil->inspeksi->interior ?? null; @endphp

                        @if($i)
                        @foreach([
                            'kebersihan_kabin'=>'Kebersihan Kabin',
                            'kondisi_jok'=>'Kondisi Jok',
                            'dashboard'=>'Dashboard',
                            'audio'=>'Audio',
                            'ac'=>'AC'
                        ] as $field => $label)

                        <div class="border rounded p-2 mb-2">
                            <div class="row align-items-center">

                                <div class="col-md-4">
                                    <div class="photo-box">
                                        @if(!empty($i->{'foto_'.$field}))
                                        <img src="{{ fotoUrl($i->{'foto_'.$field}) }}"
                                            onclick="openSingleImage('{{ fotoUrl($i->{'foto_'.$field}) }}')">
                                        @else
                                        <small class="text-muted">Tidak ada foto</small>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-md-8">
                                    <strong>{{ $label }}</strong><br>
                                    <span class="badge bg-secondary">
                                        {{ $i->$field ?? '-' }}
                                    </span>

                                    @if(!empty($i->{'note_'.$field}))
                                    <p class="small text-muted mb-0">
                                        {{ $i->{'note_'.$field} }}
                                    </p>
                                    @endif
                                </div>

                            </div>
                        </div>

                        @endforeach
                        @endif
                    </div>
                </div>
            </div>

           
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed"
                            data-bs-toggle="collapse"
                            data-bs-target="#me{{$mobil->id}}">
                        Mesin ({{ $mobil->inspeksi->grade_mesin ?? '-' }})
                    </button>
                </h2>

                <div id="me{{$mobil->id}}" class="accordion-collapse collapse">
                    <div class="accordion-body">
                        @php $m = $mobil->inspeksi->mesin ?? null; @endphp

                        @if($m)
                        @foreach([
                            'suara_mesin'=>'Suara Mesin',
                            'getaran_mesin'=>'Getaran Mesin',
                            'kebocoran_oli'=>'Kebocoran Oli',
                            'asap_knalpot'=>'Asap Knalpot'
                        ] as $field => $label)

                        <div class="border rounded p-2 mb-2">
                            <div class="row align-items-center">

                                <div class="col-md-4">
                                    <div class="photo-box">
                                        @if(!empty($m->{'foto_'.$field}))
                                        <img src="{{ fotoUrl($m->{'foto_'.$field}) }}"
                                            onclick="openSingleImage('{{ fotoUrl($m->{'foto_'.$field}) }}')">
                                        @else
                                        <small class="text-muted">Tidak ada foto</small>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-md-8">
                                    <strong>{{ $label }}</strong><br>
                                    <span class="badge bg-secondary">
                                        {{ $m->$field ?? '-' }}
                                    </span>

                                    @if(!empty($m->{'note_'.$field}))
                                    <p class="small text-muted mb-0">
                                        {{ $m->{'note_'.$field} }}
                                    </p>
                                    @endif
                                </div>

                            </div>
                        </div>

                        @endforeach
                        @endif
                    </div>
                </div>
            </div>

          
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed"
                            data-bs-toggle="collapse"
                            data-bs-target="#ke{{$mobil->id}}">
                        Kelengkapan ({{ $mobil->inspeksi->grade_kelengkapan ?? '-' }})
                    </button>
                </h2>

                <div id="ke{{$mobil->id}}" class="accordion-collapse collapse">
                    <div class="accordion-body">
                        @php $k = $mobil->inspeksi->kelengkapan ?? null; @endphp

                        @if($k)
                        @foreach([
                            'stnk'=>'STNK',
                            'bpkb'=>'BPKB',
                            'faktur'=>'Faktur',
                            'surat_pelepasan'=>'Surat Pelepasan',
                            'dokumen_tambahan'=>'Dokumen Tambahan'
                        ] as $field => $label)

                        <div class="border rounded p-2 mb-2">
                            <div class="row align-items-center">
                                <div class="col-md-4">
                                    <div class="photo-box">
                                        @if(!empty($k->{'foto_'.$field}))
                                        <img src="{{ fotoUrl($k->{'foto_'.$field}) }}"
                                            onclick="openSingleImage('{{ fotoUrl($k->{'foto_'.$field}) }}')">
                                        @else
                                        <small class="text-muted">Tidak ada foto</small>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-md-8">
                                    <strong>{{ $label }}</strong><br>
                                    <span class="badge bg-secondary">
                                        {{ $k->$field ?? '-' }}
                                    </span>

                                    @if(!empty($k->{'note_'.$field}))
                                    <p class="small text-muted mb-0">
                                        {{ $k->{'note_'.$field} }}
                                    </p>
                                    @endif
                                </div>

                            </div>
                        </div>

                        @endforeach
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>
</div>

@endforeach
@if(count($mobils) == 2)

@php

$fiturList = [

    'abs' => 'ABS',
    'ebd' => 'EBD',
    'ba' => 'Brake Assist',
    'esc' => 'ESC',
    'tcs' => 'TCS',
    'hsa' => 'HSA',
    'hdc' => 'HDC',
    'vsc' => 'VSC',
    'ebs' => 'EBS',
    'isofix' => 'ISOFIX',
    'immobilizer' => 'Immobilizer',
    'alarm' => 'Alarm',
    'bsm' => 'BSM',
    'rcta' => 'RCTA',
    'ldw' => 'LDW',
    'lka' => 'LKA',
    'fcw' => 'FCW',
    'aeb' => 'AEB',
    'acc' => 'Adaptive Cruise Control',
    'tpms' => 'TPMS',
    'camera_360' => '360 Camera',
    'rear_view_camera' => 'Rear Camera',

];

$mobil1 = $mobils[0];
$mobil2 = $mobils[1];

@endphp

<div class="card mt-4">

    </div>

    <div class="card-body">

        <div class="table-responsive">

            <table class="table table-bordered align-middle">

                <thead class="table-light">
                    <tr class="text-center">
                        <th width="40%">Fitur</th>

                        <th>
                            {{ $mobil1->merk }}
                            {{ $mobil1->nama_mobil }}
                        </th>

                        <th>
                            {{ $mobil2->merk }}
                            {{ $mobil2->nama_mobil }}
                        </th>
                    </tr>
                </thead>

                <tbody>

                @foreach($fiturList as $field => $nama)

                    <tr>

                        <td class="fw-semibold">
                            {{ $nama }}
                        </td>

                        <td class="text-center">

                            @if(optional($mobil1->fitur)->$field)
                                <span class="text-success fs-5">✔</span>
                            @else
                                <span class="text-danger fs-5">✘</span>
                            @endif

                        </td>

                        <td class="text-center">

                            @if(optional($mobil2->fitur)->$field)
                                <span class="text-success fs-5">✔</span>
                            @else
                                <span class="text-danger fs-5">✘</span>
                            @endif

                        </td>

                    </tr>

                @endforeach

                </tbody>

            </table>

        </div>

    </div>
</div>

@endif
    </div>
</div>


<div class="modal fade" id="imageModal">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content bg-dark">
            <img id="modalImage" class="viewer-img">
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
function openSingleImage(src){
    document.getElementById('modalImage').src = src;
    new bootstrap.Modal(document.getElementById('imageModal')).show();
}
</script>

</body>
</html>