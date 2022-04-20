@extends('layouts.fronted.master')
@section('discription')
<meta name="description" content="E-com fashion, digital and more products. This is a larvel project of commercial web. But not open for shopping yet... Next may be yours.">
<meta name="keywords" content="Laravel 8, commercial, project, junior webdeveloper.">
@endsection
@section('title', 'Wishlist')
@section('page_styles')
<style rel="stylesheet" href="{{ asset('fronted/assets/css/first.css') }}"></style>
@endsection
@section('content')
<div class="flex w-full my-12 text-gray-100">
    @if(session('success') || session('fail'))
    @php($status = session('success') ? 'success' : 'fail')
    <div class="myAlert hidden fixed top-20">
        <div class="{{$status == 'success' ? 'text-green-200 bg-green-600 my-4 p-2 md:p-4 rounded flex justify-between items-center' : 'text-red-200 bg-red-500 my-4 rounded p-2 md:p-4 flex justify-between items-center'}}">
            <span class="{{$status == 'success' ? 'material-icons self-center mr-2' : 'material-icons-round self-center mr-2'}}">
                @if($status == 'success')
                check_circle
                @else
                error
                @endif
            </span>
            <div class="divide-y divide-solid divide-green-200 flex-grow">
                <h3 class="pb-3 font-serif">

                    @if($status == 'success')
                    Success!
                    @else
                    Sorry!
                    @endif

                </h3>
                <p class="pt-3">{{session($status)}}</p>
            </div>
            <strong class="text-xl cursor-pointer del-alert text-white self-start px-2">&times;</strong>
        </div>
    </div>
    @endif
    <div class="w-full md:rounded p-4 bg-gray-700">
        <div class="overflow-x-auto mx-4">
            <table class="table-auto w-full text-sm min-w-max">
                <thead>
                    <tr>
                        <th colspan="4" class="heading-title">My Wishlist</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($wishlist as $wish)
                    <tr>
                        <td class="min-w-max"><img src="{{asset($wish->product->product_thumbnail)}}" alt="image" class="w-32 object-cover mx-auto"></td>
                        <td class="min-w-max px-4">
                            <div class="product-name mx-auto"><a href="#">{{$wish->product->product_name_en}}</a></div>
                            <div class=" price">

                                @if($wish->product->discount_price)
                                <span class="line-through">{{$wish->product->selling_price}}</span>
                                <span>{{$wish->product->discount_price}}</span> $
                                @else
                                <div>{{$wish->product->selling_price}} $</div>
                                @endif
                            </div>
                        </td>
                        <td class="px-2">
                            <button class="p-2 text-lg bg-blue-500 rounded-lg" type="button" title="Add Cart" data-toggle="modal" data-target="#exampleModal" id="{{$wish->product_id}}" onclick="productView(this.id)"> Add to Cart </button>
                        </td>
                        <td class="px-2 close-btn">
                            <form action="{{route('removeFromWishlist', $wish->id)}}" method="post">
                                @method('delete')
                                @csrf
                                <button type="submit" class="bg-red-500 p-2 rounded-lg"><i class="fa fa-times"></i></button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
@section('page_footer_scripts')
<script src="{{asset('backend/assets/js/alerts.js')}}"></script>
@endsection