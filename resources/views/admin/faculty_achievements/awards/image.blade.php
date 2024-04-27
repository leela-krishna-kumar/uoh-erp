    <!-- create modal content -->
    <div id="imageaward-{{ $awards->id }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">{{ $awards->membership_name }}Image </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">

                <img src="{{ asset('uploads/user/'. $awards->image ) }}"  />

            </div>
        </div>
        </div>
    </div>
