<nav class="navbar navbar-vertical fixed-left navbar-expand-md navbar-light bg-white" id="sidenav-main">
    <div class="container-fluid">
        <!-- Toggler -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#sidenav-collapse-main"
                aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <!-- Brand -->
        <a class="navbar-brand pt-0" href="{{route('home')}}">
            <img src="{{ asset('argon') }}/img/brand/blue.png" class="navbar-brand-img" alt="...">
        </a>
        <!-- Collapse -->
        <div class="collapse navbar-collapse" id="sidenav-collapse-main">
            <!-- Collapse header -->
            <div class="navbar-collapse-header d-md-none">
                <div class="row">
                    <div class="col-6 collapse-brand">
                        <a href="#">
                            <img src="{{ asset('argon') }}/img/brand/blue.png">
                        </a>
                    </div>
                    <div class="col-6 collapse-close">
                        <button type="button" class="navbar-toggler" data-toggle="collapse"
                                data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false"
                                aria-label="Toggle sidenav">
                            <span></span>
                            <span></span>
                        </button>
                    </div>
                </div>
            </div>
            <!-- Form -->
            <div class="top-ranking text-center py-3 mb-2"
                 style="background: #FFDC00; font-family: 'Pridi', sans-serif; border-radius: 10px">
                <h3>Top Shipper</h3>
                <div class="list-ranking">
                    <div class="top3shipper__data">
                        <table class="w-100" style="font-size: 13px">
                            <thead style="background: #ffffff; border-bottom: 5px solid #FFDC00">
                            <tr>
                                <th>Top</th>
                                <th>Name</th>
                                <th>Amount</th>
                                <th>%</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($globalData['top3Shipper'] as $index => $item)
                            <tr style="background: #ffffff; border-bottom: 5px solid #FFDC00">
                                <td>
                                    <img style="height: 20px" src="{{ cxl_asset('assets/img/top'.($index + 1).'.png') }}" />
                                </td>
                                <td class="rank">{{ $item->shipper->name }}</td>
                                <td class="team">{{ $item->amount_total }}</td>
                                <td class="points">{{ round($item->shipped_ratio) }}</td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="top-ranking text-center py-3 border mb-4"
                 style="background: #FFDC00; font-family: 'Pridi', sans-serif; border-radius: 10px">
                <h3>Top List</h3>
                <div class="list-ranking">
                    <div class="top3manager__data">
                        <table class="w-100" style="font-size: 13px">
                            <thead style="background: #ffffff; border-bottom: 5px solid #FFDC00">
                            <tr>
                                <th>Top</th>
                                <th>Name</th>
                                <th>Amount</th>
                                <th>%</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($globalData['top3Manager'] as $index => $item)
                                <tr style="background: #ffffff; border-bottom: 5px solid #FFDC00">
                                    <td>
                                        <img style="height: 20px" src="{{ cxl_asset('assets/img/top'.($index + 1).'.png') }}" />
                                    </td>
                                    <td class="rank">{{ $item->manager->name }}</td>
                                    <td class="team">{{ $item->amount_total }}</td>
                                    <td class="points">{{ round($item->shipped_ratio) }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- Navigation -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="{{route('admin.account.index')}}">
                        <i class="ni ni-circle-08 text-primary"></i> {{ __('Accounts') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('admin.order.index')}}">
                        <i class="ni ni-money-coins text-primary"></i> {{ __('Orders') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('admin.note.index')}}">
                        <i class="ni ni-book-bookmark text-primary"></i> {{ __('Notes') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('admin.ranking.index')}}">
                        <i class="ni ni-diamond text-primary"></i> {{ __('Ranking') }}
                    </a>
                </li>
                @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('leader-manager') || auth()->user()->hasRole('leader-shipper'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('admin.user.index')}}">
                            <i class="ni ni-single-02 text-primary"></i> {{ __('Users') }}
                        </a>
                    </li>
                @endif
                @if(auth()->user()->hasRole('admin'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('admin.notification.index')}}">
                            <i class="ni ni-notification-70 text-primary"></i> {{ __('Notifications') }}
                        </a>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>
