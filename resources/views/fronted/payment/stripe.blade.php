@extends('layouts.fronted.master')
@section('discription')
<meta name="description" content="E-com fashion, digital and more products. This is a larvel project of commercial web. But not open for shopping yet... Next may be yours.">
<meta name="keywords" content="Laravel 8, commercial, project, junior webdeveloper.">
@endsection
@section('title', 'Stripe')
@section('page_styles')
<style rel="stylesheet" href="{{ asset('fronted/assets/css/first.css') }}"></style>
<style>
    .StripeElement {
        box-sizing: border-box;
        height: 40px;
        padding: 10px 12px;
        border: 1px solid transparent;
        border-radius: 14px;
        background-color: white;
        box-shadow: 0 1px 5px 0 #e6ebf1;
        -webkit-transition: box-shadow 150ms ease;
        transition: box-shadow 150ms ease;
    }

    .StripeElement--focus {
        box-shadow: 0 1px 5px 0 #cfd7df;
    }

    .StripeElement--invalid {
        border-color: #fa755a;
    }

    .StripeElement--webkit-autofill {
        background-color: #fefde5 !important;
    }
</style>
@endsection

@section('content')
<div class="flex w-full flex-col my-12 text-gray-100">
    <div class="text-center py-4 font-bold">STRIPE</div>
    @if(session('fail'))
    <div class="text-red-300 mb-2">
        <span class="material-icons self-center mx-2">
            error
        </span>
        <span class="text-sm font-bold">{{session('fail')}}</span>
    </div>
    @endif
    @auth
    <div class="w-full md:rounded p-4 bg-gray-700 text-sm md:grid md:grid-cols-2 md:gap-4">
        <div class="pt-2 text-left">
            <div class="text-left mb-2"><b>Shopping Total Amount</b>
            </div>
            <div>
                Sub Total: {{Cart::subtotal()}}
            </div>
            <div>
                Tax (17%): ${{Cart::tax()}}
            </div>
            @if(Session::has('coupon'))
            <div class="text-blue-300">
                Coupon {{Session::get('coupon.coupon_name')}} ({{Session::get('coupon.coupon_discount')}}%): <span class="text-red-300"> -${{Session::get('coupon.discount_amount')}}</span>
            </div>
            <div class="text-green-300 border-y border-gray-100 py-2">
                Grand Total: ${{Session::get('coupon.total_amount')}}
            </div>
            @else
            <div class="text-green-300 border-y border-gray-100 py-2">
                Grand Total: ${{Cart::total()}}
            </div>
            @endif
        </div><!-- /shopping amount -->
        <!-- Stripe -->
        <form action="{{route('stripe.order')}}" method="post" id="payment-form">
            @csrf
            <div class="form-row">
                <!-- class="form-row" -->
                <input type="hidden" name="name" value="{{ $data['shipping_name'] }}">
                <input type="hidden" name="email" value="{{ $data['shipping_email'] }}">
                <input type="hidden" name="phone" value="{{ $data['shipping_phone'] }}">
                <input type="hidden" name="city" value="{{ $data['city'] }}">
                <input type="hidden" name="post_code" value="{{ $data['post_code'] }}">
                <input type="hidden" name="division_id" value="{{ $data['division'] }}">
                <input type="hidden" name="district_id" value="{{ $data['district'] }}">
                <input type="hidden" name="state_id" value="{{ $data['state_name'] }}">
                <input type="hidden" name="notes" value="{{ $data['notes'] }}">
                <input type="hidden" name="shipping_street" value="{{ $data['shipping_street'] }}">
                <input type="hidden" name="shipping_house_number" value="{{ $data['shipping_house_number'] }}">
                <input type="hidden" name="shipping_entrance" value="{{ $data['shipping_entrance'] }}">
                <input type="hidden" name="shipping_floor" value="{{ $data['shipping_floor'] }}">
                <input type="hidden" name="shipping_apt_number" value="{{ $data['shipping_apt_number'] }}">
                <label for="card-element">
                    Credit or debit card
                </label>

                <div id="card-element">
                    <!-- A Stripe Element will be inserted here. -->
                </div>
                <!-- Used to display form errors. -->
                <div id="card-errors" role="alert"></div>
            </div>
            <div class="mt-2">
                <button class="px-4 font-serif transform motion-safe:hover:scale-105 bg-purple-400 rounded-lg font-semibold text-white py-2 hover:bg-purple-600 transition ease-in-out duration-700">Submit Payment</button>
            </div>
        </form>
    </div>
    @endauth
</div>
@endsection
@section('page_footer_scripts')
<script src="{{asset('backend/assets/js/alerts.js')}}"></script>
<!-- Stripe element -->

<script type="text/javascript">
    // Create a Stripe client.
    var stripe = Stripe('pk_test_51JwsEwK28qPY8wk1yfHlv8nyKwSi1dTLseVMjTx8ljlAD87itKeh1oiRq7dvjighbFI7gYRPj1Lm3OR733ACnc1500Yiop4XI4');
    // Create an instance of Elements.
    var elements = stripe.elements();
    // Custom styling can be passed to options when creating an Element.
    // (Note that this demo uses a wider set of styles than the guide below.)
    var style = {
        base: {
            color: '#32325d',
            fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
            fontSmoothing: 'antialiased',
            fontSize: '16px',
            '::placeholder': {
                color: '#aab7c4'
            }
        },
        invalid: {
            color: '#fa755a',
            iconColor: '#fa755a'
        }
    };
    // Create an instance of the card Element.
    var card = elements.create('card', {
        style: style
    });
    // Add an instance of the card Element into the `card-element` <div>.
    card.mount('#card-element');
    // Handle real-time validation errors from the card Element.
    card.on('change', function(event) {
        var displayError = document.getElementById('card-errors');
        if (event.error) {
            displayError.textContent = event.error.message;
        } else {
            displayError.textContent = '';
        }
    });
    // Handle form submission.
    var form = document.getElementById('payment-form');
    form.addEventListener('submit', function(event) {
        event.preventDefault();
        stripe.createToken(card).then(function(result) {
            if (result.error) {
                // Inform the user if there was an error.
                var errorElement = document.getElementById('card-errors');
                errorElement.textContent = result.error.message;
            } else {
                // Send the token to your server.
                stripeTokenHandler(result.token);
            }
        });
    });
    // Submit the form with the token ID.
    function stripeTokenHandler(token) {
        // Insert the token ID into the form so it gets submitted to the server
        var form = document.getElementById('payment-form');
        var hiddenInput = document.createElement('input');
        hiddenInput.setAttribute('type', 'hidden');
        hiddenInput.setAttribute('name', 'stripeToken');
        hiddenInput.setAttribute('value', token.id);
        form.appendChild(hiddenInput);
        // Submit the form
        form.submit();
    }
</script>
@endsection