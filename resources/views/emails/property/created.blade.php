<x-mail::message>
    # Property Created Successfully

    Hello <{{ $property->user->email }}>,

    Your property titled "{{ $property->title }}" has been successfully created and is currently "pending" approval.

    You will receive another email once it is published.

<x-mail::button :url="''">
View
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
