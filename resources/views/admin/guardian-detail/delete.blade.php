<div class="modal fade" id="deleteGuardianModal-{{ @$guardian_detail->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteGuardianModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
      <form action="@isset($guardian_detail) {{ route('admin.guardian-detail.destroy',[@$guardian_detail->id]) }} @endisset" method="post" class="delete-form">
      @csrf
      @method('DELETE')
        <div class="modal-content">
            <div class="modal-body text-center">
                <h5 class="modal-title" id="deleteGuardianModalLabel">{{ __('modal_are_you_sure') }}</h5>
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