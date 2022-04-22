@extends('template.login-template')

@section('main-content')
<div class="page page-center">
    <div class="container-tight py-4">
        <div class="text-center mb-4">
            <a href="." class="navbar-brand navbar-brand-autodark"><img src="{{ asset('images/logo.png') }}" height="36"></a>
        </div>
        <form class="card card-md" action="{{ route('loginProcess')}}" autocomplete="off">
            @csrf
            <div class="card-body">
                <h2 class="card-title text-center mb-4">Login to your account</h2>
                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <input type="text" class="form-control" name="username" placeholder="Enter Username" required>
                </div>
                <div class="mb-2">
                    <label class="form-label">
                        Password
                        <span class="form-label-description">
                            <a href="{{ route('forget') }}">I forgot password</a>
                        </span>
                    </label>
                    <input type="password" class="form-control" name="password" placeholder="Password" autocomplete="off" required>
                </div>
                <div class="mb-2">
                    <label class="form-check">
                        <input type="checkbox" name="remember" class="form-check-input" />
                        <span class="form-check-label">Remember me on this device</span>
                    </label>
                </div>
                <div class="form-footer">
                    <button type="submit" class="btn btn-primary w-100">Sign in</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection