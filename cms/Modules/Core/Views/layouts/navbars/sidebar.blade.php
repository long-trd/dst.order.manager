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
            <form class="mt-4 mb-3 d-md-none">
                <div class="input-group input-group-rounded input-group-merge">
                    <input type="search" class="form-control form-control-rounded form-control-prepended" placeholder="{{ __('Search') }}" aria-label="Search">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <span class="fa fa-search"></span>
                        </div>
                    </div>
                </div>
            </form>
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
                @if(auth()->user()->hasRole('admin'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('admin.user.index')}}">
                            <i class="ni ni-single-02 text-primary"></i> {{ __('Users') }}
                        </a>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>
