<div id="addLeave" uk-modal>
    <div class="uk-modal-dialog">
        <button class="uk-modal-close-default" type="button" uk-close></button>
        <div class="uk-modal-header">
            <h2 class="uk-modal-title">Apply Leave</h2>
        </div>
        <form class="needs-validation" action="{{ route($route.'.store') }}" method="post" enctype="multipart/form-data">
            <div class="uk-modal-body">
                @csrf
                <div class="row">
                <!-- Form Start -->
                <div class="form-group col-md-4">
                    <label for="apply_date">{{ __('field_apply_date') }} <span>*</span></label>
                    <input type="date" class="form-control" name="apply_date" id="apply_date" value="{{ date('Y-m-d') }}" readonly required>

                    <div class="invalid-feedback">
                        {{ __('required_field') }} {{ __('field_apply_date') }}
                    </div>
                </div>

                <div class="form-group col-md-4">
                    <label for="from_date">{{ __('field_start_date') }} <span>*</span></label>
                    <input type="date" class="form-control date" name="from_date" id="from_date" value="{{ old('from_date') }}" required>

                    <div class="invalid-feedback">
                        {{ __('required_field') }} {{ __('field_start_date') }}
                    </div>
                </div>

                <div class="form-group col-md-4">
                    <label for="to_date">{{ __('field_end_date') }} <span>*</span></label>
                    <input type="date" class="form-control date" name="to_date" id="to_date" value="{{ old('to_date') }}" required>

                    <div class="invalid-feedback">
                        {{ __('required_field') }} {{ __('field_end_date') }}
                    </div>
                </div>

                <div class="form-group col-md-12">
                    <label for="subject">{{ __('field_leave_subject') }} <span>*</span></label>
                    <input type="text" class="form-control" name="subject" value="{{ old('subject') }}" required>

                    <div class="invalid-feedback">
                        {{ __('required_field') }} {{ __('field_leave_subject') }}
                    </div>
                </div>

                <div class="form-group col-md-12">
                    <label for="reason">{{ __('field_reason') }}</label>
                    <textarea class="form-control" name="reason" id="reason">{{ old('reason') }}</textarea>

                    <div class="invalid-feedback">
                        {{ __('required_field') }} {{ __('field_reason') }}
                    </div>
                </div>

                <div class="form-group col-md-12">
                    <label for="attach">{{ __('field_attach') }}</label>
                    <input type="file" class="form-control" name="attach" id="attach" value="{{ old('attach') }}">

                    <div class="invalid-feedback">
                        {{ __('required_field') }} {{ __('field_attach') }}
                    </div>
                </div>
                <!-- Form End -->
                </div>
            </div>
            <div class="uk-modal-footer text-right">
                <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> {{ __('Apply') }}</button>
            </div>
        </form>
    </div>
</div>