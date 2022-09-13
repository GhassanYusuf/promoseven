@php

    // Include Employees Controller
    use App\Http\Controllers\ReportsController;

    // Get The Boxes Values
    $boxes = (new ReportsController)->companiesBoxes();

@endphp

<!-- Small boxes (Stat box) -->
<div class="row">

    <!-- Employees -->
    <div class="col-lg-2 col-6">
        <!-- small box -->
        <div class="small-box bg-info">
            <div class="inner">
            <h3>{{ $boxes->Employees }}</h3>
            <p>Employees</p>
            </div>
            <div class="icon">
            <i class="fas fa-users"></i>
            </div>
            <a href="{{ URL('/employee/all') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    
    <!-- Native -->
    <div class="col-lg-2 col-6">
        <!-- small box -->
        <div class="small-box bg-success">
            <div class="inner">
            <h3>{{ $boxes->Natives }}</h3>
            <p>Native</p>
            </div>
            <div class="icon">
            <i class="far fa-flag"></i>
            </div>
            <a href="{{ URL('/employee/natives') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    
    <!-- Expatriates -->
    <div class="col-lg-2 col-6">
        <!-- small box -->
        <div class="small-box bg-warning">
            <div class="inner">
            <h3>{{ $boxes->Expatriates }}</h3>
            <p>Expatriates</p>
            </div>
            <div class="icon">
            <i class="fas fa-globe"></i>
            </div>
            <a href="{{ URL('/employee/expatriates') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    
    <!-- Expiries -->
    <div class="col-lg-2 col-6">
        <!-- small box -->
        <div class="small-box bg-danger">
            <div class="inner">
            <h3>{{ $boxes->Expiries }}</h3>
            <p>Expiries</p>
            </div>
            <div class="icon">
            <i class="far fa-clock"></i>
            </div>
            <a href="{{ URL('/employee/expiries') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    
    <!-- Incomplete -->
    <div class="col-lg-2 col-6">
        <!-- small box -->
        <div class="small-box bg-info">
            <div class="inner">
            <h3>{{ $boxes->Incompletes }}</h3>
            <p>Incomplete</p>
            </div>
            <div class="icon">
            <i class="fas fa-chart-pie"></i>
            </div>
            <a href="{{ URL('/employee/incomplete') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    
    <!-- Deposits -->
    <div class="col-lg-2 col-6">
        <!-- small box -->
        <div class="small-box bg-dark">
            <div class="inner">
            <h3>{{ $boxes->Deposits }}</h3>
            <p>Deposits</p>
            </div>
            <div class="icon">
            <i class="fas fa-passport"></i>
            </div>
            <a href="{{ URL('/employee/deposits') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>

</div>