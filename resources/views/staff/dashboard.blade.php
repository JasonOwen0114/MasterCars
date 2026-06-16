<!DOCTYPE html>
<html>
<head>
    <title>Staff Dashboard</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        html,
        body{
            height: 100%;
        }

        body{
            display: flex;
            flex-direction: column;
            background-color: #f8f9fa;
        }

        .main-content{
            flex: 1;
        }

        .table{
            background: white;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">

    <div class="container-fluid">

        <span class="navbar-brand">
            Staff Dashboard
        </span>

        <div class="d-flex align-items-center">

            <a href="{{ route('staff.booking') }}"
               class="btn btn-warning btn-sm me-3">
                Booking
            </a>

            <span class="text-white me-3">
                {{ auth()->user()->nama }}
            </span>

            <form action="{{ route('logout') }}" method="POST">
                @csrf

                <button class="btn btn-outline-light btn-sm">
                    Logout
                </button>
            </form>

        </div>

    </div>

</nav>

<div class="main-content">

    <div class="container mt-4">

        <h4 class="mb-3">
            Daftar Mobil Untuk Inspeksi
        </h4>

        <div class="table-responsive">

            <table class="table table-bordered table-hover">

                <thead class="table-dark">

                    <tr>
                        <th>Merk</th>
                        <th>Model</th>
                        <th>Tahun</th>
                        <th>Transmisi</th>
                        <th>Warna</th>
                        <th>Tipe Mesin</th>
                        <th>Kontak</th>
                        <th>Alamat</th>
                        <th>Kecamatan</th>
                        <th>Jadwal</th>
                        <th>Aksi</th>
                    </tr>

                </thead>

                <tbody>

                @forelse($jadwal as $j)

                    <tr>

                        <td>{{ $j->merk }}</td>
                        <td>{{ $j->model_mobil }}</td>
                        <td>{{ $j->tahun }}</td>
                        <td>{{ $j->transmisi }}</td>
                        <td>{{ $j->warna }}</td>
                        <td>{{ $j->tipe_mesin }}</td>
                        <td>{{ $j->nomor_kontak }}</td>
                        <td>{{ $j->alamat }}</td>
                        <td>{{ $j->kecamatan }}</td>
                        <td>{{ $j->jadwal }} {{ $j->jam }}</td>

                        <td>

                            <a href="{{ route('staff.inspeksi.form', $j->id) }}"
                               class="btn btn-primary btn-sm">
                                Mulai Inspeksi
                            </a>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="11" class="text-center">
                            Belum ada jadwal inspeksi
                        </td>

                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>

        <hr>

        <h4 class="mb-3">
            Inspeksi Ulang
        </h4>

        <div class="table-responsive">

            <table class="table table-bordered table-hover">

                <thead class="table-dark">

                    <tr>
                        <th>Merk</th>
                        <th>Model</th>
                        <th>Tahun</th>
                        <th>Transmisi</th>
                        <th>Warna</th>
                        <th>Tipe Mesin</th>
                        <th>Kontak</th>
                        <th>Alamat</th>
                        <th>Kecamatan</th>
                        <th>Jadwal</th>
                        <th>Aksi</th>
                    </tr>

                </thead>

                <tbody>

                @forelse($reinspeksi as $r)

                    <tr>


                        <td>{{ $r->merk }}</td>
                        <td>{{ $r->model_mobil }}</td>
                        <td>{{ $r->tahun }}</td>
                        <td>{{ $r->transmisi }}</td>
                        <td>{{ $r->warna }}</td>
                        <td>{{ $r->tipe_mesin }}</td>
                        <td>{{ $r->nomor_kontak }}</td>
                        <td>{{ $r->alamat }}</td>
                        <td>{{ $r->kecamatan }}</td>
                        <td>{{ $r->jadwal }} {{ $r->jam }}</td>
                        <td>

                            <a href="{{ route('staff.inspeksi.form', $r->id) }}"
                               class="btn btn-primary btn-sm">
                                Update Inspeksi
                            </a>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="11" class="text-center">
                            Tidak ada jadwal re-inspeksi
                        </td>

                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

<footer class="bg-dark text-white text-center py-3 mt-auto">

    <small>
        © {{ date('Y') }} Sistem Inspeksi Mobil |
        Staff Panel
    </small>

</footer>

</body>
</html>