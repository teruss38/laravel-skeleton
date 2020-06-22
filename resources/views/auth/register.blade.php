@extends('layouts.app')

@section('title', __('Register'))

@section('content')
    <div class="container py-6 login-box">
        <div class="row justify-content-center shadow ">
            <div class="col-12 col-sm-7 col-lg-7 col-xl-8 login-bg">
                <h4 class="mb-3">{{ __('Register') }}</h4>
                <form method="POST" id="register_form" action="{{ route('register') }}">
                    @csrf
                    <div class="form-group">
                        <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" placeholder="{{ __('Nickname') }}" required autocomplete="username" autofocus>

                        @error('username')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required placeholder="{{ __('E-Mail Address') }}" autocomplete="email">

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
                        <input id="password-confirm" type="password" class="form-control @error('password') is-invalid @enderror" name="password_confirmation"  placeholder="{{ __('Confirm Password') }}" required autocomplete="new-password">
                    </div>

                    <div class="form-group">
                        <div class="form-check">
                            <input class="form-check-input @error('terms') is-invalid @enderror" type="checkbox" name="terms"
                                   id="terms" {{ old('terms') ? 'checked' : '' }}>

                            <label class="form-check-label" for="terms">
                                同意 <a href="{{ url('terms') }}" target="_blank">服务条款</a> 和 <a href="{{ url('privacy') }}" target="_blank">隐私政策</a>
                            </label>
                            @error('terms')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group mb-0">
                        <input type="hidden" name="ticket" id="ticket" value="">
                        <input type="hidden" name="randstr" id="randstr" value="">
                        <button type="button" class="login-btn" id="TencentCaptcha" data-appid="{{config('services.captcha.register.aid')}}" data-cbfn="captchaCallback">
                            {{ __('Register') }}
                        </button>

                        @if (Route::has('mobile.register'))
                            <a class="btn btn-link" href="{{ route('mobile.register') }}">
                                {{ __('Mobile Register') }}
                            </a>
                        @endif

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

@push('footer')
    <!-- 腾讯防水墙 -->
    <script src="https://ssl.captcha.qq.com/TCaptcha.js"></script>
    <script>
        window.captchaCallback = function(res) {
            if (res.ret === 0) {
                document.getElementById("ticket").value = res.ticket;
                document.getElementById("randstr").value = res.randstr;
                document.getElementById('register_form').submit();
            }
        }
    </script>
@endpush
