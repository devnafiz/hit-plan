<!doctype html>
<html lang="{{ htmlLang() }}" @langrtl dir="rtl" @endlangrtl>

<head>
    <meta charset="utf-8">
    <link rel="icon" href="{{ asset('img/logo/' . get_setting('fabicon')) }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ get_setting('app_name_short') }} | @yield('title')</title>
    <meta name="description" content="@yield('meta_description', get_setting('app_name_short'))">
    <meta name="author" content="@yield('meta_author', 'islamrakib361@gmail.com')">
    <meta name="baseURL" content="{{ asset('') }}" />

    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('img/brand/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('uploads/' . get_setting('fabicon')) }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('uploads/' . get_setting('fabicon')) }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" rel="stylesheet">

    @yield('meta')
    <link href="{{ asset('css/select2.css') }}" rel="stylesheet">
    <link href="{{ asset('css/icons.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/plugins/datetimepicker/css/jquery.datetimepicker.min.css') }}">

    @stack('before-styles')
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ mix('css/backend.css') }}" rel="stylesheet">
    <link href="{{ asset('css/admin/adminlte.css') }}" rel="stylesheet">
    <link href="{{ mix('css/admin/extend.css') }}" rel="stylesheet">
    <livewire:styles />
    @stack('after-styles')
</head>

<body class="hold-transition sidebar-mini text-sm">
    @include('includes.partials.announcements')
    <div class="wrapper">
        @include('backend.includes.header')
        @include('backend.includes.sidebar')
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            @include('includes.partials.read-only')
            @include('includes.partials.logged-in-as')

            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-12">
                            @include('backend.includes.partials.breadcrumbs')
                        </div>
                    </div>
                </div> <!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">
                @include('includes.partials.messages')
                @yield('content')
            </section> <!-- /.content -->
        </div> <!-- /.content-wrapper -->
        @include('backend.includes.footer')
    </div> <!-- ./wrapper -->

    @stack('before-scripts')
    <script src="{{ mix('js/manifest.js') }}"></script>
    <script src="{{ mix('js/vendor.js') }}"></script>
    <script src="{{ asset('js/backend.js') }}"></script>
    <script src="{{ asset('js/custom.js') }}"></script>
    <script src="{{ asset('/js/Webcam.js') }}"></script>
    <script src="{{ asset('js/select2.js') }}"></script>
    <script src="{{ asset('assets/plugins/datetimepicker/js/jquery.datetimepicker.full.min.js') }}"></script>
    <script src="" data-turbo-eval="false" data-turbolinks-eval="false">
        window.livewire = new Livewire();
        window.livewire.devTools(true);
        window.Livewire = window.livewire;
        window.livewire_app_url = '';
        window.livewire_token = 'HlPnOXtx6Zn5yybYsgHZzMujkz9wU6DzOQnVh1cv';

        /* Make sure Livewire loads first. */
        if (window.Alpine) {
            /* Defer showing the warning so it doesn't get buried under downstream errors. */
            document.addEventListener("DOMContentLoaded", function() {
                setTimeout(function() {
                    console.warn(
                        "Livewire: It looks like AlpineJS has already been loaded. Make sure Livewire\'s scripts are loaded before Alpine.\\n\\n Reference docs for more info: http://laravel-livewire.com/docs/alpine-js"
                    )
                })
            });
        }

        /* Make Alpine wait until Livewire is finished rendering to do its thing. */
        window.deferLoadingAlpine = function(callback) {
            window.addEventListener('livewire:load', function() {
                callback();
            });
        };

        let started = false;
        window.addEventListener('alpine:initializing', function() {
            if (!started) {
                window.livewire.start();

                started = true;
            }
        });

        document.addEventListener("DOMContentLoaded", function() {
            if (!started) {
                window.livewire.start();

                started = true;
            }
        });
    </script>
    @stack('after-scripts')
</body>

</html>