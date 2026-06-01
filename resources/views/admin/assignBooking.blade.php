<!DOCTYPE html>
<html>
<head>
    <title>Assign Delivery</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
    html, body{
        height: 100%;
    }

    body{
        display: flex;
        flex-direction: column;
        background: #f8f9fa;
    }

    .main-content{
        flex: 1;
    }

    table{
    width: 100%;
    }

    .table td,
    .table th{
        font-size: 13px;
        vertical-align: middle;
    }

</style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">

        <span class="navbar-brand">
            Admin Dashboard
        </span>

        <div class="d-flex align-items-center gap-2 flex-wrap">

            <a href="{{ route('admin.staff.create') }}" class="btn btn-success btn-sm">
                + Add Staff
            </a>

            <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary btn-sm">
                Dashboard
            </a>

            <a href="{{ route('admin.reinspeksi') }}" class="btn btn-primary btn-sm">
                Re-Inspeksi
            </a>

            <a href="{{ route('admin.laporan') }}" class="btn btn-info btn-sm">
                Laporan
            </a>

            <span class="text-white me-2">
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

    <div class="container-fluid mt-4 px-4">

        <h4 class="mb-4">
            Assign Delivery Mobil
        </h4>

        <div class="table-responsive">

            <table class="table table-bordered table-striped bg-white">

                <thead class="table-dark">


                <tr>

                    <th>Merk</th>
                    <th>Model</th>
                    <th>Tahun</th>
                    <th>Transmisi</th>
                    <th>Warna</th>
                    <th>Tipe Mesin</th>
                    <th>Kontak</th>
                    <th>Alamat Asal</th>
                    <th>Kecamatan Asal</th>
                    <th>Alamat Tujuan</th>
                    <th>Kecamatan Tujuan</th>
                    <th>Jadwal</th>
                    <th>Staff</th>
                    <th>Aksi</th>

                </tr>
                </thead>

                <tbody>

                @foreach($bookings as $b)

                    @php
                        $availableStaff = app(App\Http\Controllers\AdminController::class)
                            ->getAvailableStaffDelivery($b);
                    @endphp

<tr>

    <td>
        {{ $b->merk }}
    </td>

    <td>
        {{ $b->model_mobil }}
    </td>

    <td>
        {{ $b->tahun }}
    </td>

    <td>
        {{ $b->transmisi }}
    </td>

    <td>
        {{ $b->warna }}
    </td>

    <td>
        {{ $b->tipe_mesin }}
    </td>

    <td>
        {{ $b->nomor_kontak }}
    </td>

    <td>
        {{ $b->alamat_asal }}
    </td>

    <td>
        {{ $b->kecamatan_asal }}
    </td>

    <td>
        {{ $b->alamat_tujuan }}
    </td>

    <td>
        {{ $b->kecamatan_tujuan }}
    </td>

    <td>
        {{ $b->jadwal }}
        <br>
        <small>
            {{ $b->jam }}
        </small>
    </td>

    <td>

        <form action="{{ route('admin.booking.assign', $b->id) }}"
              method="POST">

            @csrf

            <select name="staff_id" class="form-select">

                <option value="">
                    -- Pilih Staff --
                </option>

                @foreach($availableStaff as $s)

                    <option value="{{ $s->id }}">
                        {{ $s->nama }}
                    </option>

                @endforeach

            </select>

    </td>

    <td>

            <button class="btn btn-primary btn-sm">
                Assign
            </button>

        </form>

    </td>

</tr>

                @endforeach

                </tbody>

            </table>

        </div>

    </div>

</div>

<footer class="bg-dark text-white text-center py-3 mt-auto">
    <small>
        © {{ date('Y') }} Sistem Inspeksi Mobil |
        Admin Panel
    </small>
</footer>

</body>
</html>