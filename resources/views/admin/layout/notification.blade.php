@if(session('success') || session('fail'))
@php($status = session('success') ? 'success' : 'fail')
<div class="myAlert hidden fixed top-20">
    <div class="{{$status == 'success' ? 'text-green-200 bg-green-600 my-4 p-2 md:p-4 rounded flex justify-between items-center' : 'text-red-200 bg-red-500 my-4 rounded p-2 md:p-4 flex justify-between items-center'}}">
        <span class="material-icons self-center mr-2">
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