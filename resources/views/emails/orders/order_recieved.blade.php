@component('mail::message')
# The Order {{$data['invoice_no']}} Recieved

## Amount: ${{$data['amount']}}
### For: {{$data['name']}}, {{$data['email']}}

@component('mail::button', ['url' => ''])
VIEW ORDER
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent