@component('mail::message')
# Confirmation email

Hallo {{ $user->fullname }}! Welkom bij CRPG! :)
Klik op de link hieronder om je email te bevestigen.

{{ route('forgotpassword', ['token' => $user->verify_code]) }}

Thanks,<br>
{{ config('app.name') }}
@endcomponent