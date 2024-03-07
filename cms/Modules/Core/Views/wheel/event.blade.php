<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, maximum-scale=1">
    <meta name="format-detection" content="telephone=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>LI XI MAY MAN</title>
    <meta name="description" content="">
    <meta name="keywords" content="">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="{{ cxl_asset('assets/css/lucky_wheel.css') }}" rel="stylesheet">
</head>

<body class="lucky_wheel">
@if(!in_array(auth()->id(), $globalData['listUserPlay']))
    <h1 style="font-size: 30px; color: red">
        Bạn không có quyền truy cập trang này.
    </h1>
@else
    <div id="main">
        <div class="thumb_volume">
            <img src="{{ cxl_asset('/assets/img/wheel/volume.png') }}" alt="volume" width="48" height="48">
        </div>
        <div class="thumb_mute">
            <img src="{{ cxl_asset('/assets/img/wheel/mute.png') }}" alt="mute" width="48" height="48">
        </div>
        <audio controls id="audio_main">
            <source src="{{ cxl_asset('/assets/img/wheel/nhac.mp3') }}">
        </audio>
        <div class="inner">
            <h1 class="util_pc">HAPPY NEW YEAR・HAPPY NEW YEAR・HAPPY NEW YEAR・HAPPY NEW YEAR・HAPPY NEW YEAR・</h1>
            <h1 class="util_sp">HAPPY NEW YEAR・HAPPY NEW YEAR・HAPPY NEW YEAR・</h1>
            <section class="section" id="about_us">
                <audio controls id="audio_wheel">
                    <source src="{{ cxl_asset('/assets/img/wheel/wheel.wav') }}">
                </audio>
                <div class="inner">
                    <div class="frog">
                        <img src="{{ cxl_asset('/assets/img/wheel/frog.png') }}" width="712" height="864" alt="frog">
                        <div class="thumb line1">
                            <img src="{{ cxl_asset('/assets/img/wheel/firework.png') }}" width="312" height="294"
                                 alt="firework">
                        </div>
                    </div>
                    <div class="thumb number_1">
                        <img src="{{ cxl_asset('/assets/img/wheel/number1.png') }}" width="335" height="541" alt="number">
                    </div>
                    <div class="thumb number_2">
                        <img src="{{ cxl_asset('/assets/img/wheel/number2.png') }}" width="333" height="541" alt="number">
                    </div>
                    <div class="thumb number_3">
                        <img src="{{ cxl_asset('/assets/img/wheel/number3.png') }}" width="332" height="541" alt="number">
                    </div>
                    <div class="thumb number_4">
                        <img src="{{ cxl_asset('/assets/img/wheel/number4.png') }}" width="332" height="541" alt="number">
                    </div>
                    <div class="title_img">
                        <img src="{{ cxl_asset('/assets/img/wheel/title.png') }}" width="2188" height="784" alt="title">
                    </div>
                </div>
            </section>
            <!-- /ablout_us -->
            <section id="luckywheel" class="hc_luckywheel">
                <div class="inner">
                    <div class="thumb">
                        <img src="{{ cxl_asset('/assets/img/wheel/arrow.png') }}" width="232" height="335" alt="arrow">
                    </div>
                    <div class="hc_luckywheel_container">
                        <canvas class="hc-luckywheel-canvas" width="500px" height="500px">Vòng Xoay May Mắn</canvas>
                    </div>
                    <div class="btn-start">
                        <div class="between">
                        </div>
                    </div>
                    <a class="hc-luckywheel-btn" href="javascript:;">
                        <img src="{{ cxl_asset('/assets/img/wheel/start.png') }}" width="255" height="185" alt="start">
                    </a>
                    <p class="txt_messenger">Bạn còn <span id="timesSpin"></span> lượt quay lì xì</p>
                </div>
            </section>
            <section class="section" id="popup">
                <div class="inner">
                    <div class="message">
                        <div class="thumb close">
                            <img src="{{ cxl_asset('/assets/img/wheel/close.svg') }}" width="21" height="19" alt="close">
                        </div>
                        <h4 class="text_money"></h4>
                        <h5><span id="money"></span></h5>
                    </div>
                </div>
            </section>
            <section class="section" id="notification">
                <div class="inner">
                    <h3>THÔNG BÁO</h3>
                    <div class="txt_desp">
                        <ul class="notification">
                            <li>
                                <div class="thumb"><img src="{{ cxl_asset('/assets/img/wheel/gift1.png') }}" alt=""></div>
                                <p></p>
                            </li>
                        </ul>
                    </div>
                    <div class="thumb gift1">
                        <img src="{{ cxl_asset('/assets/img/wheel/group_gift2.png') }}" width="313" height="370" alt="gift">
                    </div>
                    <div class="thumb gift2">
                        <img src="{{ cxl_asset('/assets/img/wheel/group_gift1.png') }}" width="313" height="370" alt="gift">
                    </div>
                </div>
            </section>
        </div>
        <div class="bgr_under"></div>
    </div>
@endif
<!-- /footer -->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
<script defer type="text/javascript" src="{{ cxl_asset('/assets/libs/wheel/js/jquery-3.6.0.min.js') }}"></script>
<script defer type="text/javascript" src="{{ cxl_asset('/assets/libs/wheel/js/jquery.validate.min.js') }}"></script>
<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script src="{{ cxl_asset('/assets/js/components/wheel/hc-canvas-luckwheel.js') }}"></script>
<script src="{{ cxl_asset('/assets/js/components/wheel/confetti.js') }}"></script>
<script src="{{ cxl_asset('/assets/js/components/wheel/main.js') }}"></script>
<script src="{{ cxl_asset('/assets/js/components/wheel/login.js') }}"></script>

<script>
    const start = () => {
        setTimeout(function () {
            confetti.start()
        });
    };
    start();

    var userLogin = @json($userLogin);
</script>
</body>
</html>

