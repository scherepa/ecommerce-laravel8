@extends('admin.admin_master')

@section('title', 'All Categories')

@section('page_header_scripts')
@endsection
@section('admin')
<div class="p-4 bg-gray-900 md:rounded">
    <div class="p-4 mb-4">
        <h2 class="font-serif font-bold text-xl text-gray-100 leading-tight">
            Update Category
        </h2>
    </div>
    <div class="p-4 md:rounded bg-gray-800 mb-2">
        <h3 class="font-serif font-semibold text-lg text-gray-100 leading-tight">
            {{ucfirst($category->name_en)}} Category Information
        </h3>
        <p class="text-sm text-gray-300 leading-tight mt-1 mb-2">
            Review and update {{ucfirst($category->name_en)}} category information.
        </p>
    </div>
    @auth('admin')
    <div class="p-4 md:rounded bg-gray-700">
        <form action="{{ route('admin.category.update', $category->id) }}" method="POST" class="w-full">
            @method('put')
            @csrf
            <div class="mb-2 grid grid-cols-6 lg:gap-4">
                <label for="name_en" class="text-gray-100 text-sm font-semibold pr-2 py-2 col-span-3  lg:col-span-1">English name:</label>
                <input type="text" name="name_en" id="name_en" class="col-span-6 lg:col-span-5 rounded-lg text-sm border @error('name_en')  border-red-500 @enderror" value="{{$category->name_en}}" placeholder="En Category Name" required>
            </div>
            @error('name_en')
            <div class="text-red-500 text-sm">{{$message}}</div>
            @enderror
            <div class="mb-2 grid grid-cols-6 lg:gap-4">
                <label for="name_heb" class="text-gray-100 text-sm font-semibold pr-2 py-2 col-span-3 lg:col-span-1">Hebrew name:</label>
                <input type="text" name="name_heb" id="name_heb" class="col-span-6 lg:col-span-5 rounded-lg text-sm border @error('name_heb')  border-red-500 @enderror rtl" value="{{$category->name_heb}}" placeholder="שם קטגוריה" required>
            </div>
            @error('name_heb')
            <div class="text-red-500 text-sm">{{$message}}</div>
            @enderror
            <div class="mb-2 grid grid-cols-6 lg:gap-4">
                <label for=" icon" class="text-gray-100 text-sm font-semibold pr-2 py-2 col-span-3  lg:col-span-1">Category Icon:</label>
                <input type="text" name="icon" id="icon" class="col-span-6 lg:col-span-5  rounded-lg text-sm border @error('icon')  border-red-500 @enderror" value="{{$category->icon}}" placeholder="fa fa-user" required>
            </div>
            @error('icon')
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
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{asset('backend/assets/js/deleteAlert.js')}}"></script>
@endsection