@extends('front.index')
@section('content')
    <link rel="stylesheet" href="{{asset('')}}front/css/pagesStyle.css">
    <link href="https://fonts.googleapis.com/css?family=Cairo&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('')}}front/css/bootstrap.min.css">
    <!--start register-->
    <section class="register_seller register2">
        <div class="container">
            <div class="reg-content mx-auto">
                <div class="user-icon">
                    <i class="far fa-user"></i>
                </div>
                <form class="pt-3" method="post" action="{{url(route('auth.postNewPasswordRestaurant'))}}">
                    {!! csrf_field() !!}

                    <div class="form-group">
                        <input type="text" name="pin_code" class="form-control" id="exampleInputEmail1"
                               placeholder="رقم الكود">
                    </div>
                    <div class="form-group">
                        <input type="email" name="email" class="form-control" id="exampleInputEmail1"
                        placeholder="البريد الالكترونى">
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" name="password" id="exampleInputPassword1"
                        aria-describedby="passwordHelp" placeholder="كلمة السر">
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" name="password_confirmation"
                        id="exampleInputPassword1" aria-describedby="passwordHelp" placeholder="تأكيد كلمة السر">
                    </div>

                    <button type="submit" class="mx-auto btn">تغيير كلمه المرور</button>
                </form>
            </div>
        </div>
    </section>

@endsection