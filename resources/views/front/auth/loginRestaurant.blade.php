@extends('front.index')
@section('content')
    <link rel="stylesheet" href="{{asset('')}}front/css/pagesStyle.css">
    <link href="https://fonts.googleapis.com/css?family=Cairo&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('')}}front/css/bootstrap.min.css">
    {{--    <link rel="stylesheet" type="text/css" href="{{asset('')}}front/css/bootstrap-rtl.css">--}}

    <!-- pop up -->
    <div class="meal-pop-up">
        <div class="pop-up-content">

            <h3 class="text-center">كيف تريد الاستمرار ؟</h3>
            <span class="close-pop-up"><i class="fas fa-times"></i></span>
            <a href="{{route('register.client')}}">
                <button class="btn mx-auto f-btn">طلب طعام</button>
            </a>
            <a href="{{route('register.restaurant')}}">
                <button class="btn mx-auto">بيع طعام</button>
            </a>
        </div>
    </div>
    <!-- end pop up -->


    <!--start register-->
    <section class="register_seller register2">
        <div class="container">
            @include('flash::message')
            <div class="reg-content mx-auto center-block">
                <div class="user-icon">
                    <i class="far fa-user"></i>
                </div>
                <form class="pt-3" method="post" action="{{url(route('front.restaurant.login'))}}">
                    {!! csrf_field() !!}
                    <div class="form-group">
                        <input type="email" name="email" class="form-control" id="exampleInputEmail1"
                               placeholder="البريد الالكترونى">
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" class="form-control" id="exampleInputText1"
                               aria-describedby="emailHelp"
                               placeholder="الرقم السرى">
                    </div>

                    <button type="submit" class="mx-auto btn">دخول</button>

                    <div class="reg-option">
                        {{--                        <span> <a href="register.html"> مستخدم جديد؟ </a></span>--}}
                        <span> <a href="{{route('auth.resetRestaurant')}}"> نسيت كلمة السر؟ </a></span>
                    </div>

                    <div class="text-center">
                        <button type="button" style="display: inline" class="mx-auto btn pop-btn ">إنشاء حساب جديد</button>
                        <button type="button" style="display: inline" class="mx-auto btn">
                            <span> <a href="{{route('front.client.get')}}"> تسجيل الدخول كمستخدم </a></span>
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </section>
    <!--end register-->

@endsection