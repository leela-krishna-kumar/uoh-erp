<div class="card-block" id="deleteRoutine-{{ $row->id }}">
      <div class="row">
            @isset($row)
            <input type="text" name="routine_id[]" value="{{ $row->id }}" hidden>
            <input type="checkbox" id="delete_routine-{{ $row->id }}" name="delete_routine[]" value="{{ $row->id }}" hidden>
            @endisset

            <div class="form-group col-md-2">
                  <label for="subject">{{ __('field_subject') }} <span>*</span></label>
                  <select class="form-control select2 subject-dropdown" name="subject[]" id="subject" required>
                        <option value="">{{ __('select') }}</option>
                        @foreach( $subjects as $subject )
                        <option value="{{ $subject->id }}" @isset($row) {{ $row->subject_id == $subject->id ? 'selected' : '' }} @endisset>{{ $subject->code }} - {{ $subject->title }}</option>
                        @endforeach
                  </select>

                  <div class="invalid-feedback">
                  {{ __('required_field') }} {{ __('field_subject') }}
                  </div>
            </div>
            <div class="form-group col-md-2">
                  <label for="teacher">{{ __('field_teacher') }} <span>*</span></label>
                  <select class="form-control select2 teacher-dropdown" name="teacher[]" id="teacher" required>
                        <option value="">{{ __('select') }}</option>
                        @foreach( $teachers as $teacher )
                        <option value="{{ $teacher->id }}" @isset($row) {{ $row->teacher_id == $teacher->id ? 'selected' : '' }} @endisset>{{ $teacher->staff_id }} - {{ $teacher->first_name }} {{ $teacher->last_name }}</option>
                        @endforeach
                  </select>

                  <div class="invalid-feedback">
                  {{ __('required_field') }} {{ __('field_teacher') }}
                  </div>
            </div>
            <div class="form-group col-md-2">
                  <label for="room">{{ __('field_room') }} {{ __('field_no') }} <span>*</span></label>
                  <select class="form-control select2" name="room[]" id="room" required>
                        <option value="">{{ __('select') }}</option>
                        @foreach( $rooms as $room )
                        <option value="{{ $room->id }}" @isset($row) {{ $row->room_id == $room->id ? 'selected' : '' }} @endisset>{{ $room->title }} - {{ $room->type }}</option>
                        @endforeach
                  </select>

                  <div class="invalid-feedback">
                  {{ __('required_field') }} {{ __('field_room') }} {{ __('field_no') }}
                  </div>
            </div>
            <div class="form-group col-md-2">
                  <label for="start_time">{{ __('field_time') }} {{ __('field_from') }} <span>*</span></label>
                  <input type="time" class="form-control time" name="start_time[]" id="start_time" value="{{ $row->start_time }}" required>

                  <div class="invalid-feedback">
                  {{ __('required_field') }} {{ __('field_time') }} {{ __('field_from') }}
                  </div>
            </div>
            <div class="form-group col-md-2">
                  <label for="end_time">{{ __('field_time') }} {{ __('field_to') }} <span>*</span></label>
                  <input type="time" class="form-control time" name="end_time[]" id="end_time" value="{{ $row->end_time }}" required>

                  <div class="invalid-feedback">
                  {{ __('required_field') }} {{ __('field_time') }} {{ __('field_to') }}
                  </div>
            </div>
            
            @isset($row)
            <div class="form-group col-md-2">
                  <div class="btn btn-danger btn-filter" onclick="deleteRoutine({{ $row->id }})">
                        <span><i class="fas fa-trash-alt"></i> {{ __('btn_remove') }}</span>
                  </div>
            </div>
            @endisset
      </div>
</div>
<script>
      $(document).ready(function () {
    $('.subject-dropdown').off('change').on('change', function () {
        var selectedSubjectId = $(this).val();
        var managedBy = $(this).find('option:selected').data('managed_by');
        var teacherSelect = $(this).closest('.row').find('.teacher-dropdown');

        var routeUrl = "{{ route('admin.get-subject-teacher-list') }}";
        
        $.ajax({
            url: routeUrl,
            method: 'GET',
            data: { subject_id: selectedSubjectId },
            success: function (data) {
                teacherSelect.empty();
                teacherSelect.append('<option value="">{{ __("Select") }}</option>');
                
                $.each(data, function (index, teacher) {
                    teacherSelect.append($('<option>', {
                        value: teacher.id,
                        text: teacher.staff_id + ' - ' + teacher.first_name + ' ' + teacher.last_name
                    }));
                });
            },
            error: function (xhr, status, error) {
                console.error(error);
            }
        });
    });
});
</script>
