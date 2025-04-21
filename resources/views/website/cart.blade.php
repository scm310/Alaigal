@extends('frontend.layout')
@section('content')

@include('frontend.parital.topheader')


<style>
 
  h1 {
    text-align: center;
    margin-bottom: 20px;
  }

  .cart-items {
    max-height: 400px;
    overflow-y: auto;
    border-bottom: 1px solid #ddd;
    padding-bottom: 20px;
    margin-bottom: 20px;
  }



  .item-details {
    flex: 1;
  }

  .item-details h2,
  .item-details p {
    margin-bottom: 5px;
  }

  .price {
    color: #b12704;
    font-weight: bold;
  }

  .quantity-controls {
    display: flex;
    align-items: center;
    margin: 10px 0;
  }

  .quantity-btn {
    width: 30px;
    height: 30px;
    background-color: #9055fd;
    border: 1px solid #ddd;
    border-radius: 5px;
    text-align: center;
    line-height: 30px;
    cursor: pointer;
    transition: background 0.2s;
  }

  .quantity-btn:hover {
    background-color: #9055fd;
  
  }


  .quantity-input {
    width: 50px;
    text-align: center;
    margin: 0 10px;
    border: 1px solid #ddd;
    border-radius: 5px;
  }

  .delete-btn {
    background: #e74c3c;
    color: #fff;
    border: none;
    padding: 5px 10px;
    border-radius: 5px;
    cursor: pointer;
    transition: background 0.2s;
  }

  .delete-btn:hover {
    background: #c0392b;

  }

  .cart-summary {
    text-align: center;
    margin-top: 20px;
  }

  .cart-summary p {
    font-size: 15px;
  }

  .checkout-btn {

    background-color: #9055fd;
    color: #fff;
    border: none;
    padding: 10px 20px;
    border-radius: 5px;
    font-size: 16px;
    cursor: pointer;
    transition: background 0.2s;

  }

  .cart-items img {
    width: 100px;
    /* Default width */
    height: 75px;
    /* Default height */
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    /* Smooth zoom effect */
  }

  .cart-items img:hover {
    transform: scale(1.5);
    /* Enlarge the image on hover */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    /* Add shadow for better visibility */
    z-index: 10;
    /* Ensure it appears on top of other elements */
  }

 table th {
background-color:rgb(172, 203, 206) !important;
 }
 
 

  table td {
    border: none;
    /* Remove borders around individual cells */
  }
  

   .fold-text {
           
            white-space: nowrap;
           
        }


  @media(max-width : 600px) {
    .nl {
      width: 100%;
    }

    .nl1 {
      width: 100%;
    }
  }

  .card1-title {
    background-color: rgb(172, 203, 206) !important; /* Set the background color to gray */
    color: black; /* Optional: Set the text color to white to make it more readable */
    padding: 10px; Optional: Add padding for better spacing
  }

  .btn{
    background-color: #9055fd;
}
button{
    background-color: #9055fd;   
}
</style>

