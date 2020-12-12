@extends('layouts.app')

@push('head')
    <meta property="og:title" content="{{ settings('system.title') }}"/>
    <meta property="og:description" content="{{settings('system.description')}}"/>
    <meta property="og:url" content="{{ config('app.url') }}"/>
    <meta property="og:image" content="{{ asset('img/logo.png') }}"/>
    <meta property="og:type" content="website"/>
    <meta property="og:site_name" content="{{ config('app.name', 'Larva') }}"/>
@endpush

@section('content')
    <div class="container my-3">
        <div class="row">
            <div class="d-block bg-white p-2 col-xs-12 col-sm-12 col-md-12 col-lg-6">
                <x-widgets.home-carousel/>
            </div>
            <div class="d-none d-lg-block p-2 col-lg-6 bg-white">
                <div class="row">
                    <div class="p-1 col-12 col-lg-6">
                        <a href="#" target="_blank">
                            <img class="d-block w-100" src="{{asset('img/ads/empty.jpg')}}" alt="#">
                        </a>
                    </div>
                    <div class="p-1 col-12 col-lg-6">
                        <a href="#" target="_blank">
                            <img class="d-block w-100" src="{{asset('img/ads/empty.jpg')}}" alt="#">
                        </a>
                    </div>
                    <div class="w-100 d-none d-md-block"></div>

                    <div class="p-1 col-12 col-lg-6">
                        <a href="#" target="_blank">
                            <img class="d-block w-100" src="{{asset('img/ads/empty.jpg')}}" alt="#">
                        </a>
                    </div>
                    <div class="p-1 col-12 col-lg-6">
                        <a href="#" target="_blank">
                            <img class="d-block w-100" src="{{asset('img/ads/empty.jpg')}}" alt="#">
                        </a>
                    </div>
                </div>



            </div>
        </div>
    </div>

    <div class="container">
        <div class="row mb-3">
            <div class="d-block bg-white col-xs-12 col-sm-12 col-md-12 col-lg-9">
                <nav class="home_tab">
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <a class="nav-item nav-link active" id="nav-main-tab" data-toggle="tab" href="#nav-main"
                           role="tab" aria-controls="nav-main" aria-selected="true">最新</a>
                        <a class="nav-item nav-link" id="nav-news-tab" data-toggle="tab" href="#nav-news" role="tab"
                           aria-controls="nav-news" aria-selected="false">最新</a>
                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-main" role="tabpanel" aria-labelledby="nav-main-tab">
                        <x-widgets.home-article limit="10"/>
                    </div>
                </div>
            </div>

            <div class="d-none d-lg-block pr-0 col-lg-3">
                @include('layouts._side')
            </div>
        </div>

        <x-widgets.home-link/>
    </div>
@endsection
