@component('mail::message')
# {{ $content->subject }}
<br>
{{ $content->message }}.
<hr>
<code>{{ __('You can replay to me on') }} {{ $content->email }}</code>
<br>
{{ __('Thanks,') }}<br>
{{ $content->name }}
@endcomponent
