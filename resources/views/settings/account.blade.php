@extends('layouts.app')

@section('title', __('User Account'))

@push('footer')
    <!-- 腾讯防水墙 -->
    <script src="https://ssl.captcha.qq.com/TCaptcha.js"></script>
@endpush

@section('content')
    <div class="container  py-4">
        <div class="row">
            <!--左侧菜单-->
            <div id="secondary" class="col-12 col-md-3">
                @include('settings._menu')
            </div>

            <div id="main" class="settings col-12 col-md-9">
                <settings-account></settings-account>
            </div>
        </div>
    </div>
@endsection
