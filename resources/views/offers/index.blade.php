@extends('layouts.app')
@section('page_title')
    {{trans('admin.offers')}}
@endsection
@section('small_title')
    {{trans('admin.offer')}}
@endsection
@section('content')


    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">{{trans('admin.listOffer')}}</h3>

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
                @if(count($records))
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
                                                    <th>{{trans('admin.name')}}</th>
                                                    <th>{{trans('admin.content')}}</th>
                                                    <th>{{trans('admin.image')}}</th>
                                                    <th>{{trans('admin.from')}}</th>
                                                    <th>{{trans('admin.to')}}</th>
                                                    <th>{{trans('admin.restaurant')}}</th>
                                                    <th class="text-center">{{trans('admin.delete')}}</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($records as $record)
                                                <tr id="removable{{$record->id}}">
                                                    <td>{{$loop->iteration}}</td>
                                                    <td>{{$record->name}}</td>
                                                    <td>{{$record->content}}</td>
{{--                                                    <td>--}}
{{--                                                        <img src="../{{$record->image}}" alt="000000" class="img-thumbnail" width="50px" height="50px">--}}
{{--                                                    </td>--}}
                                                    <td>
                                                        <a href="{{asset($record->image)}}" data-lightbox="{{$record->id}}" data-title="{{$record->name}}">
                                                            <img src="{{asset($record->image)}}" alt="" style="height: 60px;">
                                                        </a>
                                                    </td>
                                                    <td>{{$record->from}}</td>
                                                    <td>{{$record->to}}</td>
                                                    <td>{{$record->restaurant->name}}</td>
                                                    <td class="text-center">
                                                        <button id="{{$record->id}}" data-token="{{ csrf_token() }}"
                                                                data-route="{{URL::route('offer.destroy',$record->id)}}"
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
