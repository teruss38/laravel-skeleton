@extends('layouts.app')

@section('title', __('Reset Password'))

@section('content')
    <div class="container py-4 login-box">
        <div class="row justify-content-center shadow ">
            <div class="col-12 col-sm-7 col-lg-7 col-xl-8 login-bg">
                <h4 class="mb-3">{{ __('Reset Password') }}</h4>
                <form method="POST" action="{{ route('password.update') }}">
                    @csrf

                    <input type="hidden" name="token" value="{{ $token }}">

                    <div class="form-group">
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" placeholder="{{ __('E-Mail Address') }}" required autocomplete="email" autofocus>

                        @error('email')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="{{ __('Password') }}" required autocomplete="new-password">

                        @error('password')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="{{ __('Confirm Password') }}" required autocomplete="new-password">
                    </div>

                    <div class="form-group mb-0">
                        <button type="submit" class="login-btn">
                            {{ __('Reset Password') }}
                        </button>

                        @if (Route::has('login'))
                            <a class="btn btn-link" href="{{ route('login') }}">
                                {{ __('Already have an account?') }}
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            <div class="col-12 col-sm-5 col-lg-5 col-xl-4 bg-three">
                @include('auth._social')
            </div>
        </div>
    </div>

@endsection
