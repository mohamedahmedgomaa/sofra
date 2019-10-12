@inject('models', 'App\Model\Restaurant')
<div class="form-group">
    <label for="note">{{trans('admin.note')}}</label>
    {!! Form::text('note', null , [
        'class' => 'form-control'
    ]) !!}
</div>

<div class="form-group">
    <label for="amount">{{trans('admin.amount')}}</label>
    {!! Form::text('amount', null , [
        'class' => 'form-control'
    ]) !!}
</div>


<div class="form-group">
    <label for="restaurant_id">{{trans('admin.restaurant')}}</label>
    {!! Form::select('restaurant_id',$models->pluck('name', 'id') , old('restaurant_id'),
     ['class'=>'form-control', 'placeholder' => '..............']) !!}
</div>


<div class="form-group">
    <button class="btn btn-primary" type="submit">Submit</button>
</div>