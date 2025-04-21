@extends('admin_layouts.app')

@section('content')
    <h1>Quote Invoice</h1>
    <table border="1">
        <tr>
            <th>Product</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Subtotal</th>
        </tr>
        @foreach(json_decode($quote->cart_data) as $item)
        <tr>
            <td>{{ $item->product_name }}</td>
            <td>{{ $item->quantity }}</td>
            <td>₹{{ number_format($item->price, 2) }}</td>
            <td>₹{{ number_format($item->price * $item->quantity, 2) }}</td>
        </tr>
        @endforeach
    </table>
    <h3>Total: ₹{{ number_format($quote->total, 2) }}</h3>

    @endsection

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#download-btn').click(function() {
            let products = [];

            $('.cart-item').each(function() {
                let product = {
                    product_name: $(this).find('p b').text().trim(),
                    product_details: $(this).find('.item-details p:nth-child(4)').text().trim(),
                    price: parseFloat($(this).find('.price').text().replace('₹', '').trim()),
                    quantity: parseInt($(this).find('.quantity-input').val()),
                    sgst: parseFloat($(this).find('td:nth-child(3)').html().match(/(\d+\.\d+)/g)[0]), // Extract SGST
                    cgst: parseFloat($(this).find('td:nth-child(3)').html().match(/(\d+\.\d+)/g)[1]), // Extract CGST
                    subtotal: parseFloat($(this).find('td:nth-child(4)').text().replace('₹', '').trim())
                };
                products.push(product);
            });

            if (products.length === 0) {
                alert("No items in the quote!");
                return;
            }

            $.ajax({
                url: "{{ route('customer-quotation.store') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    products: products
                },
                success: function(response) {
                    alert(response.message);
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                    alert("Error storing the quote. Check console for details.");
                }
            });
        });
    });
</script>

