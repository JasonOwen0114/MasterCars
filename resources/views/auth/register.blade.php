@extends('layout.app')

@section('content')
<style>
    body{
        background:#f8f9fa;
    }

    .register-wrapper{
        min-height:85vh;
        display:flex;
        align-items:center;
        justify-content:center;
    }

    .register-card{
        width:100%;
        max-width:500px;
        border:none;
        border-radius:15px;
        box-shadow:0 4px 15px rgba(0,0,0,0.1);
    }

    .register-card .card-header{

        color:black;
        text-align:center;
        font-weight:600;
        font-size:1.2rem;
        border-radius:15px 15px 0 0 !important;
        padding:15px;
    }

    .form-control{
        height:48px;
        border-radius:10px;
    }

    .btn-register{
        height:48px;
        border-radius:10px;
        font-weight:600;
    }

    @media (max-width:576px){
        .register-wrapper{
            padding:15px;
        }

        .register-card{
            max-width:100%;
        }

        .register-card .card-body{
            padding:20px;
        }
    }
</style>

<div class="container">

    <div class="register-wrapper">

        <div class="register-card card">

            <div class="card-header">
                Register
            </div>

            <div class="card-body">

               <form method="POST" action="{{ route('register') }}">
                @csrf

                <input
                    name="nama"
                    class="form-control mb-3"
                    placeholder="Nama"
                    value="{{ old('nama') }}"
                    required
                >

                <input
                    name="email"
                    type="email"
                    class="form-control mb-3"
                    placeholder="Email"
                    value="{{ old('email') }}"
                    required
                >

                <input
                    name="no_hp"
                    class="form-control mb-3"
                    placeholder="No HP"
                    value="{{ old('no_hp') }}"
                    required
                >

                <input
                    name="password"
                    type="password"
                    class="form-control mb-3"
                    placeholder="Password"
                    required
                >

                <input
                    name="password_confirmation"
                    type="password"
                    class="form-control mb-3"
                    placeholder="Konfirmasi Password"
                    required
                >
                @if ($errors->any())
                    <div class="text-danger small mb-3">
                        {{ $errors->first() }}
                    </div>
                @endif

                <button class="btn btn-success btn-register w-100">
                    Register
                </button>
            </form>
                <div class="text-center mt-3">
                    Sudah punya akun?
                    <a href="{{ url('/login') }}">Login</a>
                </div>

            </div>

        </div>

    </div>

</div>
@endsection