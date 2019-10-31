@extends('front.index')
@section('content')

    <section class="contact">
    <div class="form-section">
        <h4>تواصل معنا</h4>
        <form class="pt-3" method="post" action="{{url(route('createContactUs'))}}">
            {!! csrf_field() !!}
            <div class="form-group">
                <input type="text" class="form-control" name="name" id="exampleInputText1" aria-describedby="emailHelp" placeholder="الاسم كاملاً">
            </div>
            <div class="form-group">
                <input type="email" class="form-control" name="email" id="exampleInputEmail1" placeholder="البريد الإلكترونى">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="phone" id="exampleInputTel1" placeholder="الجوال">
            </div>
            <div class="form-group">
                <textarea class="form-control" name="message" placeholder="ماهى رسالتك ؟" rows="4"></textarea>
            </div>
            <div class="form-group radio">
                {!! Form::radio('type', 'complaint', true) !!} شكوى
                {!! Form::radio('type', 'suggestion') !!} إقتراح
                {!! Form::radio('type', 'enquiry') !!}  إستعلام
            </div>

            <!-- Default unchecked -->
{{--            <div class="custom-control custom-radio">--}}
{{--                <input type="radio" class="custom-control-input" id="defaultUnchecked" name="defaultExampleRadios">--}}
{{--                <label class="custom-control-label" for="defaultUnchecked">Default unchecked</label>--}}
{{--            </div>--}}

{{--            <!-- Default checked -->--}}
{{--            <div class="custom-control custom-radio">--}}
{{--                <input type="radio" class="custom-control-input" id="defaultChecked" name="defaultExampleRadios" checked>--}}
{{--                <label class="custom-control-label" for="defaultChecked">Default checked</label>--}}
{{--            </div>--}}

            <button type="submit" class="btn btn-primary btn-lg m-3">
                <h5>إرسال</h5>
            </button>

        </form>
    </div>

</section>

@endsection