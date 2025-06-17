<x-mail::message>
    # Subscription Successful

    Hello <{{ $user->email }}>,

    You’ve successfully subscribed to the "{{ $plan->name }}" plan. Here are the details:

<x-mail::panel>
    **Plan ID:** {{ $plan->plan_id }}

    **Billing Method:** {{ $plan->billing_method }}

    **Interval:** Every {{ $plan->interval_count }} {{ $plan->billing_method }}(s)

    **Base Price:** ${{ $plan->price }} ({{ strtoupper($plan->currency) }})

    **Listings Allowed:** {{ $plan->number_of_listings ?? 'Unlimited' }}

    **Images Allowed per Listing:** {{ $plan->number_of_images ?? 'Unlimited' }}

    **Start Date:** {{ \Carbon\Carbon::parse($startDate)->toFormattedDateString() }}

    **End Date:** {{ \Carbon\Carbon::parse($endDate)->toFormattedDateString() }}
</x-mail::panel>

    You can manage your subscription from your dashboard.

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
