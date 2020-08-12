<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-dns-prefetch-control" content="on">
    <meta http-equiv="Cache-Control" content="no-transform"/>
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="Description" content="@yield('description', __('Description'))">
    <meta name="Keywords" content="@yield('keywords', __('Keywords'))">
    <title>@yield('title', __('Title'))@if (request()->path() != '/') - {{ config('app.name', 'Laravel') }}@endif</title>
    <!-- Styles -->
    <link href="{{ asset(mix('/css/app.css')) }}" rel="stylesheet">
    @stack('head')
</head>
<body>
    <div id="app">
        <!-- Header -->
        @include('layouts._header')
        <!-- End Header -->
        @yield('jumbotron')

        <main class="py-2">
            @yield('content')
        </main>
        <!-- Copyright Footer -->
        @include('layouts._footer')
        <!-- End Copyright Footer -->
    </div>
    <!-- Scripts -->
<script src="{{ asset(mix('/js/manifest.js')) }}"></script>
<script src="{{ asset(mix('/js/vendor.js')) }}"></script>
<script src="{{ asset(mix('/js/app.js')) }}"></script>
    @stack('footer')
</body>
</html>
