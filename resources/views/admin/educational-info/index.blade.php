@include('admin.educational-info.school.index')
@include('admin.educational-info.college.index')
@include('admin.educational-info.entrance.index')
<form class="needs-validation" novalidate action="{{ route('admin.update-academic-info',$student->id) }}" method="post">
    @csrf
   <input type="hidden" name="student_id" value="{{ $student->id }}">
   <fieldset class="row scheduler-border">
      <legend>{{ __('field_academic_information') }}</legend>
      @include('common.inc.academic_info_search')
   </fieldset>
   <fieldset class="row scheduler-border">
      <legend>{{ __('field_entry_details') }}</legend>
      @include('common.inc.entry_details_search')
      <div class="form-group col-md-4">
         <label for="status">Managed By</label>
         <select class="form-control select2" name="managed_by[]" id="managed_by"multiple>
         @foreach($teachers as $key => $teacher)
            <option value="{{ $teacher->id }}"  @if(@isset($student) && $student->managed_by != null && in_array($teacher->id,$student->managed_by)) selected @endif>{{ $teacher->first_name }} {{ $teacher->last_name }}</option>
         @endforeach
         </select>
         <div class="invalid-feedback">
            {{ __('required_field') }} {{ __('Managed By') }}
         </div>
      </div>
      <div class="form-group col-md-4">
         <label for="status">{{ __('field_group') }}</label>
         <select class="form-control" name="group_id" id="group_id">
         <option value="" readonly >{{ __('select') }}</option>
         @foreach($groups as $group )
            <option value="{{ $group->id }}" @if(isset($student) && $student->group_id == $group->id) selected @endif>{{ $group->name }}</option>
         @endforeach
         </select>
         <div class="invalid-feedback">
            {{ __('required_field') }} {{ __('field_group') }}
         </div>
      </div>
      <div class="form-group col-md-4">
         <label for="status">{{ __('field_admission_type') }}</label>
         <select class="form-control select2" name="status" id="status">
         @foreach( $statuses as $status )
            <option value="{{ $status->id }}" @if(isset($student) && $student->status == $status->id) selected @endif>{{ $status->title }}</option>
         @endforeach
         </select>
         <div class="invalid-feedback">
            {{ __('required_field') }} {{ __('field_admission_type') }}
         </div>
      </div>
     
      <div class="col-md-12 d-flex justify-content-end">
         <button type="submit" class="btn btn-primary">Save</button>
      </div>
   </fieldset>
</form>