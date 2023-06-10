@extends('admin.admin_master')

@section('title', 'Dashboard')

@section('page_header_scripts')
<script>
    let brands = "{{implode(',',$brands)}}";
    let prods = "{{json_encode($products)}}";
    console.log(brands);
    let qty = "{{json_encode($qtys)}}";
    console.log(qty);
</script>
<!-- Charts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
<script src="{{asset('backend/assets/js/chartjs-int.js')}}"></script>
@endsection
@section('admin')
<div class="p-4 bg-gray-900 md:rounded">
    <div class="space-y-6">
        <div class="p-4 mb-4">
            <h2 class="font-serif font-semibold text-xl text-gray-100 leading-tight">
                Dashboard
            </h2>
        </div>
        <div class="p-4 mb-4 rounded bg-gray-800">
            <!-- cards -->
            @foreach($brands as $brand)
            <div id="cards" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-2 lg:gap-4 py-4">
                <div class="p-4 bg-gray-700 text-gray-100 rounded">{{$brand}}</div>
                <div class="p-4 text-white bg-gray-700 text-gray-100 rounded">{{$products[$brand]->count()}}</div>
                <div class="p-4 text-white bg-gray-700 text-gray-100 rounded">{{$products[$brand]->sum('product_qty')}}</div>
            </div>
            @endforeach

            <!-- end cards -->
            <!-- charts -->

            <div id="chart" class="grid grid-cols-1 lg:grid-cols-2 gap-2 lg:gap-4">
                <div class="rounded p-4 bg-gray-700"><canvas id="myChart" class="rounded"></canvas></div>
                <div class="rounded p-4 bg-gray-700"><canvas id="myChartpie" class="rounded"></canvas></div>
            </div>

            <!-- endOfCharts -->
            <!-- table -->
            <div class="flex w-full py-4">
                <div class="w-full rounded p-2 bg-gray-700">
                    <div class="overflow-x-auto m-2">
                        <table class="table-auto w-full">
                            <thead>
                                <tr>
                                    <th class="rounded-lg p-2 bg-gray-800 text-gray-100 border-2 border-gray-700">
                                        Products
                                    </th>
                                    <th class="rounded-lg p-2 bg-gray-800 text-gray-100 border-2 border-gray-700">
                                        Brand
                                    </th>
                                    <th class="rounded-lg p-2 bg-gray-800 text-gray-100 border-2 border-gray-700">
                                        Price
                                    </th>
                                    <th class="rounded-lg p-2 bg-gray-800 text-gray-100 border-2 border-gray-700">
                                        Discount Price
                                    </th>
                                    <th class="rounded-lg p-2 bg-gray-800 text-gray-100 border-2 border-gray-700">
                                        QTY
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($brands as $brand)
                                @foreach($products[$brand] as $prod)
                                <tr>
                                    <td class="rounded-lg p-2 bg-gray-800 text-gray-100 border-2 border-gray-700">
                                        {{$prod->product_name_en}}
                                    </td>
                                    <td class="rounded-lg p-2 bg-gray-800 text-gray-100 border-2 border-gray-700">

                                        {{$brand}}

                                    </td>
                                    <td class="rounded-lg p-2 bg-gray-800 text-gray-100 border-2 border-gray-700">
                                        {{$prod->selling_price}}
                                    </td>
                                    <td class="rounded-lg p-2 bg-gray-800 text-gray-100 border-2 border-gray-700">
                                        {{$prod->discount_price ?? 0}}
                                    </td>
                                    <td class="rounded-lg p-2 bg-gray-800 text-gray-100 border-2 border-gray-700">
                                        {{$prod->product_qty}}
                                    </td>
                                </tr>
                                @endforeach
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection