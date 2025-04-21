<h1>Quote for Client</h1>
<p>Quote ID: {{ $quote->id }}</p>
<p>Date: {{ $quote->date->format('d-m-Y') }}</p>

<table border="1" cellpadding="10">
    <thead>
        <tr>
            <th>Product Name</th>
            <th>Brand</th>
            <th>Sales Price</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($quote->items as $item)
            <tr>
                <td>{{ $item->product_name }}</td>
                <td>{{ $item->brand }}</td>
                <td>{{ number_format($item->sales_price, 2) }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
