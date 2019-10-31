@extends('front.index')
@section('content')


    <!--================================START RESTAURANT=================================-->
    <section class="restaurant-header text-center text-white">
        <img src="../{{$restaurant->image}}" width="300rem">
        <h1>{{$restaurant->name}}</h1>
        <div class="rating">
            @for($i= 1; $i <= 5;$i++)
                <span class="fa fa-star {{$rate >= $i?'checked':''}}"></span>
            @endfor
        </div>

        <!--rating-->
    </section>
    <!--================================START RESTAURANT=================================-->

    <!--================================START FOOD=================================-->
    <section class="food">
        @if(count($restaurant->products))
            <div class="row">
                @foreach($restaurant->products as $product)
                    <div class="col-sm-4">
                        <div class="card" style="width: 450px;">
                            <img src="../{{$product->image}}" class="card-img-top"
                                 alt="...">
                            <div class="card-body text-center">
                                <h5 class="card-title">{{$product->name}}</h5>
                                <p class="small">{{$product->description}}</p>
                                <p class="card-text text-left ml-5 h5">
                                    <img src="{{asset('')}}front/img/images/food-order.png" width="10%">
                                    {{$product->time}} تقريباً
                                </p>
                                <p class="card-text text-left ml-5 h5">
                                    <img src="{{asset('')}}front/img/images/pig.png" width="10%">
                                    {{$product->price}} ريال
                                </p>
                                <button type="button" class="btn btn-primary btn-lg m-2">
                                    <a href="{{route('meal',$product->id)}}"> اضغط هنا للتفاصيل</a>
                                </button>
                            </div>
                        </div>
                    </div>
            @endforeach
            <!--col-->
            </div>

        @else
            <div class="row text-center">
                <div class="col-sm-12 btn-lg">
                    <div class="alert alert-success"> No Food</div>
                </div>
            </div>
    @endif
    <!--row-->

    </section>
    <!--================================END FOOD=================================-->

@endsection