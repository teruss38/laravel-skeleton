@extends('layouts.app')

@section('title', __('User Profile'))

@section('content')
    <div class="container  py-4">
        <div class="row">
            <!--左侧菜单-->
            <div id="secondary" class="col-12 col-md-3">
                @include('settings._menu')
            </div>

            <div id="main" class="settings col-12 col-md-9">
                <settings-profile></settings-profile>
            </div>
        </div>
    </div>
@endsection
