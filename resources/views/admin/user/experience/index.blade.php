<div class="row mt-3">
    <div class="col-md-12">
       {{-- School --}}
       <fieldset class="row scheduler-border">
          <div class="d-flex justify-content-between">
             <div>
                <legend class="mt-2">{{ __('field_experience') }}</legend>
             </div>
             <div class="mb-1">
                <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#createExperience-{{ $row->id }}" type="button" class="btn btn-info"><i class="fas fa-plus"></i> {{ __('btn_add_new') }}</a>
             </div>
          </div>
          <!-- [ Data table ] start -->
          <div class="table-responsive">
             <table id="table" class="display table nowrap table-striped table-hover" style="width:100%">
                <thead>
                   <tr>
                         <th>#</th>
                         <th>{{ __('Type') }}</th>
                         <th>{{ __('field_subject') }}</th>
                         <th>{{ __('field_organization') }}</th>
                         <th>{{ __('field_from_date') }}</th>
                         <th>{{ __('field_to_date') }}</th>
                         <th>{{ __('field_action') }}</th>
                   </tr>
                </thead>
                <tbody>
                   @foreach($experiences as $key => $experience )
                      <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ @$experience->type ? $experience->type_parsed->label : '' }}</td>
                            <td>{{ @$experience->subject }}</td>
                            <td>{{ @$experience->organization }}</td>
                            <td>{{ @$experience->from_date }}</td>
                            <td>{{ @$experience->to_date }}</td>
                            <td>
                               <button type="button" class="btn btn-icon btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editExperienceModal-{{ @$experience->id }}"><i class="fas fa-edit"></i>
                               </button>
                               @include('admin.user.experience.edit')
                               <button type="button" class="btn btn-icon btn-danger btn-sm" data-bs-toggle="modal"data-bs-target="#deleteExperienceModal-{{ @$experience->id }}">
                                  <i class="fas fa-trash-alt"></i>
                               </button>
                               @include('admin.user.experience.delete')
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
 @include('admin.user.experience.create')