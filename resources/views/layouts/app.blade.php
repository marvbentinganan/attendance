<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    {{-- <script src="{{ asset('js/app.js') }}" defer></script> --}}
    <script src="{{ asset('js/jquery-3.2.1.min.js') }}"></script>
    @stack('header_scripts')

    <!-- Fonts -->

    <!-- Styles -->
    <link href="{{ asset('css/semantic-ui/semantic.min.css') }}" rel="stylesheet">
    <link href="{{ asset('plugins/ionicons/css/ionicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('plugins/toastr/css/toastr.min.css') }}" rel="stylesheet">
</head>

<body>
    <div id="app" style="padding-top: 20px;">
    @include('partials.main_navigation')
        <div class="ui stackable very padded grid">
            <div class="three wide computer only four wide tablet only column">
                @yield('left')
            </div>
            <div class="sixteen wide mobile only nine wide computer only twelve wide tablet only column">
                @yield('content')
            </div>
            <div class="four wide computer only column">
                @yield('right')
            </div>
        </div>
    </div>

    <script src="{{ asset('js/semantic-ui/semantic.min.js') }}"></script>
    <script src="{{ asset('plugins/sweetalert2/sweetalert2.all.js') }}"></script>
    <script src="{{ asset('plugins/toastr/js/toastr.min.js') }}"></script>

    <script>
        function confirm(){
            swal({ title: 'Are you sure?',
            text: "You will be logged out of the system",
            type: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes' })
            .then((result) => {
                if (result.value){
                    $('#logout').submit();
                }
            })
        }
        $('.dropdown').dropdown();
    </script>
    @stack('footer_scripts')
</body>

</html>
