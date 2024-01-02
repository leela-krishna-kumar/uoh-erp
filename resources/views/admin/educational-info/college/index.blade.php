<div class="row">
   <div class="col-md-12">
      {{-- college --}}
      <fieldset class="row scheduler-border">
         <div class="d-flex justify-content-between">
            <div>
               <legend>{{ __('field_college_information') }}</legend>
            </div>
            <div class="mb-1">
               <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#createCollegeModal-{{ $student->id }}" type="button" class="btn btn-info"><i class="fas fa-plus"></i> {{ __('btn_add_new') }}</a>
            </div>
         </div>
         <!-- [ Data table ] start -->
         <div class="table-responsive">
            <table id="table" class="display table nowrap table-striped table-hover" style="width:100%">
               <thead>
                  <tr>
                        <th>#</th>
                        <th>{{ __('field_collage_name') }}</th>
                        <th>{{ __('field_institution') }}</th>
                        <th>{{ __('field_graduation_year') }}</th>
                        <th>{{ __('field_exam_id') }}</th>
                        <th>{{ __('field_hall_ticket_no') }}</th>
                        <th>{{ __('field_graduation_point') }}</th>
                        <th>{{ __('field_action') }}</th>
                  </tr>
               </thead>
               <tbody>
                  @foreach($college_educations as $key => $college_education)
                     <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ @$college_education->payload['collage_name'] }}</td>
                        <td>
                           {{ @$college_education->payload['institution'] }}
                        </td>
                        <td>{{ @$college_education->payload['collage_graduation_year'] }}</td>
                        <td>
                        {{ @$college_education->payload['collage_exam_id'] }}
                        </td>
                        <td>
                        {{ @$college_education->payload['hall_ticket_no'] }}
                        </td>
                        <td>
                        {{ @$college_education->payload['collage_graduation_point'] }}
                        </td>
                        <td>
                           <button type="button" class="btn btn-icon btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editCollegeModal-{{ @$college_education->id }}"><i class="fas fa-edit"></i>
                           </button>
                              @include('admin.educational-info.college.edit')
                           <button type="button" class="btn btn-icon btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteCollegeModal-{{ @$college_education->id }}"><i class="fas fa-trash-alt"></i>
                           </button>
                              @include('admin.educational-info.college.delete')
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
@include('admin.educational-info.college.create')