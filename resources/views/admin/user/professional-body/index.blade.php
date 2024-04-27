<div class="row mt-3">
    <div class="col-md-12">
       <fieldset class="row scheduler-border">
          <div class="d-flex justify-content-between">
             <div>
                <legend class="mt-2">Research</legend>
             </div>
             @php
             $professions = App\Models\ProfessionalBody::where('user_id', $row->id)->get();
             @endphp
             <div class="mb-1">
                {{-- @if($professions->count() < 1) --}}
                    <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#createprofession-{{ $row->id }}" type="button" class="btn btn-info"><i class="fas fa-plus"></i> {{ __('btn_add_new') }}</a>
                {{-- @endif --}}
             </div>
          </div>
          <div class="table-responsive">
             <table id="table" class="display table nowrap table-striped table-hover" style="width:100%">
                <thead>
                   <tr>
                         <th>#</th>
                         <th>Membership Name</th>
                         <th>Membership Id</th>
                         {{-- <th>Others Membership Type</th> --}}
                         <th>Id Card</th>
                         <th>{{ __('field_action') }}</th>
                   </tr>
                </thead>
                <tbody>
                    @foreach($professions as $key => $profession)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>
                                @if ($profession->membership_name == 'others')
                                    {{ ucfirst($profession->others_membership_type) }}
                                @else
                                {{ @$profession->membership_name }}
                                @endif</td>
                            <td>{{ @$profession->membership_id }}</td>
                            {{-- <td>{{ @$profession->others_membership_type }}</td> --}}
                            <td>
                              <button type="button" class="btn btn-icon btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#idcardProfesionModal-{{ @$profession->id }}">
                                 <i class="fas fa-eye"></i>
                              </button>

                              @include('admin.user.professional-body.idcard')
                            </td>
                            <td>
                                <button type="button" class="btn btn-icon btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editProfesionModal-{{ @$profession->id }}"><i class="fas fa-edit"></i>
                                </button>
                                @include('admin.user.professional-body.edit')
                                <button type="button" class="btn btn-icon btn-danger btn-sm" data-bs-toggle="modal"data-bs-target="#deleteProfesionModal-{{ @$profession->id }}">
                                   <i class="fas fa-trash-alt"></i>
                                </button>
                                @include('admin.user.professional-body.delete')
                             </td>
                        </tr>
                    @endforeach
                </tbody>
             </table>
          </div>
       </fieldset>
    </div>
 </div>
 @include('admin.user.professional-body.create')
