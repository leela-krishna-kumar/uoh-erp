<div class="row mt-3">
    <div class="col-md-12">
       <fieldset class="row scheduler-border">
          <div class="d-flex justify-content-between">
             <div>
                <legend class="mt-2">Research</legend>
             </div>
             @php
             $researches = App\Models\StaffResearcherId::where('user_id', $row->id)->get();
             @endphp
             <div class="mb-1">
                @if($researches->count() < 1)
                    <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#createResearch-{{ $row->id }}" type="button" class="btn btn-info"><i class="fas fa-plus"></i> {{ __('btn_add_new') }}</a>
                @endif
             </div>
          </div>
          <div class="table-responsive">
             <table id="table" class="display table nowrap table-striped table-hover" style="width:100%">
                <thead>
                   <tr>
                         <th>#</th>
                         <th>Vidwan Id</th>
                         <th>Orcid Id</th>
                         <th>Researcher Id</th>
                         <th>Scopus Id</th>
                         <th>Google Scholar Id</th>
                         <th>WOS Id</th>
                         <th>{{ __('field_action') }}</th>
                   </tr>
                </thead>
                <tbody>
                    @foreach($researches as $key => $research)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ @$research->vidwan_id }}</td>
                            <td>{{ @$research->orcid_id }}</td>
                            <td>{{ @$research->researcher_id }}</td>
                            <td>{{ @$research->scopus_id }}</td>
                            <td>{{ @$research->google_scholar_id }}</td>
                            <td>{{ @$research->wos_id }}</td>
                            <td>
                                <button type="button" class="btn btn-icon btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editResearchModal-{{ @$research->id }}"><i class="fas fa-edit"></i>
                                </button>
                                @include('admin.user.research.edit')
                                <button type="button" class="btn btn-icon btn-danger btn-sm" data-bs-toggle="modal"data-bs-target="#deleteResearchModal-{{ @$research->id }}">
                                   <i class="fas fa-trash-alt"></i>
                                </button>
                                @include('admin.user.research.delete')
                             </td>
                        </tr>
                    @endforeach
                </tbody>
             </table>
          </div>
       </fieldset>
    </div>
 </div>
 @include('admin.user.research.create')