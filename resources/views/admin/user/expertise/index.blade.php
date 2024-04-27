<div class="row mt-3">
    <div class="col-md-12">
       {{-- School --}}
       <fieldset class="row scheduler-border">
          <div class="d-flex justify-content-between">
             <div>
                <legend class="mt-2">Expertise</legend>
             </div>
             @php
             $expertise = App\Models\Expertise::where('user_id', $row->id)->get();
             @endphp
             <div class="mb-1">
                <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#createExpertise-{{ $row->id }}" type="button" class="btn btn-info"><i class="fas fa-plus"></i> {{ __('btn_add_new') }}</a>
             </div>
          </div>
          <!-- [ Data table ] start -->
          <div class="table-responsive">
             <table id="table" class="display table nowrap table-striped table-hover" style="width:100%">
                <thead>
                   <tr>
                         <th>#</th>
                         {{-- <th>{{ __('user_id') }}</th> --}}
                         <th>Area of Expertise</th>
                         <th>Topic</th>
                         <th>{{ __('field_action') }}</th>
                   </tr>
                </thead>
                <tbody>

                    @php
                        $i=1
                    @endphp

                   @foreach($expertise as $expertise )
                      <tr>
                            <td>{{ $i++ }}</td>

                            <td>{{ @$expertise->area_of_expertise }}</td>
                            <td>{{ @$expertise->topics }}</td>

                            <td>
                               <button type="button" class="btn btn-icon btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editExpertiseModal-{{ @$expertise->id }}"><i class="fas fa-edit"></i>
                               </button>
                               @include('admin.user.expertise.edit')
                               <button type="button" class="btn btn-icon btn-danger btn-sm" data-bs-toggle="modal"data-bs-target="#deleteExpertiseModal-{{ @$expertise->id }}">
                                  <i class="fas fa-trash-alt"></i>
                               </button>
                               @include('admin.user.expertise.delete')
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
 @include('admin.user.expertise.create')
