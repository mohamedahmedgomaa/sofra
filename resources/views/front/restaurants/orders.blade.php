@extends('front.index')
@section('content')

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css"
          integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
    <link rel="stylesheet" href="{{asset('')}}front/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{asset('')}}front/css/pagesStyle.css">

    <section class="choose-bar">
        <div class="container text-center">
            <div class="row">

                <div class="col-lg">
                    <a href="#" class="new"><span class="active-span new-span">طلبات جديدة</span></a>
                </div>

                <div class="col-lg">
                    <a href="#" class="current"><span class="current-span">طلبات حالية</span></a>
                </div>

                <div class="col-lg">
                    <a href="#" class="prev"><span class="prev-span">طلبات سابقة</span></a>
                </div>

            </div>
        </div>
    </section>

    <section class="order  admin-or">
        <div class="container">

            <!--new order-->
            <div class="new-order" id="mew">
                @if(count(auth('restaurant')->user()->orders->where('state', 'pending')))
                    @foreach(auth('restaurant')->user()->orders->where('state', 'pending') as $order)
                        <div class="card-or mx-auto">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-lg-5">
                                        <div class="text-center">
                                            <img src="../{{$order->client->image}}" class="img-fluid">
                                        </div>
                                    </div>
                                    <div class="col-lg-7">
                                        <div class="details">
                                            <h4>العميل : <span>{{$order->client->name}}</span></h4>
                                            <span>
                                        <label for="">رقم الطلب : </label>
                                        <span>{{$order->id}}</span>
                                    </span>
                                            <span>
                                        <label for="">المجموع : </label>
                                        <span>{{$order->total}} ريال</span>
                                    </span>
                                            <span>
                                        <label for="">العنوان : </label>
                                        <span>{{$order->address}}</span>
                                    </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="buttons">
                                    {!! Form::open([
                                        'action' => ['Front\frontController@acceptedOrder',$order->id],
                                        'method' => 'post'
                                    ]) !!}
                                    <button type="submit" class="btn btn-success sure">استلام</button>
                                    {!! Form::close() !!}
                                    {!! Form::open([
                                        'action' => ['Front\frontController@rejectedOrder',$order->id],
                                        'method' => 'post'
                                    ]) !!}
                                    <button type="submit" class="btn btn-danger sure">رفض</button>
                                    {!! Form::close() !!}
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="alert alert-danger text-center">
                        لا توجد طلبات جديده
                    </div>
                @endif
            </div>

            <!--prev order-->
            <div class="prev-order" id="prev">
                @if(count(auth('restaurant')->user()->orders->whereIn('state', ['delivered','declined' ,'rejected'])))
                    @foreach(auth('restaurant')->user()->orders->whereIn('state', ['delivered','declined' ,'rejected']) as $order)
                        <div class="card-or mx-auto">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-lg-5">
                                        <div class="text-center">
                                            <img src="../{{$order->client->image}}" class="img-fluid">
                                        </div>
                                    </div>
                                    <div class="col-lg-7">
                                        <div class="details">
                                            <h4>العميل : <span>{{$order->client->name}}</span></h4>
                                            <span>
                                        <label for="">رقم الطلب : </label>
                                        <span>{{$order->id}}</span>
                                    </span>
                                            <span>
                                        <label for="">المجموع : </label>
                                        <span>{{$order->total}} ريال</span>
                                    </span>
                                            <span>
                                        <label for="">العنوان : </label>
                                        <span>{{$order->address}}</span>
                                    </span>
                                        </div>
                                    </div>
                                </div>
                                @if($order->state == 'delivered')
                                    <div class="buttons">
                                        <button class="btn btn-success sure">الطلب مكتمل</button>
                                    </div>
                                @elseif($order->state == 'declined')
                                    <div class="buttons">
                                        <button class="btn btn-danger sure">الطلب تم رفضه</button>
                                    </div>
                                @elseif($order->state == 'rejected')
                                    <div class="buttons">
                                        <button class="btn btn-danger sure">الطلب مرفوض</button>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="alert alert-danger text-center">
                        لا توجد طلبات مكتمله
                    </div>
                @endif
            </div>

            <!--current order-->
            <div class="current-order" id="current">
                @if(count(auth('restaurant')->user()->orders->whereIn('state', 'accepted')))
                    @foreach(auth('restaurant')->user()->orders->whereIn('state', 'accepted') as $order)
                        <div class="card-or mx-auto">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-lg-5">
                                        <div class="text-center">
                                            <img src="../{{$order->client->image}}" class="img-fluid">
                                        </div>
                                    </div>
                                    <div class="col-lg-7">
                                        <div class="details">
                                            <h4>العميل : <span>{{$order->client->name}}</span></h4>
                                            <span>
                                        <label for="">رقم الطلب : </label>
                                        <span>{{$order->id}}</span>
                                    </span>
                                            <span>
                                        <label for="">المجموع : </label>
                                        <span>{{$order->total}} ريال</span>
                                    </span>
                                            <span>
                                        <label for="">العنوان : </label>
                                        <span>{{$order->address}}</span>
                                    </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="buttons">
                                    <span class="phone">{{$order->client->phone}}</span>
                                    {!! Form::open([
                                        'action' => ['Front\frontController@deliveredOrder',$order->id],
                                        'method' => 'post'
                                    ]) !!}
                                    <button type="submit" class="btn btn-success sure">تأكد الاستلام</button>
                                    {!! Form::close() !!}
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="alert alert-danger text-center">
                        لا توجد طلبات حاليه
                    </div>
                @endif
            </div>

        </div>
    </section>


@endsection