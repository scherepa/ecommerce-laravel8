@extends('layouts.fronted.master')
@section('discription')
<meta name="description" content="E-com fashion, digital and more products. This is a larvel project of commercial web. But not open for shopping yet... Next may be yours.">
<meta name="keywords" content="Laravel 8, commercial, project, junior webdeveloper.">
@endsection
@section('title', 'My Cart')
@section('page_styles')
<style rel="stylesheet" href="{{ asset('fronted/assets/css/first.css') }}"></style>
@endsection
@section('content')
<div class="flex w-full flex-col my-12 text-gray-100">
    <div class="text-center py-4 font-bold">MY CART</div>
    @if(session('fail'))
    <div class="text-red-300 mb-2">
        <span class="material-icons self-center mx-2">
            error
        </span>
        <span class="text-sm font-bold">{{session('fail')}}</span>
    </div>
    @endif
    <div class="w-full md:rounded p-4 bg-gray-700 mb-4">
        <div class="overflow-x-auto mx-4">
            <table class="table-auto w-full text-sm min-w-max">
                <thead>
                    <tr>
                        <th colspan="7" class="heading-title py-2">My Cart</th>
                    </tr>
                    <tr>
                        <th class="text-left">Image</th>
                        <th class="text-left px-2">Name</th>
                        <th class="text-left px-2">Color</th>
                        <th class="text-left px-2">Size</th>
                        <th class="text-left px-2">Quantity</th>
                        <th class="text-left px-2">Sub Total</th>
                        <th class="text-center">Remove</th>
                    </tr>
                </thead>
                <tbody id="cartPage" class="text-left">

                </tbody>
            </table>
        </div>
    </div>
    <div class="w-full md:rounded p-4 bg-gray-700 text-sm md:grid md:grid-cols-2 lg:grid-cols-3 md:gap-2 lg:gap-4">
        <div class="estimate-ship-tax  py-2">
            <table class="table w-full">
                <thead>
                    <tr>
                        <th>
                            <div class="estimate-title text-left">Discount Code</div>
                            <p class="text-left text-sm font-thin">Enter your coupon code if you have one..</p>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <form action="" class="w-full">
                                <div class="mb-2">
                                    <input type="text" class="rounded-lg text-sm w-full border-0" placeholder="You Coupon.." id="tax">
                                </div>
                                <div>
                                    <button type="submit" class="font-serif transform motion-safe:hover:scale-105 bg-blue-400 w-full rounded-lg font-semibold text-white py-2 focus:ring-4 focus:ring-blue-300 focus:ring-opacity-50 hover:bg-blue-600 transition ease-in-out duration-700 shadow-lg" onclick="applyCoupon()">APPLY COUPON</button>
                                </div>
                            </form>
                        </td>
                    </tr>
                </tbody><!-- /tbody -->
            </table><!-- /table -->
        </div><!-- /.estimate-ship-tax -->

        <div class="apply-coupon py-2 {{(session('coupon') || !Cart::count()) ? 'hidden' : ''}}">
            <table class="table w-full">
                <thead>
                    <tr>
                        <th>
                            <div class="discount-name text-left">Discount Code</div>
                            <p class="text-left text-sm font-thin">Enter your coupon code if you have one..</p>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <div class="mb-2">
                                <input type="text" class="rounded-lg text-sm w-full border-0 text-gray-900" placeholder="You Coupon.." id="coupon_name">
                            </div>
                            <div>
                                <button class="font-serif transform motion-safe:hover:scale-105 bg-green-400 w-full rounded-lg font-semibold text-white py-2 focus:ring-4 focus:ring-green-300 focus:ring-opacity-50 hover:bg-green-600 transition ease-in-out duration-700 shadow-lg" onclick="applyCoupon()">APPLY COUPON</button>
                            </div>
                        </td>
                    </tr>
                </tbody><!-- /tbody -->
            </table><!-- /table -->
        </div><!-- apply coupon -->

        <div class="cart-shopping-total py-2">
            <div class="flex flex-col w-full text-left">
                <div class="flex-1">
                    <div class="cart-sub-total">
                    </div>
                    <div class="cart-tax">
                    </div>
                    <div class="text-blue-300 coupDetails">
                    </div>
                    <div class="cart-grand-total text-green-300">
                    </div>
                </div>
                @if(Cart::count())
                <div>
                    <div class="cart-checkout-btn">
                        <a href="{{route('checkoutPage')}}">
                            <div class="font-serif transform motion-safe:hover:scale-105 bg-purple-400 w-full rounded-lg font-semibold text-white py-2 focus:ring-4 focus:ring-purple-300 focus:ring-opacity-50 hover:bg-purple-600 transition ease-in-out duration-700 shadow-lg checkout-btn text-center">PROCCED TO CHEKOUT</div>
                        </a>
                    </div>
                </div>
                @endif
            </div><!-- /flex -->
        </div><!-- /.cart-shopping-total -->
    </div>
</div>
@endsection
@section('page_footer_scripts')
<script src="{{asset('backend/assets/js/alerts.js')}}"></script>
@endsection