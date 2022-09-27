@php

    // Include Employees Controller
    use App\Http\Controllers\CountriesController;

    // Include Employees Controller
    use App\Http\Controllers\CompaniesController;

    // Include Employees Controller
    use App\Http\Controllers\VisasController;

    // List Visa
    $list_countries     = (new CountriesController)->index();
    $list_companies     = (new CompaniesController)->index();
    $list_visa          = (new VisasController)->index();

@endphp

{{-- Edit Modal --}}

<div class="modal" id="editModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <form action="{{ URL('/') }}" method="post">
                <input type="hidden" name="_token" value="IAco62EkgZYSoc0I1ctgFkZkRe2AFTirqfRdMEvL">
                <input type="hidden" name="_method" value="DELETE">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-pen mr-2"></i>Edit Employee Info</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                    <div class="col-sm-6">
                        <!-- text input -->
                        <div class="form-group">
                        <label>
                            <i class="fas fa-keyboard"></i> NAME </label>
                        <input type="text" name="name" class="form-control" value="{{ $profile->name }}">
                        </div>
                        <!-- select -->
                        <div class="form-group">
                        <label>
                            <i class="fas fa-male mr-1"></i>|<i class="fas fa-male ml-1 mr-1"></i>GENDER</label>
                        <select class="form-control" name="gender">
                            @if($profile->gender == "M" || $profile->gender == "MALE")
                                <option selected value="MALE">MALE</option>
                                <option value="FEMALE">FEMALE</option>
                            @else
                                <option value="MALE">MALE</option>
                                <option selected value="FEMALE">FEMALE</option>
                            @endif
                        </select>
                        </div>
                        <!-- text input -->
                        <div class="form-group">
                        <label>
                            <i class="fas fa-birthday-cake mr-1"></i>Birthdate</label>
                        <input type="date" class="form-control" name="birthdate" value="{{ $profile->birthdate }}">
                        </div>
                        <!-- text input -->
                        <div class="form-group">
                        <label>
                            <i class="fas fa-flag mr-1"></i>Nationality</label>
                        <select class="form-control" name="nationality">
                            @foreach($list_countries as $user_country)

                                @if($nationality->iso == $user_country->iso)
                                    <option value="{{ $user_country->id }}" selected>{{ $user_country->name }} </option>
                                @else
                                    <option value="{{ $user_country->id }}">{{ $user_country->name }} </option>
                                @endif
                        
                            @endforeach
                        </select>
                        </div>
                        <!-- select -->
                        <div class="form-group">
                        <label>
                            <i class="fas fa-building mr-1"></i>COMPANY</label>
                        <select class="form-control" name="company">
                            @foreach($list_companies as $user_company)

                                @if($employment->company == $user_company->name)
                                    <option value="{{ $user_company->id }}" selected>{{ $user_company->name }} </option>
                                @else
                                    <option value="{{ $user_company->id }}">{{ $user_company->name }} </option>
                                @endif
                        
                            @endforeach
                        </select>
                        </div>
                        <div class="form-group">
                            <label><i class="fas fa-mobile mr-1"></i>Mobile</label>
                            <input type="text" class="form-control" name="mobile" value="">
                        </div>
                        <div class="form-group">
                            <label><i class="fas fa-phone mr-1"></i>Extension</label>
                            <input type="text" class="form-control" name="ext" value="">
                        </div>
                        <div class="form-group">
                            <label><i class="fas fa-envelope mr-1"></i>Email</label>
                            <input type="text" class="form-control" name="email" value="">
                        </div>
                        <div class="form-group">
                            <label><i class="fa fa-bank mr-1"></i>IBAN Number</label>
                            <input type="text" class="form-control" name="bank_account" value="{{ $profile->bank_account }}">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label><i class="fas fa-calendar mr-1"></i><i class="fas fa-user mr-1"></i>Joining Date</label>
                            <input type="date" class="form-control" name="join_date" value="{{ $employment->start }}">
                        </div>
                        <div class="form-group">
                            <label><i class="fas fa-id-card mr-1"></i>Position</label>
                            <input type="text" class="form-control" name="position" value="{{ $employment->position }}">
                        </div>
                        <div class="form-group">
                            <label><i class="fas fa-hashtag mr-1"></i>Employee Code</label>
                            <input type="text" class="form-control" name="code" value="{{ $profile->code }}">
                        </div>
                        <!-- text input -->
                        <div class="form-group">
                        <label>
                            <i class="fas fa-id-card"></i> CPR Number </label>
                        <input type="text" class="form-control" name="cpr_number" value="{{ $cpr->id }}">
                        </div>
                        <!-- text input -->
                        <div class="form-group">
                            <label><i class="fas fa-calendar mr-1"></i><i class="fas fa-id-card mr-1"></i>CPR Expire</label>
                            <input type="date" class="form-control" name="cpr_expire" value="{{ $cpr->expire }}">
                        </div>
                        <!-- text input -->
                        <div class="form-group">
                        <label>
                            <i class="fas fa-passport mr-1"></i>Passport Number</label>
                            <input type="text" class="form-control" name="passport" value="{{ $passport->id }}">
                        </div>
                        <!-- text input -->
                        <div class="form-group">
                            <label><i class="fas fa-calendar mr-1"></i><i class="fas fa-passport mr-1"></i>Passport Expire</label>
                            <input type="date" class="form-control" name="passport_expire" value="{{ date($passport->expire) }}">
                        </div>
                        <!-- select -->
                        <div class="form-group">
                        <label>
                            <i class="fas fa-file mr-1"></i>Visa {{ $visa->expire }}</label>
                            <select class="form-control" name="visa_under">
                                
                                @foreach($list_visa as $user_visa)

                                    {{-- @if($visa->company == $user_visa->company) --}}
                                        {{-- <option value="{{ $user_visa->id }}" selected> {{ $user_visa->name }} </option> --}}
                                    {{-- @else --}}
                                        <option value="{{ $user_visa->id }}"> {{ $user_visa->name }} </option>
                                    {{-- @endif --}}
                            
                                @endforeach

                            </select>
                        </div>
                        <div class="form-group">
                            <label><i class="fas fa-calendar mr-1"></i><i class="fas fa-file mr-1"></i>Visa Expiry</label>
                            <input type="date" class="form-control" name="visa_expire" value="2024-07-13">
                        </div>
                    </div>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <button class="btn btn-primary">Apply</button>
                    <button class="btn btn-secondary" data-dismiss="modal" aria-label="Close">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>