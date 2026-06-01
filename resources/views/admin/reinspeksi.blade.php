<!DOCTYPE html>
<html>
<head>
    <title>Re-Inspeksi</title>

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
            Re-Inspeksi
        </span>

        <div class="d-flex align-items-center gap-2 flex-wrap">

            <a href="{{ route('admin.staff.create') }}"
               class="btn btn-success btn-sm">
                + Add Staff
            </a>

            <a href="{{ route('admin.dashboard') }}"
               class="btn btn-secondary btn-sm">
                Dashboard
            </a>

            <a href="{{ route('admin.booking') }}"
               class="btn btn-warning btn-sm">
                Assign Delivery
            </a>

            <a href="{{ route('admin.laporan') }}"
               class="btn btn-info btn-sm">
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

        <h4 class="mb-3">
            Jadwal Re-Inspeksi
        </h4>

        <div class="table-responsive">

            <table class="table table-bordered table-striped align-middle">

                <thead class="table-dark">

                    <tr>

                        <th>Order ID</th>
                        <th>Merk</th>
                        <th>Model</th>
                        <th>Tahun</th>
                        <th>Transmisi</th>
                        <th>Warna</th>
                        <th>Tipe Mesin</th>
                        <th>Nomor Kontak</th>
                        <th>Alamat</th>
                        <th>Kecamatan</th>
                        <th>Jadwal</th>
                        <th>Jam</th>
                  
                        <th>Staff</th>
                        <th>Aksi</th>

                    </tr>

                </thead>

                <tbody>

                @forelse($jadwal as $j)

                    @php
                        $availableStaff = app(App\Http\Controllers\AdminController::class)
                            ->getAvailableStaff($j);
                    @endphp

<tr>

    <td>
        {{ $j->order_id }}
    </td>

    <td>
        {{ $j->merk }}
    </td>

    <td>
        {{ $j->model_mobil }}
    </td>

    <td>
        {{ $j->tahun }}
    </td>

    <td>
        {{ $j->transmisi }}
    </td>

    <td>
        {{ $j->warna }}
    </td>

    <td>
        {{ $j->tipe_mesin }}
    </td>

    <td>
        {{ $j->nomor_kontak }}
    </td>

    <td>
        {{ $j->alamat }}
    </td>

    <td>
        {{ $j->kecamatan }}
    </td>

    <td>
        {{ $j->jadwal }}
    </td>

    <td>
        {{ $j->jam }}
    </td>



    <td>

        <form action="{{ route('admin.assign.store', $j->id) }}"
              method="POST">

            @csrf

            <select name="staff_id"
                    class="form-select"
                    required>

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

            <button class="btn btn-success btn-sm">
                Assign
            </button>

        </form>

    </td>

</tr>

                @empty

                    <tr>

                        <td colspan="7" class="text-center">
                            Tidak ada data re-inspeksi
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
        Admin Panel
    </small>

</footer>

</body>
</html>