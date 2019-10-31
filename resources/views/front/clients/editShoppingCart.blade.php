@extends('front.index')
@inject('payment_methods', 'App\Model\PaymentMethod')
@section('content')

    <main class="register-bg">
        <section class="register">
            <div class="form-section">
                <img src="{{asset('')}}front/img/images/user.png" width="30%">
                <form class="pt-3" method="post" action="{{url('client/add-order')}}"
                      enctype="multipart/form-data">
                    {!! csrf_field() !!}
{{--                    <div class="form-group">--}}
{{--                        <input type="text" class="form-control" name="name" id="exampleInputText1"--}}
{{--                               aria-describedby="emailHelp" value="{{$model->note}}" placeholder="ملاحظات">--}}
{{--                    </div>--}}


                    <div class="form-group">
                        {!! Form::textarea('note', null , [
                            'class' => 'form-control',
                            'placeholder' => 'ملاحظات'
                        ]) !!}
                    </div>

                    <div class="form-group">
                        <input type="text" class="form-control" name="address" id="exampleInputText1"
                               aria-describedby="emailHelp" placeholder="العنوان">
                    </div>

                    <div class="form-group">
                    {!! Form::select('payment_method_id',$payment_methods->pluck('name', 'id') , old('payment_method_id'), [
                         'class'=>'custom-select custom-select-lg mb-3 mt-3 custom-width',
                         'placeholder' => 'اختر طريقه الدفع',
                         'required' => 'required'
                         ]) !!}
                    </div>

                    <button type="submit" class="btn btn-primary btn-lg m-3">
                        <h5>انهاء الشراء</h5>
                    </button>

                </form>
            </div>

        </section>
    </main>
@endsection