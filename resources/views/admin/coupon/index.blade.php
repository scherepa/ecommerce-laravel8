@extends('admin.admin_master')

@section('title', 'All Coupons')
@section('page_styles')
<style type="text/css">
    input {
        outline: none;
    }
</style>

@section('admin')
<div class="p-4 bg-gray-900 md:rounded">
    <div class="p-4 mb-4">
        <h2 class="font-serif font-bold text-xl text-gray-100 leading-tight">
            All Coupons
        </h2>
    </div>
    <div class="p-4 md:rounded bg-gray-800 mb-2">
        <h3 class="font-serif font-semibold text-lg text-gray-100 leading-tight">
            All Coupons Information
        </h3>
        <p class="text-sm text-gray-300 leading-tight mt-1 mb-2">
            Veiw your coupon's main information, add new coupon or delete coupon.
        </p>
    </div>
    <!-- table -->
    <div class="flex w-full">
        <div class="w-full md:rounded p-2 bg-gray-700">
            <div class="overflow-x-auto m-2">
                @livewire('allcoupons')
            </div>
        </div>
    </div>
    <x-jet-section-border />
    @auth('admin')
    <div class="p-4 md:rounded bg-gray-800 mb-2">
        <h3 class="font-serif font-semibold text-lg text-gray-100 leading-tight">
            New Coupon
        </h3>
        <p class="text-sm text-gray-300 leading-tight mt-1 mb-2">
            Add new Coupon.
        </p>
    </div>
    <div class="p-4 md:p-6 lg:py-10 lg:px-12 md:rounded bg-gray-700">
        <form action="{{route('admin.store.coupon')}}" method="POST" class="w-full">
            @csrf
            <div class="mb-2 grid grid-cols-6 lg:gap-4">
                <label for="coupon_name" class="text-gray-100 text-sm font-semibold pr-2 py-2 col-span-3  lg:col-span-2">Coupon name<span class="text-red-500 text-xs">*</span>:</label>
                <input type="text" name="coupon_name" id="coupon_name" class="col-span-6 lg:col-span-4 rounded-lg text-sm border @error('coupon_name')  border-red-500 @enderror" value="{{old('coupon_name')}}" placeholder="coupon name" required autofocus>
            </div>
            @error('coupon_name')
            <div class="text-red-500 text-sm">{{$message}}</div>
            @enderror
            <div class="mb-2 grid grid-cols-6 lg:gap-4">
                <label for="coupon_discount" class="text-gray-100 text-sm font-semibold pr-2 py-2 col-span-3 lg:col-span-2">Coupon Discount %<span class="text-red-500 text-xs">*</span>:</label>
                <input type="number" name="coupon_discount" id="coupon_discount" class="col-span-6 lg:col-span-4 rounded-lg text-sm border @error('coupon_discount')  border-red-500 @enderror" value="{{old('coupon_discount')}}" placeholder="coupon discount %" required autofocus>
            </div>
            @error('coupon_discount')
            <div class="text-red-500 text-sm">{{$message}}</div>
            @enderror
            <x-jet-section-border />
            <div class="mb-2 grid grid-cols-6 gap-4">
                <label for="coupon_validity" class="text-gray-100 text-sm font-semibold pr-2 py-2 col-span-3  lg:col-span-2">Coupon Validity<span class="text-red-500 text-xs">*</span>:</label>
                <input type="date" name="coupon_validity" id="coupon_validaty" class="col-span-6 lg:col-span-4  rounded-lg border @error('coupon_validity')  border-red-500 @enderror" required autofocus min="{{ Carbon\Carbon::now()->format('Y-m-d') }}">
            </div>
            @error('coupon_validity')
            <div class=" text-red-500 text-sm">{{$message}}
            </div>
            @enderror
            <x-jet-section-border />
            <div class="grid grid-cols-6 lg:gap-4 mt-2">
                <h4 class="text-gray-100 text-sm font-bold col-span-3 lg:col-span-2">Upload this Coupon?</h4>
                <button type="submit" class="bg-purple-600 hover:bg-purple-800 text-gray-100 ml-auto w-full col-span-6 lg:col-span-4  rounded  mt-4 py-2 text-sm font-bold">
                    Save Coupon
                </button>
            </div>
        </form>
    </div>
    @endauth
</div>
@endsection
@section('page_footer_scripts')
<script src="{{asset('backend/assets/js/alerts.js')}}"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{asset('backend/assets/js/deleteAlert.js')}}"></script>
@endsection