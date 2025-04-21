@component('mail::message')
# Subscription Invoice

Hi {{ $member->first_name }},

Thank you for your payment. Please find your invoice attached below.
**Invoice No:** {{ $invoiceNumber }}

@component('mail::panel')
**Member Name:** {{ $member->first_name }} {{ $member->last_name }}  
**Email:** {{ $member->email }}  
**Phone:** {{ $member->phone_number }}  
@endcomponent

@component('mail::panel')
**Payment ID:** {{ $subscription->order_id }}  
**Plan Type:** {{ ucfirst($subscription->plan_type) }}  
**Duration:** {{ $subscription->duration }} months  
**Product Count:** {{ $subscription->product_count ?? 'N/A' }}  
**Amount:** ₹{{ number_format($subscription->amount, 2) }}  
**Start Date:** {{ $subscription->start_date->format('d M Y') }}  
**End Date:** {{ $subscription->end_date->format('d M Y') }}  
@endcomponent

If you have any questions, please contact our support team.

Thanks,<br>
TIEPMD Team
@endcomponent
