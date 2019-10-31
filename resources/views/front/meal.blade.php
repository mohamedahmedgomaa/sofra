@extends('front.index')
@section('content')



    <section class="meal container">

        <img src="{{asset($meal->image)}}" class="meal-photo">
        <h1>{{$meal->name}}</h1>
        <h6>{{$meal->description}}</h6>
        <div class="meal-details">
            <h5><img src="{{asset('')}}front/img/images/Layer 5.png"> السعر : {{$meal->price}} ريال</h5>
            <h5><img src="{{asset('')}}front/img/images/Layer 2.png">مدة تجهيز الطلب : {{$meal->time}} دقيقة</h5>
            <h5><img src="{{asset('')}}front/img/images/Layer 3.png">رسوم التوصيل : {{$meal->restaurant->delivery}} ريال
            </h5>
{{--            @if(auth('restaurant'))--}}
            <button type="button" class="btn btn-primary btn-lg">
                <a style="display: inline" href="{{route('productEdit',$meal->id)}}">تعديل المنتج</a>
            </button>
        </div>
        <!--meal-details-->
        <hr>
        <a href="{{route('client.getAddToCart',['id' =>$meal->id])}}" class="btn btn-primary btn-lg">
            <h2 style="display: inline">أضف إلى العربة</h2>
        </a>

        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content text-center">
                    <div class="modal-header">
                        <h4>كيف تريد الإستمرار؟</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <button type="button" class="btn btn-secondary">طلب طعام</button>
                    <button type="button" class="btn btn-primary">بيع طعام</button>

                </div>
            </div>
        </div>
        <!--modal-->

        <div class="meal-info">
            <h5><img src="{{asset('')}}front/img/images/Layer 4.png" width="7%"><a href="#">معلومات عن هذا المتجر</a>
            </h5>
            <h3 class="border-l">تقييمات المستخدمين</h3>
            <p class="sm ml-3">{{count($meal->restaurant->comments)}} تقييم</p>
        </div>
        <!--meal-info-->

        <div class="reviews">

            @foreach($meal->restaurant->comments as $comment)
                <div class="review">
                    <span>بواسطة {{$comment->client->name}}</span>
                    <div class="rating" style="display: inline-block">
                        @for($i= 1; $i <= 5;$i++)
                            <span class="fa fa-star {{$comment->evaluate >= $i?'checked':''}}"></span>
                        @endfor

                    </div>
                    <!--rating-->

                    <h5 class="mt-5 mb-3">{{$comment->comment}}</h5>
                </div>
        @endforeach
        <!--review-->
        </div>
        <!--reviews-->

        <form class="pt-3" method="post" action="{{url(route('createComment'))}}">
            {!! csrf_field() !!}
            <div class="review-write my-5">
                <h4 class="border-l">أضف تقييمك</h4>
                <div class="rating">
                    <span class="fa fa-star checked"></span>
                    <span class="fa fa-star checked"></span>
                    <span class="fa fa-star checked"></span>
                    <span class="fa fa-star"></span>
                    <span class="fa fa-star"></span>
                </div>
                <!--rating-->
                <textarea name="message" rows="6" placeholder="أضف تقييمك"></textarea>
                <button type="submit" class="btn btn-primary btn-lg">
                    <h2 style="display: inline" class="cancel">إرسال</h2>
                </button>
            </div>
        </form>
        <!--review-write-->

        <div class="more-food" style="direction: ltr;margin-bottom: 100px">
            <h4 class="border-l text-left">المزيد من أكلات هذا المطعم</h4>
            <div class="bg">
                <div class="container">
                    <div class="owl-carousel owl-theme" id="owl-services">
                        @foreach($meal->restaurant->products as $product)
                            <div class="item">
                                <img src="{{asset($product->image)}}">
                                <div class="overlay"></div>
                                <div class="button">
                                    <h4>{{$product->name}}</h4>
                                    <a href="{{route('meal',$product->id)}}"> {{$product->description}} </a>
                                </div>
                            </div>
                            <!--item-->
                        @endforeach

                    </div>
                    <!--owl-carousel-->
                </div>
                <!--container-->
            </div>
            <!--bg-->
        </div>
        <!--more-food-->


    </section>

@endsection