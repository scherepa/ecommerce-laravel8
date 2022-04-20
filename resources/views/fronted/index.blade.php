@extends('layouts.fronted.master')
@section('discription')
<meta name="description" content="E-com fashion, digital and more products. This is a larvel project of commercial web. But not open for shopping yet... Next may be yours.">
<meta name="keywords" content="Laravel 8, commercial, project, junior webdeveloper.">
@endsection
@section('title', 'Home')
@section('page_styles')
<style rel="stylesheet" href="{{ asset('fronted/assets/css/first.css') }}"></style>
@endsection
@section('content')

<!-- Slider -->
<div id="sliderWrap">
    <div class="w-full relative h-96 text-gray-100" id="slider">
        @foreach($slides as $key => $slide)
        <!-- only active sliders will be shown -->
        <div class="absolute z-0 inset-0 flex items-center justify-center transition-all ease-in-out duration-1000 slide {{$key == 0 ? 'first': 'hidden'}}" style="background-image: linear-gradient(45deg, rgba(127, 63, 191, 1) 0 50%, rgb(223, 208, 235) 50% 100%),url('{{asset($slide->slider_img)}}'); height: 24rem; background-position: center,center; background-repeat: no-repeat, no-repeat; background-size: cover, contain; background-blend-mode: overlay;">
            <div class="w-56 max-w-full min-w-max text-lg md:text-2xl lg:text-5xl text-center text-gray-900 font-bold py-4 px-2" style="background: linear-gradient(45deg,  rgba(255, 255, 255, 0.4) 0 50%, rgba(127, 63, 191, 0.4) 50% 100%)">{{$slide->title}}
                <p class="text-sm">{{$slide->description}}</p>
            </div>

        </div>
        @endforeach
    </div>
    <div class=" flex items-center justify-between p-4">
        <button id="prev" class="py-2 px-6 md:px-12 bg-gray-700 hover:bg-gray-500 rounded-full  text-purple-200 hover:text-purple-900 text-sm font-bold">Prev</button>
        <button id="next" class="py-2 px-6 md:px-12 bg-gray-700 hover:bg-gray-500 rounded-full  text-purple-200 hover:text-purple-900 text-sm font-bold">Next</button>
    </div>
</div>

<!-- Sale -->
<!-- Grid wrapper -->
<div class="relative bg-gray-100 rounded-t">
    <div class="text-pink-900 text-xl font-bold text-right w-full py-3 pr-12 rounded-t" style="background: linear-gradient(45deg, rgba(255, 255, 255, 0.4) 0 75%, rgba(244, 114, 182, 0.41) 75% 100%)">
        <div class="flex justify-between">
            <a href="{{route('prod.allsales')}}" class="text-pink-900 text-lg font-bold text-right p-3 ml-1 rounded-full border border-2 border-pink-900 bg-pink-300 hover:bg-pink-600 hover:text-pink-100"><span>
                    {{session()->get('language') == 'hebrew' ? 'כל המבצעים' : 'All Sales'}}</span></a>
            <div>{{session()->get('language') == 'hebrew' ? 'מכירה' : 'Sale'}}</div>
        </div>
    </div><span class="material-icons bg-pink-500 text-white absolute top-0.5 right-0.5 p-2 rounded-full">
        monetization_on
    </span>
</div>
<!-- -mx-4 -->
<div class="flex flex-wrap {{session()->get('language') == 'hebrew' ? 'flex-row-reverse' : ''}}">
    @if($allprods->count())
    @foreach ($allprods as $prod)
    @if(!$prod->featured && !$prod->hot_deals && $prod->discount_price )
    <x-my-product :prod="$prod" />
    @endif
    @endforeach
    @endif
</div>
<!-- Hot -->
<div class="relative bg-gray-100 rounded-t">
    <div class="text-red-900 text-xl font-bold text-right w-full py-3 pr-12 rounded-t" style="background: linear-gradient(45deg, rgba(255, 255, 255, 0.4) 0 75%, rgba(244, 114, 182, 0.41) 75% 100%)">
        <div class="flex justify-between">
            <a href="{{route('prod.allhot')}}" class="text-pink-800 text-lg font-bold text-right px-6 py-2 ml-1 rounded-full border border-2 border-red-900 bg-red-300 hover:bg-red-400 hover:text-white"><span>
                    {{session()->get('language') == 'hebrew' ? 'חם' : 'Hot'}}</span></a>
            <div>{{session()->get('language') == 'hebrew' ? 'חם' : 'Hot'}}</div>
        </div>
    </div>
    <span class="material-icons bg-red-500 text-white absolute top-0.5 right-0.5 p-2 rounded-full">
        whatshot
    </span>
</div>

<div class="-mx-4 flex flex-wrap {{session()->get('language') == 'hebrew' ? 'flex-row-reverse' : ''}}">
    @if($allprods->count())
    @foreach ($allprods as $prod)
    @if($prod->hot_deals && !$prod->discount_price && !$prod->featured)
    <x-my-product :prod="$prod" />
    @endif
    @endforeach
    @endif
</div>

<div class="relative bg-gray-100 rounded-t">
    <div class="text-green-900 text-xl font-bold text-right w-full py-3 pr-12 rounded-t" style="background: linear-gradient(45deg, rgba(255, 255, 255, 0.4) 0 75%, #6ee7b7 75% 100%)">{{session()->get('language') == 'hebrew' ? 'מומלצים' : 'Featured'}}</div><span class="material-icons bg-green-600 text-white absolute top-0.5 right-0.5 p-2 rounded-full">
        stars
    </span>
</div>

<div class="-mx-4 flex flex-wrap {{session()->get('language') == 'hebrew' ? 'flex-row-reverse' : ''}}">
    @if($allprods->count())
    @foreach ($allprods as $prod)
    @if($prod->featured && !$prod->hot_deals && !$prod->discount_price )
    <x-my-product :prod="$prod" />
    @endif
    @endforeach
    @endif

</div>
<!-- New Arrivals -->

<div class="relative bg-gray-100 rounded-t">
    <div class="text-blue-900 text-xl font-bold text-right w-full py-3 pr-12 rounded-t" style="background: linear-gradient(45deg, rgba(255, 255, 255, 0.4) 0 75%, rgba(25, 181, 254, 0.41) 75% 100%)">{{session()->get('language') == 'hebrew' ? 'חדש' : 'New Arrivals'}}</div><span class="material-icons bg-blue-500 text-white absolute top-0.5 right-0.5 p-2 rounded-full">
        new_releases
    </span>
</div>

<div class="-mx-4 flex flex-wrap {{session()->get('language') == 'hebrew' ? 'flex-row-reverse' : ''}}">
    @if($nprods->count())
    @foreach ($nprods as $prod)
    <x-my-product :prod="$prod" />
    @endforeach
    @endif
</div>
<!-- Brands -->
<div class="my-4 flex flex-wrap  bg-gray-100 {{session()->get('language') == 'hebrew' ? 'flex-row-reverse' : ''}} ">
    @foreach($brands as $brand)
    <!-- Grid column -->
    <div class="w-14 flex flex-col p-1">
        <a href="#" class="w-full rounded-lg border border-gray-900">
            <img src=" {{asset($brand->image)}}" alt="{{$brand->name_en}}" class="object-contain h-12 w-full rounded">
        </a>
    </div>
    @endforeach
</div>
@endsection
@section('page_footer_scripts')
<script src="{{asset('fronted/assets/js/slider.js')}}"></script>
@endsection