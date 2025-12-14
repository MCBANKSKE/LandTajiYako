@component('mail::layout')
{{-- Header --}}
@slot('header')
@component('mail::header', ['url' => config('app.url')])
{{ config('app.name') }}
@endcomponent
@endslot

# New Contact Form Submission

**Name:** {{ $details['name'] }}

**Email:** {{ $details['email'] }}

**Subject:** {{ $details['subject'] }}

**Message:**
{{ $details['message'] }}

{{-- Footer --}}
@slot('footer')
@component('mail::footer')
© {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
@endcomponent
@endslot
@endcomponent
