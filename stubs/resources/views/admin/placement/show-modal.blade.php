    <!-- Edit modal content -->
    <div id="showplacement-{{$row->id}}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">View Placement</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <!-- Details View Start -->
                    <h5>
                        <mark class="text-primary">Company :</mark> {{ @$row->company->name }}
                    </h5>
                    <hr/>
                    <p>
                        <mark class="text-primary">Date Of Visit :</mark> {{ $row->date }}
                    </p>
                    <hr/>
                    <div class="">
                        <div class="row">
                            <div class="col-md-12">
                                <p><mark class="text-primary">Contact Person Name :</mark>{{ @$row->company->contact_person_name}}</p><hr/>

                                <p><mark class="text-primary">Contact Person Phone :</mark> {{ @$row->company->contact_person_phone}} </p><hr/>

                                <p><mark class="text-primary">{{ __('field_status') }}:</mark> 
                                @if($row->status == 1 )
                                <span class="badge badge-pill badge-success">{{ __('status_active') }}</span>
                                @else
                                <span class="badge badge-pill badge-danger">{{ __('status_inactive') }}</span>
                                @endif
                                <hr/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 max-scroll">
                                <p><mark class="text-primary">{{ __('field_description') }}:</mark> {!! $row->description !!}</p><hr/>
                            </div>
                        </div>
                    </div>
                    <!-- Details View End -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-times"></i> {{ __('btn_close') }}</button>
                </div>
            </div>
        </div>
    </div>