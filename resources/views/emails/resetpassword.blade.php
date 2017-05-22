@component('mail::message')
# Reset password

Wachtwoord vergeten? Gebruik de link hieronder om je wachtwoord te resetten.

{{ route('resetpassword', ['token' => $token]) }}

Al heb je dit niet zelf aangevraagd dan kun je dit mailtje negeren (en deels een beetje paranoia worden).

Met liefde, CRPG
@endcomponent