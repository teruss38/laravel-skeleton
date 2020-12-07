@extends('layouts.app')

@section('title', __('Register'))

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Username') }}</label>

                            <div class="col-md-6">
                                <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="username" autofocus>

                                @error('username')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
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

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <input type="hidden" name="ticket" id="ticket" value="">
                                <input type="hidden" name="randstr" id="randstr" value="">
                                <button @if (config('app.env') != 'testing' && settings('user.enable_login_ticket')) type="button" @else type="submit" @endif class="btn btn-primary" id="TencentCaptcha" data-appid="{{settings('system.captcha_aid')}}" data-cbfn="captchaCallback">
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
                        </div>
                    </form>
                </div>
            </div>
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
                document.getElementById('register_form').submit();
            }
        }
    </script>
    @endif
@endpush
