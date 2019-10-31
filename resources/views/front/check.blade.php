<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>سفرة</title>
    <!--title icon -->
    <link rel="shortcut icon" type="image/png" href="{{asset('')}}front/img/images/sofra logo-1.png">
    <!--fontawesome css-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css"
          integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Lemonada&display=swap" rel="stylesheet">
    <!--css bootstrap-->
    <link rel="stylesheet" href="https://cdn.rtlcss.com/bootstrap/v4.2.1/css/bootstrap.min.css"
          integrity="sha384-vus3nQHTD+5mpDiZ4rkEPlnkcyTP+49BhJ4wJeJunw06ZAp+wzzeBPUXr42fi8If" crossorigin="anonymous">
    <!--my style-->

    <link href="{{asset('')}}front/css/style.css" rel="stylesheet">
</head>
<!--fontawesome js-->
<script src="{{asset('')}}front/js/all.min.js"></script>
<body>
    <header>
        {{--            @if(auth()->guard('client')->check())--}}
        {{--            {{ auth()->guard('client')->user()->name }}--}}
        {{--            @else--}}
        {{--                @endif--}}
        <h1 class="main-heading">سُفرة</h1>
        <h1 class="sub-heading">بتشترى .. بتبيع ؟ كله عند أم ربيع</h1>
        <button type="button" class="btn btn-primary btn-lg">
            <a style="display: inline" class="h2" href="{{url(route('index'))}}">طلب الطعام</a>
            <img src="{{asset('')}}front/img/images/dish.png" class="ml-1" width="20%">
        </button>
        <button type="button" class="btn btn-primary btn-lg">
            <a style="display: inline" class="h2" href="{{url(route('front.restaurant.get'))}}">بيع الطعام</a>
            <img src="{{asset('')}}front/img/images/dish.png" class="ml-1" width="20%">
        </button>
    </header>

    <script src="{{asset('')}}front/js/all.min.js"></script>
    <script src="{{asset('')}}front/JS/jquery-3.2.1.min.js"></script>
    <script src="{{asset('')}}front/JS/popper.min.js"></script>
    <script src="{{asset('')}}front/JS/bootstrap.min.js"></script>
    <script src="{{asset('')}}front/JS/main.js"></script>
    <script src="{{asset('')}}front/js/myJquery.js"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"
            integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
            crossorigin="anonymous"></script>


</body>

</html>