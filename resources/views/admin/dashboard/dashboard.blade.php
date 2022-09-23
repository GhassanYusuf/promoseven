@extends('admin.template.master')

@section('content')

<div class="content-wrapper">

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            <h1 class="m-0">Dashboard</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ URL('/') }}">Home</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
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

            <!-- Pie Charts -->
            @include('admin.widget.piechart')

            {{-- Area & Bar Chart --}}
            {{-- @include('admin.widget.areachart') --}}

            <!-- Employees Listing -->
            @include('admin.widget.employee_status')

        </div>

    </section>

</div>

@endsection

@section('scripts')



@endsection