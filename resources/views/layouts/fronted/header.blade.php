<div class="bg-gray-100 flex justify-between items-center px-4 md:px-6 border-b-2 border-black">
    <div class="text-lg md:text-2xl font-extrabold py-4 sm:block flex-shrink-0 cursor-pointer">
        <a href="{{url('/')}}">
            <span class="inline-block pr-2 hidden md:inline-block"><img src="{{ asset('backend/images/pexels-artem-beliaikin-1051747-logo.jpg')}}" alt="logo" class="rounded-full h-12 w-12 object-cover"></span><span class="pr-0 text-purple-500">E-com</span><span class="hidden md:inline-block">merce</span>
        </a>
    </div>
    <div class="py-4 grid grid-cols-2 gap-4">
        @auth
        @if (auth()->user()->profile_photo_path)
        <span class="px-3 py-1">
            <a href="{{url('user/profile')}}">
                <span class="block rounded-full w-6 h-6 bg-cover bg-no-repeat bg-center" style="background-image: url('{{Storage::url(auth()->user()->profile_photo_path)}}');">
                </span>
            </a>
        </span>
        @else
        <span class="px-3 py-1 text-purple-100 hover:text-purple-500 bg-gray-700 rounded-full"><a href="{{url('user/profile')}}"><i class="icon fa fa-user"></i>
            </a>
            <p class="sr-only">To profile</p>
        </span>
        @endif
        <form action="{{route('logout')}}" method="post">
            @csrf
            <button type="submit" class="text-2xl text-gray-700"><i class="fa fa-sign-out" aria-hidden="true" title="Sign out"></i><span class="sr-only">Sign out</span>
            </button>
        </form>
        @else
        <a href="{{ route('login') }}" class="text-base md:text-2xl text-gray-700 px-2"><i class="fa fa-sign-in" aria-hidden="true" title="Login"></i><span class="sr-only">Login</span></a>
        <a href="{{ route('register') }}" class="text-base md:text-2xl text-gray-700 px-2"><i class="fa fa-user-plus" aria-hidden="true" title="register"></i><span class="sr-only">Register</span></a>
        @endauth
    </div>
</div>
<div class="hidden position absolute z-50 w-full px-4 lg:w-1/2 top-18 md:top-20 lg:top-24 right-0" id="miniCartList">
    <div class="bg-gray-700 text-gray-100 py-4 px-2 w-full flex justify-between"><button class="px-2 py-1 bg-red-500 text-gray-100 rounded-lg" onclick="closeMiniCartList()">X</button>
        <span class="inline-block" id="pricing"></span>
    </div>
    <div id="CartListTable" class="w-full flex flex-wrap bg-gray-100 pb-2"></div>
    <div class="flex w-full justify-end bg-gray-200 text-gray-100 py-4 px-2"><a href="{{route('mycartpage')}}" class="w-1/2 md:w-1/3 min-w-max">
            <div class="font-serif transform motion-safe:hover:scale-105 bg-blue-400 rounded-lg font-semibold text-white px-4 py-1 focus:ring-4 focus:ring-blue-300 focus:ring-opacity-50 hover:bg-blue-600 transition ease-in-out duration-700 shadow-lg w-full text-center text-xl md:text-sm"> <i class="icon fa fa-shopping-cart" title='Cart Page'></i><span class="not-sr-only hidden md:inline-block mx-1">@if(session()->get('language') == 'hebrew') סל קניות @else My Cart @endif</span> </div>
        </a></div>
</div>

