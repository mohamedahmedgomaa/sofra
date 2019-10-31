@extends('front.index')
@section('content')

    @if(Session::has('cart'))
        <main class="cart" style="padding: 5rem 10rem;">
            <div class="media" id="order1">
                <h4> المبلغ الكلى : {{$totalPrice}} ريال</h4>
            </div>
            @foreach($products as $product)
                <div class="media" id="order1">
                    <img src="{{asset('')}}front/img/images/burger-cheeseburger-delicious-1624473.jpg" class="mr-3"
                         alt="...">
                    <div class="media-body">
                        <h5 class="mt-0">بيف برجر {{$product['item']['name']}} جرام</h5>
                        <h5 class="mt-0">{{$product['item']['price']}} ريال</h5>
                        <h5 class="mt-0">البائع : {{$product['item']['restaurant']['name']}}</h5>
                        <h5 class="mt-0">الكمية : <span
                                    style="width: 3rem;background-color:#c9c9c9;border: unset">{{$product['qty']}}</span>
                        </h5>
                        <button type="button" class="btn btn-primary btn-lg" id="deleteOrder1">
                            <i class="far fa-times-circle" style="font-size: 1.5rem;"></i>
                            <a style="display: inline" class="h4"
                               href="{{route('client.reduceByOne',['id' => $product['item']['id']])}}">مسح منتج واحد</a>
                        </button>
                        <button type="button" class="btn btn-primary btn-lg" id="deleteOrder1">
                            <i class="far fa-times-circle" style="font-size: 1.5rem;"></i>
                            <a style="display: inline" class="h4"
                               href="{{route('client.remove',['id' => $product['item']['id']])}}">مسح</a>
                        </button>
                    </div>
                </div>
            @endforeach

            <button type="button" class="btn btn-primary btn-lg" id="deleteOrder1">
                <i class="fa fa-shopping-cart" style="font-size: 2rem;"></i>
                <a style="display: inline" class="h4"
                   href="{{url('/client/checkout')}}">شراء</a>
            </button>
        </main>
            @else
                <div class="alert alert-danger text-center">
                    <h3>لا توجد منتجات</h3>
                </div>
            @endif


@endsection