@extends('layouts.app')

@section('title', __('Verify Your Email Address'))

@section('content')
    <div class="container py-6 login-box">
        <div class="row justify-content-center shadow ">
            <div class="col-12 login-bg">
                <h4 class="mb-3">{{ __('Verify Your Email Address') }}</h4>
                @if (session('resent'))
                    <div class="alert alert-success" role="alert">
                        {{ __('A fresh verification link has been sent to your email address.') }}
                    </div>
                @endif

                {{ __('Before proceeding, please check your email for a verification link.') }}
                {{ __('If you did not receive the email') }},
                <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                    @csrf
                    <button type="submit"
                            class="btn btn-link p-0 m-0 align-baseline">{{ __('Click here to request another') }}</button>
                    .
                </form>
            </div>
        </div>
    </div>
@endsection
