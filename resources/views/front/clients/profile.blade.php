@extends('front.index')
@section('content')

    <main class="register-bg">
        <section class="register">
            <div class="form-section">
                <img src="{{asset('')}}front/img/images/user.png" width="30%">
                <form class="pt-3" method="post" action="{{url(route('client.editProfile',$profile->id))}}"
                      enctype="multipart/form-data">
                    {!! csrf_field() !!}
                    <div class="form-group">
                        <input type="text" class="form-control" name="name" id="exampleInputText1"
                               aria-describedby="emailHelp" value="{{$profile->name}}" placeholder="الاسم">
                    </div>
                    <div class="form-group">
                        <input type="email" class="form-control" name="email" value="{{$profile->email}}" id="exampleInputEmail1"
                               placeholder="البريد الالكترونى">
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
                        <input type="text" class="form-control" name="phone" id="exampleInputTel1"  value="{{$profile->phone}}" placeholder="الجوال">
                    </div>

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


                    <div class="form-group">
                        <input type="file" value="{{$profile->image}}" class="form-control-file" name="image" id="exampleFormControlFile1">
                    </div>

                    <button type="submit" class="btn btn-primary btn-lg m-3">
                        <h5>دخول</h5>
                    </button>

                </form>
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
                        var option = '<option value="">اختر المدينة</option>';
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