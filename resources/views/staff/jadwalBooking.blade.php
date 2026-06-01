<!DOCTYPE html>
<html>
<head>
    <title>Jadwal Booking</title>

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

<nav class="navbar navbar-dark bg-dark">

    <div class="container-fluid">

        <span class="navbar-brand">
            Jadwal Booking
        </span>

        <a href="{{ route('staff.dashboard') }}"
           class="btn btn-light btn-sm">
            Kembali
        </a>

    </div>

</nav>

<div class="main-content">

    <div class="container mt-4">

        <h4 class="mb-3">
            Daftar Booking
        </h4>

        <div class="table-responsive">

            <table class="table table-bordered table-hover">

                <thead class="table-dark">

                    <tr>
                        <th>Kontak</th>
                        <th>Alamat Asal</th>
                        <th>Kecamatan Asal</th>
                        <th>Alamat Tujuan</th>
                        <th>Kecamatan Tujuan</th>
                        <th>Jadwal</th>
                        <th>Aksi</th>
                    </tr>

                </thead>

                <tbody>

                @forelse($booking as $b)

                    <tr>

                        <td>{{ $b->nomor_kontak }}</td>
                        <td>{{ $b->alamat_asal }}</td>
                        <td>{{ $b->kecamatan_asal }}</td>
                        <td>{{ $b->alamat_tujuan }}</td>
                        <td>{{ $b->kecamatan_tujuan }}</td>
                        <td>{{ $b->jadwal }} {{ $b->jam }}</td>

                        <td>

                            @if($b->status == 1)

                                <form action="{{ route('staff.booking.accept', $b->id) }}"
                                      method="POST">
                                    @csrf

                                    <button class="btn btn-success btn-sm">
                                        Accept
                                    </button>

                                </form>

                            @endif

                            @if($b->status == 2)

                                <form action="{{ route('staff.booking.kirim', $b->id) }}"
                                      method="POST">
                                    @csrf

                                    <button class="btn btn-primary btn-sm">
                                        Terkirim
                                    </button>

                                </form>

                            @endif

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="7" class="text-center">
                            Tidak ada booking
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