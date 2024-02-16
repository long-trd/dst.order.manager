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
                            <h3 class="mb-0">{{ __('Create New Prize') }}</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="post" class="item-form" action="{{ route('admin.prize.store') }}" autocomplete="off" enctype="multipart/form-data">
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
                                    <input type="text" name="text" id="text" value="{{ old('text') }}" class="form-control" placeholder="Name">
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label">{{ __('Image') }}</label>
                                    <input type="file" name="img" id="img"
                                           class="form-control mt-3" placeholder="Ảnh mặt trước">
                                    <img class="img-thumbnail mt-3 d-none" width="20%"
                                         src=""
                                         alt=""/>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label" for="name">{{ __('Unit') }}</label>
                                    <input type="text" name="unit" id="unit" value="{{ old('unit') }}" class="form-control" placeholder="Unit">
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label" for="name">{{ __('Percentage') }}</label>
                                    <input type="number" name="percentage" id="percentage" value="{{ old('percentage') }}" class="form-control" placeholder="Percentage">
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label" for="name">{{ __('Number') }}</label>
                                    <input type="number" name="number" id="number" value="{{ old('number') }}" class="form-control" placeholder="Number">
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label">{{ __('Event') }}</label>
                                    <select class="form-control des_project_progress" name="wheel_event_id"
                                            data-toggle="select" title="status"
                                            data-minimum-results-for-search="Infinity"
                                            data-placeholder="Select Status">
                                        @foreach ($wheelEvents as $wheelEvent)
                                            <option
                                                value="{{ $wheelEvent->id }}"
                                                {{ $wheelEvent->id == old('wheel_event_id') ? "selected" : "" }}>{{ __($wheelEvent->name) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="text-center">
                                    <a href="{{ route('admin.prize.index') }}" class="btn btn-info mt-4 text-white">{{ __('Back') }}</a>
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
@push('js')
    <script>
        $('#img').on('change', function (e) {
            file = e.target.files;
            _fileReader = new FileReader();
            _fileReader.readAsDataURL(file[0]);
            _fileReader.onload = function (e) {
                $('.img-thumbnail').removeClass('d-none');
                $('.img-thumbnail').attr('src', e.target.result);
            }
        });
    </script>
@endpush
