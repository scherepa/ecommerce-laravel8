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
                    Image
                </th>
                <th class="rounded-lg p-2 bg-gray-800 text-gray-100 border-2 border-gray-700 text-center" scope="col">
                    Code
                </th>
                <th class="rounded-lg p-2 bg-gray-800 text-gray-100 border-2 border-gray-700 text-center" scope="col">
                    QTY
                </th>
                <th class="rounded-lg p-2 bg-gray-800 text-gray-100 border-2 border-gray-700 text-center" scope="col">
                    Price
                </th>
                <th class="rounded-lg p-2 bg-gray-800 text-gray-100 border-2 border-gray-700 text-center" scope="col">
                    Discount
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
            @if($products->count())
            @foreach($products as $key => $product)
            <tr class="font-light">
                <td class="rounded-lg p-2 bg-gray-800 text-gray-100 border-2 border-gray-700 text-center" scope="row">
                    {{--$products->firstItem()--}}
                    {{$key + 1}}
                </td>
                <td class="rounded-lg p-2 bg-gray-800 text-gray-100 border-2 border-gray-700 text-center ">
                    {{$product->product_name_en}} / {{$product->product_name_heb}}
                </td>
                <td class="rounded-lg p-2 bg-gray-800 text-gray-100 border-2 border-gray-700">
                    <img src=" {{asset($product->product_thumbnail)}}" alt="{{$product->product_name_en}}" class="mx-auto h-20 object-contain">
                </td>
                <td class="rounded-lg p-2 bg-gray-800 text-gray-100 border-2 border-gray-700 text-center ">
                    {{$product->product_code}}
                </td>
                <td class="rounded-lg p-2 bg-gray-800 text-gray-100 border-2 border-gray-700 text-center ">
                    {{$product->product_qty}}
                </td>
                <td class="rounded-lg p-2 bg-gray-800 text-gray-100 border-2 border-gray-700 text-center ">
                    {{$product->selling_price}}
                </td>
                <td class="rounded-lg p-2 bg-gray-800 border-2 border-gray-700 text-center ">
                    @if($product->discount_price)
                    <div class="rounded-full bg-green-500 px-2 text-gray-100 text-xs font-semibold">
                        {{round((($product->selling_price - $product->discount_price)/$product->selling_price)*100)}}%
                    </div>
                    @else
                    <div class="rounded-full bg-gray-500 px-2 text-gray-100 text-xs font-semibold">N/A</div>
                    @endif
                </td>
                <td class="rounded-lg p-2 bg-gray-800 border-2 border-gray-700 text-center ">
                    @if($product->status == 1)
                    <div class="rounded-full bg-green-400 px-2 text-gray-100 text-xs font-semibold">Active</div>
                    @else
                    <div class="rounded-full bg-gray-500 px-2 text-gray-100 text-xs font-semibold">Inactive</div>
                    @endif
                </td>
                <td class="rounded-lg bg-gray-800 border-2 border-gray-700">
                    <div class="flex justify-between content-center">
                        @auth('admin')
                        <div class="px-1 my-2">
                            <button wire:click="updateStatus({{$product->id}})" class="rounded-full bg-purple-400 text-gray-100 px-4">
                                @if($product->status == 1)
                                <i class="fa fa-arrow-down" aria-hidden="true" title="Disactivate" alt="disactivate"></i>
                                @else
                                <i class="fa fa-arrow-up" aria-hidden="true" title="Activate" alt="activate"></i>
                                @endif
                            </button>
                        </div>
                        <form action="{{route('admin.product.edit', $product->id)}}" method="GET" class="px-1 my-2">
                            <button type="submit" class="rounded-full bg-blue-400 text-gray-100 px-4"><i class="fa fa-pencil-square-o" aria-hidden="true" title="View&Edit" alt="View&Edit"></i>
                            </button>
                        </form>
                        <div class="px-1 my-2">
                            <button wire:click="confirmDelete({{$product->id}})" class="px-4 rounded-full bg-red-500 text-white js-submit-confirm"><i class="fa fa-trash-o" aria-hidden="true" title="Delete" alt="Delete"></i>
                            </button>
                        </div>
                        @endauth
                    </div>
                </td>
            </tr>
            @endforeach
            @else
            <tr>
                <td colspan="9" class="font-bold text-center text-gray-100">
                    <div>Wh..ops <br> There are no products on this page any more... go to previous page</div>
                </td>
            </tr>
            @endif
        </tbody>
        <tfoot>
            <tr>
                <td colspan="9">
                    <div>{{$products->links()}}</div>
                </td>
            </tr>
        </tfoot>
    </table>
</div>