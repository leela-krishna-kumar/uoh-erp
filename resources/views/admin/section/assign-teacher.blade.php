
<div id="addModal-{{ $row->id }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered ">
        <form class="needs-validation" novalidate action="{{ route('admin.assign-teacher', $row->id) }}" method="post"
            enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header d-flex justify-content-between">
                    <label for="student"><strong>{{ __('Assign Teacher') }}</strong> </label>   
                    <a type="button" data-bs-dismiss="modal" href="javascript:void(0)"> <span class="text-muted"  ></span><i class="fas fa-times"></i> </a>
                </div>
                <div class="modal-body">
                    <div class="modal-body ">
                        <div class="form-group col-md-12 mt-2 mb-2">
                            <label for="teacher_id">{{ __('Teacher') }}</label>
                            <select class="form-control select2" name="teacher_id" id="teacher_id" >
                                <option readonly value="">{{ __('select') }}</option>
                                @foreach ($teachers as $teacher)
                                    <option value="{{ $teacher->id }}" @if ($teacher->id == $row->teacher_id) selected @endif>
                                        {{ $teacher->first_name }} {{ $teacher->last_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">  
                        <button type="submit" class="btn btn-danger"><i class="fas fa-check"></i>
                            {{ __('Assign') }}</button>
                    </div>
        </form>
     </div>
   </div>
