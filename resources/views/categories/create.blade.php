@extends('layouts.app')
@inject('model', 'App\Model\Category')
@section('page_title')
    {{trans('admin.createCategory')}}
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
                <h3 class="box-title">{{trans('admin.createCategory')}}</h3>

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
                <div class="box">
                    @include('partials.validations_errors')
                    @include('flash::message')
                    <div class="box-body">
                        {!! Form::model($model, ['action' => 'CategoryController@store']) !!}
                        @include('categories.form')
                        {!! Form::close() !!}
                    </div>
                    <!-- /.box-body -->
                </div>

            </div>
        </div>
        <!-- /.box -->

    </section>
    <!-- /.content -->
@endsection
