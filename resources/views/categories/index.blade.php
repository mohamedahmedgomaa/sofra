@extends('layouts.app')
@section('page_title')
    {{trans('admin.categories')}}
@endsection
@section('small_title')
    {{trans('admin.category')}}
@endsection
@section('content')


    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">{{trans('admin.listCategories')}}</h3>
            </div>
            <div class="box-body">
                @if(count($records))
                    <div class="box">

                        <div class="box-body">
                            <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                                <a href="{{url(route('category.create'))}}" class="btn btn-primary"><i class="fa fa-plus"></i> {{trans('admin.createCategory')}}</a>
                                <br>
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
                                                    <th class="text-center">{{trans('admin.edit')}}</th>
                                                    <th class="text-center">{{trans('admin.delete')}}</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($records as $record)
                                                <tr id="removable{{$record->id}}">
                                                    <td>{{$loop->iteration}}</td>
                                                    <td>{{$record->name}}</td>
                                                    <td class="text-center">
                                                        <a href="{{url(route('category.edit', $record->id))}}" class="btn btn-success btn-xs"><i class="fa fa-edit"></i></a>
                                                    </td>
                                                    <td class="text-center">
                                                        <button id="{{$record->id}}" data-token="{{ csrf_token() }}"
                                                                data-route="{{URL::route('category.destroy',$record->id)}}"
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
