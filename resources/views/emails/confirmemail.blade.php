@component('mail::message')
# Confirmation email

Hallo {{ $user->fullname }}! Welkom bij CRPG! :)
Klik op de link hieronder om je email te bevestigen.

{{ route('confirm', ['token' => $user->verify_code]) }}

Thanks,<br>
{{ config('app.name') }}
@endcomponent