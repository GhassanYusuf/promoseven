@php

    // Include Employees Controller
    use App\Http\Controllers\ReportsController;

    // Get The Boxes Values
    $charts = (new ReportsController)->boxes();

@endphp

<div class="row">

    {{-- All Nationalities --}}
    <section class="col-sm-4">

        <!-- USERS LIST -->
        <div class="card card-outline card-info">
            <div class="card-header">
            <h3 class="card-title">
                <h3 class="card-title"><i class="text-info fas fa-passport mr-1"></i> Nationalities</h3>
            </h3>

            <div class="card-tools">
                {{-- <span class="badge badge-info">{{ sizeof($employees) }}</span> --}}
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove">
                <i class="fas fa-times"></i>
                </button>
            </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0 m-0">
                <div class="chartjs-size-monitor text-center mr-5"><canvas class="p-0 m-0" id="natChart" height="100%" width="100%"></canvas></div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer text-center">
                <a class="text-info" href="{{ route('expatriates') }}">View Nationality Report<i class="text-info fas fa-arrow-circle-right ml-2"></i></a>
            </div>
            <!-- /.card-footer -->
            <script>

                //
                
            </script>
        </div>
        <!--/.card -->

    </section>

    {{-- All Company --}}
    <section class="col-sm-4">

        <!-- USERS LIST -->
        <div class="card card-outline card-success">
            <div class="card-header">
            <h3 class="card-title"><i class="text-success fas fa-building mr-1"></i> Company</h3>
            <div class="card-tools">
                {{-- <span class="badge badge-success">{{ sizeof($native) }}</span> --}}
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
                <div class="text-center mr-5"><canvas class="p-0 m-0" id="comChart" height="100%" width="100%"></canvas></div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer text-center">
                <a class="text-success" href="{{ route('expatriates') }}">View Company Report<i class="text-success fas fa-arrow-circle-right ml-2"></i></a>
            </div>
            <!-- /.card-footer -->
            <script>
                
            </script>
        </div>
        <!--/.card -->

    </section>

    {{-- All Visa --}}
    <section class="col-sm-4">

        <!-- USERS LIST -->
        <div class="card card-outline card-warning">
            <div class="card-header">
                <h3 class="card-title"><i class="text-warning fas fa-file mr-1"></i> Visa</h3>
                <div class="card-tools">
                    {{-- <span class="badge badge-warning">{{ sizeof($expatriate) }}</span> --}}
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <!-- Card Body -->
            <div class="card-body p-0">
                <div class="text-center mr-5"><canvas class="p-0 m-0" id="visChart" height="100%" width="100%"></canvas></div>
            </div>
            <!-- Card Footer -->
            <div class="card-footer text-center">
                <a class="text-warning" href="{{ route('expatriates') }}">View Visa Report<i class="text-warning fas fa-arrow-circle-right ml-2"></i></a>
            </div>
            <!-- Java Script For This Chart -->
            <script>
                
            </script>
        </div>
        <!--/.card -->

    </section>

</div>