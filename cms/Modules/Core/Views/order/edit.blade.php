@extends('Core::layouts.app')

@section('content')
    <!-- Topnav -->
    <!-- Header -->
    <!-- Header -->
    <div class="header bg-primary pb-6">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-center py-4 nav-bar-height position-relative">
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
                        <h3 class="mb-0">Edit order</h3>
                    </div>
                    <!-- Light table -->
                    <div class="table-responsive">
                        <form method="post" action="{{ route('admin.order.update', ['id' => $order->id])}}" autocomplete="off">
                            @csrf
                            @method('PUT')

                            @if (count($errors) > 0)
                                <div class="alert alert-danger alert-dismissible fade show alert-missing-info" role="alert">
                                    <label class="form-control-label text-center text-white w-50">{{ __('Missing information !!!') }}</label>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif

                            @if(\Illuminate\Support\Facades\Session::has('success'))
                                <div class="alert alert-success alert-dismissible fade show alert-missing-info" role="alert">
                                    <label class="form-control-label text-center text-white w-50">{{ __('Update successful !!!') }}</label>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif

                            <div class="alert alert-warning alert-dismissible fade show alert-notice" role="alert">
                                <label class="form-control-label text-center text-white w-50">{{ __('NOTICE') }}</label><br>
                                <label class="form-control-label text-center text-white w-50">{{ __('If you set this order with tracking or shipped status, the tracking field can not be empty') }}</label>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>


                            <div class="pl-lg-4 pd-left-25">
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
                                    <label class="form-control-label" for="input-name">{{ __('Info') }}</label>
                                    <input type="text" name="name" value="{{$order->name}}" class="form-control form-control-alternative w-90" required autofocus>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label" for="input-email">{{ __('Ebay URL') }}</label>
                                    <input type="url" name="ebay_url" value="{{$order->ebay_url}}" class="form-control form-control-alternative w-90" required>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label" for="input-email">{{ __('Product URL') }}</label>
                                    <input type="url" name="product_url" value="{{$order->product_url}}" class="form-control form-control-alternative w-90" required>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label" for="input-email">{{ __('Status') }}</label>
                                    <div class="custom-control custom-radio mb-3">
                                        <input name="status" class="custom-control-input" value="new" id="customRadio1" type="radio"
                                            {{$order->status == 'new' ? 'checked' : '' }}
                                        >
                                        <label class="custom-control-label" for="customRadio1">New</label>
                                    </div>
                                    <div class="custom-control custom-radio mb-3">
                                        <input name="status" class="custom-control-input" value="processing" id="customRadio2" type="radio"
                                            {{$order->status == 'processing' ? 'checked' : '' }}
                                        >
                                        <label class="custom-control-label" for="customRadio2">Processing</label>
                                    </div>
                                    <div class="custom-control custom-radio mb-3">
                                        <input name="status" class="custom-control-input" value="needhelp" id="customRadio3" type="radio"
                                            {{$order->status == 'needhelp' ? 'checked' : '' }}
                                        >
                                        <label class="custom-control-label" for="customRadio3">Needhelp</label>
                                    </div>
                                    <div class="custom-control custom-radio mb-3">
                                        <input name="status" class="custom-control-input" value="cancel" id="customRadio4" type="radio"
                                            {{$order->status == 'cancel' ? 'checked' : '' }}
                                        >
                                        <label class="custom-control-label" for="customRadio4">Cancel</label>
                                    </div>
                                    <div class="custom-control custom-radio mb-3">
                                        <input name="status" class="custom-control-input" value="tracking" id="customRadio5" type="radio"
                                            {{$order->status == 'tracking' ? 'checked' : '' }}
                                        >
                                        <label class="custom-control-label" for="customRadio5">Tracking</label>
                                    </div>
                                    <div class="custom-control custom-radio mb-3">
                                        <input name="status" class="custom-control-input" value="shipped" id="customRadio6" type="radio"
                                            {{$order->status == 'shipped' ? 'checked' : '' }}
                                        >
                                        <label class="custom-control-label" for="customRadio6">Shipped</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label" for="input-email">{{ __('Shipping Information') }}</label>
                                    <textarea name="shipping_information" class="form-control w-90" rows="3" required>{{$order->shipping_information}}</textarea>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label" for="input-email">{{ __('Price') }}</label>
                                    <input type="number" name="price" value="{{$order->price}}" class="form-control form-control-alternative w-25" required>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label" for="input-email">{{ __('Quantity') }}</label>
                                    <input type="number" name="quantity" value="{{$order->quantity}}" class="form-control form-control-alternative w-25" required>
                                </div>
                                <div class="form-group">
                                    <div class="input-group input-group-alternative w-25">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>
                                        </div>
                                        <input class="form-control datepicker" placeholder="Select date" type="text" name="order_date" value="{{cxl_carbon()::parse($order->order_date)->format('Y-m-d')}}" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label" for="input-email">{{ __('Customer Notes') }}</label>
                                    <textarea name="customer_notes" class="form-control w-90" rows="3" required>{{$order->customer_notes}}</textarea>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label" for="input-email">{{ __('Tracking') }}</label>
                                    <textarea name="tracking" class="form-control w-90" rows="3">{{$order->tracking}}</textarea>
                                </div>
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox mb-3">
                                        <input class="custom-control-input" id="customCheck1" type="checkbox" name="helping" value="1" {{$order->helper && count($order->helper) > 0 ? 'checked' : ''}}>
                                        <label class="custom-control-label" for="customCheck1">Helping</label>
                                    </div>
                                </div>
                                @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('shipper'))
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-email">{{ __('Notes') }}</label>
                                        <textarea name="paypal_notes" class="form-control w-90" id="exampleFormControlTextarea1" rows="3">{{$order->paypal_notes}}</textarea>
                                    </div>
                                @endif
                                <div class="text-center">
                                    <button type="submit" class="btn btn-success mt-4">{{ __('Save') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- Card footer -->
                    <div class="card-footer py-4 position-relative">
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
    </script>
@endpush
