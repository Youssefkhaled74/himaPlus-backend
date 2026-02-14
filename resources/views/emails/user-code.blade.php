<x-mail::message>
# Hello,

the code to verify your account : {{ $code }} .

{{-- <x-mail::button :url="''">
Button Text
</x-mail::button> --}}

{{-- @component('mail::button', ['url' => config('app.url')])
ادخل على الموقع
@endcomponent --}}

Thanks,<br>
Hema Pules
</x-mail::message>
