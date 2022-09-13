<div class="modal" tabindex="-1" role="dialog" id="terminateModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ URL('/') }}" method="post">
                <input type="hidden" name="_token" value="IAco62EkgZYSoc0I1ctgFkZkRe2AFTirqfRdMEvL">
                <input type="hidden" name="_method" value="DELETE">
                <div class="modal-header">
                    <h5 class="modal-title">Are you sure you want to proceed with termination?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <div class="md-form">
                        <label data-error="wrong" data-success="right" for="form32">Termination Date</label>
                        <input type="date" id="form32" name="end_date" class="form-control validate" required="">
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <button class="btn btn-primary">Terminate </button>
                    <button class="btn btn-secondary" data-dismiss="modal" aria-label="Close">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>