@extends('layouts.app')
@section('page_title')
    {{trans('admin.contacts')}}
@endsection
@section('small_title')
    {{trans('admin.enquiry')}}
@endsection
@section('content')

    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">{{trans('admin.listEnquiry')}}</h3>

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
                                                    <th>{{trans('admin.phone')}}</th>
                                                    <th>{{trans('admin.message')}}</th>
                                                    <th class="text-center">{{trans('admin.typeMessage')}}</th>
                                                    <th class="text-center">{{trans('admin.delete')}}</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($records as $record)
                                                    <tr id="removable{{$record->id}}">
                                                        <td>{{$loop->iteration}}</td>
                                                        <td>{{$record->name}}</td>
                                                        <td>{{$record->email}}</td>
                                                        <td>{{$record->phone}}</td>
                                                        <td>{{$record->message}}</td>
                                                        <td class="text-center alert alert-info">{{trans('admin.enquiry')}}</td>
                                                        <td class="text-center">
                                                            <button id="{{$record->id}}" data-token="{{ csrf_token() }}"
                                                                    data-route="{{URL::route('contact.destroy',$record->id)}}"
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
