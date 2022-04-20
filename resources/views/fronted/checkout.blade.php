@extends('layouts.fronted.master')
@section('discription')
<meta name="description" content="E-com fashion, digital and more products. This is a larvel project of commercial web. But not open for shopping yet... Next may be yours.">
<meta name="keywords" content="Laravel 8, commercial, project, junior webdeveloper.">
@endsection
@section('title', 'Start Checkout')
@section('page_styles')
<style rel="stylesheet" href="{{ asset('fronted/assets/css/first.css') }}"></style>
@endsection

@section('content')
<div class="flex w-full flex-col my-12 text-gray-100">
    <div class="text-center py-4 font-bold">START CHECKOUT</div>
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
                        <th colspan="4" class="heading-title py-2">Products in Cart</th>
                    </tr>
                    <tr>
                        <th class="text-left">Image</th>
                        <th class="text-left px-2">Details</th>
                        <th class="text-left px-2">Quantity</th>
                        <th class="text-left px-2">Sub Total</th>
                    </tr>
                </thead>
                <tbody class="text-left box-border">
                    @if($carts->count())
                    @foreach($carts as $cart)
                    <tr class="px-2 bg-gray-800 divide-x divide-gray-700">
                        <td class="w-32"><img src="/{{$cart->options['image']}}" alt="image" class="w-32 object-cover">
                        </td>
                        <td class="px-2">
                            <div>{{$cart->name}}</div>
                            <div class="price">Price: ${{$cart->price}}</div>
                            @if($cart->options['color'])
                            <div>
                                <strong>Color: {{$cart->options['color']}}</strong>
                            </div>
                            @endif
                            @if($cart->options['size'])
                            <div>
                                <strong>Size: {{$cart->options['size']}}</strong>
                            </div>
                            @endif
                        </td>
                        <td>
                            <div class="px-2">
                                <strong>Qty: {{$cart->qty}}</strong>
                            </div>
                        </td>
                        <td>
                            <div class="px-2">
                                ${{$cart->subtotal}}
                            </div>
                        </td>
                    </tr>

                    @endforeach
                    @else
                    <tr colspan="4">The Cart is empty</tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
    @auth
    <form class="w-full md:rounded p-4 bg-gray-700 text-sm md:grid md:grid-cols-2 lg:grid-cols-3 md:gap-2 lg:gap-4" method="POST" action="{{route('checkout.store')}}">
        @csrf
        <div class="py-2 border-b">
            <div class="text-left"><b>Shipping Address&Recivier Details</b>
            </div>
            <p class="text-left text-sm font-thin mb-2">Reciver details</p>
            <div class="mb-2 grid grid-cols-12 xl:gap-4">
                <label for="shipping_name" class="text-sm font-semibold pr-2 py-2 col-span-4 xl:col-span-3">Name <span class="text-red-500">*</span></label>
                <input type="text" name="shipping_name" id="shipping_name" placeholder="example@walla.com" class="text-gray-900 col-span-12 xl:col-span-9 rounded-lg text-sm appereance-none border-2 border-gray-200 @error('shipping_name') border-red-500 @enderror" value="{{Auth::user()->name}}" required>
            </div>
            @error('shipping_name')
            <div class="text-red-500 text-sm">{{$message}}</div>
            @enderror

            <div class="mb-2 grid grid-cols-12 xl:gap-4">
                <label for="shipping_email" class="text-sm font-semibold pr-2 py-2 col-span-4 xl:col-span-3">Email <span class="text-red-500">*</span></label>
                <input type="email" name="shipping_email" id="shipping_email" placeholder="example@walla.com" class="text-gray-900 col-span-12 xl:col-span-9 rounded-lg text-sm appereance-none border-2 border-gray-200 @error('shipping_email') border-red-500 @enderror" value="{{auth()->user()->email}}" required>
            </div>
            @error('shipping_email')
            <div class="text-red-500 text-sm">{{$message}}</div>
            @enderror
            <div class="mb-2 grid grid-cols-12 xl:gap-4">
                <label for="shipping_phone" class="text-sm font-semibold pr-2 py-2 col-span-4 xl:col-span-3">Phone <span class="text-red-500">*</span></label>
                <input type="text" name="shipping_phone" id="shipping_phone" placeholder="0541111111" class="appereance-none border-2 border-gray-200 text-gray-900 col-span-12 xl:col-span-9 rounded-lg text-sm @error('shipping_phone') border-red-500 @enderror" required value="{{old('shipping_phone')}}">
            </div>
            @error('shipping_phone')
            <div class="text-red-500 text-sm">{{$message}}</div>
            @enderror
        </div><!-- end recivier details -->

        <div class="py-2 border-b">
            <div class="text-left"><b>Shipping Address&Recivier Details</b>
            </div>
            <p class="text-left text-sm font-thin mb-2">Address part 1</p>
            <div class="mb-2 grid grid-cols-12 xl:gap-4">
                <label for="division" class="text-gray-100 text-sm font-semibold pr-2 py-2 col-span-4 xl:col-span-3">Division <span class="text-red-500 text-xs">*</span></label>
                <select type="text" name="division" id="division" class="col-span-12  xl:col-span-9 rounded-lg text-sm border-0 text-gray-900" required>
                    @if($divisions->count())
                    <option value="" disabled>--Select Disvision--</option>
                    @foreach($divisions as $key => $item)
                    <option value="{{$item->id}}">{{$item->name}}</option>
                    @endforeach
                    @endif
                </select>
            </div>
            @error('division')
            <div class="text-red-500 text-sm">{{$message}}</div>
            @enderror
            <div class="mb-2 grid grid-cols-12 xl:gap-4">
                <label for="district" class="la-la text-sm font-semibold pr-2 py-2 col-span-4 xl:col-span-3">District <span class="text-red-500 text-xs">*</span></label>
                <select type="text" name="district" id="district" class="test col-span-12 xl:col-span-9 rounded-lg text-sm border-0 text-gray-900" required>
                    <option value="" id="stam1" disabled selected>--Select District--</option>
                </select>
            </div>
            @error('district')
            <div class="text-red-500 text-sm">{{$message}}</div>
            @enderror

            <div class="mb-2 grid grid-cols-12 xl:gap-4">
                <label for="state_name" class="text-sm font-semibold pr-2 py-2 col-span-4  xl:col-span-3">State <span class="text-red-500 text-xs">*</span></label>
                <select type="text" name="state_name" id="state_name" class="text-gray-900 col-span-12 xl:col-span-9 rounded-lg text-sm border-0" required>
                    <option value="" disabled selected id="stam">--Select State--</option>
                </select>
            </div>
            @error('state_name')
            <div class="text-red-500 text-sm">{{$message}}</div>
            @enderror
            <div class="mb-2 grid grid-cols-12 xl:gap-4">
                <label for="city" class="text-sm font-semibold pr-2 py-2 col-span-4  xl:col-span-3">City <span class="text-red-500">*</span></label>
                <input type="text" name="city" id="city" placeholder="city" class="text-gray-900 col-span-12  xl:col-span-9 rounded-lg text-sm appereance-none border-2 border-gray-200 @error('city')  border-red-500 @enderror" required value="{{old('city')}}">
            </div>
            @error('city')
            <div class="text-red-500 text-sm">{{$message}}</div>
            @enderror
            <div class="mb-2 grid grid-cols-12 xl:gap-4">
                <label for="post_code" class="text-sm font-semibold pr-2 py-2 col-span-4  xl:col-span-3"><span class="sr-only">Postal</span><i class="fa fa-envelope" aria-hidden="true"></i> Code <span class="text-red-500">*</span></label>
                <input type="text" name="post_code" id="post_code" placeholder="3268225" class="text-gray-900 col-span-12  xl:col-span-9 rounded-lg text-sm appereance-none border-2 border-gray-200 @error('post_code')  border-red-500 @enderror" required value="{{old('post_code')}}">
            </div>
            @error('post_code')
            <div class="text-red-500 text-sm">{{$message}}</div>
            @enderror
        </div><!-- end shipping address 1 -->
        <div class="py-2 border-b">
            <div class="text-left"><b>Shipping Address&Recivier Details</b>
            </div>
            <p class="text-left text-sm font-thin mb-2">Address part 2</p>
            <div class="mb-2 grid grid-cols-12 xl:gap-4">
                <label for="shipping_street" class="text-sm font-semibold pr-2 py-2 col-span-4 xl:col-span-3">Street <span class="text-red-500">*</span></label>
                <input type="text" name="shipping_street" id="shipping_street" placeholder="Street Name" class="text-gray-900 col-span-12 xl:col-span-9 rounded-lg text-sm appereance-none border-2 border-gray-200 @error('shipping_street') border-red-500 @enderror" required value="{{old('shipping_street')}}">
            </div>
            @error('shipping_street')
            <div class="text-red-500 text-sm">{{$message}}</div>
            @enderror
            <div class="mb-2 grid grid-cols-12 xl:gap-4">
                <label for="shipping_house_number" class="text-sm font-semibold pr-2 py-2 col-span-4 xl:col-span-3">House <b>&#8470;</b> <span class="text-red-500">*</span></label>
                <input type="text" name="shipping_house_number" id="shipping_house_number" placeholder="House Number" class="text-gray-900 col-span-12 xl:col-span-9 rounded-lg text-sm appereance-none border-2 border-gray-200 @error('shipping_house_number') border-red-500 @enderror" required value="{{old('shipping_house_number')}}">
            </div>
            @error('shipping_house_number')
            <div class="text-red-500 text-sm">{{$message}}</div>
            @enderror
            <div class="mb-2 grid grid-cols-12 xl:gap-4">
                <label for="shipping_entrance" class="text-sm font-semibold pr-2 py-2 col-span-4 xl:col-span-3">Entrance</label>
                <input type="text" name="shipping_entrance" id="shipping_entrance" placeholder="Entrance" class="text-gray-900 col-span-12 xl:col-span-9 rounded-lg text-sm appereance-none border-2 border-gray-200 @error('shipping_entrance') border-red-500 @enderror" value="{{old('shipping_entrance')}}">
            </div>
            @error('shipping_entrance')
            <div class="text-red-500 text-sm">{{$message}}</div>
            @enderror
            <div class="mb-2 grid grid-cols-12 xl:gap-4">
                <label for="shipping_floor" class="text-sm font-semibold pr-2 py-2 col-span-4 xl:col-span-3">Floor</label>
                <input type="text" name="shipping_floor" id="shipping_floor" placeholder="Floor" class="text-gray-900 col-span-12 xl:col-span-9 rounded-lg text-sm appereance-none border-2 border-gray-200 @error('shipping_floor') border-red-500 @enderror" value="{{old('shipping_floor')}}">
            </div>
            @error('shipping_floor')
            <div class="text-red-500 text-sm">{{$message}}</div>
            @enderror
            <div class="mb-2 grid grid-cols-12 xl:gap-4">
                <label for="shipping_apt_number" class="text-sm font-semibold pr-2 py-2 col-span-12 xl:col-span-3">Apt. <b>&#8470;</b></label>
                <input type="text" name="shipping_apt_number" id="shipping_apt_number" placeholder="Apartment Number" class="text-gray-900 col-span-12 xl:col-span-9 rounded-lg text-sm appereance-none border-2 border-gray-200 @error('shipping_apt_number') border-red-500 @enderror" value="{{old('shipping_apt_number')}}">
            </div>
            @error('shipping_apt_number')
            <div class="text-red-500 text-sm">{{$message}}</div>
            @enderror
        </div><!-- end shipping address 2 -->
        <div class="py-2 border-b">
            <div class="text-left"><b>Shipping Notes</b>
            </div>
            <p class="text-left text-sm font-thin mb-2">If you have any notes please let us know</p>
            <div class="mb-2 grid grid-cols-12 xl:gap-4">
                <label class="info-title text-sm font-semibold pr-2 py-2 col-span-4  xl:col-span-3" for="notes">Notes</label>
                <textarea rows="5" placeholder="Notes" name="notes" class="text-gray-900 col-span-12  xl:col-span-9 rounded-lg text-sm border-0">{{old('notes')}}</textarea>
            </div>
        </div>
        <div class="py-2 border-b">
            <div class="flex flex-wrap w-full">
                <div class="w-full text-left">
                    <b class="text-left">Cart Total&Payment</b>
                    <p class="text-left text-sm font-thin mb-2">Payment Method</p>
                </div>
                <div class="md:w-4/12 text-center py-2 bg-gray-600  rounded-l-lg">
                    <i class="fa fa-cc-stripe w-full text-3xl" aria-hidden="true"></i>
                    <div class="flex content-center justify-center py-2 space-x-2">
                        <label for="stripe">Stripe</label>
                        <input type="radio" name="payment_method" value="stripe" class="appearance-none bg-gray-100 text-purple-300 focus:ring-transparent" checked id="stripe">
                    </div>
                </div>

                <div class="md:w-4/12 text-center py-2 bg-gray-600">
                    <i class="fa fa-credit-card-alt w-full text-3xl" aria-hidden="true"></i>
                    <div class="flex content-center justify-center py-2 space-x-2">
                        <label for="card">Card</label>
                        <input type="radio" name="payment_method" value="card" class="appearance-none bg-gray-100 text-purple-300 focus:ring-transparent" id="card">
                    </div>
                </div>

                <div class="md:w-4/12 text-center py-2 bg-gray-600  rounded-r-lg">
                    <i class="fa fa-money w-full text-3xl" aria-hidden="true"></i>
                    <div class="flex content-center justify-center py-2 space-x-2">
                        <label for="cash">Cash</label>
                        <input type="radio" name="payment_method" value="cash" class="appearance-none bg-gray-100 text-purple-300 focus:ring-transparent" id="cash">
                    </div>
                </div>

            </div>
        </div>

        <div class="pt-2 flex flex-col w-full justify-between text-left">
            <div>
                <div class="text-left">
                    <b>Cart Total&Payment</b>
                </div>
                <p class="text-left text-sm font-thin mb-2">Cart</p>
                <div class="border-b border-gray-100 py-2">
                    {{$cartQty}} {{Str::plural('product', $cartQty)}} in Cart
                </div>
                <div>
                    Sub Total: {{$cartSubTotal}}
                </div>
                <div>
                    Tax (17%): ${{$cartTax}}
                </div>
                @if(Session::has('coupon'))
                <div class="text-blue-300">
                    Coupon {{Session::get('coupon.coupon_name')}} ({{Session::get('coupon.coupon_discount')}}%): <span class="text-red-300"> -${{$discount}}</span>
                </div>
                @endif
                <div class="text-green-300 border-y border-gray-100 py-2">
                    Grand Total: ${{$cartTotal}}
                </div>
            </div>
            <div>
                @if($carts->count())
                <div class="pt-2">
                    <button type="submit" class="w-full font-serif transform motion-safe:hover:scale-105 bg-purple-400 rounded-lg font-semibold text-white py-2 hover:bg-purple-600 transition ease-in-out duration-700 ">PAYMENT</button>
                </div>
                @endif
            </div>
        </div>
    </form>
    @endauth
