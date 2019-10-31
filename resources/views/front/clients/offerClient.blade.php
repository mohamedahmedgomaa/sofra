@extends('front.index')
@section('content')

    @if(count($offers))
        <div class="container">
            <div class="row">
                @foreach($offers as $offer)
                    <div class="col-md-6" style="margin-bottom: 100px;margin-top: 100px">
                            <img src="../{{$offer->image}}" style="width: 90%; height: 450px">
                    </div>
                @endforeach
            </div>
        </div>
    @else
        <div class="alert alert-danger text-center">
            <h4> لا توجد علوض متاحه الان</h4>
        </div>
    @endif

@endsection