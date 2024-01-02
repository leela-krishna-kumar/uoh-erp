<div class="row mt-3">
   <div class="col-md-12">
      {{-- School --}}
      <fieldset class="row scheduler-border">
         <div class="d-flex justify-content-between">
            <div>
               <legend class="mt-2">{{ __('field_school_information') }}</legend>
            </div>
            <div class="mb-1">
               <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#createSchoolModal-{{ $student->id }}" type="button" class="btn btn-info"><i class="fas fa-plus"></i> {{ __('btn_add_new') }}</a>
            </div>
         </div>
         <!-- [ Data table ] start -->
         <div class="table-responsive">
            <table id="table" class="display table nowrap table-striped table-hover" style="width:100%">
               <thead>
                  <tr>
                        <th>#</th>
                        <th>{{ __('field_school_name') }}</th>
                        <th>{{ __('field_board') }}</th>
                        <th>{{ __('field_year_of_passing') }}</th>
                        <th>{{ __('field_exam_id') }}</th>
                        <th>{{ __('field_hall_ticket_no') }}</th>
                        <th>{{ __('field_marks') }}</th>
                        <th>{{ __('field_percenteage') }}</th>
                        <th>{{ __('GPA') }}</th>
                        <th>{{ __('field_action') }}</th>
                  </tr>
               </thead>
               <tbody>
                  @foreach($school_educations as $key => $school_education )
                     <tr>
                           <td>{{ $key + 1 }}</td>
                           <td>{{ @$school_education->payload['school_name'] }}</td>
                           <td>{{ @$school_education->payload['board'] }}</td>
                           <td>
                           {{ @$school_education->payload['year_of_passing'] }}
                           </td>
                           <td>
                           {{ @$school_education->payload['school_exam_id'] }}
                           </td>
                           <td>
                           {{ @$school_education->payload['hall_ticket_no'] }}
                           </td>
                           <td>
                            {{ @$school_education->payload['obtain_marks'] }} / {{ @$school_education->payload['total_marks'] }}
                           </td>
                           <td>
                            {{ @$school_education->payload['obtain_marks'] / @$school_education->payload['total_marks'] * 100 }}%
                           <!-- {{ @$school_education->payload['percentage'] }} -->
                           </td>
                           <td>
                           {{ @$school_education->payload['gpa'] }}
                           </td>
                           <td>
                              <button type="button" class="btn btn-icon btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editSchoolModal-{{ @$school_education->id }}"><i class="fas fa-edit"></i>
                              </button>
                              @include('admin.educational-info.school.edit')
                              <button type="button" class="btn btn-icon btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteSchoolModal-{{ @$school_education->id }}">
                                 <i class="fas fa-trash-alt"></i>
                              </button>
                              @include('admin.educational-info.school.delete')
                           </td>
                     </tr>
                  @endforeach
               </tbody>
            </table>
         </div>
         <!-- [ Data table ] end -->
      </fieldset>
   </div>
</div>
@include('admin.educational-info.school.create')
