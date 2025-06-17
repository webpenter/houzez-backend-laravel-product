<x-mail::message>
    # Property Status Updated

    Hello <{{ $property->user->email }}>,

    The status of your property titled "{{ $property->title }}" has been updated.

<x-mail::panel>
    **New Status:** {{ ucfirst(str_replace('-', ' ', $property->property_status)) }}
</x-mail::panel>

    You can check your property status anytime from your dashboard.

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
