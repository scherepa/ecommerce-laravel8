 @extends('admin.admin_master')

 @section('title', 'Edit Slide')

 @section('admin')
 <div class="p-4 bg-gray-900 md:rounded">
     <div class="p-4 mb-4">
         <h2 class="font-serif font-bold text-xl text-gray-100 leading-tight">
             Manage Slide
         </h2>
     </div>
     <div class="p-4 md:rounded bg-gray-800 mb-2">
         <h3 class="font-serif font-semibold text-lg text-gray-100 leading-tight">
             The Slide Information
         </h3>
         <p class="text-sm text-gray-300 leading-tight mt-1 mb-2">
             Veiw your and update the slide information.
         </p>
     </div>
     <div class="p-4 md:rounded bg-gray-800 mb-2">
         <h3 class="font-serif font-semibold text-lg text-gray-100 leading-tight">
             Edit Slide
         </h3>
     </div>
     @auth('admin')
     <div class="p-4 md:p-6 lg:py-10 lg:px-12 md:rounded bg-gray-700">
         <form action="{{route('admin.slider.update', $slide->id)}}" method="POST" enctype="multipart/form-data" class="w-full">
             @method('put')
             @csrf
             <div class="mb-2 grid grid-cols-6 lg:gap-4">
                 <label for="title" class="text-gray-100 text-sm font-semibold pr-2 py-2 col-span-3  lg:col-span-1">Title </label>
                 <input type="text" name="title" id="title" class="col-span-6 lg:col-span-5 rounded-lg text-sm" value="{{$slide->title}}">
             </div>
             <div class="mb-2 grid grid-cols-6 gap-4">
                 <label for="description" class="text-gray-100 text-sm font-semibold pr-2 py-2 col-span-3  lg:col-span-1">Description</label>
                 <textarea type="text" name="description" id="description" class="col-span-6 lg:col-span-5 rounded-lg text-sm ">{{$slide->description}}</textarea>
             </div>
             <div class="mb-2 grid grid-cols-6 lg:gap-4">
                 <p class="col-span-3  lg:col-span-1 font-semibold text-gray-100 text-sm py-2 pr-2">Active in Slider</p>
                 <div class="col-span-6 lg:col-span-5">
                     @if($slide->status == 1)
                     <input type="checkbox" id="disactivate" name="disactivate" value="1">
                     <div>
                         <label for="disactivate" class="text-gray-100 text-sm font-semibold pr-2 py-2">Don't Display in Slider</label>
                     </div>
                     @else
                     <input type="checkbox" id="activate" name="activate" value="1">
                     <div>
                         <label for="activate" class="text-gray-100 text-sm font-semibold pr-2 py-2">Display in Slider</label>
                     </div>
                     @endif
                 </div>
             </div>

             <div class="mb-2 grid grid-cols-6 lg:gap-4">
                 <p class="col-span-3  lg:col-span-1 font-semibold text-gray-100 text-sm py-2 pr-2">Images</p>
                 <div class="col-span-6 lg:col-span-5">
                     <div class="text-gray-200 flex rounded mt-1" id="preview"> <img src="{{asset($slide->slider_img)}}" alt="slide image" class="h-20 object-contain rounded"> </div>
                     <div class="hidden">
                         <input type="file" name="thumbnail" id="thumbnail" accept="image/*" style="height:0; padding:0;" aria-describedby="thumbnail">
                     </div>
                     <div class="text-gray-100 text-sm pr-2 py-2 col-span-3 lg:col-span-1">
                         Upload Slider
                     </div>
                     <label for="thumbnail" role="button" class="mb-2">
                         <div class="py-2 w-full rounded-lg  @error('thumbnail') bg-red-600 text-white border-red-500 @else bg-gray-100 text-gray-900 hover:bg-gray-400 @enderror text-center"><i class="fa fa-upload" aria-hidden="true" title="Want to Upload"></i> Slider</div>
                     </label>
                     @error('thumbnail')
                     <div class="text-red-500 text-sm">{{$message}}</div>
                     @enderror
                 </div>
             </div>
             <div class="grid grid-cols-6 lg:gap-4 mt-2">
                 <h4 class="text-gray-100 font-bold col-span-3 lg:col-span-1">Update slider?</h4>
                 <button type="submit" class="bg-purple-600 hover:bg-purple-800 text-gray-100 ml-auto w-full col-span-6 lg:col-span-5  rounded  mt-4 py-2">
                     Save Changes
                 </button>
             </div>
         </form>
     </div>
     @endauth
 </div>
 @endsection
 @section('page_footer_scripts')
 <script src="{{asset('backend/assets/js/alerts.js')}}"></script>
 <script src="{{asset('backend/assets/js/myMulti.js')}}"></script>
 @endsection