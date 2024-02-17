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
                        <h3 class="mb-0">Edit Site</h3>
                    </div>
                    <!-- Light table -->
                    <div class="table-responsive">
                        <form method="post" action="{{ route('admin.site.update', ['id' => $site->id]) }}" autocomplete="off">
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
                            <div class="pl-lg-4 pd-left-25" id="form-group-wrapper">
                                <div class="form-group">
                                    <label class="form-control-label" for="input-name">{{ __('Name') }}</label>
                                    <input type="text" name="name" id="input-name"
                                           class="form-control form-control-alternative w-90" value="{{ old('name', $site->name) }}" required>

                                </div>
                                @if(auth()->user()->hasRole('admin'))
                                <div class="form-group">
                                    <label class="form-control-label" for="input-user">{{ __('User') }}</label>
                                    <select class="form-control order-status w-50" id="input-user" data-toggle="select" data-live-search="true" name="user_id">
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}" {{ old('user_id', $site->user_id) == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @else
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-user">{{ __('User') }}</label>
                                        <select class="form-control order-status w-50" id="input-user" data-toggle="select" data-live-search="true" name="user_id">
                                            <option value="{{ auth()->id() }}" selected>{{ auth()->user()->name }}</option>
                                        </select>
                                    </div>
                                @endif
                                <div class="form-group">
                                    <label class="form-control-label" for="input-status">{{ __('Status') }}</label>
                                    <select class="form-control order-status w-50" id="input-status" data-toggle="select" data-live-search="true" name="status">
                                        <option {{ old('status', $site->status) == 'live' ? 'selected' : '' }} value="live">Live</option>
                                        <option {{ old('status', $site->status) == 'die' ? 'selected' : '' }} value="die">Die</option>
                                        <option {{ old('status', $site->status) == 'pause' ? 'selected' : '' }} value="pause">Pause</option>
                                    </select>
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
