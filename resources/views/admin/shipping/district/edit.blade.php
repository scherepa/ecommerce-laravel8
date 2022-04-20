@extends('admin.admin_master')

@section('title', 'Edit District')
@section('page_styles')
<style type="text/css">
    input {
        outline: none;
    }
</style>

@section('admin')
<div class="p-4 bg-gray-900 md:rounded">
    @auth('admin')
    <div class="p-4 md:rounded bg-gray-800 mb-2">
        <h3 class="font-serif font-semibold text-lg text-gray-100 leading-tight">
            Edit District
        </h3>
        <p class="text-sm text-gray-300 leading-tight mt-1 mb-2">
            Edit {{strtoupper($district->name)}} District.
        </p>
    </div>
    <div class="p-4 md:p-6 lg:py-10 lg:px-12 md:rounded bg-gray-700">
        <form action="{{route('admin.shipping.district.update', $district->id)}}" method="POST" class="w-full">
            @method('PUT')
            @csrf
            <div class="mb-2 grid grid-cols-6 lg:gap-4">
                <label for="name" class="text-gray-100 text-sm font-semibold pr-2 py-2 col-span-3  lg:col-span-2">District name<span class="text-red-500 text-xs">*</span>:</label>
                <input type="text" name="name" id="name" class="col-span-6 lg:col-span-4 rounded-lg text-sm border @error('name')  border-red-500 @enderror" value="{{$district->name}}" required autofocus>
            </div>
            @error('name')
            <div class="text-red-500 text-sm">{{$message}}</div>
            @enderror
            <div class="mb-2 grid grid-cols-6 lg:gap-4">
                <label for="division" class="text-gray-100 text-sm font-semibold pr-2 py-2 col-span-3  lg:col-span-2">Choose division<span class="text-red-500 text-xs">*</span>:</label>
                <select type="text" name="division" id="division" class="col-span-6 lg:col-span-4 rounded-lg text-sm border @error('division')  border-red-500 @enderror" required>
                    <option value="{{$district->division_id}}" selected>{{$district->division->name}}</option>
                    @if($divisions->count())
                    <option value="" disabled>--Change division--</option>
                    @foreach($divisions as $key => $item)
                    <option value="{{$item->id}}">{{$item->name}}</option>
                    @endforeach
                    @endif
                </select>
            </div>
            @error('division')
            <div class="text-red-500 text-sm">{{$message}}</div>
            @enderror

            <div class="grid grid-cols-6 lg:gap-4 mt-2">
                <h4 class="text-gray-100 text-sm font-bold col-span-3 lg:col-span-2">Upload this District?</h4>
                <button type="submit" class="bg-purple-600 hover:bg-purple-800 text-gray-100 ml-auto w-full col-span-6 lg:col-span-4  rounded  mt-4 py-2 text-sm font-bold">
                    Save Changes
                </button>
            </div>
        </form>
        <div class="flex md:justify-start">
            <a href="{{route('admin.show.shipping.district')}}"><span class="bg-blue-600 hover:bg-blue-800 text-gray-100 ml-auto w-full md:w-1/3  rounded-lg  mt-4 py-2 px-3 text-sm font-bold">all districts</span></a>
        </div>
    </div>
    @endauth
</div>
@endsection
@section('page_footer_scripts')
<script src="{{asset('backend/assets/js/alerts.js')}}"></script>
@endsection