@component('mail::message')
# Reset Password

Klik tombol di bawah ini untuk mereset password Anda:

@component('mail::button', ['url' => $url])
Reset Password
@endcomponent

Jika Anda tidak meminta reset password, abaikan email ini.

Terima kasih,<br>
{{ config('app.name') }}
@endcomponent
