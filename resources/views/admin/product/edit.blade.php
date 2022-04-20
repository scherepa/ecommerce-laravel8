+
@extends('admin.admin_master')

@section('title', 'Edit Product')
@section('page_styles')
<!-- tagsinput from bootstrap... -->
<link rel='stylesheet' href="{{asset('backend/assets/js/bootstrap-tagsinput-latest/dist/bootstrap-tagsinput.css')}}">
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
    @auth('admin')
    <div class="p-4 md:rounded bg-gray-800 mb-2">
        <h3 class="font-serif font-semibold text-lg text-gray-100 leading-tight">
            Manage Product
        </h3>
        <p class="text-sm text-gray-300 leading-tight mt-1 mb-2">
            View and update {{ucfirst($product->product_name_en)}}'s information.
        </p>
    </div>
    <div class="lg:grid sm:rounded-l md:rounded-t lg:grid-cols-12 mb-2 bg-gray-800">
        <div class="p-4 mb-2 lg:mb-0 lg:col-span-3">
            <h3 class="font-serif font-semibold text-gray-100 text-sm text-gray-100 leading-tight">
                Edit Product Gallery
            </h3>
            <p class="text-sm text-gray-300 leading-tight mt-1 mb-2">
                View, update or delete {{ucfirst($product->product_name_en)}}'s gallery images.
            </p>
        </div>
        <div class="p-4 bg-gray-700 lg:rounded-r  lg:col-span-9">
            <p class="font-semibold text-gray-100 text-sm py-2 pr-2">Gallery Images</p>
            <div class="text-gray-100 text-sm  pr-2 py-2">Review, edit or delete the product gallery images
            </div>
            @if($multi->count())
            <div class=" text-gray-100 text-sm">Product previous gallery</div>
            <p class="text-yellow-800 text-xs bg-yellow-200 rounded my-2 py-1 flex space-x-2">
                <span class="material-icons">
                    warning_amber
                </span>
                <span class="py-2 font-semibold">
                    On delete each image will be deleted from the gallery forever.
                </span>
            </p>
            <div class=" text-gray-200 flex flex-wrap rounded my-1 justify-between space-y-1" id="previous_gallery">

                @foreach($multi as $pic)
                <div class="px-1 pt-1 border border-gray-100 rounded-lg w-full md:w-1/3 lg:w-1/4 m-1">
                    <img class="h-20 object-contain rounded mx-auto" src="{{url($pic->photo_name)}}" alt="{{$product->product_name_en}}">
                    <div class="flex justify-between pt-2">
                        <form action="{{route('admin.image.edit', $pic->id)}}" method="GET">
                            <button type="submit" class="rounded-full bg-blue-400 text-gray-100 px-4"><i class="fa fa-pencil-square-o" aria-hidden="true" title="Edit" alt="Edit"></i>
                            </button>
                        </form>
                        @livewire('delete-pic', ['item' => $pic])
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class=" text-gray-100 text-sm">Product previous gallery is empty</div>
            @endif
            <hr class="my-2">
            <form action="{{ route('admin.store.multi', $product->id) }}" method="POST" enctype="multipart/form-data" class="w-full">
                @csrf
                <div class=" text-gray-100 text-sm  pr-2 py-2 col-span-3 lg:col-span-1">Add new images to the product gallery
                </div>
                <p class="text-gray-100 text-xs">On Save new images will be added to the gallery</p>
                <div class="text-gray-200 text-sm flex flex-wrap rounded mt-1 justify-between space-y-1 border border-gray-100 py-1" id="showImageHere"></div>
                <div class="hidden">
                    <input type="file" name="image[]" id="image" accept="image/*" style="height:20; padding:0;" aria-describedby="image" multiple="multiple">
                </div>
                <div class=" text-gray-100 text-sm  pr-2 py-2 col-span-3 lg:col-span-1">Upload to gallery
                </div>
                <label for="image" role="button" class="mb-2">
                    <div class="py-2 w-full rounded-lg  @error('images') bg-red-600 text-white border-red-500 @else bg-gray-100 text-gray-900 hover:bg-gray-400 @enderror text-center"><i class="fa fa-upload" aria-hidden="true" title="Want to Upload"></i> Poduct multi Images</div>
                </label>

                <button type="submit" class="bg-purple-600 hover:bg-purple-800 text-gray-100 ml-auto w-full col-span-6 lg:col-span-5  rounded  mt-4 py-2">
                    Save Images to Gallery
                </button>
            </form>
        </div>
    </div>
    <div class="lg:grid sm:rounded-l md:rounded-t lg:grid-cols-12 mb-2 bg-gray-800">
        <div class="p-4 mb-2 lg:mb-0 lg:col-span-3">
            <h3 class="font-serif font-semibold text-sm text-gray-100 leading-tight">
                Edit Product Thumbnail
            </h3>
            <p class="text-sm text-gray-300 leading-tight mt-1 mb-2">
                View and update {{ucfirst($product->product_name_en)}}'s Thumbnail.
            </p>
        </div>
        <div class="p-4 bg-gray-700 lg:rounded-r  lg:col-span-9">
            <p class="font-semibold text-gray-100 text-sm py-2 pr-2">Main Image</p>
            <form action="{{ route('admin.update.thumbnail', $product->id) }}" method="POST" enctype="multipart/form-data" class="w-full">
                @method('put')
                @csrf
                <div class="flex justify-between mt-1">
                    <span class="text-gray-200 rounded">
                        <div>current</div>
                        <div>
                            <img class="h-20 object-contain rounded" src="{{url($product->product_thumbnail)}}" alt="{{$product->product_name_en}}">
                        </div>
                    </span>
                    <span class="text-gray-200 rounded">
                        <div>new</div>
                        <div id="preview">No new image</div>
                        @error('thumbnail')
                        <div class="text-red-500 text-sm">{{$message}}</div>
                        @enderror
                    </span>
                </div>
                <div class="hidden">
                    <input type="file" name="thumbnail" id="thumbnail" accept="image/*" style="height:0; padding:0;" aria-describedby="thumbnail">
                </div>
                <div class="text-gray-100 text-sm pr-2 py-2 col-span-3 lg:col-span-1">
                    Upload thumbnail
                </div>
                <label for="thumbnail" role="button" class="mb-2">
                    <div class="py-2 w-full rounded-lg  @error('thumbnail') bg-red-600 text-white border-red-500 @else bg-gray-100 text-gray-900 hover:bg-gray-400 @enderror text-center"><i class="fa fa-upload" aria-hidden="true" title="Want to Upload"></i> Poduct Thumbnail</div>
                </label>
                <button type="submit" class="bg-purple-600 hover:bg-purple-800 text-gray-100 ml-auto w-full col-span-6 lg:col-span-5  rounded  mt-4 py-2">
                    Save This Thumbnail
                </button>
            </form>
        </div>
    </div>
    <div class="lg:grid sm:rounded-l md:rounded-t lg:grid-cols-12 mb-2 bg-gray-800">
        <div class="p-4 mb-2 lg:mb-0 lg:col-span-3">
            <h3 class="font-serif font-semibold text-gray-100 text-sm text-gray-100 leading-tight">
                Edit Product
            </h3>
            <p class="text-sm text-gray-300 leading-tight mt-1 mb-2">
                Update {{ucfirst($product->product_name_en)}} General information.
            </p>
        </div>
        <div class="p-4 bg-gray-700 lg:rounded-r  lg:col-span-9">
            <form action="{{ route('admin.product.update',$product->id) }}" method="POST" class="w-full">
                @method('put')
                @csrf
                <div class="mb-2 grid grid-cols-6 lg:gap-4">
                    <label for="name_en" class="text-gray-100 text-sm font-semibold pr-2 py-2 col-span-3  lg:col-span-1">English name:</label>
                    <input type="text" name="name_en" id="name_en" class="col-span-6 lg:col-span-5 rounded-lg text-sm border @error('name_en')  border-red-500 @enderror" value="{{$product->product_name_en}}" placeholder="En Poduct Name" required autofocus>
                </div>
                @error('name_en')
                <div class="text-red-500 text-sm">{{$message}}</div>
                @enderror
                <div class="mb-2 grid grid-cols-6 lg:gap-4">
                    <label for="name_heb" class="text-gray-100 text-sm font-semibold pr-2 py-2 col-span-3 lg:col-span-1">Hebrew name:</label>
                    <input type="text" name="name_heb" id="name_heb" class="col-span-6 lg:col-span-5 rounded-lg text-sm border @error('name_heb')  border-red-500 @enderror rtl" placeholder="שם המותג" required autofocus value="{{$product->product_name_heb}}">
                </div>
                @error('name_heb')
                <div class="text-red-500 text-sm">{{$message}}</div>
                @enderror
                <hr class="my-2">
                <div class="mb-2 grid grid-cols-6 gap-4">
                    <label for="brand_id" class="text-gray-100 text-sm font-semibold pr-2 py-2 col-span-3  lg:col-span-1">Brand:</label>
                    <select name="brand_id" id="brand_id" class="col-span-6 lg:col-span-5  rounded-lg text-sm border @error('brand_id')  border-red-500 @enderror" required autofocus>
                        @if($brands->count())
                        @foreach($brands as $key => $brand)
                        <option value="{{$brand->id}}" {{$brand->id == $product->brand->id ? 'selected' : ''}}>{{$brand->name_en}}</option>
                        @endforeach
                        @endif
                    </select>
                </div>
                @error('brand')
                <div class="text-red-500 text-sm">{{$message}}</div>
                @enderror

                <div class="mb-2 grid grid-cols-6 gap-4">
                    <label for="category_id" class="text-gray-100 text-sm font-semibold pr-2 py-2 col-span-3  lg:col-span-1">Category:</label>
                    <select name="category_id" id="category_id" class="col-span-6 lg:col-span-5  rounded-lg text-sm border @error('category_id')  border-red-500 @enderror" required autofocus>
                        @if($categories->count())
                        @foreach($categories as $key => $categ)
                        <option value="{{$categ->id}}" {{$categ->id == $product->category->id ? 'selected' : ''}}>{{$categ->name_en}}</option>
                        @endforeach
                        @endif
                    </select>
                </div>
                @error('category_id')
                <div class="text-red-500 text-sm">{{$message}}</div>
                @enderror

                <div class="mb-2 grid grid-cols-6 lg:gap-4">
                    <label for="sub_category_id" class="text-gray-100 text-sm font-semibold pr-2 py-2 col-span-3  lg:col-span-1">Sub Category:</label>
                    <select name="sub_category_id" id="sub_category_id" class="test col-span-6 lg:col-span-5  rounded-lg text-sm border @error('sub_category_id')  border-red-500 @enderror" required>
                        <option value="{{$product->sub_category_id}}" selected>{{$product->sub_category->name_en}}</option>
                    </select>
                </div>
                @error('sub_category_id')
                <div class="text-red-500 text-sm">{{$message}}</div>
                @enderror

                <div class="mb-2 grid grid-cols-6 lg:gap-4">
                    <label for="sub_sub_category_id" class="text-gray-100 text-sm font-semibold pr-2 py-2 col-span-3  lg:col-span-1">2Sub Category:</label>
                    <select name="sub_sub_category_id" id="sub_sub_category_id" class="test1 col-span-6 lg:col-span-5  rounded-lg text-sm border @error('sub_sub_category_id')  border-red-500 @enderror" required>
                        <option value="{{$product->sub_sub_category_id}}" selected>{{$product->sub_sub_category->name_en}}</option>
                    </select>
                </div>
                @error('sub_sub_category_id')
                <div class="text-red-500 text-sm">{{$message}}</div>
                @enderror
                <hr class="my-2">

                <div class="mb-2 grid grid-cols-6 lg:gap-4">
                    <label for="code" class="text-gray-100 text-sm font-semibold pr-2 py-2 col-span-3  lg:col-span-1">Code:</label>
                    <input type="text" name="code" id="code" class="col-span-6 lg:col-span-5 rounded-lg text-sm border @error('code')  border-red-500 @enderror" value="{{$product->product_code}}" placeholder="Product Code" required>
                </div>
                @error('code')
                <div class="text-red-500 text-sm">{{$message}}</div>
                @enderror
                <hr class="my-2">
                <div class="mb-2 grid grid-cols-6 lg:gap-4">
                    <p class="col-span-3  lg:col-span-1 font-bold text-gray-100 text-sm py-2 pr-2">Color & Size</p>
                    <div class="col-span-6 lg:col-span-5 flex flex-wrap place-content-between">
                        <span class="mb-2">
                            <label for="product_color_en" class="text-gray-100 text-sm font-semibold pr-2 py-2">Product color english:</label>
                            <div>
                                <input type="text" name="product_color_en" id="product_color_en" class="rounded-lg text-sm border @error('product_color_en')  border-red-500 @enderror w-full" value="{{$product->product_color_en}}" placeholder="Product color english" required data-role="tagsinput">

                                @error('product_color_en')
                                <div class="text-red-500 text-sm">{{$message}}</div>
                                @enderror
                            </div>
                        </span>
                        <span class="mb-2">
                            <label for="product_color_heb" class="text-gray-100 text-sm font-semibold pr-2 py-2">Product color hebrew:</label>
                            <div>
                                <input type="text" name="product_color_heb" id="product_color_heb" class="rounded-lg text-sm border @error('product_color_heb')  border-red-500 @enderror w-full" value="{{$product->product_color_en}}" placeholder="Product color hebrew" required data-role="tagsinput">

                                @error('product_color_heb')
                                <div class="text-red-500 text-sm">{{$message}}</div>
                                @enderror
                            </div>
                        </span>
                        @if ($product->product_size_en)
                        <span class="mb-2">
                            <label for="product_size_en" class="text-gray-100 text-sm font-semibold pr-2 py-2">Product size english:</label>
                            <div>
                                <input type="text" name="product_size_en" id="product_size_en" class="rounded-lg text-sm border @error('product_size_en')  border-red-500 @enderror w-full" value="{{$product->product_size_en}}" placeholder="Product size english" data-role="tagsinput">

                                @error('product_size_en')
                                <div class="text-red-500 text-sm">{{$message}}</div>
                                @enderror
                            </div>
                        </span>
                        @endif
                    </div>
                </div>
                <hr class="my-2">

                <div class="mb-2 grid grid-cols-6 lg:gap-4">
                    <label for="product_tags_heb" class="text-gray-100 text-sm font-semibold pr-2 py-2 col-span-3  lg:col-span-1">Product Tags Hebrew:</label>
                    <div class="col-span-6 lg:col-span-5 tags-default bg-white rounded text-gray-600 px-4 py-6 controls">
                        <input type="text" name="product_tags_heb" id="product_tags_heb" class="rounded-lg text-sm" value="{{$product->product_tags_heb}}" placeholder="Product Tags Hebre" required data-role="tagsinput">
                    </div>
                </div>
                @error('product_tags_heb')
                <div class="text-red-500 text-sm">{{$message}}</div>
                @enderror

                <div class="mb-2 grid grid-cols-6 lg:gap-4">
                    <label for="product_tags_en" class="text-gray-100 text-sm font-semibold pr-2 py-2 col-span-3  lg:col-span-1">Product Tags English:</label>
                    <!--  tags-default -->
                    <div class="col-span-6 lg:col-span-5 bg-white rounded text-gray-600 px-4 py-6 controls">
                        <input type="text" name="product_tags_en" id="product_tags_en" class="rounded-lg text-sm" value="{{$product->product_tags_en}}" placeholder="Product Tags English" required data-role="tagsinput" autofocus>
                    </div>
                </div>
                @error('product_tags_en')
                <div class="text-red-500 text-sm">{{$message}}</div>
                @enderror
                <hr class="my-2">

                <div class="mb-2 grid grid-cols-6 lg:gap-4">
                    <p class="col-span-3  lg:col-span-1 font-bold text-gray-100 text-sm py-2 pr-2">Price</p>
                    <div class="col-span-6 lg:col-span-5 flex flex-wrap place-content-between">
                        <span class="mb-2">
                            <label for="selling_price" class="text-gray-100 text-sm font-semibold pr-2 py-2">Selling Price:</label>
                            <div>
                                <input type="text" name="selling_price" id="selling_price" class="rounded-lg text-sm border @error('price')  border-red-500 @enderror w-full" value="{{$product->selling_price}}" placeholder="Price" required>

                                @error('selling_price')
                                <div class="text-red-500 text-sm">{{$message}}</div>
                                @enderror
                            </div>
                        </span>
                        <span class="mb-2">
                            <label for="discount_price" class="text-gray-100 text-sm font-semibold pr-2 py-2  w-1/2 lg:w-1/6">Discount Price:</label>
                            <div>
                                <input type="text" name="discount_price" id="discount_price" class="w-full rounded-lg text-sm border @error('discount_price')  border-red-500 @enderror" value="{{$product->discount_price}}" placeholder="Discount Price in dollars">

                                @error('discount_price')
                                <div class="text-red-500 text-sm col-span-6">{{$message}}</div>
                                @enderror
                            </div>
                        </span>
                    </div>
                </div>
                <hr class="my-2">

                <div class="mb-2 grid grid-cols-6 lg:gap-4">
                    <label for="short_descp_en" class="text-gray-100 text-sm font-semibold pr-2 py-2 col-span-3  lg:col-span-1">Short Description En:</label>
                    <textarea type="text" name="short_descp_en" id="short_descp_en" class="col-span-6 lg:col-span-5 rounded-lg text-sm border @error('short_descp_en')  border-red-500 @enderror" placeholder="English Short Description" required>{{$product->short_descp_en}}</textarea>
                </div>
                @error('short_descp_en')
                <div class="text-red-500 text-sm">{{$message}}</div>
                @enderror

                <div class="mb-2 grid grid-cols-6 lg:gap-4">
                    <label for="short_descp_heb" class="text-gray-100 text-sm font-semibold pr-2 py-2 col-span-3  lg:col-span-1">Short Description Heb:</label>
                    <textarea name="short_descp_heb" id="short_descp_heb" class="col-span-6 lg:col-span-5 rounded-lg text-sm border @error('short_descp_heb')  border-red-500 @enderror rtl" placeholder="Short Description Heb" required>{{$product->short_descp_heb}}</textarea>
                </div>
                @error('short_descp_heb')
                <div class="text-red-500 text-sm">{{$message}}</div>
                @enderror

                <div class="mb-2 grid grid-cols-6 lg:gap-4">
                    <label for="long_descp_en" class="text-gray-100 text-sm font-semibold pr-2 py-2 col-span-3  lg:col-span-1">Full Description English:</label>
                    <textarea type="text" name="long_descp_en" id="editor" class="col-span-6 lg:col-span-5 rounded-lg text-sm border @error('long_descp_en')  border-red-500 @enderror" required>{{$product->long_descp_en}}</textarea>
                </div>
                @error('long_descp')
                <div class="text-red-500 text-sm">{{$message}}</div>
                @enderror

                <div class="mb-2 grid grid-cols-6 lg:gap-4">
                    <label for="long_descp_heb" class="text-gray-100 text-sm font-semibold pr-2 py-2 col-span-3  lg:col-span-1">Full Description Heb:</label>
                    <textarea name="long_descp_heb" id="long_descp_heb" class="col-span-6 lg:col-span-5 rounded-lg text-sm border @error('long_descp_heb')  border-red-500 @enderror rtl" placeholder="Full description hebrew" required>{{$product->long_descp_heb}}</textarea>
                </div>
                @error('long_descp_heb')
                <div class="text-red-500 text-sm">{{$message}}</div>
                @enderror
                <hr class="my-2">

                <div class="mb-2 lg:grid lg:grid-cols-6 lg:gap-4">
                    <label for="product_qty" class="text-gray-100 text-sm font-semibold pr-2 py-2 lg:col-span-1">Qty:</label>
                    <div class="py-2">
                        <input type="text" name="product_qty" id="product_qty" class="rounded-lg text-sm border @error('product_qty')  border-red-500 @enderror" value="{{$product->product_qty}}" placeholder="Qty" required>
                    </div>
                </div>
                @error('product_qty')
                <div class="text-red-500 text-sm">{{$message}}</div>
                @enderror

                <div class="grid grid-cols-6 lg:gap-4 mt-2">
                    <p class="text-gray-100 text-xs font-semibold col-span-3 lg:col-span-1">Update this product?</p>
                </div>
                <button type="submit" class="bg-purple-600 hover:bg-purple-800 text-gray-100 ml-auto w-full col-span-6 lg:col-span-5  rounded  mt-4 py-2">
                    Save Changes
                </button>
            </form>
        </div>
    </div>
    <div class="lg:grid sm:rounded-l md:rounded-t lg:grid-cols-12 mb-2 bg-gray-800">
        <div class="p-4 mb-2 lg:mb-0 lg:col-span-3">
            <h3 class="font-serif font-semibold text-gray-100 text-sm text-gray-100 leading-tight">
                Edit Product Features
            </h3>
            <p class="text-sm text-gray-300 leading-tight mt-1 mb-2">
                View and update {{ucfirst($product->product_name_en)}}'s Features.
            </p>
        </div>
        <div class="p-4 bg-gray-700 lg:rounded-r  lg:col-span-9">
            <p class="font-semibold text-gray-100 text-sm py-2 pr-2">Features & Status</p>
            <form action="{{route('admin.update.features',$product->id)}}" method="POST" class="flex place-content-between flex-wrap w-full">
                @method('put')
                @csrf
                <span>
                    <input type="checkbox" id="hot_deals" name="hot_deals" value="1" {{$product->hot_deals ? 'checked' : ''}}>
                    <div>
                        <label for="hot_deals" class="text-gray-100 text-sm font-semibold pr-2 py-2">Hot Deals</label>
                    </div>
                </span>
                <span>
                    <input type="checkbox" id="featured" name="featured" value="1" {{$product->featured ? 'checked' : ''}}>
                    <div>
                        <label for="featured" class="text-gray-100 text-sm font-semibold pr-2 py-2">Featured</label>
                    </div>
                </span>
                <span>
                    <input type="checkbox" id="special_offer" name="special_offer" value="1" {{$product->special_offer ? 'checked' : ''}}>
                    <div><label for="special_offer" class="text-gray-100 text-sm font-semibold pr-2 py-2">Special Offer</label></div>
                </span>
                <span>
                    <input type="checkbox" id="checkbox_5" name="special_deals" value="1" {{$product->special_deals ? 'checked' : ''}}>
                    <div>
                        <label for="checkbox_5" class="text-gray-100 text-sm font-semibold pr-2 py-2">Special Deals</label>
                    </div>
                </span>
                <button type="submit" class="bg-purple-600 hover:bg-purple-800 text-gray-100 ml-auto w-full col-span-6 lg:col-span-5  rounded  mt-4 py-2">
                    Save Changes
                </button>
            </form>
        </div>
    </div>



    @endauth
</div>
@endsection
@section('page_footer_scripts')
<script src="{{asset('backend/assets/js/alerts.js')}}"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{asset('backend/assets/js/deleteAlert.js')}}"></script>
<script src="{{asset('backend/assets/js/myMulti.js')}}"></script>

<!-- <script>
    $(function() {
        $('input').on('change', function(event) {

            var $element = $(event.target);
            var $container = $element.closest('.tags-default');

            if (!$element.data('tagsinput'))
                return;

            var val = $element.val();
            if (val === null)
                val = "null";
            var items = $element.tagsinput('items');

            $('code', $('pre.val', $container)).html(($.isArray(val) ? JSON.stringify(val) : "\"" + val.replace('"', '\\"') + "\""));
            $('code', $('pre.items', $container)).html(JSON.stringify($element.tagsinput('items')));


        }).trigger('change');
    });
</script> -->


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