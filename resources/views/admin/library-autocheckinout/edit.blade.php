
    <!-- create modal content -->
    <div id="laedit{{ $library_a->id }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form class="needs-validation" novalidate action="{{ route($route . '.update' , $library_a->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    {{-- <input type="hidden" name="user_id" value="{{ $row->id }}">
                    <input type="hidden" name="staff_id" value="{{ $row->staff_id }}"> --}}
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel">Edit Library Attendence</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">

                     <fieldset class="row">
                        
                        <div class="form-group col-md-6">
                            <label for="membership_id">Name<span>*</span></label>
                            <input type="text" class="form-control " name="name" value="{{ @$library_a->name }}" required>
                         </div>


                         <div class="form-group col-md-6">
                            <label for="membership_id">Roll Number<span>*</span></label>
                            <input type="text" class="form-control " name="roll_no" id="title_of_paper" value="{{ @$library_a->roll_no }}" required>
                         </div>

                         <div class="form-group col-md-6">
                            <label for="membership_id">IN Time<span>*</span></label>
                            <input type="datetime-local" class="form-control " name="in_time" value="{{ @$library_a->in_time }}" required>
                         </div>

                         <div class="form-group col-md-6">
                            <label for="membership_id">OUT Time<span>*</span></label>
                            <input type="datetime-local" class="form-control " name="out_time" value="{{ @$library_a->out_time }}" required>
                         </div>

                     </fieldset>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-times"></i> {{ __('btn_close') }}</button>
                        <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> {{ __('btn_save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
