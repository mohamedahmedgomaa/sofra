@extends('layouts.app')
@section('page_title')
    {{trans('admin.products')}}
@endsection
@section('small_title')
    {{trans('admin.product')}}
@endsection
@section('content')


    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">{{trans('admin.listProduct')}}</h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-9">
                        <form action="/admin/search" method="get">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <input placeholder="search" class="form-control" name="search" type="text">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <button class="btn btn-primary btn-block" type="submit"><i class="fa fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                @if(count($records))
                    <div class="box">

                        <div class="box-body">
                            <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                                {{--                                <form method="get" action="/results" class="form-group has-search">--}}
                                {{--                                    {{ csrf_field() }}--}}
                                {{--                                    <span class="fa fa-search form-control-feedback"></span>--}}
                                {{--                                    <input type="text" name="search" class="form-control" placeholder="Search">--}}
                                {{--                                </form>--}}
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
                                                    <th>{{trans('admin.description')}}</th>
                                                    <th>{{trans('admin.price')}}</th>
                                                    <th>{{trans('admin.offer')}}</th>
                                                    <th>{{trans('admin.time')}}</th>
                                                    <th>{{trans('admin.image')}}</th>
                                                    <th>{{trans('admin.restaurant')}}</th>
                                                    <th class="text-center">{{trans('admin.delete')}}</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($records as $record)
                                                    <tr id="removable{{$record->id}}">
                                                        <td>{{$loop->iteration}}</td>
                                                        <td>{{$record->name}}</td>
                                                        <td>{{$record->description}}</td>
                                                        <td>{{$record->price}}</td>
                                                        @if($record->offer == null)
                                                            <td>لا يوج عرض</td>
                                                        @else
                                                            <td>{{$record->offer}}</td>
                                                        @endif

                                                        <td>{{$record->time}}</td>
                                                        <td>
                                                            <img src="../{{$record->image}}" alt="000000"
                                                                 class="img-thumbnail" width="50px" height="50px">
                                                        </td>
                                                        {{--                                                        @if(!empty($record->restaurant_id))--}}
                                                        <td>{{$record->restaurant->name}}</td>
                                                        {{--                                                        @else--}}
                                                        {{--                                                            <td>{{$record->restaurant_id}}</td>--}}
                                                        {{--                                                        @endif--}}
                                                        <td class="text-center">
                                                            <button id="{{$record->id}}" data-token="{{ csrf_token() }}"
                                                                    data-route="{{URL::route('product.destroy',$record->id)}}"
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
