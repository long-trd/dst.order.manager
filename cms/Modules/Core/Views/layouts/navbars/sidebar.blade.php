<nav class="navbar navbar-vertical fixed-left navbar-expand-md navbar-light bg-white" id="sidenav-main">
    <div class="container-fluid">
        <!-- Toggler -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle navigation">
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
                        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle sidenav">
                            <span></span>
                            <span></span>
                        </button>
                    </div>
                </div>
            </div>
            <!-- Form -->
           <div class="top-ranking text-center py-3 border" style="background: #FFDC00; font-family: 'Pridi', sans-serif; border-radius: 10px">
               <h2>Top Ranking</h2>
               <div class="text-center">
                   <ul class="nav nav-pills justify-content-center">
                       <li class="nav-item mr-2 mr-md-0">
                           <a style="min-width: 85px" id="top3manager" href="#" class="nav-link nav-link-top3 py-2 px-3 active" data-toggle="tab">
                               <span class="d-none d-md-block">List</span>
                               <span class="d-md-none">L</span>
                           </a>
                       </li>
                       <li class="nav-item">
                           <a style="min-width: 85px" id="top3shipper" href="#" class="nav-link nav-link-top3 py-2 px-3" data-toggle="tab">
                               <span class="d-none d-md-block">Shipper</span>
                               <span class="d-md-none">S</span>
                           </a>
                       </li>
                   </ul>
               </div>
               <div class="list-ranking">
                   <div class="top3manager__data mt-3">
                       @foreach($globalData['top3Manager'] as $index => $item)
                       <p>{!! $index == 0 ? '<i class="ni ni-trophy"></i> ' : '' !!}{{ $item->manager->name }}</p>
                       @endforeach
                   </div>
                   <div class="top3shipper__data mt-3" style="display: none">
                       @foreach($globalData['top3Shipper'] as $index => $item)
                           <p>{!! $index == 0 ? '<i class="ni ni-trophy"></i> ' : '' !!}{{ $item->shipper->name }} ({{ round($item->shipped_ratio) }}%)</p>
                       @endforeach
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
                @if(auth()->user()->hasRole('admin'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('admin.user.index')}}">
                            <i class="ni ni-single-02 text-primary"></i> {{ __('Users') }}
                        </a>
                    </li>
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
@push('js')
    <script type="text/javascript">
        $(function () {
            $(document).on('click', '.nav-link-top3', function () {
                $('#top3manager').hasClass('active') ? $('.top3manager__data').show() : $('.top3manager__data').hide();
                $('#top3shipper').hasClass('active') ? $('.top3shipper__data').show() : $('.top3shipper__data').hide();
            })
        })
    </script>
@endpush
