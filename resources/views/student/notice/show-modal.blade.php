<div id="showStudentNotice-{{ $row->id }}" uk-modal>
    <div class="uk-modal-dialog">
        <button class="uk-modal-close-default" type="button" uk-close></button>
        <div class="uk-modal-header">
            <h2 class="uk-modal-title">Notice</h2>
        </div>
        <div class="uk-modal-body">
            <!-- Details View Start -->
            <div class="">
                <!-- Details View Start -->
                <div class="">
                    <div class="row">
                        <div class="col-md-6">
                            <p><mark class="text-primary">{{ __('field_notice_no') }}:</mark> #{{ $row->notice_no }}</p><hr/>
                            <p><mark class="text-primary">{{ __('field_category') }}:</mark> {{ $row->category->title ?? '' }}</p><hr/>
                        </div>
                        <div class="col-md-6">
                            <p><mark class="text-primary">{{ __('field_publish_date') }}:</mark> 
                                @if(isset($setting->date_format))
                                {{ date($setting->date_format, strtotime($row->date)) }}
                                @else
                                {{ date("Y-m-d", strtotime($row->date)) }}
                                @endif
                            </p><hr/>

                            {{-- @if(is_file('uploads/'.$path.'/'.$row->attach))
                                <a href="{{ asset('uploads/'.$path.'/'.$row->attach) }}" class="btn btn-icon btn-dark btn-sm" download><i class="fas fa-download"></i></a>
                            @endif --}}

                            @if(isset($row->url))
                                <a href="{{ url($row->url) }}" class="btn btn-icon btn-dark btn-sm" target="_blank"><i class="fas fa-link"></i></a>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <p><mark class="text-primary">{{ __('field_description') }}:</mark> {!! $row->description !!}</p><hr/>
                        </div>
                    </div>
                </div>
                <!-- Details View End -->
            </div>
            <!-- Details View End -->
        </div>
    </div>
</div>