@extends('admin.template.master')

@section('content')

@php

@endphp

<div class="content-wrapper">

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0"><i class="fa fa-users-cog ml-2 mr-1"></i>MANAGE ENTERPRISE</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item active">ENTERPRISE</li>
                    <li class="breadcrumb-item active">COMPANY</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
        
            <div class="row">

                <!-- Small boxes (Stat box) -->
                <div class="col-lg-12">
                    @include('admin.widget.employee_boxes')
                </div>

            </div>

            {{-- Employees Table --}}
            <div class="row">

                <!-- Companies List -->
                <div class="col-lg-8">
                    <div class="card card-outline card-primary">
                        {{-- Table Header --}}
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-building mr-1"></i>
                                <b>Companies List</b>
                            </h3>
                            
                            <div class="card-tools">
                                <div class="input-group input-group-sm">
                                <input type="text" class="form-control" placeholder="Search Company">
                                    <div class="input-group-append">
                                        <div class="btn btn-primary">
                                            <i class="fas fa-search"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- Table Body --}}
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                    <tr>
                                        <th><i class="fas fa-id-badge mr-1"></i>ID</th>
                                        <th><i class="fas fa-image mr-1"></i>Logo</th>
                                        <th><i class="fas fa-keyboard mr-1"></i>Name</th>
                                        <th><i class="fas fa-hashtag mr-1"></i>CR</th>
                                        <th><i class="fas fa-certificate mr-1"></i>VAT</th>
                                        <th><i class="far fa-calendar mr-1"></i>Expire</th>
                                        <th><i class="far fa-bolt mr-1"></i>Quick Buttons</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($companies as $company)
                                        <tr>
                                            <td>{{ $company->id }}</td>
                                            <td><img src="{{ asset('/dist/img/avatar/male.png') }}" id="image_41" class="img-fluid" style="width: 100px;" alt="Responsive image"></td>
                                            <td>
                                                <a href="#" style="color:black;">{{ $company->name }}</a>
                                                <br>
                                                <i class="fas fa-building mr-1"></i>
                                                <small class="badge badge-success">MOTHER COMPANY</small>
                                            </td>
                                            <td><a href="#" style="color:black;">{{ $company->cr }}</a></td>
                                            <td><span class="tag tag-success">{{ $company->vat_number }}</span></td>
                                            <td><small class="badge badge-white">{{ $company->cr_expire }}</small></td>
                                            <td>
                                                <!-- Example single danger button -->
                                                <div class="btn-group dropleft">
                                                    <button type="button" class="btn btn-outline-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <b>Quick Action</b>
                                                    </button>
                                                    <div class="dropdown-menu bg-white">
                                                        <a class="dropdown-item" href="{{ URL('/company/') }}"><span class="text-primary"><i class="fas fa-eye mr-1"></i>View</span></a>
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
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Create New Company -->
                <div class="col-sm-4">
                <div class="card card-outline card-danger">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-building mr-1"></i>
                            <b>Add New Company</b>
                        </h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                            <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalLabel">Crop Image for Upload</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="img-container">
                                        <div class="row">
                                        <div class="col-md-8">
                                            <img id="image" src="https://avatars0.githubusercontent.com/u/3456749">
                                        </div>
                                        <div class="col-md-4">
                                            <div class="preview"></div>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                    <button type="button" class="btn btn-primary" id="crop">Crop</button>
                                </div>
                            </div>
                            </div>
                        </div>
                        <form action="http://192.168.5.178/promoseven-hr-hr/public/company-store" method="post">
                            <input type="hidden" name="_token" value="IAco62EkgZYSoc0I1ctgFkZkRe2AFTirqfRdMEvL">           
                            <div class="form-group">
                            <label for="exampleInputEmail1"><i class="fas fa-keyboard"></i> Name</label>
                            <input type="text" class="form-control" id="exampleInputEmail1" name="name" placeholder="Enter Company Name">
                            </div>
                            <div class="form-group">
                            <label for="exampleInputEmail1"><i class="fas fa-hashtag"></i> CR</label>
                            <input type="text" class="form-control" id="exampleInputEmail1" name="cr" placeholder="Enter CR Number">
                            </div>
                            <div class="form-group">
                            <label for="exampleInputEmail1"><i class="fas fa-certificate"></i> VAT</label>
                            <input type="text" class="form-control" id="exampleInputEmail1" name="vat_number" placeholder="Enter VAT Account Number">
                            </div>
                            <div class="form-group">
                            <label for="exampleInputEmail1"><i class="fas fa-calendar"></i> Expire Date</label>
                            <input type="date" class="form-control" id="exampleInputEmail1" name="cr_expire" placeholder="Enter CR Expire Date">
                            </div>
                            <div class="form-group">
                            <label for="exampleInputEmail1"><i class="fas fa-building"></i> Parent Company</label>
                            <select class="form-control select2bs4 select2-hidden-accessible" name="parent_company" style="width: 100%;" data-select2-id="17" tabindex="-1" aria-hidden="true">
                                <option selected="selected" value="{{ NULL }}">- NOT CHILD COMPANY -</option>
                                @foreach($companies as $company)
                                    <option value="{{ $company->id }}"> {{ $company->name }} </option>
                                @endforeach
                            </select>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-danger float-right">Create New Company</button>
                        <!-- <button type="button" class="btn btn-default float-right">Cancel</button> -->
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
                </div>

            </div>
        </div>

    </section>

</div>

@endsection