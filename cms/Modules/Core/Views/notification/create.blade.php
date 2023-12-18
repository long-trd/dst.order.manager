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
    <!-- Page content -->
    <div class="container-fluid mt--6">
        <div class="row">
            <div class="col">
                <div class="card">
                    <!-- Card header -->
                    <div class="card-header border-0">
                        <h3 class="mb-0">Create Notification</h3>
                    </div>
                    <!-- Light table -->
                    <div class="table-responsive">
                        <form method="post" action="{{ route('admin.notification.store') }}" autocomplete="off">
                            @csrf
                            @if (count($errors) > 0)
                                <div class="alert alert-danger alert-dismissible fade show alert-missing-info"
                                     role="alert">
                                    {{ session('status') }}
                                    <label
                                        class="form-control-label text-center text-white w-50">{{ __($errors->first()) }}</label>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif
                            <div class="pl-lg-4 pd-left-25" id="form-group-wrapper">
                                <div class="form-group">
                                    <label class="form-control-label" for="content">{{ __('Content') }}</label>
                                    <textarea type="text" name="content" id="content" class="form-control form-control-alternative w-90" required>{{ old('content') }}</textarea>

                                </div>
                                <div class="form-group">
                                    <label class="form-control-label" for="start_date">{{ __('Start Date') }}</label>
                                    <input type="date" name="start_date" id="start_date"
                                           class="form-control form-control-alternative w-90" value="{{ old('start_date') }}" required>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label" for="end_date">{{ __('End Date') }}</label>
                                    <input type="date" name="end_date" id="end_date"
                                           class="form-control form-control-alternative w-90" value="{{ old('end_date') }}" required>
                                </div>
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
