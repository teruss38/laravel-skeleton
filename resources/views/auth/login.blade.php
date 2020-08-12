@extends('layouts.app')

@section('title', __('User Login'))

@section('content')
    <div class="container py-4 login-box">
        <div class="row justify-content-center shadow ">
            <div class="col-12 col-sm-7 col-lg-7 col-xl-8 login-bg">
                <h4 class="mb-3">{{ __('Login') }}</h4>
                <form method="POST" id="login_form" action="{{ route('login') }}">
                    @csrf
                    <div class="form-group">
                        <input id="account" type="text"
                               class="form-control @error('account') is-invalid @enderror"
                               name="account" value="{{ old('account') }}" required
                               autocomplete="account" placeholder="{{ __('PhoneOrEmail') }}" autofocus>

                        @error('account')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <input id="password" type="password"
                               class="form-control @error('password') is-invalid @enderror"
                               name="password" required autocomplete="current-password" placeholder="{{ __('Password') }}">

                        @error('password')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember"
                                   id="remember" {{ old('remember') ? 'checked' : '' }}>

                            <label class="form-check-label" for="remember">
                                {{ __('Remember Me') }}
                            </label>
                        </div>
                    </div>

                    <div class="form-group">
                        <input type="hidden" name="ticket" id="ticket" value="">
                        <input type="hidden" name="randstr" id="randstr" value="">
                        <button @if (config('app.env') != 'testing' && settings('user.enable_login_ticket')) type="button" @else type="submit" @endif class="login-btn" id="TencentCaptcha" data-appid="{{config('services.captcha.login.aid')}}" data-cbfn="captchaCallback">
                            {{ __('Login') }}
                        </button>
                    </div>

                    <div class="form-group row mb-0">
                        <div class="col-12 col-sm-6 col-lg-6">
                            @if (Route::has('password.request'))
                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    {{ __('Forgot Your Password?') }}
                                </a>
                            @endif
                        </div>
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

@push('footer')
    @if (config('app.env') != 'testing' && settings('user.enable_login_ticket'))
    <!-- 腾讯防水墙 -->
    <script src="https://ssl.captcha.qq.com/TCaptcha.js"></script>
    <script>
        window.captchaCallback = function(res) {
            if (res.ret === 0) {
                document.getElementById("ticket").value = res.ticket;
                document.getElementById("randstr").value = res.randstr;
                document.getElementById('login_form').submit();
            }
        }
    </script>
    @endif
@endpush
