<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Argon Dashboard') }}</title>
    <!-- Favicon -->
    <link href="{{ asset('argon') }}/img/brand/favicon.png" rel="icon" type="image/png">
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
    <!-- Extra details for Live View on GitHub Pages -->

    <!-- Icons -->
    <link href="{{ asset('argon') }}/vendor/nucleo/css/nucleo.css" rel="stylesheet">
    <link href="{{ asset('argon') }}/vendor/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet">
    <!-- Argon CSS -->
    <link type="text/css" href="{{ asset('argon') }}/css/argon.css?v=1.0.0" rel="stylesheet">
    <link type="text/css" href="{{ cxl_asset('/css/argon_custom.css')}}" rel="stylesheet">
    @stack('style')
</head>
<body class="{{ $class ?? '' }}">
@auth()
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
    @include('Core::layouts.navbars.sidebar')
@endauth
<div class="main-content">
    @if(auth()->check())
        @if(count($globalNotification) > 0)
            <div class="notification-wrapper d-flex flex-row">
                <div class="advertise">
                    <img class="ml-3 mt-1 advertise-menu" style="height: 30px" src="{{ cxl_asset('assets/img/icons/icon-speaker.png') }}"/>
                </div>
                <div class="advertise w-100 mr-2" style="display: flex; align-items: center;">
                    <marquee>
                        <div style="display: flex; align-items: center; vertical-align: center">
                            <strong class="text-white mr-4">Thông báo hôm nay: </strong>
                            @foreach($globalNotification as $notification)
                                <p style="margin-bottom: 0; margin-right: 50px"><i class="ni ni-tag text-success mr-2"></i>{{ $notification->content }}</p>
                            @endforeach
                        </div>
                    </marquee>
                </div>
            </div>
        @endif
    @endif
    @include('Core::layouts.navbars.navbar')
    @yield('content')
</div>

@guest()
    @include('Core::layouts.footers.guest')
@endguest

<script src="{{ asset('argon') }}/vendor/jquery/dist/jquery.min.js"></script>
<script src="{{ asset('argon') }}/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('argon') }}/vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>

@stack('js')

<!-- Argon JS -->
<script src="{{ asset('argon') }}/js/argon.js?v=1.0.0"></script>
</body>
</html>
<style>
    .notification-wrapper {
        background: red;
        position: relative;
        font-size: 18px;
        line-height: unset;
        padding: 6px 10px;
        color: #ffffff;
        z-index: 999999;
    }
</style>
