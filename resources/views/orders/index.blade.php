@extends('layouts.app')
@inject('restaurant', 'App\Model\Restaurant')
@section('page_title')
    {{trans('admin.orders')}}
@endsection
@section('small_title')
    {{trans('admin.order')}}
@endsection
@push('scripts')
    <script type="text/javascript">
        jQuery(document).ready(function($) {
            $('.datepicker').datepicker({
                dateFormat: "yy-mm-dd"
            });
        });
    </script>
@endpush
@section('content')



    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">{{trans('admin.listOrder')}}</h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                            title="Collapse">
                        <i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip"
                            title="Remove">
                        <i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body">
                <div class="row">
                    {!! Form::open([
                        'method' => 'GET'
                    ]) !!}
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="">&nbsp;</label>
                            {!! Form::text('order_id',request()->input('order_id'),[
                                'class' => 'form-control',
                                'placeholder' => 'رقم الطلب'
                            ]) !!}
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="">&nbsp;</label>
                            {!! Form::select('restaurant_id',$restaurant->get()->pluck('name','id')->toArray(),request()->input('restaurant_id'),[
                                'class' => 'form-control',
                                'placeholder' => 'كل المطاعم'
                            ]) !!}
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="">&nbsp;</label>
                            {!! Form::select('state',
                                [
                                    'pending' => 'قيد التنفيذ',
                                    'accepted' => 'تم تأكيد الطلب',
                                    'rejected' => 'مرفوض',
                                ],\Request::input('state'),[
                                    'class' => 'form-control',
                                    'placeholder' => 'كل حالات الطلبات'
                            ]) !!}
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for=""></label>
                            {!! Form::text('from',request()->input('from'),[
                                'class' => 'form-control datepicker',
                                'placeholder' => 'من'
                            ]) !!}
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for=""></label>
                            {!! Form::text('to',\Request::input('to'),[
                                'class' => 'form-control datepicker',
                                'placeholder' => 'إلى'
                            ]) !!}
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="">&nbsp;</label>
                            <button class="btn btn-flat btn-block btn-primary">بحث</button>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
                @if(count($order))
                    <div class="box">

                        <div class="box-body">
                            <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                                {{--                                <div class="row">--}}
                                {{--                                    <div class="col-sm-6">--}}
                                {{--                                        <div id="example1_filter" class="dataTables_filter"><label>Search:<input--}}
                                {{--                                                        type="search" class="form-control input-sm" placeholder=""--}}
                                {{--                                                        aria-controls="example1"></label></div>--}}
                                {{--                                    </div>--}}
                                {{--                                </div>--}}

                                @include('flash::message')
                                <br>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped">
                                                <thead>
                                                <tr role="row">
                                                    <th>#</th>
                                                    <th>{{trans('admin.note')}}</th>
                                                    <th>{{trans('admin.state')}}</th>
                                                    <th>{{trans('admin.restaurant')}}</th>
                                                    <th>{{trans('admin.client')}}</th>
                                                    <th>{{trans('admin.price')}}</th>
                                                    <th>{{trans('admin.delivery')}}</th>
                                                    <th>{{trans('admin.commission')}}</th>
                                                    <th>{{trans('admin.total')}}</th>
                                                    <th>{{trans('admin.address')}}</th>
                                                    <th>{{trans('admin.paymentMethod')}}</th>
                                                    <th class="text-center">{{trans('admin.show')}}</th>
                                                    <th class="text-center">{{trans('admin.delete')}}</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($order as $record)
                                                    <tr id="removable{{$record->id}}">
                                                        <td>{{$loop->iteration}}</td>
                                                        <td>{{$record->note}}</td>
                                                        @if($record->state == 'pending' || $record->state == 'accepted')
                                                            <td class="alert alert-success text-center">{{$record->state}}</td>
                                                        @elseif($record->state == 'declined')
                                                            <td class="alert alert-danger text-center">{{$record->state}}</td>
                                                        @elseif($record->state == 'delivered')
                                                            <td class="alert alert-warning text-center">{{$record->state}}</td>
                                                        @else
                                                            <td class="alert alert-info text-center">{{$record->state}}</td>
                                                        @endif
                                                        <td>{{$record->restaurant->name}}</td>
                                                        <td>{{$record->client->name}}</td>
                                                        <td>{{$record->price}}</td>
                                                        <td>{{$record->delivery}}</td>
                                                        <td>{{$record->commission}}</td>
                                                        <td>{{$record->total}}</td>
                                                        <td>{{$record->address}}</td>
                                                        <td>{{optional($record->paymentMethod)->name}}</td>
                                                        <td class="text-center">
                                                            {!! Form::open([
                                                                'action' => ['OrderController@show',$record->id],
                                                                'method' => 'get'
                                                            ]) !!}
                                                            <button type="submit" class="btn btn-success btn-xs"><i
                                                                        class="fa fa-address-book"></i></button>
                                                            {!! Form::close() !!}
                                                        </td>
                                                        <td class="text-center">
                                                            <button id="{{$record->id}}" data-token="{{ csrf_token() }}"
                                                                    data-route="{{URL::route('order.destroy',$record->id)}}"
                                                                    type="button" class="destroy btn btn-danger btn-xs">
                                                                <i class="fa fa-trash-o"></i></button>
                                                        </td>
                                                    </tr>
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
                    <div class="text-center">{{$order->links()}}</div>
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
