@extends('Core::layouts.app')

@section('content')
    <div class="header bg-primary pb-6">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-center py-4 nav-bar-height position-relative">
                    <div class="btn-search left-element">
                        <a href="{{route('admin.notification.create')}}" class="btn btn-success text-white">Create</a>
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
                        <h3 class="mb-0">Notifications</h3>
                    </div>
                    <!-- Light table -->
                    <div class="table-responsive">
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                            <tr>
                                <th scope="col" class="sort" data-sort="no">No</th>
                                <th scope="col" class="sort" data-sort="name">Content</th>
                                <th scope="col" class="sort" data-sort="email">Start Date</th>
                                <th scope="col" class="sort" data-sort="role">End Date</th>
                                <th scope="col" class="sort" data-sort="role">Created At</th>
                                <th scope="col"></th>
                            </tr>
                            </thead>
                            <tbody class="list">
                            @foreach($notifications as $notification)
                                <tr data-notification="{{ $notification->id }}">
                                    <th scope="row" class="budget">
                                        <div class="media align-items-center">
                                            <div class="media-body">
                                                <span class="name mb-0 text-sm">{{ $notification->id }}</span>
                                            </div>
                                        </div>
                                    </th>
                                    <td class="budget">
                                        {{ $notification->content }}
                                    </td>
                                    <td class="budget">
                                            {{ $notification->start_date }}
                                    </td>
                                    <td class="budget">
                                        {{ $notification->end_date }}
                                    </td>
                                    <td class="budget">
                                        {{ $notification->created_at }}
                                    </td>
                                    <td class="text-right budget">
                                        <div class="dropdown">
                                            <a class="btn btn-sm btn-icon-only text-light" href="#" role="button"
                                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                <a class="dropdown-item list-account-dropdown"
                                                   href="{{route('admin.notification.edit', ['id' => $notification->id])}}">Edit</a>
                                                <a class="dropdown-item list-account-dropdown delete-notification"
                                                   href="#" data-id="{{$notification->id}}">Delete</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- Card footer -->
                    <div class="card-footer py-4 position-relative">
                        {!! $notifications->links() !!}
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
        $(document).ready(function () {
            $('.delete-notification').on('click', function (e) {
                if (confirm('Do you want to delete this notification ?')) {
                    $.ajax({
                        type: 'DELETE',
                        url: '{{ route('admin.notification.delete', ['id' => ''])}}' + '/' + $(this).attr('data-id'),
                        headers: {
                            'X-CSRF-TOKEN': '{!! csrf_token() !!}'
                        },

                        success: function (data) {
                            if (data.status == 201) {
                                window.location.reload(true);
                            } else {
                                alert('Something went wrong, please try again or contact for support !');
                            }
                        }
                    });
                }
            });
        });
    </script>
@endpush
