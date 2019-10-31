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
                <form class="pt-3" method="post" action="{{url(route('auth.resetPasswordClient'))}}">
                    {!! csrf_field() !!}
                    <div class="form-group">
                        <input type="email" name="email" class="form-control" id="exampleInputEmail1"
                               placeholder="البريد الالكترونى">
                    </div>

                    <button type="submit" class="mx-auto btn">ارسال</button>

                    <div class="text-center">
                        <button type="button" style="display: inline" class="mx-auto btn">
                            <span> <a href="{{route('front.client.get')}}"> الرجوع لصفحه التسجيل </a></span>
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </section>

@endsection