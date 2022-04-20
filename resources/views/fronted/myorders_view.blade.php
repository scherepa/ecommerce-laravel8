@extends('layouts.fronted.master')
@section('discription')
<meta name="description" content="E-com fashion, digital and more products. This is a larvel project of commercial web. But not open for shopping yet... Next may be yours.">
<meta name="keywords" content="Laravel 8, commercial, project, junior webdeveloper.">
@endsection
@section('title', 'My Orders')
@section('page_styles')
<style rel="stylesheet" href="{{ asset('fronted/assets/css/first.css') }}"></style>
@endsection
@section('content')
<div class="w-full my-12 text-gray-100">
    <div class="text-center pb-4 font-bold">All Orders</div>
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
                        <th class="text-left">Invoice no</th>
                        <th class="text-left">Date</th>
                        <th class="text-left">Transaction no</th>
                        <th class="text-left">Total</th>
                        <th class="text-left">Payment</th>
                        <th class="text-left">Status</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if($orders->count())
                    @foreach($orders as $index => $order)
                    <tr class="{{$index%2 == 0 ? '' : 'bg-gray-800'}}">
                        <td class="text-left">{{$order->invoice_no}}</td>
                        <td class="text-left">{{$order->order_date}}</td>
                        <td class="text-left">{{$order->transaction_id}}</td>
                        <td class="text-left">${{$order->amount}}</td>
                        <td class="text-left">{{$order->payment_method}}</td>
                        <td><span class="w-full text-center bg-gray-400 rounded-full px-2 my-1 text-white">{{$order->status}}</span></td>
                        <td class="p-1 flex flex-col lg:flex-row space-x-1 space-y-1 items-center min-w-max">
                            <a href="{{route('my.order.details', ['orderId' => $order->id])}}" class="bg-blue-400 rounded-full hover:bg-blue-600 px-2 w-full lg:w-1/2 grid grid-cols-2 items-center"><span class="text-center px-2 col-span-2 lg:col-span-1"><i class="fa fa-eye" aria-hidden="true"></i></span><span class="sr-only lg:not-sr-only lg:pr-2">view</span></a>
                            <a href="" class="w-full lg:w-1/2 bg-purple-400 rounded-full hover:bg-purple-600 px-2 grid grid-cols-2 items-center"><span class="text-center px-2 col-span-2 lg:col-span-1"><i class="fa fa-download" aria-hidden="true"></i></span><span class="sr-only lg:not-sr-only lg:pr-2">invoice</span></a>
                        </td>
                    </tr>
                    @endforeach
                    @else
                    <tr colspan="7">There are no orders...</tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
@section('page_footer_scripts')
<script src="{{asset('backend/assets/js/alerts.js')}}"></script>
@endsection