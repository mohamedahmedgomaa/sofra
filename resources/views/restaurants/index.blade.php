@extends('layouts.app')
@inject('city', 'App\Model\City')
@php
$cities = $city->pluck('name', 'id')->toArray();
@endphp
@section('page_title')
    {{trans('admin.restaurants')}}
@endsection
@section('small_title')
    {{trans('admin.restaurant')}}
@endsection
@section('content')

    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">{{trans('admin.listRestaurants')}}</h3>
            </div>
            <div class="box-body">
                <div class="box">
                    <div class="clearfix"></div>
                    <br>
                    <div class="restaurant-filter">
                        {!! Form::open([
                        'method' => 'get'
                        ]) !!}
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    {!! Form::text('name',request()->input('name'),[
                                    'placeholder' => 'اسم المطعم',
                                    'class' => 'form-control'
                                    ]) !!}
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::select('city_id',$cities,request()->input('city_id'),[
                                    'class' => 'select2 form-control',
                                    'placeholder' => 'المدينة'
                                    ]) !!}
                                </div>
                            </div>
                            <div class="col-md-3">
                                {{-- 'soon' => 'قريبا', --}}
                                <div class="form-group">
                                    {!! Form::select('activated',['open' => 'مفتوح', 'closed' => 'مغلق'],request()->input('activated'),[
                                    'class' => 'select2 form-control',
                                    'placeholder' => 'حالة المطعم'
                                    ]) !!}
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <button class="btn btn-primary btn-block" type="submit"><i
                                                class="fa fa-search"></i></button>
                                </div>
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                @if(count($records))
                        <div class="box-body">
                            <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                                @include('flash::message')
                                <br>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped">
                                                <thead>
                                                <tr role="row">
                                                    <th>#</th>
                                                    <th>{{trans('admin.name')}}</th>
                                                    <th>{{trans('admin.email')}}</th>
                                                    <th>{{trans('admin.image')}}</th>
                                                    <th>{{trans('admin.payment')}}</th>
                                                    <th>{{trans('admin.phone')}}</th>
                                                    <th>{{trans('admin.minimum')}}</th>
                                                    <th>{{trans('admin.delivery')}}</th>
                                                    <th>{{trans('admin.city')}}</th>
                                                    <th>{{trans('admin.state')}}</th>
                                                    <th>{{trans('admin.whats_app')}}</th>
                                                    <th>{{trans('admin.restaurant_phone')}}</th>
                                                    <th class="text-center">{{trans('admin.active')}}</th>
                                                    <th class="text-center">{{trans('admin.delete')}}</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($records as $record)
                                                    <tr id="removable{{$record->id}}">
                                                        <td>{{$loop->iteration}}</td>
                                                        {{--                                                        <td>{{$record->name}}</td>--}}
                                                        <td><a style="cursor: pointer" data-toggle="modal"
                                                               data-target="#myModal{{$record->id}}">{{$record->name}}</a>
                                                        </td>
                                                        <td>{{$record->email}}</td>
                                                        <td>
                                                            <a href="{{asset($record->image)}}" data-lightbox="{{$record->id}}" data-title="{{$record->name}}">
                                                                <img src="{{asset($record->image)}}" alt="" style="height: 60px;">
                                                            </a>
                                                        </td>
                                                        <td class="text-center">
                                                            {{ $record->total_commissions - $record->total_payments }}
                                                        </td>
                                                        <td>{{$record->phone}}</td>
                                                        <td>{{$record->minimum}}</td>
                                                        <td>{{$record->delivery}}</td>

                                                        <td>{{$record->neighborhood->name}} {{$record->neighborhood->city->name}}</td>
                                                        @if($record->state == 'open')
                                                            <td class="text-center">
                                                                <p class="alert alert-success">{{trans('admin.open')}}</p>
                                                            </td>
                                                        @else
                                                            <td class="text-center">
                                                                <p class="alert alert-danger">{{trans('admin.close')}}</p>
                                                            </td>
                                                        @endif

                                                        <td>{{$record->whats_app}}</td>
                                                        <td>{{$record->restaurant_phone}}</td>
                                                        @if($record->activated == 1)
                                                            <td class="text-center">
                                                                {!! Form::open([
                                                                    'action' => ['RestaurantController@activated',$record->id],
                                                                    'method' => 'put'
                                                                ]) !!}
                                                                <button type="submit" class="btn btn-success btn-xs"><i
                                                                            class="fa fa-edit"></i> {{trans('admin.enable')}}
                                                                </button>
                                                                {!! Form::close() !!}
                                                            </td>
                                                        @else
                                                            <td class="text-center">
                                                                {!! Form::open([
                                                                    'action' => ['RestaurantController@activated',$record->id],
                                                                    'method' => 'put'
                                                                ]) !!}
                                                                <button type="submit" class="btn btn-danger btn-xs"><i
                                                                            class="fa fa-edit"></i> {{trans('admin.notEnabled')}}
                                                                </button>
                                                                {!! Form::close() !!}
                                                            </td>
                                                        @endif
                                                        <td class="text-center">
                                                            <button id="{{$record->id}}" data-token="{{ csrf_token() }}"
                                                                    data-route="{{URL::route('restaurant.destroy',$record->id)}}"
                                                                    type="button" class="destroy btn btn-danger btn-xs">
                                                                <i class="fa fa-trash-o"></i></button>
                                                        </td>
                                                    </tr>
                                                    <div class="modal fade" id="myModal{{$record->id}}" tabindex="-1"
                                                         role="dialog" aria-labelledby="myModalLabel">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <button type="button" class="close"
                                                                            data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span></button>
                                                                    <h4 class="modal-title"
                                                                        id="myModalLabel">{{$record->name}}</h4>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="row">
                                                                        <div class="col-lg-8">
                                                                            <ul>
                                                                                <li> العنوان : {{$record->address}}</li>
                                                                                <li> المدينة :
                                                                                    @if(count($record->neighborhood))
                                                                                        {{$record->neighborhood->name}}
                                                                                        @if(count($record->neighborhood->city))
                                                                                            {{$record->neighborhood->city->name}}
                                                                                        @endif
                                                                                    @endif
                                                                                </li>
                                                                                <li> الحد الأدنى للطلبات
                                                                                    : {{$record->minimum_charger}}</li>
                                                                                <li> للتواصل : {{$record->phone}}</li>
                                                                                <hr>
                                                                                <li>إجمالي الطلبات
                                                                                    : {{$record->total_orders_amount}}</li>
                                                                                <li>إجمالي العمولات المستحقة
                                                                                    : {{$record->total_commissions}}</li>
                                                                                <li>إجمالي المبالغ المسددة
                                                                                    : {{$record->total_payments}}</li>
                                                                                <li>صافي العمولات المستحقة
                                                                                    : {{$record->total_commissions - $record->total_payments}}</li>
                                                                            </ul>
                                                                        </div>
                                                                        <div class="col-lg-4">
                                                                            <img height="150px" width="150px"
                                                                                 src="{{url('/'.$record->image.'/')}}"/>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-default"
                                                                            data-dismiss="modal">إغلاق
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    {{--                                                    @php $count ++; @endphp--}}
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <div class="text-center">{{$records->links()}}</div>
                @else
                    <div class="alert alert-danger">
                        No Data
                    </div>
                @endif
            </div>
        </div>
        <!-- /.box -->

    </section>
    <!-- /.content -->
@endsection
