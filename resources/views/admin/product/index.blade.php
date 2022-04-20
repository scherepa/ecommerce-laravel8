@extends('admin.admin_master')

@section('title', 'All Products')
@section('page_styles')
<!-- tagsinput from bootstrap... -->
<link rel='stylesheet' href="{{asset('backend/assets/js/bootstrap-tagsinput-latest/dist/bootstrap-tagsinput.css')}}">
<!-- rewrite css 4 tags input -->
<style type="text/css">
    input {
        outline: none;
    }

    .bootstrap-tagsinput .tag {
        margin-right: 2px;
        color: white !important;
        background-color: #a78bfa;
        padding: .2em .6em .3em;
        font-size: 100%;
        font-weight: 700;
        vertical-align: baseline;
        border-radius: .25em;
    }
</style>
@section('page_header_scripts')
<!-- tagsinput from bootstrap -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.min.js"></script> -->
<script src="{{asset('backend/assets/js/bootstrap-tagsinput-latest/dist/bootstrap-tagsinput.js')}}"></script>

@endsection
@section('admin')
<div class="p-4 bg-gray-900 md:rounded">
    <div class="p-4 mb-4">
        <h2 class="font-serif font-bold text-xl text-gray-100 leading-tight">
            All Products
        </h2>
    </div>
    <div class="p-4 md:rounded bg-gray-800 mb-2">
        <h3 class="font-serif font-semibold text-lg text-gray-100 leading-tight">
            All Products Information
        </h3>
        <p class="text-sm text-gray-300 leading-tight mt-1 mb-2">
            Veiw your products's main information, add new product or delete product.
        </p>
    </div>
    <!-- table -->
    <div class="flex w-full">
        <div class="w-full md:rounded p-2 bg-gray-700">
            <div class="overflow-x-auto m-2">
                @livewire('allproducts')
            </div>
        </div>
    </div>
    <!-- Slider -->
    <div id="sliderWrap">
        <div class="w-full relative h-64 text-gray-100" id="slider">
            @foreach($prods as $key => $prod)
            <!-- only active sliders will be shown -->
            <div class="absolute z-0 inset-0 flex items-center justify-center transition-all ease-in-out duration-1000 slide {{$key == 0 ? 'first': 'hidden'}}" style="background-image: linear-gradient(45deg, rgba(127, 63, 191, 1) 0 50%, white 50% 100%),url('{{asset($prod->product_thumbnail)}}'); height: 16rem; background-position: center,center; background-repeat: no-repeat, no-repeat; background-size: cover, contain; background-blend-mode: overlay;">
                <p class="text-xl md:text-2xl lg:text-5xl text-center text-gray-900 font-bold p-8" style="background: linear-gradient(45deg,  rgba(255, 255, 255, 0.4) 0 50%, rgba(127, 63, 191, 0.4) 50% 100%)">{{$prod->product_name_en}}</p>
            </div>
            @endforeach
        </div>
        <div class=" flex items-center justify-between p-4">
            <button id="prev" class="py-2 px-6 md:px-12 bg-gray-700 hover:bg-gray-500 rounded-full  text-purple-200 hover:text-purple-900 text-sm font-bold">Prev</button>
            <button id="next" class="py-2 px-6 md:px-12 bg-gray-700 hover:bg-gray-500 rounded-full  text-purple-200 hover:text-purple-900 text-sm font-bold">Next</button>
        </div>
    </div>
    <x-jet-section-border />
    @auth('admin')
    <div class="p-4 md:rounded bg-gray-800 mb-2">
        <h3 class="font-serif font-semibold text-lg text-gray-100 leading-tight">
            New Product
        </h3>
        <p class="text-sm text-gray-300 leading-tight mt-1 mb-2">
            Add new Product.
        </p>
    </div>
    <div class="p-4 md:p-6 lg:py-10 lg:px-12 md:rounded bg-gray-700">
        <form action="{{ route('admin.store.product') }}" method="POST" enctype="multipart/form-data" class="w-full">
            @csrf
            <div class="mb-2 grid grid-cols-6 lg:gap-4">
                <label for="name_en" class="text-gray-100 text-sm font-semibold pr-2 py-2 col-span-3  lg:col-span-1">English name<span class="text-red-500 text-xs">*</span>:</label>
                <input type="text" name="name_en" id="name_en" class="col-span-6 lg:col-span-5 rounded-lg text-sm border @error('name_en')  border-red-500 @enderror" value="{{old('name_en')}}" placeholder="En Poduct Name" required autofocus>
            </div>
            @error('name_en')
            <div class="text-red-500 text-sm">{{$message}}</div>
            @enderror


            <div class="mb-2 grid grid-cols-6 lg:gap-4">
                <label for="name_heb" class="text-gray-100 text-sm font-semibold pr-2 py-2 col-span-3 lg:col-span-1">Hebrew name<span class="text-red-500 text-xs">*</span>:</label>
                <input type="text" name="name_heb" id="name_heb" class="col-span-6 lg:col-span-5 rounded-lg text-sm border @error('name_heb')  border-red-500 @enderror rtl" value="{{old('name_heb')}}" placeholder="שם המותג" required autofocus>
            </div>
            @error('name_heb')
            <div class="text-red-500 text-sm">{{$message}}</div>
            @enderror

            <x-jet-section-border />
            <div class="mb-2 grid grid-cols-6 gap-4">
                <label for="brand_id" class="text-gray-100 text-sm font-semibold pr-2 py-2 col-span-3  lg:col-span-1">Brand<span class="text-red-500 text-xs">*</span>:</label>
                <select name="brand_id" id="brand_id" class="col-span-6 lg:col-span-5  rounded-lg text-sm border @error('brand_id')  border-red-500 @enderror" required autofocus>
                    <option value="" disabled selected>Select Brand</option>
                    @if($brands->count())
                    @foreach($brands as $key => $brand)
                    <option value="{{$brand->id}}">{{$brand->name_en}}</option>
                    @endforeach
                    @endif
                </select>
            </div>
            @error('brand')
            <div class="text-red-500 text-sm">{{$message}}</div>
            @enderror

            <div class="mb-2 grid grid-cols-6 gap-4">
                <label for="category_id" class="text-gray-100 text-sm font-semibold pr-2 py-2 col-span-3  lg:col-span-1">Category<span class="text-red-500 text-xs">*</span>:</label>
                <select name="category_id" id="category_id" class="col-span-6 lg:col-span-5  rounded-lg text-sm border @error('category_id')  border-red-500 @enderror" required autofocus>
                    <option value="" disabled selected>Select Category</option>
                    @if($categories->count())
                    @foreach($categories as $key => $categ)
                    <option value="{{$categ->id}}">{{$categ->name_en}}</option>
                    @endforeach
                    @endif
                </select>
            </div>
            @error('category_id')
            <div class="text-red-500 text-sm">{{$message}}</div>
            @enderror

            <div class="mb-2 grid grid-cols-6 lg:gap-4">
                <label for="sub_category_id" class="text-gray-100 text-sm font-semibold pr-2 py-2 col-span-3  lg:col-span-1">Sub Category<span class="text-red-500 text-xs">*</span>:</label>
                <select name="sub_category_id" id="sub_category_id" class="test col-span-6 lg:col-span-5  rounded-lg text-sm border @error('sub_category_id')  border-red-500 @enderror" required>
                    <option value="" disabled selected>Select Sub Category</option>
                </select>
            </div>
            @error('sub_category_id')
            <div class="text-red-500 text-sm">{{$message}}</div>
            @enderror

            <div class="mb-2 grid grid-cols-6 lg:gap-4">
                <label for="sub_sub_category_id" class="text-gray-100 text-sm font-semibold pr-2 py-2 col-span-3  lg:col-span-1">2Sub Category<span class="text-red-500 text-xs">*</span>:</label>
                <select name="sub_sub_category_id" id="sub_sub_category_id" class="test1 col-span-6 lg:col-span-5  rounded-lg text-sm border @error('sub_sub_category_id')  border-red-500 @enderror" required>
                    <option value="" selected disabled>Select Sub Sub Category</option>
                </select>
            </div>
            @error('sub_sub_category_id')
            <div class="text-red-500 text-sm">{{$message}}</div>
            @enderror
            <x-jet-section-border />
            <div class="mb-2 grid grid-cols-6 lg:gap-4">
                <label for="code" class="text-gray-100 text-sm font-semibold pr-2 py-2 col-span-3  lg:col-span-1">Code<span class="text-red-500 text-xs">*</span>:</label>
                <input type="text" name="code" id="code" class="col-span-6 lg:col-span-5 rounded-lg text-sm border @error('code')  border-red-500 @enderror" value="{{old('product_code')}}" placeholder="Product Code" required>
            </div>
            @error('code')
            <div class="text-red-500 text-sm">{{$message}}</div>
            @enderror
            <x-jet-section-border />
            <div class="mb-2 grid grid-cols-6 lg:gap-4">
                <p class="col-span-3  lg:col-span-1 font-bold text-gray-100 text-sm py-2 pr-2">Color & Size</p>
                <div class="col-span-6 lg:col-span-5 flex flex-wrap place-content-between">
                    <span class="mb-2">
                        <label for="product_color_en" class="text-gray-100 text-sm font-semibold pr-2 py-2">Product color english<span class="text-red-500 text-xs">*</span>:</label>
                        <div>
                            <input type="text" name="product_color_en" id="product_color_en" class="rounded-lg text-sm border @error('product_color_en')  border-red-500 @enderror w-full" value="{{old('product_color_en')}}" placeholder="Product color english" data-role="tagsinput required">

                            @error('product_color_en')
                            <div class="text-red-500 text-sm">{{$message}}</div>
                            @enderror
                        </div>
                    </span>
                    <span class="mb-2">

                        <label for="product_color_heb" class="text-gray-100 text-sm font-semibold pr-2 py-2" required>Product color hebrew<span class="text-red-500 text-xs">*</span>:</label>
                        <div>
                            <input type="text" name="product_color_heb" id="product_color_heb" class="rounded-lg text-sm border @error('product_color_heb')  border-red-500 @enderror w-full" value="{{old('product_color_heb')}}" placeholder="Product color hebrew" data-role="tagsinput">

                            @error('product_color_heb')
                            <div class="text-red-500 text-sm">{{$message}}</div>
                            @enderror
                        </div>
                    </span>
                    <span class="mb-2">
                        <label for="product_size_en" class="text-gray-100 text-sm font-semibold pr-2 py-2">Product size english:</label>
                        <div>
                            <input type="text" name="product_size_en" id="product_size_en" class="rounded-lg text-sm border @error('product_size_en')  border-red-500 @enderror w-full" value="{{old('product_size_en')}}" placeholder="Product size english" data-role="tagsinput">

                            @error('product_size_en')
                            <div class="text-red-500 text-sm">{{$message}}</div>
                            @enderror
                        </div>
                    </span>
                </div>
            </div>
            <x-jet-section-border />
            <div class="mb-2 grid grid-cols-6 lg:gap-4">
                <label for="product_tags_heb" class="text-gray-100 text-sm font-semibold pr-2 py-2 col-span-3  lg:col-span-1">Product Tags Hebrew<span class="text-red-500 text-xs">*</span>:</label>
                <div class="col-span-6 lg:col-span-5 tags-default bg-white rounded text-gray-600 px-4 py-6 controls">
                    <input type="text" name="product_tags_heb" id="product_tags_heb" class="rounded-lg text-sm" value="{{old('product_tags_heb')}}" placeholder="Product Tags Hebre" required data-role="tagsinput">
                </div>
            </div>
            @error('product_tags_heb')
            <div class="text-red-500 text-sm">{{$message}}</div>
            @enderror

            <div class="mb-2 grid grid-cols-6 lg:gap-4">
                <label for="product_tags_en" class="text-gray-100 text-sm font-semibold pr-2 py-2 col-span-3  lg:col-span-1">Product Tags English<span class="text-red-500 text-xs">*</span>:</label>
                <!--  tags-default -->
                <div class="col-span-6 lg:col-span-5 bg-white rounded text-gray-600 px-4 py-6 controls">
                    <input type="text" name="product_tags_en" id="product_tags_en" class="rounded-lg text-sm" value="{{old('product_tags_en')}}" placeholder="Product Tags English" required data-role="tagsinput" autofocus>
                </div>
            </div>
            @error('product_tags_en')
            <div class="text-red-500 text-sm">{{$message}}</div>
            @enderror
            <x-jet-section-border />
            <div class="mb-2 grid grid-cols-6 lg:gap-4">
                <p class="col-span-3  lg:col-span-1 font-bold text-gray-100 text-sm py-2 pr-2">Price</p>
                <div class="col-span-6 lg:col-span-5 flex flex-wrap place-content-between">
                    <span class="mb-2">
                        <label for="selling_price" class="text-gray-100 text-sm font-semibold pr-2 py-2">Selling Price<span class="text-red-500 text-xs">*</span>:</label>
                        <div>
                            <input type="text" name="selling_price" id="selling_price" class="rounded-lg text-sm border @error('price')  border-red-500 @enderror w-full" value="{{old('selling_price')}}" placeholder="Price" required>

                            @error('selling_price')
                            <div class="text-red-500 text-sm">{{$message}}</div>
                            @enderror
                        </div>
                    </span>
                    <span class="mb-2">
                        <label for="discount_price" class="text-gray-100 text-sm font-semibold pr-2 py-2  w-1/2 lg:w-1/6">Discount Price:</label>
                        <div>
                            <input type="text" name="discount_price" id="discount_price" class="w-full rounded-lg text-sm border @error('discount_price')  border-red-500 @enderror" value="{{old('discount_price')}}" placeholder="Discount Price in dollars">

                            @error('discount_price')
                            <div class="text-red-500 text-sm col-span-6">{{$message}}</div>
                            @enderror
                        </div>
                    </span>
                </div>
            </div>
            <x-jet-section-border />
            <div class="mb-2 grid grid-cols-6 lg:gap-4">
                <label for="short_descp_en" class="text-gray-100 text-sm font-semibold pr-2 py-2 col-span-3  lg:col-span-1">Short Description En<span class="text-red-500 text-xs">*</span>:</label>
                <textarea type="text" name="short_descp_en" id="short_descp_en" class="col-span-6 lg:col-span-5 rounded-lg text-sm border @error('short_descp_en')  border-red-500 @enderror" placeholder="English Short Description" required>{{old('short_descp_en')}}</textarea>
            </div>
            @error('short_descp_en')
            <div class="text-red-500 text-sm">{{$message}}</div>
            @enderror

            <div class="mb-2 grid grid-cols-6 lg:gap-4">
                <label for="short_descp_heb" class="text-gray-100 text-sm font-semibold pr-2 py-2 col-span-3  lg:col-span-1">Short Description Heb<span class="text-red-500 text-xs">*</span>:</label>
                <textarea name="short_descp_heb" id="short_descp_heb" class="col-span-6 lg:col-span-5 rounded-lg text-sm border @error('short_descp_heb')  border-red-500 @enderror rtl" placeholder="Short Description Heb" required>{{old('short_descp_heb')}}</textarea>
            </div>
            @error('short_descp_heb')
            <div class="text-red-500 text-sm">{{$message}}</div>
            @enderror

            <div class="mb-2 grid grid-cols-6 lg:gap-4">
                <label for="long_descp_en" class="text-gray-100 text-sm font-semibold pr-2 py-2 col-span-3  lg:col-span-1">Full Description English<span class="text-red-500 text-xs">*</span>:</label>
                <textarea type="text" name="long_descp_en" id="editor" class="col-span-6 lg:col-span-5 rounded-lg text-sm border @error('long_descp_en')  border-red-500 @enderror" required>{{old('long_descp_en')}}</textarea>
            </div>
            @error('long_descp')
            <div class="text-red-500 text-sm">{{$message}}</div>
            @enderror

            <div class="mb-2 grid grid-cols-6 lg:gap-4">
                <label for="long_descp_heb" class="text-gray-100 text-sm font-semibold pr-2 py-2 col-span-3  lg:col-span-1">Full Description Heb<span class="text-red-500 text-xs">*</span>:</label>
                <textarea name="long_descp_heb" id="long_descp_heb" class="col-span-6 lg:col-span-5 rounded-lg text-sm border @error('long_descp_heb')  border-red-500 @enderror rtl" placeholder="Full description hebrew" required>{{old('long_descp_heb')}}</textarea>
            </div>
            @error('long_descp_heb')
            <div class="text-red-500 text-sm">{{$message}}</div>
            @enderror
            <x-jet-section-border />
            <div class="mb-2 grid grid-cols-6 lg:gap-4">
                <p class="col-span-3  lg:col-span-1 font-semibold text-gray-100 text-sm py-2 pr-2">Features & Status</p>
                <div class="col-span-6 lg:col-span-5 flex place-content-between flex-wrap">
                    <fieldset>
                        <span>
                            <input type="checkbox" id="hot_deals" name="hot_deals" value="1">
                            <div>
                                <label for="hot_deals" class="text-gray-100 text-sm font-semibold pr-2 py-2">Hot Deals</label>
                            </div>
                        </span>
                        <span>
                            <input type="checkbox" id="featured" name="featured" value="1">
                            <div>
                                <label for="featured" class="text-gray-100 text-sm font-semibold pr-2 py-2">Featured</label>
                            </div>
                        </span>
                    </fieldset>
                    <fieldset>
                        <span>
                            <input type="checkbox" id="special_offer" name="special_offer" value="1">
                            <div><label for="special_offer" class="text-gray-100 text-sm font-semibold pr-2 py-2">Special Offer</label></div>
                        </span>
                        <span>
                            <input type="checkbox" id="checkbox_5" name="special_deals" value="1">
                            <div>
                                <label for="checkbox_5" class="text-gray-100 text-sm font-semibold pr-2 py-2">Special Deals</label>
                            </div>
                        </span>
                    </fieldset>
                </div>
            </div>
            <x-jet-section-border />
            <div class="mb-2 grid grid-cols-6 lg:gap-4">
                <p class="col-span-3  lg:col-span-1 font-semibold text-gray-100 text-sm py-2 pr-2">Images</p>
                <div class="col-span-6 lg:col-span-5">
                    <div class="hidden">
                        <input type="file" name="image[]" id="image" accept="image/*" style="height:20; padding:0;" aria-describedby="image" multiple="multiple">
                    </div>
                    <div class=" text-gray-100 text-sm  pr-2 py-2 col-span-3 lg:col-span-1">Upload to gallery
                    </div>
                    <label for="image" role="button" class="mb-2">
                        <div class="py-2 w-full rounded-lg  @error('images') bg-red-600 text-white border-red-500 @else bg-gray-100 text-gray-900 hover:bg-gray-400 @enderror text-center"><i class="fa fa-upload" aria-hidden="true" title="Want to Upload"></i> Poduct multi Images</div>
                    </label>
                    <div class="text-gray-200 flex flex-wrap rounded mt-1 justify-between space-y-1" id="showImageHere"></div>
                    <div class="hidden">
                        <input type="file" name="thumbnail" id="thumbnail" accept="image/*" style="height:0; padding:0;" aria-describedby="thumbnail" required>
                    </div>
                    <div class="text-gray-100 text-sm pr-2 py-2 col-span-3 lg:col-span-1">
                        Upload thumbnail
                    </div>
                    <label for="thumbnail" role="button" class="mb-2">
                        <div class="py-2 w-full rounded-lg  @error('thumbnail') bg-red-600 text-white border-red-500 @else bg-gray-100 text-gray-900 hover:bg-gray-400 @enderror text-center"><i class="fa fa-upload" aria-hidden="true" title="Want to Upload"></i> Poduct Thumbnail<span class="text-red-500 text-xs">*</span>
                        </div>
                    </label>
                    <div class="text-gray-200 flex rounded mt-1" id="preview"></div>
                </div>

                @error('thumbnail')
                <div class="text-red-500 text-sm">{{$message}}</div>
                @enderror

            </div>
            <x-jet-section-border />
            <div class="mb-2 lg:grid lg:grid-cols-6 lg:gap-4">
                <label for="product_qty" class="text-gray-100 text-sm font-semibold pr-2 py-2 lg:col-span-1">Qty<span class="text-red-500 text-xs">*</span>:</label>
                <div class="py-2">
                    <input type="text" name="product_qty" id="product_qty" class="rounded-lg text-sm border @error('product_qty')  border-red-500 @enderror" value="{{old('product_qty')}}" placeholder="Qty" required>
                </div>
            </div>
            @error('product_qty')
            <div class="text-red-500 text-sm">{{$message}}</div>
            @enderror
            <x-jet-section-border />
            <div class="grid grid-cols-6 lg:gap-4 mt-2">
                <h4 class="text-gray-100 font-bold col-span-3 lg:col-span-1">Upload this product?</h4>
                <button type=" submit" class="bg-purple-600 hover:bg-purple-800 text-gray-100 ml-auto w-full col-span-6 lg:col-span-5  rounded  mt-4 py-2">
                    Add Poduct
                </button>
            </div>
        </form>
    </div>
    @endauth
