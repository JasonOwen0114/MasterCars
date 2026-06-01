<!DOCTYPE html>
<html>
<head>
    <title>Tambah Staff</title>

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
            Staff Dashboard
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

    <div class="container mt-5">

        <h3 class="mb-4">
            Tambah Staff
        </h3>

        <div class="card p-4 shadow-sm">

            <form action="{{ route('admin.staff.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label>Nama</label>
                    <input type="text" name="nama" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>No HP</label>
                    <input type="text" name="no_hp" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Alamat</label>
                    <textarea name="alamat" class="form-control" required></textarea>
                </div>

                <div class="d-flex justify-content-between">

                    <a href="{{ route('admin.dashboard') }}"
                       class="btn btn-secondary">
                        Kembali
                    </a>

                    <button class="btn btn-success">
                        Simpan Staff
                    </button>

                </div>

            </form>

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