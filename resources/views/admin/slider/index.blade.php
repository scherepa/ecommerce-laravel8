@extends('admin.admin_master')

@section('title', 'All Sliders')

@section('admin')
<div class="p-4 bg-gray-900 md:rounded">
    <div class="p-4 mb-4">
        <h2 class="font-serif font-bold text-xl text-gray-100 leading-tight">
            All Sliders
        </h2>
    </div>
    <div class="p-4 md:rounded bg-gray-800 mb-2">
        <h3 class="font-serif font-semibold text-lg text-gray-100 leading-tight">
            All Sleders Information
        </h3>
        <p class="text-sm text-gray-300 leading-tight mt-1 mb-2">
            Veiw your products's main information, add new slider or delete slider.
        </p>
    </div>
    <!-- table -->
    <div class="flex w-full">
        <div class="w-full md:rounded p-2 bg-gray-700">
            <div class="overflow-x-auto m-2">
                @livewire('admin.slider')
            </div>
        </div>
    </div>
    <x-jet-section-border />
    @auth('admin')
    <div class="p-4 md:rounded bg-gray-800 mb-2">
        <h3 class="font-serif font-semibold text-lg text-gray-100 leading-tight">
            New Slider
        </h3>
        <p class="text-sm text-gray-300 leading-tight mt-1 mb-2">
            Add new Slider.
        </p>
    </div>
    <div class="p-4 md:p-6 lg:py-10 lg:px-12 md:rounded bg-gray-700">
        <form action="{{route('store.slider')}}" method="POST" enctype="multipart/form-data" class="w-full">
            @csrf
            <div class="mb-2 grid grid-cols-6 lg:gap-4">
                <label for="title" class="text-gray-100 text-sm font-semibold pr-2 py-2 col-span-3  lg:col-span-1">Title </label>
                <input type="text" name="title" id="title" class="col-span-6 lg:col-span-5 rounded-lg text-sm" value="{{old('title')}}" placeholder="En Poduct Name" autofocus>
            </div>
            <div class="mb-2 grid grid-cols-6 gap-4">
                <label for="description" class="text-gray-100 text-sm font-semibold pr-2 py-2 col-span-3  lg:col-span-1">Description</label>
                <textarea type="text" name="description" id="description" class="col-span-6 lg:col-span-5 rounded-lg text-sm ">{{old('description')}}</textarea>
            </div>
            <div class="mb-2 grid grid-cols-6 lg:gap-4">
                <p class="col-span-3  lg:col-span-1 font-semibold text-gray-100 text-sm py-2 pr-2">Active in Slider</p>
                <div class="col-span-6 lg:col-span-5">
                    <input type="checkbox" id="status" name="status" value="1">
                    <div>
                        <label for="status" class="text-gray-100 text-sm font-semibold pr-2 py-2">Display in Slider</label>
                    </div>
                </div>
            </div>
            <div class="mb-2 grid grid-cols-6 lg:gap-4">
                <p class="col-span-3  lg:col-span-1 font-semibold text-gray-100 text-sm py-2 pr-2">Images</p>
                <div class="col-span-6 lg:col-span-5">
                    <div class="hidden">
                        <input type="file" name="thumbnail" id="thumbnail" accept="image/*" style="height:0; padding:0;" aria-describedby="thumbnail" required>
                    </div>
                    <div class="text-gray-100 text-sm pr-2 py-2 col-span-3 lg:col-span-1">
                        Upload Slider
                    </div>
                    <label for="thumbnail" role="button" class="mb-2">
                        <div class="py-2 w-full rounded-lg  @error('slider_img') bg-red-600 text-white border-red-500 @else bg-gray-100 text-gray-900 hover:bg-gray-400 @enderror text-center"><i class="fa fa-upload" aria-hidden="true" title="Want to Upload"></i> Slider</div>
                    </label>
                    <div class="text-gray-200 flex rounded mt-1" id="preview"></div>
                    @error('slider_img')
                    <div class="text-red-500 text-sm">{{$message}}</div>
                    @enderror
                </div>
            </div>
            <div class="grid grid-cols-6 lg:gap-4 mt-2">
                <h4 class="text-gray-100 font-bold col-span-3 lg:col-span-1">Upload this slider?</h4>
                <button type=" submit" class="bg-purple-600 hover:bg-purple-800 text-gray-100 ml-auto w-full col-span-6 lg:col-span-5  rounded  mt-4 py-2">
                    Save Slider
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
@endsection