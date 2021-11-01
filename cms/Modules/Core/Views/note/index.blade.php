@extends('Core::layouts.app')

@push('style')
    <link href="{{cxl_asset('assets/libs/ckeditor/config-ckeditor.js')}}"/>
@endpush

@section('content')
    <div class="header bg-primary pb-6">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-center py-4 nav-bar-height position-relative">
                    <div class="btn-search left-element">
                        <a href="javascript:void(0)" class="btn btn-success text-white" id="save-form">Save</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid mt--6">
        <div class="row">
            <div class="col">
                <div class="card">
                    <!-- Card header -->
                    <div class="card-header border-0">
                        <h3 class="mb-0">Notes</h3>
                    </div>
                    <div class="card-body">
                        <form id="note-form" action="{{ route('admin.note.update') }}" method="POST">
                            @csrf
                            @method('PUT')
                            <textarea class="form-control textarea" id="textarea" rows="3" placeholder="Note" name="notes"> {!! auth()->user()->notes !!}</textarea>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{cxl_asset('assets/libs/ckeditor/ckeditor.js')}}"></script>
    <script>
        $(document).ready(function () {
            let saveFormBtn = $('#save-form');
            let noteForm = $('#note-form');

            CKEDITOR.replace('textarea', {
                height: '400px'
            });

            saveFormBtn.on('click', function () {
                noteForm.submit();
            });
        });
    </script>
@endpush
