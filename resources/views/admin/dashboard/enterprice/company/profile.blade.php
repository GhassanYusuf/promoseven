@extends('admin.template.master')

@section('content')

<div class="content-wrapper">

    @php

        $profile        = $profile[0];
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
                <h1 class="m-0"><i class="fa fa-users-cog ml-2 mr-2"></i>MANAGE EMPLOYEES</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item active">EMPLOYEES</li>
                <li class="breadcrumb-item active">PROFILE</li>
                <li class="breadcrumb-item active">{{ $profile->name }}</li>
            </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
        </div><!-- /.container-fluid -->
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
                                src="{{ asset('dist/img/user4-128x128.jpg') }}"
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
                                        @if(!is_null($employment->start))
                                            {{ $employment->experiance->y }} &nbsp;<sub>YEARS</sub>&nbsp; {{ $employment->experiance->m }} &nbsp;<sub>MONTHS</sub>&nbsp; {{ $employment->experiance->d }} &nbsp;<sub>DAYS</sub>
                                        @else
                                            MISSING
                                        @endif
                                    </a>
                                </li>
                            </ul>

                            <div class="row">
                                <div class="col-sm-4">
                                    <a href="#" class="btn btn-outline-secondary btn-sm btn-block"><i class="fas fa-pen mr-1"></i><b>Edit</b></a>
                                </div>
                                <div class="col-sm-4">
                                    <a href="#" class="btn btn-outline-secondary btn-sm btn-block"><i class="fas fa-envelope mr-1"></i><b>Notify</b></a>
                                </div>
                                <div class="col-sm-4">
                                    <button type="button" class="btn btn-outline-danger btn-sm btn-block" title="Terminate" data-toggle="modal" data-target="#terminateModal">
                                        <i class="fas fa-user-slash"></i> Terminate
                                    </button>
                                </div>
                            </div>

                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->

                    <!-- About Me Box -->
                    <div class="card card-info card-outline">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fas fa-info-circle mr-2"></i>About Me</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <strong><i class="fas fa-book mr-1"></i> Education</strong>

                            <p class="text-muted">
                            B.S. in Computer Science from the University of Tennessee at Knoxville
                            </p>

                            <hr>

                            <strong><i class="fas fa-map-marker-alt mr-1"></i> Location</strong>

                            <p class="text-muted">Malibu, California</p>

                            <hr>

                            <strong><i class="fas fa-pencil-alt mr-1"></i> Skills</strong>

                            <p class="text-muted">
                                <span class="tag tag-danger">UI Design</span>
                                <span class="tag tag-success">Coding</span>
                                <span class="tag tag-info">Javascript</span>
                                <span class="tag tag-warning">PHP</span>
                                <span class="tag tag-primary">Node.js</span>
                            </p>

                            <hr>

                            <strong><i class="far fa-file-alt mr-1"></i> Notes</strong>

                            <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam fermentum enim neque.</p>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->

                </div>

                {{-- Profile Details --}}
                <div class="col-md-9">
                    <div class="card card-info card-outline">
                        
                        <!-- /.card-header -->
                        <div class="card-header p-2">
                            <ul class="nav nav-pills">
                                <li class="nav-item"><a class="btn btn-sm btn-outline-info active mr-2" href="#activity" data-toggle="tab">Notes</a></li>
                                <li class="nav-item"><a class="btn btn-sm btn-outline-info mr-2" href="#timeline" data-toggle="tab">Position</a></li>
                                <li class="nav-item"><a class="btn btn-sm btn-outline-info mr-2" href="#settings" data-toggle="tab">Info</a></li>
                            </ul>
                        </div><!-- /.card-header -->

                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="tab-content">

                                <!-- tab-pane [Employee Position] -->
                                <div class="active tab-pane" id="activity">
                                    <!-- Post -->
                                    <div class="post">
                                        <div class="user-block">
                                            <img class="img-circle img-bordered-sm" src="{{ asset('dist/img/user1-128x128.jpg') }}" alt="user image">
                                            <span class="username">
                                                <a href="#">Jonathan Burke Jr.</a>
                                                <a href="#" class="float-right btn-tool"><i class="fas fa-times"></i></a>
                                            </span>
                                            <span class="description">Shared publicly - 7:30 PM today</span>
                                        </div>
                                        <!-- /.user-block -->
                                        <p>
                                            Lorem ipsum represents a long-held tradition for designers,
                                            typographers and the like. Some people hate it and argue for
                                            its demise, but others ignore the hate as they create awesome
                                            tools to help create filler text for everyone from bacon lovers
                                            to Charlie Sheen fans.
                                        </p>

                                        <p>
                                            <a href="#" class="link-black text-sm mr-2"><i class="fas fa-share mr-1"></i> Share</a>
                                            <a href="#" class="link-black text-sm"><i class="far fa-thumbs-up mr-1"></i> Like</a>
                                            <span class="float-right">
                                            <a href="#" class="link-black text-sm">
                                                <i class="far fa-comments mr-1"></i> Comments (5)
                                            </a>
                                            </span>
                                        </p>

                                        <input class="form-control form-control-sm" type="text" placeholder="Type a comment">
                                    </div>
                                    <!-- /.post -->

                                    <!-- Post -->
                                    <div class="post clearfix">
                                        <div class="user-block">
                                            <img class="img-circle img-bordered-sm" src="{{ asset('dist/img/user7-128x128.jpg') }}" alt="User Image">
                                            <span class="username">
                                                <a href="#">Sarah Ross</a>
                                                <a href="#" class="float-right btn-tool"><i class="fas fa-times"></i></a>
                                            </span>
                                            <span class="description">Sent you a message - 3 days ago</span>
                                        </div>
                                        <!-- /.user-block -->
                                        <p>
                                            Lorem ipsum represents a long-held tradition for designers,
                                            typographers and the like. Some people hate it and argue for
                                            its demise, but others ignore the hate as they create awesome
                                            tools to help create filler text for everyone from bacon lovers
                                            to Charlie Sheen fans.
                                        </p>

                                        <form class="form-horizontal">
                                            <div class="input-group input-group-sm mb-0">
                                            <input class="form-control form-control-sm" placeholder="Response">
                                            <div class="input-group-append">
                                                <button type="submit" class="btn btn-danger">Send</button>
                                            </div>
                                            </div>
                                        </form>
                                    </div>
                                    <!-- /.post -->

                                    <!-- Post -->
                                    <div class="post">
                                        <div class="user-block">
                                            <img class="img-circle img-bordered-sm" src="{{ asset('dist/img/user6-128x128.jpg') }}" alt="User Image">
                                            <span class="username">
                                                <a href="#">Adam Jones</a>
                                                <a href="#" class="float-right btn-tool"><i class="fas fa-times"></i></a>
                                            </span>
                                            <span class="description">Posted 5 photos - 5 days ago</span>
                                        </div>
                                        <!-- /.user-block -->
                                        <div class="row mb-3">
                                            <div class="col-sm-6">
                                                <img class="img-fluid" src="{{ asset('dist/img/photo1.png') }}" alt="Photo">
                                            </div>
                                            <!-- /.col -->
                                            <div class="col-sm-6">
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <img class="img-fluid mb-3" src="{{ asset('dist/img/photo2.png') }}" alt="Photo">
                                                        <img class="img-fluid" src="{{ asset('dist/img/photo3.jpg') }}" alt="Photo">
                                                    </div>
                                                    <!-- /.col -->
                                                    <div class="col-sm-6">
                                                        <img class="img-fluid mb-3" src="{{ asset('dist/img/photo4.jpg') }}" alt="Photo">
                                                        <img class="img-fluid" src="{{ asset('dist/img/photo1.png') }}" alt="Photo">
                                                    </div>
                                                    <!-- /.col -->
                                                </div>
                                                <!-- /.row -->
                                            </div>
                                            <!-- /.col -->
                                        </div>
                                        <!-- /.row -->

                                        <p>
                                            <a href="#" class="link-black text-sm mr-2"><i class="fas fa-share mr-1"></i> Share</a>
                                            <a href="#" class="link-black text-sm"><i class="far fa-thumbs-up mr-1"></i> Like</a>
                                            <span class="float-right">
                                            <a href="#" class="link-black text-sm">
                                                <i class="far fa-comments mr-1"></i> Comments (5)
                                            </a>
                                            </span>
                                        </p>

                                        <input class="form-control form-control-sm" type="text" placeholder="Type a comment">
                                    </div>
                                    <!-- /.post -->
                                </div>
                                <!-- /.tab-pane -->

                                <!-- tab-pane Time Line [Employee Position] -->
                                <div class="tab-pane" id="timeline">
                                    <!-- The timeline -->
                                    <div class="timeline timeline-inverse">
                                        <!-- timeline time label -->
                                        <div class="time-label">
                                            <span class="bg-danger">
                                            10 Feb. 2014
                                            </span>
                                        </div>
                                        <!-- /.timeline-label -->
                                        <!-- timeline item -->
                                        <div>
                                            <i class="fas fa-envelope bg-primary"></i>
                                            <div class="timeline-item">
                                                <span class="time"><i class="far fa-clock"></i> 12:05</span>
                                                <h3 class="timeline-header"><a href="#">Support Team</a> sent you an email</h3>
                                                <div class="timeline-body">
                                                    Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles,
                                                    weebly ning heekya handango imeem plugg dopplr jibjab, movity
                                                    jajah plickers sifteo edmodo ifttt zimbra. Babblely odeo kaboodle
                                                    quora plaxo ideeli hulu weebly balihoo...
                                                </div>
                                                <div class="timeline-footer">
                                                    <a href="#" class="btn btn-primary btn-sm">Read more</a>
                                                    <a href="#" class="btn btn-danger btn-sm">Delete</a>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- END timeline item -->
                                        <!-- timeline item -->
                                        <div>
                                            <i class="fas fa-user bg-info"></i>
                                            <div class="timeline-item">
                                                <span class="time"><i class="far fa-clock"></i> 5 mins ago</span>
                                                <h3 class="timeline-header border-0"><a href="#">Sarah Young</a> accepted your friend request</h3>
                                            </div>
                                        </div>
                                        <!-- END timeline item -->
                                        <!-- timeline item -->
                                        <div>

                                            <i class="fas fa-comments bg-warning"></i>

                                            <div class="timeline-item">
                                                <span class="time"><i class="far fa-clock"></i> 27 mins ago</span>
                                                <h3 class="timeline-header"><a href="#">Jay White</a> commented on your post</h3>
                                                <div class="timeline-body">
                                                    Take me to your leader!
                                                    Switzerland is small and neutral!
                                                    We are more like Germany, ambitious and misunderstood!
                                                </div>
                                                <div class="timeline-footer">
                                                    <a href="#" class="btn btn-warning btn-flat btn-sm">View comment</a>
                                                </div>
                                            </div>

                                        </div>
                                        <!-- END timeline item -->
                                        <!-- timeline time label -->
                                        <div class="time-label">
                                            <span class="bg-success">
                                            3 Jan. 2014
                                            </span>
                                        </div>
                                        <!-- /.timeline-label -->
                                        <!-- timeline item -->
                                        <div>
                                            <i class="fas fa-camera bg-purple"></i>

                                            <div class="timeline-item">

                                                <span class="time"><i class="far fa-clock"></i> 2 days ago</span>

                                                <h3 class="timeline-header"><a href="#">Mina Lee</a> uploaded new photos</h3>

                                                <div class="timeline-body">
                                                    {{-- <img src="https://placehold.it/150x100" alt="..."> --}}
                                                    {{-- <img src="https://placehold.it/150x100" alt="..."> --}}
                                                    {{-- <img src="https://placehold.it/150x100" alt="..."> --}}
                                                    {{-- <img src="https://placehold.it/150x100" alt="..."> --}}
                                                </div>

                                            </div>

                                        </div>
                                        <!-- END timeline item -->
                                        <div>
                                            <i class="far fa-clock bg-gray"></i>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.tab-pane -->

                                <!-- tab-pane [Employee Info] -->
                                <div class="tab-pane" id="settings">

                                    <!-- Nationality & Gender -->
                                    <div class="row">
                                        <div class="col-sm-2">
                                            <p class="mb-0"><b>Country</b></p>
                                        </div>
                                        <div class="col-sm-4">
                                            <p class="text-muted mb-0">{{ $nationality->name }}</p>
                                        </div>
                                        <div class="col-sm-2">
                                            <p class="mb-0"><b>Gender</b></p>
                                        </div>
                                        <div class="col-sm-4">
                                            <p class="text-muted mb-0">{{ $profile->gender }}</p>
                                        </div>
                                    </div>
                                    <hr>
                                    <!-- / Nationality & Gender -->

                                    <!-- Birthdate & Age -->
                                    <div class="row">
                                        <div class="col-sm-2">
                                            <p class="mb-0"><b>Birthdate</b></p>
                                        </div>
                                        <div class="col-sm-4">
                                            <p class="text-muted mb-0">{{ makeDate($profile->birthdate) }}</p>
                                        </div>
                                        <div class="col-sm-2">
                                            <p class="mb-0"><b>Age</b></p>
                                        </div>
                                        <div class="col-sm-4">
                                            <p class="text-muted mb-0">{{ $profile->age }}</p>
                                        </div>
                                    </div>
                                    <hr>
                                    <!-- / Birthdate & Age -->

                                    <!-- Visa Display Only For Expatriates -->
                                    @if( $nationality->iso3 != 'BHR' )
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
                                                @if( $visa->company != "FAMILY VISA")
                                                    <p class="mb-0">Expiry</p>
                                                @endif
                                            </div>
                                            <div class="col-sm-4">
                                                @if( $visa->company != "FAMILY VISA")
                                                    <p class="text-muted mb-0">{{ makeDate($visa->expire) }}</p>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="row mt-1">
                                            <div class="col-sm-2">
                                                @if( $visa->company != "FAMILY VISA")
                                                    <p class="mb-0">Validity</p>
                                                @endif
                                            </div>
                                            <div class="col-sm-10">
                                                @if( $visa->company != "FAMILY VISA")
                                                    <a class="text-{{ colorSelect($visa) }} float-left">
                                                        {{ display($visa->validity->y) }} &nbsp;<sub>YEARS</sub>&nbsp; {{ display($visa->validity->m) }} &nbsp;<sub>MONTHS</sub>&nbsp; {{ display($visa->validity->d) }} &nbsp;<sub>DAYS</sub>
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                        <hr>
                                    @endif
                                    <!-- / Visa Display Only For Expatriates -->
                                    
                                    <!-- CPR Display -->
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
                                            @if($cpr->indicator == "G")
                                                <a class="text-success float-left">
                                            @elseif($cpr->indicator == "Y")
                                                <a class="text-warning float-left">
                                            @elseif($cpr->indicator == "R")
                                                <a class="text-danger float-left">
                                            @else
                                                <a class="text-danger float-left">
                                            @endif
                                                {{ display($cpr->validity->y) }} &nbsp;<sub>YEARS</sub>&nbsp; {{ display($cpr->validity->m) }} &nbsp;<sub>MONTHS</sub>&nbsp; {{ display($cpr->validity->d) }} &nbsp;<sub>DAYS</sub>
                                            </a>
                                        </div>
                                    </div>
                                    <hr>
                                    <!-- / CPR Display -->

                                    <!-- Passport Display -->
                                    <div class="row">
                                        <div class="col-sm-2">
                                            <p class="mb-0"><b>Passport</b></p>
                                        </div>
                                        <div class="col-sm-4">
                                            <p class="text-muted mb-0">{{ display($passport->id) }}</p>
                                        </div>
                                        <div class="col-sm-2">
                                            <p class="mb-0">Expiry</p>
                                        </div>
                                        <div class="col-sm-4">
                                            <p class="text-muted mb-0">{{ makeDate($passport->expire); }}</p>
                                        </div>
                                    </div>
                                    <div class="row mt-1">
                                        <div class="col-sm-2">
                                            <p class="mb-0">Validity</p>
                                        </div>
                                        <div class="col-sm-10">
                                            @if($passport->indicator == "G")
                                                <a class="text-success float-left">
                                            @elseif($passport->indicator == "Y")
                                                <a class="text-warning float-left">
                                            @elseif($passport->indicator == "R")
                                                <a class="text-danger float-left">
                                            @else
                                                <a class="text-danger float-left">
                                            @endif
                                                {{ display($passport->validity->y) }} &nbsp;<sub>YEARS</sub>&nbsp; {{ display($passport->validity->m) }} &nbsp;<sub>MONTHS</sub>&nbsp; {{ display($passport->validity->d) }} &nbsp;<sub>DAYS</sub>
                                            </a>
                                        </div>
                                    </div>
                                    <hr>
                                    <!-- / Passport Display -->

                                    <!-- BANK Account Display -->
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
                                <!-- /.tab-pane -->

                            </div>
                            <!-- /.tab-content -->
                        </div><!-- /.card-body -->

                    </div> <!-- /.card -->
                </div> {{-- /Profile Details --}}

            </div>

        </div>

    </section>

</div>

@endsection