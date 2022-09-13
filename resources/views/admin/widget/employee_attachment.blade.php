{{-- Edit Modal --}}

<div class="modal" id="fileAttach" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ URL('/') }}" method="post" enctype="multipart/form-data">
                <input type="hidden" name="_token" value="IAco62EkgZYSoc0I1ctgFkZkRe2AFTirqfRdMEvL">
                <input type="hidden" name="_method" value="DELETE">
                <div class="modal-header">
                    <h5 class="modal-title">Employee File Attachments</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <form action="" method="POST" >
                            <div class="col-12">
                                <div class="form-group">
                                    <label>
                                        <i class="fas fa-keyboard mr-1"></i>
                                        Title
                                    </label>
                                    <input type="text" name="title" class="form-control" placeholder="Type The File Title Here" value="">
                                </div>
                                <div class="form-group">
                                    <label>
                                        <i class="fas fa-paperclip mr-1"></i>
                                        File Attachment
                                    </label>
                                    <input type="file" name="file" class="form-control">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <button type="submit" class="btn btn-primary">Attach</button>
                    <button class="btn btn-secondary" data-dismiss="modal" aria-label="Close">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>