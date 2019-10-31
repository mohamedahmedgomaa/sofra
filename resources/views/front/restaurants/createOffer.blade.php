@extends('front.index')
@section('content')


    <section class="register add-offer">
        <h3 style="text-align: center;margin-bottom: 3rem">إضافة عرض جديد</h3>
        <div class="form-section">
            <form class="pt-2" method="post" action="{{url(route('restaurant.postCreateOffer'))}}" enctype="multipart/form-data">
                {!! csrf_field() !!}

                <div class="form-group">
                    <div class="image-upload mb-2">
                        <label for="file-input">
                            <img src="{{asset('')}}front/img/images/Layer 1.png" width="100%" class="image-upload1">
                        </label>
                        <input id="file-input" type="file" name="image">
                    </div>
                    <h4 style="color: #230040;margin-bottom: 2rem">صورة العرض</h4>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" name="name" id="exampleInputText1" aria-describedby="emailHelp"
                           placeholder="اسم العرض">
                </div>
                <div class="form-group">
                    <textarea rows="5" class="form-control" name="content" id="exampleInputText1" aria-describedby="emailHelp"
                              placeholder="وصف مختصر"></textarea>
                </div>
{{--                <div class="form-group">--}}
{{--                    <input type="number" class="form-control" name="price" id="exampleInputText1" aria-describedby="emailHelp"--}}
{{--                           placeholder="السعر">--}}
{{--                </div>--}}

                <div class="form-row">
                    <h6 style="color: #230040;align-self: center;" class="px-2">من</h6>
                    <input type="text" name="from" id="demo-3_1" class="form-control-sm px-1">
                    <h6 style="color: #230040;align-self: center;" class="px-2">إلى</h6>
                    <input type="text" name="to" id="demo-3_2" class="form-control-sm px-1">
                </div>
                <button type="submit" class="btn btn-primary">
                    <a style="display: inline">إضافة</a>
                </button>
            </form>
        </div>
        <!--form-section-->
    </section>


@endsection