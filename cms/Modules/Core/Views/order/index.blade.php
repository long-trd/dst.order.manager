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
                        <a href="{{route('admin.order.create')}}" class="btn btn-success text-white">Create</a>
                        <button class="btn btn-info text-white" data-toggle="modal" data-target="#modal-form">Search</button>
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
                                <th scope="col" class="sort" data-sort="status">Status</th>
                                <th scope="col" class="sort" data-sort="manager">Manager</th>
                                <th scope="col" class="sort" data-sort="shipper">Shipper</th>
                                <th scope="col" class="sort" data-sort="helper">Helper</th>
                                <th scope="col" class="sort" data-sort="name">Info</th>
                                <th scope="col" class="sort" data-sort="ebay_url">Ebay URL</th>
                                <th scope="col" class="sort" data-sort="product_url">Product URL</th>
                                <th scope="col" class="sort" data-sort="shipping_infomation">Shipping Infomation</th>
                                <th scope="col" class="sort" data-sort="price">Price</th>
                                <th scope="col" class="sort" data-sort="quantity">Quantity</th>
                                <th scope="col" class="sort" data-sort="order_date">Order Date</th>
                                <th scope="col" class="sort" data-sort="customer_notes">Customer Notes</th>
                                <th scope="col" class="sort" data-sort="tracking">Tracking</th>
                                @if(auth()->user()->hasRole('admin'))
                                    <th scope="col" class="sort" data-sort="paypal-notes">Paypal Notes</th>
                                @endif
                                <th scope="col"></th>
                            </tr>
                            </thead>
                            <tbody class="list">
                            @foreach($orders as $key => $order)
                                <tr class="order-{{$order->status}} right-click" data-order="{{$order->order_id}}">
                                    <th scope="row" class="budget">
                                        <div class="media align-items-center">
                                            <div class="media-body">
                                                <span class="name mb-0 text-sm">{{$key + 1}}</span>
                                            </div>
                                        </div>
                                    </th>
                                    <td class="budget">
                                        <span class="badge badge-dot mr-4">
                                            <i class="
                                                @if($order->status == 'new')
                                                    bg-secondary
                                                @elseif ($order->status == 'processing')
                                                    bg-primary
                                                @elseif ($order->status == 'needhelp')
                                                    bg-warning
                                                @elseif ($order->status == 'cancel')
                                                    bg-danger
                                                @elseif ($order->status == 'tracking')
                                                    bg-info
                                                @elseif ($order->status == 'shipped')
                                                    bg-success
                                                @endif
                                            "></i>
                                            <span class="status">{{$order->status}}</span>
                                        </span>
                                    </td>
                                    <td class="budget">
                                        {{isset($order->manager->name) ? $order->manager->name : ''}}
                                    </td>
                                    <td class="budget">
                                        {{isset($order->shipper->name) ? $order->shipper->name : ''}}
                                    </td>
                                    <td class="budget">
                                        {{isset($order->helper->name) ? $order->helper->name : ''}}
                                    </td>
                                    <td class="budget">
                                        {{$order->name}}
                                    </td>
                                    <td class="budget">
                                        {{$order->ebay_url}}
                                    </td>
                                    <td class="budget">
                                        {{$order->product_url}}
                                    </td>
                                    <td class="budget">
                                        {{$order->shipping_information}}
                                    </td>
                                    <td class="budget">
                                        {{$order->price.'$'}}
                                    </td>
                                    <td class="budget">
                                        {{$order->quantity}}
                                    </td>
                                    <td class="budget">
                                        {{$order->order_date}}
                                    </td>
                                    <td class="budget">
                                        {{$order->customer_notes}}
                                    </td>
                                    <td class="budget">
                                        {{$order->tracking}}
                                    </td>
                                    @if(auth()->user()->hasRole('admin'))
                                        <td class="budget">
                                            <div class="avatar-group">
                                                <span class="name mb-0 text-sm">{{$order->paypal_notes}}</span>
                                            </div>
                                        </td>
                                    @endif
                                    <td class="text-right budget">
                                        <div class="dropdown">
                                            <a class="btn btn-sm btn-icon-only text-light" href="#" role="button"
                                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                <a class="dropdown-item list-account-dropdown"
                                                   href="{{route('admin.order.edit', ['id' => $order->order_id])}}">Edit</a>
                                                @if(auth()->user()->hasRole('admin'))
                                                    <a class="dropdown-item list-account-dropdown delete-order"
                                                       href="#" data-id="{{$order->order_id}}">Delete</a>
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
                        <div class="total-price">{{'Total: '. $totalPrice . '$'}}</div>
                        {!! $orders->links() !!}
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
                <div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
                    <div class="modal-dialog modal- modal-dialog-centered modal-sm" role="document">
                        <div class="modal-content">
                            <div class="modal-body p-0">
                                <div class="card bg-secondary shadow border-0">
                                    <div class="card-body px-lg-5 py-lg-5">
                                        <form role="form" action="{{route('admin.order.index')}}" method="GET">
                                            @csrf
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" name="random-search" placeholder="Search something..."
                                                               value="{{isset($request['random-search']) ? $request['random-search'] : ''}}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <select class="form-control order-status" data-toggle="select" title="Simple select" data-live-search="true" name="status">
                                                            <option value="default">--Status--</option>
                                                            <option value="new" {{isset($request['status']) && $request['status'] == 'new' ? 'selected' : ''}}>New</option>
                                                            <option value="processing" {{isset($request['status']) && $request['status'] == 'processing' ? 'selected' : ''}}>Processing</option>
                                                            <option value="needhelp" {{isset($request['status']) && $request['status'] == 'needhelp' ? 'selected' : ''}}>Needhelp</option>
                                                            <option value="cancel" {{isset($request['status']) && $request['status'] == 'cancel' ? 'selected' : ''}}>Cancel</option>
                                                            <option value="tracking" {{isset($request['status']) && $request['status'] == 'tracking' ? 'selected' : ''}}>Tracking</option>
                                                            <option value="shipped" {{isset($request['status']) && $request['status'] == 'shipped' ? 'selected' : ''}}>Shipped</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <select class="form-control order-account" data-toggle="select" title="Simple select" data-live-search="true" name="account">
                                                            <option value="default">--Ip Address--</option>
                                                            @foreach($accounts as $account)
                                                                <option value="{{$account->id}}" {{isset($request['account']) && $request['account'] == $account->id ? 'selected' : ''}}>{{$account->ip_address}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" name="shipper" placeholder="Shipper name"
                                                               value="{{isset($request['shipper']) ? $request['shipper'] : ''}}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" name="manager" placeholder="List name"
                                                               value="{{isset($request['manager']) ? $request['manager'] : ''}}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="input-group input-group-alternative">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>
                                                        </div>
                                                        <input class="form-control datepicker" placeholder="Start date" type="text" name="start_date" value="{{isset($request['start_date']) ? $request['start_date'] : ''}}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="input-group input-group-alternative">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>
                                                        </div>
                                                        <input class="form-control datepicker" placeholder="End date" type="text" name="end_date" value="{{isset($request['end_date']) ? $request['end_date'] : ''}}">
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
    </div>
@endsection
@push('js')
    <script type="text/javascript">
        $(document).ready(function () {
            @if($errors->has('shipper'))
                    alert("Don't have any shipper !!!");
            @endif

            $('.order-status, .order-account').on('change', function () {
                var option = $(this).find('option:first');
                if (this.value == 'default') {
                    $(option).attr('disabled', 'disabled');
                } else {
                    $(option).removeAttr('disabled');
                }
            });

            $('.right-click').dblclick(function () {
                window.location = `{{route('admin.order.edit', ['id' => ''])}}/${$(this).attr('data-order')}`;
            });

            $('.delete-order').on('click', function (e) {
                if (confirm('Do you want to delete this order ?')) {
                    $.ajax({
                        type: 'DELETE',
                        url: '{{ route('admin.order.delete', ['id' => ''])}}' + '/' + $(this).attr('data-id'),
                        headers: {
                            'X-CSRF-TOKEN': '{!! csrf_token() !!}'
                        },

                        success: function (data) {
                            if (data.status == 201) {
                                window.location.reload(true);
                            } else {
                                alert('Something went wrong, please try again or contact for support !');
                            }
                        }
                    });
                }
            });
        });
    </script>
@endpush