<div id="wrapper" class="container">
  @include('frontend.parital.categorylisting')

  <div class="shadow p-3 mb-5 mt-2 bg-white rounded">
    <h1> Quote </h1>
    <div class="row">
      <!-- Cart Items Section -->
      <div class="col-9 nl1">
        <div class="cart-items" id="cart-items">
          <table class="table no-space-table" >
            <thead>
              <tr >
              <th>
                <span>Product</span>
              </th>

              <th>
                Product Details
              </th>
             <th>
              GST
             </th>
             
             <th>
              Subtotal
             </th>
             <th></th>
             </tr>
            </thead>
          
            @php
            $subtotal = 0;
            @endphp
            <tbody>
              @if (session()->has('cart'))
              @php
              $cartItems = session('cart');
             
              @endphp


              @foreach ($cartItems as $index => $cartItem)
              @php
              $itemTotal = $cartItem['price'] * $cartItem['quantity'];
              $subtotal += $itemTotal;
              @endphp
              <tr class="cart-item">
                <td>
               
                  <img src="{{ asset('storage/app/public/' . ($cartItem['image'] ?? 'default_product.jpg')) }}" alt="Product {{ $index + 1 }}" class="img-fluid">
                  <div id="image-modal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.8); justify-content: center; align-items: center; z-index: 1000;">
                    <img id="modal-image" src="" style="max-width: 80%; max-height: 80%; border: 5px solid #fff; border-radius: 10px;">
                  </div>
                  <p style="font-size: 11px;"><b>{{ $cartItem['product_name'] }} <br> <span class="price" style="font-size: 11px;">₹{{ number_format($cartItem['price'], 2) }}</span></b></p>
                 
                </td>
                <td>
                  <div class="item-details">
                 
                    
                    <p>
                    <div class="quantity-controls">
                      <button class="quantity-btn decrement-btn">-</button>
                      <input type="tel" value="{{ $cartItem['quantity']}}" min="1" class="quantity-input" data-price="{{ $cartItem['price'] }}" data-product-id="{{ $cartItem['id'] }}">
                      <button class="quantity-btn increment-btn">+</button>
                    </div>
                    </p>
                    <p style="font-size: 10px;"> <b>Specification</b></p>
                    @if (is_array($cartItem['specification_name']) && is_array($cartItem['specification_value']))             
                            <p style="font-size: 10px;">
                                <strong>{{ $cartItem['specification_name'][0] }}:</strong>
                                {{ $cartItem['specification_value'][0] }}
                            </p>    
                  @endif 
                  <a style="font-size: 10px; text-decoration: none;" href="{{ route('product.detail',$cartItem['id'])}}">read more.....</a>

                  </div>
                </td>
                <td>
    <b>SGST</b>:{{ number_format( ($cartItem['price'] * $cartItem['gst'] / 100), 2) . " (" . $cartItem['gst'] . "%)" }}
    <br>
    <b>CGST</b>:{{ number_format( ($cartItem['price'] * $cartItem['gst'] / 100), 2) . " (" . $cartItem['gst'] . "%)" }}

                </td>
                <td>
                ₹ {{$subtotal+( $subtotal*$cartItem['tax'] ) / 100 ?? 0}}
                </td>
                
                <td>
                  <button class="delete-btn" data-product-id="{{ $cartItem['id'] }}">
                    <i class="fa fa-trash"></i>
                  </button>
                </td>
              </tr>
              @endforeach
              @else
              <tr>
                <td colspan="4" class="text-center">No items in the Quote.</td>
              </tr>
              @endif

            </tbody>


          </table>
        </div>
      </div>

      <!-- Cart Summary Section -->
      <div class="col-3 nl">
    <div class="card" style="margin-top: -16px;">
        <div class="card-body" >
        <h5 class="card1-title text-center">Quote Summary</h5>
            <h6 class="card-subtitle mb-2 text-muted text-center">
                Total Items: {{ session()->has('cart') ? count(session('cart')) : 0 }}
            </h6>
            <div class="Quote-summary">
    <div class="d-flex justify-content-between">
        <p>Subtotal:</p>
        <strong id="subtotal">0</strong>
    </div>
    <div class="d-flex justify-content-between">
        <p>SGST:</p>
        <strong id="sgst">0</strong>
    </div>
    <div class="d-flex justify-content-between">
        <p>CGST:</p>
        <strong id="cgst">0</strong>
    </div>
    <hr>
    <div class="d-flex justify-content-between">
        <p>Total:</p>
        <strong id="total">0</strong>
    </div>

    <!-- Centered Download Quote Button -->
    <div class="text-center">
        <button id="download-btn" class="checkout-btn">Download Quote</button>
    </div>
</div>

  
        </div>
    </div>
</div>
    </div>
  </div>
</div>

@include('frontend.parital.footer')

