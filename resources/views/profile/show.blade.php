@extends('layouts.fronted.master')
@section('title', 'Profile')
@section('page_header_scripts')
@endsection
@section('content')

<div class="p-4 bg-gray-900 rounded">

    <div class="py-4 mb-4">
        <h2 class="font-serif font-semibold text-xl text-gray-100 leading-tight">
            Profile
        </h2>
    </div>

    @if(session('success') || session('fail'))
    @php($status = session('success') ? 'success' : 'fail')
    <div class="myAlert hidden fixed top-20">
        <div class="{{$status == 'success' ? 'text-green-200 bg-green-600 my-4 p-2 md:p-4 rounded flex justify-between items-center' : 'text-red-200 bg-red-500 my-4 rounded p-2 md:p-4 flex justify-between items-center'}}">
            <span class="{{$status == 'success' ? 'material-icons self-center mr-2' : 'material-icons-round self-center mr-2'}}">
                @if($status == 'success')
                check_circle
                @else
                error
                @endif
            </span>
            <div class="divide-y divide-solid divide-green-200 flex-grow">
                <h3 class="pb-3 font-serif">

                    @if($status == 'success')
                    Success!
                    @else
                    Sorry!
                    @endif

                </h3>
                <p class="pt-3">{{session($status)}}</p>
            </div>
            <strong class="text-xl cursor-pointer del-alert text-white self-start px-2">&times;</strong>
        </div>
    </div>
    @endif



    <!-- profile name, email and photo -->
    <div class="mt-5 md:grid md:grid-cols-3 md:gap-6">
        <div class="md:col-span-1 flex justify-between">
            <div class="px-4 sm:px-0">
                <h3 class="font serif font-semibold text-lg text-gray-100 leading-tight">Profile Information</h3>
                <p class="text-sm text-gray-300 leading-tight mt-1 mb-2">
                    Update your account's profile information and email address.
                </p>
            </div>
        </div>
        <div class="md:col-span-2 sm:rounded-lg bg-gray-700 px-4">
            <p class="text-sm font-thin text-gray-100 leading-tight py-4">Photo
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

                <form action="{{route('user.profile.update')}}" class="my-6 space-y-4" method="POST" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <div class="space-y-4 px-4 flex flex-col">
                        @if (auth()->user()->profile_photo_path)
                        <input type='checkbox' name='del_photo' id="del_photo" class="hidden">
                        <div id="btn_check" class="rounded-lg bg-red-200 text-red-900 py-2 text-center w-full  text-sm font-bold">&times; Photo</div>
                        <div id="uncheck_wrap" class="hidden space-y-4">
                            <div class="text-yellow-900 bg-yellow-200 p-2 rounded-lg  divide-y divide-solid divide-red-400" id="remove_mess">
                                <p class="text-sm font-bold pb-2"><i class="fa fa-exclamation-circle text-xl mr-2" aria-hidden="true"></i>Your Current Image will be Removed.</p>
                                <p class="pt-2 text-sm">If you wish to keep your current image press the button below.</p>
                            </div>

                            <div id="btn_uncheck" class="rounded bg-blue-200 text-blue-900 py-2 text-center w-full text-sm font-bold"> Keep Image
                            </div>
                        </div>
                        @endif
                        <div class="hidden">
                            <input type="file" name="photo" id="photo" accept="image/*" style="height:0; padding:0;" aria-describedby="photo" class="myfile">
                        </div>
                        <div class="flex">
                            <label for="photo" class="rounded-lg bg-gray-200 text-gray-900 py-2 text-center w-full text-sm font-bold" role="button" aria-label="Upload"><i class="fa fa-upload" aria-hidden="true" title="Want to Upload?"></i> Image
                            </label>
                        </div>
                        @error('photo')
                        <div class="text-red-500 text-sm">{{$message}}</div>
                        @enderror
                        <input type="text" name="name" id="name" class="outline-none focus:ring focus:ring-gray-300 focus:ring-4 bg-gray-100 rounded-lg w-full text-gray-900 @error('name') border-4 border-red-300 @enderror text-sm" value="{{auth()->user()->name}}" required>
                        @error('name')
                        <div class="text-red-500 text-sm">{{$message}}</div>
                        @enderror
                        <input type="text" name="phone" id="phone" class="outline-none focus:ring focus:ring-gray-300 focus:ring-4 bg-gray-100  rounded-lg w-full text-gray-900 @error('phone') border-4 border-red-300 @enderror text-sm" value="{{auth()->user()->phone}}" placeholder="054xxxxxxx">
                        @error('phone')
                        <div class="text-red-500 text-sm">{{$message}}</div>
                        @enderror
                        <input type="email" name="email" id="email" class="outline-none focus:ring focus:ring-gray-300 bg-gray-100 rounded-lg w-full text-gray-900 @error('email') border-4 border-red-300 @enderror text-sm" value="{{auth()->user()->email}}" required>
                        @error('email')
                        <div class="text-red-500 text-sm">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="py-4">
                        <x-jet-button>
                            {{ __('Save') }}
                        </x-jet-button>
                    </div>
                </form>
                @endif
            </div>
        </div>
    </div>
    <x-jet-section-border />
    @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
    <div class="md:grid md:grid-cols-3 md:gap-6">
        <div class="lg:col-span-1 flex justify-between">
            <div class="px-4 sm:px-0">
                <h3 class="font serif font-semibold text-lg text-gray-100 leading-tight">Update Password</h3>

                <p class="text-sm text-gray-300 leading-tight mt-1 mb-2">
                    Ensure your account is using a long password to stay secure.
                </p>
            </div>
        </div>
        <div class="md:col-span-2 sm:rounded-lg bg-gray-700 p-5">
            <form action="{{route('user.password.update')}}" class="space-y-4" method="Post">
                @csrf
                <label for="current_password" class="sr-only">Current Password</label>
                <input type="password" name="current_password" id="current_password" placeholder="Current Password" class="placeholder-gray-500 bg-gray-100 rounded-lg w-full placeholder-opacity-75 text-sm" required autocomplete="current_password">
                @error('current_password')
                <div class="text-red-500 text-sm">{{$message}}</div>
                @enderror
                <label for="password" class="sr-only">New Password</label>
                <input type="password" name="password" id="password" placeholder="New Password" class="placeholder-gray-500 bg-gray-100 text-sm rounded-lg w-full placeholder-opacity-75" required>
                @error('password')
                <div class="text-red-500 text-sm">{{$message}}</div>
                @enderror
                <label for="cpassword_confirmation" class="sr-only">Password Confirmation</label>
                <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Confirm Password" class="placeholder-gray-500 bg-gray-100 p-2 rounded-lg w-full placeholder-opacity-75 text-sm" required>
                @error('password_confirmation')
                <div class="text-red-500 text-sm">{{$message}}</div>
                @enderror
                <x-jet-button>
                    {{ __('Save') }}
                </x-jet-button>
            </form>
        </div>
    </div>
    @endif

    <x-jet-section-border />

    @if (Laravel\Fortify\Features::canManageTwoFactorAuthentication())
    <div class="mt-10 sm:mt-0">
        @livewire('profile.two-factor-authentication-form')
    </div>

    <x-jet-section-border />
    @endif

    <div class="mt-10 sm:mt-0">
        @livewire('profile.logout-other-browser-sessions-form')
    </div>

    @if (Laravel\Jetstream\Jetstream::hasAccountDeletionFeatures())
    <x-jet-section-border />

    <div class="my-10 sm:mt-0">
        @livewire('profile.delete-user-form')
    </div>
    @endif

</div>

@endsection
@section('page_footer_scripts')
<script src="{{asset('backend/assets/js/myOneImg.js')}}"></script>
<script src="{{asset('backend/assets/js/alerts.js')}}"></script>
<script>
    $(document).ready(function() {
        $('#photo').on('change', function() {
            $("#del_photo").prop("checked", false);
            $("#uncheck_wrap").hide();
            $("#btn_check").show();

        });
        $("#btn_check").click(function() {
            /* remove file from form */
            $('#photo').val('');
            /* sign checkbox */
            $("#del_photo").prop("checked", true);
            $("#btn_check").hide();
            $("#uncheck_wrap").show();
            /* if there is a photo chosen before for upload preview remove arrow and preview */
            $('#arrow').empty();
            $('#preview-image-before-upload').hide();
        });

        $("#btn_uncheck").click(function() {
            $("#del_photo").prop("checked", false);
            $("#uncheck_wrap").hide();
            $("#btn_check").show();

        });
    });
</script>
@endsection