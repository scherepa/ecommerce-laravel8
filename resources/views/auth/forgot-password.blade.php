@extends('layouts.fronted.master')
@section('title', 'Remind')
@section('content')
<div class="flex-1 bg-gradient-to-b from-gray-900 to-gray-100 py-20">
    <div class="bg-gradient-to-t from-gray-600 to-gray-100 w-11/12 md:w-1/2  bg-white rounded-lg px-4 md:px-6 py-10 lg:space-y-12 space-y-12 mx-auto">
        <div class="text-sm text-gray-600">
            {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
        </div>

        @if (session('status'))
        <div class="font-medium text-sm text-green-600">
            {{ session('status') }}
        </div>
        @endif

        <x-jet-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="my-10">
                <label for="email" class="sr-only">Email</label>
                <input type="email" name="email" id="email" placeholder="example@walla.com" class="bg-gray-100 w-full border-2 rounded-lg p-4 @error('email') border-red-500 @enderror" value="{{old('email')}}" required autofocus>
            </div>

            <div>
                <button type="submit" class="font-serif transform motion-safe:hover:scale-105 bg-purple-500 w-full rounded font-semibold text-purple-100 px-3 py-4 focus:ring-4 focus:ring-purple-300 focus:ring-opacity-50 hover:bg-purple-800 transition ease-in-out duration-700 shadow-lg">{{ __('Email Password Reset Link') }}</button>
            </div>
        </form>
    </div>
</div>
@endsection