<div class="bg-gray-700 text-gray-100 mb-0 p-2">
    <ul class="grid grid-cols-1 sm:grid-cols-3 md:grid-cols-4 gap-4">
        @if($cats->count())
        @foreach($cats as $cat)
        <li>
            <a href="{{route('prod.allcateg', [$cat->id,$cat->slug_en])}}">
                <div class="text-green-900 hover:text-green-100 font-bold text-right w-full px-2 py-3 rounded-t" style="background: linear-gradient(45deg, white 0 25%, rgba(52, 211, 153, 0.8) 25% 100%)">
                    <span class="not-sr-only hidden md:inline-block">
                        {{session()->get('language') == 'hebrew' ? $cat->name_heb : $cat->name_en}}</span>
                    @if(!str_contains($cat->icon, 'fa fa-'))
                    <span class="material-icons bg-white border-white border text-green-500 p-2 rounded-full">
                        {{$cat->icon}}
                    </span>
                    @else
                    <span class="bg-white border-white border p-2 rounded-full">
                        <i class="{{$cat->icon}} text-lg" aria-hidden="true"></i></span>
                    @endif
                </div>
            </a>
            <ul>
                @foreach($cat->subcategory as $sub)
                <li>
                    <a href="{{route('prod.allsubcateg', [$sub->id,$sub->slug_en])}}">
                        <div class="{{session()->get('language') == 'hebrew' ? 'text-right rtl' : ''}} text-green-900 hover:text-green-100 font-bold w-full px-2 py-3 bg-green-100 hover:bg-green-500 cursor-default text-sm">
                            {{session()->get('language') == 'hebrew' ? $sub->name_heb : $sub->name_en}}
                        </div>
                    </a>
                </li>
                <ul>
                    @foreach($sub->sub_subcategory as $subsub)
                    <li>
                        <a class="text-sm font-semibold" href="{{route('prod.allsubsubcateg', [$subsub->id,$subsub->slug_en])}}">
                            <div class="{{session()->get('language') == 'hebrew' ? 'text-right rtl' : ''}}">
                                {{session()->get('language') == 'hebrew' ? $subsub->name_heb : $subsub->name_en}}
                            </div>
                        </a>
                    </li>
                    @endforeach
                </ul>
                @endforeach
            </ul>
        </li>
        @endforeach
        @endif
        <div>
            <li>
                <a href="{{route('prod.allhot')}}">
                    <div class="text-pink-900 hover:text-pink-100 font-bold px-2 py-3 rounded text-right {{session()->get('language') == 'hebrew' ? 'rtl' : ''}} mb-4" style="background: linear-gradient(45deg, white 0 25%, rgba(244, 114, 182, 0.8) 25% 100%)">{{session()->get('language') == 'hebrew' ? 'חם' : 'Hot'}}
                        <span class="material-icons bg-red-500 text-white p-2 rounded-full">
                            whatshot
                        </span>
                    </div>
                </a>
            </li>
            <li>
                <a href="#">
                    <div class="text-blue-900 hover:text-blue-100 font-bold px-2 py-3 rounded mb-4 text-right {{session()->get('language') == 'hebrew' ? 'rtl' : ''}}" style="background: linear-gradient(45deg, white 0 25%, rgba(25, 181, 254, 0.8) 25% 100%)">{{session()->get('language') == 'hebrew' ? 'חדש' : 'New'}}
                        <span class="material-icons bg-blue-500 text-white p-2 rounded-full">
                            new_releases
                        </span>
                    </div>
                </a>
            </li>
            <li>
                <a href="{{url('/contact')}}">
                    <div class="text-purple-900 hover:text-purple-100 font-bold px-2 py-3 rounded mb-4 text-right {{session()->get('language') == 'hebrew' ? 'rtl' : ''}}" style="background: linear-gradient(45deg, white 0 25%, rgba(150, 25, 254, 0.8) 25% 100%)"><span class="not-sr-only hidden md:inline-block">
                            {{session()->get('language') == 'hebrew' ? 'צור קשר' : 'Contact Us'}}</span>
                        <span class="material-icons bg-white text-purple-500 p-2 rounded-full">
                            contact_support
                        </span>
                    </div>
                </a>
            </li>
        </div>
    </ul>

</div>
<div class="bg-transparent text-gray-100 grid grid-cols-2 px-4">
    <div class="text-sm font-extrabold py-2">
        E-com<span class="hidden md:inline-block">merce</span>
    </div>
    <div class="pb-4  text-xs tracking-widest text-right">
        laravel-project<br>&copy;SvCher-2021
    </div>
</div>