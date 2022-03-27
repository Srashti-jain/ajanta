@component('mail::message')

{{ $content }}

**Platform:** {{ $browser }} on {{ $platform }}
**IP Address:** {{ $ipAddress }}<br>
**Time:** {{ $time->toCookieString() }}<br>

If this was you, you can ignore this alert. If you suspect any suspicious activity on your account, please change your password.

Regards,<br>{{ config('app.name') }}
@endcomponent
