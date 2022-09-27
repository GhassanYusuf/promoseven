<div class="modal" tabindex="-1" role="dialog" id="sendNewNotification">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
        <form action="{{ URL('/') }}" method="post">
            <input type="hidden" name="_token" value="IAco62EkgZYSoc0I1ctgFkZkRe2AFTirqfRdMEvL">
            <input type="hidden" name="_method" value="PUT">  
            <div class="modal-header">
                <h5 class="modal-title">Send Notification</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="md-form mb-2">
                    <label data-error="wrong" data-success="right" for="form32">Title</label>
                    <input type="text" size="100" id="form32" name="title" class="form-control validate" placeholder="This Is The Notification Title" value="" required="">
                </div>

                <div class="md-form">
                    <label data-error="wrong" data-success="right" for="form32">Content</label>
                    <textarea type="text" id="form8" name="content" placeholder="Your Notification Content Body . . ." class="md-textarea form-control" rows="8" required=""></textarea> 
                </div>
            </div>
            <div class="modal-footer d-flex justify-content-center">
                <button class="btn btn-primary">Send</button>
                <button class="btn btn-secondary" data-dismiss="modal" aria-label="Close">Close</button>
            </div>
        </form>
        </div>
    </div>
</div>