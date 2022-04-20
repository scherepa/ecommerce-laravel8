<div>
    <form wire:submit.prevent="submit" method="post">
        @csrf
        @if($notification)
        <div class="text-green-500 font-bold text-sm my-2">
            <span class="material-icons self-center mr-2">
                check_circle
            </span>{{$notification}}
        </div>
        @endif
        <div class="mb-2 grid grid-cols-6 lg:gap-4">
            <label for="name" class="text-gray-100 text-sm font-semibold pr-2 py-2 col-span-3  lg:col-span-1">Your name:</label>
            <input type="text" name="name" id="name" class="col-span-6 lg:col-span-5 rounded-lg text-sm border @error('name')  border-red-500 @enderror" value="{{old('name')}}" placeholder="Your Name" required wire:model="name">
        </div>
        @error('name')
        <div class="text-red-500 text-sm">{{$message}}</div>
        @enderror

        <div class="mb-2 grid grid-cols-6 lg:gap-4">
            <label for="email" class="text-gray-100 text-sm font-semibold pr-2 py-2 col-span-3 lg:col-span-1">Email:</label>
            <input type="text" name="email" id="email" class="col-span-6 lg:col-span-5 rounded-lg text-sm border @error('email')  border-red-500 @enderror" value="{{old('email')}}" placeholder="example@gmail.com" required email wire:model="email">
        </div>
        @error('email')
        <div class="text-red-500 text-sm">{{$message}}</div>
        @enderror

        <div class="mb-2 grid grid-cols-6 lg:gap-4">
            <label for="theme" class="text-gray-100 text-sm font-semibold pr-2 py-2 col-span-3 lg:col-span-1">Theme:</label>
            <input type="text" name="theme" id="theme" class="col-span-6 lg:col-span-5 rounded-lg text-sm border @error('theme')  border-red-500 @enderror" value="{{old('theme')}}" placeholder="Theme" required wire:model="theme">
        </div>
        @error('theme')
        <div class="text-red-500 text-sm">{{$message}}</div>
        @enderror

        <div class="mb-2 grid grid-cols-6 lg:gap-4">
            <label for="body" class="text-gray-100 text-sm font-semibold pr-2 py-2 col-span-3 lg:col-span-1">Email:</label>
            <textarea name="body" id="body" class="col-span-6 lg:col-span-5 rounded-lg text-sm border @error('body')  border-red-500 @enderror" value="{{old('body')}}" placeholder="Your message here:" required wire:model="body"></textarea>
        </div>
        @error('body')
        <div class="text-red-500 text-sm">{{$message}}</div>
        @enderror
        <div class="flex justify-end">
            <div class="py-4">
                <x-jet-button>
                    {{ __('Send') }}
                </x-jet-button>
            </div>
        </div>
    </form>
</div>