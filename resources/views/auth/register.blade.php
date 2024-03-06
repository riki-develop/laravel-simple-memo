@extends('layouts.auth')

@section('content')
<div class="container">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header">{{ isset($authgroup) ? ucwords($authgroup) : ""}} {{ __('Register') }}</div>
    
                    <div class="card-body w-75 mx-auto">
                        @isset($authgroup)
                        <form method="POST" action="{{ url("register/$authgroup") }}">
                        @else
                        <form method="POST" action="{{ route('register') }}">
                        @endisset
                            @csrf
    
                            <div class="mb-3">
                                <label for="name" class="form-label">{{ __('Name') }}</label>
                                <div class="">
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
    
                            <div class="mb-3">
                                <label for="email" class="form-label">{{ __('Email Address') }}</label>
                                <div class="">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
    
                            <div class="mb-3">
                                <label for="password" class="form-label">{{ __('Password') }}</label>
                                <div class="">
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
    
                            <div class="mb-3">
                                <label for="password-confirm" class="form-label">{{ __('Confirm Password') }}</label>
                                <div class="">
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                </div>
                            </div>
    
                            <div class="mb-3 mx-auto text-center">
                                <button type="submit" class="btn btn-primary w-25">
                                    {{ __('Register') }}
                                </button>
                            </div>
    
                            @if (!isset($authgroup))
                            <div class="text-center">
                                <a href="/register/admin" class="text-decoration-none">管理者登録はこちら</a>
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