</div>
@endsection
@section('page_footer_scripts')
<script src="{{asset('backend/assets/js/alerts.js')}}"></script>
<script>
    $(document).ready(function() {
        function getAllStates(iddis = $('select[name="district"]').val()) {
            if (iddis) {
                $.ajax({
                    url: "{{ url('/shipping/state/ajax') }}/" + iddis,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        //console.log(data);
                        if (data) {
                            $('select[name="state_name"]').empty();
                            $('select[name="state_name"]').append('<option value="" selected id="stam" disabled>-- Select State --</option>');
                            $.each(data, function(key, value) {
                                $('select[name="state_name"]').append('<option value="' + value.id + '">' + value.name + '</option>');
                            });
                            $('#stam').prop('selected', false);
                        }
                    },
                });
            }
        }
        $('select[name="district"]').on('change', function() {
            var iddis = $(this).val();
            //console.log(id);
            if (iddis) {
                getAllStates(iddis);
            } else {
                alert('danger');
            }
        });

        function getAllDistricts(id = $('select[name="division"]').val()) {
            if (id) {
                $.ajax({
                    url: "{{ url('/shipping/district/ajax') }}/" + id,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        //console.log(data);
                        $('select[name="district"]').empty();
                        $('select[name="district"]').append('<option value="" disabled id="stam1">-- Select District --</option>');
                        if (data) {
                            $.each(data, function(key, value) {
                                $('select[name="district"]').append('<option value="' + value.id + '">' + value.name + '</option>');
                            });
                            getAllStates();
                        }
                    },
                });
            }
        }
        $('select[name="division"]').on('change', function() {
            var $id = $(this).val();
            //console.log($id);
            if ($id) {
                getAllDistricts($id);
            } else {
                alert('danger');
            }
        });
        getAllDistricts();
    });
</script>
@endsection