@extends('layouts.fronted.master')
@section('title', 'Login')
@section('content')

<div class="py-12 flex place-content-center bg-gradient-to-b from-gray-900 to-gray-100">
    <div class="-mx-4 bg-gradient-to-t from-gray-600 to-gray-100 w-11/12 md:w-1/2 lg:w-2/5 xl:w-1/3 bg-white rounded-lg p-2 md:p-6">
        <h1 class="font-serif font-bold mb-2 text-gray-900">Please Log In:</h1>
        <x-jet-validation-errors class="mb-4" />
        <form action="{{ (isset($guard) && $guard != 'web') ? url($guard.'/login') : route('login') }}" method="POST" class="mb-4">
            @csrf
            <div class="mb-2 grid grid-cols-12 lg:gap-4">
                <label for="email" class="text-gray-900 text-sm font-semibold pr-2 py-2 col-span-4 lg:col-span-3">Email <span class="text-red-500">*</span></label>
                <input type="email" name="email" id="email" class="col-span-12 lg:col-span-9 rounded-lg text-sm border @error('email')  border-red-500 @enderror" value=" {{old('email')}}" placeholder="example@gmail.com" required>
            </div>
            @error('email')
            <div class="text-red-500 text-sm">{{$message}}</div>
            @enderror
            <div class="mb-2 grid grid-cols-12 lg:gap-4">
                <label for="password" class="text-gray-900 text-sm font-semibold pr-2 py-2 col-span-4 lg:col-span-3">Password <span class="text-red-500">*</span></label>
                <input type="password" name="password" id="password" placeholder="Your password" class="col-span-12 lg:col-span-9 rounded-lg text-sm border @error('password')  border-red-500 @enderror" required autocomplete="current-password">
            </div>
            @error('password')
            <div class="text-red-500 text-sm">{{$message}}</div>
            @enderror
            <div class="block mb-4">
                <label for="remember_me" class="flex items-center">
                    <x-jet-checkbox id="remember_me" name="remember" />
                    <span class="font-serif ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
            </div>
            <div>
                <button type="submit" class="font-serif transform motion-safe:hover:scale-105 bg-green-400 w-full rounded-lg font-semibold text-white py-2 focus:ring-4 focus:ring-green-300 focus:ring-opacity-50 hover:bg-green-600 transition ease-in-out duration-700 shadow-lg">Log in</button>
            </div>
        </form>


        @if (Route::has('password.request'))
        <p class="font-serif text-gray-900 text-sm mb-2">Forgot your password?</p>
        <a href="{{route('password.request')}}">
            <div class="font-serif transform motion-safe:hover:scale-105 w-full py-1 hover:text-white text-blue-600 rounded-lg font-semibold my-2 border-2 border-blue-100 bg-white hover:bg-blue-600 rounded transition ease-in-out duration-700 text-center">Remind
            </div>
        </a>
        @endif
        <p class="font-serif text-gray-900 text-sm my-2">New user?</p>
        <a href="{{route('register')}}">
            <div class="font-serif transform motion-safe:hover:scale-105 w-full text-center py-1 bg-white text-gray-600 font-semibold rounded-lg transition ease-in-out duration-700 border-2 border-gray-100 hover:text-white hover:bg-gray-400">Register</div>
        </a>
    </div>
</div>

@endsection