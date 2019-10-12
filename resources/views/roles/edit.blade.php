@extends('layouts.app')
@section('page_title')
    تعديل رتبه
@endsection
@section('small_title')
    رتبه
@endsection
@section('content')

    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">تعديل رتبه</h3>
            </div>

            <div class="box">
                <div class="box-body">
                    @include('flash::message')
                    @include('partials.validations_errors')
                    <div class="box-body">
                        {!! Form::model($model, [
                            'action' => ['RoleController@update',$model->id],
                            'method' =>'put'
                        ]) !!}
                        @include('roles.form')
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
