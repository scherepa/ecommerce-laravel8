@extends('layouts.fronted.master')
@section('discription')
<meta name="description" content="E-com fashion, digital and more products. This is a larvel project of commercial web. But not open for shopping yet... Next may be yours.">
<meta name="keywords" content="Laravel 8, commercial, project, junior webdeveloper.">
@endsection
@section('title', $prod->product_name_en)
@section('page_styles')
<style rel="stylesheet" href="{{ asset('fronted/assets/css/first.css') }}"></style>
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
@endsection
@section('content')
<div class="text-gray-100 text-xl font-bold text-center py-4">
    <h2>{{$prod->product_name_en}}</h2>
</div>
<!-- -mx-4  -->
<div class="flex">
    <div class="w-full flex flex-col p-4 justify-center content-center">
        <div class="w-full  mx-auto bg-gray-800 rounded p-4">
            @livewire('single-product',['prod'=>$prod,'multi'=>$multi, 'color_en' => $color_en, 'color_heb' => $color_heb, 'size_en' => $size_en])
        </div>
    </div>
</div>
@if($related->count()||$same->count())
<!-- -mx-4 -->
<div class="flex flex-wrap {{session()->get('language') == 'hebrew' ? 'flex-row-reverse' : ''}} bg-gradient-to-t from-purple-800">
    @if($related->count())
    @foreach ($related as $prod)
    <x-my-product :prod="$prod" />
    @endforeach
    @endif
    @if($prods->count())
    @foreach ($prods as $prodf)
    <x-my-product :prod="$prodf" />
    @endforeach
    @endif
</div>
@endif
@endsection
@section('page_footer_scripts')
<script src="{{asset('fronted/assets/js/slider.js')}}"></script>
@endsection