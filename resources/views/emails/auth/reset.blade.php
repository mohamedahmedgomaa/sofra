@component('mail::message')
# Introduction

Bank Eldame Reset Password.

@component('mail::button', ['url' => url(route('auth.newPasswordClient'))])
    Sofra
@endcomponent

<p>Your reset code is : {{$code}}</p>

Thanks,<br>
{{ config('app.name') }}
@endcomponent
