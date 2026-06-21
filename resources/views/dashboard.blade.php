<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>MasterCars</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
        }
        .hero-img {
            height: 500px;
            width: 100%;
            object-fit: cover;
            border-radius: 16px;
        }

        @media (max-width: 768px) {
            .hero-img {
                height: 250px;
            }
        }
        .car-card img {
            height: 180px;
            object-fit: cover;
            border-radius: 8px;
        }
        footer {
            background: #000;
            color: #aaa;
        }
        .filter-card {
            border: none;
            border-radius: 16px;
            padding: 18px;
            background: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.06);
        }

        .filter-title {
            font-weight: 700;
            font-size: 18px;
            margin-bottom: 16px;
        }

        .filter-btn {
            height: 48px;
            min-width: 110px;
            border-radius: 10px;
            font-weight: 600;
        }

        .form-control,
        .form-select,
        .ts-control {
            min-height: 48px !important;
            border-radius: 10px !important;
        }

        .sort-wrapper {
            background: white;
            border-radius: 16px;
            padding: 18px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.06);
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

    <a href="{{ route('user.profile') }}" class="nav-link text-white">
        Profil
    </a>

    @auth
        @if($jumlahMenunggu > 0)
            <a href="{{ route('user.inspeksi') }}" class="nav-link text-white">
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
            <a href="{{ route('user.mobilSaya') }}" class="nav-link text-white">
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
<a href="{{ route('laporan.reinspeksi') }}" class="nav-link text-white">
    Laporan Inspeksi
</a>
@endif
    @auth
        {{-- <a href="#" class="nav-link text-white">Beli</a> --}}
    @else
        {{-- <a href="{{ route('login') }}" class="nav-link text-white">Beli</a> --}}
    @endauth

    @auth
        <a href="{{ route('jual1') }}" class="nav-link text-white">Jual</a>
    @else
        <a href="{{ route('login') }}" class="nav-link text-white">Jual</a>
    @endauth

    @auth
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button class="btn btn-danger btn-sm">Logout</button>
        </form>
    @else
        <a href="{{ route('login') }}" class="btn btn-light btn-sm">Login</a>
    @endauth

</div>

</nav>

<div class="container mt-5">

    <div class="row">
        <div class="col-lg-12 mb-4">
           <h1 class="fw-bold">
                Welcome to MasterCars
                @auth
                    , {{ auth()->user()->nama }}
                @endauth
            </h1>

            <p class="text-muted mt-3">
                Find the perfect car for your needs here. Shop new and used cars,
                sell your car, compare prices, and explore financing options to find your dream car.
            </p>
        </div>
    </div>

    <div id="heroCarousel" class="carousel slide mb-5" data-bs-ride="carousel">
        <div class="carousel-inner rounded-4 shadow-sm">

            <div class="carousel-item active">
                <img src="{{ asset('images/img1.png') }}"
                     class="d-block w-100 hero-img"
                     alt="Car 1">
            </div>

            <div class="carousel-item">
                <img src="{{ asset('images/img2.png') }}"
                     class="d-block w-100 hero-img"
                     alt="Car 2">
            </div>

            <div class="carousel-item">
                <img src="{{ asset('images/img3.png') }}"
                     class="d-block w-100 hero-img"
                     alt="Car 3">
            </div>

        </div>

        <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>

        <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>
    </div>

</div>

<div class="container mt-4">

