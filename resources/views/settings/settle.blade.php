@extends('layouts.app')

@section('title', __('Settle Accounts'))

@section('content')
    <div class="container  py-4">
        <div class="row">
            <!--左侧菜单-->
            <div id="secondary" class="col-12 col-md-3">
                @include('settings._menu')
            </div>

            <div id="main" class="settings col-12 col-md-9">
                <settings-settle></settings-settle>
            </div>
        </div>
    </div>
@endsection
