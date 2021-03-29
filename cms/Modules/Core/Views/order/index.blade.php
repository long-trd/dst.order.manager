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
                        <a href="{{route('admin.account.create')}}" class="btn btn-success text-white">Create</a>
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
                        <h3 class="mb-0">Orders on {{$account->ip_address}}</h3>
                    </div>
                    <!-- Light table -->
                    <div class="table-responsive">
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                            <tr>
                                <th scope="col" class="sort" data-sort="no">No</th>
                                <th scope="col" class="sort" data-sort="shipper">Shipper</th>
                                <th scope="col" class="sort" data-sort="helper">Helper</th>
                                <th scope="col" class="sort" data-sort="name">Name</th>
                                <th scope="col" class="sort" data-sort="ebay_url">Ebay URL</th>
                                <th scope="col" class="sort" data-sort="product_url">Product URL</th>
                                <th scope="col" class="sort" data-sort="status">Status</th>
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
                            @foreach($orders as $order)
                                <tr class="list-account" data-account="{{$order->id}}">
                                    <th scope="row">
                                        <div class="media align-items-center">
                                            <div class="media-body">
                                                <span class="name mb-0 text-sm">{{$order->id}}</span>
                                            </div>
                                        </div>
                                    </th>
                                    <td class="budget">
                                        {{$order->shipper->name}}
                                    </td>
                                    <td class="budget">
                                        {{isset($account->helper->name) ? $account->helper->name : ''}}
                                    </td>
                                    <td>
                                        <span class="badge badge-dot mr-4">
                                            <i class=""></i>
                                            <span class="status">{{$order->status}}</span>
                                        </span>
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
                                        {{$order->price}}
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
                                        <td>
                                            <div class="avatar-group">
                                                <span class="name mb-0 text-sm">{{$order->paypal_notes}}</span>
                                            </div>
                                        </td>
                                    @endif
                                    <td class="text-right">
                                        <div class="dropdown">
                                            <a class="btn btn-sm btn-icon-only text-light" href="#" role="button"
                                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                <a class="dropdown-item list-account-dropdown"
                                                   href="{{route('admin.order.edit', ['id' => $order->id])}}">Edit</a>
                                                <a class="dropdown-item list-account-dropdown delete-account"
                                                   href="#" data-id="{{$order->id}}">Delete</a>
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
    </div>
@endsection
@push('js')
    <script type="text/javascript">
        $(document).ready(function () {
            {{--$('.delete-account').on('click', function (e) {--}}
                {{--if (confirm('Do you want to delete this account ?')) {--}}
                    {{--$.ajax({--}}
                        {{--type: 'DELETE',--}}
                        {{--url: '{{ route('admin.account.delete', ['id' => ''])}}' + '/' + $(this).attr('data-id'),--}}
                        {{--headers: {--}}
                            {{--'X-CSRF-TOKEN': '{!! csrf_token() !!}'--}}
                        {{--},--}}

                        {{--success: function (data) {--}}
                            {{--if (data.status == 201) {--}}
                                {{--window.location.reload(true);--}}
                            {{--} else {--}}
                                {{--alert('Something went wrong, please try again or contact for support !');--}}
                            {{--}--}}
                        {{--}--}}
                    {{--});--}}
                {{--}--}}
            {{--});--}}
        });
    </script>
@endpush