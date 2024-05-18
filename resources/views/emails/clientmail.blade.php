<x-mail::message>
    Dear {{ $client->name }},

    It is our pleasure to inform you we have registered your case details in our system, pending action from our executives and field operatives.

    We hope to begin our good work on your case within the next 2 weeks. Should you require another opportunity to discuss more information or details on your case/cases, or if you may have any concerns to highlight to us, please feel free to reply to us via this email or call us via WhatsApp @ +65 8505 5484. For updates on your case, you may access it with your registered email as follows;

    Login Page: https://www.securre.net/dcmslogin
    Login ID: {{ $client->}}
    Password: [password.clientname.date]

    It is an honour to be working on your case/s, and we appreciate your faith in our good service. We look forward to impressing you with our expertise, meticulous attention to detail and efficient recovery process.

    In the meantime, please feel free to check out our website for more information and here's a small introduction on how we were listed on Lianhe Wanbao and Straits Times for our good work! (media link)

<x-mail::button :url="'/login'">
Button Text
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
