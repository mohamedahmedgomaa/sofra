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
            <div class="reg-content mx-auto">
                <div class="user-icon">
                    <i class="far fa-user"></i>
                </div>
                <form class="pt-3" method="post" action="{{url(route('front.client.login'))}}">
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
                        <span> <a href="{{route('auth.resetClient')}}"> نسيت كلمة السر؟ </a></span>
                    </div>

                    <div class="text-center">
                        <button type="button" style="display: inline" class="mx-auto btn pop-btn ">إنشاء حساب جديد</button>
                        <button type="button" style="display: inline"    class="mx-auto btn">
                            <span> <a href="{{route('front.restaurant.get')}}"> تسجيل الدخول كمطعم </a></span>
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </section>
    <!--end register-->

    {{--    <main class="register-bg">--}}
    {{--        <section class="register">--}}
    {{--            <div class="form-section">--}}
    {{--                <img src="{{asset('')}}front/img/images/user.png" width="30%">--}}
    {{--                <form class="pt-3" method="post" action="{{url(route('front.login'))}}">--}}
    {{--                    {!! csrf_field() !!}--}}
    {{--                    <div class="form-group">--}}
    {{--                        <input type="email" name="email" class="form-control" id="exampleInputEmail1"--}}
    {{--                        placeholder="البريد الالكترونى">--}}
    {{--                    </div>--}}
    {{--                    <div class="form-group">--}}
    {{--                        <input type="password" name="password" class="form-control" id="exampleInputText1" aria-describedby="emailHelp"--}}
    {{--                               placeholder="الرقم السرى">--}}
    {{--                    </div>--}}
    {{--                    <button type="submit" class="btn btn-primary btn-lg m-3">--}}
    {{--                        <span>دخول</span>--}}
    {{--                    </button>--}}
    {{--                    <div class="links py-5">--}}
    {{--                        <a href="#" class="newUser">--}}
    {{--                            <h5>مستخدم جديد ؟</h5>--}}
    {{--                        </a>--}}
    {{--                        <a href="#" class="forgetPass">--}}
    {{--                            <h5>نسيت كلمة السر ؟</h5>--}}
    {{--                        </a>--}}
    {{--                    </div>--}}
    {{--                    <button type="button"  class="btn btn-primary btn-lg m-3 pop-btn" style="color: #fff;">--}}
    {{--                        <span>إنشأ حساب الان</span>--}}
    {{--                    </button>--}}
    {{--                    <button type="button" class="mx-auto btn pop-btn">إنشاء حساب جديد</button>--}}
    {{--                </form>--}}
    {{--            </div>--}}

    {{--        </section>--}}

    {{--    </main>--}}

@endsection