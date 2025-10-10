<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login V2</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--===============================================================================================-->
    <link rel="icon" type="image/png" href={{asset("/loginAsset/images/icons/favicon.ico")}}/>
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href={{asset("/loginAsset/vendor/bootstrap/css/bootstrap.min.css")}}>
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href={{asset("/loginAsset/fonts/font-awesome-4.7.0/css/font-awesome.min.css")}}>
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href={{asset("/loginAsset/fonts/iconic/css/material-design-iconic-font.min.css")}}>
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href={{asset("/loginAsset/vendor/animate/animate.css")}}>
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href={{asset("/loginAsset/vendor/css-hamburgers/hamburgers.min.css")}}>
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href={{asset("/loginAsset/vendor/animsition/css/animsition.min.css")}}>
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href={{asset("/loginAsset/vendor/select2/select2.min.css")}}>
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href={{asset("/loginAsset/vendor/daterangepicker/daterangepicker.css")}}>
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href={{asset("/loginAsset/css/util.css")}}>
    <link rel="stylesheet" type="text/css" href={{asset("/loginAsset/css/main.css")}}>


    {{--helper Asset--}}
    <link rel="stylesheet" type="text/css" href={{asset("/helperAsset/toastyfy.min.css")}}>
    <link rel="stylesheet" type="text/css" href={{asset("/helperAsset/loader.css")}}>
    <script src={{asset("/helperAsset/axios.min.js")}}></script>
    <script src={{asset("/helperAsset/toastity.min.js")}}></script>
    <script src={{asset("/helperAsset/config.js")}}></script>

    <!--===============================================================================================-->
</head>
<body>

<!-- Fullscreen Loader -->
<div id="loader-wrapper" class="loader-wrapper" style="display: none;">
    <span class="loader"></span>
</div>

<div class="limiter">
    <div class="container-login100">
        <div class="wrap-login100">

        @yield('main-section')
        </div>
    </div>
</div>


<div id="dropDownSelect1"></div>

<!--===============================================================================================-->
<script src={{asset("/loginAsset/vendor/jquery/jquery-3.2.1.min.js")}}></script>
<!--===============================================================================================-->
<script src={{asset("/loginAsset/vendor/animsition/js/animsition.min.js")}}></script>
<!--===============================================================================================-->
<script src={{asset("/loginAsset/vendor/bootstrap/js/popper.js")}}></script>
<script src={{asset("/loginAsset/vendor/bootstrap/js/bootstrap.min.js")}}></script>
<!--===============================================================================================-->
<script src={{asset("/loginAsset/vendor/select2/select2.min.js")}}></script>
<!--===============================================================================================-->
<script src={{asset("/loginAsset/vendor/daterangepicker/moment.min.js")}}></script>
<script src={{asset("/loginAsset/vendor/daterangepicker/daterangepicker.js")}}></script>
<!--===============================================================================================-->
<script src={{asset("/loginAsset/vendor/countdowntime/countdowntime.js")}}></script>
<!--===============================================================================================-->
<script src={{asset("/loginAsset/js/main.js")}}></script>


</body>
</html>


