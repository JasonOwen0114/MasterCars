<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Hasil Inspeksi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .thumb {
            width: 100%;
            height: 160px;
            object-fit: cover;
            border-radius: 8px;
            cursor: pointer;
        }
        .viewer-img {
            width: 100%;
            max-height: 80vh;
            object-fit: contain;
            background: #000;
        }
        .nav-btn {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            font-size: 2rem;
            color: white;
            background: rgba(0,0,0,.5);
            border: none;
            width: 48px;
            height: 48px;
            border-radius: 50%;
        }
        .nav-left { left: 10px; }
        .nav-right { right: 10px; }
    </style>
    <style>
    .thumb {
        width: 100%;
        height: 160px;
        object-fit: cover;
        border-radius: 8px;
        cursor: pointer;
    }

    .viewer-img {
        width: 100%;
        max-height: 80vh;
        object-fit: contain;
        background: #000;
    }

    .nav-btn {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        font-size: 2rem;
        color: white;
        background: rgba(0,0,0,.5);
        border: none;
        width: 48px;
        height: 48px;
        border-radius: 50%;
    }

    .nav-left { left: 10px; }
    .nav-right { right: 10px; }


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
<body>
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
<div class="container py-4">

    <h4 class="fw-bold mb-4">Hasil Inspeksi Kendaraan</h4>

    <div class="card shadow-sm mb-3">
        <div class="card-body">
            <h5>{{ $mobil->merk }} {{ $mobil->nama_mobil }}</h5>
            <p class="text-muted mb-1">Tipe: {{ $mobil->tipe }} • Warna: {{ $mobil->warna }}</p>
            <p class="small mb-2">
                Mesin {{ $mobil->kapasitas_mesin }} cc • {{ $mobil->kapasitas_kursi }} Kursi
            </p>

            @if($mobil->status_jual == 1)
                <span class="badge bg-primary"> Titip Jual di MasterCars</span>
            @elseif($mobil->status_jual == 2)
                <span class="badge bg-secondary"> Mobil di Lokasi Penjual</span>
            @else
                <span class="badge bg-warning text-dark">Belum memilih metode penjualan</span>
            @endif

            @if(!is_null($mobil->harga))
                <div class="mt-2 fw-bold text-success">
                    Harga: Rp {{ number_format($mobil->harga, 0, ',', '.') }}
                </div>
            @endif
            <div class="mt-3">
    <span class="badge bg-dark p-2">   
                Terakhir Inspeksi: 
                {{ $mobil->inspeksi?->tanggal_inspeksi 
                    ? \Carbon\Carbon::parse($mobil->inspeksi->tanggal_inspeksi)->format('d M Y')
                    : '-' }}
    </span>
</div>

        </div>
    </div>

    @php
        $fotos = collect([
            'foto_depan','foto_belakang','foto_kiri','foto_kanan',
            'foto_dashboard','foto_kursi_depan','foto_kursi_belakang','foto_bagasi_belakang'
        ])->filter(fn($f) => !empty($mobil->$f))
          ->map(fn($f) => asset('storage/'.$mobil->$f))
          ->values();
    @endphp

    <div class="row g-3 mb-4">
        @foreach($fotos as $i => $foto)
            <div class="col-md-3 col-6">
                <img src="{{ $foto }}" class="thumb shadow-sm"
                     onclick="openViewer({{ $i }})">
            </div>
        @endforeach
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
<div class="card shadow-sm mb-4 mt-5">
    <div class="card-body">
        <h6 class="fw-bold mb-3">Penilaian Inspeksi</h6>

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

            @if($e)
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
                                <img src="{{ asset('storage/'.$e->{'foto_'.$field}) }}"
                                     class="img-fluid rounded shadow-sm"
                                     style="max-height:150px; cursor:pointer"
                                     onclick="openSingleImage('{{ asset('storage/'.$e->{'foto_'.$field}) }}')">
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
                                <img src="{{ asset('storage/'.$i->{'foto_'.$field}) }}"
                                     class="img-fluid rounded shadow-sm"
                                     style="max-height:150px; cursor:pointer"
                                     onclick="openSingleImage('{{ asset('storage/'.$i->{'foto_'.$field}) }}')">
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
                'indikator_dashboard' => 'Indikator Dashboard'
            ] as $field => $label)

            <div class="border rounded p-3 mb-3">
                <div class="row align-items-center">

        
                    <div class="col-md-4 text-center">
                        @if(!empty($m->{'foto_'.$field}))
                            <img src="{{ asset('storage/'.$m->{'foto_'.$field}) }}"
                                 class="img-fluid rounded shadow-sm"
                                 style="max-height:150px; cursor:pointer"
                                 onclick="openSingleImage('{{ asset('storage/'.$m->{'foto_'.$field}) }}')">
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
                            <img src="{{ asset('storage/'.$k->{'foto_'.$field}) }}"
                                 class="img-fluid rounded shadow-sm"
                                 style="max-height:150px; cursor:pointer"
                                 onclick="openSingleImage('{{ asset('storage/'.$k->{'foto_'.$field}) }}')">
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

        </div>
    </div>
