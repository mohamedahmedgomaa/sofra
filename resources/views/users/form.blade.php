@inject('role', 'App\Model\Role')
<?php
$roles = $role->pluck('display_name', 'id')->toArray();
?>
<div class="form-group">
    <label for="name">الاسم</label>
    {!! Form::text('name', null , ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    <label for="email">البريد الالكترونى</label>
    {!! Form::email('email', null, ['class'=>'form-control']) !!}
</div>

<div class="form-group">
    <label for="password">كلمه المرور</label>
    {!! Form::password('password', ['class'=>'form-control']) !!}
</div>

<div class="form-group">
    <label for="password_confirmation">تاكيد كلمه المرور</label>
    {!! Form::password('password_confirmation', ['class'=>'form-control']) !!}
</div>

<div class="form-group">
    <label for="roles_list">قائمه الرتب</label>
    {!! Form::select('roles_list[]',$roles,null, [
    'class'=>'form-control select2',
    'multiple' => 'multiple'
    ]) !!}
</div>

<div class="form-group">
    <button class="btn btn-primary" type="submit">اضافه</button>
</div>