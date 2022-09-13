<div class="modal" tabindex="-1" role="dialog" id="notesModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ URL('/') }}" method="post">
                <input type="hidden" name="_token" value="IAco62EkgZYSoc0I1ctgFkZkRe2AFTirqfRdMEvL">             
                <div class="modal-header">
                <h5 class="modal-title">Notes &amp; Remarks</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>
                </div>
                <div class="modal-body">
                <div class="md-form">
                    <i class="fas fa-pencil prefix grey-text"></i>
                    <input type="text" id="form32" name="title" class="form-control validate" placeholder="Title" required=""><br>
                    <textarea placeholder="Your Note..." type="text" id="form8" name="content" class="md-textarea form-control" rows="4" required=""></textarea> 
                </div>
                </div>
                <div class="modal-footer d-flex justify-content-center">
                <button class="btn btn-primary">Submit </button>
                <button class="btn btn-secondary" data-dismiss="modal" aria-label="Close">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>