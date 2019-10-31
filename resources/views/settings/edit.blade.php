@extends('layouts.app')
@section('content')
@section('page_title')
    صفحه الاعدادات
@endsection
@section('small_title')
    الاعدادات
@endsection
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">صفحه الاعدادات</h3>

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
                    @include('flash::message')
                    @include('partials.validations_errors')
                    <div class="box-body">
                        <form action="{{route('settings.update')}}" method="POST"  enctype="multipart/form-data">
                            {{ csrf_field()}}
                            <div class="form-group">
                                <label for="phone">رقم الهاتف</label>
                                <input type="text" class="form-control" name="phone"  value="{{$settings->phone}}">
                            </div>

                            <div class="form-group">
                                <label for="blog_email">البريد الالكترونى</label>
                                <input type="text" class="form-control" name="email"  value="{{$settings->email}}">
                            </div>

                            <div class="form-group">
                                <label for="text">النص</label>
                                <textarea name="text" class="form-control" rows="8">{{$settings->text}}</textarea>
                            </div>

                            <div class="form-group">
                                <label for="contents">النص 2</label>
{{--                                <input type="text" class="form-control" name="text"  value="{{$settings->contents}}">--}}
                                <textarea name="contents" class="form-control" rows="8">{{$settings->contents}}</textarea>
                            </div>

                            <div class="form-group">
                                <label for="whats_app">واتس اب</label>
                                <input type="text" class="form-control" name="whats_app"  value="{{$settings->whats_app}}">
                            </div>

                            <div class="form-group">
                                <label for="instagram">انستيجرام</label>
                                <input type="text" class="form-control" name="instagram"  value="{{$settings->instagram}}">
                            </div>

                            <div class="form-group">
                                <label for="you_tube">يوتيوب</label>
                                <input type="text" class="form-control" name="you_tube"  value="{{$settings->you_tube}}">
                            </div>

                            <div class="form-group">
                                <label for="twitter">تويتر</label>
                                <input type="text" class="form-control" name="twitter"  value="{{$settings->twitter}}">
                            </div>

                            <div class="form-group">
                                <label for="facebook">فيس بوك</label>
                                <input type="text" class="form-control" name="facebook"  value="{{$settings->facebook}}">
                            </div>

                            <div class="form-group">
                                <label for="max_credit">الحد الاعلى للعموله</label>
                                <input type="text" class="form-control" name="max_credit"  value="{{$settings->max_credit}}">
                            </div>

                            <div class="form-group">
                                <label for="commission">عموله الموقع</label>
                                <input type="text" class="form-control" name="commission"  value="{{$settings->commission}}">
                            </div>

                            <div class="form-group">
                                <label for="image">صوره الموقع</label>
                                <input type="file" class="form-control-file" name="image">
                                <img src="{{asset($settings->image)}}" alt="000000" class="img-thumbnail" width="50px" height="50px">
                            </div>

                            <button type="submit" class="btn btn-primary btn-lg">تعديل</button>
                        </form>
                    </div>
                    <!-- /.box-body -->
                </div>

            </div>
        </div>
        <!-- /.box -->

    </section>
    <!-- /.content -->
@endsection
