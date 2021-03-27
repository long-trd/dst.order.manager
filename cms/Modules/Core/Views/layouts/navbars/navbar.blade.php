@auth()
    @include('Core::layouts.navbars.navs.auth')
@endauth
    
@guest()
    @include('Core::layouts.navbars.navs.guest')
@endguest