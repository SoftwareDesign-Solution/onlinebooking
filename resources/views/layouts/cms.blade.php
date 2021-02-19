<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="logged-in" content="{{ Auth::user() ? 'yes' : 'no' }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <script src="{{ asset('js/app.js') }}" defer></script>
    <link href="{{ asset('css/cms.css') }}" rel="stylesheet">
    <link rel="apple-touch-icon" sizes="180x180" href="/assets/favicon/apple-touch-icon.png?v=Gv60B5kMez">
    <link rel="icon" type="image/png" sizes="32x32" href="/assets/favicon/favicon-32x32.png?v=Gv60B5kMez">
    <link rel="icon" type="image/png" sizes="16x16" href="/assets/favicon/favicon-16x16.png?v=Gv60B5kMez">
    <link rel="manifest" href="/assets/favicon/site.webmanifest?v=Gv60B5kMez">
    <link rel="mask-icon" href="/assets/favicon/safari-pinned-tab.svg?v=Gv60B5kMez" color="#ed7b23">
    <link rel="shortcut icon" href="/assets/favicon/favicon.ico?v=Gv60B5kMez">
    <meta name="apple-mobile-web-app-title" content="t-on">
    <meta name="application-name" content="t-on">
    <meta name="msapplication-TileColor" content="#252c35">
    <meta name="msapplication-config" content="/assets/favicon/browserconfig.xml?v=Gv60B5kMez">
    <meta name="theme-color" content="#ed7b23">
</head>
<body>
<div id="app">
    <nav>
        @svg('/assets/icons/logo.svg', 'logo')
        <ul>
            <li class="nav-item {{ str_contains(request()->url(), '/cms/dashboard') ? 'active' : '' }}">
                <a href="{{ url("/cms/dashboard") }}">
                    @svg('/assets/icons/analytics.svg')
                </a>
            </li>
            <li class="nav-item {{ str_contains(request()->url(), '/cms/bookings') ? 'active' : '' }}">
                <a href="{{ url("/cms/bookings") }}">
                    @svg('/assets/icons/calendar.svg')
                </a>
            </li>
            <li class="nav-item {{ str_contains(request()->url(), '/cms/users') ? 'active' : '' }}">
                <a href="{{ url("/cms/users") }}">
                    @svg('/assets/icons/users.svg')
                </a>
            </li>
            <li class="nav-item {{ str_contains(request()->url(), '/cms/rooms') ? 'active' : '' }}">
                <a href="{{ url("/cms/rooms") }}">
                    @svg('/assets/icons/rooms.svg')
                </a>
            </li>
        </ul>
    </nav>
    <main>
        @yield('content')
    </main>
    <div id="sidebar">
        @yield('sidebar')
    </div>
    <div id="hidden">
        @include('app.partials.static-data')
    </div>
</div>
</body>
</html>
