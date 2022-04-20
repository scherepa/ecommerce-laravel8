@php
$route = Route::current()->getName();
@endphp

<div class="bg-gray-300 md:bg-gray-900 pr-6 md:pr-0 overflow-auto w-4/5 md:w-4/12 lg:w-3/12 hidden  md:block transition ease-in-out duration-700" id="sidebar">
    <div class="p-4 space-y-6 bg-gray-900 text-gray-100 min-h-full">
        <div class="flex justify-between">
            <a href="{{route('admin.dashboard')}}" class="text-2xl md:text-xl font-bold flex items-center space-x-2 rounded  hover:bg-gray-100 hover:text-gray-900 motion-safe:hover:scale-105 ease-in-out px-4 transition duration-700 border-2 {{$route == 'admin.dashboard' ? 'border-purple-400' : 'border-white'}}">
                <!-- logo -->
                <i class="fa fa-tachometer" aria-hidden="true" title="Controls"></i>
                <span class="hidden md:inline-block">Controls</span>
            </a>
            <button id="closebtn" class="text-2xl md:hidden  motion-safe:hover:scale-110 ease-in-out transition duration-700"><i class="fa fa-window-close" aria-hidden="true" title="Close"></i>
            </button>
        </div>
        <!-- sidebar -->
        <nav>
            <div class="p-4 bg-gray-800 rounded space-y-4">
                @auth('admin')
                <div id="app_wrap">
                    <div id="app_brand" class="p-2 text-base rounded hover:text-lg hover:bg-gray-200 hover:text-black hover:font-extrabold transform motion-safe:hover:scale-105 transition ease-in-out duration-700 bg-gray-700 {{str_contains($route,'brand') ? 'bg-purple-600' : 'bg-gray-700'}}">Brands</div>
                    <div class="mt-4 space-y-2">
                        <a href="{{route('admin.show.brand')}}" class="hidden brand-menu text-sm  p-2 {{$route == 'admin.show.brand' ? 'bg-purple-400' : 'bg-gray-700'}}  rounded hover:text-base hover:bg-gray-200 hover:text-black hover:font-extrabold transform motion-safe:hover:scale-105 transition ease-in-out duration-700">All Brands</a>
                        <a href="#" class="hidden brand-menu text-sm  p-2 bg-gray-700 rounded hover:text-base hover:bg-gray-200 hover:text-black hover:font-extrabold transform motion-safe:hover:scale-105 transition ease-in-out duration-700">Compose</a>
                        <a href="#" class="hidden brand-menu text-sm  p-2 bg-gray-700 rounded hover:text-base hover:bg-gray-200 hover:text-black hover:font-extrabold transform motion-safe:hover:scale-105 transition ease-in-out duration-700">Read</a>
                    </div>
                </div>
                <div id="categories_wrap">
                    <div id="categories" class=" p-2 {{str_contains($route,'category') ? 'bg-purple-600' : 'bg-gray-700'}} text-base rounded hover:text-lg hover:text-lg hover:bg-gray-200 hover:text-black  hover:font-extrabold transform motion-safe:hover:scale-105 transition ease-in-out duration-700">
                        Categories
                    </div>
                    <div class="mt-4 space-y-2">
                        <a href="{{route('admin.show.category')}}" class="hidden category-menu text-sm  p-2 {{$route == 'admin.show.category' ? 'bg-purple-400' : 'bg-gray-700'}} rounded hover:text-base hover:bg-gray-200 hover:text-black hover:font-extrabold transform motion-safe:hover:scale-105 transition ease-in-out duration-700">All Categories</a>
                        <a href="{{route('admin.show.subcategory')}}" class="hidden category-menu text-sm  p-2 {{($route == 'admin.show.subcategory' || (!str_contains($route,'subsub') && str_contains($route,'subcategory'))) ? 'bg-purple-400' : 'bg-gray-700'}} rounded hover:text-base hover:bg-gray-200 hover:text-black hover:font-extrabold transform motion-safe:hover:scale-105 transition ease-in-out duration-700">All Sub Categories</a>
                        <a href="{{route('admin.show.subsubcategory')}}" class="hidden category-menu text-sm  p-2 {{($route == 'admin.show.subsubcategory' || str_contains($route,'subsubcategory'))? 'bg-purple-400' : 'bg-gray-700'}} rounded hover:text-base hover:bg-gray-200 hover:text-black hover:font-extrabold transform motion-safe:hover:scale-105 transition ease-in-out duration-700">All Sub Sub Categories</a>
                        <a href="#" class="hidden category-menu text-sm  p-2 bg-gray-700 rounded hover:text-base hover:bg-gray-200 hover:text-black hover:font-extrabold transform motion-safe:hover:scale-105 transition ease-in-out duration-700">Read</a>
                    </div>
                </div>
                <div id="prod_wrap">
                    <div id="prod" class=" p-2 {{str_contains($route,'product') ? 'bg-purple-600' : 'bg-gray-700'}} text-base rounded hover:text-lg hover:text-lg hover:bg-gray-200 hover:text-black  hover:font-extrabold transform motion-safe:hover:scale-105 transition ease-in-out duration-700">
                        Products
                    </div>
                    <div class="mt-4 space-y-2">
                        <a href="{{route('admin.show.product')}}" class="hidden prod-menu text-sm  p-2 {{($route == 'admin.show.product' || str_contains($route,'product')) ? 'bg-purple-400' : 'bg-gray-700'}} rounded hover:text-base hover:bg-gray-200 hover:text-black hover:font-extrabold transform motion-safe:hover:scale-105 transition ease-in-out duration-700">All Products</a>
                    </div>
                </div>
                <div id="ship_wrap">
                    <div id="ship" class=" p-2 {{str_contains($route,'shipping') ? 'bg-purple-600' : 'bg-gray-700'}} text-base rounded hover:text-lg hover:text-lg hover:bg-gray-200 hover:text-black  hover:font-extrabold transform motion-safe:hover:scale-105 transition ease-in-out duration-700">
                        Shipping
                    </div>
                    <div class="mt-4 space-y-2">
                        <a href="{{route('admin.show.shipping.division')}}" class="hidden ship-menu text-sm  p-2 {{($route == 'admin.show.shipping.division' || str_contains($route,'division')) ? 'bg-purple-400' : 'bg-gray-700'}} rounded hover:text-base hover:bg-gray-200 hover:text-black hover:font-extrabold transform motion-safe:hover:scale-105 transition ease-in-out duration-700">All divisions</a>
                    </div>
                    <div class="mt-4 space-y-2">
                        <a href="{{route('admin.show.shipping.district')}}" class="hidden ship-menu text-sm  p-2 {{($route == 'admin.show.shipping.district' || str_contains($route,'district')) ? 'bg-purple-400' : 'bg-gray-700'}} rounded hover:text-base hover:bg-gray-200 hover:text-black hover:font-extrabold transform motion-safe:hover:scale-105 transition ease-in-out duration-700">All districts</a>
                    </div>
                    <div class="mt-4 space-y-2">
                        <a href="{{route('admin.show.shipping.state')}}" class="hidden ship-menu text-sm  p-2 {{($route == 'admin.show.shipping.state' || str_contains($route,'state')) ? 'bg-purple-400' : 'bg-gray-700'}} rounded hover:text-base hover:bg-gray-200 hover:text-black hover:font-extrabold transform motion-safe:hover:scale-105 transition ease-in-out duration-700">All states</a>
                    </div>
                </div>
                <div id="coup_wrap">
                    <div id="coup" class=" p-2 {{str_contains($route,'coupon') ? 'bg-purple-600' : 'bg-gray-700'}} text-base rounded hover:text-lg hover:text-lg hover:bg-gray-200 hover:text-black  hover:font-extrabold transform motion-safe:hover:scale-105 transition ease-in-out duration-700">
                        Coupons
                    </div>
                    <div class="mt-4 space-y-2">
                        <a href="{{route('admin.show.coupon')}}" class="hidden coup_menu text-sm  p-2 {{($route == 'admin.show.coupon' || str_contains($route,'coupon')) ? 'bg-purple-400' : 'bg-gray-700'}} rounded hover:text-base hover:bg-gray-200 hover:text-black hover:font-extrabold transform motion-safe:hover:scale-105 transition ease-in-out duration-700">All Coupons</a>
                    </div>
                </div>
                <a href="{{route('admin.show.slider')}}" class="block p-2 {{($route == 'admin.show.slider' || str_contains($route,'slider')) ? 'bg-purple-600' : 'bg-gray-700'}} text-base rounded hover:text-lg hover:bg-gray-200 hover:text-black hover:font-extrabold transform motion-safe:hover:scale-105 transition ease-in-out duration-700">Slider</a>
                <div id="interface_wrap">
                    <div id="interface" class=" p-2 bg-gray-700 text-base rounded hover:text-lg hover:text-lg hover:bg-gray-200 hover:text-black  hover:font-extrabold transform motion-safe:hover:scale-105 transition ease-in-out duration-700">
                        User Interface
                    </div>
                    <div class="mt-4 space-y-2">
                        <a href="#" class="hidden interface-menu text-sm  p-2 bg-gray-700 rounded hover:text-base hover:bg-gray-200 hover:text-black hover:font-extrabold transform motion-safe:hover:scale-105 transition ease-in-out duration-700">Inbox</a>
                        <a href="#" class="hidden interface-menu text-sm  p-2 bg-gray-700 rounded hover:text-base hover:bg-gray-200 hover:text-black hover:font-extrabold transform motion-safe:hover:scale-105 transition ease-in-out duration-700">Compose</a>
                        <a href="#" class="hidden interface-menu text-sm  p-2 bg-gray-700 rounded hover:text-base hover:bg-gray-200 hover:text-black hover:font-extrabold transform motion-safe:hover:scale-105 transition ease-in-out duration-700">Read</a>
                    </div>
                </div>
                <div id="mail_wrap">
                    <div id="mail" class="p-2 bg-gray-700 text-base rounded hover:text-lg hover:bg-gray-200 hover:text-black  hover:font-extrabold transform motion-safe:hover:scale-105 transition ease-in-out duration-700">
                        Mail
                    </div>
                    <div class="mt-4 space-y-2">
                        <a href="#" class="hidden mail-menu text-sm  p-2 bg-gray-700 rounded hover:text-base hover:bg-gray-200 hover:text-black hover:font-extrabold transform motion-safe:hover:scale-105 transition ease-in-out duration-700">Inbox</a>
                        <a href="#" class="hidden mail-menu text-sm  p-2 bg-gray-700 rounded hover:text-base hover:bg-gray-200 hover:text-black hover:font-extrabold transform motion-safe:hover:scale-105 transition ease-in-out duration-700">Compose</a>
                        <a href="#" class="hidden mail-menu text-sm  p-2 bg-gray-700 rounded hover:text-base hover:bg-gray-200 hover:text-black hover:font-extrabold transform motion-safe:hover:scale-105 transition ease-in-out duration-700">Read</a>
                    </div>
                </div>
            </div>
            <!-- Account Management -->
            <div class="mb-4 p-4 border-t border-gray-200 mt-2">
                <div class="px-2 hidden font-medium md:block text-base text-white">{{ Auth::user()->name }}
                </div>
                <div class="px-2 hidden font-thin md:block text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>
            <div class="p-4 bg-gray-800 rounded space-y-4">
                @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                <a href="{{ route('admin.profile') }}" class="flex-shrink-0">
                    <div class="{{str_contains($route,'profile') ? 'bg-purple-600' : 'bg-gray-700'}} p-2 rounded hover:bg-white  transform motion-safe:hover:scale-105 transition ease-in-out duration-700 hover:px-4">
                        @if (auth()->user()->profile_photo_path)
                        <span class="block rounded-full w-7 h-7 bg-cover bg-no-repeat bg-center" style="background-image: url('{{Storage::url(auth()->user()->profile_photo_path)}}');" alt="{{ Auth::user()->name }}" title="{{ Auth::user()->name}}&#013;{{ Auth::user()->email}}">
                        </span>
                        @else
                        <span class="block rounded-full w-7 h-7 bg-gray-200 text-gray-800 text-base font-extrabold flex justify-center  items-center" alt="{{ Auth::user()->name }}" title="{{ Auth::user()->name}}&#013;{{ Auth::user()->email}}">
                            {{strtoupper(auth()->user()->name[0].auth()->user()->name[1])}}
                        </span>
                        @endif
                    </div>
                </a>
                @endif
                <!-- Authentication -->
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <a href="{{ route('admin.logout') }}" onclick="event.preventDefault();
                                    this.closest('form').submit();">
                        <div class="block bg-gray-700 p-2 text-xl rounded hover:text-2xl hover:bg-gray-200 hover:text-black ease-in-out hover:font-extrabold transition duration-700 text-left">
                            <i class="fa fa-sign-out" aria-hidden="true" title="Log out"></i>
                        </div>
                    </a>
                </form>
            </div>
            @endauth
        </nav>
    </div>
</div>
<!-- button for mobile menu -->
<button id="menubtn" class="focus:outline-none transition ease-in-out duration-700 border-t-2 border-r-2 border-l-0 border-b-2 bg-gray-100 border-gray-900 text-gray-900 hover:bg-gray-900 hover:text-white h-10 w-14 rounded-r-full text-2xl fixed  top-20  md:hidden hover:border-white">
    <i class="fa fa-bars" aria-hidden="true" title="Menu"></i>
</button>