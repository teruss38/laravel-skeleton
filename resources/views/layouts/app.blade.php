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
    <meta name="format-detection" content="telephone=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="Description" content="@yield('description', settings('system.description'))">
    <meta name="Keywords" content="@yield('keywords', settings('system.keywords'))">
    <title>@yield('title', settings('system.title'))@if (request()->path() != '/') - {{ config('app.name', 'Laravel') }}@endif</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @stack('head')
</head>
<body>
    <div id="app">
        <!-- Header -->
        @include('layouts._header')
        <!-- End Header -->
        @yield('jumbotron')

        <main class="py-4">
            @yield('content')
        </main>
        <!-- Copyright Footer -->
        @include('layouts._footer')
        <!-- End Copyright Footer -->
    </div>
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    @stack('scripts')
@stack('footer')
</body>
</html>
