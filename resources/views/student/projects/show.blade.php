<div id="showProject-{{ $row->id }}" uk-modal>
    <div class="uk-modal-dialog">
        <button class="uk-modal-close-default" type="button" uk-close></button>
        <div class="uk-modal-header">
            <h2 class="uk-modal-title">Project</h2>
        </div>
        <div class="uk-modal-body">
            <!-- Details View Start -->
            <h4>
                <mark class="text-primary">{{ __('Title') }}:</mark> {{ $row->title }}
            </h4>
            <hr/>
            <div class="row">
                <div class="col-md-12">
                   <p><mark class="text-primary">{{ __('Category') }}:</mark> {{ $row->category->name }}</p><hr/>

                   <p><mark class="text-primary">{{ __('Status') }}:</mark> 
                        @if( $row->status == 0)
                            <span class="badge badge-pill badge-primary">{{ __('Assigned') }}</span>
                        @elseif( $row->status == 1)
                            <span class="badge badge-pill badge-secondary">{{ __('Draft') }}</span>
                        @elseif( $row->status == 2 )
                            <span class="badge badge-pill badge-info">{{ __('In Review') }}</span>
                        @elseif( $row->status == 3 )
                            <span class="badge badge-pill badge-danger">{{ __('Rejected') }}</span>
                        @else
                            <span class="badge badge-pill badge-success">{{ __('Review') }}</span>
                        @endif
                    </p><hr/>
                    <p><mark class="text-primary">{{ __('Description') }}:</mark> {{ $row->description }}</p><hr/>

                </div>
            </div>
            <!-- Details View End -->
        </div>
    </div>
</div>