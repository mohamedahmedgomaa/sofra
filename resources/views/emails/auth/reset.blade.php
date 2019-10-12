@component('mail::message')
    # Introduction

    Bank Eldame Reset Password.

    @component('mail::button', ['url' => 'http://ipda3.com'])
        Reset
    @endcomponent

    <p>Your reset code is : {{$code}}</p>

    Thanks,<br>
    {{ config('app.name') }}
@endcomponent
