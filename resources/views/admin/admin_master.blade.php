<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="robots" content="none" />

    <title>E-com - @yield('title') </title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/css/scrollbar.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/css/heb.css') }}">


    @livewireStyles
    @yield('page_styles')
    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}" defer></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    @yield('page_header_scripts')

</head>

<body>
    <div class="min-h-screen flex flex-col">
        <!-- header -->
        @include('admin.layout.header')
        <div class="flex flex-col flex-1">
            <div class="flex-1 flex flex-col md:flex-row min-h-full w-full">
                <!-- sidebar -->
                @include('admin.layout.sidebar')

                <!-- main -->
                <div id="main" class="flex-1 w-full md:flex-0 md:w-8/12 lg:9/12 min-h-full flex flex-col bg-gray-900">
                    <div class="flex-1 py-12 lg:px-4 lg:py-12  md:p-0.5 bg-gradient-to-t from-gray-900 to-white">
                        @include('admin.layout.notification')
                        @yield('admin')
                    </div>
                    <!-- footer -->
                    @include('admin.layout.footer')
                </div>

            </div>
        </div>
    </div>
    <script src="{{asset('backend/assets/js/adminLayout.js')}}"></script>
    @stack('modals')
    @livewireScripts
    @yield('page_footer_scripts')
</body>

</html>