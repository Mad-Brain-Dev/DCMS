<x-mail::message>
Your client account is ready!!

<x-mail::button :url="'/login'">
Button Text
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>

