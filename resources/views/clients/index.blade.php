@extends('layouts.app')
@section('page_title')
    {{trans('admin.clients')}}
@endsection
@section('small_title')
    {{trans('admin.client')}}
@endsection
@section('content')

    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">{{trans('admin.listClients')}}</h3>
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
                                                    <th>{{trans('admin.email')}}</th>
                                                    <th>{{trans('admin.image')}}</th>
                                                    <th>{{trans('admin.phone')}}</th>
                                                    <th>{{trans('admin.neighborhood')}}</th>
                                                    <th>{{trans('admin.city')}}</th>
                                                    <th class="text-center">{{trans('admin.active')}}</th>
                                                    <th class="text-center">{{trans('admin.delete')}}</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($records as $record)
                                                <tr id="removable{{$record->id}}">
                                                    <td>{{$loop->iteration}}</td>
                                                    <td>{{$record->name}}</td>
                                                    <td>{{$record->email}}</td>
                                                    <td>
                                                        <img src="../{{$record->image}}" alt="000000" class="img-thumbnail" width="50px" height="50px">
                                                    </td>
                                                    <td>{{$record->phone}}</td>
                                                    <td>{{$record->neighborhood->name}}</td>
                                                    <td>{{$record->neighborhood->city->name}}</td>
                                                    @if($record->is_active == 1)
                                                    <td class="text-center">
                                                            {!! Form::open([
                                                                'action' => ['ClientController@is_active',$record->id],
                                                                'method' => 'put'
                                                            ]) !!}
                                                            <button type="submit" class="btn btn-success btn-xs"><i class="fa fa-edit"></i> {{trans('admin.enable')}}</button>
                                                            {!! Form::close() !!}
                                                        </td>
                                                    @else
                                                        <td class="text-center">
                                                            {!! Form::open([
                                                                'action' => ['ClientController@is_active',$record->id],
                                                                'method' => 'put'
                                                            ]) !!}
                                                            <button type="submit" class="btn btn-danger btn-xs"><i class="fa fa-edit"></i> {{trans('admin.notEnabled')}}</button>
                                                            {!! Form::close() !!}
                                                        </td>
                                                    @endif
                                                    <td class="text-center">
                                                        <button id="{{$record->id}}" data-token="{{ csrf_token() }}"
                                                                data-route="{{URL::route('client.destroy',$record->id)}}"
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
