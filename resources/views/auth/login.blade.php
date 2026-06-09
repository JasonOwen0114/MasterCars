@extends('layout.app')

@section('content')
<style>
    body{
        background:#f8f9fa;
    }

    .login-wrapper{
        min-height:80vh;
        display:flex;
        align-items:center;
        justify-content:center;
    }

    .login-card{
        width:100%;
        max-width:420px;
        border:none;
        border-radius:15px;
        box-shadow:0 4px 15px rgba(0,0,0,0.1);
    }

    .login-card .card-header{

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

    .btn-login{
        height:48px;
        border-radius:10px;
        font-weight:600;
    }

    @media (max-width:576px){
        .login-wrapper{
            padding:15px;
        }

        .login-card{
            max-width:100%;
        }

        .login-card .card-body{
            padding:20px;
        }
    }
</style>

<div class="container">
    <div class="login-wrapper">
        <div class="login-card card">
            <div class="card-header">
                Login
            </div>

            <div class="card-body">

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0 ps-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <form method="POST">
                    @csrf

                    <input
                        type="email"
                        name="email"
                        class="form-control"
                        placeholder="Email"
                        required
                    >

                    @error('email')
                        <div class="text-danger small mb-3">
                            {{ $message }}
                        </div>
                    @enderror

                    <input
                        type="password"
                        name="password"
                        class="form-control mb-3"
                        placeholder="Password"
                        required
                    >

                    <button class="btn btn-primary btn-login w-100">
                        Login
                    </button>
                </form>

                <div class="text-center mt-3">
                    Belum punya akun?
                    <a href="/register">Register</a>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection