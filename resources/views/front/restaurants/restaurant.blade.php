@extends('front.index')
@section('content')

    <!--================================START RESTAURANT=================================-->
    <section class="restaurant-header text-center text-white">
        <img src="../{{auth('restaurant')->user()->image}}" width="300rem">
        <h1>{{auth('restaurant')->user()->name}}</h1>
        <div class="rating">
            @for($i= 1; $i <= 5;$i++)
                <span class="fa fa-star {{auth('restaurant')->user()->comments()->avg('evaluate') >= $i?'checked':''}}"></span>
            @endfor
        </div>
        <!--rating-->
    </section>
    <!--================================START RESTAURANT=================================-->

    <!--================================START FOOD=================================-->
    <section class="food text-center">
        <h2>قائمة الطعام / منتجاتى</h2>
        <button type="button" class="btn btn-primary btn-lg">
            <a style="display: inline" href="{{route('addProduct')}}">اضف منتج جديد</a>
        </button>
        @if(count(auth('restaurant')->user()->products))
        <div class="row">
            @foreach(auth('restaurant')->user()->products as $products)
                <div class="col-sm-4" id="food-type1">
                    <div class="card" style="width: 450px;">
                        {!! Form::open([
                            'action' => ['Front\frontController@deleteProduct',$products->id],
                            'method' => 'delete'
                        ]) !!}
                        <button type="submit" class="btnDelete" id="btnDelete1" onclick="return confirm('Are you sure？')"><i class="fas fa-times-circle"></i>
                        </button>
                        {!! Form::close() !!}

                        <img src="../{{$products->image}}" class="card-img-top" alt="...">
                        <div class="card-body text-center">
                            <h5 class="card-title"><span class="card-title"><a style="color: #ff0084" href="{{route('meal',$products->id)}}">{{$products->name}}</a></span></h5>
                            <p class="small">{{$products->description}}</p>
                            <p class="card-text text-left ml-5 h5">
                                <img src="{{asset('')}}front/img/images/pig.png" width="40rem">
                                {{$products->price}} ريال
                            </p>
                        </div>
                    </div>
                </div>
                <!--col-->
            @endforeach
        </div>
        <!--row-->
        @else
            <div class="row text-center">
                <div class="col-sm-12 btn-lg">
                    <div class="alert alert-success"> No Food</div>
                </div>
            </div>
        @endif
    </section>
    <!--================================END FOOD=================================-->

@endsection