</div>


</div>

<div class="modal fade" id="modalMetodeJual" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title fw-bold">Pilih Metode Penjualan</h5>
                <button type="button" class="btn-close"
                        data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body text-center">
                <button class="btn btn-primary w-100 mb-3"
                        onclick="pilihStatus(1)">
                     Titip Jual di MasterCars
                </button>

                <button class="btn btn-outline-secondary w-100"
                        onclick="pilihStatus(2)">
                     Mobil Tetap di Penjual
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalHarga" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <form method="POST" action="{{ route('mobil.simpanHarga', $mobil->id) }}">
                @csrf
                <input type="hidden" name="status_jual" id="statusJual">

                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Masukkan Harga Mobil</h5>
                    <button type="button" class="btn-close"
                            data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <input type="number" name="harga"
                           class="form-control"
                           placeholder="Contoh: 150000000"
                           required>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-success w-100">
                        Simpan & Post Mobil
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>

<div class="modal fade" id="viewerModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content bg-dark position-relative">
            <button class="nav-btn nav-left" onclick="prevImage()">‹</button>
            <img id="viewerImage" class="viewer-img">
            <button class="nav-btn nav-right" onclick="nextImage()">›</button>
        </div>
    </div>
</div>
<div class="modal fade" id="modalReinspeksi" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <form method="POST" action="{{ route('mobil.reinspeksi', $mobil->id) }}">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title">Jadwalkan Inspeksi Ulang</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                <input type="text" name="nomor_kontak"
                    class="form-control mb-2"
                    value="{{ auth()->user()->no_hp }}"
                    required>

                <input type="text" name="alamat"
                    class="form-control mb-2"
                    value="{{ auth()->user()->alamat }}"
                    required>

                <input type="text" name="kecamatan"
                    class="form-control mb-2"
                    value="{{ auth()->user()->kecamatan }}"
                    required>

                    <input type="date" name="jadwal"
                           class="form-control mb-2" required>

                    <select name="jam" id="jam"
                            class="form-control" required>
                        <option value="">Pilih Jam</option>
                        <option value="08:00:00">08:00</option>
                        <option value="11:00:00">11:00</option>
                        <option value="14:00:00">14:00</option>
                    </select>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-primary w-100">
                        Ajukan Re-Inspeksi
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
    const images = @json($fotos);
    let currentIndex = 0;

    const viewerModal = new bootstrap.Modal(document.getElementById('viewerModal'));
    const hargaModal  = new bootstrap.Modal(document.getElementById('modalHarga'));

    function openViewer(i) {
        currentIndex = i;
        document.getElementById('viewerImage').src = images[i];
        viewerModal.show();
    }

    function nextImage() {
        currentIndex = (currentIndex + 1) % images.length;
        document.getElementById('viewerImage').src = images[currentIndex];
    }

    function prevImage() {
        currentIndex = (currentIndex - 1 + images.length) % images.length;
        document.getElementById('viewerImage').src = images[currentIndex];
    }

    function pilihStatus(status) {
        document.getElementById('statusJual').value = status;
        bootstrap.Modal.getInstance(document.getElementById('modalMetodeJual')).hide();
        hargaModal.show();
    }
</script>


</body>
</html>