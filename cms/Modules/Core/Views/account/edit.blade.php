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
                        <h3 class="mb-0">Edit account</h3>
                    </div>
                    <!-- Light table -->
                    <div class="table-responsive">
                        <form method="post" action="{{ route('admin.account.update', ['id' => $account->id]) }}" autocomplete="off">
                            @csrf
                            @method('put')

                            @if (count($errors) > 0)
                                <div class="alert alert-danger alert-dismissible fade show alert-missing-info" role="alert">
                                    {{ session('status') }}
                                    <label class="form-control-label text-center text-white w-50">{{ __('Missing information !!!') }}</label>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif


                            <div class="pl-lg-4 pd-left-25">
                                <div class="form-group">
                                    <label class="form-control-label" for="input-name">{{ __('Shipper') }}</label>
                                    @foreach($users as $key => $user)
                                        @if(!$user->hasRole('admin'))
                                            <div class="custom-control custom-checkbox mb-3">
                                                <input class="custom-control-input" id="customCheck{{$key}}" type="checkbox" name="shipper[]" value="{{$user->id}}"
                                                    @foreach($account->users as $userSelected)
                                                        {{$user->id == $userSelected->id ? 'checked' : ''}}
                                                    @endforeach
                                                >
                                                <label class="custom-control-label" for="customCheck{{$key}}">{{$user->name}}</label>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label" for="input-name">{{ __('Ip Address') }}</label>
                                    <input type="text" name="ip_address" id="input-name" class="form-control form-control-alternative w-90" value="{{$account->ip_address}}" required autofocus>

                                </div>
                                <div class="form-group">
                                    <label class="form-control-label" for="input-email">{{ __('Email') }}</label>
                                    <input type="email" name="email" id="input-email" class="form-control form-control-alternative w-90" value="{{$account->email}}" required>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label" for="input-email">{{ __('Status') }}</label>
                                    <div class="custom-control custom-radio mb-3">
                                        <input name="status" class="custom-control-input" value="live" id="customRadio5" type="radio" {{$account->status == 'live' ? 'checked' : ''}}>
                                        <label class="custom-control-label" for="customRadio5">Live</label>
                                    </div>
                                    <div class="custom-control custom-radio mb-3">
                                        <input name="status" class="custom-control-input" value="suspended" id="customRadio6" type="radio" {{$account->status == 'suspended' ? 'checked' : ''}}>
                                        <label class="custom-control-label" for="customRadio6">Suspended</label>
                                    </div>
                                    <div class="custom-control custom-radio mb-3">
                                        <input name="status" class="custom-control-input" value="restrict" id="customRadio7" type="radio" {{$account->status == 'restrict' ? 'checked' : ''}}>
                                        <label class="custom-control-label" for="customRadio7">Restrict</label>
                                    </div>
                                </div>
                                @if(auth()->user()->hasRole('admin'))
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-email">{{ __('Paypal Notes') }}</label>
                                        <textarea name="paypal_notes" class="form-control w-75" id="exampleFormControlTextarea1" rows="3">{{$account->paypal_notes}}</textarea>
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