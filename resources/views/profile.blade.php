<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Profil Saya</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body{
            background: #f4f6f9;
            min-height: 100vh;
        }

        .profile-wrapper{
            max-width: 850px;
            margin: auto;
        }

        .profile-card{
            border: none;
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        }

        .profile-header{
            background: linear-gradient(135deg, #6c757d, #9aa0a6);
            padding: 35px;
            color: white;
        }

        .profile-header h2{
            margin: 0;
            font-weight: 700;
        }

        .profile-header p{
            margin-top: 8px;
            opacity: 0.9;
        }

        .profile-body{
            padding: 35px;
            background: white;
        }

        .form-label{
            font-weight: 600;
            margin-bottom: 8px;
            color: #374151;
        }

        .form-control{
            border-radius: 12px;
            padding: 12px 14px;
            border: 1px solid #dcdfe4;
        }

        .form-control:focus{
            box-shadow: none;
            border-color: #0d6efd;
        }

        textarea.form-control{
            resize: none;
        }

        .btn{
            border-radius: 10px;
            padding: 10px 20px;
            font-weight: 600;
        }

        .btn-primary{
            background: #0d6efd;
            border: none;
        }

        .btn-primary:hover{
            background: #0b5ed7;
        }

        .modal-content{
            border: none;
            border-radius: 18px;
            overflow: hidden;
        }

        .modal-header{
            background: #0d6efd;
            color: white;
            border-bottom: none;
            padding: 20px 24px;
        }

        .modal-title{
            font-weight: 700;
        }

        .btn-close{
            filter: brightness(0) invert(1);
        }

        .modal-body{
            padding: 25px;
        }

        .modal-footer{
            border-top: none;
            padding: 20px 25px;
        }

        .alert{
            border-radius: 12px;
        }

        @media(max-width: 768px){

            .profile-header{
                padding: 25px;
            }

            .profile-body{
                padding: 25px;
            }

            .d-flex-mobile{
                display: flex;
                flex-direction: column;
                gap: 10px;
            }

            .d-flex-mobile .btn{
                width: 100%;
                margin-left: 0 !important;
            }
        }
    </style>
</head>
<body>
    @php
    use App\Models\Mobil;
    use Illuminate\Support\Facades\DB;

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
    ->whereNull('status_approval')
    ->orWhereNotNull('note')
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
        <a href="{{ route('jual1') }}" class="nav-link text-white">
            Jual
        </a>
    @else
        <a href="{{ route('login') }}" class="nav-link text-white">
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
        <a href="{{ route('login') }}" class="btn btn-light btn-sm">
            Login
        </a>
    @endauth

</div>
</nav>
<div class="container py-5">

    <div class="profile-wrapper">

        <div class="profile-card">

            <div class="profile-header">
                <h2>Profil Saya</h2>

            </div>

            <div class="profile-body">

                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('user.profile.update') }}">
                    @csrf

                    <div class="row">

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nama</label>
                            <input name="nama"
                                   class="form-control"
                                   value="{{ auth()->user()->nama }}">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email</label>
                            <input name="email"
                                   class="form-control"
                                   value="{{ auth()->user()->email }}">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">No HP</label>
                            <input name="no_hp"
                                   class="form-control"
                                   value="{{ auth()->user()->no_hp }}">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Kecamatan</label>
                            <input type="text"
                                   name="kecamatan"
                                   class="form-control"
                                   value="{{ auth()->user()->kecamatan }}">
                        </div>

                        <div class="col-12 mb-4">
                            <label class="form-label">Alamat Lengkap</label>
                            <textarea name="alamat"
                                      class="form-control"
                                      rows="4">{{ auth()->user()->alamat }}</textarea>
                        </div>

                    </div>

                    <div class="d-flex-mobile">
                        <button class="btn btn-primary">
                            Simpan Profil
                        </button>

                        <button type="button"
                                class="btn btn-outline-secondary ms-2"
                                data-bs-toggle="modal"
                                data-bs-target="#passwordModal">
                            Ubah Password
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="passwordModal" tabindex="-1">
    <div class="modal-dialog">

        <form method="POST"
              action="{{ route('user.profile.password') }}"
              class="modal-content">
            @csrf

            <div class="modal-header">
                <h5 class="modal-title">Ubah Password</h5>

                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="mb-3">
                    <label class="form-label">Password Lama</label>

                    <input type="password"
                           name="password_lama"
                           class="form-control"
                           required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Password Baru</label>

                    <input type="password"
                           name="password"
                           class="form-control"
                           required>
                </div>

                <div class="mb-2">
                    <label class="form-label">
                        Konfirmasi Password Baru
                    </label>

                    <input type="password"
                           name="password_confirmation"
                           class="form-control"
                           required>
                </div>

            </div>

            <div class="modal-footer">

                <button class="btn btn-primary">
                    Simpan Password
                </button>

            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

@if ($errors->any())
<script>
    var myModal = new bootstrap.Modal(document.getElementById('passwordModal'));
    myModal.show();
</script>
@endif

</body>
</html>