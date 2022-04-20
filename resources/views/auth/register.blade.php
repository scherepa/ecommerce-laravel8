@extends('layouts.fronted.master')
@section('title', 'Register')
@section('content')

<div class="flex justify-center items-center bg-gradient-to-b from-gray-100 py-12">
    <div class="-mx-4 bg-gradient-to-t from-gray-600 to-gray-100 w-11/12 md:w-1/2 lg:w-2/5 xl:w-1/3 bg-white rounded-lg p-2 md:p-6">
        <h1 class="font-serif font-bold mb-2 text-gray-900">Please Register:</h1>
        <x-jet-validation-errors class="mb-4" />
        <form action="{{ route('register') }}" method="POST" class="mb-4">
            @csrf
            <div class="mb-2 grid grid-cols-12 lg:gap-4">
                <label for="name" class="text-gray-900 text-sm font-semibold pr-2 py-2 col-span-4 lg:col-span-3">Name</label>
                <input type="text" name="name" id="name" placeholder="Your name" class="col-span-12 lg:col-span-9 rounded-lg text-sm border @error('name') border-red-500 @enderror" value="{{old('name')}}" required autofocus autocomplete="name">
            </div>
            <div class="mb-2 grid grid-cols-12 lg:gap-4">
                <label for="email" class="text-gray-900 text-sm font-semibold pr-2 py-2 col-span-4 lg:col-span-3">Email</label>
                <input type="email" name="email" id="email" placeholder="example@walla.com" class="col-span-12 lg:col-span-9 rounded-lg text-sm border @error('email') border-red-500 @enderror" value="{{old('email')}}" required>
            </div>
            <div class="mb-2 grid grid-cols-12 lg:gap-4">
                <label for="phone" class="text-gray-900 text-sm font-semibold pr-2 py-2 col-span-4 lg:col-span-3">Phone</label>
                <input type="text" name="phone" id="phone" placeholder="Your phone" class="col-span-12 lg:col-span-9 rounded-lg text-sm border @error('phone') border-red-500 @enderror" value="{{old('phone')}}" autofocus>
            </div>
            <div class="mb-2 grid grid-cols-12 lg:gap-4">
                <label for="password" class="text-gray-900 text-sm font-semibold pr-2 py-2 col-span-4 lg:col-span-3">Password</label>
                <input type="password" name="password" id="password" placeholder="Your password" class="col-span-12 lg:col-span-9 rounded-lg text-sm border @error('password') border-red-500 @enderror" required>
            </div>
            <div class="mb-4 grid grid-cols-12 lg:gap-4">
                <label for="password_confirmation" class="text-gray-900 text-sm font-semibold pr-2 py-2 col-span-4 lg:col-span-3">Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Confirm Password" class="col-span-12 lg:col-span-9 rounded-lg text-sm border @error('password') border-red-500 @enderror" required>
            </div>
            <div>
                <button type="submit" class="font-serif transform motion-safe:hover:scale-105 bg-green-400 w-full rounded-lg font-semibold text-white py-2 focus:ring-4 focus:ring-green-300 focus:ring-opacity-50 hover:bg-green-600 transition ease-in-out duration-700 shadow-lg">Save</button>
            </div>
        </form>
        <p class="font-serif text-gray-900 text-sm my-2">Registered?</p>
        <a href="{{route('login')}}">
            <div class="font-serif transform motion-safe:hover:scale-105 w-full text-center py-1 bg-white text-gray-600 font-semibold rounded-lg transition ease-in-out duration-700 border-2 border-gray-100 hover:text-white hover:bg-gray-400">Log in</div>
        </a>
    </div>
</div>
@endsection