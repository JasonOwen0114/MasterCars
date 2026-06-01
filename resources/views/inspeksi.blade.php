<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Mobil Menunggu Inspeksi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .img-mobil {
            width: 100%;
            height: 160px;
            object-fit: cover;
            border-radius: 8px;
            background: #f1f1f1;
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
                   class="nav-link text-white fw-bold">
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
    <h4 class="fw-bold mb-4">Mobil Menunggu Hasil Inspeksi</h4>

    @forelse($mobils as $mobil)
        <div class="card mb-3 shadow-sm">
            <div class="row g-0 align-items-center">
                <div class="col-md-3 p-2">
                    <img
                        src="{{ asset('storage/'.$mobil->foto_thumbnail) }}"
                        class="img-mobil"
                        alt="Mobil">
                </div>

                <div class="col-md-7">
                    <div class="card-body">
                        <h5 class="fw-bold">
                            {{ $mobil->merk }} {{ $mobil->nama_mobil }}
                        </h5>
                        <p class="text-muted small mb-1">
                            {{ $mobil->tipe }} • {{ $mobil->warna }}
                        </p>
                        <p class="small mb-0">
                            Mesin {{ $mobil->kapasitas_mesin }} cc •
                            {{ $mobil->kapasitas_kursi }} Kursi
                        </p>
                    </div>
                </div>

                <div class="col-md-2 text-center">
                    <a href="{{ route('user.inspeksi.hasil',$mobil->id) }}"
                       class="btn btn-outline-primary btn-sm">
                        Lihat Hasil
                    </a>
                </div>
            </div>
        </div>
    @empty
        <div class="alert alert-info">
            Belum ada mobil yang diinspeksi
        </div>
    @endforelse
</div>

</body>
</html>