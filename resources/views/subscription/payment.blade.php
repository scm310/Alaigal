@extends('memberlayout.navbar')
<style>
 /* Main Container */
    .container-wrapper {
        width: 100%;
        max-width: 1400px;
        margin: 0 auto;
        background: white;
        padding: 15px;
        border-radius: 10px;
        box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.2);
        transition: margin-right 0.3s ease-in-out, width 0.3s ease-in-out;
        overflow: hidden;
    }
 .header {
            background: linear-gradient(to right, #1d2b64, #f8cdda);
            color: white ;
            padding: 11px;
            text-align: center;
            font-size: 22px;
            font-weight: bold;
            border-radius: 8px;
            margin-bottom: 15px;
            height: 70px;
        }
    .header-gradient {
    background: linear-gradient(to right, #1d2b64, #f8cdda);
    color: white !important;
    font-weight: bold !important;
    text-align: center;
    font-size:18px;
    border-radius:8px;
}
@media (max-width: 768px) {
    .header { font-size: 16px; padding: 10px; }
    .header-gradient { font-size: 14px; }
    .subscription-card { margin-bottom: 20px !important; }
    .container { padding: 10px !important; }
    .product-btn { padding: 5px 8px !important; font-size: 12px; }
    .btn-primary { font-size: 12px !important; padding: 8px 12px !important; }
    .table th, .table td { font-size: 12px !important; padding: 6px; }
    .row > .col-md-6 { margin-bottom: 15px; }
}
</style>

@php
    use Carbon\Carbon;
    $member = Auth::guard('member')->user();
    $latestDirectory = $member ? \App\Models\Subscription::where('member_id', $member->id)
        ->where('plan_type', 'member_directory')
        ->where('payment_status', 1)
        ->whereDate('end_date', '>=', Carbon::now())
        ->latest('end_date')
        ->first() : null;

    $canRenewMemberDirectory = true;
    if ($latestDirectory && Carbon::now()->lt(Carbon::parse($latestDirectory->end_date))) {
        $canRenewMemberDirectory = false;
    }
@endphp

@section('content')
<div class="container-wrapper mt-4">
    <div class="header">Choose Your Subscription & Confirm Payment</div>
    <div class="container p-5" style="background-color: #fff; border-radius: 10px;">
        <div class="row">
            <div class="col-md-6">
                <div class="card shadow-sm" style="background-color: #e7cfcf;">
                    <div class="card-header header-gradient">Choose Your Subscription</div>
                    <div class="card-body">
                        <h5>Access to TIEPMD Member Directory</h5>
                        <label><input type="radio" name="member_plan" value="6" {{ !$canRenewMemberDirectory ? 'disabled' : 'checked' }} onchange="updateCart()"> 6 months - ₹600 + GST</label><br>
                        <label><input type="radio" name="member_plan" value="12" {{ !$canRenewMemberDirectory ? 'disabled' : '' }} onchange="updateCart()"> 1 year- ₹1200 + GST</label>
                        @if (!$canRenewMemberDirectory)
                        <div class="alert alert-info mt-2">You can renew Member Directory after your subscription ends.</div>
                        @endif

                        <hr>

                        <h5>Access to TIEPMD Marketplace</h5>
                        <label><input type="checkbox" id="enable_marketplace"> Enable Marketplace Access</label>

                        <div id="marketplace_options" style="display: none;">
                            <label><input type="radio" name="marketplace_plan" value="6" checked onchange="updateCart()"> 6 months - ₹1200 + GST</label><br>
                            <label><input type="radio" name="marketplace_plan" value="12" onchange="updateCart()"> 1 year - ₹2400 + GST</label>
                            <div class="d-flex align-items-center mt-2">
                                <span class="mr-2">No of Products allowed for Upload in Marketplace:</span>
                                <button type="button" class="btn btn-primary mx-2 product-btn" data-change="-5">-</button>
                                <input type="text" id="product_count" name="product_count" value="5" class="text-center" readonly style="width:50px;">
                                <button type="button" class="btn btn-primary mx-2 product-btn" data-change="5">+</button>
                            </div>
                            <small>(Max 50 products)</small>
                        </div>

                        @if ($latestDirectory)
                        <input type="hidden" id="latest_directory_end" value="{{ $latestDirectory->end_date }}">
                        @endif
                        <input type="hidden" id="calculated_duration" value="0">
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card shadow-sm" style="background-color: #e7cfcf;">
                    <div class="card-header header-gradient">Payment Cart</div>
                    <div class="card-body">
                        <table class="table">
                            <tr><th>Description</th><th>Amount</th></tr>
                            <tr><td>Member Directory Access</td><td>₹<span id="selected_member_price">600</span></td></tr>
                            <tr id="marketplace_row" style="display: none;"><td>Marketplace Access</td><td>₹<span id="selected_marketplace_price">0</span></td></tr>
                            <tr><th>Subtotal</th><th>₹<span id="subtotal">600</span></th></tr>
                            <tr><td>CGST (9%)</td><td>₹<span id="cgst">54</span></td></tr>
                            <tr><td>SGST (9%)</td><td>₹<span id="sgst">54</span></td></tr>
                            <tr><th>Total Payable</th><th>₹<span id="total_amount">708</span></th></tr>
                        </table>
                        <div class="text-center">
                            <button id="pay-now" class="btn btn-primary px-4 py-2" style="font-size: 14px;">Pay Now</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const razorpayKey = "{{ $razorpayKey ?? '' }}";

function updateCart() {
    const memberPlanInput = document.querySelector('input[name="member_plan"]:checked');
    let memberDuration = 0;
    let memberPrice = 0;

    if (memberPlanInput && !memberPlanInput.disabled) {
        memberDuration = parseInt(memberPlanInput.value);
        memberPrice = (memberDuration === 6) ? 600 : 1200;
    }

    const marketplaceEnabled = document.getElementById('enable_marketplace').checked;
    const marketplacePlanInput = document.querySelector('input[name="marketplace_plan"]:checked');
    let marketplacePrice = 0;
    let finalMarketplaceDuration = 0;

    const today = new Date();
    today.setHours(0, 0, 0, 0);

    const endDateInput = document.getElementById('latest_directory_end')?.value;

    if (marketplaceEnabled) {
        if (!endDateInput && memberDuration === 0) {
            document.getElementById('enable_marketplace').checked = false;
            document.getElementById('marketplace_options').style.display = "none";
            alert("❌ Member Directory subscription required for Marketplace access.");
            return;
        }

        // Get selected marketplace plan duration
        if (marketplacePlanInput) {
            finalMarketplaceDuration = parseInt(marketplacePlanInput.value);
            marketplacePrice = (finalMarketplaceDuration === 6) ? 1200 : 2400;
        }

        let endDate = endDateInput ? new Date(endDateInput) : new Date(today);
        if (!endDateInput) {
            endDate.setMonth(endDate.getMonth() + memberDuration);
        }
        endDate.setHours(0, 0, 0, 0);

        // Apply product count adjustments
        const productCount = parseInt(document.getElementById('product_count').value);
        const extraProducts = Math.max((productCount - 5) / 5, 0);
        const monthlyExtraCost = extraProducts * 100; 
        marketplacePrice += monthlyExtraCost * (finalMarketplaceDuration === 6 ? 6 : 12);

        // Info Note
        document.getElementById("marketplace_note")?.remove();
        const note = document.createElement("div");
        note.className = "alert alert-info mt-2";
        note.id = "marketplace_note";
        note.innerText = `Marketplace subscription aligned to Member Directory expiry (${endDate.toISOString().split('T')[0]}). You will be charged ₹${(marketplacePrice/finalMarketplaceDuration).toFixed(2)} x ${finalMarketplaceDuration} month(s) and your subscription will end along with Member Directory Expiry`;
        document.getElementById("marketplace_options").appendChild(note);
    }

    const subtotal = memberPrice + marketplacePrice;
    const cgst = subtotal * 0.09;
    const sgst = subtotal * 0.09;
    const totalAmount = subtotal + cgst + sgst;

    document.getElementById("selected_member_price").innerText = memberPrice.toFixed(2);
    document.getElementById("selected_marketplace_price").innerText = marketplacePrice.toFixed(2);
    document.getElementById("subtotal").innerText = subtotal.toFixed(2);
    document.getElementById("cgst").innerText = cgst.toFixed(2);
    document.getElementById("sgst").innerText = sgst.toFixed(2);
    document.getElementById("total_amount").innerText = totalAmount.toFixed(2);

    document.getElementById("marketplace_row").style.display = marketplaceEnabled ? "table-row" : "none";
    document.getElementById("marketplace_options").style.display = marketplaceEnabled ? "block" : "none";
    document.getElementById("calculated_duration").value = marketplaceEnabled ? finalMarketplaceDuration : memberDuration;
}


document.querySelectorAll(".product-btn").forEach(btn => {
    btn.addEventListener("click", function () {
        const change = parseInt(this.getAttribute("data-change"));
        const input = document.getElementById('product_count');
        const currentCount = parseInt(input.value);
        const newCount = currentCount + change;
        if (newCount >= 5 && newCount <= 50 && newCount % 5 === 0) {
            input.value = newCount;
            updateCart();
        }
    });
});

    document.querySelectorAll("input[name='member_plan'], input[name='marketplace_plan']").forEach(function(el) {
        el.addEventListener("change", updateCart);
    });

    document.getElementById("enable_marketplace").addEventListener("change", function() {
        document.getElementById('marketplace_options').style.display = this.checked ? "block" : "none";
        updateCart();
    });

  document.getElementById("pay-now").addEventListener("click", function (e) {
    e.preventDefault();
    const totalAmount = parseFloat(document.getElementById("total_amount").innerText) * 100;
    const memberPlan = document.querySelector('input[name="member_plan"]:checked')?.value;
    const marketplaceEnabled = document.getElementById("enable_marketplace").checked;
    const productCount = marketplaceEnabled ? parseInt(document.getElementById("product_count").value) : 0;
    const duration = parseInt(document.getElementById("calculated_duration").value) || 0;

    const options = {
        key: razorpayKey,
        amount: totalAmount,
        currency: "INR",
        name: "TIEPMD Subscription",
        description: "Membership & Marketplace Access",
        handler: function (response) {
            // Build the verification URL
            let url;
            if (marketplaceEnabled && memberPlan) {
                url = "{{ route('subscription.verifyBoth') }}?" + 
                      `razorpay_payment_id=${response.razorpay_payment_id}` +
                      `&duration=${memberPlan}` +
                      `&product_count=${productCount}`;
            } else if (marketplaceEnabled) {
                url = "{{ route('subscription.verifyMarketplace') }}?" + 
                      `razorpay_payment_id=${response.razorpay_payment_id}` +
                      `&product_count=${productCount}`;
            } else {
                url = "{{ route('subscription.verifyMember') }}?" + 
                      `razorpay_payment_id=${response.razorpay_payment_id}` +
                      `&duration=${memberPlan}`;
            }

            // Redirect to verification endpoint
            window.location.href = url;
        },
        theme: { color: "#e7cfcf" }
    };

    const rzp = new Razorpay(options);
    rzp.open();
});
});
</script>
@endsection