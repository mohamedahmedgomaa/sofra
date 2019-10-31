@extends('front.index')
@inject('category', 'App\Model\Category')
<?php
$categories = $category->pluck('name', 'id')->toArray();
?>
@section('content')

    <main>
        <section class="account">
            <div class="form-section">
                <i class="fas fa-user-circle"></i>
                {{--                <form class="pt-3" method="post" action="{{url(route('restaurant.editProfile',$profile->id))}}"--}}
                {{--                      enctype="multipart/form-data">--}}
                {{--                    {!! csrf_field() !!}--}}
                {!! Form::model($profile, [
                    'action' => ['Front\frontController@editProfile',$profile->id],
                    'method' =>'post',
                    'files' => true
                ]) !!}

                <div class="form-group">
                    <input type="text" class="form-control" name="name" id="exampleInputText1"
                           aria-describedby="emailHelp" value="{{$profile->name}}">
                </div>
                <div class="form-group">
                    <input type="email" class="form-control" name="email" id="exampleInputEmail1"
                           value="{{$profile->email}}">
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" name="password" id="exampleInputPassword1"
                           aria-describedby="passwordHelp" placeholder="كلمة السر">
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" name="password_confirmation"
                           id="exampleInputPassword1" aria-describedby="passwordHelp" placeholder="تأكيد كلمة السر">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" name="phone"
                           aria-describedby="emailHelp" id="exampleInputTel1" value="{{$profile->phone}}">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" name="minimum" id="exampleInputText1"
                           aria-describedby="emailHelp" value="{{$profile->minimum}}">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" name="delivery" id="exampleInputText1"
                           aria-describedby="emailHelp" value="{{$profile->delivery}}">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" name="whats_app" id="exampleInputText1"
                           aria-describedby="emailHelp" value="{{$profile->whats_app}}">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" name="restaurant_phone" id="exampleInputText1"
                           aria-describedby="emailHelp" value="{{$profile->restaurant_phone}}">
                </div>

{{--                <select style="background: #e7e3e3;" class="custom-select custom-select-lg mb-3 mt-3 custom-width"--}}
{{--                        id="city_id"--}}
{{--                        name="city_id">--}}
{{--                    <option value="" selected>اختر المحافظه</option>--}}
{{--                    @foreach($cities as $city)--}}
{{--                        <option value="{{$city->id}}">{{$city->name}}</option>--}}
{{--                    @endforeach--}}
{{--                </select>--}}
                <div class="form-group">
                    @inject('city', 'App\Model\City')
                    {!! Form::select('city_id',$city->pluck('name', 'id')->toArray(),optional($profile->neighborhood)->city_id, [
                    'class'=>'custom-select custom-select-lg mb-3 mt-3 custom-width',
                    'id' => 'city_id',
                    'placeholder' => 'اختر المدينه'
                    ]) !!}
                </div>

                <div class="form-group">
                    @inject('neighborhood', 'App\Model\Neighborhood')
                    {!! Form::select('neighborhood_id',$neighborhood->pluck('name', 'id')->toArray(),$profile->neighborhood_id, [
                    'class'=>'custom-select custom-select-lg mb-3 mt-3 custom-width',
                    'id' => 'neighborhood_id',
                    'placeholder' => 'اختر الحى'
                    ]) !!}
                </div>

{{--                <select style="background: #e7e3e3;" class="custom-select custom-select-lg mb-3 mt-3 custom-width"--}}
{{--                        id="neighborhood_id"--}}
{{--                        name="neighborhood_id">--}}
{{--                    <option selected>اختر الحى</option>--}}
{{--                </select>--}}

                <div class="form-group">
                    {!! Form::select('categories[]',$categories,null, [
                    'class'=>'form-control select2',
                    'multiple' => 'multiple',
                    'placeholder' => 'اختر القسم'
                    ]) !!}
                </div>

                <div class="form-group radio" style="font-size: 25px;color: white;">
                    {!! Form::radio('state', 'open', true) !!} مفتوح
                    {!! Form::radio('state', 'close') !!} مغلق
                </div>


                <div class="form-group">
                    <input type="file" class="form-control-file" value="{{$profile->image}}" name="image"
                           id="exampleFormControlFile1">
                </div>

                <button type="submit" class="btn btn-primary btn-lg m-3">
                    <h5>إحفظ التغيرات</h5>
                </button>
                {!! Form::close() !!}
            </div>
        </section>
    </main>

    @push('js')
        <script>
            $("#city_id").change(function () {
                var city_id = $("#city_id").val();
                // alert('ddddd');
                var url = "{{url('api/restaurant/neighborhoods?city_id=')}}" + city_id;
                // console.log(url);
                $.ajax({
                    url: url,
                    type: 'get',
                    dataType: 'json',
                    success: function (data) {
                        // alert('aaaaaa');
                        $('#neighborhood_id').empty();
                        var option = '<option value="">اختر الحى</option>';
                        $("#neighborhood_id").append(option);
                        $.each(data.data, function (index, neighborhood) {
                            var option = '<option value="' + neighborhood.id + '">' + neighborhood.name + '</option>';
                            $("#neighborhood_id").append(option);
                        });
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log(textStatus, errorThrown);
                    }
                });
            });
        </script>
    @endpush
@endsection