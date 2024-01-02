<div class="row">
     <div class="col-md-12">
         <div class="mt-3">
            <fieldset class="row scheduler-border">
               <legend>{{ __('field_documents') }}</legend>
               <div class="form-group col-md-6">
                  <label for="photo">{{ __('field_photo') }}: <span>{{ __('image_size', ['height' => 300, 'width' => 300]) }}</span></label>
                  <input type="file" class="form-control" name="photo" id="photo" value="{{ old('photo') }}">
    
                  <div class="invalid-feedback">
                     {{ __('required_field') }} {{ __('field_photo') }}
                  </div>
    
                  @if(is_file('uploads/'.$path.'/'.$student->photo))
                        <img src="{{ asset('uploads/'.$path.'/'.$student->photo) }}" class="img-fluid" style="max-width: 80px; max-height: 80px;" onerror="this.src='{{ asset('dashboard/images/user/avatar-1.jpg') }}';">
                  @endif
               </div>
    
               <div class="form-group col-md-6">
                  <label for="signature">{{ __('field_signature') }}: <span>{{ __('image_size', ['height' => 100, 'width' => 300]) }}</span></label>
                  <input type="file" class="form-control" name="signature" id="signature" value="{{ old('signature') }}">
    
                  <div class="invalid-feedback">
                     {{ __('required_field') }} {{ __('field_signature') }}
                  </div>
    
                  @if(is_file('uploads/'.$path.'/'.$student->signature))
                        <img src="{{ asset('uploads/'.$path.'/'.$student->signature) }}" class="img-fluid" style="max-width: 80px; max-height: 80px;" onerror="this.src='{{ asset('dashboard/images/user/avatar-1.jpg') }}';">
                  @endif
               </div>
             </fieldset>
         </div>
         <fieldset class="row scheduler-border">
            <legend>{{ __('field_other_documents') }}</legend>
            <table class="table table-bordered">
               <thead>
                   <tr>
                       <th>{{ __('field_title') }}</th>
                       <th>{{ __('field_type') }}</th>
                       <th>{{ __('field_document') }}</th>
                       <th>{{ __('field_action') }}</th>
                   </tr>
               </thead>
               <tbody>
                   @foreach($student->documents as $document)
                   <tr>
                       <td>{{ $document->title }}</td>
                       <td>{{ @$document->type->name }}</td>
                       <td>
                           @if(is_file('uploads/'.$path.'/'.$document->attach))
                              <a href="{{ asset('uploads/'.$path.'/'.$document->attach) }}" class="btn btn-sm btn-icon btn-dark" download><i class="fas fa-download"></i></a>
                           @endif
                       </td>
                       <td>
                        <button type="button" class="btn btn-icon btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editDocumentModal-{{ @$document->id }}"><i class="fas fa-edit"></i>
                        </button>
                        @include('admin.documents-info.edit')
                        <button type="button" class="btn btn-icon btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteDocumentModal-{{ @$document->id }}">
                           <i class="fas fa-trash-alt"></i>
                        </button>
                        @include('admin.documents-info.delete')
                     </td>
                   </tr>
                   @endforeach
               </tbody>
           </table>
           <legend>{{ __('field_upload') }} {{ __('field_document') }}</legend>
           <form class="needs-validation" novalidate action="{{ route('admin.document.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="student_id" value="{{ $student->id }}">
                <div class="container-fluid">
                <div id="newDocument" class="clearfix"></div>
                <div class="form-group">
                    <button id="addDocument" type="button" class="btn btn-info"><i class="fas fa-plus"></i> {{ __('btn_add_new') }}</button>
                </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary submit-btn">Save</button>
                    </div>
                </div>
            </form>
         </fieldset>
     </div>
   </div>
  