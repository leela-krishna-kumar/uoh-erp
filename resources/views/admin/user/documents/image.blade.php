<!-- Modal for photo -->
<div id="imagedocument-{{ $row->id }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="photoModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="photoModalLabel">{{ __('Photo') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                @php
                    $extension = pathinfo($row->photo, PATHINFO_EXTENSION);
                @endphp
                @if($extension === 'png' || $extension === 'jpeg' || $extension === 'jpg')
                    <img src="{{ asset('uploads/student/'. $row->photo ) }}" />
                @else
                    <iframe src="{{ asset('uploads/student/'. $row->photo ) }}" width="100%" height="500px"></iframe>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Modal for signature -->
<div id="signaturedocument-{{ $row->id }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="photoModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="photoModalLabel">Signature</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                @php
                    $extension = pathinfo($row->signature, PATHINFO_EXTENSION);
                @endphp
                @if($extension === 'png' || $extension === 'jpeg' || $extension === 'jpg')
                <img src="{{ asset('uploads/student/'. $row->signature ) }}" />
                @else
                    <iframe src="{{ asset('uploads/student/'. $row->signature ) }}" width="100%" height="500px"></iframe>
                @endif
            </div>
        </div>
    </div>
</div>

<div id="resumedocument-{{ $row->id }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="photoModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="photoModalLabel">Resume</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                @php
                    $extension = pathinfo($row->resume, PATHINFO_EXTENSION);
                @endphp
                @if($extension === 'png' || $extension === 'jpeg' || $extension === 'jpg')
                <img src="{{ asset('uploads/student/'. $row->resume ) }}" />
                @else
                    <iframe src="{{ asset('uploads/student/'. $row->resume ) }}" width="100%" height="500px"></iframe>
                @endif
            </div>
        </div>
    </div>
</div>


<!-- Modal for Joining Letter -->
<div id="joiningletterdocument-{{ $row->id }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="photoModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="photoModalLabel">Joining Letter</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                @php
                    $extension = pathinfo($row->joining_letter, PATHINFO_EXTENSION);
                @endphp
                @if($extension === 'png' || $extension === 'jpeg' || $extension === 'jpg')
                <p>if</p>
                <img src="{{ asset('uploads/student/'. $row->joining_letter ) }}" />
                @else
                <p>else</p>
                    <iframe src="{{ asset('uploads/student/'. $row->joining_letter ) }}" width="100%" height="500px"></iframe>
                @endif
            </div>
        </div>
    </div>
</div>


