@extends('layouts.fronted.master')
@section('discription')
<meta name="description" content="E-com fashion, digital and more products. This is a larvel project of commercial web. But not open for shopping yet... Next may be yours.">
<meta name="keywords" content="Laravel 8, commercial, project, junior webdeveloper.">
@endsection
@section('title', 'Sale')
@section('page_styles')
<style rel="stylesheet" href="{{ asset('fronted/assets/css/first.css') }}"></style>
@endsection
@section('content')
<!-- Sale -->
<!-- Grid wrapper -->
<div class="relative bg-gray-100 rounded my-8">
    <div class="text-pink-900 text-xl font-bold text-right w-full py-3 pr-12 rounded-t bg-gradient-to-b from-pink-800">{{session()->get('language') == 'hebrew' ? 'מכירה' : 'Sale'}}</div><span class="material-icons bg-pink-500 text-white absolute top-0.5 right-0.5 p-2 rounded-full">
        monetization_on
    </span>
</div>
@if($prods->count())
@if($cats->count())
@foreach($cats as $cat)
@if($prods->contains('category_id', $cat->id))
<div class="relative bg-gray-100 rounded-t">
    <div class="text-green-900 text-xl font-bold text-right w-full py-3 pr-12 rounded-t" style="background: linear-gradient(45deg, rgba(255, 255, 255, 0.4) 0 75%, rgba(52, 211, 153, 0.41) 75% 100%)">{{session()->get('language') == 'hebrew' ? $cat->name_heb : $cat->name_en}}</div>
    @if(!str_contains($cat->icon, 'fa fa-'))
    <span class="material-icons bg-green-500 text-white absolute top-0.5 right-0.5 p-2 rounded-full">
        {{$cat->icon}}
    </span>
    @else
    <span class="bg-green-500 text-white absolute top-0.5 right-0.5 p-2 rounded-full">
        <i class="{{$cat->icon}} text-lg" aria-hidden="true"></i></span>
    @endif
</div>
<!-- -mx-4  -->
<div class="flex flex-wrap {{session()->get('language') == 'hebrew' ? 'flex-row-reverse' : ''}}">
    <!-- main content -->
    <!-- Grid column -->

    @foreach ($prods as $prod)
    @if($prod->category_id==$cat->id)
    <x-my-product :prod="$prod" />
    @endif
    @endforeach

    <!-- Grid column -->
</div>
@endif
@endforeach
@endif
@endif
@endsection