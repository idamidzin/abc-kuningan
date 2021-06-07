<header class="topnavbar-wrapper">
    <!-- START Top Navbar-->
    <nav class="navbar topnavbar">
        <!-- START navbar header-->
        <div class="navbar-header">
            <a class="navbar-brand" href="{{ route('admin.dashboard') }}">
                <div class="brand-logo">
                    <strong style="color: white">
                        {{ 'ABC Kuningan' }}
                    </strong>
                </div>
                <div class="brand-logo-collapsed">
                    <img class="img-fluid" src="{{ asset('logo.png') }}" alt="App Logo" width="200px;"/>
                </div>
            </a>
        </div>
        <!-- END navbar header-->
        <!-- START Left navbar-->
        <ul class="navbar-nav mr-auto flex-row">
            <li class="nav-item">
                <a class="nav-link d-none d-md-block d-lg-block d-xl-block" href="#" data-trigger-resize="" data-toggle-state="aside-collapsed">
                    <em class="fas fa-bars"></em>
                </a>
                <a class="nav-link sidebar-toggle d-md-none" href="#" data-toggle-state="aside-toggled" data-no-persist="true">
                    <em class="fas fa-bars"></em>
                </a>
            </li>
        </ul>
        <!-- END Left navbar-->
        <!-- START Right Navbar-->
        <div class="navbar">
            <a href="{{ route('logout') }}" style="text-decoration: none;"><div class="brand-logo">
                <strong style="color: white">
                    {{ 'Keluar' }}
                </strong>
                </div>
            </a>
        </div>
        <!-- END Right Navbar-->
        <!-- START Search form-->
        <form class="navbar-form" role="search" action="#">
            <div class="form-group">
                <input class="form-control" type="text" placeholder="Type and hit enter ..." />
                <div class="fas fa-times navbar-form-close" data-search-dismiss=""></div>
            </div>
            <button class="d-none" type="submit">Submit</button>
        </form>
        <!-- END Search form-->
    </nav>
    <!-- END Top Navbar-->
</header>
