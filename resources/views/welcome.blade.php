@extends('layouts.layout')
@section('title','Home')

@push('css')
<style>
    .latest-update-card .card-body .latest-update-box:after {
        width: 0 !important;
    }
</style>
@endpush

@section('main')
<div class="row">
    <div class="col-12">
        <!-- widget-success-card start -->
        <div class="card flat-card widget-purple-card">
            <div class="row-table">
                <div class="col-sm-3 card-body">
                    <h4>{{ \Carbon\Carbon::now()->format('d/m/y') }}</h4>
                </div>
                <div class="col-sm-9">
                    <h4>Welcome {{ auth()->user()->name }}</h4>
                </div>
            </div>
        </div>
        <!-- widget-success-card end -->
        <!-- alert -->
        <div class="card-header bg-info mb-4">
            <h5 class="text-white">Today's Stat.</h5>
        </div>
        <!-- alert end -->

        <!-- Low Stock Alert Section -->
        @if(count($lowStockItems) > 0)
            <div class="col-12 mb-4">
                <div class="card border-danger">
                    <div class="card-header bg-danger">
                        <h5 class="text-white mb-0">
                            <i class="feather icon-alert-circle mr-2"></i>
                            Low Stock Alert - {{ count($lowStockItems) }} Product(s) Below Threshold
                        </h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Product Name</th>
                                        <th>Batch No.</th>
                                        <th>Current Stock</th>
                                        <th>Supplier</th>
                                        <th>Unit Price</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($lowStockItems as $item)
                                        <tr class="@if($item['current_stock'] <= 2) table-danger @else table-warning @endif">
                                            <td>
                                                <strong>{{ $item['product_name'] }}</strong>
                                            </td>
                                            <td>
                                                <span class="badge badge-secondary">{{ $item['batch_no'] }}</span>
                                            </td>
                                            <td>
                                                <span class="badge @if($item['current_stock'] <= 2) badge-danger @else badge-warning @endif">
                                                    {{ $item['current_stock'] }} units
                                                </span>
                                            </td>
                                            <td>{{ $item['supplier'] }}</td>
                                            <td>@ksh($item['sell_price'])</td>
                                            <td>
                                                @if($item['current_stock'] <= 2)
                                                    <span class="badge badge-danger">Critical</span>
                                                @elseif($item['current_stock'] <= 5)
                                                    <span class="badge badge-warning">Warning</span>
                                                @else
                                                    <span class="badge badge-info">Low</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <!-- Low Stock Alert Section End -->
    </div>
    <!-- table card-1 start -->
    <div class="col-md-12 col-xl-6">

        <div class="card flat-card">
            <div class="row-table">
                <div class="col-sm-6 card-body br">
                    <div class="row">
                        <div class="col-sm-2">
                            <i class="icon feather icon-package text-c-green mb-1 d-block"></i>
                        </div>
                        <div class="col-sm-10 text-md-center">
                            <h5>Products In Stock</h5>
                            <span>{{ $dailyReport['productsCount'] }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 card-body">
                    <div class="row">
                        <div class="col-sm-2">
                            <i class="icon feather icon-trending-up text-c-red mb-1 d-block"></i>
                        </div>
                        <div class="col-sm-10 text-md-center">
                            <h5>Sold Products</h5>
                            <span>{{ $dailyReport['soldProducts'] }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row-table">
                <div class="col-sm-6 card-body br">
                    <div class="row">
                        <div class="col-sm-2">
                            <i class="icon feather icon-alert-triangle text-c-blue mb-1 d-block"></i>
                        </div>
                        <div class="col-sm-10 text-md-center">
                            <h5>Out Of Stock Products</h5>
                            <span>{{ $dailyReport['outOfStockProducts'] }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 card-body">
                    <div class="row">
                        <div class="col-sm-2 p-r-0">
                            <i class="icon feather icon-star text-c-yellow mb-1 d-block"></i>
                        </div>
                        <div class="col-sm-10 p-l-0 text-md-center">
                            <h5>Most Sold Products</h5>
                            <span>{{ $dailyReport['topSoldProduct']['maxProduct'] }} {{
                                $dailyReport['topSoldProduct']['maxQuantity'] }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- widget primary card start -->

        <!-- widget primary card end -->
    </div>
    <!-- table card-1 end -->
    <!-- table card-2 start -->
    <div class="col-md-12 col-xl-6">
        <div class="card flat-card">
            <div class="row-table">
                <div class="col-sm-6 card-body br">
                    <div class="row">
                        <div class="col-sm-2">
                            <i class="icon feather icon-list text-c-blue mb-1 d-block"></i>
                        </div>
                        <div class="col-sm-10 text-md-center">
                            <h5>Toal Order</h5>
                            <span>{{ $dailyReport['totalOrder'] }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 card-body">
                    <div class="row">
                        <div class="col-sm-2">
                            <i class="icon feather icon-briefcase text-c-blue mb-1 d-block"></i>
                        </div>
                        <div class="col-sm-10 text-md-center">
                            <h5>Total Sell Amount</h5>
                            <span>@ksh((int) $dailyReport['totalSellAmount'])</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row-table">
                <div class="col-sm-6 card-body br">
                    <div class="row">
                        <div class="col-sm-2">
                            <i class="icon feather icon-check-circle text-c-blue mb-1 d-block"></i>
                        </div>
                        <div class="col-sm-10 text-md-center">
                            <h5>Total Paid Amount</h5>
                            <span>@ksh((int) $dailyReport['totalSellAmount'] - (int) $dailyReport['totalDueAmount'])</span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 card-body">
                    <div class="row">
                        <div class="col-sm-2">
                            <i class="icon feather icon-credit-card text-c-blue mb-1 d-blockz"></i>
                        </div>
                        <div class="col-sm-10 text-md-center">
                            <h5>Total Due Amount</h5>
                            <span>@ksh((int) $dailyReport['totalDueAmount'])</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- widget-success-card end -->
    </div>
    <!-- table card-2 end -->
    <div class="col-xl-6 col-md-12">
        <div class="card latest-update-card">
            <div class="card-header">
                <h5>Profit & Expense Updates</h5>
                <div class="card-header-right">
                    <div class="btn-group card-option">
                        <button type="button" class="btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false">
                            <i class="feather icon-more-horizontal"></i>
                        </button>
                        <ul class="list-unstyled card-option dropdown-menu dropdown-menu-right">
                            <li class="dropdown-item full-card"><a href="#!"><span><i class="feather icon-maximize"></i>
                                        maximize</span><span style="display:none"><i class="feather icon-minimize"></i>
                                        Restore</span></a></li>
                            <li class="dropdown-item minimize-card"><a href="#!"><span><i
                                            class="feather icon-minus"></i> collapse</span><span style="display:none"><i
                                            class="feather icon-plus"></i> expand</span></a></li>
                            <li class="dropdown-item reload-card"><a href="#!"><i class="feather icon-refresh-cw"></i>
                                    reload</a></li>
                            <li class="dropdown-item close-card"><a href="#!"><i class="feather icon-trash"></i>
                                    remove</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="latest-update-box">
                    <div class="row">
                        <div class="col-6">
                            <div class="row">
                                <div class="col m-t-30">
                                    <h5 class="text-success">Profit Update</h5>
                                </div>
                            </div>
                            <div class="row p-t-30 p-b-30">
                                <div class="col-auto text-right update-meta">
                                    <p class="text-muted m-b-0 d-inline-flex">Today</p>
                                    <i class="feather icon-briefcase bg-twitter update-icon"></i>
                                </div>
                                <div class="col">
                                    <a href="#!">
                                        <h6>@ksh((int) $dailyReport['profit'])</h6>
                                    </a>
                                </div>
                            </div>
                            <div class="row p-b-30">
                                <div class="col-auto text-right update-meta">
                                    <p class="text-muted m-b-0 d-inline-flex">This Week</p>
                                    <i class="feather icon-briefcase bg-c-red update-icon"></i>
                                </div>
                                <div class="col">
                                    <a href="#!">
                                        <h6>@ksh($weeklyProfit['profit'])</h6>
                                    </a>
                                </div>
                            </div>
                            <div class="row p-b-0">
                                <div class="col-auto text-right update-meta">
                                    <p class="text-muted m-b-0 d-inline-flex">{{ \Carbon\Carbon::now()->format('F') }}
                                    </p>
                                    <i class="feather icon-briefcase bg-facebook update-icon"></i>
                                </div>
                                <div class="col">
                                    <a href="#!">
                                        <h6>@ksh($monthlyProfit['profit'])</h6>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="row">
                                <div class="col m-t-30">
                                    <h5 class="text-success">Expense Update</h5>
                                </div>
                            </div>
                            <div class="row p-t-30 p-b-30">
                                <div class="col-auto text-right update-meta">
                                    <p class="text-muted m-b-0 d-inline-flex">Today</p>
                                    <i class="feather icon-briefcase bg-twitter update-icon"></i>
                                </div>
                                <div class="col">
                                    <a href="#!">
                                        <h6>@ksh((int) $dailyReport['totalExpense'])</h6>
                                    </a>
                                </div>
                            </div>
                            <div class="row p-b-30">
                                <div class="col-auto text-right update-meta">
                                    <p class="text-muted m-b-0 d-inline-flex">This Week</p>
                                    <i class="feather icon-briefcase bg-c-red update-icon"></i>
                                </div>
                                <div class="col">
                                    <a href="#!">
                                        <h6>@ksh($weeklyProfit['totalExpense'])</h6>
                                    </a>
                                </div>
                            </div>
                            <div class="row p-b-0">
                                <div class="col-auto text-right update-meta">
                                    <p class="text-muted m-b-0 d-inline-flex">{{ \Carbon\Carbon::now()->format('F') }}
                                    </p>
                                    <i class="feather icon-briefcase bg-facebook update-icon"></i>
                                </div>
                                <div class="col">
                                    <a href="#!">
                                        <h6>@ksh($monthlyProfit['totalExpense'])</h6>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-6 col-md-12">
        <div class="card table-card">
            <div class="card-header">
                <h5>Recent Invoices</h5>
                <div class="card-header-right">
                    <div class="btn-group card-option">
                        <button type="button" class="btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false">
                            <i class="feather icon-more-horizontal"></i>
                        </button>
                        <ul class="list-unstyled card-option dropdown-menu dropdown-menu-right">
                            <li class="dropdown-item full-card"><a href="#!"><span><i class="feather icon-maximize"></i>
                                        maximize</span><span style="display:none"><i class="feather icon-minimize"></i>
                                        Restore</span></a></li>
                            <li class="dropdown-item minimize-card"><a href="#!"><span><i
                                            class="feather icon-minus"></i> collapse</span><span style="display:none"><i
                                            class="feather icon-plus"></i> expand</span></a></li>
                            <li class="dropdown-item reload-card"><a href="#!"><i class="feather icon-refresh-cw"></i>
                                    reload</a></li>
                            <li class="dropdown-item close-card"><a href="#!"><i class="feather icon-trash"></i>
                                    remove</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Customer</th>
                                <th>Total</th>
                                <th>Due</th>
                                <th>Profit</th>
                                <th class="text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($currentDateInvoices)
                            @foreach ($currentDateInvoices as $key=>$invoice)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $invoice->customer->name }}</td>
                                <td>@ksh($invoice->total)</td>
                                <td>@ksh($invoice->due)</td>
                                <td>@ksh($invoice->profit)</td>
                                <td class="text-right"><label class="badge badge-light-danger"><a
                                            href="{{ route('invoices.show',$invoice->id) }}"><i
                                                class="icon feather icon-eye"></i></a></label></td>
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td>No Invoice Created Yet!</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection