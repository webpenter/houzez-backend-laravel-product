@extends('emails.layout')

@section('content')
<h2 style="margin:0 0 15px;color:#2980b9;">Renew Your Subscription</h2>
<p style="font-size:15px;color:#333;">
Dear {{ $user->name }},  
Your subscription package <strong>{{ $plan->name }}</strong> will expire on  
<strong>{{ $expiry_date }}</strong>.
</p>

<p style="margin:20px 0;color:#555;">
To avoid interruption in your property listings, please renew your package before the expiry date.
</p>

<p>
    <a href="{{ url('/pricing') }}" 
       style="background:#2980b9;color:#fff;padding:12px 20px;text-decoration:none;border-radius:5px;">
       Renew Now
    </a>
</p>
@endsection
