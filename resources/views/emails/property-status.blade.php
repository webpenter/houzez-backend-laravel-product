@extends('emails.layout')

@section('content')
<h2 style="margin:0 0 15px;color:#2c3e50;">Property Status Updated</h2>
<p style="font-size:15px;color:#333;">
Dear {{ $user->name }},  
Your property <strong>{{ $property->title }}</strong> has been updated to status:  
<strong style="color:#27ae60;">{{ ucfirst($status) }}</strong>.
</p>

<p style="margin:20px 0;color:#555;">
You can view the property details by clicking below:
</p>

<p>
    <a href="{{ url('/property/'.$property->slug) }}" 
       style="background:#27ae60;color:#fff;padding:12px 20px;text-decoration:none;border-radius:5px;">
       View Property
    </a>
</p>
@endsection
