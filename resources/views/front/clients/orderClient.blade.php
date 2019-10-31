@extends('front.index')
@section('content')

    <section class="orders-buyer">

        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <a class="nav-item nav-link active" style="margin-left: 10rem" id="nav-new-tab" data-toggle="tab"
                   href="#nav-new" role="tab" aria-controls="nav-all" aria-selected="true">
                    <h3>طلبات جديدة</h3>
                </a>
                <a class="nav-item nav-link" id="nav-past-tab" data-toggle="tab" href="#nav-past" role="tab"
                   aria-controls="nav-womens" aria-selected="false">
                    <h3>طلبات سابقة</h3>
                </a>
            </div>
        </nav>

        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-new" role="tabpanel" aria-labelledby="nav-new-tab">
                @if(count(auth('client')->user()->orders->whereIn('state', ['pending','accepted'])))
                    @foreach(auth('client')->user()->orders->whereIn('state', ['pending','accepted']) as $order)
                        <div class="col-6 media">
                            <img src="../{{$order->restaurant->image}}" class="mr-3" alt="res-img" width="30%">
                            <div class="media-body row">
                                <div class="restaurant-content col-9">
                                    <h4>{{$order->restaurant->name}}</h4>
                                    <h5>رقم الطلب : {{$order->id}}</h5>
                                    <h5>المجموع : {{$order->total}} ريال</h5>
                                </div>
                                <!--restaurant-content-->
                                <div class="button-orders col" style="display: grid">
                                    @if($order->state == 'accepted')
                                        {!! Form::open([
                                            'action' => ['Front\frontController@deliveredOrderClient',$order->id],
                                            'method' => 'post'
                                        ]) !!}
                                        <button type="submit" class="confirm h6 btn btn-lg">تاكيد الاستلام</button>
                                        {!! Form::close() !!}
                                    @elseif($order->state == 'pending')
                                        <h6 class="confirm h6">بانتظار الموافقه على الطلب</h6>
                                    @endif

                                    {!! Form::open([
                                        'action' => ['Front\frontController@declinedOrderClient',$order->id],
                                        'method' => 'post'
                                    ]) !!}
                                    <button type="submit" class="refuse h6 btn btn-lg">رفض</button>
                                    {!! Form::close() !!}
                                </div>
                                <!--button-orders-->
                            </div>
                            <!--media-body-->
                        </div>
                        <!--media-->
                    @endforeach
                @else
                    <div class="container" style="margin-top: 50px;margin-bottom: 50px">
                        <div class="alert alert-danger text-center">
                            <h4> لا توجد طلبات جديده</h4>
                        </div>
                    </div>
                @endif
            </div>
            <!--tab-pane-->


            <div class="tab-pane fade" id="nav-past" role="tabpanel" aria-labelledby="nav-past-tab">
                @if(count(auth('client')->user()->orders->whereIn('state', ['delivered','declined' ,'rejected'])))
                    @foreach(auth('client')->user()->orders->whereIn('state', ['delivered','declined' ,'rejected']) as $order)
                        <div class="col-6 media">
                            <img src="{{asset($order->restaurant->image)}}" class="mr-3" alt="res-img" width="30%">
                            <div class="media-body">
                                <h4>{{$order->restaurant->name}}</h4>
                                <div class="restaurant-content">
                                    <h5>رقم الطلب : {{$order->id}}</h5>
                                    <h5>السعر : {{$order->price}} ريال</h5>
                                    <h5>التوصيل : {{$order->delivery}} ريال</h5>
                                    <h5>الاجمالى : {{$order->total}} ريال</h5>
                                </div>
                                <!--restaurant-content-->
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
                        <!--media-body-->
                        </div>
                        <!--media-->
                    @endforeach
                @else
                    <div class="alert alert-danger text-center">
                        لا توجد طلبات مكتمله
                    </div>
                @endif
            </div>
            <!--tab-pane-->

        </div>
        <!--tab-content-->

    </section>

@endsection