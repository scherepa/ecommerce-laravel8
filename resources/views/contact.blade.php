@extends('layouts.fronted.master')
@section('discription')
<meta name="description" content="E-com fashion, digital and more products. This is a larvel project of commercial web. But not open for shopping yet... Next may be yours.">
<meta name="keywords" content="Laravel 8, commercial, project, junior webdeveloper.">
@endsection
@section('title', 'Contact Us')
@section('page_styles')
<style rel="stylesheet" href="{{ asset('fronted/assets/css/first.css') }}"></style>
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
@endsection
@section('content')
<div class="text-gray-100 text-xl font-bold text-center py-4">
    <h2>We'll be glad to hear from you</h2>
</div>


<div class="-mx-4 flex">

    <!-- Form -->
    <div class="w-full flex flex-col p-4 justify-center content-center">
        <div class="w-full md:w-2/3 mx-auto bg-gray-800 rounded p-4">@livewire('general-contact-form')</div>
    </div>


</div>
@endsection