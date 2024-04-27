<div class="modal fade" id="deleteExpertiseModal-{{ @$expertise->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteExpertiseModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
      <form action="@isset($expertise) {{ route('admin.expertise.destroy',[@$expertise->id]) }} @endisset" method="post" class="delete-form">
      @csrf
      @method('DELETE')
        <div class="modal-content">
            <div class="modal-body text-center">
                <h5 class="modal-title" id="deleteExpertiseModalLabel">{{ __('modal_are_you_sure') }}</h5>
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
