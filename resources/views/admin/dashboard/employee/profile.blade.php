@extends('admin.template.master')

@section('content')

<div class="content-wrapper">

    @php

        $profile        = $profile[0];
        $contact        = json_decode($profile->contact);
        $nationality    = json_decode($profile->nationality);
        $employment     = json_decode($profile->employment);
        $visa           = json_decode($profile->visa);
        $cpr            = json_decode($profile->cpr);
        $passport       = json_decode($profile->passport);

    @endphp

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><i class="fa fa-gear ml-2 mr-2"></i>MANAGE EMPLOYEES</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">EMPLOYEES</li>
                        <li class="breadcrumb-item active">PROFILE</li>
                        <li class="breadcrumb-item active">{{ $profile->name }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <section class="content">

        <!-- Fluid -->
        <div class="container-fluid">
        
            <!-- Small boxes (Stat box) -->
            <div class="row">

                {{-- Profile Details --}}
                <div class="col-md-3">

                    <!-- Profile Image -->
                    <div class="card card-info card-outline">
                        <div class="card-body box-profile">
                            <div class="text-center">
                            <img class="profile-user-img img-fluid img-circle"
                                src="{{ checkPicture($profile) }}"
                                alt="User profile picture">
                            </div>

                            <h3 class="profile-username text-center">{{ $profile->name }}</h3>

                            <p class="text-muted text-center">{{ $employment->position }}</p>

                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    <b>Company</b> <a class="float-right">{{ display($employment->company) }}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Join Date</b> <a class="float-right">{{ makeDate($employment->start) }}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Years Of Work</b> <a class="float-right">
                                        {!! checkExperiance($employment) !!}
                                    </a>
                                </li>
                            </ul>

                            <div class="row">
                                <div class="col-sm-4">
                                    <button type="button" class="btn btn-outline-info btn-sm btn-block" title="Edit" data-toggle="modal" data-target="#editModal">
                                        <i class="fas fa-pen mr-1"></i>Edit
                                    </button>
                                </div>
                                <div class="col-sm-4">
                                    <a href="#" class="btn btn-outline-info btn-sm btn-block" title="Terminate" data-toggle="modal" data-target="#sendNewNotification"><i class="fas fa-envelope mr-1"></i><b>Notify</b></a>
                                </div>
                                <div class="col-sm-4">
                                    @if(is_null($employment->end))
                                        <button type="button" class="btn btn-danger btn-sm btn-block" title="Terminate" data-toggle="modal" data-target="#terminateModal">
                                            <i class="fas fa-user-slash mr-1"></i>Terminate
                                        </button>
                                    @else
                                        <button type="button" class="btn btn-success btn-sm btn-block" title="Terminate" data-toggle="modal" data-target="#terminateModal">
                                            <i class="fas fa-user mr-1"></i>Re Hire
                                        </button>
                                    @endif
                                </div>
                            </div>

                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->

                    <!-- About Me Box -->
                    {{-- @if(!is_null($contact)) --}}
                    <div class="card card-info card-outline">
                        
                        <!-- /.card-header -->
                        <div class="card-header">
                            <h3 class="card-title"><i class="fas fa-info-circle mr-2"></i>Contact Info</h3>
                        </div>

                        <!-- /.card-header -->
                        <div class="card-body">
                            
                            
                                <strong><i class="fas fa-phone mr-1"></i>Extension</strong>
                                <p class="text-muted"> </p>
                                <hr>

                                <strong><i class="fas fa-envelope mr-1"></i>Email</strong>
                                <p class="text-muted"> </p>
                                <hr>

                                <strong><i class="fas fa-mobile mr-1"></i>Mobile</strong>
                                <p class="text-muted"> </p>
                            

                        </div>
                        <!-- /.card-body -->
                    </div>
                    {{-- @endif --}}
                    <!-- /.card -->

                    <!-- About Me Box -->
                    <div class="card card-info card-outline">
                        
                        <!-- /.card-header -->
                        <div class="card-header">
                            <h3 class="card-title"><i class="fas fa-paperclip mr-2"></i>Attachments</h3>
                        </div>

                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                    <tr>
                                        <th>Record</th>
                                        <th>Document</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($files as $file)
                                        <tr>
                                            <td class="col-2">
                                                <span class="">{{ makeDate($file->created_at) }}</span>
                                            </td>
                                            <td class="col-8">
                                                <span class=""><a href="{{ $file->path }}"> {{ $file->title }}</a></span>
                                            </td>
                                            <td class="col-2">
                                                <a href="#" class="link-black mr-2" data-toggle="modal" data-target="#notesEditModal"><i class="fas fa-eye"></i></a>
                                                <a href="#" class="link-black mr-2" data-toggle="modal" data-target="#notesEditModal"><i class="fas fa-pen"></i></a>
                                                <a href="#" class="link-black mr-2" data-toggle="modal" data-target="#notesEditModal"><i class="fas fa-trash"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="card-footer">
                            <button type="button" class="btn btn-sm btn-outline-secondary float-right ml-2" data-toggle="modal" data-target="#fileAttach">
                                <i class="fas fa-plus mr-1"></i>Add
                            </button>
                        </div>

                    </div>
                    <!-- /.card -->

                </div>

                {{-- 2nd Col --}}
                <div class="col-md-5">

                    {{-- Employee Info --}}
                    <div class="card card-outline card-warning">
                        <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-file mr-1"></i> Employee Info
                        </h3>
                        </div>
                        <div class="card-body">
                            
                            <div class="row">
                                <div class="col-sm-2">
                                <p class="mb-0">
                                    <b>Country</b>
                                </p>
                                </div>
                                <div class="col-sm-4">
                                <p class="text-muted mb-0"><i class="flag-icon flag-icon-{{ strtolower($nationality->iso) }} mr-2"></i>{{ display($nationality->name) }}</p>
                                </div>
                                <div class="col-sm-2">
                                <p class="mb-0">
                                    <b>Gender</b>
                                </p>
                                </div>
                                <div class="col-sm-4">
                                <p class="text-muted mb-0">{{ display($profile->gender) }}</p>
                                </div>
                            </div>
                            <hr>

                            <div class="row">
                                <div class="col-sm-2">
                                <p class="mb-0">
                                    <b>Birthdate</b>
                                </p>
                                </div>
                                <div class="col-sm-4">
                                <p class="text-muted mb-0">{{ makeDate($profile->birthdate) }}</p>
                                </div>
                                <div class="col-sm-2">
                                <p class="mb-0">
                                    <b>Age</b>
                                </p>
                                </div>
                                <div class="col-sm-4">
                                <p class="text-muted mb-0">{{ display($profile->age) }}</p>
                                </div>
                            </div>
                            <hr>
                            
                            <!-- Visa Display Only For Expatriates -->
                            @if($nationality->iso3 != 'BHR')
                                <div class="row">
                                    <div class="col-sm-2">
                                    <p class="mb-0">
                                        <b>Visa</b>
                                    </p>
                                    </div>
                                    <div class="col-sm-4">
                                    <p class="text-muted mb-0">{{ display($visa->company) }}</p>
                                    </div>
                                    <div class="col-sm-2">
                                    <p class="mb-0">Expiry</p>
                                    </div>
                                    <div class="col-sm-4">
                                    <p class="text-muted mb-0">{{ makeDate($visa->expire) }}</p>
                                    </div>
                                </div>
                                <div class="row mt-1">
                                    <div class="col-sm-2">
                                    <p class="mb-0">Validity</p>
                                    </div>
                                    <div class="col-sm-10">
                                    <p class="text-muted mb-0">
                                        <span class="text-{{ colorSelect($visa->indicator) }}"> {!! checkValidity($visa) !!} </span>
                                    </p>
                                    </div>
                                </div>
                                <hr>
                            @endif
                            <!-- / Visa Display Only For Expatriates -->
                            
                            <div class="row">
                                <div class="col-sm-2">
                                <p class="mb-0">
                                    <b>CPR</b>
                                </p>
                                </div>
                                <div class="col-sm-4">
                                <p class="text-muted mb-0">{{ display($cpr->id) }}</p>
                                </div>
                                <div class="col-sm-2">
                                <p class="mb-0">Expiry</p>
                                </div>
                                <div class="col-sm-4">
                                <p class="text-muted mb-0">{{ makeDate($cpr->expire) }}</p>
                                </div>
                            </div>

                            <div class="row mt-1">
                                <div class="col-sm-2">
                                <p class="mb-0">Validity</p>
                                </div>
                                <div class="col-sm-10">
                                <span class="text-{{ colorSelect($cpr->indicator) }}"> {!! checkValidity($cpr) !!} </span>
                                </div>
                            </div>
                            <hr>

                            <div class="row">
                                <div class="col-sm-2">
                                <p class="mb-0">
                                    <b>Passport</b>
                                </p>
                                </div>
                                <div class="col-sm-4">
                                <p class="text-muted mb-0">{{ display($passport->id) }}</p>
                                </div>
                                <div class="col-sm-2">
                                <p class="mb-0">Expiry</p>
                                </div>
                                <div class="col-sm-4">
                                <p class="text-muted mb-0">{{ makeDate($passport->expire) }}</p>
                                </div>
                            </div>

                            <div class="row mt-1">
                                <div class="col-sm-2">
                                <p class="mb-0">Validity</p>
                                </div>
                                <div class="col-sm-10">
                                <span class="text-{{ colorSelect($passport->indicator) }}"> {!! checkValidity($passport) !!} </span>
                                </div>
                            </div>
                            <hr>

                            <div class="row">
                                <div class="col-sm-2">
                                <p class="mb-0">
                                    <b>BANK</b>
                                </p>
                                </div>
                                <div class="col-sm-5">
                                <p class="text-muted mb-0">{{ display($profile->bank_account) }}</p>
                                </div>
                            </div>
                            
                        </div>
                    </div>

                    <div class="card card-outline card-dark">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-sticky-note mr-1"></i> Notes &amp; Remarks
                            </h3>
                        </div>
                        <div class="card-body" id="notes">
                            <!-- The timeline -->
                            <div class="timeline timeline-inverse">

                                {{-- Define A Variable For Store Previous Values --}}
                                @php
                                    $previousNote = NULL;
                                @endphp

                                {{-- Loop To display Notes --}}
                                @foreach($notes as $note)
                                    
                                    @if($previousNote != makeDate($note->created_at))
                                        <!-- timeline time label -->
                                        <div class="time-label">
                                            <span class="bg-dark text-sm">{{ makeDate($note->created_at) }}</span>
                                        </div>
                                    @endif

                                    <!-- timeline item -->
                                    <div>
                                        <i class="fas fa-sticky-note bg-primary"></i>
                                        <div class="timeline-item">
                                        <span class="time"><i class="far fa-clock mr-1"></i>{{ makeTime($note->created_at) }}</span>                                    
                                        <span class="time"><i class="far fa-user mr-1"></i>{{ $note->done_by }}</span>
                                        <h3 class="timeline-header">
                                            {{ $note->title }}
                                        </h3>
                                        <div class="timeline-body">
                                            {{ $note->content }}
                                        </div>
                                        <div class="timeline-footer">
                                            <p class="p-1 m-0">
                                                <a href="#" class="link-black text-sm mr-2" data-toggle="modal" data-target="#notesEditModal"><i class="fas fa-pen mr-2"></i>Edit</a>
                                                <a href="{{ URL('/notes/delete/' . $note->id) }}" class="link-black text-sm"><i class="fas fa-trash mr-2"></i>Delete</a>
                                            </p>
                                        </div>
                                        </div>
                                    </div>

                                    @php
                                        $previousNote = makeDate($note->created_at);
                                    @endphp

                                @endforeach

                                {{-- To Display A Clock Sign --}}
                                @if(sizeof($notes) > 0)
                                    <div>
                                        <i class="far fa-clock bg-gray"></i>
                                    </div>
                                @endif

                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="button" class="btn btn-sm btn-outline-secondary float-right ml-2" data-toggle="modal" data-target="#notesModal">
                                <i class="fas fa-plus mr-1"></i>Add
                            </button>
                        </div>
                    </div>
                        

                </div>

                {{-- 3rd Col --}}
                <div class="col-md-4">

                    <!-- Leaves Box -->
                    <div class="card card-outline card-danger">
                        <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-suitcase mr-1"></i> Leaves
                        </h3>
                        <div class="card-tools">
                            <span class="badge badge-warning ml-2">0 Taken</span>
                            <span class="badge badge-success ml-2">30 Remaining</span>
                        </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0">
                        <table class="table table-hover text-nowrap">
                            <thead>
                            <tr>
                                <th>Type</th>
                                <th>Permission</th>
                                <th>Leave Date</th>
                                <th>Return Date</th>
                                <th>Days</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach ($leaves as $leave)
                                    <tr>
                                        <td>{{ $leave->type }}</td>

                                        @if($leave->approval != "APPROVED")
                                            <td><button class="btn btn-sm btn-outline-success"><strong>Approve</strong></button></td>
                                        @else
                                            <td>{{ $leave->approval }}</td>
                                        @endif

                                        @if($leave->status != "ON LEAVE" && $leave->status != "RETURNED")
                                            <td><button class="btn btn-sm btn-outline-success"><strong>Departed</strong></button></td>
                                        @else
                                            <td>{{ makeDate($leave->start_date) }}</td>
                                        @endif

                                        @if($leave->status != "RETURNED")
                                            <td><button class="btn btn-sm btn-outline-success"><strong>Returned</strong></button></td>
                                        @else
                                            <td>{{ $leave->return_date }}</td>
                                        @endif

                                        <td>{{ $leave->leave_days }}</td>
                                        
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button type="button" class="btn btn-sm btn-outline-secondary float-right ml-2" data-toggle="modal" data-target="#lModal">
                                <i class="fas fa-search mr-1"></i>View All
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-secondary float-right ml-2" data-toggle="modal" data-target="#leaveModal">
                                <i class="fas fa-plus mr-1"></i>Add
                            </button>
                        </div>
                    </div>

                    <!-- Passport Transactions Box -->
                    <div class="card card-outline card-secondary">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-passport mr-1"></i>Passport Transactions
                            </h3>
                            
                            <div class="card-tools">
                                <span class="badge badge-danger">Last 1 Transactions</span>
                            </div>
                        </div>

                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                    <tr>
                                        <th>Record</th>
                                        <th>Action</th>
                                        <th>Purpose</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($passports as $passport)
                                    <tr>
                                        <td>{{ makeDate($passport->created_at) }}</td>
                                        <td>PASSPORT {{ $passport->state }}</td>
                                        <td>{{ $passport->note }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- /.card-body -->
                        <div class="card-footer clearfix">
                            <button type="button" class="btn btn-sm btn-outline-secondary float-right ml-2" data-toggle="modal" data-target="#trModal">
                                <i class="fas fa-search mr-1"></i>View All
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-success float-right ml-2" data-toggle="modal" data-target="#passdepositModal">
                                <i class="fas fa-arrow-down mr-1"></i>Deposit
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-warning float-right ml-2" data-toggle="modal" data-target="#passwithdrawlModal">
                                <i class="fas fa-arrow-up mr-1"></i>Withdraw
                            </button>
                        </div>
                    </div>

                </div>

            </div>
            
        </div>

        {{-- Widget Terminate Modal --}}
        @include('admin.widget.employee_terminate')

        {{-- Widget Passport Deposit Modal --}}
        @include('admin.widget.passport_deposit')

        {{-- Widget Passport Withdrawl Modal --}}
        @include('admin.widget.passport_withdraw')

        {{-- Widget View Leaves --}}
        @include('admin.widget.leave_view')

        {{-- Widget Apply Leaves --}}
        @include('admin.widget.leave_apply')

        {{-- Widget View Passport Transaction History --}}
        @include('admin.widget.passport_view')

        {{-- Widget Employee Edit Modal --}}
        {{-- @include('admin.widget.employee_edit') --}}

        {{-- Widget Employee Edit Modal --}}
        @include('admin.widget.employee_notify')

        {{-- Widget Employee Edit Modal --}}
        @include('admin.widget.employee_attachment')

        {{-- Widget Add New Note --}}
        @include('admin.widget.notes_add')

        {{-- Widget Edit New Note --}}
        @include('admin.widget.notes_edit')


    </section>

</div>

@endsection