<nav>

    <div class="bg-gray-900 text-gray-100 text-sm font-bold md-text-lg flex justify-between flex-wrap">
        @if(session()->get('language') == 'hebrew')
        <a href="{{ route('eng.language') }}" class="inline-block px-4 my-3 text-sm text-purple-100 hover:text-purple-500 border border-purple-100 rounded-full hover:border-purple-500 hover:bg-purple-100">
            <span class="material-icons my-1">
                arrow_right
            </span>
            English
        </a>
        @else
        <a href="{{ route('heb.language') }}" class="inline-block px-4 my-3 text-sm text-purple-100 hover:text-purple-500  rtl border border-purple-100 rounded-full hover:border-purple-500 hover:bg-purple-100">
            <span class="material-icons my-1">
                arrow_left
            </span>
            עברית
        </a>
        @endif

        <span class="min-w-min">
            <ul class="flex flex-wrap justify-between w-full">
                @auth
                <li class="p-4 text-purple-100 hover:text-purple-500"><a href="{{route('dashboard')}}"><i class="icon fa fa-dashboard" title='dashboard'></i><span class="not-sr-only hidden lg:inline-block mx-1">@if(session()->get('language') == 'hebrew') ניהול @else Dashboard @endif</span></a></li>
                <li class="p-4 text-purple-100 hover:text-purple-500"><a href="{{route('wishlist')}}"><i class="icon fa fa-heart" title='wishlist'></i><span class="not-sr-only hidden lg:inline-block mx-1">@if(session()->get('language') == 'hebrew') מוצרים אהובים @else Wishlist @endif</span></a></li>
                @endauth
                <li class="p-4 text-purple-100 hover:text-purple-500"><a href="{{route('mycartpage')}}"><i class="icon fa fa-shopping-cart" title='my cart'></i><span class="not-sr-only hidden lg:inline-block mx-1">@if(session()->get('language') == 'hebrew') סל קניות @else Cart @endif</span></a></li>
                <li class="p-4"><button onclick="openMiniCartList()" class="px-2 text-purple-100 hover:text-purple-500 divide-x-2 divide-gray-100 divide-solid rounded-full border border-gray-100 hover:border-purple-500"><i class="icon fa fa-shopping-cart mx-1" title='cart'></i><span class="rounded-full px-2 bg-purple-300 text-sm font-bold" id="miniCart">0</span><span id="totalCart" class="mx-2 px-2">0</span></button></li>
                <li class="p-4 text-purple-100 hover:text-purple-500"><a href="{{route('checkoutPage')}}"><i class="icon fa fa-check" title='checkout'></i><span class="not-sr-only hidden lg:inline-block mx-1">@if(session()->get('language') == 'hebrew') לקופה @else Checkout @endif</span></a></li>
            </ul>
        </span>
    </div>
    <div class="lg:flex lg:justify-between lg:items-center py-4 bg-gray-800">
        <div class="md:px-4 lg:w-1/2 xxl:w-1/3">
            <form class="w-full flex border-2 border-purple-500 rounded-full  bg-purple-400 text-purple-100" id="search">
                <span class="flex-shrink-0">
                    <label for="search_field" class="sr-only">Search by</label>
                    <select id="search_field" name="search_field" class="border-0 bg-purple-400 focus:shadow-inner text-gray-100 sm:text-sm rounded-l-full appearance-none h-full w-full">
                        <option value="all" selected disabled>By</option>
                        <option value="product">Product</option>
                        <option value="category">Category</option>
                        <option value="brand">Brand</option>
                    </select>
                </span>
                <span class="flex-grow">
                    <input type="text" class="w-full focus:outline-none focus:border-purple-400" placeholder="Search...">
                </span>
                <span class="flex-shrink-0">
                    <button class="w-full h-full px-2 bg-purple-400 text-purple-100 rounded-r-full  focus:border-purple-400" type="submit">
                        <i class="fa fa-search" aria-hidden="true"></i><span class="sr-only">Search</span>
                    </button>
                </span>
            </form>
        </div>
        <div class="flex justify-end"><span class="sr-only">Menu</span><i class="fa fa-bars fa-2x visible md:invisible m-4  text-gray-200 cursor-pointer" id="hamburger"></i></div>

    </div>

    <div class="mymainnav">
        <div class="py-4 bg-gray-800 w-full px-4">
            <div class="-mx-4 font-semibold invisible md:visible h-0 md:h-auto relative" id="mymenu">
                <span class="mx-auto px-2 text-purple-100 hover:text-purple-500">
                    <a href="{{url('/')}}" id="home" class="pt-4 border-b-2 border-purple-200"><span class="material-icons">
                            home
                        </span><span class="sr-only">Home</span></a>
                </span>

                @if($cats->count())
                @foreach($cats as $cat)
                <span class="mx-auto px-2 text-purple-100 hover:text-purple-500 text-sm font-bold md:text-base">
                    <a href="{{route('prod.allcateg', [$cat->id,$cat->slug_en])}}" class="inline-block pt-4 px-2">{{session()->get('language') == 'hebrew' ? $cat->name_heb : $cat->name_en}}@if(!str_contains($cat->icon, 'fa fa-'))
                        <span class="material-icons bg-white border-white border text-green-500 rounded-full">
                            {{$cat->icon}}
                        </span>
                        @else
                        <span class="bg-white border-white border rounded-full">
                            <i class="{{$cat->icon}} text-lg" aria-hidden="true"></i></span>
                        @endif
                    </a>
                    <div class="lg:mx-0 bg-gray-300 text-gray-100 rounded-b contents absolute w-full z-40 mysub py-2">
                        <div class="flex flex-wrap w-full">
                            @if($cat->subcategory->count())
                            @foreach($cat->subcategory as $sub)
                            <span class="w-full lg:w-1/3 md:w-1/2 inline-block">
                                <div class="flex w-full">
                                    <a class="flex-1 text-gray-700 font-bold text-sm hover:text-purple-400 mx-2 px-4 py-2 rounded hover:bg-gray-500 itemsub" href="{{route('prod.allsubcateg', [$sub->id,$sub->slug_en])}}">{{session()->get('language') == 'hebrew' ? $sub->name_heb : $sub->name_en}}</a>
                                </div>
                                <div class="bg-gray-100 text-gray-600 rounded-b mysubsub py-2 w-full">
                                    @if($sub->sub_subcategory->count())
                                    @foreach($sub->sub_subcategory as $subsub)
                                    <div class="flex w-full">
                                        <a href="{{route('prod.allsubsubcateg', [$subsub->id,$subsub->slug_en])}}" class="flex-1 text-gray-600 font-bold text-sm hover:text-purple-800 mx-2 px-4 py-2 rounded hover:bg-gray-300">
                                            {{session()->get('language') == 'hebrew' ? $subsub->name_heb : $subsub->name_en}}
                                        </a>
                                    </div>
                                    @endforeach
                                    @endif
                                </div>
                            </span>
                            @endforeach
                            @endif
                        </div>
                    </div>
                </span>
                @endforeach
                @endif
                <span class="mx-auto px-2 text-blue-100 hover:text-blue-500 text-sm font-bold md:text-base">
                    <a href="#" class="inline-block pt-4 px-2">{{session()->get('language') == 'hebrew' ? 'חדש' : 'New'}}<span class="material-icons bg-blue-500 text-white rounded-full">
                            new_releases
                        </span>
                    </a>
                </span>
                <span class="mx-auto px-2 text-red-100 hover:text-red-500 text-sm font-bold md:text-base">
                    <a href="{{route('prod.allhot')}}" class="inline-block pt-4 px-2">{{session()->get('language') == 'hebrew' ? 'חם' : 'Hot'}}<span class="material-icons bg-red-500 text-white rounded-full">
                            whatshot
                        </span>
                    </a>
                </span>
                <span class="mx-auto px-2 text-purple-100 hover:text-purple-500 text-sm font-bold md:text-base">
                    <a href="{{url('/contact')}}" class="inline-block pt-4 px-2"><span class="material-icons bg-white text-purple-500 rounded-full">
                            contact_support
                        </span><span class="sr-only">Contact</span>
                    </a>
                </span>
            </div>
        </div>

    </div>

</nav>