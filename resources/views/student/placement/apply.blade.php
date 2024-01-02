<div id="apply" uk-modal>
    <div class="uk-modal-dialog">
        <button class="uk-modal-close-default" type="button" uk-close></button>
        <div class="uk-modal-header">
            <h2 class="uk-modal-title">Apply</h2>
        </div>
        <form class="needs-validation" action="{{ route($route.'.apply') }}" method="post" enctype="multipart/form-data">
            <div class="uk-modal-body">
                @csrf
                <input type="hidden" id="placement_id" name="placement_id" value="">
                <div class="row">
                <!-- Form Start -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="high_school" class="form-label"> High School <span>*</span></label>
                            <input type="number" required class="form-control" min="0" max="100" name="high_school"
                                id="" value="{{ old('high_school') }}">
                            <div class="invalid-feedback">
                                {{ __('required_field') }} {{ __('High School') }}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="higher_secondary" class="form-label"> Higher Secondary <span>*</span></label>
                            <input type="number" required class="form-control" min="0" max="100" name="higher_secondary"
                                id="" value="{{ old('higher_secondary') }}">
                            <div class="invalid-feedback">
                                {{ __('required_field') }} {{ __('Higher Secondary ') }}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="aggregate" class="form-label"> Aggregate <span>*</span></label>
                            <input type="number" required class="form-control" min="0" max="100" name="aggregate"
                                id="" value="{{ old('aggregate') }}">
                            <div class="invalid-feedback">
                                {{ __('required_field') }} {{ __('Aggregate') }}
                            </div>
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