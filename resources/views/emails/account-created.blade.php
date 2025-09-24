@extends('emails.layout')

@section('content')
<h2 style="margin:0 0 15px;color:#27ae60;">Welcome to Buy WebPenter 🎉</h2>
<p style="font-size:15px;color:#333;">
Dear {{ $user->name }},  
Your account has been created successfully on <strong>Buy WebPenter</strong>.
</p>

<p style="margin:20px 0;color:#555;">
You can now log in to your dashboard and start exploring properties.
</p>

<p>
    <a href="{{ url('/login') }}" 
       style="background:#27ae60;color:#fff;padding:12px 20px;text-decoration:none;border-radius:5px;">
       Login to Dashboard
    </a>
</p>
@endsection
