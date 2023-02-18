@component('mail::message')
# Dear concern


{!! $body !!}


@component('mail::panel')
    Please find the attachments
@endcomponent


@component('mail::button', ['url' => url("https://msrecruitingbd.com/contact/")])
    Contact with Us
@endcomponent

Thanks,<br>
<a href="{{ url('/') }}">
    {{ config('app.name') }}
</a>
<br>
Phone: +880 1738 556 980
<br>
website:
<a href="https://msrecruitingbd.com">
    https://msrecruitingbd.com
</a>
@endcomponent
