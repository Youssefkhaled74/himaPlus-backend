<x-mail::message>
# Hello,

you have new order #{{ $orderNo }}.

{{-- @component('mail::button', ['url' => config('app.url')])
ادخل على الموقع
@endcomponent --}}

Thanks,<br>
Hema Pules
</x-mail::message>
