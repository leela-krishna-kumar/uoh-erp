<div class="modal fade" id="deleteProfesionModal-{{ @$profession->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteExperienceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
      <form action="@isset($profession) {{ route('admin.professional-body.destroy',[@$profession->id]) }} @endisset" method="post" class="delete-form">
      @csrf
      @method('DELETE')
        <div class="modal-content">
            <div class="modal-body text-center">
                <h5 class="modal-title" id="v">{{ __('modal_are_you_sure') }}</h5>
                <p class="text-danger mt-2">{{ __('modal_delete_warning') }}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-times"></i> {{ __('btn_close') }}</button>
                <button type="submit" class="btn btn-danger"><i class="fa-solid fa-trash-can"></i> {{ __('btn_delete') }}</button>
            </div>
        </div>
      </form>
    </div>
  </div>