@extends('front.index')
@inject('city', 'App\Model\City')
@php
    $cities = $city->pluck('name', 'id')->toArray();
@endphp
@section('content')

    <main>
        <!--================================START HEADER===============================-->
        <header>
            {{--            @if(auth()->guard('client')->check())--}}
            {{--            {{ auth()->guard('client')->user()->name }}--}}
            {{--            @else--}}
            {{--                @endif--}}
            <h1 class="main-heading">سُفرة</h1>
            <h1 class="sub-heading">بتشترى .. بتبيع ؟ كله عند أم ربيع</h1>
            <button type="button" class="btn btn-primary btn-lg">
                <a style="display: inline" class="h2" href="{{url(route('front.client.get'))}}">سجل الان</a>
                <img src="{{asset('')}}front/img/images/dish.png" class="ml-1" width="20%">
            </button>
        </header>
        <!--================================END HEADER=================================-->

        <!--================================START RESTAURANT===============================-->
        <section class="restaurant">
            <div class="container">
                <h2>ابحث عن مطعمك المفضل</h2>
                {!! Form::open([ 'method' => 'get' ]) !!}
                <div class="row mt-5">
                    <div class="col-md-5">
                        <div class="input-group mb-3">
                            {!! Form::select('city_id',$cities,request()->input('city_id'),[
                                'class' => 'select2 custom-select',
                                'id' => 'inputGroupSelect01',
                                'placeholder' => 'اختر المدينه'
                            ]) !!}
                        </div>
                    </div>
                    <!--col-->
                    <div class="col-md-5">
                        <div class="search_box mb-3">
                            <input type="search" name="name" class="form-control mr-sm-2"
                                   placeholder="ابحث عن مطعمك المفضل">
                            <i class="fas fa-search"></i>
                        </div>
                    </div>
                    <div class="col-md-2 search">
                        <div class="circle search-icon">
                            <button class="circle search-icon" type="submit"><i
                                        class="fas fa-search search-icon"></i></button>
                        </div>
                    </div>
                {!! Form::close() !!}
                <!--col-->
                </div>
                <!--row-->


                <div class="row mt-4">

                    @foreach($restaurants as $restaurant)
                        <div class="col-md-6">
                            <div class="media">
                                <img src="{{$restaurant->image}}" class="mr-3" alt="res-img" width="40%">
                                <div class="media-body">
                                    <a href="restaurants/{{$restaurant->id}}"><h4>{{$restaurant->name}}</h4></a>
                                    <div class="rating">
                                        @for($i= 1; $i <= 5;$i++)
                                            <span class="fa fa-star {{$restaurant->comments()->avg('evaluate') >= $i?'checked':''}}"></span>
                                        @endfor
                                    </div>
                                    <!--rating-->
                                    <div class="restaurant-content">
                                        @if($restaurant->state == 'open')
                                            <h5 class="open"><i class="fas fa-circle mr-2" style="color: #17bf4e;"></i>مفتوح
                                            </h5>
                                        @else
                                            <h5 class="close"><i class="fas fa-circle mr-2" style="color: red;"></i>مغلق
                                            </h5>
                                        @endif
                                        <p class="mt-3">الحد الأدنى للطلب : {{$restaurant->minimum}} ريال </p>
                                        <p>رسوم التوصيل : {{$restaurant->delivery}} ريال</p>
                                    </div>
                                    <!--restaurant-content-->
                                </div>
                                <!--media-body-->
                            </div>
                            <!--media-->
                        </div>
                        <!--col-->
                    @endforeach

                </div>
                <!--row-->
            </div>
            <!--container-->
        </section>

        <!--================================END RESTAURANT=================================-->


        <!--================================START OFFERS===============================-->
        <section class="offers">
            <div class="container">
                <div class="row">
                    <div class="col-md-5">
                        <img src="{{asset('')}}front/img/images/offers.png" width="100%">
                    </div>
                    <!--col-->
                    <div class="col-md-7">
                        <div class="bg text-center">
                            <h2 class="paragraph">نقدم فى سفرة أفضل العروض لكل أنواع المطاعم و الأكلات الشهية المهلبية
                                ماذا
                                تنتظر إبدأ الإستمتاع بالعروض الآن</h2>
                            <button type="button" class="btn btn-primary btn-lg">
                                <a style="display: inline" class="h2" href="offers.html">شاهد العروض</a>
                            </button>
                        </div>
                        <!--bg-->
                    </div>
                    <!--col-->
                </div>
                <!--row-->
            </div>
            <!--container-->
        </section>
        <!--================================END OFFERS=================================-->


        <!--================================START APP===============================-->
        <section class="app">
            <div class="row">
                <div class="col-md-7">
                    <h1>قم بتحميل التطبيق الخاص بنا الآن</h1>
                    <div class="text-center">
                        <button type="button" class="btn btn-primary btn-lg">
                            <h1>حمل الآن <i class="fab fa-android"></i></h1>
                        </button>
                    </div>
                </div>
                <!--col-->
                <div class="col-md-5 mb-0 pb-0">
                    <img src="{{asset('')}}front/img/images/app mockup.png" width="100%">
                </div>
                <!--col-->
            </div>
            <!--row-->
        </section>
        <!--================================END APP===============================-->


    </main>


@endsection