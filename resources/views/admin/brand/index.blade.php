@extends('admin.admin_master')

@section('title', 'All Brands')

@section('page_header_scripts')
@endsection
@section('admin')
<div class="p-4 bg-gray-900 md:rounded">
    <div class="p-4 mb-4">
        <h2 class="font-serif font-bold text-xl text-gray-100 leading-tight">
            All Brands
        </h2>
    </div>
    <div class="p-4 md:rounded bg-gray-800 mb-2">
        <h3 class="font-serif font-semibold text-lg text-gray-100 leading-tight">
            All Brands Information
        </h3>
        <p class="text-sm text-gray-300 leading-tight mt-1 mb-2">
            Update your brand's information, add new or delete.
        </p>
    </div>
    <!-- table -->
    <div class="flex w-full">
        <div class="w-full md:rounded p-2 bg-gray-700">
            <div class="overflow-x-auto m-2">
                <table class="table-auto w-full text-sm">
                    <thead>
                        <tr>
                            <th class="rounded-lg p-2 bg-gray-800 text-gray-100 border-2 border-gray-700 text-center" scope="col">
                                #
                            </th>
                            <th class="rounded-lg p-2 bg-gray-800 text-gray-100 border-2 border-gray-700 text-center" scope="col">
                                Name en
                            </th>
                            <th class="rounded-lg p-2 bg-gray-800 text-gray-100 border-2 border-gray-700 text-center" scope="col">
                                Name heb
                            </th>
                            <th class="rounded-lg p-2 bg-gray-800 text-gray-100 border-2 border-gray-700 text-center" scope="col">
                                Image
                            </th>
                            <th class="rounded-lg p-2 bg-gray-800 text-gray-100 border-2 border-gray-700 text-center" scope="col">
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($brands->count())
                        @foreach($brands as $key => $brand)
                        <tr class="font-light">
                            <td class="rounded-lg p-2 bg-gray-800 text-gray-100 border-2 border-gray-700 text-center" scope="row">
                                {{--$brands->firstItem()--}}
                                {{$key + 1}}
                            </td>
                            <td class="rounded-lg p-2 bg-gray-800 text-gray-100 border-2 border-gray-700 text-center">
                                {{$brand->name_en}}
                            </td>
                            <td class="rounded-lg p-2 bg-gray-800 text-gray-100 border-2 border-gray-700 text-center ">
                                {{$brand->name_heb}}
                            </td>
                            <td class="rounded-lg p-2 bg-gray-800 text-gray-100 border-2 border-gray-700">
                                <img src=" {{asset($brand->image)}}" alt="{{$brand->name_en}}" class="mx-auto h-20 object-contain">
                            </td>
                            <td class="rounded-lg bg-gray-800 border-2 border-gray-700">
                                <div class="flex justify-around content-center flex-wrap">
                                    @auth('admin')
                                    <form action="{{route('admin.brand.edit', $brand->id)}}" method="GET">
                                        <button type="submit" class="rounded-full bg-blue-400 text-gray-100 px-4 m-2"><i class="fa fa-pencil-square-o" aria-hidden="true" title="Edit" alt="Edit"></i>
                                        </button>
                                    </form>
                                    <form action="{{route('admin.brand.delete', $brand->id)}}" method="POST" class="mr-1">
                                        <!-- protection with hidden token -->
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-4 rounded-full bg-red-500 text-white m-2 js-submit-confirm"><i class="fa fa-trash-o" aria-hidden="true" title="Delete" alt="Delete"></i>
                                        </button>
                                    </form>
                                    @endauth
                                </div>
                            </td>
                        </tr>
                        @endforeach
                        @endif
                    </tbody>
                </table>
                {{$brands->links()}}
            </div>
        </div>
    </div>
    <x-jet-section-border />
    @auth('admin')
    <div class="p-4 md:rounded bg-gray-800 mb-2">
        <h3 class="font-serif font-semibold text-lg text-gray-100 leading-tight">
            New Brand
        </h3>
        <p class="text-sm text-gray-300 leading-tight mt-1 mb-2">
            Add new brand.
        </p>
    </div>
    <div class="p-4 md:rounded bg-gray-700">
        <form action="{{ route('store.brand') }}" method="POST" enctype="multipart/form-data" class="w-full">
            @csrf
            <div class="mb-2 grid grid-cols-6 lg:gap-4">
                <label for="name_en" class="text-gray-100 text-sm font-semibold pr-2 py-2 col-span-3  lg:col-span-1">English name:</label>
                <input type="text" name="name_en" id="name_en" class="col-span-6 lg:col-span-5 rounded-lg text-sm border @error('name_en')  border-red-500 @enderror" value="{{old('name_en')}}" placeholder="En Brand Name" required>
            </div>
            @error('name_en')
            <div class="text-red-500 text-sm">{{$message}}</div>
            @enderror
            <div class="mb-2 grid grid-cols-6 lg:gap-4">
                <label for="name_heb" class="text-gray-100 text-sm font-semibold pr-2 py-2 col-span-3 lg:col-span-1">Hebrew name:</label>
                <input type="text" name="name_heb" id="name_heb" class="col-span-6 lg:col-span-5 rounded-lg text-sm border @error('name_heb')  border-red-500 @enderror rtl" value="{{old('name_heb')}}" placeholder="שם המותג" required>
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
            <br>
            <hr>
            <div class="mt-2" style="height:250px;display:none;" id="preview-image-before-upload">
                <div class="my-2 text-gray-200">Uploaded Image</div>
                <img alt="preview image" style="height:80%; object-fit:scale-down;" id="preview">
            </div>
            @error('image')
            <div class="text-red-500 text-sm">{{$message}}</div>
            @enderror

            <button type="submit" class="bg-purple-600 hover:bg-purple-800 text-gray-100 w-full  rounded  mt-4 py-2">
                Add Brand
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
<script src="{{asset('backend/assets/js/deleteAlertReg.js')}}"></script>
@endsection