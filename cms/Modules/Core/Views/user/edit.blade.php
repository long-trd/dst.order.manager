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
                        <h3 class="mb-0">Edit User</h3>
                    </div>
                    <!-- Light table -->
                    <div class="table-responsive">
                        <form method="post" action="{{ route('admin.user.update', ['id' => $user->id]) }}"
                              autocomplete="off">
                            @csrf
                            @method('put')

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


                            <div class="pl-lg-4 pd-left-25">
                                <div class="form-group">
                                    <label class="form-control-label" for="input-name">{{ __('Name') }}</label>
                                    <input type="text" name="name" id="input-name"
                                           class="form-control form-control-alternative w-90" value="{{$user->name}}"
                                           required>

                                </div>
                                <div class="form-group">
                                    <label class="form-control-label" for="input-email">{{ __('Email') }}</label>
                                    <input type="email" name="email" id="input-email"
                                           class="form-control form-control-alternative w-90" value="{{$user->email}}"
                                           required>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label" for="input-password">{{ __('Password') }}</label>
                                    <input type="password" name="password" id="input-password"
                                           class="form-control form-control-alternative w-90" value="" autocomplete>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label"
                                           for="input-password-confirmation">{{ __('Confirm Password') }}</label>
                                    <input type="password" name="password_confirmation" id="input-password-confirmation"
                                           class="form-control form-control-alternative w-90" value="" autocomplete>
                                </div>
                                <div class="form-group branch">
                                    <label class="form-control-label" for="branch">{{ __('Chi nhánh') }}</label>
                                    <input type="text" name="branch" id="branch"
                                           class="form-control form-control-alternative w-90"
                                           value="{{ $user->branch }}">
                                </div>
                                <div class="form-group manager">
                                    <label class="form-control-label" for="input-email">{{ __('Manager') }}</label>
                                    <div class="role-check">
                                        <label class="custom-toggle">
                                            <input type="checkbox" name="role[]" id="role-manager"
                                                   value="3" {{$user->hasRole('manager') ? 'checked' : ''}}>
                                            <span class="custom-toggle-slider rounded-circle"></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label" for="input-email">{{ __('Shipper') }}</label>
                                    <div class="role-check">
                                        <label class="custom-toggle">
                                            <input type="checkbox" name="role[]"
                                                   value="2" {{$user->hasRole('shipper') ? 'checked' : ''}}>
                                            <span class="custom-toggle-slider rounded-circle"></span>
                                        </label>
                                    </div>
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
@push('js')
{{--    <script type="text/javascript">--}}
        {{--$(function () {--}}
        {{--    $('#role-manager').on('change', function () {--}}
        {{--        if($('#role-manager').is(':checked')) {--}}
        {{--            const html = `<div class="form-group branch">--}}
        {{--                            <label class="form-control-label" for="branch">{{ __('Chi nhánh') }}</label>--}}
        {{--                            <input type="text" name="branch" id="branch" class="form-control form-control-alternative w-90" value="" autocomplete>--}}
        {{--                          </div>`;--}}
        {{--            $(html).insertBefore('.manager');--}}
        {{--        } else {--}}
        {{--            $('.branch').remove();--}}
        {{--        }--}}
        {{--    })--}}
        {{--})--}}
{{--    </script>--}}
@endpush
