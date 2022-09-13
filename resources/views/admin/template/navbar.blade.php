@php

    // Include Employees Controller
    use App\Http\Controllers\ReportsController; 

    // Get The Boxes Values
    $boxes = (new ReportsController)->boxes();

@endphp

<aside class="main-sidebar sidebar-dark-primary elevation-2">

    <!-- Brand Logo -->
    <div class="row bg-dark brand-link">
        <img class="mx-auto d-block img-fluid" alt="Responsive image" src="{{ asset("dist/img/logo/promosevenWhite.svg") }}" alt="Promoseven" style="width: 100%">
    </div>

    <!-- Sidebar -->
    <div class="sidebar">

        {{-- User Information --}}
        {{-- <div class="text-center mt-3">
            <a href="{{ URL('/') }}">
                <?php
                    $gender = "FEMALE";
                ?>
                @if($gender == "MALE")
                    <img class="rounded-circle border border-3 border-warning img-fluid" alt="Responsive image" src="{{ asset('dist/img/avatar/male.png') }}" alt="User Image">
                @else
                    <img class="rounded-circle border border-3 border-warning img-fluid" alt="Responsive image" src="{{ asset('dist/img/avatar/female.png') }}" alt="User Image">
                @endif
            </a>
            <a class="users-list-name mt-2" href="#">
                <b>LOURDES OMBAO APUYAN<b>
            </a>
            <span class="users-list-date mb-3"><b>NETWORK ENGINEER</b></span>
        </div> --}}

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            
            {{-- New Side Bar --}}
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            
                {{-- Header - Managment --}}
                <li class="nav-header bg-warning"><i class="fa fa-users-cog ml-2 mr-2"></i><b>MANAGE EMPLOYEES</b></li>

                    {{-- All Employees --}}
                    <li class="nav-item mt-2">
                        <a href="{{ URL('/employees/all') }}" class="nav-link">
                            <i class="nav-icon fas fa-users"></i>
                            <p class="text">
                                All
                            <span class="right badge badge-info">{{ $boxes->Employees }}</span></p>
                        </a>
                    </li>

                    {{-- Native Employees --}}
                    <li class="nav-item">
                        <a href="{{ URL('/employees/natives') }}" class="nav-link">
                            <i class="nav-icon far fa-flag"></i>
                            <p class="text">
                                Natives
                                <span class="right badge badge-success">{{ $boxes->Natives }}</span>
                            </p>
                        </a>
                    </li>

                    {{-- All Expatriates --}}
                    <li class="nav-item">
                        <a href="{{ URL('/employees/expatriates') }}" class="nav-link">
                            <i class="nav-icon fas fa-globe"></i>
                            <p class="text">
                                Expatriates
                                <span class="right badge badge-warning">{{ $boxes->Expatriates }}</span>
                            </p>
                        </a>
                    </li>

                    {{-- Have Expiries --}}
                    <li class="nav-item">
                        <a href="{{ URL('/employees/expiries') }}" class="nav-link">
                            <i class="nav-icon far fa-clock"></i>
                            <p class="text">
                                Have Expiries
                                <span class="right badge badge-danger">{{ $boxes->Expiries }}</span>
                            </p>
                        </a>
                    </li>

                    {{-- Have Incomplete Info --}}
                    <li class="nav-item">
                        <a href="{{ URL('/employees/incomplete') }}" class="nav-link">
                            <i class="nav-icon fas fa-chart-pie"></i>
                            <p class="text">
                                Incomplete
                                <span class="right badge badge-info">{{ $boxes->Incompletes }}</span>
                            </p>
                        </a>
                    </li>

                    {{-- Passport Deposits --}}
                    <li class="nav-item">
                        <a href="{{ URL('/employees/deposits') }}" class="nav-link">
                            <i class="nav-icon fas fa-passport"></i>
                            <p class="text">
                                Deposits
                                <span class="right badge badge-dark">{{ $boxes->Deposits }}</span>
                            </p>
                        </a>
                    </li>

                    {{-- All Male Employees --}}
                    <li class="nav-item">
                        <a href="{{ URL('/employees/males') }}" class="nav-link">
                            <i class="nav-icon fas fa-male"></i>
                            <p class="text">
                                Males
                                <span class="right badge badge-info">{{ $boxes->Males }}</span>
                            </p>
                        </a>
                    </li>

                    {{-- All Female Employees --}}
                    <li class="nav-item">
                        <a href="{{ URL('/employees/females') }}" class="nav-link">
                            <i class="nav-icon fas fa-female"></i>
                            <p class="text">
                                Females
                                <span class="right badge badge-danger">{{ $boxes->Females }}</span>
                            </p>
                        </a>
                    </li>

                    {{-- All Ex Employees --}}
                    <li class="nav-item mb-2">
                        <a href="{{ URL('/employees/ex') }}" class="nav-link">
                            <i class="nav-icon fas fa-users-slash"></i>
                            <p class="text">
                                Ex
                                <span class="right badge badge-danger">{{ $boxes->ExEmployees }}</span>
                            </p>
                        </a>
                    </li>

                </li>

                {{-- Header - Managment --}}
                <li class="nav-header bg-warning"><i class="fas fa-building ml-2 mr-2"></i><b>MANAGE ENTERPRISE</b></li>

                    {{-- All Companies --}}
                    <li class="nav-item mt-2">
                        <a href="{{ route('list.companies') }}" class="nav-link">
                            <i class="nav-icon fas fa-building"></i>
                            <p class="text">
                                Company
                                <span class="right badge badge-secondary">New</span>
                            </p>
                        </a>
                    </li>

                    {{-- Company Departments --}}
                    <li class="nav-item">
                        <a href="{{ route('list.departments') }}" class="nav-link">
                            <i class="nav-icon fas fa-home"></i>
                            <p class="text">
                                Department
                                <span class="right badge badge-secondary">New</span>
                            </p>
                        </a>
                    </li>

                    {{-- Visa Sources --}}
                    <li class="nav-item mb-10">
                        <a href="{{ route('list.visas') }}" class="nav-link">
                            <i class="nav-icon fas fa-file"></i>
                            <p class="text">
                                Visa
                                <span class="right badge badge-secondary">New</span>
                            </p>
                        </a>
                    </li>

                </li>

            </ul>

        </nav>
        <!-- /.sidebar-menu -->

    </div>
    <!-- /.sidebar -->

</aside>