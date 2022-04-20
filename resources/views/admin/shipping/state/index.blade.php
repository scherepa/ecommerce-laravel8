@extends('admin.admin_master')

@section('title', 'All States')
@section('page_styles')
<style type="text/css">
    input {
        outline: none;
    }
</style>

@section('admin')
<div class="p-4 bg-gray-900 md:rounded">
    <div class="p-4 mb-4">
        <h2 class="font-serif font-bold text-xl text-gray-100 leading-tight">
            All States
        </h2>
    </div>
    <div class="p-4 md:rounded bg-gray-800 mb-2">
        <h3 class="font-serif font-semibold text-lg text-gray-100 leading-tight">
            All Shipping Area States Information
        </h3>
        <p class="text-sm text-gray-300 leading-tight mt-1 mb-2">
            Veiw and Manage All States.
        </p>
    </div>
    <!-- table -->
    <div class="flex w-full">
        <div class="w-full md:rounded p-2 bg-gray-700">
            <div class="overflow-x-auto m-2">
                <div>
                    <table class="w-full text-sm">
                        <thead>
                            <tr>
                                <th class="rounded-lg p-2 bg-gray-800 text-gray-100 border-2 border-gray-700 text-center" scope="col">
                                    #
                                </th>
                                <th class="rounded-lg p-2 bg-gray-800 text-gray-100 border-2 border-gray-700 text-center whitespace-nowrap" scope="col">
                                    Name
                                </th>
                                <th class="rounded-lg p-2 bg-gray-800 text-gray-100 border-2 border-gray-700 text-center whitespace-nowrap" scope="col">
                                    District
                                </th>
                                <th class="rounded-lg p-2 bg-gray-800 text-gray-100 border-2 border-gray-700 text-center whitespace-nowrap" scope="col">
                                    Division
                                </th>
                                <th class="rounded-lg p-2 bg-gray-800 text-gray-100 border-2 border-gray-700 text-center" scope="col">
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($states->count())
                            @foreach($states as $key => $item)
                            <tr class="font-light">
                                <td class="rounded-lg p-2 bg-gray-800 text-gray-100 border-2 border-gray-700 text-center" scope="row">
                                    {{$key + 1}}
                                </td>
                                <td class="rounded-lg p-2 bg-gray-800 text-gray-100 border-2 border-gray-700 text-center ">
                                    {{$item->name}}
                                </td>
                                <td class="rounded-lg p-2 bg-gray-800 text-gray-100 border-2 border-gray-700 text-center ">
                                    {{$item->district->name}}
                                </td>
                                <td class="rounded-lg p-2 bg-gray-800 text-gray-100 border-2 border-gray-700 text-center ">
                                    {{$item->division->name}}
                                </td>
                                <td class="rounded-lg bg-gray-800 border-2 border-gray-700">
                                    <div class="flex justify-around content-center">
                                        @auth('admin')
                                        <form action="{{route('admin.shipping.state.edit', $item->id)}}" method="GET" class="px-1 my-2">
                                            <button type="submit" class="rounded-full bg-blue-400 text-gray-100 px-4"><i class="fa fa-pencil-square-o" aria-hidden="true" title="View&Edit" alt="View&Edit"></i>
                                            </button>
                                        </form>
                                        <form action="{{route('admin.shipping.state.delete', $item->id)}}" method="POST" class="px-1 my-2">
                                            @method('DELETE')
                                            @csrf
                                            <button class="px-4 rounded-full bg-red-500 text-white js-submit-confirm"><i class="fa fa-trash-o" aria-hidden="true" title="Delete" alt="Delete"></i>
                                            </button>
                                        </form>
                                        @endauth
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td colspan="5" class="font-bold text-center text-gray-100">
                                    <div>Wh..ops <br> There are no states yet...</div>
                                </td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <x-jet-section-border />
    @auth('admin')
    <div class="p-4 md:rounded bg-gray-800 mb-2">
        <h3 class="font-serif font-semibold text-lg text-gray-100 leading-tight">
            New State
        </h3>
        <p class="text-sm text-gray-300 leading-tight mt-1 mb-2">
            Add new Shipping Area State/Province.
        </p>
    </div>
    <div class="p-4 md:p-6 lg:py-10 lg:px-12 md:rounded bg-gray-700">
        <form action="{{route('admin.store.shipping.state')}}" method="POST" class="w-full">
            @csrf
            <div class="mb-2 grid grid-cols-6 lg:gap-4">
                <label for="name" class="text-gray-100 text-sm font-semibold pr-2 py-2 col-span-3  lg:col-span-2">State name<span class="text-red-500 text-xs">*</span>:</label>
                <input type="text" name="name" id="name" class="col-span-6 lg:col-span-4 rounded-lg text-sm border @error('name')  border-red-500 @enderror" value="{{old('name')}}" placeholder="state name" required autofocus>
            </div>
            @error('name')
            <div class="text-red-500 text-sm">{{$message}}</div>
            @enderror
            <div class="mb-2 grid grid-cols-6 lg:gap-4">
                <label for="division" class="text-gray-100 text-sm font-semibold pr-2 py-2 col-span-3  lg:col-span-2">Choose division<span class="text-red-500 text-xs">*</span>:</label>
                <select type="text" name="division" id="division" class="col-span-6 lg:col-span-4 rounded-lg text-sm border @error('division')  border-red-500 @enderror" required autofocus>
                    @if($divisions->count())
                    <option value="" selected disabled>--Choose division--</option>
                    @foreach($divisions as $key => $item)
                    <option value="{{$item->id}}">{{$item->name}}</option>
                    @endforeach
                    @endif
                </select>
            </div>
            @error('division')
            <div class="text-red-500 text-sm">{{$message}}</div>
            @enderror
            <div class="mb-2 grid grid-cols-6 lg:gap-4">
                <label for="district" class="text-gray-100 text-sm font-semibold pr-2 py-2 col-span-3  lg:col-span-2">Choose district<span class="text-red-500 text-xs">*</span>:</label>
                <select type="text" name="district" id="district" class="test col-span-6 lg:col-span-4 rounded-lg text-sm border @error('district')  border-red-500 @enderror" required autofocus>
                    <option value="" selected disabled>--Select District--</option>
                </select>
            </div>
            @error('district')
            <div class="text-red-500 text-sm">{{$message}}</div>
            @enderror
            <div class="grid grid-cols-6 lg:gap-4 mt-2">
                <h4 class="text-gray-100 text-sm font-bold col-span-3 lg:col-span-2">Upload this State?</h4>
                <button type="submit" class="bg-purple-600 hover:bg-purple-800 text-gray-100 ml-auto w-full col-span-6 lg:col-span-4  rounded  mt-4 py-2 text-sm font-bold">
                    Save State
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
<script>
    $(document).ready(function() {
        $('select[name="division"]').on('change', function() {
            let id = $(this).val();
            if (id) {
                $.ajax({
                    url: "{{ url('/admin/shipping/district/ajax') }}/" + id,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        //console.log(data);
                        $('select[name="district"]').empty();
                        $('select[name="district"]').append('<option value="" selected disabled>--Select District--</option>');
                        $.each(data, function(key, value) {
                            $('select[name="district"]').append('<option value="' + value.id + '">' + value.name + '</option>');
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