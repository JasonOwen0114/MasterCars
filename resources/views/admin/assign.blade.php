<!DOCTYPE html>
<html>
<head>
    <title>Assign Staff</title>

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
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">

        <span class="navbar-brand">
            Admin Dashboard
        </span>

        <div class="d-flex align-items-center gap-2 flex-wrap">

            <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary btn-sm">
                Dashboard
            </a>

            <a href="{{ route('admin.booking') }}" class="btn btn-warning btn-sm">
                Assign Delivery
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

    <div class="container mt-4">

        <h4 class="mb-4">
            Assign Staff untuk Mobil {{ $jadwal->mobil->nama }}
        </h4>

        <div class="table-responsive">

            <table class="table table-bordered table-striped bg-white">

                <tr class="table-dark">
                    <th>Nama Staff</th>
                    <th>No HP</th>
                    <th>Total Jadwal</th>
                    <th>Aksi</th>
                </tr>

                @foreach($staffs as $staff)

                <tr>

                    <td>{{ $staff->nama }}</td>

                    <td>
                        @foreach($staff->jadwalHariIni as $j)
                            <span class="badge bg-warning">
                                {{ $j->jam }} -
                                {{ date('H:i', strtotime($j->jam.' +2 hours')) }}
                            </span>
                        @endforeach
                    </td>

                    <td>

                        <form method="POST"
                              action="{{ route('admin.assign', $jadwal->id) }}">
                            @csrf

                            <input type="hidden"
                                   name="staff_id"
                                   value="{{ $staff->id }}">

                            <button class="btn btn-sm btn-primary">
                                Assign
                            </button>

                        </form>

                    </td>

                </tr>

                @endforeach

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