<!-- total purchase -->
<script>
    function updateCartSummary() {
        fetch("{{ route('cart.summary') }}")
            .then(response => response.json())
            .then(data => {
                // Create a formatter for Indian currency
                const indianCurrencyFormatter = new Intl.NumberFormat('en-IN', {
                    style: 'currency',
                    currency: 'INR',
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });

                document.getElementById('subtotal').innerText = indianCurrencyFormatter.format(data.subtotal);
                document.getElementById('sgst').innerText = indianCurrencyFormatter.format(data.sgst);
                document.getElementById('cgst').innerText = indianCurrencyFormatter.format(data.cgst);
                document.getElementById('total').innerText = indianCurrencyFormatter.format(data.total);
                document.querySelector('.card-subtitle').innerText = `Total Items: ${data.totalItems}`;
            })
            .catch(error => console.error('Error updating cart summary:', error));
    }

    setInterval(updateCartSummary, 1000); // Call every second to refresh
    updateCartSummary(); // Initial call on page load
</script>


<script>
  document.addEventListener('DOMContentLoaded', () => {
    const images = document.querySelectorAll('.cart-items img');
    const modal = document.getElementById('image-modal');
    const modalImage = document.getElementById('modal-image');

    images.forEach(image => {
      image.addEventListener('click', () => {
        modalImage.src = image.src;
        modal.style.display = 'flex';
      });
    });

    modal.addEventListener('click', () => {
      modal.style.display = 'none';
    });
  });
</script>

<script>
  quantityInputs.forEach(input => {
    input.addEventListener('input', updateTotals);

    // Optional: Handle increment and decrement buttons
    const quantityControls = input.closest('.quantity-controls');
    const decrementBtn = quantityControls ? quantityControls.querySelector('.decrement-btn') : null;
    const incrementBtn = quantityControls ? quantityControls.querySelector('.increment-btn') : null;

    if (decrementBtn) {
      decrementBtn.addEventListener('click', () => {
        if (input.value > 1) {
          input.value = parseInt(input.value, 10) - 1;
          updateTotals();
        }
      });
    }

    if (incrementBtn) {
      incrementBtn.addEventListener('click', () => {
        input.value = parseInt(input.value, 10) + 1;
        updateTotals();
      });
    }
  });
</script>

<script>
  $(document).ready(function () {
    // Decrement button click event
    $(".decrement-btn").on("click", function () {
      let input = $(this).siblings(".quantity-input");
      let currentQuantity = parseInt(input.val());
      let productId = input.data("product-id");

      if (currentQuantity > 1) {
        input.val(currentQuantity - 1); // Update UI first
        updateQuantity(productId, currentQuantity - 1);
      }
    });

    // Increment button click event
    $(".increment-btn").on("click", function () {
      let input = $(this).siblings(".quantity-input");
      let currentQuantity = parseInt(input.val());
      let productId = input.data("product-id");

      input.val(currentQuantity + 1); // Update UI first
      updateQuantity(productId, currentQuantity + 1);
    });

    // Input change event
    $(".quantity-input").on("input", function () {
      let input = $(this);
      let quantity = parseInt(input.val());
      let productId = input.data("product-id");

      if (quantity > 0) {
        updateQuantity(productId, quantity);
      } else {
        alert("Quantity must be at least 1.");
        input.val(1); // Reset to minimum quantity
        updateQuantity(productId, 1);
      }
    });

    // Function to update quantity via AJAX
    function updateQuantity(productId, quantity) {
      $.ajax({
        url: "{{ route('cart.updateQuantity') }}",
        method: "POST",
        data: {
          _token: "{{ csrf_token() }}",
          product_id: productId,
          quantity: quantity,
        },
        success: function (response) {
          if (response.success) {
            // Update SGST, CGST, and subtotal in the UI
            $(`.cart-item input[data-product-id="${productId}"]`)
              .closest("tr")
              .find("td:nth-child(3)")
              .html(`
                <b>CGST</b>: ₹${response.cgst.toFixed(2)} (${response.gst}%)<br>
                <b>SGST</b>: ₹${response.sgst.toFixed(2)} (${response.gst}%)
              `);

            // Update the row subtotal
            $(`.cart-item input[data-product-id="${productId}"]`)
              .closest("tr")
              .find("td:nth-child(4)")
              .text(`₹ ${response.rowSubtotal.toFixed(2)}`);

            
           
          }
        },
        error: function (error) {
          console.error("Error updating quantity:", error);
        },
      });
    }
  });