</div>
@endsection
@section('page_footer_scripts')
<script src="{{asset('backend/assets/js/alerts.js')}}"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{asset('backend/assets/js/deleteAlert.js')}}"></script>
<script src="{{asset('backend/assets/js/myMulti.js')}}"></script>
<script src="{{asset('fronted/assets/js/slider.js')}}"></script>

<script>
    $(document).ready(function() {
        $('#sub_category_id').on('change', function() {
            let sub_category_id = $(this).val();
            if (sub_category_id) {
                $.ajax({
                    url: "{{ url('/admin/subsubcategory/ajax') }}/" + sub_category_id,
                    type: "GET",
                    dataType: "json",
                    success: function(data1) {
                        $('.test1').empty()
                        $.each(data1, function(key, value) {
                            $('.test1').append('<option value="' + value.id + '">' + value.name_en + '</option>');
                        });
                    },
                });
            } else {
                alert('danger');
            }
        });

        $('select[name="category_id"]').on('change', function() {
            let category_id = $(this).val();
            if (category_id) {
                $.ajax({
                    url: "{{ url('/admin/subcategory/ajax') }}/" + category_id,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        //console.log(data);
                        $('select[name="sub_category_id"]').empty();
                        $('.test1').empty();
                        let b = "stam";
                        let a = 'selected';
                        $('.test').append('<option value= "" "' + a + '"  id="' + b + '">Subcategory?</option>');
                        a = 'disabled';
                        $.each(data, function(key, value) {
                            $('.test').append('<option value="' + value.id + '">' + value.name_en + '</option>');
                        });
                        $('#stam').prop('disabled', true);

                    },
                });
            } else {
                alert('danger');
            }
        });

    });
</script>

@endsection