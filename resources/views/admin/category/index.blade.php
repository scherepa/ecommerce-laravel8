@extends('admin.admin_master')

@section('title', 'All Categories')

@section('page_header_scripts')
@endsection
@section('admin')
<div class="p-4 bg-gray-900 md:rounded">
    <div class="p-4 mb-4">
        <h2 class="font-serif font-bold text-xl text-gray-100 leading-tight">
            All Categories
        </h2>
    </div>
    <div class="p-4 md:rounded bg-gray-800 mb-2">
        <h3 class="font-serif font-semibold text-lg text-gray-100 leading-tight">
            All Categories Information
        </h3>
        <p class="text-sm text-gray-300 leading-tight mt-1 mb-2">
            Review and update each category's information, add new category or delete.
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
                                Icon
                            </th>
                            <th class="rounded-lg p-2 bg-gray-800 text-gray-100 border-2 border-gray-700 text-center" scope="col">
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($categories->count())
                        @foreach($categories as $key => $cat)
                        <tr class="font-light">
                            <td class="rounded-lg p-2 bg-gray-800 text-gray-100 border-2 border-gray-700 text-center" scope="row">
                                {{--$categories->firstItem()--}}
                                {{$key + 1}}
                            </td>
                            <td class="rounded-lg p-2 bg-gray-800 text-gray-100 border-2 border-gray-700 text-center">
                                {{$cat->name_en}}
                            </td>
                            <td class="rounded-lg p-2 bg-gray-800 text-gray-100 border-2 border-gray-700 text-center ">
                                {{$cat->name_heb}}
                            </td>
                            <td class="rounded-lg p-2 bg-gray-800 text-gray-100 border-2 border-gray-700 text-center">
                                @if(!str_contains($cat->icon, 'fa fa-'))
                                <span class="material-icons">
                                    {{$cat->icon}}
                                </span>
                                @else
                                <i class="{{$cat->icon}} text-gray-100 text-lg" aria-hidden="true"></i>
                                @endif
                            </td>
                            <td class="rounded-lg bg-gray-800 border-2 border-gray-700">
                                <div class="flex justify-around content-center flex-wrap">
                                    @auth('admin')
                                    <form action="{{route('admin.category.edit', $cat->id)}}" method="GET">
                                        <button type="submit" class="rounded-full bg-blue-400 text-gray-100 px-4 m-2"><i class="fa fa-pencil-square-o" aria-hidden="true" title="Edit" alt="Edit"></i>
                                        </button>
                                    </form>
                                    <form action="{{route('admin.category.delete', $cat->id)}}" method="POST" class="mr-1">
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
            </div>
        </div>
    </div>
    <x-jet-section-border />
    @auth('admin')
    <div class="p-4 md:rounded bg-gray-800 mb-2">
        <h3 class="font-serif font-semibold text-lg text-gray-100 leading-tight">
            New Category
        </h3>
        <p class="text-sm text-gray-300 leading-tight mt-1 mb-2">
            Add new category to the categories.
        </p>
    </div>
    <div class="p-4 md:rounded bg-gray-700">
        <form action="{{ route('store.category') }}" method="POST" class="w-full">
            @csrf
            <div class="mb-2 grid grid-cols-6 lg:gap-4">
                <label for="name_en" class="text-gray-100 text-sm font-semibold pr-2 py-2 col-span-3  lg:col-span-1">English name:</label>
                <input type="text" name="name_en" id="name_en" class="col-span-6 lg:col-span-5 rounded-lg text-sm border @error('name_en')  border-red-500 @enderror" value="{{old('name_en')}}" placeholder="En Category Name" required>
            </div>
            @error('name_en')
            <div class="text-red-500 text-sm">{{$message}}</div>
            @enderror
            <div class="mb-2 grid grid-cols-6 lg:gap-4">
                <label for="name_heb" class="text-gray-100 text-sm font-semibold pr-2 py-2 col-span-3 lg:col-span-1">Hebrew name:</label>
                <input type="text" name="name_heb" id="name_heb" class="col-span-6 lg:col-span-5 rounded-lg text-sm border @error('name_heb')  border-red-500 @enderror rtl" value="{{old('name_heb')}}" placeholder="שם קטגוריה" required>
            </div>
            @error('name_heb')
            <div class="text-red-500 text-sm">{{$message}}</div>
            @enderror
            <p class="text-xs font-thin text-blue-200">
                <span class="material-icons mr-2">
                    warning
                </span> For font awsome 4.7 icon fill in class name like: fa fa-user <br>For google icons fill in name like: face
            </p>
            <div class="mb-2 grid grid-cols-6 lg:gap-4">
                <label for=" icon" class="text-gray-100 text-sm font-semibold pr-2 py-2 col-span-3  lg:col-span-1">Category Icon:</label>
                <input type="text" name="icon" id="icon" class="col-span-6 lg:col-span-5  rounded-lg text-sm border @error('name_heb')  border-red-500 @enderror" value="{{old('icon')}}" placeholder="fa fa-user" required>
            </div>
            @error('icon')
            <div class="text-red-500 text-sm">{{$message}}</div>
            @enderror

            <button type="submit" class="bg-purple-600 hover:bg-purple-800 text-gray-100 w-full  rounded  mt-4 py-2">
                Add Category
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