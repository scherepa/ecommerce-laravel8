<div class="md:grid md:grid-cols-6 md:gap-4 lg:gap-6">
    <div class="md:col-span-3 lg:col-span-2 flex flex-col justify-between rounded bg-gray-700 p-1">
        <div class="w-full text-gray-100  xl:col-span-6">
            @if ($multi->count())
            <div id="sliderWrap" class="p-2">
                <div class="w-full relative h-64  text-gray-100" id="slider">
                    <div class="absolute z-0 inset-0 flex items-center justify-center transition-all ease-in-out duration-1000 slide first" style="background-image: linear-gradient(45deg, #7c3aed 0 50%, white 50% 100%),url('{{asset($prod->product_thumbnail)}}'); height: 16rem; background-position: center,center; background-repeat: no-repeat, no-repeat; background-size: cover, contain; background-blend-mode: overlay;">
                        <div class="h-32 px-12 py-2" style="background: linear-gradient(45deg,  rgba(255, 255, 255, 0.4) 0 50%, rgba(127, 63, 191, 0.4) 50% 100%)">
                            <img src="{{asset($prod->product_thumbnail)}}" alt="{{session()->get('language') == 'hebrew' ? $prod->product_name_heb : $prod->product_name_en}}" class="object-contain h-24">
                        </div>
                        @if($prod->discount_price)
                        <span class="rounded-full bg-red-500 text-gray-100 text-xs font-semibold absolute top-1 right-1">
                            {{round((($prod->selling_price - $prod->discount_price)/$prod->selling_price)*100)}}%
                        </span>
                        @endif
                    </div>
                    @foreach($multi as $key => $photo)
                    <!-- only active sliders will be shown -->
                    <div class="absolute z-0 inset-0 flex items-center justify-center transition-all ease-in-out duration-1000 slide hidden" style="background-image: linear-gradient(45deg, #7c3aed 0 50%, white 50% 100%),url('{{asset($photo->photo_name)}}'); height: 16rem; background-position: center,center; background-repeat: no-repeat, no-repeat; background-size: cover, contain; background-blend-mode: overlay;">
                        <div class="h-32 px-12 py-2" style="background: linear-gradient(45deg,  rgba(255, 255, 255, 0.4) 0 50%, rgba(127, 63, 191, 0.4) 50% 100%)">
                            <img src="{{asset($photo->photo_name)}}" alt="{{session()->get('language') == 'hebrew' ? $prod->product_name_heb : $prod->product_name_en}}" class="object-contain h-24">
                        </div>
                        @if($prod->discount_price)
                        <span class="rounded-full bg-red-500 text-gray-100 text-xs font-semibold absolute top-1 right-1">
                            {{round((($prod->selling_price - $prod->discount_price)/$prod->selling_price)*100)}}%
                        </span>
                        @endif
                    </div>
                    @endforeach
                </div>
                <div class=" flex items-center justify-between p-4">
                    <button id="prev" class="py-1 px-2  bg-purple-700 hover:bg-purple-100 rounded-full  text-purple-100 hover:text-purple-900 text-sm font-bold">Prev</button>
                    <button id="next" class="py-1 px-2  bg-purple-700 hover:bg-purple-100 rounded-full  text-purple-100 hover:text-purple-900 text-sm font-bold">Next</button>
                </div>
            </div>
            @else
            <div class="h-32"><img src=" {{asset($prod->product_thumbnail)}}" alt="{{$prod->product_name_en}}" class="object-cover h-32 rounded-t"></div>
            @endif
        </div>
    </div>
    <div class="md:col-span-3 lg:col-span-4 rounded bg-gray-700 grid flex-cols-3 content-between space-x-1 p-1">
        <div style="background-image:url('{{asset($prod->product_thumbnail)}}'); height: 16rem; background-position:center; background-repeat: no-repeat; background-size:contain;">
            <div class="{{session()->get('language') == 'hebrew' ? 'rtl' : ''}} rounded-l bg-gradient-to-b from-purple-600 p-2">

                <h3 class=" text-gray-100 text-lg font-bold">{{session()->get('language') == 'hebrew' ? $prod->product_name_heb : $prod->product_name_en}}</h3>
                <p class="text-yellow-300">raiting</p>
                <p class="w-full text-sm font-thin text-gray-100 leading-tight">
                    {{session()->get('language') == 'hebrew' ? $prod->short_descp_heb : $prod->short_descp_en}}
                </p>

            </div>
        </div>
        <div class="{{session()->get('language') == 'hebrew' ? 'rtl' : ''}} font-bold text-gray-100 text-sm rounded-l bg-gradient-to-t from-purple-600 p-2">
            <h3>{{session()->get('language') == 'hebrew' ? 'הזמן עכשיו' : 'Order Now'}}</h3>
            <!-- <form class="w-full space-y-2 p-2"> -->
            <h3 class="invisible" id="single-modal-title">{{$prod->product_name_en}}
            </h3>
            @if($prod->discount_price)
            <div>
                <span class="line-through">{{ $prod->selling_price }}</span>
                <span class="text-2xl font-extrabold">{{ $prod->discount_price }}</span> $
            </div>
            @else
            <div class="text-2xl font-extrabold">{{ $prod->selling_price }} $</div>
            @endif
            <div class="mb-2 grid grid-cols-6 lg:gap-4">
                <div id="#single-chooseColor" class="font-bold text-sm text-red-500 col-span-6"></div>
                <label for="color" class="text-gray-100 text-sm font-semibold pr-2 py-2 col-span-3  lg:col-span-1">{{session()->get('language') != 'hebrew' ? 'colors' : 'צבע'}}</label>
                <select class="col-span-6 lg:col-span-4 text-gray-800 rounded-lg text-sm border" id="single-color" name="color">
                    @if(session()->get('language') != 'hebrew')
                    @foreach($color_en as $color)
                    <option value="{{ $color }}">{{ $color }}</option>
                    @endforeach
                    @else
                    @foreach($color_heb as $color)
                    <option value="{{ $color }}">{{ $color }}</option>
                    @endforeach
                    @endif
                </select>
            </div>
            @if($size_en)
            <div class="mb-2 grid grid-cols-6 lg:gap-4" id="sizearea">
                <label for="size" class="text-gray-100 text-sm font-semibold pr-2 py-2 col-span-3  lg:col-span-1">{{session()->get('language') == 'hebrew' ? 'מידה' : 'size'}}</label>
                <select class="col-span-6 lg:col-span-4 text-gray-800 rounded-lg text-sm border" id="single-size" name="size">
                    @foreach($size_en as $size)
                    <option value="{{ $size }}">{{ $size }}</option>
                    @endforeach
                </select>
            </div>
            @endif
            <div class="mb-2 grid grid-cols-6 lg:gap-4">
                <label for="qty" class="text-gray-100 text-sm font-semibold pr-2 py-2 col-span-3  lg:col-span-1">{{session()->get('language') == 'hebrew' ? 'כמות' : 'Qty'}}</label>
                <div class="col-span-6 lg:col-span-4 text-gray-800 rounded-lg text-sm">
                    <input type="number" class="rounded-lg w-2/6 lg:w-3/12 text-sm font-semibold text-gray-900" id="single-qty" value="1" min="1" name="qty" max="{{$prod->product_qty}}">
                </div>
            </div>
            <input type="hidden" id="single_product_id" value="{{$prod->id}}">
            @if($prod->product_qty > 0)
            <div class="lg:flex lg:justify-between">
                <button class="my-2 font-bold text-right w-full lg:w-1/3 rounded-lg shadow-lg border-gray-100 border {{session()->get('language') == 'hebrew' ? 'rtl' : ''}}" style="background: linear-gradient(45deg, white 0 25%, #7c3aed 25% 100%);" onclick="addSingleToCart(true)"><span class="not-sr-only hidden md:inline-block">{{session()->get('language') == 'hebrew' ? 'קנה עכשיו' : 'Buy now'}}</span>
                    <span class="material-icons text-purple-300 hover:text-purple-100 bg-purple-800 hover:bg-purple-600 rounded-full p-2 m-1">
                        point_of_sale
                    </span>
                </button>
                <div class="my-2 cursor-pointer font-bold text-right w-full lg:w-1/3 rounded-lg shadow-lg border-gray-100 border {{session()->get('language') == 'hebrew' ? 'rtl' : ''}}" style="background: linear-gradient(45deg, white 0 25%, #7c3aed 25% 100%);" onclick="addSingleToCart()"><span class="not-sr-only hidden md:inline-block">{{session()->get('language') == 'hebrew' ?  'הוסף לסל' : 'add to cart'}}</span><span class="material-icons text-purple-300 hover:text-purple-100 bg-purple-800 hover:bg-purple-600 rounded-full p-2 m-1">
                        add_shopping_cart
                    </span>
                </div>
            </div>
            @endif
            <!-- </form> -->
        </div>
    </div>
    <div class=" md:col-span-6 {{session()->get('language') == 'hebrew' ? 'rtl' : ''}}">
        <p class="text-gray-100 text-lg font-bold">{{session()->get('language') == 'hebrew' ? $prod->product_name_heb : $prod->product_name_en}} Full Description</p>
        <p class="text-gray-100 text-sm font-bold">{{session()->get('language') == 'hebrew' ? $prod->brand->name_heb : $prod->brand->name_en}}</p>
        <p class="text-sm font-thin text-gray-100 leading-tight">{{session()->get('language') == 'hebrew' ? $prod->long_descp_heb : $prod->long_descp_en}}
        </p>
    </div>
</div>