@extends('front.index')
@section('content')


    <section class="register">

        @include('flash::message')

        <div class="form-section">
            <form class="pt-3" method="post" action="{{url(route('addProductCreate'))}}" enctype="multipart/form-data">
                {!! csrf_field() !!}

                <div class="form-group">
                    <div class="image-upload mb-2">
                        <label for="file-input">
                            <img src="{{asset('')}}front/img/images/Layer 1.png" width="100%" class="image-upload1">
                        </label>
                        <input id="file-input" name="image" type="file">
                    </div>
                    <h4 style="color: #230040;margin-bottom: 2rem">صورة المنتج</h4>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" name="name" id="exampleInputText1" aria-describedby="emailHelp" placeholder="اسم المنتج">
                </div>
                <div class="form-group">
                    <textarea rows="5" class="form-control" name="description" id="exampleInputText1" aria-describedby="emailHelp" placeholder="وصف مختصر"></textarea>
                </div>
                <div class="form-group">
                    <input type="number" class="form-control" name="price" id="exampleInputText1" aria-describedby="emailHelp" placeholder="السعر">
                </div>
                <div class="form-group">
                    <input type="number" class="form-control" name="offer" id="exampleInputText1" aria-describedby="emailHelp" placeholder="العرض">
                </div>
                <div class="form-group">
                    <input type="number" class="form-control" name="time" id="exampleInputText1" aria-describedby="emailHelp" placeholder="مدة التجهيز">
                </div>
                <button type="submit" class="btn btn-primary">
                    إضافة
                </button>
            </form>
        </div>
        <!--form-section-->
    </section>



@endsection