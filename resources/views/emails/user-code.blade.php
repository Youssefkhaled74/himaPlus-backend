<x-mail::message>
# {{ __('emails.hello') }},

{{ __('emails.verify_code_message') }} {{ $code }} .

{{-- <x-mail::button :url="''">
Button Text
</x-mail::button> --}}

{{-- @component('mail::button', ['url' => config('app.url')])
ادخل على الموقع
@endcomponent --}}

{{ __('emails.thanks') }},<br>
{{ __('emails.brand_name') }}
</x-mail::message>
