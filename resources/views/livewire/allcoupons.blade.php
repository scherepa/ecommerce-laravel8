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
                <th class="rounded-lg p-2 bg-gray-800 text-gray-100 border-2 border-gray-700 text-center" scope="col">
                    Discount
                </th>
                <th class="rounded-lg p-2 bg-gray-800 text-gray-100 border-2 border-gray-700 text-center" scope="col">
                    Validity
                </th>
                <th class="rounded-lg p-2 bg-gray-800 text-gray-100 border-2 border-gray-700 text-center" scope="col">
                    Status
                </th>
                <th class="rounded-lg p-2 bg-gray-800 text-gray-100 border-2 border-gray-700 text-center" scope="col">
                    Action
                </th>
            </tr>
        </thead>
        <tbody>
            @if($coupons->count())
            @foreach($coupons as $key => $coupon)
            <tr class="font-light">
                <td class="rounded-lg p-2 bg-gray-800 text-gray-100 border-2 border-gray-700 text-center" scope="row">
                    {{--$coupons->firstItem()--}}
                    {{$key + 1}}
                </td>
                <td class="rounded-lg p-2 bg-gray-800 text-gray-100 border-2 border-gray-700 text-center ">
                    {{$coupon->coupon_name}}
                </td>
                <td class="rounded-lg p-2 bg-gray-800 border-2 border-gray-700 text-center ">
                    <div class="rounded-full bg-green-500 px-2 text-gray-100 text-xs font-semibold">
                        {{$coupon->coupon_discount}}%
                    </div>
                </td>
                <td class="rounded-lg p-2 bg-gray-800 text-gray-100 border-2 border-gray-700 text-center ">
                    {{ Carbon\Carbon::parse($coupon->coupon_validity)->format('D, d F Y')}}
                </td>
                <td class="rounded-lg p-2 bg-gray-800 border-2 border-gray-700 text-center ">
                    @if($coupon->coupon_validity >= Carbon\Carbon::now()->format('Y-m-d'))
                    <div class="rounded-full bg-green-400 px-2 text-gray-100 text-xs font-semibold">Valid</div>
                    @else
                    <div class="rounded-full bg-gray-500 px-2 text-gray-100 text-xs font-semibold">Invalid</div>
                    @endif
                </td>
                <td class="rounded-lg bg-gray-800 border-2 border-gray-700">
                    <div class="flex justify-between content-center">
                        @auth('admin')
                        <form action="{{route('admin.coupon.edit', $coupon->id)}}" method="GET" class="px-1 my-2">
                            <button type="submit" class="rounded-full bg-blue-400 text-gray-100 px-4"><i class="fa fa-pencil-square-o" aria-hidden="true" title="View&Edit" alt="View&Edit"></i>
                            </button>
                        </form>
                        <div class="px-1 my-2">
                            <button wire:click="confirmDelete({{$coupon->id}})" class="px-4 rounded-full bg-red-500 text-white js-submit-confirm"><i class="fa fa-trash-o" aria-hidden="true" title="Delete" alt="Delete"></i>
                            </button>
                        </div>
                        @endauth
                    </div>
                </td>
            </tr>
            @endforeach
            @else
            <tr>
                <td colspan="6" class="font-bold text-center text-gray-100">
                    <div>Wh..ops <br> There are no coupons yet if you are on the first page... <br>If it's not the case: There are no coupons on this page any more... go to previous page</div>
                </td>
            </tr>
            @endif
        </tbody>
        <tfoot>
            <tr>
                <td colspan="6">
                    <div>{{$coupons->links()}}</div>
                </td>
            </tr>
        </tfoot>
    </table>
</div>