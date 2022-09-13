@php

    // Include Employees Controller
    use App\Http\Controllers\ReportsController; 

    // Get The Boxes Values
    $boxes          = (new ReportsController)->boxes();
    $birthdays      = (new ReportsController)->BirthdayLite();
    $probations     = (new ReportsController)->ProbationLite();
    $anniversaries  = (new ReportsController)->AnniversaryLite();
    $onleaves       = (new ReportsController)->OnLeaveLite();

    // // Check Picture
    // function checkPicture($user) {
    //     if(!is_null($user->picture)) {
    //         return $user->picture;
    //     } else {
    //         if($user->gender == 'M') {
    //             return asset('dist/img/avatar/male.png');
    //         } elseif($user->gender == 'F') {
    //             return asset('dist/img/avatar/female.png');
    //         } else {
    //             return asset('dist/img/avatar/male.png');
    //         }
    //     }
    // }

    // // Date Formating
    // function makeDate($date) {
    //     if(!is_null($date)) {
    //         $date = date_create($date);
    //         return date_format($date,"d-M-y");
    //     } else {
    //         return "MISSING";
    //     }
    // }

@endphp

<div class="row">

    {{-- On Leave --}}
    <section class="col-sm-3">

        <!-- USERS LIST -->
        <div class="card card-outline card-secondary">
            <div class="card-header">
                <h3 class="card-title">
                    <h3 class="card-title"><i class="text-secondary fas fa-plane-departure mr-2"></i>On Leave</h3>
                </h3>
                <div class="card-tools">
                    <span class="badge badge-danger">{{ $boxes->OnLeave }}</span>
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
                <ul class="users-list clearfix">
                    @foreach ($onleaves as $onleave)
                        <li>
                            <a class="users-list-name" href="{{ URL('/employees/'. $onleave->id ) }}"><img src="{{ checkPicture($onleave) }}" alt="User Image"></a>
                            <a class="users-list-name" href="{{ URL('/employees/'. $onleave->id ) }}">{{ $onleave->name }}</a>
                            <a class="users-list-name" href="{{ URL('/employees/'. $onleave->id ) }}"><span class="users-list-date">RETURN ON<br>{{ makeDate($onleave->return) }}</span></a>
                        </li>
                    @endforeach
                </ul>
                <!-- /.users-list -->
            </div>
            <!-- /.card-body -->
            <div class="card-footer text-center">
                <a class="text-secondary" href="{{ URL('/') }}">View On Leave Report<i class="text-secondary fas fa-arrow-circle-right ml-2"></i></a>
            </div>
            <!-- /.card-footer -->
        </div>
        <!--/.card -->

    </section>

    {{-- Yearly Anniversaries --}}
    <section class="col-sm-3">

        <!-- USERS LIST -->
        <div class="card card-outline card-secondary">
            <div class="card-header">
            <h3 class="card-title"><i class="text-secondary fas fa-bell mr-2"></i>Yearly Anniversaries</h3>
            <div class="card-tools">
                <span class="badge badge-danger">{{ $boxes->Anniversary }}</span>
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove">
                <i class="fas fa-times"></i>
                </button>
            </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
                <ul class="users-list clearfix">
                    @foreach ($anniversaries as $anniversary)
                        <li>
                            <a class="users-list-name" href="{{ URL('/employees/'. $anniversary->id ) }}"><img src="{{ checkPicture($anniversary) }}" alt="User Image"></a>
                            <a class="users-list-name" href="{{ URL('/employees/'. $anniversary->id ) }}">{{ $anniversary->name }}</a>
                            <a class="users-list-name" href="{{ URL('/employees/'. $anniversary->id ) }}"><span class="users-list-date">JOIN DATE<br>{{ makeDate($anniversary->join) }}</span></a>
                        </li>
                    @endforeach
                </ul>
                <!-- /.users-list -->
            </div>
            <!-- /.card-body -->
            <div class="card-footer text-center">
                <a class="text-secondary" href="{{ URL('/') }}">View Yearly Anniversaries Report<i class="text-secondary fas fa-arrow-circle-right ml-2"></i></a>
            </div>
            <!-- /.card-footer -->
        </div>
        <!--/.card -->

    </section>

    {{-- Under Probation --}}
    <section class="col-sm-3">

        <!-- USERS LIST -->
        <div class="card card-outline card-secondary">
            <div class="card-header">
                <h3 class="card-title"><i class="text-secondary fas fa-clock mr-2"></i>Under Probation</h3>
                <div class="card-tools">
                    <span class="badge badge-danger">{{ $boxes->Probation }}</span>
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
                <ul class="users-list clearfix">
                    @foreach ($probations as $probation)
                        <li>
                            <a class="users-list-name" href="{{ URL('/employees/'. $probation->id ) }}"><img src="{{ checkPicture($probation) }}" alt="User Image"></a>
                            <a class="users-list-name" href="{{ URL('/employees/'. $probation->id ) }}">{{ $probation->name }}</a>
                            <a class="users-list-name" href="{{ URL('/employees/'. $probation->id ) }}"><span class="users-list-date">JOIN DATE<br>{{ makeDate($probation->join) }}</span></a>
                        </li>
                    @endforeach
                </ul>
                <!-- /.users-list -->
            </div>
            <!-- /.card-body -->
            <div class="card-footer text-center">
                <a class="text-secondary" href="{{ URL('/') }}">View Under Probation Report<i class="text-secondary fas fa-arrow-circle-right ml-2"></i></a>
            </div>
            <!-- /.card-footer -->
        </div>
        <!--/.card -->

    </section>

    {{-- Monthly Birthdays --}}
    <section class="col-sm-3">

        <!-- USERS LIST -->
        <div class="card card-outline card-secondary">
            <div class="card-header">
                <h3 class="card-title"><i class="text-secondary fas fa-birthday-cake mr-2"></i>Monthly Birthdays</h3>
                <div class="card-tools">
                    <span class="badge badge-danger">{{ $boxes->Birthdays }}</span>
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
                <ul class="users-list clearfix">
                    @foreach ($birthdays as $birthday)
                        <li>
                            <a class="users-list-name" href="{{ URL('/employees/'. $birthday->id ) }}"><img src="{{ checkPicture($birthday) }}" alt="User Image"></a>
                            <a class="users-list-name" href="{{ URL('/employees/'. $birthday->id ) }}">{{ $birthday->name }}</a>
                            <a class="users-list-name" href="{{ URL('/employees/'. $birthday->id ) }}"><span class="users-list-date">AGE {{ $birthday->age }}<br>{{ makeDate($birthday->birthday) }}</span></a>
                        </li>
                    @endforeach
                </ul>
                <!-- /.users-list -->
            </div>
            <!-- /.card-body -->
            <div class="card-footer text-center">
                <a class="text-secondary" href="{{ URL('/') }}">View Monthly Birthdays Report<i class="text-secondary fas fa-arrow-circle-right ml-2"></i></a>
            </div>
            <!-- /.card-footer -->
        </div>
        <!--/.card -->

    </section>

</div>