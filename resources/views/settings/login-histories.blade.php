@extends('layouts.app')

@section('title', __('Login Histories'))

@section('content')
    <div class="container  py-4">
        <div class="row">
            <!--左侧菜单-->
            <div id="secondary" class="col-md-3">
                @include('settings._menu')
            </div>

            <div id="main" class="settings col-md-9 form-horizontal">
                <settings-login-histories></settings-login-histories>
            </div>
        </div>
    </div>
@endsection
