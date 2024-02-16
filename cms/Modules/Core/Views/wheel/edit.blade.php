@extends('Core::layouts.app')

@section('content')
    <div class="header bg-primary pb-6">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-center py-4 nav-bar-height position-relative">
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid mt--6">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <h3 class="mb-0">{{ __('Edit New Wheel event') }}</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="post" class="item-form" action="{{ route('admin.wheel.update', ['id' => $wheelEvent->id]) }}" autocomplete="off">
                            @csrf
                            @if (count($errors) > 0)
                                <div class="alert alert-danger alert-dismissible fade show alert-missing-info"
                                     role="alert">
                                    {{ session('status') }}
                                    <label
                                        class="form-control-label text-center text-white w-50">{{ __('Missing information !!!') }}</label>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif
                            <div class="create-form">
                                <div class="form-group">
                                    <label class="form-control-label" for="name">{{ __('Name') }}</label>
                                    <input type="text" name="name" value="{{ old('name', $wheelEvent->name) }}" id="name" class="form-control" placeholder="Name">
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label" for="active_date">{{ __('Active Date') }}</label>
                                    <input type="text" name="active_date"
                                           class="form-control datepicker" data-date-format="dd-mm-yyyy"
                                           placeholder="Active Date"
                                           value="{{ old('active_date', $wheelEvent->active_date) && strtotime(old('active_date', $wheelEvent->active_date)) ? \Carbon\Carbon::parse(old('active_date', $wheelEvent->active_date))->format('d-m-Y') : '' }}"
                                           id="active_date"
                                    >
                                </div>
                                <div class="text-center">
                                    <a href="{{ route('admin.wheel.index') }}" class="btn btn-info mt-4 text-white">{{ __('Back') }}</a>
                                    <button type="submit" class="btn btn-success mt-4">{{ __('Save') }}</button>
                                </div>
                            </div>
                        </form>
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
