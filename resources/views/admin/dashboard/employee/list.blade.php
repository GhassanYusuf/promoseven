@extends('admin.template.master')

@section('content')

    @php

        switch ($type) {
            case "all":
                $color      = "info";
                $icon       = "fas fa-users";
                $search_url = URL('/api/employees/search/');
                break;
            case "natives":
                $color      = "success";
                $icon       = "far fa-flag";
                $search_url = URL('/api/employees/search/');
                break;
            case "expatriates":
                $color      = "warning";
                $icon       = "fas fa-globe";
                $search_url = URL('/api/employees/search/');
                break;
            case "expiries":
                $color      = "danger";
                $icon       = "far fa-clock";
                $search_url = URL('/api/employees/search/');
                break;
            case "incompletes":
                $color      = "info";
                $icon       = "fas fa-chart-pie";
                $search_url = URL('/api/employees/search/');
                break;
            case "deposits":
                $color      = "dark";
                $icon       = "fas fa-passport";
                $search_url = URL('/api/employees/search/');
                break;
            case "males":
                $color      = "primary";
                $icon       = "nav-icon fas fa-male";
                $search_url = URL('/api/employees/search/');
                break;
            case "females":
                $color      = "danger";
                $icon       = "nav-icon fas fa-female";
                $search_url = URL('/api/employees/search/');
                break;
            case "ex":
                $color      = "danger";
                $icon       = "fas fa-users";
                $search_url = URL('/api/employees/search/');
                break;
            case "deposits":
                $color      = "dark";
                $icon       = "fas fa-users";
                $search_url = URL('/api/employees/search/');
                break;
            case "deposits":
                $color      = "dark";
                $icon       = "fas fa-users";
                $search_url = URL('/api/employees/search/');
                break;
            default:
                $color      = "info";
                $icon       = "fas fa-users";
                $search_url = URL('/api/employees/search/');
        }

    @endphp

    <div class="content-wrapper">

        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><i class="fa fa-users-cog ml-2 mr-2"></i>MANAGE EMPLOYEES</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">EMPLOYEES</li>
                        <li class="breadcrumb-item active">{{ strtoupper($type) }}</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>

        <!-- Main content -->
        <section class="content">

            <div class="container-fluid">
            
                <!-- Small boxes (Stat box) -->
                @include('admin.widget.employee_boxes')

                {{-- Employees Table --}}
                <div class="row">
                    {{-- Full 12 WideSection --}}
                    <section class="col-lg-12">

                        <!-- TABLE: LATEST ORDERS -->
                        <div class="card card-outline card-{{ $color }}">

                            <div class="card-header border-transparent">

                                <h3 class="card-title">
                                    <i class="{{ $icon }} text-{{ $color }} mr-1"></i>
                                    {{ ucfirst($type) }}
                                </h3>

                                <div class="card-tools">
                                    <div class="input-group input-group-sm">
                                        <input type="text" class="form-control" placeholder="Search Mail">
                                        <div class="input-group-append">
                                            <div class="btn btn-{{ $color }}">
                                                <i class="fas fa-search"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        <!-- /.card-header -->

                        <div class="card-body p-0">
                            <div class="table-responsive">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                    <tr>
                                        <th class="text-secondary">ID</th>
                                        <th class="text-secondary">Picture</th>
                                        <th class="text-secondary">Name</th>
                                        <th class="text-secondary">Nationality</th>
                                        <th class="text-secondary">Age & Gender</th>
                                        <th class="text-secondary">Employment</th>
                                        <th class="text-secondary">Identification</th>
                                        <th class="text-secondary">Quick Buttons</th>
                                    </tr>
                                </thead>
                                <tbody>
                                        @if(!is_null($employees))
                                        @foreach ($employees as $employee)

                                            @if(!is_null($employee))

                                                @php
                                                    $birthdate  = makeDate($employee->birthdate);
                                                    $work       = json_decode($employee->employment);
                                                    $experiance = $work->experiance;
                                                    $visa       = json_decode($employee->visa);
                                                    $cpr        = json_decode($employee->cpr);
                                                    $passport   = json_decode($employee->passport);
                                                    $country    = json_decode($employee->nationality);
                                                    $incomplete = $employee->incomplete;
                                                @endphp

                                                <tr>
                                                    <td>
                                                        <a href="pages/examples/invoice.html">{{ $employee->id }}</a>
                                                    </td>
                                                    <td>
                                                        @if($employee->gender == "MALE")
                                                            <img _ngcontent-xwe-c16="" src="{{ asset('dist/img/avatar/male.png') }}" class="direct-chat-img">
                                                        @elseif($employee->gender == "FEMALE")
                                                            <img _ngcontent-xwe-c16="" src="{{ asset('dist/img/avatar/female.png') }}" class="direct-chat-img">
                                                        @else
                                                            <img _ngcontent-xwe-c16="" src="{{ asset('dist/img/avatar/male.png') }}" class="direct-chat-img">
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <b>
                                                            <a class="text-dark" href="{{ URL('/employees/' . $employee->id) }}">{{ $employee->name }}</a>
                                                        </b>
                                                        <br>

                                                        {{-- This Is To Show The CPR Indicator --}}
                                                        <span class="badge badge-{{ colorSelect($cpr->indicator) }} mr-1">CPR</span>

                                                        {{-- This Is To Show The Passport Indicator --}}
                                                        <span class="badge badge-{{ colorSelect($passport->indicator) }} mr-1">PASSORT</span>

                                                        {{-- This Is To Show The Visa Indicator --}}
                                                        @if($country->iso3 != 'BHR')
                                                            <span class="badge badge-{{ colorSelect($visa->indicator) }} mr-1">VISA</span>
                                                        @endif

                                                        {{-- This Is To Show Experiance Time --}}
                                                        @if($work->start != NULL)
                                                            <span class="badge badge-secondary mr-1">
                                                            @if($experiance->y > 0) {{ $experiance->y }}Y @endif
                                                            @if($experiance->m > 0) {{ $experiance->m }}M @endif
                                                            @if($experiance->d > 0) {{ $experiance->d }}D @endif
                                                            </span>
                                                        @endif

                                                        {{-- This Is To Indicate Incomplete Profile --}}
                                                        @if($incomplete == 'I')
                                                            <span class="badge badge-info mr-1">INCOMPLETE</span>
                                                        @endif

                                                    </td>
                                                    <td>
                                                        <i class="flag-icon flag-icon-{{ strtolower($country->iso) }} mr-2"></i>{{ $country->name }}
                                                        <br>
                                                        <span class="badge badge-dark mr-1">{{ $country->iso }}</span>
                                                        <span class="badge badge-dark mr-1">{{ $country->iso3 }}</span>
                                                    </td>
                                                    <td>
                                                        <span class="badge badge-warning mr-1 mb-1"><i class="fas fa-clock mt-1 mb-1 ml-1 mr-1"></i><b>{{ $employee->age }}Y</b></span>
                                                        @if($employee->gender == "MALE")
                                                            <span class="badge badge-info mr-1 mb-1 pr-2"><i class="fas fa-male mt-1 mb-1 ml-1 mr-2"></i><b>M</b></span>
                                                        @else
                                                            <span class="badge badge-danger mr-1 mb-1 pr-2"><i class="fas fa-female mt-1 mb-1 ml-1 mr-2"></i><b>F</b></span>
                                                        @endif
                                                        <br>
                                                        <span class="badge badge-dark mr-1 pr-2"><i class="far fa-calendar mt-1 mb-1 ml-1 mr-2"></i>{{ $birthdate }}</span>
                                                    </td>
                                                    <td>
                                                        @if($work->company == NULL)
                                                            <span class="badge badge-secondary mr-1 mb-1 pr-2"><i class="fas fa-building mt-1 mb-1 ml-1 mr-2"></i>NOT SET</span> <br>
                                                        @else
                                                            <span class="badge badge-danger mb-1 mr-1 pr-2"><i class="fas fa-building mt-1 mb-1 ml-1 mr-2"></i>{{ $work->company }}</span> <br>
                                                        @endif

                                                        @if($visa->company == NULL)
                                                            <span class="badge badge-secondary mr-1 pr-2"><i class="fas fa-file mt-1 mb-1 ml-1 mr-2"></i>NOT SET</span>
                                                        @else
                                                            <span class="badge badge-info mr-1 pr-2"><i class="fas fa-file mt-1 mb-1 ml-1 mr-2"></i>{{ $visa->company }}</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <span class="badge badge-success mr-1 mb-1 pr-2"><i class="fas fa-id-card mt-1 mb-1 ml-1 mr-2"></i>{{ $cpr->id }}</span> <br>
                                                        <span class="badge badge-success mr-1 pr-2"><i class="fas fa-passport mt-1 mb-1 ml-1 mr-2"></i>{{ $passport->id }}</span>
                                                    </td>
                                                    <td>
                                                        <!-- Example single danger button -->
                                                        <div class="btn-group dropleft">
                                                            <button type="button" class="btn btn-outline-dark dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                <b>Quick Action</b>
                                                            </button>
                                                            <div class="dropdown-menu bg-white">
                                                                <a class="dropdown-item" href="{{ URL('/employees/' . $employee->id) }}"><span class="text-primary"><i class="fas fa-eye mr-1"></i>View</span></a>
                                                                <a class="dropdown-item" href="#"><span class="text-primary"><i class="fas fa-paperclip mr-1"></i>Attach File</span></a>
                                                                <a class="dropdown-item" href="#"><span class="text-primary"><i class="fas fa-pen mr-1"></i>Edit</span></a>
                                                                <a class="dropdown-item" href="#"><span class="text-primary"><i class="fas fa-plane-departure mr-1"></i>Apply Leave</span></a>
                                                                <div class="dropdown-divider"></div>
                                                                <a class="dropdown-item" href="#"><span class="text-warning"><i class="fa fa-arrow-up mr-1"></i><i class="fa fa-passport mr-1"></i>Withdraw</span></a>
                                                                <a class="dropdown-item" href="#"><span class="text-success"><i class="fa fa-arrow-down mr-1"></i><i class="fa fa-passport mr-1"></i>Deposit</span></a>
                                                                <div class="dropdown-divider"></div>
                                                                <a class="dropdown-item" href="#"><span class="text-danger"><i class="fas fa-user-slash mr-1"></i>Terminate</span></a>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>

                                            @endif
                                        @endforeach
                                        @endif
                                    
                                </tbody>
                            </table>
                            </div>
                            <!-- /.table-responsive -->
                        </div>

                        <!-- /.card-body -->

                        <div class="card-footer clearfix">
                            <a href="javascript:void(0)" class="btn btn-sm btn-outline-{{ $color }} float-left mr-2"><i class="fas fa-file-pdf mr-1"></i>Download PDF</a>
                            <a href="javascript:void(0)" class="btn btn-sm btn-outline-{{ $color }} float-left"><i class="fas fa-print mr-1"></i>Print</a>
                        </div>

                        <!-- /.card-footer -->

                        </div>

                        <!-- /.card -->
                        
                    </section>

                </div>

            </div>

        </section>

    </div>

@endsection

@section('scripts')

    <script type="text/javascript">

        // $(document).ready(function () {
        //     $(document).on('click', '.add_employee', function (e) {
                
        //         e.preventDefault();

        //         // var data = {
        //         //     'name': $('.name').val(),
        //         //     'email': $('.email').val(),
        //         //     'phone': $('.phone').val(),
        //         //     'course': $('.course').val(),
        //         // }

        //         var data = "hello";

        //         console.log(data);

        //     });            
        // });

        

        // Key Press Detection
        $('#search').on('keyup',function() {

            // The Key Press Value
            $value = $(this).val();

            // Displays What You Type
            alert($value);

            // $.ajax({
            //     type: 'get',
            //     url: '{{ $search_url }}',
            //     data: {'search': $value},
            //     success: function(data) {
            //         $('tbody').html(data);
            //     }
            // };

        });

    </script>

@endsection