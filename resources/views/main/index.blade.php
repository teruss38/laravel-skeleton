@extends('layouts.app')

@push('head')
    <meta property="og:title" content="{{ settings('system.title') }}" />
    <meta property="og:description" content="{{settings('system.description')}}" />
    <meta property="og:url" content="{{ config('app.url') }}" />
    <meta property="og:image" content="{{ asset('img/logo.png') }}" />
    <meta property="og:type" content="website" />
    <meta property="og:site_name" content="{{ config('app.name', 'Larva') }}" />
@endpush

@section('content')
    这是首页


        <div class="row">
            <div class="col-md-12">
                <div class="side_box mb-3">
                    <div class="box-header">
                        <div class="box-title">友情链接</div>
                    </div>
                    <div class="box-body">
                        <x-link type="home"/>
                    </div>
                </div>
            </div>
        </div>
@endsection
