<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>E-com </title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


    <!-- Styles -->
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    @livewireStyles
    @yield('page_styles')
    <style>
        .first {
            opacity: 1;
            animation: opacity 200ms ease-in-out;
        }

        @keyframes op {
            0% {
                opacity: 0
            }

            100% {
                opacity: 1
            }
        }
    </style>


    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}" defer></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    @yield('page_header_scripts')


</head>

<body>

    <!-- Container -->

    <div class="min-h-screen w-full mx-auto px-4 bg-gray-900 flex flex-col">
        <header>
            @include('layouts.fronted.header')
        </header>


        <div class="flex-1">
            <!-- Grid wrapper -->
            <div id="sliderWrap">
                <div class="w-full relative h-64 text-gray-100" id="slider">
                    <div class="absolute inset-0  bg-purple-500 flex items-center justify-center text-5xl transition-all ease-in-out duration-1000 slide first 1">Fassion</div>
                    <div class="hidden absolute inset-0  bg-purple-500  flex items-center justify-center text-5xl transition-all ease-in-out duration-1000 slide 2">Accessories</div>
                    <div class="hidden absolute inset-0  bg-purple-500 flex items-center justify-center text-5xl transition-all ease-in-out duration-1000 slide 3">Digital</div>
                </div>
                <div class="flex items-center justify-between p-4">
                    <button id="prev" class="py-2 px-6 md:px-12 bg-gray-700 hover:gray-100 rounded-full  text-purple-200 hover:text-purple-500 ">Prev</button>
                    <button id="next" class="py-2 px-6 md:px-12 bg-gray-700 hover:gray-100 rounded-full  text-purple-200 hover:text-purple-500 ">Next</button>
                </div>
            </div>

            <div class="-mx-4 flex flex-wrap" id="main">
                <!-- main content -->
                <!-- Grid column -->

                <!-- Grid column -->
                <div class="w-full flex flex-col p-4 sm:w-1/2 lg:w-1/3">

                    <!-- Column contents -->

                    <div class="flex flex-col flex-1 px-10 py-12 bg-gray-100 rounded-lg shadow-lg">

                        <div class="flex-1">

                            <h2 class="text-gray-900 text-2xl font-bold leading-snug">

                                Tailwind v1.1.0

                            </h2>

                            <p class="mt-2 text-lg">

                                Tailwind v1.1.0 has been released with some cool new features and a

                                couple of bug fixes. This is the first feature release since the

                                v1.0 release, so let's dig into some of the updates.

                            </p>

                        </div>

                        <a href="#" class="mt-6 inline-flex items-center px-6 py-3 text-gray-100 font-semibold bg-gray-700 rounded-md shadow-sm">

                            View article

                        </a>

                    </div>

                </div>

                <!-- Grid column -->

                <div class="w-full flex flex-col p-4 sm:w-1/2 lg:w-1/3">

                    <!-- Column contents -->

                    <div class="flex flex-col flex-1 px-10 py-12 bg-gray-100 rounded-lg shadow-lg">

                        <div class="flex-1">

                            <h2 class="text-gray-900 text-2xl font-bold leading-snug">

                                Getting Started with Tailwind CSS Custom Forms

                            </h2>

                            <p class="mt-2 text-lg">

                                In this tutorial, I show you how to install the Tailwind CSS Custom

                                Forms plugin and get started using it.

                            </p>

                        </div>

                        <a href="#" class="mt-6 inline-flex items-center px-6 py-3 text-gray-100 font-semibold bg-gray-700 rounded-md shadow-sm">

                            View article

                        </a>

                    </div>

                </div>

            </div>
        </div>

        <footer>
            @include('layouts.fronted.footer')
        </footer>

    </div>
    <script src="{{asset('fronted/assets/js/menu.js')}}"></script>

    <script>
        let current = $(".first");
        let next = current.next();
        let prev = $("#slider").children().last();
        let interval = setInterval(startshow, 4000);
        function startshow() {
            //loop on every first class in the page
            $(".first").each(function() {
                current = $(this);
                next = $("#slider").children().last().hasClass("first") ? $("#slider").children().first() : $(this).next();
                prev = $("#slider").children().first().hasClass("first") ? $("#slider").children().last() : $(this).prev();
                $(this).toggleClass("hidden").toggleClass("first");
                next.toggleClass("first").toggleClass("hidden");
                prev = current;
                current = next;
                next = $("#slider").children().last().hasClass("first") ? $("#slider").children().first() : current.next();
                //check if the last element has first class to repeat the loop again
                if ($("#slider").children().last().hasClass("first")) {
                    setTimeout(function() {
                        /* console.log(current); */
                        $("#slider").children().first().removeClass("hidden").addClass("first");
                        current = $("#slider").children().first();
                        prev = $("#slider").children().last();
                        next = current.next();
                    }, 4000); //you must set this time as the same time for setInterval time
                }

            });
        }

        function checkshow(func) {
            if (func == 'start') {
                interval = setInterval(startshow, 4000);
            } else {
                clearInterval(interval);

            }
        }

        function afterprev() {
            checkshow('start');
        }

        $('#prev').click(function() {
            checkshow('stop');
            current.toggleClass('hidden').toggleClass("first");
            prev.toggleClass('first').toggleClass("hidden");
            next = current;
            current = prev;
            prev = $("#slider").children().first().hasClass("first") ? $("#slider").children().last() : current.prev();
            afterprev();
        });
        $('#next').click(function() {
            checkshow('stop');
            current.toggleClass('hidden').toggleClass("first");
            next.toggleClass('first').toggleClass("hidden");
            prev = current;
            current = next;
            next = $("#slider").children().last().hasClass("first") ? $("#slider").children().first() : current.next();
            afterprev();
        });
    </script>

</body>

</html>