<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>E-com - Login </title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


    <!-- Styles -->
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">

    @livewireStyles

    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}" defer></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


</head>

<body>
    <div class="min-h-screen flex justify-center items-center bg-gradient-to-b from-gray-900">
        <div class="bg-gradient-to-t from-gray-600 to-white w-10/12 md:w-6/12 lg:w-4/12 bg-white rounded-lg p-6 shadow-lg">
            <h1 class="font-serif font-bold mb-2">Please Login:</h1>
            <x-jet-validation-errors class="mb-4" />
            @if(session('status'))
            <!-- or session()->has('status') -->
            <div class="w-full rounded mb-4 font-medium text-sm px-3 py-4 text-center">
                {{ session('status')}}
            </div>
            @endif
            <form action="{{ isset($guard)? url($guard.'/login') : route('login') }}" method="POST" class="mb-4">
                @csrf
                <div class="mb-4">
                    <label for="email" class="sr-only">Email</label>
                    <input type="email" name="email" id="email" placeholder="example@walla.com" class="bg-gray-100 w-full border-2 rounded-lg p-4 @error('email') border-red-500 @enderror" value="{{old('email')}}">
                </div>
                <div class="mb-4">
                    <label for="password" class="sr-only">Password</label>
                    <input type="password" name="password" id="password" placeholder="Your password" class="bg-gray-100 w-full border-2 rounded-lg p-4 @error('password') border-red-500 @enderror" required autocomplete="current-password">
                </div>
                <div class="block mb-4">
                    <label for="remember_me" class="flex items-center">
                        <x-jet-checkbox id="remember_me" name="remember" />
                        <span class="font-serif ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                    </label>
                </div>
                <div>
                    @if (Route::has('password.request'))
                    <p class="font-serif">Forgot your password?</p>
                    <button class="font-serif transform motion-safe:hover:scale-105 w-full p-4 hover:text-white text-blue-600 rounded font-semibold my-2 border-2 border-blue-100 bg-white hover:bg-blue-600 rounded transition ease-in-out duration-700 shadow-lg "><a href="{{route('password.request')}}" class="w-full">Remind</a></button>
                    @endif
                </div>
                <div>
                    <button type="submit" class="font-serif transform motion-safe:hover:scale-105 bg-green-400 w-full rounded font-semibold text-white px-3 py-4 focus:ring-4 focus:ring-green-300 focus:ring-opacity-50 hover:bg-green-600 transition ease-in-out duration-700 shadow-lg ">Login</button>
                </div>
            </form>
        </div>

    </div>
</body>

</html>