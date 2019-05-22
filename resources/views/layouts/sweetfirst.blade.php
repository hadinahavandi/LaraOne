<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>سامانه ارتباط با کارکنان عقیدتی و سیاسی قرارگاه پدافند هوایی خاتم الانبیا</title>
    <link
            rel="stylesheet"
            href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600"
    />
    <!-- https://fonts.google.com/specimen/Open+Sans -->
    <link rel="stylesheet" href="/css/all.min.css" />
    <!-- https://fontawesome.com/ -->
    <link rel="stylesheet" href="/css/bootstrap.min.css" />
    <!-- https://getbootstrap.com/ -->
    <link rel="stylesheet" href="/css/tooplate-style.css" />
    <!--
Tooplate 2111 Pro Line
http://www.tooplate.com/view/2111-pro-line
-->
</head>

<body>
<!-- page header -->
<div class="container" id="home">
    <div class="col-12 text-center">
        <img src="/img/title-contact.png">
        <div class="tm-page-header">
        </div>
    </div>
</div>
<!-- navbar -->
<div class="tm-nav-section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <nav class="navbar navbar-expand-md navbar-light">
                    <button
                            class="navbar-toggler"
                            type="button"
                            data-toggle="collapse"
                            data-target="#tmMainNav"
                            aria-controls="tmMainNav"
                            aria-expanded="false"
                            aria-label="Toggle navigation"
                    >
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="tmMainNav">
                        <ul class="navbar-nav mx-auto tm-navbar-nav">
                            <li class="nav-item active">
                                <a class="nav-link" href="/"
                                >صفحه اصلی </a
                                >
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/contactus/messages/Send">ارسال پیام</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/contactus/messages/find">پیگیری پیام ها</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/login">ورود به سامانه</a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
    </div>
</div>
<!-- Activities -->
<div class="container" id="activities">
    <div class="row">

        @yield('content')
    </div>
</div>
<footer class="container tm-footer">
    <div class="row tm-footer-row">
        <p class="col-md-10 col-sm-12 mb-0">
            تمامی حقوق برای قرارگاه پدافند هوایی خاتم الانبیا محفوظ می باشد.
        </p>
        <div class="col-md-2 col-sm-12 scrolltop">
            <div class="scroll icon"><i class="fa fa-4x fa-angle-up"></i></div>
        </div>
    </div>
</footer>

<script src="/js/jquery-1.9.1.min.js"></script>
<!-- Single Page Nav plugin works with this version of jQuery -->
<script src="/js/jquery.singlePageNav.min.js"></script>
<script src="/js/bootstrap.min.js"></script>
<script>
    /**
     * detect IE
     * returns version of IE or false, if browser is not Internet Explorer
     */
    function detectIE() {
        var ua = window.navigator.userAgent;

        var msie = ua.indexOf("MSIE ");
        if (msie > 0) {
            // IE 10 or older => return version number
            return parseInt(ua.substring(msie + 5, ua.indexOf(".", msie)), 10);
        }

        var trident = ua.indexOf("Trident/");
        if (trident > 0) {
            // IE 11 => return version number
            var rv = ua.indexOf("rv:");
            return parseInt(ua.substring(rv + 3, ua.indexOf(".", rv)), 10);
        }

        // var edge = ua.indexOf('Edge/');
        // if (edge > 0) {
        //     // Edge (IE 12+) => return version number
        //     return parseInt(ua.substring(edge + 5, ua.indexOf('.', edge)), 10);
        // }

        // other browser
        return false;
    }



    $(window).scroll(function() {
        if ($(this).scrollTop() > 50) {
            $(".scrolltop:hidden")
                .stop(true, true)
                .fadeIn();
        } else {
            $(".scrolltop")
                .stop(true, true)
                .fadeOut();
        }

        // Make sticky header
        if ($(this).scrollTop() > 158) {
            $(".tm-nav-section").addClass("sticky");
        } else {
            $(".tm-nav-section").removeClass("sticky");
        }
    });
</script>
</body>
</html>