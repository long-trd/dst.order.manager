@extends('Core::layouts.app')
@section('content')
    <div class="header bg-primary pb-6">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-center py-4 nav-bar-height position-relative">
                    <div class="btn-search left-element">
                        <a href="{{ route('admin.site.create') }}" class="btn btn-success text-white">Create</a>
                        <button class="btn btn-info text-white" data-toggle="modal" data-target="#modal-form">Search
                        </button>
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
                        <h3 class="mb-0">Sites</h3>
                    </div>
                    <!-- Light table -->
                    <div class="table-responsive">
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                            <tr>
                                <th scope="col" class="sort" data-sort="no">No</th>
                                <th scope="col" class="sort" data-sort="account_ip">Name</th>
                                <th scope="col" class="sort" data-sort="status">User</th>
                                <th scope="col" class="sort" data-sort="manager">Status</th>
                                <th scope="col" class="sort" data-sort="manager">Created at</th>
                                <th scope="col" class="sort" data-sort="manager">Updated at</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody class="list">
                            @foreach ($sites as $key => $site)
                                <tr>
                                    <th scope="row" class="budget" style="height: 100px">
                                        <div class="media align-items-center">
                                            <div class="media-body">
                                                <span class="name mb-0 text-sm">{{ $site->id }}</span>
                                            </div>
                                        </div>
                                    </th>
                                    <td class="budget">
                                        {{ $site->name }}
                                    </td>
                                    <td class="budget">
                                        {{ $site->user->name }}
                                    </td>
                                    <td class="budget">
                                        <span class="badge badge-dot mr-4">
                                            <i
                                                    class="
                                                @if ($site->status == 'live') bg-success
                                                @elseif ($site->status == 'pause')
                                                    bg-primary
                                                @elseif ($site->status == 'die')
                                                    bg-danger
                                                @endif
                                            ">
                                            </i>
                                            <span class="status">{{ $site->status }}</span>
                                        </span>
                                    </td>
                                    <td class="budget">
                                        {{ $site->created_at }}
                                    </td>
                                    <td class="budget">
                                        {{ $site->updated_at }}
                                    </td>
                                    <td class="text-right budget">
                                        <div class="dropdown">
                                            <a class="btn btn-sm btn-icon-only text-light" href="#" role="button"
                                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                @if(auth()->user()->hasRole('admin') || auth()->id() == $site->user_id)
                                                    <a class="dropdown-item list-account-dropdown"
                                                       href="{{route('admin.site.edit', ['id' => $site->id])}}">Edit</a>
                                                @endif
                                                @if(auth()->user()->hasRole('admin'))
                                                    <a class="dropdown-item list-account-dropdown delete-site"
                                                       href="#" data-id="{{ $site->id }}">Delete</a>
                                                    <a class="dropdown-item list-account-dropdown log-site"
                                                       data-toggle="modal" data-target="#logModal"
                                                       href="#" data-log="{{ json_encode($site->site_log->toArray()) }}">Logs</a>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer py-4 position-relative">
                        {!! $sites->appends(request()->query())->links() !!}
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
        <div class="row">
            <div class="col-md-4">
                <div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="modal-form"
                     aria-hidden="true">
                    <div class="modal-dialog modal- modal-dialog-centered modal-sm" role="document">
                        <div class="modal-content">
                            <div class="modal-body p-0">
                                <div class="card bg-secondary shadow border-0">
                                    <div class="card-body px-lg-5 py-lg-5">
                                        <form role="form" action="{{ route('admin.site.index') }}" method="GET">
                                            @csrf
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <input class="form-control" name="name"
                                                               value="{{ isset($request['name']) ? $request['name'] : '' }}"
                                                               placeholder="Name"/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <select class="form-control order-status" data-toggle="select"
                                                                title="Simple select" data-live-search="true"
                                                                name="status">
                                                            <option value="">--Status--</option>
                                                            <option
                                                                value="live" {{ isset($request['status']) && $request['status'] == 'live' ? 'selected' : '' }}>
                                                                Live
                                                            </option>
                                                            <option
                                                                value="die" {{ isset($request['status']) && $request['status'] == 'die' ? 'selected' : '' }}>
                                                                Die
                                                            </option>
                                                            <option
                                                                value="pause" {{ isset($request['status']) && $request['status'] == 'pause' ? 'selected' : '' }}>
                                                                Pause
                                                            </option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <select class="form-control order-account" data-toggle="select"
                                                                title="Simple select" data-live-search="true"
                                                                name="user">
                                                            <option value="">--User--</option>
                                                            @foreach ($users as $user)
                                                                <option value="{{ $user->id }}"
                                                                    {{ isset($request['user']) && $request['user'] == $user->id ? 'selected' : '' }}
                                                                >
                                                                    {{ $user->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="input-group input-group-alternative">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i
                                                                    class="ni ni-calendar-grid-58"></i></span>
                                                        </div>
                                                        <input class="form-control datepicker" placeholder="Start date"
                                                               type="text" name="start_date"
                                                               value="{{ isset($request['start_date']) ? $request['start_date'] : '' }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="input-group input-group-alternative">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i
                                                                    class="ni ni-calendar-grid-58"></i></span>
                                                        </div>
                                                        <input class="form-control datepicker" placeholder="End date"
                                                               type="text" name="end_date"
                                                               value="{{ isset($request['end_date']) ? $request['end_date'] : '' }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="text-center">
                                                <button type="submit" class="btn btn-primary my-4">Search</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="logModal" tabindex="-1" role="dialog" aria-labelledby="logModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="logModalLabel">Title</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <ul id="listLogs">

                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script type="text/javascript">
        $(document).ready(function () {
            $('.delete-site').on('click', function (e) {
                if (confirm('Do you want to delete this site ?')) {
                    $.ajax({
                        type: 'DELETE',
                        url: '{{ route('admin.site.delete', ['id' => '']) }}' + '/' + $(this)
                            .attr('data-id'),
                        headers: {
                            'X-CSRF-TOKEN': '{!! csrf_token() !!}'
                        },

                        success: function (data) {
                            if (data.status == 201) {
                                window.location.reload(true);
                            } else {
                                alert(
                                    'Something went wrong, please try again or contact for support !'
                                );
                            }
                        }
                    });
                }
            });
            $('.log-site').on('click', function () {
                let logs = JSON.parse($(this).attr('data-log'));
                $('#logModal #listLogs').empty();
                $.each(logs, function(index, item) {
                    let liElement = $('<li>').text(item.message).attr('data-id', item.id);
                    $('#listLogs').append(liElement);
                });
            });
        });
    </script>
@endpush
