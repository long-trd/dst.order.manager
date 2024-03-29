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
                        <h3 class="mb-0">Create order</h3>
                    </div>
                    <!-- Light table -->
                    <div class="table-responsive">
                        <form method="post" action="{{ route('admin.order.create')}}" autocomplete="off">
                            @csrf

                            @if (count($errors) > 0)
                                <div class="alert alert-danger alert-dismissible fade show alert-missing-info" role="alert">
                                    <label class="form-control-label text-center text-white w-50">{{ __('Invalid data !!!') }}</label>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif

                            <div class="alert alert-warning alert-dismissible fade show alert-notice" role="alert">
                                <label class="form-control-label text-center text-white w-50">{{ __('NOTICE') }}</label><br>
                                <label class="form-control-label text-center text-white w-50">{{ __('If you set this order with tracking or shipped status, the tracking field can not be empty.') }}</label>
                                <label class="form-control-label text-center text-white w-50">{{ __('The account ip must be registered and belongs to you.') }}</label>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>


                            <div class="pl-lg-4 pd-left-25">
                                <div class="form-group">
                                    <label class="form-control-label" for="input-name">{{ __('Shipper') }}</label>
                                    @foreach($shippers as $key => $shipper)
                                        <div class="custom-control custom-radio mb-3">
                                            <input required name="shipping_user_id" value="{{$shipper->id}}" class="custom-control-input" id="shipper-{{$key}}" type="radio">
                                            <label class="custom-control-label" for="shipper-{{$key}}">{{$shipper->name}}</label>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label" for="input-name">{{ __('Account IP') }}</label>
                                    <select class="form-control order-status w-25" data-toggle="select" data-live-search="true" name="account_ip">
                                        @foreach($accounts as $account)
                                            <option value="{{$account->ip_address}}">{{$account->ip_address}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label" for="input-name">{{ __('Site') }}</label>
                                    <select class="form-control order-status w-25" data-toggle="select" data-live-search="true" name="site_id">
                                        @foreach($sites as $site)
                                            <option value="{{$site->id}}">{{$site->name .' - '. $site->status}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label" for="input-name">{{ __('Network') }}</label>
                                    <select class="form-control order-status w-25" data-toggle="select" data-live-search="true" name="network">
                                        <option value="">--Network--</option>
                                        <option value="tiktok">Tiktok</option>
                                        <option value="facebook">Facebook</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label" for="input-name">{{ __('Info') }}</label>
                                    <input type="text" name="name" class="form-control form-control-alternative w-90" required>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label" for="input-email">{{ __('Ebay URL') }}</label>
                                    <input type="url" name="ebay_url" class="form-control form-control-alternative w-90" required>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label" for="input-email">{{ __('Product URL') }}</label>
                                    <input type="url" name="product_url" class="form-control form-control-alternative w-90" required>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label" for="input-email">{{ __('Status') }}</label>
                                    <div class="custom-control custom-radio mb-3">
                                        <input name="status" class="custom-control-input" value="new" id="customRadio1" type="radio">
                                        <label class="custom-control-label" for="customRadio1">New</label>
                                    </div>
                                    <div class="custom-control custom-radio mb-3">
                                        <input name="status" class="custom-control-input" value="processing" id="customRadio2" type="radio">
                                        <label class="custom-control-label" for="customRadio2">Processing</label>
                                    </div>
                                    <div class="custom-control custom-radio mb-3">
                                        <input name="status" class="custom-control-input" value="needhelp" id="customRadio3" type="radio">
                                        <label class="custom-control-label" for="customRadio3">Needhelp</label>
                                    </div>
                                    <div class="custom-control custom-radio mb-3">
                                        <input name="status" class="custom-control-input" value="cancel" id="customRadio4" type="radio">
                                        <label class="custom-control-label" for="customRadio4">Cancel</label>
                                    </div>
                                    <div class="custom-control custom-radio mb-3">
                                        <input name="status" class="custom-control-input" value="tracking" id="customRadio5" type="radio">
                                        <label class="custom-control-label" for="customRadio5">Tracking</label>
                                    </div>
                                    <div class="custom-control custom-radio mb-3">
                                        <input name="status" class="custom-control-input" value="shipped" id="customRadio6" type="radio">
                                        <label class="custom-control-label" for="customRadio6">Shipped</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label" for="input-email">{{ __('Shipping Information') }}</label>
                                    <textarea name="shipping_information" class="form-control w-90" rows="3" required></textarea>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label" for="input-email">{{ __('Price') }}</label>
                                    <input type="number" name="price" class="form-control form-control-alternative w-25" required>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label" for="input-email">{{ __('Quantity') }}</label>
                                    <input type="number" name="quantity" class="form-control form-control-alternative w-25" required>
                                </div>
                                <div class="form-group">
                                    <div class="input-group input-group-alternative w-25">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>
                                        </div>
                                        <input class="form-control datepicker" placeholder="Select date" type="text" name="order_date" value="" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label" for="input-email">{{ __('Customer Notes') }}</label>
                                    <textarea name="customer_notes" class="form-control w-90" rows="3" required></textarea>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label" for="input-email">{{ __('Tracking') }}</label>
                                    <textarea name="tracking" class="form-control w-90" rows="3"></textarea>
                                </div>
                                @if(auth()->user()->hasRole('admin'))
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-email">{{ __('Paypal Notes') }}</label>
                                        <textarea name="paypal_notes" class="form-control w-90" id="exampleFormControlTextarea1" rows="3"></textarea>
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
