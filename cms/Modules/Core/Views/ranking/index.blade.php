@extends('Core::layouts.app')
@section('content')
    <div class="header bg-primary pb-6">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-center py-4 nav-bar-height position-relative">
                    <div class="btn-search left-element">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 mb-5 mb-xl-0">
                <div class="card bg-gradient-default shadow">
                    <div class="card-header bg-transparent">
                        <div class="row align-items-center">
                            <div class="col">
                                <ul class="nav nav-pills justify-content-start">
                                    <li class="nav-item mr-2 mr-md-0">
                                        <a href="{{ request()->fullUrlWithQuery(['role' => 'manager', 'page' => 1]) }}"
                                           class="nav-link py-2 px-3 {{ !request('role') || request('role') == 'manager' ? 'active' : '' }}">
                                            <span class="d-none d-md-block">List</span>
                                            <span class="d-md-none">L</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ request()->fullUrlWithQuery(['role' => 'shipper', 'page' => 1]) }} "
                                           class="nav-link py-2 px-3 {{ request('role') == 'shipper' ? 'active' : '' }}">
                                            <span class="d-none d-md-block">Shipper</span>
                                            <span class="d-md-none">S</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="col">
                                <div class="d-flex justify-content-end">
                                    <div class="input-group input-group-alternative w-25">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>
                                        </div>
                                        <input class="form-control month_year_only" value="{{ request('year') ? \Carbon\Carbon::create(request('year'), request('month'), 1, 0, 0, 0)->format('m/Y') : \Carbon\Carbon::now()->format('m/Y') }}" placeholder="Select time" id="selectTime">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <!-- Projects table -->
                            <table class="table align-items-center table-flush mb-3 text-white">
                                <thead class="thead-light">
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Amount total</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($rankingTotal as $index => $item)
                                    <tr>
                                        <th scope="row">
                                            {{ ($page - 1)*10 + $index + 1 }}
                                        </th>
                                        <td>
                                            {{ request('role') == 'shipper' ? ($item->shipper ? $item->shipper->name : '') : ($item->manager ? $item->manager->name : '') }}
                                        </td>
                                        <td>
                                            {{ request('role') == 'shipper' ? ($item->shipper ? $item->shipper->email : '') : ($item->manager ? $item->manager->email : '') }}
                                        </td>
                                        <td>
                                            {{ $item->amount_total }}
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            {!! $rankingTotal->appends(request()->query())->links() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-xl-12 mb-5 mb-xl-0">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col">
                                <h3 class="mb-0">Shipped Ranking</h3>
                            </div>
                            <div class="col">
                                <div class="d-flex justify-content-end">
                                    <div class="input-group input-group-alternative w-25">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>
                                        </div>
                                        <input class="form-control month_year_only" value="{{ request('shippedYear') ? \Carbon\Carbon::create(request('shippedYear'), request('shippedMonth'), 1, 0, 0, 0)->format('m/Y') : \Carbon\Carbon::now()->format('m/Y') }}" placeholder="Select time" id="selectShippedTime">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <!-- Projects table -->
                        <table class="table align-items-center table-flush mb-3">
                            <thead class="thead-light">
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">%</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($rankingShipped as $index => $item)
                                <tr>
                                    <th scope="row">
                                        {{ $index + 1 }}
                                    </th>
                                    <td>
                                        {{ $item->shipper ? $item->shipper->name : '' }}
                                    </td>
                                    <td>
                                        {{  $item->shipper ? $item->shipper->email : '' }}
                                    </td>
                                    <td>
                                        {{ round($item->ratio) }}%
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
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
            $('.month_year_only').datepicker({
                format: "mm/yyyy",
                startView: "months",
                minViewMode: "months",
                autoclose: true
            });

            $('#selectTime').on('change', function () {
                changeUrl()
            });

            $('#selectShippedTime').on('change', function () {
                changeUrl()
            });

            function changeUrl() {
                let urlParams = new URLSearchParams(window.location.search);
                let role = urlParams.get('role') ?? 'manager';
                let time = $('#selectTime').val().split('/');
                let shippedTime = $('#selectShippedTime').val().split('/');
                let month = parseInt(time[0], 10);
                let year = parseInt(time[1], 10);
                let shippedMonth = parseInt(shippedTime[0], 10);
                let shippedYear = parseInt(shippedTime[1], 10);
                let url = window.location.pathname + '?role=' + role + '&month=' + month + '&year=' + year + '&shippedMonth=' + shippedMonth + '&shippedYear=' + shippedYear + '&page=1';
                window.location.href = url;
            }
        });
    </script>
@endpush
<style>
    .pagination {
        position: unset !important;
    }
</style>
