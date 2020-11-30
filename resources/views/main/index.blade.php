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
@endsection
