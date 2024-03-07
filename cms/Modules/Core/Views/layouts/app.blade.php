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
    <link href="https://fonts.googleapis.com/css?family=Pridi:600" rel="stylesheet">
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
        @if(count($globalData['notifications']) > 0)
            <div class="notification-wrapper d-flex flex-row">
                <div class="advertise">
                    <img class="ml-3 mt-1 advertise-menu" style="height: 40px"
                         src="{{ cxl_asset('assets/img/icons/icon-speaker.png') }}"/>
                </div>
                <div class="advertise w-100 mr-2" style="display: flex; align-items: center;">
                    <marquee>
                        <div style="display: flex; align-items: center; vertical-align: center">
                            @foreach($globalData['notifications'] as $notification)
                                <strong class="marquee__line"
                                        style="margin-right: 50px">{{ $notification->content }}</strong>
                            @endforeach
                        </div>
                    </marquee>
                </div>
            </div>
        @endif
    @endif

    @include('Core::layouts.navbars.navbar')

    @yield('content')

    @if ($globalData['wheelEventActive'] && $globalData['countPrize'] == 0 && auth()->check() && !auth()->user()->hasRole('admin'))
        <div class="modal fade" id="lucky_wheel" tabindex="-1" role="dialog" aria-labelledby="lucky_wheel"
             aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Thông báo</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-center">
                        <b class="text-center d-flex justify-content-center">Chúc mừng năm mới {{ now()->year }}!</b>
                        <br>
                        <span>Mau mau đến vòng quay may mắn để quay lì xì thôi!</span>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <a type="button" href="{{ route('lucky.wheel.index') }}" class="btn btn-primary">Vòng quay may
                            mắn</a>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

@guest()
    @include('Core::layouts.footers.guest')
@endguest

<script src="{{ asset('argon') }}/vendor/jquery/dist/jquery.min.js"></script>
<script src="{{ asset('argon') }}/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('argon') }}/vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>

@if($globalData['wheelEventActive'])
    @if(auth()->check() && !auth()->user()->hasRole('admin'))
        @if(in_array(auth()->id(), $globalData['listUserPlay']) && $globalData['countPrize'] == 0)
            <script>
                $(document).ready(function() {
                    $('#lucky_wheel').modal('show');
                });
            </script>
        @endif
    @endif
@endif

@stack('js')

<!-- Argon JS -->
<script src="{{ asset('argon') }}/js/argon.js?v=1.0.0"></script>
</body>
</html>
<style>
    .notification-wrapper {
        background: #FFDC00;
        position: relative;
        color: #000000;
        line-height: unset;
        padding: 6px 10px;
        z-index: 999999;
        font-family: "Pridi", sans-serif;
        font-weight: 600;
        font-size: 20px;
        text-transform: uppercase;
    }

    .marquee__line {
        flex-shrink: 0;
        margin: 0;
        min-width: 100%;
        white-space: nowrap;
        animation-name: marqueeLine;
        animation-duration: 25s;
        animation-timing-function: ease-in-out;
    }

    .top-ranking {
        box-shadow: 5px 5px 10px 3px rgba(8, 7, 7, 0.4);
        -webkit-box-shadow: 5px 5px 10px 3px rgba(8, 7, 7, 0.4);
        -moz-box-shadow: 5px 5px 10px 3px rgba(8, 7, 7, 0.4);
    }

    @keyframes marqueeLine {
        from {
            transform: translateX(0);
        }

        to {
            transform: translateX(-100%);
        }
    }
</style>
