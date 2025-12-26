@component('mail::message')
# Low Stock Alert

The following product is running low on stock:

**Product:** {{ $product->name }}

**Stock Quantity:** {{ $product->stock_quantity }}

Please update the stock quantity as soon as possible.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
