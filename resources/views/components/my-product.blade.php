@props(['prod' => $prod])

<div class="w-full flex flex-col p-4 sm:w-1/2 lg:w-1/4">
    <div class="flex flex-col flex-1 px-6 py-8 bg-gray-100 rounded-lg">

        <div class="flex-1">

            <div class='h-64 relative'><img src=" {{asset($prod->product_thumbnail)}}" alt="{{$prod->product_name_en}}" class="object-cover h-64 w-full"> @if($prod->discount_price)
                <span class="rounded-full bg-red-500 p-2 text-gray-100 text-xs font-semibold absolute top-1 right-1">
                    {{round((($prod->selling_price - $prod->discount_price)/$prod->selling_price)*100)}}%
                </span>
                @endif
            </div>
            <div>
                <p class="p-2 bg-purple-300 text-gray-600 font-bold text-sm {{session()->get('language') == 'hebrew' ? 'rtl' : ''}}">{{session()->get('language') == 'hebrew' ? $prod->product_name_heb : $prod->product_name_en}}</p>
                raiting
            </div>
            @if($prod->discount_price)
            <span class="line-through">{{$prod->selling_price}}</span>
            <span>{{$prod->discount_price}}</span> $
            @else
            <div>{{$prod->selling_price}} $</div>
            @endif
            <div class="flex justify-between">
                <button class="p-2 hover:bg-indigo-300 rounded-full" onclick="addToWishlist('{{ $prod->id }}')" id="{{ $prod->id }}" title="Add to wishlist">
                    <i class=" icon fa fa-heart" title='wishlist'></i>
                </button>
                <button class="p-2 icon text-lg" type="button" title="Add Cart" data-toggle="modal" data-target="#exampleModal" onclick="productView('{{ $prod->id }}')" id="{{ $prod->id }}">
                    <i class="fa fa-shopping-cart"></i>
                </button>
            </div>

        </div>

        <a href="{{route('prod.details', [$prod->id,$prod->product_slug_en])}}" class="mt-6 inline-flex items-center px-6 py-2 text-gray-100 font-semibold bg-gray-700 rounded-md shadow-sm hover:bg-purple-400 hover:text-purple-900 transition ease-in-out duration-700">
            {{session()->get('language') == 'hebrew' ? 'למוצר' : 'View'}}
        </a>

    </div>
</div>