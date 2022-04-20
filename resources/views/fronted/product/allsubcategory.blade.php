@extends('layouts.fronted.master')
@section('title', $cat->name_en)
@section('discription')
<meta name="description" content="E-com fashion, digital and more products. This is a larvel project of commercial web. But not open for shopping yet... Next may be yours.">
<meta name="keywords" content="Laravel 8, commercial, project, junior webdeveloper.">
@endsection
@section('title', '{{$cat->name_en}}')
@section('page_styles')
<style rel="stylesheet" href="{{ asset('fronted/assets/css/first.css') }}"></style>
@endsection
@section('content')
<div class="relative bg-gray-100 rounded my-8">
    <div class="text-green-900 text-xl font-bold text-right w-full py-3 pr-12 rounded-t bg-gradient-to-b from-green-800">{{session()->get('language') == 'hebrew' ? $cat->name_heb : $cat->name_en}}
    </div>
</div>
@if($prods->count())
<!-- -mx-4 -->
<div class="flex flex-wrap {{session()->get('language') == 'hebrew' ? 'flex-row-reverse' : ''}} bg-gradient-to-t from-green-800">
    @foreach ($prods as $prod)
    <x-my-product :prod="$prod" />
    @endforeach
</div>
@else
<div>Whoops There are no products in this category...</div>
@endif
@endsection