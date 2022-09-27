@php

    // Include Employees Controller
    use App\Http\Controllers\UserController;
    use App\Http\Controllers\LeavesController;

    // Get All Employees
    $substitute = (new UserController)->index();

@endphp

<div class="modal" id="leaveModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <form action="{{ URL('/') }}" method="post">
                <input type="hidden" name="_token" value="IAco62EkgZYSoc0I1ctgFkZkRe2AFTirqfRdMEvL">
                <div class="modal-header text-center">
                    <h4 class="modal-title w-100 font-weight-bold">Apply For A Leave</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body mx-3">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <input type="hidden" name="employee" value="390">
                                <label data-error="wrong" data-success="right" for="form32">Type of Leave</label>
                                <select class="form-control validate" name="type">
                                    <option value="">Select type of leave</option>
                                    <option value="A">Annual</option>
                                    <option value="S">Sick</option>
                                    <option value="W">Unpaid</option>
                                    <option value="P">Paternity</option>
                                    <option value="M">Maternity</option>
                                    <option value="C">Compassionate</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <input type="hidden" name="employee" value="390">
                                <label data-error="wrong" data-success="right" for="form32">Substitute</label>
                                <select class="form-control validate" name="annual_ticket">
                                    <option value="">Select Substitute</option>
                                    @foreach ($substitute as $employee)
                                        <option value="{{ $employee->id }}"> {{ $employee->name }} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <input type="hidden" name="employee" value="390">
                                <label data-error="wrong" data-success="right" for="form32">Start Date</label>
                                <input type="date" id="form32" name="start_date" class="start form-control validate">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <input type="hidden" name="employee" value="390">
                                <label data-error="wrong" data-success="right" for="form32">Return Date</label>
                                <input type="date" id="form32" name="start_date" class="start form-control validate">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <input type="hidden" name="employee" value="390">
                                <label data-error="wrong" data-success="right" for="form32">Annual Ticket</label>
                                <select class="form-control validate" name="type">
                                    <option value="No">No</option>
                                    <option value="Yes">Yes</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <input type="hidden" name="employee" value="390">
                                <label data-error="wrong" data-success="right" for="form32">Destination</label>
                                <input type="text" id="form32" name="destination" placeholder=" - Optional - " class="form-control validate">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <input type="hidden" name="employee" value="390">
                                <label data-error="wrong" data-success="right" for="form32">Flight Details</label>
                                <input type="text" id="form32" name="flight_details" placeholder=" - Optional - " class="form-control validate">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <input type="hidden" name="employee" value="390">
                                <label data-error="wrong" data-success="right" for="form32">Contact</label>
                                <input type="text" id="form32" name="contact_info" placeholder=" - Optional - " class="form-control validate">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <input type="hidden" name="employee" value="390">
                                <label data-error="wrong" data-success="right" for="form32">Note</label>
                                <textarea type="text" name="note" id="form8" class="md-textarea form-control" rows="4"></textarea>
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