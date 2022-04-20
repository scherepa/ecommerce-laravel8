@extends('admin.admin_master')

@section('title', 'Edit Brand')

@section('page_header_scripts')
@endsection
@section('admin')
<div class="p-4 bg-gray-900 md:rounded">
    @auth('admin')
    <div class="p-4 md:rounded bg-gray-800 mb-2">
        <h2 class="font-serif font-semibold text-lg text-gray-100 leading-tight">
            Edit Brand
        </h2>
        <p class="text-sm text-gray-300 leading-tight mt-1 mb-2">
            Update {{ $brand->name_en }} information.
        </p>
    </div>
    <div class="p-4 md:rounded bg-gray-700">
        <div class="mb-2"><img src=" {{asset($brand->image)}}" alt="{{$brand->name_en}}" class="mx-auto h-20 object-contain"></div>
        <form action="{{route('admin.brand.update',$brand->id)}}" method="POST" enctype="multipart/form-data" class="w-full">
            @method('put')
            @csrf
            <div class="mb-2 grid grid-cols-6 lg:gap-4">
                <label for="name_en" class="text-gray-100 text-sm font-semibold pr-2 py-2 col-span-3  lg:col-span-1">English name:</label>
                <input type="text" name="name_en" id="name_en" class="col-span-6 lg:col-span-5 rounded-lg text-sm border @error('name_en')  border-red-500 @enderror" value="{{$brand->name_en}}" placeholder="En Brand Name" required>
            </div>
            @error('name_en')
            <div class="text-red-500 text-sm">{{$message}}</div>
            @enderror
            <div class="mb-2 grid grid-cols-6 lg:gap-4">
                <label for="name_heb" class="text-gray-100 text-sm font-semibold pr-2 py-2 col-span-3 lg:col-span-1">Hebrew name:</label>
                <input type="text" name="name_heb" id="name_heb" class="col-span-6 lg:col-span-5 rounded-lg text-sm border @error('name_heb')  border-red-500 @enderror rtl" value="{{$brand->name_heb}}" placeholder="שם המותג" required>
            </div>
            @error('name_heb')
            <div class="text-red-500 text-sm">{{$message}}</div>
            @enderror
            <div class="mb-2 grid grid-cols-6 lg:gap-4">
                <div class="hidden">
                    <input type="file" name="image" id="image" accept="image/*" style="height:0; padding:0;" aria-describedby="image">
                </div>
                <div class="text-gray-100 text-sm font-semibold pr-2 py-2 col-span-3 lg:col-span-1">Upload Image</div>

                <label for="image" role="button" aria-label="Upload" class="col-span-6 lg:col-span-5">
                    <div class="py-2 w-full rounded-lg  @error('image') bg-red-600 text-white border-red-500 @else bg-gray-100 text-gray-900 hover:bg-gray-400 @enderror text-center"><i class="fa fa-upload" aria-hidden="true" title="Want to Upload"></i> Brand Image</div>
                </label>
            </div>
            <div class="mt-2" style="display:none;" id="preview-image-before-upload">
                <div class="my-2 text-gray-200">Uploaded Image</div>
                <img alt="preview image" class="mx-auto h-20 object-contain" id="preview" />
            </div>
            @error('image')
            <div class="text-red-500 text-sm">{{$message}}</div>
            @enderror
            <button type="submit" class="bg-purple-600 hover:bg-purple-800 text-gray-100 w-full  rounded  mt-4 py-2">
                Save Changes
            </button>
        </form>
    </div>
    @endauth
    <x-jet-section-border />
</div>
@endsection
@section('page_footer_scripts')
<script src="{{asset('backend/assets/js/brandimg.js')}}"></script>
<script src="{{asset('backend/assets/js/alerts.js')}}"></script>
@endsection