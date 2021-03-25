@component('mail::message')
# Introduction

your OTP is {{ $data['otp'] }}.


Thanks,<br>
{{ config('app.name') }}
@endcomponent
