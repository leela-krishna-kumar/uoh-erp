<div class="row mt-3">
    <div class="col-md-12">
       {{-- School --}}
       <fieldset class="row scheduler-border">
          <div class="d-flex justify-content-between">
             <div>
                <legend class="mt-2">{{ __('tab_educational_info') }}</legend>
             </div>
             <div class="mb-1">
                <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#createEducation-{{ $row->id }}" type="button" class="btn btn-info"><i class="fas fa-plus"></i> {{ __('btn_add_new') }}</a>
             </div>
          </div>
          <!-- [ Data table ] start -->
          <div class="table-responsive">
             <table id="table" class="display table nowrap table-striped table-hover" style="width:100%">
                <thead>
                   <tr>
                         <th>#</th>
                         <th>{{ __('field_education_level') }}</th>
                         <th>{{ __('field_year_of_graduation') }}</th>
                         <th>{{ __('field_graduation_academy') }}</th>
                         <th>{{ __('field_graduation_field') }}</th>
                         <!-- <th>{{ __('field_experience') }}</th> -->
                         <th>{{ __('field_action') }}</th>
                   </tr>
                </thead>
                <tbody>
                   @foreach($educations as $key => $education )
                      <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ @$education->education_type }}</td>
                            <td>{{ @$education->payload['year_of_graduation'] }}</td>
                            <td>{{ @$education->payload['graduation_academy'] }}</td>
                            <td>{{ @$education->payload['graduation_field'] }}</td>
                            <!-- <td>{{ @$education->payload['experience'] }}</td> -->
                            <td>
                               <button type="button" class="btn btn-icon btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editEducationalModal-{{ @$education->id }}"><i class="fas fa-edit"></i>
                               </button>
                               @include('admin.user.educational.edit')
                               <button type="button" class="btn btn-icon btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteEducationalModal-{{ @$education->id }}">
                                  <i class="fas fa-trash-alt"></i>
                               </button>
                               @include('admin.user.educational.delete')
                            </td>
                      </tr>
                   @endforeach
                </tbody>
             </table>
          </div>
          <!-- [ Data table ] end -->
       </fieldset>
       @php
         $array = ['SSC', 'Inter', 'UG', 'PG', 'Ph.D'];
         $education_level = App\Models\Education::where('model_id', auth()->user()->id)->where('education_type', 'Diploma')->first();
         if($education_level)
         {
         $array = ['SSC', 'UG', 'PG', 'Ph.D'];
         }
         $education_level = App\Models\Education::where('model_id', auth()->user()->id)->pluck('education_type')->toArray();
         $not_details = array_diff($array, $education_level);
      @endphp
      <p style="text-align: center; color: red;">
         *Please fill these details: 
         @foreach($not_details as $detail)
             {{ $detail }},
         @endforeach
     </p>
    </div>
 </div>
 @include('admin.user.educational.create')