@extends('front.index')
@section('content')

    <main class="register-bg">
        <section class="register">
            <div class="form-section">
                <img src="{{asset('')}}front/img/images/user.png" width="30%">
                <form class="pt-3" method="post" action="{{url(route('post.register.client'))}}" enctype="multipart/form-data">
                    {!! csrf_field() !!}
                    <div class="form-group">
                        <input type="text" class="form-control" name="name" id="exampleInputText1"
                               aria-describedby="emailHelp" placeholder="الاسم">
                    </div>
                    <div class="form-group">
                        <input type="email" class="form-control" name="email" id="exampleInputEmail1"
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
                        <input type="text" class="form-control" name="phone" id="exampleInputTel1" placeholder="الجوال">
                    </div>

                    <select style="background: #e7e3e3;" class="custom-select custom-select-lg mb-3 mt-3 custom-width"
                            id="city_id"
                            name="city_id">
                        <option value="" selected>اختر المحافظه</option>
                        @foreach($cities as $city)
                            <option value="{{$city->id}}">{{$city->name}}</option>
                        @endforeach
                    </select>

                    <select style="background: #e7e3e3;" class="custom-select custom-select-lg mb-3 mt-3 custom-width"
                            id="neighborhood_id"
                            name="neighborhood_id">
                        <option value="" selected>اختر المدينة</option>
                    </select>


                    <div class="form-group">
                        <input type="file" class="form-control-file" name="image" id="exampleFormControlFile1">
                    </div>
                    <div class="form-group form-check">
                        <input type="checkbox" class="form-check-input" id="exampleCheck1">
                        <label class="form-check-label" for="exampleCheck1">بإنشاء حسابك أنت توافق على الشروط الخاصة
                            بسفرة</label>
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