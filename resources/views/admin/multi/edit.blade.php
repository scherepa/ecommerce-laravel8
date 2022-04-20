@extends('admin.admin_master')
@section('title', 'All Products')
@section('admin')
<div class="p-4 bg-gray-900 md:rounded">
    @auth('admin')
    <div class="p-4 md:rounded bg-gray-800 mb-2">
        <h3 class="font-serif font-semibold text-lg text-gray-100 leading-tight">
            Edit Image
        </h3>
        <p class="text-sm text-gray-300 leading-tight mt-1 mb-2">
            Update {{ucfirst($product->product_name_en)}}'s Image.
        </p>
        <div class="p-4 md:p-6 lg:py-10 lg:px-12 md:rounded bg-gray-700">
            <div class="mb-2 grid grid-cols-6 lg:gap-4">
                <p class="col-span-3  lg:col-span-1 font-semibold text-gray-100 text-sm py-2 pr-2">Product Image</p>
                <div class="col-span-6 lg:col-span-5">
                    <form action="{{ route('admin.update.prod.image', $prod_image->id) }}" method="POST" enctype="multipart/form-data" class="w-full">
                        @method('put')
                        @csrf
                        <div class="my-1">
                            <div class="text-gray-200 rounded">
                                <div>current</div>
                                <div>
                                    <img class="w-full md:w-1/2 object-contain rounded" src="{{url($prod_image->photo_name)}}" alt="{{$product->product_name_en}} image">
                                </div>
                            </div>
                            <div class="text-gray-200 rounded">
                                <div>new</div>
                                <div id="preview">No new image</div>
                                @error('photo_name')
                                <div class="text-red-500 text-sm">{{$message}}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="hidden">
                            <input type="file" name="photo_name" id="thumbnail" accept="image/*" style="height:0; padding:0;" aria-describedby="photo_name" value="{{$prod_image->photo_name}}">
                        </div>
                        <div class="text-gray-100 text-sm pr-2 py-2 col-span-3 lg:col-span-1">
                            Upload to Replace
                        </div>
                        <label for="thumbnail" role="button" class="mb-2">
                            <div class="py-2 w-full rounded-lg  @error('photo_name') bg-red-600 text-white border-red-500 @else bg-gray-100 text-gray-900 hover:bg-gray-400 @enderror text-center"><i class="fa fa-upload" aria-hidden="true" title="Want to Upload"></i> New Image</div>
                        </label>
                        <button type="submit" class="bg-purple-600 hover:bg-purple-800 text-gray-100 ml-auto w-full col-span-6 lg:col-span-5  rounded  mt-4 py-2">
                            Replace
                        </button>
                    </form>

                </div>
            </div>
        </div>
    </div>
    @endauth
    <form action="{{route('admin.product.edit', $product->id)}}" method="GET" class="px-1 my-2">
        <button type="submit" class="rounded-full bg-blue-400 text-gray-100 px-4">Back to Product
        </button>
    </form>
</div>


@endsection
@section('page_footer_scripts')
<script src="{{asset('backend/assets/js/alerts.js')}}"></script>
<script src="{{asset('backend/assets/js/myMulti.js')}}"></script>
@endsection