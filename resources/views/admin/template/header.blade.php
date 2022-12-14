<nav class="main-header navbar navbar-expand navbar-dark navbar-light">

<!-- Left navbar links -->
<ul class="navbar-nav">
    <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
        <a href="{{ ROUTE('dashboard') }}" class="nav-link"><i class="fas fa-home"></i></a>
    </li>
    {{-- <li class="nav-item d-none d-sm-inline-block">
        <a href="{{ URL('/') }}" class="nav-link">Dashboard</a>
    </li> --}}
    {{-- <li class="nav-item d-none d-sm-inline-block">
        <a href="{{ URL('/') }}" class="nav-link">Contact</a>
    </li> --}}
</ul>

<!-- Right navbar links -->
<ul class="navbar-nav ml-auto">
    <!-- Navbar Search -->
    <li class="nav-item">
    <a class="nav-link" data-widget="navbar-search" href="#" role="button">
        <i class="fas fa-search"></i>
    </a>
    <div class="navbar-search-block">
        <form class="form-inline">
        <div class="input-group input-group-sm">
            <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
            <div class="input-group-append">
            <button class="btn btn-navbar" type="submit">
                <i class="fas fa-search"></i>
            </button>
            <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                <i class="fas fa-times"></i>
            </button>
            </div>
        </div>
        </form>
    </div>
    </li>

    <!-- Add New Employee Button -->
    <li class="nav-item">
        <a class="nav-link" href="#" role="button">
            <i class="fas fa-user-plus mr-2"></i>
            {{-- <b>ADD</b> --}}
        </a>
    </li>

    <!-- Batch Add New Employee Button -->
    <li class="nav-item">
        <a class="add_employee nav-link" href="#" role="button">
            <i class="fas fa-users mr-2"></i><b>BATCH</b>
        </a>
    </li>

    <!-- Messages Dropdown Menu -->
    <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
            <i class="far fa-comments"></i>
            <span class="badge badge-danger navbar-badge">3</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
                <img src="{{ asset("dist/img/user1-128x128.jpg") }}" alt="User Avatar" class="img-size-50 mr-3 img-circle">
                <div class="media-body">
                <h3 class="dropdown-item-title">
                    Brad Diesel
                    <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">Call me whenever you can...</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                </div>
            </div>
            <!-- Message End -->
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
                <img src="{{ asset("dist/img/user8-128x128.jpg") }}" alt="User Avatar" class="img-size-50 img-circle mr-3">
                <div class="media-body">
                <h3 class="dropdown-item-title">
                    John Pierce
                    <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">I got your message bro</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                </div>
            </div>
            <!-- Message End -->
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
                <img src="{{ asset("dist/img/user3-128x128.jpg") }}" alt="User Avatar" class="img-size-50 img-circle mr-3">
                <div class="media-body">
                <h3 class="dropdown-item-title">
                    Nora Silvester
                    <span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">The subject goes here</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                </div>
            </div>
            <!-- Message End -->
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
        </div>
    </li>

    <!-- Notifications Dropdown Menu -->
    <li class="nav-item dropdown">
        @php

            // Include Employees Controller
            use App\Http\Controllers\ReportsController;

            // Get The Boxes Values
            $boxes = (new ReportsController)->boxes();

            // Notifications Count
            $notifications = $boxes->LeavesPending + $boxes->OnLeave + $boxes->Incompletes + $boxes->Expiries;

        @endphp
        <a class="nav-link" data-toggle="dropdown" href="#">
            <i class="far fa-bell"></i>
            <span class="badge badge-warning navbar-badge">{{ $notifications }}</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <span class="dropdown-item dropdown-header">{{ $notifications }} Notifications</span>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item">
                <i class="fas fa-plane-departure mr-2"></i> {{ $boxes->LeavesPending }} Pending Requests
                <span class="float-right text-muted text-sm">3 mins</span>
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item">
                <i class="fas fa-plane-departure mr-2"></i> {{ $boxes->OnLeave }} Employees On Leave
                <span class="float-right text-muted text-sm">3 mins</span>
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item">
                <i class="fas fa-users mr-2"></i> {{ $boxes->Incompletes }} Incomplete Profiles
                <span class="float-right text-muted text-sm">12 hours</span>
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item">
                <i class="far fa-clock mr-2"></i> {{ $boxes->Expiries }} Document Expiries
                <span class="float-right text-muted text-sm">2 days</span>
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
        </div>
    </li>

    <li class="nav-item dropdown user-menu">
        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
            <img src="{{ asset('dist/img/avatar/male.png') }}" class="user-image img-circle elevation-2" alt="User Image">
            <span class="d-none d-md-inline">Alexander Pierce</span>
        </a>
        <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <!-- User image -->
            <li class="user-header bg-dark">
            <img src="{{ asset('dist/img/avatar/male.png') }}" class="img-circle elevation-0" size= alt="User Image">
            <p>
                Alexander Pierce - Web Developer
                <small>Member since Nov. 2012</small>
            </p>
            </li>
            <!-- Menu Body -->
            <li class="user-body">
            <div class="row">
                <div class="col-4 text-center">
                <a href="#">Followers</a>
                </div>
                <div class="col-4 text-center">
                <a href="#">Sales</a>
                </div>
                <div class="col-4 text-center">
                <a href="#">Friends</a>
                </div>
            </div>
            <!-- /.row -->
            </li>
            <!-- Menu Footer-->
            <li class="user-footer">
            <a href="#" class="btn btn-default btn-flat">Profile</a>
            <a href="#" class="btn btn-default btn-flat float-right">Sign out</a>
            </li>
        </ul>
    </li>

    {{-- Full Screen --}}
    <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
            <i class="fas fa-expand-arrows-alt"></i>
        </a>
    </li>

    {{-- Control Side Bar --}}
    <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-controlsidebar-slide="true" href="#" role="button">
            <i class="fas fa-th-large"></i>
        </a>
    </li>
</ul>
</nav>