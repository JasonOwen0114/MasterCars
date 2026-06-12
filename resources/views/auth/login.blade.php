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

                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif


                <form method="POST">
                    @csrf

                <div class="mb-3">
                    <input
                        type="email"
                        name="email"
                        class="form-control"
                        placeholder="Email"
                        required
                    >
                </div>
                <div class="mb-3">
                    <input
                        type="password"
                        name="password"
                        class="form-control"
                        placeholder="Password"
                        required
                    >
                </div>

                    @error('email')
                        <div class="text-danger small mb-3">
                            {{ $message }}
                        </div>
                    @enderror

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