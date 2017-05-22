@component('mail::message')
# Confirmation email

Hallo {{ $user->fullname }}! Welkom bij CRPG! :)
Klik op de link hieronder om je email te bevestigen.

{{ route('register.confirm', ['token' => $user->verify_code]) }}

See you at CRPG!
@endcomponent