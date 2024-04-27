    <!-- create modal content -->
    <div id="idcardProfesionModal-{{ $profession->id }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">{{ $profession->membership_name }} Id Card </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
               
                <img src="{{ asset('uploads/student/'. $profession->idcard ) }}"  />

            </div>
        </div>
        </div>
    </div>