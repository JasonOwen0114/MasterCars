<!DOCTYPE html>
<html>
<head>
    <title>@yield('title')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>

        body{
            background:#f5f5f5;
        }

        .table thead th{
            background:#6c757d !important;
            color:white !important;
        }

        .card-header{
            background:#6c757d !important;
            color:white !important;
            font-weight:bold;
        }

    </style>

</head>
<body>

<nav class="navbar navbar-dark bg-dark navbar-expand-lg">
    <div class="container-fluid">

        <span class="navbar-brand fw-bold">
            📊 Laporan Admin
        </span>

        <!-- BAGIAN KANAN -->
        <div class="d-flex align-items-center gap-2">

            <!-- DROPDOWN LAPORAN -->
            <div class="dropdown">

                <button class="btn btn-outline-light btn-sm dropdown-toggle"
                        type="button"
                        data-bs-toggle="dropdown"
                        aria-expanded="false">
                    Laporan
                </button>

                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-dark">

                    <li>
                        <a class="dropdown-item"
                           href="{{ route('admin.laporan.staff') }}">
                           Kinerja Staff
                        </a>
                    </li>

                    <li>
                        <a class="dropdown-item"
                           href="{{ route('admin.laporan.pendapatan') }}">
                           Pendapatan Bulanan
                        </a>
                    </li>

                    <li>
                        <a class="dropdown-item"
                           href="{{ route('admin.laporan.jadwalTerpadat') }}">
                           Jadwal Terpadat
                        </a>
                    </li>

                    <li>
                        <a class="dropdown-item"
                           href="{{ route('admin.laporan.jadwal') }}">
                           Jadwal Inspeksi
                        </a>
                    </li>

                    <li>
                        <a class="dropdown-item"
                           href="{{ route('admin.laporan.waktuPenjualan') }}">
                           Waktu Penjualan
                        </a>
                    </li>

                    <li>
                        <a class="dropdown-item"
                           href="{{ route('admin.laporan.pendapatanInspeksi') }}">
                           Pendapatan Inspeksi
                        </a>
                    </li>

                    <li>
                        <a class="dropdown-item"
                           href="{{ route('admin.laporan.mobilTahun') }}">
                           Mobil per Tahun
                        </a>
                    </li>

                    <li>
                        <a class="dropdown-item"
                           href="{{ route('admin.laporan.hasilInspeksi') }}">
                           Hasil Inspeksi
                        </a>
                    </li>

                    <li>
                        <a class="dropdown-item"
                           href="{{ route('admin.laporan.penjualan') }}">
                           Penjualan
                        </a>
                    </li>

                    <li>
                        <a class="dropdown-item"
                           href="{{ route('admin.laporan.mobilAktif') }}">
                           Mobil Aktif
                        </a>
                    </li>

                </ul>

            </div>

            <!-- TOMBOL DASHBOARD -->
            <a href="{{ route('admin.dashboard') }}"
               class="btn btn-warning btn-sm">
               ⬅ Dashboard
            </a>

        </div>

    </div>
</nav>

<div class="container py-4">

    @yield('content')

</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>
</body>
</html>