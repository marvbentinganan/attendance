<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="{{ asset('storage/logo.png') }}" id="favicon">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }} | @yield('title')</title>

    <!-- Styles -->
    <link href="{{ asset('css/semantic-ui/semantic.min.css') }}" rel="stylesheet">
    <link href="{{ asset('plugins/ionicons/css/ionicons.min.css') }}" rel="stylesheet">
    <script src="{{ asset('js/jquery-3.2.1.min.js') }}"></script>
    <style>
        html,
        body {
            height: 100%;
        }

        body {
            min-height: 100vh;
            flex-direction: column;
        }
    </style>
</head>

<body>
    @include('partials.main_navigation')
    <div class="ui centered middle aligned grid container" style="flex: 1; width: 100% !important; height: 100% !important; margin: 0 !important;">
        @yield('content')
    </div>
    <!-- Scripts -->
    <script src="{{ asset('js/semantic-ui/semantic.min.js') }}"></script>
    <footer>
        @stack('footer_scripts')
    </footer>
</body>

</html>
