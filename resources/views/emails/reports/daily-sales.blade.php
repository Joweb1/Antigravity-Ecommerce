@component('mail::message')
# Daily Sales Report

Here is the sales report for today:

**Total Sales:** ${{ number_format($dailySales, 2) }}

Thanks,<br>
{{ config('app.name') }}
@endcomponent
