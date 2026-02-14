<x-mail::message>
# Hello,

{{ $message }}.

{{-- @component('mail::button', ['url' => config('app.url')])
ادخل على الموقع
@endcomponent --}}

Thanks,<br>
Hema Pules
</x-mail::message>
