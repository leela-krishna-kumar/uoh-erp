<form class="needs-validation mt-3" novalidate action="{{ route('admin.document.store') }}" method="post" enctype="multipart/form-data">
    @csrf
    {{-- @method('PUT') --}}
   <input type="hidden" name="type" value="user">
   <input type="hidden" name="user_id" value="{{ $row->id }}">
        <fieldset class="row scheduler-border">
            <div class="form-group col-md-6">
                <label for="photo">{{ __('field_photo') }}: <span>{{ __('image_size', ['height' => 300, 'width' => 300]) }}</span></label>
                <div class="input-group">
                    <input type="file" class="form-control" name="photo" id="photo" value="{{ @$row->photo }}">
                    {{-- @if($row->photo != null && $row->photo != '')
                        <button type="button" class="btn btn-icon btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#imagedocument-{{ @$row->id }}">
                            <i class="fas fa-eye"></i>
                        </button>
                        @include('admin.user.documents.image')
                    @endif --}}
                </div>
                
                @if($row->photo != null && $row->photo != '')
                    @if($row->photo != null && $row->photo != '')
                        <u><a href="{{ $row->photo }}" data-bs-toggle="modal" data-bs-target="#imagedocument-{{ $row->id }}"></i> <span style="color: blue;">{{ $row->photo }}</span></a></u>
                        @include('admin.user.documents.image')
                    @endif
                @endif


                <div class="invalid-feedback">
                    {{ __('required_field') }} {{ __('field_photo') }}
                </div>
            </div>
            
            <div class="form-group col-md-6">
                <label for="signature">{{ __('field_signature') }}: <span>{{ __('image_size', ['height' => 300, 'width' => 300]) }}</span></label>
                <div class="input-group">
                    <input type="file" class="form-control" name="signature" id="signature" value="{{ @$row->signature }}">
                </div>
                @if($row->signature != null && $row->signature != '')
                    @if($row->signature != null && $row->signature != '')
                        <u><a href="{{ $row->signature }}" data-bs-toggle="modal" data-bs-target="#signaturedocument-{{ $row->id }}"></i> <span style="color: blue;">{{ $row->signature }}</span></a></u>
                        @include('admin.user.documents.image')
                    @endif
                @endif
                <div class="invalid-feedback">
                    {{ __('required_field') }} {{ __('field_signature') }}
                </div>
            </div>

            <div class="form-group col-md-6">
                <label for="resume">{{ __('field_resume') }}: <span>{{ __('image_size', ['height' => 300, 'width' => 300]) }}</span></label>
                <div class="input-group">
                    <input type="file" class="form-control" name="resume" id="resume" value="{{ @$row->resume }}">
                </div>
                @if($row->resume != null && $row->resume != '')
                    <u><a href="{{ $row->resume }}" data-bs-toggle="modal" data-bs-target="#resumedocument-{{ $row->id }}"></i> <span style="color: blue;">{{ $row->resume }}</span></a></u>
                    @include('admin.user.documents.image')
                @endif
                <div class="invalid-feedback">
                    {{ __('required_field') }} {{ __('field_resume') }}
                </div>
            </div>

            <div class="form-group col-md-6">
                <label for="joining_letter">{{ __('field_joining_letter') }}: <span>{{ __('image_size', ['height' => 300, 'width' => 300]) }}</span></label>
                <div class="input-group">
                    <input type="file" class="form-control" name="joining_letter" id="joining_letter" value="{{ @$row->joining_letter }}">
                </div>
                @if($row->joining_letter != null && $row->joining_letter != '')
                    <u><a href="{{ $row->joining_letter }}" data-bs-toggle="modal" data-bs-target="#joiningletterdocument-{{ $row->id }}"></i> <span style="color: blue;">{{ $row->joining_letter }}</span></a></u>
                    @include('admin.user.documents.image')
                @endif
                <div class="invalid-feedback">
                    {{ __('required_field') }} {{ __('field_joining_letter') }}
                </div>
            </div>

            <div class="form-group col-md-6">
                <label for="aadhar_image">Aadhar Image<span>{{ __('image_size', ['height' => 300, 'width' => 300]) }}</span></label>
                <div class="input-group">
                    <input type="file" class="form-control" name="aadhar_image" id="aadhar_image" value="{{ @$row->aadhar_image }}">
                </div>
                @if($row->aadhar_image != null && $row->aadhar_image != '')
                    <u><a href="{{ $row->aadhar_image }}" data-bs-toggle="modal" data-bs-target="#driverAdharImage-{{ $row->id }}"></i> <span style="color: blue;">{{ $row->aadhar_image }}</span></a></u>
                    @include('admin.fleets.image')
                @endif
            </div>

            <div class="form-group col-md-6">
                <label for="driving_license_pic">Driving License<span>{{ __('image_size', ['height' => 300, 'width' => 300]) }}</span></label>
                <div class="input-group">
                    <input type="file" class="form-control" name="driving_license_pic" id="driving_license_pic" value="{{ @$row->driving_license_pic }}">
                </div>
                @if($row->driving_license_pic != null && $row->driving_license_pic != '')
                    <u><a href="{{ $row->driving_license_pic }}" data-bs-toggle="modal" data-bs-target="#drivingLicenseImage-{{ $row->id }}"></i> <span style="color: blue;">{{ $row->driving_license_pic }}</span></a></u>
                    @include('admin.fleets.image')
                @endif
            </div>
        </fieldset>
        <fieldset class="row scheduler-border">
            <legend>{{ __('field_upload') }} {{ __('field_document') }}</legend>
            <div class="container-fluid">
                <div id="newDocument" class="clearfix">
                    <?php foreach($documents as $document): ?>
                        <div id="documentFormField" class="row">
                            
                            <div class="form-group col-md-4">
                                <label for="title" class="form-label">{{ __('field_title') }} <span>*</span></label>
                                <input type="text" class="form-control" name="titles[]" value="<?= $document->title ?>" required>
                                <div class="invalid-feedback">{{ __('required_field') }} {{ __('field_title') }}</div>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="document" class="form-label">{{ __('field_document') }} <span>*</span></label>
                                <input type="file" class="form-control" name="documents[]" value="<?= $document->attach ?>">
                                @if(isset($document->id))
                                    <input type="hidden" name="documentids[]" value="{{ $document->id }}">
                                    <u><a href="{{ $document->attach }}" data-bs-toggle="modal" data-bs-target="#uploadeddocument-{{ $document->id }}"><span style="color: blue;">{{ $document->attach }}</span></a></u>
                                @else
                                    <input type="hidden" name="documentids[]" value="">
                                @endif
                                <div class="invalid-feedback">{{ __('required_field') }} {{ __('field_document') }}</div>
                            </div>

                            <div id="uploadeddocument-{{ $document->id }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="photoModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="photoModalLabel">Document</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        </div>
                                        <div class="modal-body">
                                            @php
                                                $extension = pathinfo($document->attach, PATHINFO_EXTENSION);
                                            @endphp
                                            @if($extension === 'png' || $extension === 'jpeg' || $extension === 'jpg')
                                                <img src="{{ asset('uploads/student/'. $document->attach ) }}" />
                                            @else
                                                <iframe src="{{ asset('uploads/student/'. $document->attach ) }}" width="100%" height="500px"></iframe>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-3">
                                <button id="removeDocument" type="button" class="btn btn-danger btn-filter"><i class="fas fa-trash-alt"></i> {{ __('btn_remove') }}</button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="form-group">
                    <input type="hidden" name="documentids[]" value="">
                    <input type="hidden" name="documents[]" value="">
                    <button id="addDocument" type="button" class="btn btn-info"><i class="fas fa-plus"></i> {{ __('btn_add_new') }}</button>
                </div>
            </div>
        </fieldset>
 <div class="row">
     <div class="col-md-12 text-right">
        <button type="submit" class="btn btn-primary">Save</button>
      </div>
 </div>
</form>