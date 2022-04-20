@extends('admin.admin_master')

@section('title', 'Profile')

@section('page_header_scripts')
@endsection
@section('admin')

<div class="p-4 bg-gray-900 rounded">

    <div class="p-4 mb-4">
        <h2 class="font-serif font-semibold text-xl text-gray-100 leading-tight">
            {{ __('Profile') }}
        </h2>
    </div>

    <div class="p-4 my-4">
        <div class="space-y-6">
            <!-- profile name, email and photo -->
            <div class="lg:grid lg:grid-cols-3 lg:gap-6">
                <div class="lg:col-span-1 flex justify-between">
                    <div class="px-4 sm:px-0">
                        <h3 class="font serif font-semibold text-lg text-gray-100 leading-tight">Profile Information</h3>
                        <p class="text-sm text-gray-300 leading-tight mt-1 mb-2">
                            Update your account's profile information and email address.
                        </p>
                    </div>
                </div>
                <div class="lg:col-span-2 rounded bg-gray-700 p-6">
                    <p class="text-sm font-thin text-gray-100 leading-tight">Photo
                    </p>
                    <div>
                        @if (Laravel\Fortify\Features::canUpdateProfileInformation())
                        <div class="flex justify-between">
                            @if (auth()->user()->profile_photo_path)
                            <div>
                                <span class="block rounded-full w-20 h-20 bg-cover bg-no-repeat bg-center" style="background-image: url('{{Storage::url(auth()->user()->profile_photo_path)}}');">
                                </span>
                            </div>
                            @else
                            <div>
                                <span class="block rounded-full w-20 h-20 bg-gray-200 text-gray-800 text-3xl font-extrabold flex justify-center  items-center">
                                    {{strtoupper($user->name[0].$user->name[1])}}
                                </span>
                            </div>
                            @endif
                            <div class="flex items-center" id='arrow'>
                            </div>
                            <div id="preview-image-before-upload">
                                <span class="block rounded-full w-20 h-20 bg-cover bg-no-repeat bg-center" id="box">
                                </span>
                            </div>
                        </div>

                        <form action="{{route('admin.profile.update')}}" class="my-6 space-y-6" method="POST" enctype="multipart/form-data">
                            @method('PUT')
                            @csrf
                            @if (auth()->user()->profile_photo_path)
                            <input type='checkbox' name='del_photo' id="del_photo" class="hidden">
                            <div id="btn_check" class="rounded bg-red-200 text-red-900 py-2 text-center w-full"><strong>&times;</strong> Photo</div>
                            <div id="uncheck_wrap" class="hidden space-y-4">
                                <div class="text-yellow-900 bg-yellow-200 p-2 rounded  divide-y divide-solid divide-red-400" id="remove_mess">
                                    <p class="text-sm font-bold pb-2"><i class="fa fa-exclamation-circle text-xl mr-2" aria-hidden="true"></i>Your Current Image will be Removed.</p>
                                    <p class="pt-2 text-sm">If you wish to keep your current image press the button below.</p>
                                </div>

                                <div id="btn_uncheck" class="rounded bg-blue-200 text-blue-900 py-2 text-center w-full "> Keep Image
                                </div>
                            </div>
                            @endif
                            <div class="hidden">
                                <input type="file" name="photo" id="photo" accept="image/*" style="height:0; padding:0;" aria-describedby="photo" class="myfile">
                            </div>
                            <div class="flex">
                                <label for="photo" class="rounded bg-gray-200 text-gray-900 py-2 text-center w-full" role="button" aria-label="Upload"><i class="fa fa-upload" aria-hidden="true" title="Want to Upload?"></i> Image
                                </label>
                            </div>
                            @error('photo')
                            <div class="text-red-500 text-sm">{{$message}}</div>
                            @enderror
                            <div class="space-y-4">
                                <input type="text" name="name" id="name" class="outline-none focus:ring focus:ring-gray-300 focus:ring-4 bg-gray-100 p-2 rounded w-full text-gray-900 @error('name') border-4 border-red-300 @enderror" value="{{auth()->user()->name}}" required>
                                @error('name')
                                <div class="text-red-500 text-sm">{{$message}}</div>
                                @enderror
                                <input type="email" name="email" id="email" class="outline-none focus:ring focus:ring-gray-300 bg-gray-100 p-2 rounded w-full text-gray-900 @error('email') border-4 border-red-300 @enderror" value="{{auth()->user()->email}}" required>
                                @error('email')
                                <div class="text-red-500 text-sm">{{$message}}</div>
                                @enderror
                            </div>
                            <div class="flex justify-end pt-6">
                                <button type="submit" class="font-semibold border-2 bg-gray-100 text-indigo-500 border-indigo-500 hover:bg-indigo-500 w-full md:w-3/4 lg:w-1/2 rounded-lg font-medium hover:text-gray-100 p-2 transition ease-in duration-700 ">Save</button>
                            </div>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
            @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
            <div class="lg:grid lg:grid-cols-3 lg:gap-6">
                <div class="lg:col-span-1 flex justify-between">
                    <div class="px-4 sm:px-0">
                        <h3 class="font serif font-semibold text-lg text-gray-100 leading-tight">Update Password</h3>

                        <p class="text-sm text-gray-300 leading-tight mt-1 mb-2">
                            Ensure your account is using a long password to stay secure.
                        </p>
                    </div>
                </div>
                <div class="lg:col-span-2 rounded bg-gray-700 p-6">
                    <form action="{{route('admin.password.update')}}" class="my-6 space-y-4" method="Post">
                        @csrf
                        <input type="password" name="current_password" id="current_password" placeholder="Current Password" class="placeholder-gray-500 bg-gray-100 p-2 rounded w-full placeholder-opacity-75">
                        <input type="password" name="password" id="password" placeholder="New Password" class="placeholder-gray-500 bg-gray-100 p-2 rounded w-full placeholder-opacity-75">
                        <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Confirm Password" class="placeholder-gray-500 bg-gray-100 p-2 rounded w-full placeholder-opacity-75">
                        <div class="flex justify-end pt-6">
                            <button type="submit" class="font-semibold border-2 bg-gray-100 text-indigo-500 border-indigo-500 hover:bg-indigo-500 w-full md:w-3/4 lg:w-1/2 rounded-lg font-medium hover:text-gray-100 p-2 transition ease-in duration-700 ">Save</button>
                        </div>
                    </form>
                </div>
            </div>
            @endif
        </div>

    </div>
</div>
@endsection
@section('page_footer_scripts')
<script src="{{asset('backend/assets/js/myOneImg.js')}}"></script>
<script src="{{asset('backend/assets/js/alerts.js')}}"></script>
<script src="{{asset('backend/assets/js/profilealert.js')}}"></script>
@endsection