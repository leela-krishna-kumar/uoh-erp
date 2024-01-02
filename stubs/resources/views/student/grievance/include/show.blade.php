<div id="showGrievance-{{ $row->id }}" uk-modal>
    <div class="uk-modal-dialog">
        <button class="uk-modal-close-default" type="button" uk-close></button>
        <div class="uk-modal-header">
            <h2 class="uk-modal-title">Grievance</h2>
        </div>
        <div class="uk-modal-body">
            <!-- Details View Start -->
            <h4>
                <mark class="text-primary">{{ __('field_name') }}:</mark> {{ $row->student->first_name }} {{ $row->student->last_name }}
            </h4>
            <hr/>
            <div class="row">
                <div class="col-md-12">
                   <p><mark class="text-primary">{{ __('field_category') }}:</mark> {{ $row->category->name }}</p><hr/>
                   <p><mark class="text-primary">{{ __('field_department') }}:</mark> {{ $row->department->title }}</p><hr/>

                   <p><mark class="text-primary">{{ __('field_description') }}:</mark> {{ $row->description }}</p><hr/>

                   @if(!empty($row->note))
                   <p><mark class="text-primary">{{ __('field_note') }}:</mark> {{ $row->note }}</p><hr/>
                   @endif
                </div>
            </div>
            <!-- Details View End -->
        </div>
    </div>
</div>