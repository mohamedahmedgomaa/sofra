@inject('models', 'App\Model\City')
<div class="form-group">
    <label for="name">{{trans('admin.name')}}</label>
    {!! Form::text('name', null , [
        'class' => 'form-control'
    ]) !!}
</div>

<div class="form-group">
    <label for="city_id">{{trans('admin.city')}}</label>
    {!! Form::select('city_id',$models->pluck('name', 'id') , old('city_id'),
     ['class'=>'form-control', 'placeholder' => '..............']) !!}
</div>

<div class="form-group">
    <button class="btn btn-primary" type="submit">Submit</button>
</div>