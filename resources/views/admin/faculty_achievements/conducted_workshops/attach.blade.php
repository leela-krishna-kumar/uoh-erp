<div id="brochureattachdocument-{{ $workshop->id }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="photoModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="photoModalLabel">{{ __('Photo') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                @php
                    $extension = pathinfo($workshop->brochure_attach, PATHINFO_EXTENSION);
                @endphp
                @if($extension === 'png' || $extension === 'jpeg' || $extension === 'jpg')
                    <img src="{{ asset('uploads/user/'. $workshop->brochure_attach ) }}" />
                @else
                    <iframe src="{{ asset('uploads/user/'. $workshop->brochure_attach ) }}" width="100%" height="500px"></iframe>
                @endif
            </div>
        </div>
    </div>
</div>

<div id="certificateattachdocument-{{ $workshop->id }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="photoModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="photoModalLabel">{{ __('Photo') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                @php
                    $extension = pathinfo($workshop->certificate_attach, PATHINFO_EXTENSION);
                @endphp
                @if($extension === 'png' || $extension === 'jpeg' || $extension === 'jpg')
                    <img src="{{ asset('uploads/user/'. $workshop->certificate_attach ) }}" />
                @else
                    <iframe src="{{ asset('uploads/user/'. $workshop->certificate_attach ) }}" width="100%" height="500px"></iframe>
                @endif
            </div>
        </div>
    </div>
</div>

<div id="scheduleattachdocument-{{ $workshop->id }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="photoModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="photoModalLabel">{{ __('Photo') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                @php
                    $extension = pathinfo($workshop->schedule_attach, PATHINFO_EXTENSION);
                @endphp
                @if($extension === 'png' || $extension === 'jpeg' || $extension === 'jpg')
                    <img src="{{ asset('uploads/user/'. $workshop->schedule_attach ) }}" />
                @else
                    <iframe src="{{ asset('uploads/user/'. $workshop->schedule_attach ) }}" width="100%" height="500px"></iframe>
                @endif
            </div>
        </div>
    </div>
</div>