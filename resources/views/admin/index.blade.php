@extends('admin.admin_master')

@section('title', 'Dashboard')

@section('page_header_scripts')
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

            <div id="cards" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-2 lg:gap-4 py-4">
                <div class="p-4 bg-gray-700 text-gray-100 rounded"></div>
                <div class="p-4 text-white bg-gray-700 text-gray-100 rounded"></div>
                <div class="p-4 text-white bg-gray-700 text-gray-100 rounded"></div>
            </div>

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
                                        Price
                                    </th>
                                    <th class="rounded-lg p-2 bg-gray-800 text-gray-100 border-2 border-gray-700">
                                        Deposit
                                    </th>
                                    <th class="rounded-lg p-2 bg-gray-800 text-gray-100 border-2 border-gray-700">
                                        Agent
                                    </th>
                                    <th class="rounded-lg p-2 bg-gray-800 text-gray-100 border-2 border-gray-700">
                                        Status
                                    </th>
                                    <th class="rounded-lg p-2 bg-gray-800 text-gray-100 border-2 border-gray-700">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="rounded-lg p-2 bg-gray-800 text-gray-100 border-2 border-gray-700">
                                        Indiana brrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr
                                    </td>
                                    <td class="rounded-lg p-2 bg-gray-800 text-gray-100 border-2 border-gray-700">

                                        Indianapolis

                                    </td>
                                    <td class="rounded-lg p-2 bg-gray-800 text-gray-100 border-2 border-gray-700">
                                        Indiana
                                    </td>
                                    <td class="rounded-lg p-2 bg-gray-800 text-gray-100 border-2 border-gray-700">
                                        Indiana
                                    </td>
                                    <td class="rounded-lg p-2 bg-gray-800 text-gray-100 border-2 border-gray-700">
                                        Indiana
                                    </td>
                                    <td class="rounded-lg p-2 bg-gray-800 text-gray-100 border-2 border-gray-700">
                                        Indiana
                                    </td>
                                </tr>
                                <tr>
                                    <td class="rounded-lg p-2 bg-gray-800 text-gray-100 border-2 border-gray-700">
                                        Ohio
                                    </td>
                                    <td class="rounded-lg p-2 bg-gray-800 text-gray-100 border-2 border-gray-700">
                                        Ohio
                                    </td>
                                    <td class="rounded-lg p-2 bg-gray-800 text-gray-100 border-2 border-gray-700">
                                        Ohio
                                    </td>
                                    <td class="rounded-lg p-2 bg-gray-800 text-gray-100 border-2 border-gray-700">
                                        Ohio
                                    </td>
                                    <td class="rounded-lg p-2 bg-gray-800 text-gray-100 border-2 border-gray-700">
                                        Ohio
                                    </td>
                                    <td class="rounded-lg p-2 bg-gray-800 text-gray-100 border-2 border-gray-700">
                                        Columbus
                                    </td>
                                </tr>
                                <tr>
                                    <td class="rounded-lg p-2 bg-gray-800 text-gray-100 border-2 border-gray-700">
                                        Michigan
                                    </td>
                                    <td class="rounded-lg p-2 bg-gray-800 text-gray-100 border-2 border-gray-700">
                                        Michigan
                                    </td>
                                    <td class="rounded-lg p-2 bg-gray-800 text-gray-100 border-2 border-gray-700">
                                        Michigan
                                    </td>
                                    <td class="rounded-lg p-2 bg-gray-800 text-gray-100 border-2 border-gray-700">
                                        Michigan
                                    </td>
                                    <td class="rounded-lg p-2 bg-gray-800 text-gray-100 border-2 border-gray-700">
                                        Michigan
                                    </td>
                                    <td class="rounded-lg p-2 bg-gray-800 text-gray-100 border-2 border-gray-700">
                                        Detroit
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection