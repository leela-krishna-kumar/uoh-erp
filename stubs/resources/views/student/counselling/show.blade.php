<div id="showCounselling-{{ $row->id }}" uk-modal>
    <div class="uk-modal-dialog">
        <button class="uk-modal-close-default" type="button" uk-close></button>
        <div class="uk-modal-header">
            <h2 class="uk-modal-title">Counselling</h2>
        </div>
        <div class="uk-modal-body">
            <!-- Details View Start -->
            <div class="row">
                <div class="col-md-6">
                    <p><mark class="text-primary">{{ __('Date') }}:</mark> {{ $row->date }}</p><hr/>
                </div>
                <div class="col-md-6">
                    <p><mark class="text-primary">{{ __('Time') }}:</mark> {{ $row->time }}</p><hr/>
                </div>
                <div class="col-md-6">
                    <p><mark class="text-primary">{{ __('Category') }}:</mark> {{ $row->category->name }}</p><hr/>
                </div>
                <div class="col-md-6">
                   <p><mark class="text-primary">{{ __('Status') }}:</mark> 
                    @if( $row->status == 0)
                        <span class="badge badge-pill badge-primary">{{ __('Scheduled') }}</span>
                    @elseif( $row->status == 1)
                        <span class="badge badge-pill badge-secondary">{{ __('Requested') }}</span>
                    @elseif( $row->status == 2 )
                        <span class="badge badge-pill badge-success">{{ __('Completed') }}</span>
                    @else
                        <span class="badge badge-pill badge-danger">{{ __('Cancelled') }}</span>
                    @endif
                    </p><hr/>
                </div>
                <div class="col-md-12">
                    <p><mark class="text-primary">{{ __('Note') }}:</mark> {{ $row->note }}</p><hr/>
                </div>
            </div>
            <!-- Details View End -->
        </div>
    </div>
</div>