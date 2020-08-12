@extends('layouts.app')

@section('title', __('Bind Account'))

@section('content')
    <div class="container py-4 login-box">
        <div class="row justify-content-center shadow ">
            <div class="col-12 col-sm-7 col-lg-7 col-xl-8 login-bg">
                <h4 class="mb-3">{{ __('Bind Account') }}</h4>
                <form method="POST" action="{{ route('login') }}" aria-label="{{ __('Binging') }}">
                    @csrf
                    <div class="form-group">
                        <input id="account" type="text"
                               class="form-control{{ $errors->has('account') ? ' is-invalid' : '' }}" name="account"
                               value="{{ old('account') }}" required autofocus placeholder="{{ __('PhoneOrEmail') }}">

                        @if ($errors->has('account'))
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('account') }}</strong>
                                    </span>
                        @endif
                    </div>

                    <div class="form-group">
                        <input id="password" type="password"
                               class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                               name="password" required placeholder="{{ __('Password') }}">

                        @if ($errors->has('password'))
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                        @endif
                    </div>



                    <div class="form-group">
                        <button type="submit" class="login-btn">
                            {{ __('Bind Account') }}
                        </button>

                    </div>

                    <div class="form-group row mb-0">
                        <div class="col-12 col-sm-6 col-lg-6">
                            @if (Route::has('register'))
                                <a class="btn btn-link register" href="{{ route('register') }}">
                                    {{ __('No account? Register now') }}
                                </a>
                            @endif
                        </div>
                    </div>
                </form>
            </div>

            <div class="col-12 col-sm-5 col-lg-5 col-xl-4 bg-three">
                @include('auth._social')
            </div>
        </div>
    </div>
@endsection
