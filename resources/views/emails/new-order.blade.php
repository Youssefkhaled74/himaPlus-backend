<x-mail::message>
# {{ __('emails.hello') }},

{{ __('emails.new_order_message', ['orderNo' => $orderNo]) }}.

{{-- @component('mail::button', ['url' => config('app.url')])
ادخل على الموقع
@endcomponent --}}

{{ __('emails.thanks') }},<br>
{{ __('emails.brand_name') }}
</x-mail::message>
