<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="logged-in" content="{{ Auth::user() ? 'yes' : 'no' }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <script src="{{ asset('js/app.js') }}" defer></script>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
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
    @include('app.partials.burger-menu')
    <div class="nav-placeholder"></div>
    @include('app.partials.top-menu')
    <main>
        @yield('content')
    </main>
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-1"></div>
                <div class="col-md-5">
                    <div class="contact">
                        Adresse: Linke Wienzeile 40, 1060 Wien<br/>
                        Telefon: <a href="tel:+4315875464">01 587 54 64</a><br/>
                        E-Mail-Adresse: <a href="mailto:office@t-on.at">office@t-on.at</a>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="social">
                        <a href="https://www.facebook.com/t.on.vienna" target="_blank">
                            @svg('assets/icons/facebook.svg')
                        </a>
                        <a href="https://www.instagram.com/t_on.studio/" target="_blank">
                            @svg('assets/icons/instagram.svg')
                        </a>
                    </div>
                    <div class="links">
                        <a href="https://t-on.at/datenschutzerklaerung">Datenschutzerklärung</a>
                        <a href="https://t-on.at/impressum">Impressum</a>
                    </div>
                </div>
                <div class="col-md-1"></div>
            </div>
        </div>
    </footer>

    <div class="copyright">
        <div class="container">
            <span class="copyright-text">© Cebul e.U. 2020</span>
            <span class="funding">Gefördert durch die Wirtschaftsagentur Wien. Ein Fonds der Stadt Wien. <img class="funding-logo" src="assets/images/funding-logo.jpg"></span>
        </div>
    </div>
    <div class="hidden">
        <popup name="login" ref="loginPopup" class="login-popup">
            <popup-close-button></popup-close-button>
            @include('app.partials.login')
        </popup>
        @include('app.partials.static-data')
    </div>
</div>
</body>
</html>
