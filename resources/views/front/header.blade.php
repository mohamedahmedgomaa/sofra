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

    <link href="{{asset('')}}front/css/owl.carousel.min.css" rel="stylesheet">
    <link href="{{asset('')}}front/css/owl.theme.default.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.rtlcss.com/bootstrap/v4.2.1/css/bootstrap.min.css" integrity="sha384-vus3nQHTD+5mpDiZ4rkEPlnkcyTP+49BhJ4wJeJunw06ZAp+wzzeBPUXr42fi8If" crossorigin="anonymous">
    <!--my style-->
    <link href="{{asset('')}}front/css/style.css" rel="stylesheet">
    <!--my style-->
</head>
<!--fontawesome js-->
<script src="{{asset('')}}front/js/all.min.js"></script>
<body>

<!--================================START NAVBAR=================================-->
<nav class="navbar navbar-light bg-light row">

    <div class="navbar-search col-5">

        <a href="{{route('client.shoppingCart')}}" class="cart-link">
            <i class="fas fa-shopping-cart mx-2"></i>
            <span style="font-size: 18px">{{Session::has('cart') ? Session::get('cart')->totalQty : ''}}</span>
        </a>
        @if(auth()->guard('client')->check())
            <div class="dropdown mx-2">
                <span class="btn dropdown-toggle m-0" id="dropdownMenuButton" data-toggle="dropdown"
                      aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-user-circle"></i>
                </span>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="{{route('client.orders')}}" style="display: inline-block">
                        <i class="fas fa-clipboard-list"></i>
                        طلباتى
                    </a>
                    <a class="dropdown-item" href="{{route('client.offers')}}" style="display: inline-block">
                        <i class="fas fa-gift"></i>
                        العروض
                    </a>
                    <a href="{{route('contactUs')}}" class="dropdown-item" style="display: inline-block">
                        <i class="fas fa-envelope-square"></i>
                        تواصل معنا
                    </a>
                    <a href="{{route('client.profile',auth('client')->user()->id)}}" class="dropdown-item" style="display: inline-block">
                        <i class="far fa-user"></i>
                        حسابى
                    </a>
                    <a href="{{url('logoutClient')}}" class="dropdown-item" style="display: inline-block">
                        <i class="fas fa-sign-out-alt"></i>
                        تسجيل الخروج
                    </a>
                </div>
                <!--dropdown-menu-->
            </div>
            <!--dropdown-->
        @else
            <div class="dropdown mx-2">
            <span class="btn dropdown-toggle m-0" id="dropdownMenuButton" data-toggle="dropdown"
                  aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-user-circle"></i>
                </span>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a href="{{route('contactUs')}}" class="dropdown-item" style="display: inline-block">
                        <i class="fas fa-envelope-square"></i>
                        تواصل معنا
                    </a>
                    <a href="{{route('front.client.get')}}" class="dropdown-item" style="display: inline-block">
                        <i class="fas fa-sign-out-alt"></i>
                        تسجيل الدخول كمستخدم
                    </a>
                </div>
                <!--dropdown-menu-->
            </div>
            <!--dropdown-->
        @endif
        <div class="search_box">
            <input type="search" class="form-control mr-sm-2">
            <i class="fas fa-search"></i>
        </div>

    </div>
    <!--navbar-search-->


    <a class="navbar-brand col-2" href="{{route('index')}}"><img
                src="{{asset('')}}front/img/images/sofra logo-1.png"></a>


    <button class="navbar-toggler col-4" type="button" data-toggle="collapse" data-target="#navbarsExample01"
            aria-controls="navbarsExample01" aria-expanded="false" aria-label="Toggle navigation">
        <i class="fas fa-hamburger"></i>
    </button>

    @if(auth()->guard('restaurant')->check())
        <div class="collapse navbar-collapse" id="navbarsExample01">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{route('restaurant')}}">الرئيسية</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('restaurant.profile',auth('restaurant')->user()->id)}}">الصفحه الشخصيه</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('restaurant.orders')}}">الطلبات</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('restaurant.offers')}}">العروض</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{url('logoutRestaurant')}}">تسجيل الخروج</a>
                </li>
            </ul>
        </div>
        <!--collapse-->
    @else
        <div class="collapse navbar-collapse" id="navbarsExample01">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{route('front.restaurant.get')}}">تسجيل الدخول كمطعم</a>
                </li>
            </ul>
        </div>
    @endif
</nav>
<div class="text-center">
    <h3>
        @include('flash::message')
    </h3>
</div>
<!--================================END NAVBAR=================================-->
