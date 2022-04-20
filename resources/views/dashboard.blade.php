@extends('layouts.fronted.master')
@section('title', 'Ecom - Dashboard')
@section('page_styles')
<style rel="stylesheet" href="{{ asset('fronted/assets/css/first.css') }}"></style>
@endsection
@section('content')
<div class="py-12 space-y-6">
    <h2 class="text-gray-100 text-2xl font-bold">{{ucfirst(auth()->user()->name)}}, Welcome to the Dashboard !</h2>
    @if(session('success') || session('fail'))
    @php($status = session('success') ? 'success' : 'fail')
    <div class="myAlert hidden fixed top-20">
        <div class="{{$status == 'success' ? 'text-green-200 bg-green-600 my-4 p-2 md:p-4 rounded flex justify-between items-center' : 'text-red-200 bg-red-500 my-4 rounded p-2 md:p-4 flex justify-between items-center'}}">
            <span class="{{$status == 'success' ? 'material-icons self-center mr-2' : 'material-icons-round self-center mr-2'}}">
                @if($status == 'success')
                check_circle
                @else
                error
                @endif
            </span>
            <div class="divide-y divide-solid divide-green-200 flex-grow">
                <h3 class="pb-3 font-serif">

                    @if($status == 'success')
                    Success!
                    @else
                    Sorry!
                    @endif

                </h3>
                <p class="pt-3">{{session($status)}}</p>
            </div>
            <strong class="text-xl cursor-pointer del-alert text-white self-start px-2">&times;</strong>
        </div>
    </div>
    @endif

    <div class="lg:grid lg:grid-cols-3 lg:gap-6">
        <div class="lg:col-span-1 flex justify-between">
            <div class="px-4 sm:px-0">
                <h3 class="font serif font-semibold text-lg text-gray-100 leading-tight">Profile Information</h3>
                <p class="text-sm text-gray-300 leading-tight mt-1 mb-2">
                    Review your account's profile general information.
                </p>
            </div>
        </div>
        <div class="lg:col-span-2 rounded bg-gray-700 p-6">
            <p class="text-sm font-thin text-gray-100 leading-tight py-4">{{ucfirst(auth()->user()->name)}} <br>{{auth()->user()->email}}
            </p>
            <div>
                @if (Laravel\Fortify\Features::canUpdateProfileInformation())
                <div class="md:flex md:justify-between">
                    @if (auth()->user()->profile_photo_path)
                    <div>
                        <span class="block rounded-full w-20 h-20 bg-cover bg-no-repeat bg-center" style="background-image: url('{{Storage::url(auth()->user()->profile_photo_path)}}');">
                        </span>
                    </div>
                    @else
                    <div>
                        <span class="block rounded-full w-20 h-20 bg-gray-200 text-gray-800 text-3xl font-extrabold flex justify-center  items-center">
                            {{strtoupper(auth()->user()->name[0].auth()->user()->name[1])}}
                        </span>
                    </div>
                    @endif


                    <a href="{{url('user/profile')}}">
                        <div class="font-serif text-white font-semibold text-sm rounded-lg my-6 py-2 px-10  text-center bg-purple-400 hover:bg-purple-800 motion-safe:hover:scale-105 ease-in-out transition duration-700">TO YOUR PROFILE</div>
                    </a>

                </div>
                @endif
            </div>
        </div>
    </div>

    <div class="lg:grid lg:grid-cols-3 lg:gap-6">
        <div class="lg:col-span-1 flex justify-between">
            <div class="px-4 sm:px-0">
                <h3 class="font serif font-semibold text-lg text-gray-100 leading-tight">Orders Information</h3>
                <p class="text-sm text-gray-300 leading-tight mt-1 mb-2">
                    Review your orders information.
                </p>
            </div>
        </div>
        <div class="lg:col-span-2 rounded bg-gray-700 p-6">
            <p class="text-sm font-thin text-gray-100 leading-tight py-4">Your orders & refunds information
            </p>
            <div>

                <div class="flex flex-wrap justify-center sm:justify-between">
                    <div class="p-4">
                        <p class="text-sm font-thin text-gray-100 leading-tight text-center">
                            Orders</p>
                        <span class="block rounded-full w-20 h-20 bg-gray-200 text-gray-800  font-extrabold flex justify-center  items-center"> {{$orders->count() ? $orders->count() : '0'}}
                        </span>
                    </div>
                    <div class="p-4">
                        <p class="text-sm font-thin text-gray-100 leading-tight text-center">
                            Delivered</p>
                        <span class="block rounded-full w-20 h-20 bg-gray-200 text-gray-800  font-extrabold flex justify-center  items-center"> {{$delivered}}
                        </span>
                    </div>

                    <div class="p-4">
                        <p class="text-sm font-thin text-gray-100 leading-tight text-center">
                            In Process</p>
                        <span class="block rounded-full w-20 h-20 bg-gray-200 text-gray-800  font-extrabold flex justify-center  items-center"> {{$pending}}
                        </span>
                    </div>
                    <div class="p-4">
                        <p class="text-sm font-thin text-gray-100 leading-tight text-center">
                            Payments</p>
                        <span class="block rounded-full h-20 w-20 bg-gray-200 text-gray-800  font-extrabold flex justify-center  items-center"> ${{$amount}}

                        </span>
                    </div>
                    <div class="p-4">
                        <p class="text-sm font-thin text-gray-100 leading-tight text-center">
                            Refunds</p>
                        <span class="block rounded-full w-20 h-20 bg-gray-200 text-gray-800  font-extrabold flex justify-center  items-center">
                            $10
                        </span>
                    </div>

                </div>

                <a href="{{route('my.orders')}}">
                    <div class="font-serif text-sm text-white font-semibold rounded-lg w-full md:w-1/3 my-6 py-2 px-10  text-center bg-purple-400 hover:bg-purple-800 motion-safe:hover:scale-105 ease-in-out transition duration-700 md:ml-auto">ALL ORDERS</div>
                </a>

            </div>
        </div>
    </div>


    <div class="lg:grid lg:grid-cols-3 lg:gap-6">
        <div class="lg:col-span-1 flex justify-between">
            <div class="px-4 sm:px-0">
                <h3 class="font serif font-semibold text-lg text-gray-100 leading-tight">Email and Notifications</h3>
                <p class="text-sm text-gray-300 leading-tight mt-1 mb-2">
                    Review recieved and sent messages.
                </p>
            </div>
        </div>
        <div class="lg:col-span-2 rounded bg-gray-700 p-6">
            <p class="text-sm font-thin text-gray-100 leading-tight py-4">Your email & notifications
            </p>
            <div>

                <div class="flex flex-wrap justify-center sm:justify-between">
                    <div class="p-4">
                        <p class="text-sm font-thin text-gray-100 leading-tight text-center">
                            Sent@</p>
                        <span class="block rounded-full w-20 h-20 bg-gray-200 text-gray-800 text-3xl font-extrabold flex justify-center  items-center mx-auto"> 20
                        </span>
                        <a href="#">
                            <div class="font-serif text-sm text-white font-semibold rounded-lg my-4 px-10 py-2 text-center bg-purple-400 hover:bg-purple-800 motion-safe:hover:scale-105 ease-in-out transition duration-700">REVIEW</div>
                        </a>
                    </div>
                    <div class="p-4">
                        <p class="text-sm font-thin text-gray-100 leading-tight text-center">
                            Inbox@</p>
                        <span class="block rounded-full w-20 h-20 bg-gray-200 text-gray-800 text-3xl font-extrabold flex justify-center  items-center mx-auto"> 10
                        </span>
                        <a href="#">
                            <div class="font-serif text-sm text-white font-semibold rounded-lg my-4 px-10 py-2 text-center bg-purple-400 hover:bg-purple-800 motion-safe:hover:scale-105 ease-in-out transition duration-700">REVIEW</div>
                        </a>
                    </div>

                    <div class="p-4">
                        <p class="text-sm font-thin text-gray-100 leading-tight text-center">
                            Unread@</p>
                        <span class="block rounded-full w-20 h-20 bg-gray-200 text-gray-800 text-3xl font-extrabold flex justify-center  items-center mx-auto"> 1
                        </span>
                        <a href="#">
                            <div class="font-serif text-sm text-white font-semibold  rounded-lg my-4 px-10 py-2 text-center bg-purple-400 hover:bg-purple-800 motion-safe:hover:scale-105 ease-in-out transition duration-700 ">REVIEW</div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('page_footer_scripts')
<script src="{{asset('backend/assets/js/alerts.js')}}"></script>
@endsection