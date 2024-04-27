    <!-- Delete modal -->
    <div class="modal fade" id="deletejournal-{{ $journal->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
          <form action="{{ url('admin/faculty-achievements/journals/'. $journal->id ) }}" method="post" class="delete-form">
          @csrf
          @method('DELETE')
          {{-- <input type="text" class="form-control " name="research_id" id=""  value="{{ @$journal->id }}"  required hidden> --}}
            <div class="modal-content">
                <div class="modal-body text-center">
                    <h5 class="modal-title" id="deleteModalLabel">{{ __('modal_are_you_sure') }}</h5>
                    <p class="text-danger mt-2">{{ __('modal_delete_warning') }}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-times"></i> {{ __('btn_close') }}</button>
                    <button type="submit" class="btn btn-danger"><i class="fa-solid fa-trash-can"></i> {{ __('btn_delete') }}</button>
                </div>
            </div><!-- /.modal-content -->
          </form>
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->