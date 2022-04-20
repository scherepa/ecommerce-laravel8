@extends('layouts.fronted.master')
@section('discription')
<meta name="description" content="E-com fashion, digital and more products. This is a larvel project of commercial web. But not open for shopping yet... Next may be yours.">
<meta name="keywords" content="Laravel 8, commercial, project, junior webdeveloper.">
@endsection
@section('title', 'Cash')
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
    <div class="text-center py-4 font-bold">CASH ON DELIVERY</div>
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
        <!-- Order details -->
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
            </div>
            <div class="mt-2">
                <div class="font-bold my-2">Payment Method
                </div>
                <div>Cash on Delivery <br>
                    <span class="material-icons">
                        local_shipping
                    </span>
                </div>


                <button class="mt-2 px-4 font-serif transform motion-safe:hover:scale-105 bg-purple-400 rounded-lg font-semibold text-white py-2 hover:bg-purple-600 transition ease-in-out duration-700">Submit Payment</button>
            </div>
        </form>
    </div>
    @endauth
</div>
@endsection
@section('page_footer_scripts')
<script src="{{asset('backend/assets/js/alerts.js')}}"></script>
@endsection