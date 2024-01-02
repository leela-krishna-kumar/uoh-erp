    <!-- Delete modal -->
    <div uk-modal id="studentDeleteModal-{{ $row->id }}">
        <div class="uk-modal-dialog">
          <form action="{{ route($route.'.destroy', [$row->id]) }}" method="post" class="delete-form">
          @csrf
          @method('DELETE')
            <div class="modal-content">
                <div class="modal-body text-center">
                    <h5 class="modal-title" id="studentDeleteModalLabel">{{ __('modal_are_you_sure') }}</h5>
                    <p class="text-danger mt-2">{{ __('modal_delete_warning') }}</p>
                </div>
                <div class="modal-footer">
                    <button class="uk-modal-close-default" type="button" uk-close></button>
                    {{-- <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> {{ __('Submit') }}</button> --}}
                    <button type="submit" class="btn btn-danger"><i class="fa-solid fa-trash-can"></i> {{ __('btn_delete') }}</button>
                </div>
            </div><!-- /.modal-content -->
          </form>
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->