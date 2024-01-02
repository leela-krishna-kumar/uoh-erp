@extends('admin.layouts.master')
@section('title', $title)

@section('content')
<!-- Start Content-->
<div class="main-body">
    <div class="page-wrapper">
        <!-- [ Main Content ] start -->
        <div class="row">
            <!-- [ Card ] start -->
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>{{ __('modal_add') }} {{ $title }}</h5>
                    </div>
                    <div class="card-block">
                        <a href="{{ route($route.'.index') }}" class="btn btn-primary"><i class="fas fa-arrow-left"></i> {{ __('btn_back') }}</a>

                        <a href="{{ route($route.'.create') }}" class="btn btn-info"><i class="fas fa-sync-alt"></i> {{ __('btn_refresh') }}</a>
                    </div>
                </div>
            </div>
            <!-- [ Card ] end -->
            <form class="needs-validation" novalidate action="{{ route($route.'.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="card">
                    <div class="card-block">
                        <div class="row">
                            <!-- Form Start -->
                                @include('common.inc.ecourse_search_filter')
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <label for="title">{{ __('Title') }} <span>*</span></label>
                                            <input type="text" class="form-control" name="title" id="title" value=""required>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="duration">{{ __('Duration') }} ({{ __('In min.') }})<span>*</span></label>
                                            <input type="number" min="0"class="form-control" name="duration" id="duration" value=""required>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="image">{{ __('Image') }}: <span>{{ __('image_size', ['height' => 300, 'width' => 300]) }}</span></label>
                                            <input type="file" class="form-control" name="image" id="image" value="{{ old('image') }}" accept="image/png, image/gif, image/jpeg" />
            
                                            <div class="invalid-feedback">
                                            {{ __('required_field') }} {{ __('field_photo') }}
                                            </div>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <div class="switch d-inline m-r-10">
                                                <label>{{ __('Is Published') }}</label>
                                                <input type="checkbox" id="is_published" name="is_published" value="1">
                                                <label for="is_published" class="cr"></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <label for="description">{{ __('Description') }}<span>*</span></label>
                                            <textarea  type="text" name="description" id="description" class="form-control" rows="10" required></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-md-4"></div>
                            <!-- Form End -->
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> {{ __('btn_save') }}</button>
                    </div>
                </div>
            </form>
        </div>
        <!-- [ Main Content ] end -->
    </div>
</div>
<!-- End Content-->
<script>
  function onlyOne(checkbox) {
    var checkboxes = document.getElementsByName('student_id')
    checkboxes.forEach((item) => {
        if (item !== checkbox) item.checked = false
    })
}
</script>


@endsection