<form method="GET" action="{{ route('dashboard') }}">

    <!-- FILTER UTAMA -->
    <div class="filter-card mb-3">

        <div class="row g-3 align-items-center">

            <div class="col-md">
                <select name="merk" id="merk" class="form-select">
                    <option value="">Pilih Merk</option>

                    @foreach($merks as $merk)
                        <option value="{{ $merk }}"
                            {{ request('merk') == $merk ? 'selected' : '' }}>
                            {{ $merk }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md">
                <select name="model" id="model" class="form-select">
                    <option value="">Pilih Model</option>
                </select>
            </div>

            <div class="col-md">
                <input type="number"
                       name="tahun_min"
                       class="form-control"
                       placeholder="Tahun Min"
                       value="{{ request('tahun_min') }}">
            </div>

            <div class="col-md">
                <input type="number"
                       name="tahun_max"
                       class="form-control"
                       placeholder="Tahun Max"
                       value="{{ request('tahun_max') }}">
            </div>

            <div class="col-md-auto d-flex gap-2">
                <button class="btn btn-dark filter-btn">
                    Cari
                </button>

                <a href="{{ route('dashboard') }}"
                   class="btn btn-secondary filter-btn">
                    Reset
                </a>
            </div>

        </div>

    </div>


    <div class="filter-card mb-3">


        <div class="row g-3 align-items-center">

            <div class="col-md">
                <input type="number"
                       name="harga_min"
                       class="form-control"
                       placeholder="Harga Minimum"
                       value="{{ request('harga_min') }}">
            </div>

            <div class="col-md">
                <input type="number"
                       name="harga_max"
                       class="form-control"
                       placeholder="Harga Maximum"
                       value="{{ request('harga_max') }}">
            </div>

            <div class="col-md">
                <select name="kursi" class="form-select">
                    <option value="">Kapasitas Kursi</option>

                    <option value="4" {{ request('kursi') == 4 ? 'selected' : '' }}>
                        4 Kursi
                    </option>

                    <option value="5" {{ request('kursi') == 5 ? 'selected' : '' }}>
                        5 Kursi
                    </option>

                    <option value="7" {{ request('kursi') == 7 ? 'selected' : '' }}>
                        7 Kursi
                    </option>
                </select>
            </div>

            <div class="col-md-auto d-flex gap-2">

                <button class="btn btn-primary filter-btn">
                    Rekomendasikan
                </button>

                <a href="{{ route('dashboard') }}"
                   class="btn btn-secondary filter-btn">
                    Reset
                </a>

            </div>

        </div>

    </div>

 
    <div class="sort-wrapper mb-4">

        <div class="row align-items-center g-3">

            <div class="col-md-3">
                <label class="fw-semibold mb-2">
                    Urutkan Mobil
                </label>

                <select name="sort"
                        class="form-select"
                        onchange="this.form.submit()">

                    <option value="">Default</option>

                    <option value="harga_terendah"
                        {{ request('sort') == 'harga_terendah' ? 'selected' : '' }}>
                        Harga Terendah
                    </option>

                    <option value="harga_tertinggi"
                        {{ request('sort') == 'harga_tertinggi' ? 'selected' : '' }}>
                        Harga Tertinggi
                    </option>

                    <option value="tahun_terbaru"
                        {{ request('sort') == 'tahun_terbaru' ? 'selected' : '' }}>
                        Tahun Terbaru
                    </option>

                    <option value="tahun_terlama"
                        {{ request('sort') == 'tahun_terlama' ? 'selected' : '' }}>
                        Tahun Terlama
                    </option>

                </select>
            </div>

        </div>

    </div>

</form>

</div>

<div class="container mt-5">
    <div class="row g-4" id="mobil-container">
        @if($mobils->count())
    @include('partials.mobil-card', ['mobils' => $mobils])
@else
    <div class="text-center text-muted">
        <h5>Tidak ada stok mobil</h5>
    </div>
@endif 
    </div>

    @if ($mobils->hasMorePages())
    <div class="text-center mt-4">
        <button id="load-more"
                class="btn btn-dark"
                data-next-page="{{ $mobils->currentPage() + 1 }}">
            Muat
        </button>
    </div>
    @endif
</div>

    <div class="text-center mt-4">
        <button class="btn btn-dark">Muat</button>
    </div>
</div>

<div class="container mt-5">
    <h4 class="text-center fw-bold mb-4">Cara Jual & Beli Mobil</h4>

    <div class="row g-4 text-center">
        <div class="col-md-3">
            <div class="card p-3 h-100 shadow-sm">
                <h6 class="fw-bold">Temukan Mobil</h6>
                <p class="text-muted small">Cari mobil sesuai kebutuhan Anda</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card p-3 h-100 shadow-sm">
                <h6 class="fw-bold">Kondisi Terjamin</h6>
                <p class="text-muted small">Mobil telah di inspeksi oleh inspektor berpengalaman</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card p-3 h-100 shadow-sm">
                <h6 class="fw-bold">Pengiriman</h6>
                <p class="text-muted small">Mobil dikirim ke rumah</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card p-3 h-100 shadow-sm">
                <h6 class="fw-bold">Transaksi Aman</h6>
                <p class="text-muted small">Pembayaran aman & terpercaya</p>
            </div>
        </div>
    </div>
</div>

<footer class="mt-5 py-5 bg-black text-light">
    <div class="container">
        <div class="row">

            <div class="col-md-6 mb-4">
                <img src="{{ asset('images/logo.png') }}"
                     alt="MasterCars"
                     height="40"
                     class="mb-3">

                <p class="small text-secondary">
                    MasterCars merupakan marketplace jual beli mobil terpercaya di Indonesia.
                    MasterCars melayani layanan jual beli sekaligus inspeksi kendaraan secara transparan.
                </p>

                <div class="d-flex gap-3">
                    <span class="text-secondary">●</span>
                    <span class="text-secondary">●</span>
                    <span class="text-secondary">●</span>
                </div>
            </div>

            <div class="col-md-3 mb-4">
                <h6 class="fw-bold">Layanan</h6>
                <ul class="list-unstyled small text-secondary">
                    <li>Beli Mobil</li>
                    <li>Jual Mobil</li>
                    <li>Inspeksi Kendaraan</li>
                </ul>
            </div>

        </div>

        <hr class="border-secondary">

        <div class="text-center small text-secondary">
            © {{ date('Y') }} MasterCars. All rights reserved.
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- PINDAH KE SINI -->
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>


<script>
document.getElementById('load-more')?.addEventListener('click', function () {
    let button = this;
    let page = button.getAttribute('data-next-page');

    fetch(`/?page=${page}`, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(res => res.text())
    .then(data => {
        document.getElementById('mobil-container').insertAdjacentHTML('beforeend', data);

        let nextPage = parseInt(page) + 1;
        button.setAttribute('data-next-page', nextPage);

        if (!data.trim()) {
            button.remove();
        }
    });
});



</script>
<script>
document.addEventListener('DOMContentLoaded', function () {

    const merk = document.getElementById('merk');
    const model = document.getElementById('model');

    const merkSelect = new TomSelect("#merk", {
        create: false,
        sortField: { field: "text", direction: "asc" }
    });

    const modelSelect = new TomSelect("#model", {
        create: false,
        sortField: { field: "text", direction: "asc" }
    });

    modelSelect.disable(); // disable awal

    merk.addEventListener('change', function () {

        let selectedMerk = this.value;

        modelSelect.clear();
        modelSelect.clearOptions();
        modelSelect.disable();

        if (!selectedMerk) {
            modelSelect.addOption({value: "", text: "Pilih merk dulu"});
            modelSelect.refreshOptions(false);
            return;
        }

        modelSelect.addOption({value: "", text: "Loading..."});
        modelSelect.refreshOptions(false);

        fetch(`/jual/models/${encodeURIComponent(selectedMerk)}`)
            .then(res => res.json())
            .then(data => {

                modelSelect.clearOptions();

                data.forEach(item => {
                    modelSelect.addOption({
                        value: item,
                        text: item
                    });
                });

                modelSelect.enable(); // ✅ INI YANG PENTING
                modelSelect.refreshOptions(false);

                let selectedModel = "{{ request('model') }}";
                if (selectedModel) {
                    modelSelect.setValue(selectedModel);
                }
            })
            .catch(() => {
                modelSelect.clearOptions();
                modelSelect.addOption({value: "", text: "Error load data"});
                modelSelect.refreshOptions(false);
            });
    });

    // auto trigger kalau ada merk
    @if(request('merk'))
        merk.dispatchEvent(new Event('change'));
    @endif

});
</script>


<script>
let selected = [];

document.addEventListener('change', function(e){
    if(e.target.classList.contains('compare-checkbox')){

        if(e.target.checked){
            if(selected.length >= 2){
                alert('Maksimal 2 mobil');
                e.target.checked = false;
                return;
            }
            selected.push(e.target.value);
        } else {
            selected = selected.filter(id => id != e.target.value);
        }

        if(selected.length === 2){
            window.location.href = `/compare/result?ids=${selected.join(',')}`;
        }
    }
});
</script>
</body>
</html>