</script>



<script>
  document.querySelectorAll('.delete-btn').forEach(button => {
    button.addEventListener('click', function() {
     
      const productId = this.getAttribute('data-product-id');
      console.log(productId);
      // Make the AJAX request to delete the product
      fetch(`/cart/remove/${productId}`, {
          method: 'DELETE',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
          },
        })
        .then(response => response.json())
        .then(data => {
          // If successful, remove the row from the table
          if (data.success) {
            this.closest('tr').remove(); // Removes the entire row
          } else {
            alert('Failed to remove item.');
          }
        })
        .catch(error => console.error('Error:', error));
    });
  });
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script>
  // Check if cartData is an array
const cartData = @json(session('cart', [])); // Cart items data from session
console.log(cartData); // Inspect the structure of cartData

document.getElementById('download-btn').addEventListener('click', function() {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF();

    // Title of the PDF
    doc.text('Invoice', 10, 10);

    let yOffset = 20;

    // Check if cartData is an array or object and iterate accordingly
    if (Array.isArray(cartData)) {
        cartData.forEach(item => {
            // Product details
            doc.text(`Product: ${item.product_name}`, 10, yOffset);
            yOffset += 10;
            doc.text(`Price: ₹${item.price}`, 10, yOffset);
            yOffset += 10;
            doc.text(`Quantity: ${item.quantity}`, 10, yOffset);
            yOffset += 10;
            doc.text(`Total Price: ₹${item.price * item.quantity}`, 10, yOffset);
            yOffset += 10;
            
            // Adding product specifications
            item.specification_name.forEach((specName, index) => {
                doc.text(`${specName}: ${item.specification_value[index]}`, 10, yOffset);
                yOffset += 10;
            });

            // GST and Tax details
            doc.text(`GST: ${item.gst}%`, 10, yOffset);
            yOffset += 10;
            doc.text(`Tax: ₹${(item.price * item.quantity * item.tax) / 100}`, 10, yOffset);
            yOffset += 10;

            // Add image (optional)
            if (item.image) {
                const imgPath = item.image; // Adjust image path if necessary
                doc.addImage(imgPath, 'JPEG', 150, yOffset, 40, 40); // Add image to PDF
                yOffset += 50; // Adjust position after image
            }
        });
    } else {
        // If cartData is not an array, handle it as an object
        for (let productId in cartData) {
            let item = cartData[productId];
            // Same product detail handling as above
            doc.text(`Product: ${item.product_name}`, 10, yOffset);
            yOffset += 10;
            doc.text(`Price: ₹${item.price}`, 10, yOffset);
            yOffset += 10;
            doc.text(`Quantity: ${item.quantity}`, 10, yOffset);
            yOffset += 10;
            doc.text(`Total Price: ₹${item.price * item.quantity}`, 10, yOffset);
            yOffset += 10;
            
            // Adding product specifications
            item.specification_name.forEach((specName, index) => {
                doc.text(`${specName}: ${item.specification_value[index]}`, 10, yOffset);
                yOffset += 10;
            });

            // GST and Tax details
            doc.text(`GST: ${item.gst}%`, 10, yOffset);
            yOffset += 10;
            doc.text(`Tax: ₹${(item.price * item.quantity * item.tax) / 100}`, 10, yOffset);
            yOffset += 10;

            // Add image (optional)
            if (item.image) {
                const imgPath = item.image; // Adjust image path if necessary
                doc.addImage(imgPath, 'JPEG', 150, yOffset, 40, 40); // Add image to PDF
                yOffset += 50; // Adjust position after image
            }
        }
    }

    // Add totals or any other summary data if needed
    doc.text('--- End of Invoice ---', 10, yOffset);

    // Trigger the download of the PDF
    doc.save('invoice.pdf');
});

</script>

</body>

@endsection