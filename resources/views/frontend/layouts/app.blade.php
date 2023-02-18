<!doctype html>
<html lang="{{ htmlLang() }}" @langrtl dir="rtl" @endlangrtl>

<head>
    <meta charset="utf-8">
    <link rel="icon" href="#" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>REMS</title>
    <meta name="description" content="@yield('meta_description', '')">
    <meta name="author" content="@yield('meta_author', 'islamrakib361@gmail.com')">

    @yield('meta')

    @stack('before-styles')

    <link rel="stylesheet" href="{{ asset('css/icons.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <link href="{{ mix('css/frontend.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/rowreorder/1.2.8/css/rowReorder.dataTables.min.css">
    <link rel=" stylesheet" type="text/css"
        href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.dataTables.min.css">
    @stack('after-styles')
</head>

<body
    style="background: url('https://ictd.gov.bd/themes/responsive_npf/images/bg_main.gif') repeat-y scroll center top rgba(0, 0, 0, 0);">

    <noscript>You need to enable JavaScript to run this app.</noscript>

    @include('includes.partials.read-only')
    @include('includes.partials.logged-in-as')

    <main id="app">
        @include('includes.partials.announcements')
        <!-- @include('frontend.includes.slider') -->
        @include('includes.partials.messages')
        @include('frontend.includes.nav')
        @yield('content')
    </main>

    <!-- @include('frontend.includes.footer') -->
    <a href="#" class="scrollup" style="display: none;"><i class="ion-ios-arrow-up"></i></a>
    @stack('before-scripts')
    <script src="{{ mix('js/manifest.js') }}"></script>
    <script src="{{ mix('js/vendor.js') }}"></script>
    <script src="{{ mix('js/frontend.js') }}"></script>
    <script src="{{ asset('js/custom.js') }}"></script>

    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.js"></script>
    <script type="text/javascript" charset="utf8"
        src="https://cdn.datatables.net/rowreorder/1.2.8/js/dataTables.rowReorder.min.js"></script>
    <script type="text/javascript" charset="utf8"
        src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js"></script>
    @include('Alerts::alerts')
</body>

</html>
