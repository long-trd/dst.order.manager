@extends('Core::layouts.app')
@section('content')
    <!-- Topnav -->
    <!-- Header -->
    <!-- Header -->
    <div class="header bg-primary pb-6">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-center py-4 nav-bar-height position-relative">
                    <div class="btn-search left-element">
                        <a href="{{ route('admin.order.create') }}" class="btn btn-success text-white">Create</a>
                        <button class="btn btn-info text-white" data-toggle="modal" data-target="#modal-form">Search</button>
                        @if (auth()->user()->hasRole('admin'))
                            <button class="btn btn-warning text-white" data-toggle="modal"
                                data-target="#modal-excel">Download Excel</button>
                        @endif
                        <button id="btn-order-detail" class="btn btn-info text-white" data-toggle="modal"
                            data-target="#modal-form-detail" style="display: none">Detail</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Page content -->
    <div class="container-fluid mt--6">
        <div class="row">
            <div class="col">
                <div class="card">
                    <!-- Card header -->
                    <div class="card-header border-0">
                        <h3 class="mb-0">Orders</h3>
                    </div>
                    <!-- Light table -->
                    <div class="table-responsive">
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col" class="sort" data-sort="no">No</th>
                                    <th scope="col" class="sort" data-sort="account_ip">Account IP</th>
                                    <th scope="col" class="sort" data-sort="site">Site</th>
                                    <th scope="col" class="sort" data-sort="site_status">Site status</th>
                                    <th scope="col" class="sort" data-sort="status">Status</th>
                                    <th scope="col" class="sort" data-sort="manager">Manager</th>
                                    <th scope="col" class="sort" data-sort="shipper">Shipper</th>
                                    <th scope="col" class="sort" data-sort="helper">Helper</th>
                                    <th scope="col" class="sort" data-sort="name" style="display: none">Info</th>
                                    <th scope="col" class="sort" data-sort="ebay_url" style="display: none">Ebay URL</th>
                                    <th scope="col" class="sort" data-sort="product_url">Product URL</th>
                                    <th scope="col" class="sort" data-sort="shipping_infomation">Shipping Infomation</th>
                                    <th scope="col" class="sort" data-sort="price" style="display: none">Price</th>
                                    <th scope="col" class="sort" data-sort="quantity" style="display: none">Quantity</th>
                                    <th scope="col" class="sort" data-sort="order_date" style="display: none">Order Date</th>
                                    <th scope="col" class="sort" data-sort="customer_notes" style="display: none">Customer Notes</th>
                                    <th scope="col" class="sort" data-sort="tracking" style="display: none">Tracking</th>
                                    @if (auth()->user()->hasRole('admin') || auth()->user()->hasRole('shipper'))
                                        <th scope="col" class="sort" data-sort="paypal-notes">Notes</th>
                                    @endif
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody class="list">
                                @foreach ($orders as $key => $order)
                                    <tr class="order-{{ $order->status }} right-click" data-order="{{ $order->order_id }}"
                                        data-no="{{ $key }}">
                                        <th scope="row" class="budget">
                                            <div class="media align-items-center">
                                                <div class="media-body">
                                                    <span class="name mb-0 text-sm">{{ $key + 1 }}</span>
                                                </div>
                                            </div>
                                        </th>
                                        <td class="budget ip_address">
                                            {{ $order->account->ip_address }}
                                        </td>
                                        <td class="budget site">
                                            {{ $order->site ? $order->site->name : '' }}
                                        </td>
                                        <td class="budget site_status">
                                            @if($order->site)
                                                <span class="badge badge-dot mr-4">
                                                    <i
                                                        class="
                                                        @if ($order->site->status == 'live') bg-success
                                                        @elseif ($order->site->status == 'pause')
                                                            bg-primary
                                                        @elseif ($order->site->status == 'die')
                                                            bg-danger
                                                        @endif
                                                    ">
                                                    </i>
                                                    <span class="status">{{ $order->site->status }}</span>
                                                </span>
                                            @endif
                                        </td>
                                        <td class="budget status">
                                            <span class="badge badge-dot mr-4">
                                                <i
                                                    class="
                                                @if ($order->status == 'new') bg-secondary
                                                @elseif ($order->status == 'processing')
                                                    bg-primary
                                                @elseif ($order->status == 'needhelp')
                                                    bg-warning
                                                @elseif ($order->status == 'cancel')
                                                    bg-danger
                                                @elseif ($order->status == 'tracking')
                                                    bg-info
                                                @elseif ($order->status == 'shipped')
                                                    bg-success @endif
                                            "></i>
                                                <span class="status">{{ $order->status }}</span>
                                            </span>
                                        </td>
                                        <td class="budget manager_name">
                                            {{ isset($order->manager->name) ? $order->manager->name : '' }}
                                            {!! isset($order->manager->name) ? ($globalData['arrTop3Manager'][$order->manager->name] ?? '') : '' !!}
                                        </td>
                                        <td class="budget shipper_name">
                                            {{ isset($order->shipper->name) ? $order->shipper->name : '' }}
                                            {!! isset($order->shipper->name) ? ($globalData['arrTop3Shipper'][$order->shipper->name] ?? '') : '' !!}
                                        </td>
                                        <td class="budget helper_name">
                                            {{ isset($order->helper->name) ? $order->helper->name : '' }}
                                        </td>
                                        <td class="budget name" style="display: none">
                                            {{ $order->name }}
                                        </td>
                                        <td class="budget ebay_url" style="display: none">
                                            {{ $order->ebay_url }}
                                        </td>
                                        <td class="budget product_url">
                                            {{ $order->product_url }}
                                        </td>
                                        <td class="budget shipping_information">
                                            {!! nl2br($order->shipping_information) !!}
                                        </td>
                                        <td class="budget price" style="display: none">
                                            {{ $order->price . '$' }}
                                        </td>
                                        <td class="budget quantity" style="display: none">
                                            {{ $order->quantity }}
                                        </td>
                                        <td class="budget order_date" style="display: none">
                                            {{ $order->order_date }}
                                        </td>
                                        <td class="budget customer_notes" style="display: none">
                                            {{ $order->customer_notes }}
                                        </td>
                                        <td class="budget tracking" style="display: none">
                                            {{ $order->tracking }}
                                        </td>
                                        @if (auth()->user()->hasRole('admin') || auth()->user()->hasRole('shipper'))
                                            <td class="budget">
                                                <div class="avatar-group">
                                                    <span class="name mb-0 text-sm">{{ $order->paypal_notes }}</span>
                                                </div>
                                            </td>
                                        @endif
                                        <td class="text-right budget">
                                            <div class="dropdown">
                                                <a class="btn btn-sm btn-icon-only text-light" href="#"
                                                    role="button" data-toggle="dropdown" aria-haspopup="true"
                                                    aria-expanded="false">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                    @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('leader-manager') || auth()->user()->hasRole('leader-shipper'))
                                                    <a class="dropdown-item list-account-dropdown"
                                                        href="{{ route('admin.order.edit', ['id' => $order->order_id]) }}">Edit</a>
                                                    @endif
                                                    @if (auth()->user()->hasRole('admin'))
                                                        <a class="dropdown-item list-account-dropdown delete-order"
                                                            href="#" data-id="{{ $order->order_id }}">Delete</a>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- Card footer -->
                    <div class="card-footer py-4 position-relative">
                        <div class="sumup">Total amount of this page: <b>{{ $orders->sum('order_price') }}$</b></div>
                        <div class="sumup">Total amount of all pages: <b>{{ $totalAmountByQuery }}$</b></div>
                        <div class="sumup">Total orders: <b>{{ $totalOrderByQuery }} orders</b></div>
                        <div class="sumup">Total amount valid: <b>{{ $totalAmountIgnoreSite }}$</b></div>
                        <div class="sumup">Total orders valid: <b>{{ $totalOrderIgnoreSite }} orders</b></div>
                        <div class="sumup">Percentage of orders: <b>{{ $totalOrderWithoutStatus ? round($totalOrderByQuery / $totalOrderWithoutStatus * 100, 2) : 0 }}%</b></div>
                        <div class="sumup">Percentage of orders amount: <b>{{ $totalAmountWithoutStatus ? round($totalAmountByQuery / $totalAmountWithoutStatus * 100, 2) : 0 }}%</b></div>
                        {!! $orders->appends(request()->query())->links() !!}
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer -->
        <footer class="footer pt-0">
            <div class="row align-items-center justify-content-xl-between">
                <div class="col-xl-6">
                    <div class="copyright text-center text-xl-left text-muted">
                        &copy; {{ now()->year }} <a href="https://fb.com/long.td.1498" class="font-weight-bold ml-1"
                            target="_blank">Long.TD</a>
                    </div>
                </div>
            </div>
        </footer>
        <div class="row">
            <div class="col-md-4">
                <div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="modal-form"
                    aria-hidden="true">
                    <div class="modal-dialog modal- modal-dialog-centered modal-sm" role="document">
                        <div class="modal-content">
                            <div class="modal-body p-0">
                                <div class="card bg-secondary shadow border-0">
                                    <div class="card-body px-lg-5 py-lg-5">
                                        <form role="form" action="{{ route('admin.order.index') }}" method="GET">
                                            @csrf
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <textarea class="form-control" name="random-search"> {{ isset($request['random-search']) ? $request['random-search'] : '' }} </textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <input class="form-control" name="branch" value="{{ isset($request['branch']) ? $request['branch'] : '' }}" placeholder="Branch name" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <select class="form-control order-status" data-toggle="select"
                                                            title="Simple select" data-live-search="true" name="status">
                                                            <option value="default">--Status--</option>
                                                            <option value="new"
                                                                {{ isset($request['status']) && $request['status'] == 'new' ? 'selected' : '' }}>
                                                                New</option>
                                                            <option value="processing"
                                                                {{ isset($request['status']) && $request['status'] == 'processing' ? 'selected' : '' }}>
                                                                Processing</option>
                                                            <option value="needhelp"
                                                                {{ isset($request['status']) && $request['status'] == 'needhelp' ? 'selected' : '' }}>
                                                                Needhelp</option>
                                                            <option value="cancel"
                                                                {{ isset($request['status']) && $request['status'] == 'cancel' ? 'selected' : '' }}>
                                                                Cancel</option>
                                                            <option value="tracking"
                                                                {{ isset($request['status']) && $request['status'] == 'tracking' ? 'selected' : '' }}>
                                                                Tracking</option>
                                                            <option value="shipped"
                                                                {{ isset($request['status']) && $request['status'] == 'shipped' ? 'selected' : '' }}>
                                                                Shipped</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <select class="form-control order-account" data-toggle="select"
                                                            title="Simple select" data-live-search="true" name="account">
                                                            <option value="default">--Ip Address--</option>
                                                            @foreach ($accounts as $account)
                                                                <option value="{{ $account->id }}"
                                                                    {{ isset($request['account']) && $request['account'] == $account->id ? 'selected' : '' }}>
                                                                    {{ $account->ip_address }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" name="shipper"
                                                            placeholder="Shipper name"
                                                            value="{{ isset($request['shipper']) ? $request['shipper'] : '' }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" name="manager"
                                                            placeholder="List name"
                                                            value="{{ isset($request['manager']) ? $request['manager'] : '' }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <select class="form-control" data-toggle="select"
                                                                title="Simple select" data-live-search="true" name="site">
                                                            <option value="default">--Site--</option>
                                                            @foreach ($sites as $site)
                                                                <option value="{{ $site->id }}"
                                                                    {{ isset($request['site']) && $request['site'] == $site->id ? 'selected' : '' }}>
                                                                    {{ $site->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <select class="form-control" data-toggle="select"
                                                                title="Simple select" data-live-search="true" name="network">
                                                            <option value="default">--Network--</option>
                                                            <option value="tiktok" {{ isset($request['network']) && $request['network'] == 'tiktok' ? 'selected' : '' }}>Tiktok</option>
                                                            <option value="facebook" {{ isset($request['network']) && $request['network'] == 'facebook' ? 'selected' : '' }}>Facebook</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="input-group input-group-alternative">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i
                                                                    class="ni ni-calendar-grid-58"></i></span>
                                                        </div>
                                                        <input class="form-control datepicker" placeholder="Start date"
                                                            type="text" name="start_date"
                                                            value="{{ isset($request['start_date']) ? $request['start_date'] : '' }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="input-group input-group-alternative">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i
                                                                    class="ni ni-calendar-grid-58"></i></span>
                                                        </div>
                                                        <input class="form-control datepicker" placeholder="End date"
                                                            type="text" name="end_date"
                                                            value="{{ isset($request['end_date']) ? $request['end_date'] : '' }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="text-center">
                                                <button type="submit" class="btn btn-primary my-4">Search</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="modal fade" id="modal-form-detail" tabindex="-1" role="dialog"
                    aria-labelledby="modal-form-detail" aria-hidden="true">
                    <div class="modal-dialog modal- modal-dialog-centered modal-sm" role="document">
                        <div class="modal-content">
                            <div class="modal-body p-0">
                                <div class="card bg-secondary shadow border-0">
                                    <div class="card-body px-lg-5 py-lg-5">
                                        <form id="form-detail" role="form" action="" method="POST">
                                            @method('PUT')
                                            @csrf
                                            @if(auth()->user()->hasRole('admin'))
                                                <div class="form-group">
                                                    <label class="form-control-label" for="input-name">{{ __('Shipper') }}</label>
                                                    @foreach($shippers as $key => $shipper)
                                                        <div class="custom-control custom-radio mb-3">
                                                            <input {{ $shipper->id == $order->shipping_user_id ? 'checked' : '' }} name="shipping_user_id" value="{{$shipper->id}}" class="custom-control-input" id="shipper-{{$key}}" type="radio">
                                                            <label class="custom-control-label" for="shipper-{{$key}}">{{$shipper->name}}</label>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endif
                                            <div class="form-group">
                                                <label class="form-control-label"
                                                    for="input-name">{{ __('Info') }}</label>
                                                <input type="text" name="name" value=""
                                                    class="form-control form-control-alternative w-90" required autofocus>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-control-label"
                                                    for="input-email">{{ __('Ebay URL') }}</label>
                                                <input type="url" name="ebay_url" value=""
                                                    class="form-control form-control-alternative w-90" required>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-control-label"
                                                    for="input-email">{{ __('Product URL') }}</label>
                                                <input type="url" name="product_url" value=""
                                                    class="form-control form-control-alternative w-90" required>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-control-label"
                                                    for="input-email">{{ __('Status') }}</label>
                                                <div class="custom-control custom-radio mb-3">
                                                    <input name="status" class="custom-control-input" value="new"
                                                        id="customRadio1" type="radio">
                                                    <label class="custom-control-label" for="customRadio1">New</label>
                                                </div>
                                                <div class="custom-control custom-radio mb-3">
                                                    <input name="status" class="custom-control-input" value="processing"
                                                        id="customRadio2" type="radio">
                                                    <label class="custom-control-label"
                                                        for="customRadio2">Processing</label>
                                                </div>
                                                <div class="custom-control custom-radio mb-3">
                                                    <input name="status" class="custom-control-input" value="needhelp"
                                                        id="customRadio3" type="radio">
                                                    <label class="custom-control-label"
                                                        for="customRadio3">Needhelp</label>
                                                </div>
                                                <div class="custom-control custom-radio mb-3">
                                                    <input name="status" class="custom-control-input" value="cancel"
                                                        id="customRadio4" type="radio">
                                                    <label class="custom-control-label" for="customRadio4">Cancel</label>
                                                </div>
                                                <div class="custom-control custom-radio mb-3">
                                                    <input name="status" class="custom-control-input" value="tracking"
                                                        id="customRadio5" type="radio">
                                                    <label class="custom-control-label"
                                                        for="customRadio5">Tracking</label>
                                                </div>
                                                <div class="custom-control custom-radio mb-3">
                                                    <input name="status" class="custom-control-input" value="shipped"
                                                        id="customRadio6" type="radio">
                                                    <label class="custom-control-label" for="customRadio6">Shipped</label>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-control-label"
                                                    for="input-email">{{ __('Shipping Information') }}</label>
                                                <textarea name="shipping_information" class="form-control w-90" rows="3" required></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-control-label"
                                                       for="input-email">{{ __('Network') }}</label>
                                                <select class="form-control w-90" name="network">
                                                    <option value="">__Network__</option>
                                                    <option value="tiktok">Tiktok</option>
                                                    <option value="facebook">Facebook</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-control-label"
                                                    for="input-email">{{ __('Price') }}</label>
                                                <input type="number" name="price" value=""
                                                    class="form-control form-control-alternative w-25" required>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-control-label"
                                                    for="input-email">{{ __('Quantity') }}</label>
                                                <input type="number" name="quantity" value=""
                                                    class="form-control form-control-alternative w-25" required>
                                            </div>
                                            <div class="form-group">
                                                <div class="input-group input-group-alternative w-25">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i
                                                                class="ni ni-calendar-grid-58"></i></span>
                                                    </div>
                                                    <input class="form-control datepicker" placeholder="Select date"
                                                        type="text" name="order_date" value="" readonly>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-control-label"
                                                    for="input-email">{{ __('Customer Notes') }}</label>
                                                <textarea name="customer_notes" class="form-control w-90" rows="3" required></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-control-label"
                                                    for="input-email">{{ __('Tracking') }}</label>
                                                <textarea name="tracking" class="form-control w-90" rows="3"></textarea>
                                            </div>
                                            <div class="form-group">
                                                <div class="custom-control custom-checkbox mb-3">
                                                    <input class="custom-control-input" id="customCheck1" type="checkbox"
                                                        name="helping" value="1">
                                                    <label class="custom-control-label" for="customCheck1">Helping</label>
                                                </div>
                                            </div>
                                            @if (auth()->user()->hasRole('admin') || auth()->user()->hasRole('shipper'))
                                                <div class="form-group">
                                                    <label class="form-control-label"
                                                        for="input-email">{{ __('Notes') }}</label>
                                                    <textarea name="paypal_notes" class="form-control w-90" id="exampleFormControlTextarea1" rows="3"></textarea>
                                                </div>
                                            @endif
                                            <div class="text-center">
                                                <button type="submit"
                                                    class="btn btn-success mt-4">{{ __('Save') }}</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if (auth()->user()->hasRole('admin'))
            <div class="row">
                <div class="col-md-4">
                    <div class="modal fade" id="modal-excel" tabindex="-1" role="dialog"
                        aria-labelledby="modal-excel" aria-hidden="true">
                        <div class="modal-dialog modal- modal-dialog-centered modal-sm" role="document">
                            <div class="modal-content">
                                <div class="modal-body p-0">
                                    <div class="card bg-secondary shadow border-0">
                                        <div class="card-body px-lg-5 py-lg-5">
                                            <form role="form" action="{{ route('admin.order.excel') }}"
                                                method="POST">
                                                @csrf
                                                <div class="ml-1 row form-group">
                                                    <div class="col-md-2 custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input"
                                                            id="customCheck0" name="option[]" value="order_date">
                                                        <label class="custom-control-label" for="customCheck0">Date</label>
                                                    </div>
                                                    <div class="col-md-2 custom-control custom-checkbox">
                                                        <input type="checkbox" name="option[]" value="price" class="custom-control-input"
                                                            id="customCheck2">
                                                        <label class="custom-control-label" for="customCheck2">Price</label>
                                                    </div>
                                                    <div class="col-md-2 custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input"
                                                            id="customCheck3" name="option[]" value="quantity">
                                                        <label class="custom-control-label" for="customCheck3">Quantity</label>
                                                    </div>
                                                    <div class="col-md-2 custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input"
                                                            id="customCheck4" name="option[]" value="shipper">
                                                        <label class="custom-control-label" for="customCheck4">Shipper</label>
                                                    </div>
                                                    <div class="col-md-2 custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input"
                                                            id="customCheck5" name="option[]" value="list">
                                                        <label class="custom-control-label" for="customCheck5">List</label>
                                                    </div>
                                                </div>
                                                <div class="row form-group">
                                                    <div class="col-md-6">
                                                        <div class="input-group input-group-alternative">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text"><i
                                                                        class="ni ni-calendar-grid-58"></i></span>
                                                            </div>
                                                            <input class="form-control datepicker"
                                                                placeholder="Start date" type="text" name="start_date"
                                                                value="{{ isset($request['start_date']) ? $request['start_date'] : '' }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="input-group input-group-alternative">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text"><i
                                                                        class="ni ni-calendar-grid-58"></i></span>
                                                            </div>
                                                            <input class="form-control datepicker" placeholder="End date"
                                                                type="text" name="end_date"
                                                                value="{{ isset($request['end_date']) ? $request['end_date'] : '' }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="text-center">
                                                    <button type="submit" class="btn btn-primary my-4">Download</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
@push('js')
    <script type="text/javascript">
        $(document).ready(function() {
            @if ($errors->has('shipper'))
                alert("Don't have any shipper !!!");
            @endif

            $('.order-status, .order-account').on('change', function() {
                var option = $(this).find('option:first');
                if (this.value == 'default') {
                    $(option).attr('disabled', 'disabled');
                } else {
                    $(option).removeAttr('disabled');
                }
            });

            $('.right-click').dblclick(function() {
                var _self = $(this);
                var btnOrderDetail = $('#btn-order-detail');
                var formOrderDetail = $('#modal-form-detail').find('form');
                var orderID = _self.attr('data-order');

                $.ajax({
                    type: 'POST',
                    url: '{{ route('admin.order.detail', ['id' => '']) }}' + '/' + orderID,
                    headers: {
                        'X-CSRF-TOKEN': '{!! csrf_token() !!}'
                    },

                    success: function(data) {
                        if (data.status == 200) {
                            data = data.data;
                            console.log(data);
                            formOrderDetail.find('input[name=name]').val(data.name);
                            formOrderDetail.find('input[name=ebay_url]').val(data.ebay_url);
                            formOrderDetail.find('input[name=product_url]').val(data
                                .product_url);
                            formOrderDetail.find('textarea[name=shipping_information]').val(data
                                .shipping_information);
                            formOrderDetail.find('input[name=price]').val(data.price);
                            formOrderDetail.find('input[name=quantity]').val(data.quantity);
                            formOrderDetail.find('input[name=order_date]').val(data.order_date);
                            formOrderDetail.find('textarea[name=customer_notes]').val(data
                                .customer_notes);
                            formOrderDetail.find('textarea[name=tracking]').val(data.tracking);
                            formOrderDetail.find('input[name=status][value=' + data.status +
                                ']').attr('checked', true);
                            formOrderDetail.find("select[name='network'] option[value='" + data.network + "']").prop("selected", true);

                            if (data.helper) {
                                formOrderDetail.find('input[name=helping]').attr('checked',
                                    true);
                            }

                            @if (auth()->user()->hasRole('admin'))
                                formOrderDetail.find('textarea[name=paypal_notes]').val(data
                                    .paypal_notes);
                            @endif

                            formOrderDetail.attr('action',
                                '{{ route('admin.order.update', ['id' => '']) }}' + '/' +
                                orderID);
                            btnOrderDetail.click();
                        } else {
                            alert(
                                'Something went wrong, please try again or contact for support !'
                            );
                        }
                    }
                });
            });

            $('.delete-order').on('click', function(e) {
                if (confirm('Do you want to delete this order ?')) {
                    $.ajax({
                        type: 'DELETE',
                        url: '{{ route('admin.order.delete', ['id' => '']) }}' + '/' + $(this)
                            .attr('data-id'),
                        headers: {
                            'X-CSRF-TOKEN': '{!! csrf_token() !!}'
                        },

                        success: function(data) {
                            if (data.status == 201) {
                                window.location.reload(true);
                            } else {
                                alert(
                                    'Something went wrong, please try again or contact for support !'
                                );
                            }
                        }
                    });
                }
            });
        });
    </script>
@endpush
