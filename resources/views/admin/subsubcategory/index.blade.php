@extends('admin.admin_master')

@section('title', 'All 2Sub Categories')

@section('page_header_scripts')
@endsection
@section('admin')
<div class="p-4 bg-gray-900 md:rounded">
    <div class="p-4 mb-4">
        <h2 class="font-serif font-bold text-xl text-gray-100 leading-tight">
            All Sub Sub Categories
        </h2>
    </div>
    <div class="p-4 md:rounded bg-gray-800 mb-2">
        <h3 class="font-serif font-semibold text-lg text-gray-100 leading-tight">
            All Sub Sub Categories Information
        </h3>
        <p class="text-sm text-gray-300 leading-tight mt-1 mb-2">
            Review and update each sub sub category's information, add new sub sub category or delete.
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
                                Name heb
                            </th>
                            <th class="rounded-lg p-2 bg-gray-800 text-gray-100 border-2 border-gray-700 text-center" scope="col">
                                Name en
                            </th>
                            <th class="rounded-lg p-2 bg-gray-800 text-gray-100 border-2 border-gray-700 text-center" scope="col">
                                Category
                            </th>
                            <th class="rounded-lg p-2 bg-gray-800 text-gray-100 border-2 border-gray-700 text-center" scope="col">
                                Sub Category
                            </th>
                            <th class="rounded-lg p-2 bg-gray-800 text-gray-100 border-2 border-gray-700 text-center" scope="col">
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($subsubcategories->count())
                        @foreach($subsubcategories as $key => $cat)
                        <tr class="font-light">
                            <td class="rounded-lg p-2 bg-gray-800 text-gray-100 border-2 border-gray-700 text-center" scope="row">
                                {{--$categories->firstItem()--}}
                                {{$key + 1}}
                            </td>
                            <td class="rounded-lg p-2 bg-gray-800 text-gray-100 border-2 border-gray-700 text-center ">
                                {{$cat->name_heb}}
                            </td>
                            <td class="rounded-lg p-2 bg-gray-800 text-gray-100 border-2 border-gray-700 text-center">
                                {{$cat->name_en}}
                            </td>
                            <td class="rounded-lg p-2 bg-gray-800 text-gray-100 border-2 border-gray-700 text-center">
                                {{$cat->category->name_en}}
                            </td>
                            <td class="rounded-lg p-2 bg-gray-800 text-gray-100 border-2 border-gray-700 text-center">
                                {{$cat->subcategory->name_en}}
                            </td>
                            <td class="rounded-lg bg-gray-800 border-2 border-gray-700">
                                <div class="flex justify-around content-center flex-wrap">
                                    @auth('admin')
                                    <form action="{{route('admin.subsubcategory.edit', $cat->id)}}" method="GET">
                                        <button type="submit" class="rounded-full bg-blue-400 text-gray-100 px-4 m-2"><i class="fa fa-pencil-square-o" aria-hidden="true" title="Edit" alt="Edit"></i>
                                        </button>
                                    </form>
                                    <form action="{{route('admin.subsubcategory.delete', $cat->id)}}" method="POST" class="mr-1">
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
            New Sub Sub Category
        </h3>
        <p class="text-sm text-gray-300 leading-tight mt-1 mb-2">
            Add new sub sub category to one of the sub categories.
        </p>
    </div>
    <div class="p-4 md:rounded bg-gray-700">
        <form action="{{ route('store.subsubcategory') }}" method="POST" class="w-full">
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
            <div class="mb-2 grid grid-cols-6 lg:gap-4">
                <label for="category_id" class="text-gray-100 text-sm font-semibold pr-2 py-2 col-span-3  lg:col-span-1">Category:</label>
                <select name="category_id" id="category_id" class="col-span-6 lg:col-span-5  rounded-lg text-sm border @error('category_id')  border-red-500 @enderror" required>
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
                <label for="sub_category_id" class="text-gray-100 text-sm font-semibold pr-2 py-2 col-span-3  lg:col-span-1">Sub Category:</label>
                <select name="sub_category_id" id="sub_category_id" class="test col-span-6 lg:col-span-5  rounded-lg text-sm border @error('sub_category_id')  border-red-500 @enderror" required>
                    <option value="" disabled selected>Select Sub Category</option>
                </select>
            </div>
            @error('sub_category_id')
            <div class="text-red-500 text-sm">{{$message}}</div>
            @enderror
            <button type="submit" class="bg-purple-600 hover:bg-purple-800 text-gray-100 w-full  rounded  mt-4 py-2">
                Add 2Sub Category
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

<script>
    $(document).ready(function() {
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
                        $.each(data, function(key, value) {
                            $('.test').append('<option value="' + value.id + '">' + value.name_en + '</option>');
                            /* $('select[name="sub_category_id"]').append('<option value="' + value.id + '">' + value.name_en + '</option>'); */
                        });
                    },
                });
            } else {
                alert('danger');
            }
        });
    });
</script>
@endsection