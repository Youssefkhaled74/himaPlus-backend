<x-mail::message>
# {{ __('emails.hello') }},

{{ $message }}.

{{-- @component('mail::button', ['url' => config('app.url')])
ادخل على الموقع
@endcomponent --}}

{{ __('emails.thanks') }},<br>
{{ __('emails.brand_name') }}
</x-mail::message>
