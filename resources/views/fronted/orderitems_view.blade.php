@extends('layouts.fronted.master')
@section('discription')
<meta name="description" content="E-com fashion, digital and more products. This is a larvel project of commercial web. But not open for shopping yet... Next may be yours.">
<meta name="keywords" content="Laravel 8, commercial, project, junior webdeveloper.">
@endsection
@section('title', 'Order Review')
@section('page_styles')
<style rel="stylesheet" href="{{ asset('fronted/assets/css/first.css') }}"></style>
@endsection
@section('content')
<div class="my-12 text-gray-100 w-full">
    <div class="w-full md:rounded p-4 bg-gray-700 md:grid md:grid-cols-6 md:gap-2">
        <div class="md:col-span-2 bg-gray-900">Ordered by:</div>
        <div class="md:col-span-4">{{ auth()->user()->name }}</div>
        <div class="md:col-span-2 bg-gray-900">For:</div>
        <div class="md:col-span-4">{{$order->shipping_name}}</div>
        <div class="md:col-span-2 bg-gray-900">Contact:</div>
        <div class="md:col-span-4">{{$order->shipping_email}}, phone: {{$order->shipping_phone}}</div>
        <div class="md:col-span-2 bg-gray-900">Address:</div>
        <div class="md:col-span-4">{{$order->division->name}}, district: {{$order->district->name}}, state: {{$order->state->name}}, city: {{$order->city}}, {{$order->shipping_street}} st., {{$order->shipping_house_number}}{{$order->shipping_entrance ? ', entrance: '.$order->shipping_entrance : ''}}{{$order->shipping_apt_number ? ', apt.: '.$order->shipping_apt_number : ''}}</div>
        <div class="md:col-span-2 bg-gray-900">Total:</div>
        <div class="md:col-span-4">${{$order->amount}}</div>
        <div class="md:col-span-2 bg-gray-900">Invoice no:</div>
        <div class="md:col-span-4">{{$order->invoice_no}}</div>
        <div class="md:col-span-2 bg-gray-900">Transaction no:</div>
        <div class="md:col-span-4">{{$order->transaction_id}}</div>
        <div class="md:col-span-2 bg-gray-900">Payment method:</div>
        <div class="md:col-span-4">{{$order->payment_method}}</div>
        <div class="md:col-span-2 bg-gray-900">Order date:</div>
        <div class="md:col-span-4">{{$order->order_date}}</div>
        <div class="md:col-span-2 bg-gray-900">Order status:</div>
        <div class="md:col-span-4">{{$order->status}}</div>
    </div>
    <div class="text-center py-4 font-bold">All Order Items</div>
    @if(session('fail'))
    <div class="text-red-300 mb-2">
        <span class="material-icons self-center mx-2">
            error
        </span>
        <span class="text-sm font-bold">{{session('fail')}}</span>
    </div>
    @endif

    <div class="w-full md:rounded p-4 bg-gray-700">
        <div class="overflow-auto mx-4 my-0">
            <table class="table-auto w-full text-sm">
                <thead>
                    <tr class="bg-gray-900 border-b borger-gray-200 font-serif">
                        <th>Product</th>
                        <th class="text-left p-2">Color</th>
                        <th class="text-left px-2">Size</th>
                        <th class="text-left px-2">Price</th>
                        <th class="text-left px-2">Qty</th>
                        <th class="text-left px-2">Total</th>
                        <th class="text-left px-2">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if($items->count())
                    @foreach($items as $index=>$item)
                    <tr class="{{$index%2 == 0 ? '' : 'bg-gray-800'}}">
                        <td class="text-left pt-2 md:flex"><img src="{{url($item->product->product_thumbnail)}}" alt="{{$item->product->product_name_en}}" class="object-contain w-10 md:mr-2">{{$item->product->product_name_en}}</td>
                        <td class="text-left px-2">{{$item->color ? $item->color : '...'}}</td>
                        <td class="text-left px-2">{{$item->size ? $item->size : '...'}}</td>
                        <td class="text-left px-2">${{$item->price}}</td>
                        <td class="text-left px-2">{{$item->qty}}</td>
                        <td><span class="w-full text-center bg-gray-400 rounded-full px-2 my-1 text-white">${{$item->price * $item->qty}}</span></td>
                        <td class="px-2">
                            <a href="{{route('prod.details', ['prodId' => $item->product_id, 'slug'=>$item->product->product_slug_en])}}" class="bg-blue-400 rounded-full hover:bg-blue-600 px-2"><i class="fa fa-eye" aria-hidden="true"></i><span class="sr-only md:not-sr-only">view</span></a>
                        </td>
                    </tr>
                    @endforeach
                    @else
                    <tr colspan="7">There are no items... Check the order.</tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
    <div class="flex justify-end pt-4">
        <a href="{{route('my.orders')}}">
            <span class="font-serif text-sm text-white font-semibold rounded-lg py-1 px-2 text-center bg-purple-400 hover:bg-purple-800 motion-safe:hover:scale-105 ease-in-out transition duration-700">ALL ORDERS</span>
        </a>
    </div>
</div>
@endsection
@section('page_footer_scripts')
<script src="{{asset('backend/assets/js/alerts.js')}}"></script>
@endsection