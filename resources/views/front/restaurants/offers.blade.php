@extends('front.index')
@section('content')

    <main class="offer-bg">
        <h3>العروض المتاحة الآن</h3>

        <div class="text-center">
            <button type="button" class="btn btn-primary btn-lg">
                <a style="display: inline" class="h2" href="{{route('restaurant.createOffer')}}">أضف عرض جديد</a>
            </button>
        </div>

        @if(count(auth('restaurant')->user()->offers))
            <div class="row">
                @foreach(auth('restaurant')->user()->offers as $images)
                    <div class="col-md-6" style="margin-bottom: 100px">
                        <a href="{{route('restaurant.editOffer',$images->id)}}">
                            <img src="../{{$images->image}}" style="width: 90%; height: 450px">
                        </a>
                    </div>
                @endforeach
            </div>
        @else
            <div class="alert alert-danger text-center">
                <h4> لا توجد علوض لك الان</h4>
            </div>
        @endif
    <!--row-->

    </main>


@endsection