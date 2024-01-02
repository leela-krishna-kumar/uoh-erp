

{{-- <div id="jobDescriptionModal-{{$row->id}}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">View Holidays Description</h5>
                
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
             
            </div>
           
            <div class="modal-body " id="html-content-{{$row->id}}">
                <!-- Details View Start -->
                <h5>
                    <mark class="text-primary">Designation :</mark> {{ $row->title }}
                </h5>
                <hr/>
                <div class="">
                    <div class="row">
                        <div class="col-md-12 max-scroll">
                            <p><mark class="text-primary">{{ __('field_description') }}:</mark> {!! $row->job_description !!}</p><hr/>
                        </div>
                    </div>
                </div>
                <!-- Details View End -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-times"></i> {{ __('btn_close') }}</button>
                <div>
                    <li class="dropdown-item p-0"><a href="Javascript:void(0)" title="Download PDF"  class="btn btn-sm download-pdf btn btn-success" 
                        onclick="CreatePDFfromHTML('{{$row->id}}')">Download</a>
                    </li>
                </div>
            </div>
        </div>
    </div>
</div> --}}
