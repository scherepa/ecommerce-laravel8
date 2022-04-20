<div class="bg-gray-100 flex justify-between items-center px-4 md:px-6 border-b-2 border-black">
    <div class="text-lg md:text-2xl font-extrabold py-4 sm:block flex-shrink-0 cursor-pointer">
        <span class="inline-block pr-2 hidden md:inline-block"><img src="{{ asset('backend/images/pexels-artem-beliaikin-1051747-logo.jpg')}}" alt="logo" class="rounded-full h-12 w-12 object-cover"></span><span class="pr-0 text-yellow-500">E-com</span><span class="hidden md:inline-block">merce</span>
    </div>
    <div class="py-4 sm:block">

        @auth('admin')
        <form action="{{route('admin.logout')}}" method="post">
            @csrf
            <button type="submit" class="text-2xl text-gray-700"><i class="fa fa-sign-out" aria-hidden="true" title="Sign out"></i>
            </button>
        </form>
        @else
        @if(Route::has('admin.login'))
        <a href="{{ url('/admin/login') }}" class="text-base md:text-2xl text-gray-700"><i class="fa fa-sign-in" aria-hidden="true" title="Login"></i>
        </a>
        @endif
        @endauth
    </div>
</div>