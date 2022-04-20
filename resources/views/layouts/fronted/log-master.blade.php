<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @yield('discription')
    <title>E-com - @yield('title')</title>
    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
    <!-- icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <!-- Styles -->
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/css/heb.css') }}">
    @livewireStyles
    @yield('page_styles')
    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}" defer></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    @yield('page_header_scripts')
</head>

<body>
    <!-- Container from md -->
    <div class="min-h-screen w-full mx-auto px-4 bg-gray-900 flex flex-col">
        <header>
            <div class="bg-gray-100 flex justify-between items-center px-4 md:px-6 border-b-2 border-black">
                <div class="text-lg md:text-2xl font-extrabold py-4 sm:block flex-shrink-0 cursor-pointer">
                    <a href="{{url('/')}}">
                        <span class="inline-block pr-2 hidden md:inline-block"><img src="{{ asset('backend/images/pexels-artem-beliaikin-1051747-logo.jpg')}}" alt="logo" class="rounded-full h-12 w-12 object-cover"></span><span class="pr-0 text-purple-500">E-com</span><span class="hidden md:inline-block">merce</span>
                    </a>
                </div>
                <div class="py-4 sm:block">
                    <span class="px-2">
                        <a class="px-2 bg-purple-400 text-white hover:text-purple-900 rounded-full" href="{{url('/')}}" id="home"><i class="fa fa-home" aria-hidden="true"></i><span class="sr-only">Home</span></a>
                    </span>
                    @auth
                    <form action="{{route('logout')}}" method="post">
                        @csrf
                        <button type="submit" class="text-2xl text-gray-700"><i class="fa fa-sign-out" aria-hidden="true" title="Sign out"></i><span class="sr-only">Sign out</span>
                        </button>
                    </form>@endauth
                    @guest
                    <a href="{{ route('login') }}" class="text-base md:text-2xl text-gray-700 px-2"><i class="fa fa-sign-in" aria-hidden="true" title="Login"></i><span class="sr-only">Login</span></a>
                    <a href="{{ route('register') }}" class="text-base md:text-2xl text-gray-700 px-2"><i class="fa fa-user-plus" aria-hidden="true" title="register"></i><span class="sr-only">Register</span></a>
                    @endguest
                </div>
            </div>
        </header>
        <div class="flex-1 flex flex-col">
            @yield('content')
        </div>
        <footer>
            <div class="bg-transparent text-gray-100 grid grid-cols-2 px-4">
                <div class="text-sm font-extrabold py-2">
                    E-com<span class="hidden md:inline-block">merce</span>
                </div>
                <div class="pb-4  text-xs tracking-widest text-right">
                    laravel-project<br>&copy;SvCher-2021
                </div>
            </div>
        </footer>
    </div>
    <script src="{{asset('fronted/assets/js/menu.js')}}"></script>
    @stack('modals')

    @livewireScripts
    @yield('page_footer_scripts')
</body>

</html>