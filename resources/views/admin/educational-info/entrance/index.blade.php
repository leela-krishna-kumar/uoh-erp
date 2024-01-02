<div class="row">
   <div class="col-md-12">
      <fieldset class="row scheduler-border">
         <div class="d-flex justify-content-between">
            <div>
               <legend>{{ __('field_entrance_information') }}</legend>
            </div>
            <div class="mb-1">
               <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#createEntranceModal-{{ $student->id }}" type="button" class="btn btn-info"><i class="fas fa-plus"></i> {{ __('btn_add_new') }}</a>
            </div>
         </div>
         <!-- [ Data table ] start -->
         <div class="table-responsive">
            <table id="table" class="display table nowrap table-striped table-hover" style="width:100%">
               <thead>
                  <tr>
                        <th>#</th>
                        <th>{{ __('field_entrance_exam_name') }}</th>
                        <th>{{ __('field_hall_ticket_no') }}</th>
                        <th>{{ __('field_rank') }}</th>
                        <th>{{ __('field_action') }}</th>
                  </tr>
               </thead>
               <tbody>
                  @foreach($entrances as $key => $entrance)
                     <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ @$entrance->payload['exam_name'] }}</td>
                        <td>
                        {{ @$entrance->payload['hall_ticket_number'] }}
                        </td>
                        <td>
                        {{ @$entrance->payload['rank'] }}
                        </td>
                        <td>
                           <button type="button" class="btn btn-icon btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editEntranceModal-{{ @$entrance->id }}"><i class="fas fa-edit"></i>
                           </button>
                              @include('admin.educational-info.entrance.edit')
                           <button type="button" class="btn btn-icon btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteEntranceModal-{{ @$entrance->id }}"><i class="fas fa-trash-alt"></i>
                           </button>
                              @include('admin.educational-info.entrance.delete')
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
@include('admin.educational-info.entrance.create')