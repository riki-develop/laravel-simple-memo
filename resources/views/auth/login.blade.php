@extends('layouts.auth')

@section('content')
<div class="container">


    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header">{{ isset($authgroup) ? ucwords($authgroup) : ""}} {{ __('Login') }}</div>
    
                    <div class="card-body w-75 mx-auto">
                        @isset($authgroup)
                        <form method="POST" action="{{ url("login/$authgroup") }}">
                        @else
                        <form method="POST" action="{{ route('login') }}">
                        @endisset
    
                            @csrf
    
                            <div class="mb-3">
                                <label for="email" class="form-label">{{ __('Email Address') }}</label>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
    
                                @error('email')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>
    
                            <div class="mb-3">
                                <label for="password" class="form-label">{{ __('Password') }}</label>
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
    
                                @error('password')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>
    
                            <div class="mb-3 form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label" for="remember">
                                    {{ __('Remember Me') }}
                                </label>
                            </div>
    
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>
                            </div>
    
                            <div class="my-3 text-center">
                                @if (Route::has(isset($authgroup) ? $authgroup.'.password.request' : 'password.request'))
                                    <a class="text-decoration-none" href="{{ route(isset($authgroup) ? $authgroup.'.password.request' : 'password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
    
                            @if(Request::is('login'))
                                <div class="text-center">
                                    <a href="/login/admin" class="text-decoration-none">管理者ログインはこちら</a>
                                </div>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection