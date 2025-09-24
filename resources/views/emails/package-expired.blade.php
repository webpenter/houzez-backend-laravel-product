@extends('emails.layout')

@section('content')
<h2 style="margin:0 0 15px;color:#c0392b;">Your Package Has Expired</h2>
<p style="font-size:15px;color:#333;">
Dear {{ $user->name }},  
Your subscription package <strong>{{ $plan->name }}</strong> has expired on  
<strong>{{ $expired_date }}</strong>.
</p>

<p style="margin:20px 0;color:#555;">
Upgrade now to continue enjoying our property listing services.
</p>

<p>
    <a href="{{ url('/pricing') }}" 
       style="background:#c0392b;color:#fff;padding:12px 20px;text-decoration:none;border-radius:5px;">
       Renew Package
    </a>
</p>
@endsection
