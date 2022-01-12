@component('mail::message')
# Hello, {{ $data->id_loginid }}!

You are receiving this email because we received a Personal Identification Number (PIN) recovery request for your account.

@component('mail::panel')
PIN number: <strong>{{ $data->pin }}</strong>
@endcomponent

If you did not request this, no further action is required.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
