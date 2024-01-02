@extends('admin.layouts.master')
@section('title', $title)

@section('page_css')
    <!-- Wizard css -->
    <link rel="stylesheet" href="{{ asset('dashboard/css/pages/wizard.css') }}">
@endsection

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
                    <!-- Form Start -->
                    <form class="needs-validation" novalidate action="{{ route($route.'.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="card-block">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group col-md-12">
                                        <label for="title">{{ __('Title') }} <span>*</span></label>
                                        <input type="text" class="form-control" name="title" id="title" value=""required>
                                    </div>  
                                     <div class="form-group col-md-12">
                                        <label for="lession">{{ __('Section') }} <span>*</span></label>
                                        <select class="form-control select2" name="e_section_id" id="e_section_id" required>
                                            <option readonly value="">{{ __('Select Section') }}</option>
                                            @foreach($esections as $section)
                                            <option value="{{ $section->id }}">{{ $section->title }} </option>
                                            @endforeach
                                    </select>
                                    </div>  
                                    
                                    
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="type">{{ __('Type') }}</label>
                                            <select class="form-control" name="type" id="type"required onchange="getELessonType(this.value);">
                                                <option value="">{{ __('Select') }}</option>
                                                @foreach($types as $key => $type)
                                                <option value="{{$type['label']}}">{{ $type['label'] }}</option>
                                                @endforeach
                                            </select>
                                        </div>  
    
                                        <div class="form-group col-md-6 d-none video-type">
                                            <label for="type">{{ __('Choose Options') }}</label>
                                            <select class="form-control video-mode" name="mode_type" onchange="getModeType(this.value);">
                                                <option value="">{{ __('Select') }}</option>
                                                <option value="upload">Upload</option>
                                                <option value="link">Link</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-6 d-none ebook-type">
                                            <label for="type">{{ __('Choose Options') }}</label>
                                            <select class="form-control"name="e_book_mode" onchange="getModeType(this.value);">
                                                <option value="">{{ __('Select') }}</option>
                                                <option value="book-list">Book List</option>
                                                <option value="upload">Upload</option>
                                                <option value="link">Link</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-6 d-none eTest-type">
                                            <label for="type">{{ __('Choose Options') }}</label>
                                            <select class="form-control" name="test_paper_mode"onchange="getModeType(this.value);">
                                                <option value="">{{ __('Select') }}</option>
                                                <option value="test-paper-list">Test Paper List</option>
                                                <option value="link">Link</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-12 d-none show-link">
                                        <label for="type">{{ __('Enter Link') }}</label>
                                        <input type="url" class="form-control" name="link" value="">
                                    </div> 

                                    <div class="form-group col-md-12 d-none show-upload">
                                        <label for="type">{{ __('Upload File') }}</label>
                                        <input type="file"class="form-control" value="" name="link">
                                    </div> 
                                    <div class="form-group col-md-12 d-none show-book-list">
                                        <label for="type_id">{{ __('eBook List') }}</label>
                                        <select name="book_type_id"class="form-control">
                                            <option value="" selected>Select Books</option>
                                            @foreach ($books as $book)
                                            <option value="{{$book->id}}">{{$book->title}}</option>
                                            @endforeach
                                        </select>
                                    </div> 
                                    <div class="form-group col-md-12 d-none show-testpaper-list">
                                        <label for="type_id">{{ __('Test Paper List') }}</label>
                                        <select name="test_type_id"class="form-control" id="type_id">
                                            <option value=""selected>Select Test Paper</option>
                                            @foreach ($testpapers as $testpaper)
                                            <option value="{{$testpaper->id}}">{{$testpaper->title}}</option>
                                            @endforeach
                                        </select>
                                    </div> 

                                    <div class="form-group col-md-12">
                                        <div class="switch d-inline m-r-10">
                                            <label>{{ __('Is Published') }}</label>
                                            <input type="checkbox" id="is_published" name="is_published" value="1">
                                            <label for="is_published" class="cr"></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group col-md-12">
                                        <label for="short_description">{{ __('Description') }}<span>*</span></label>
                                        <textarea type="text" name="short_description" id="short_description" class="form-control" rows="9" required></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> {{ __('btn_save') }}</button>
                        </div>
                    </form>
                    <!-- Form End -->
                </div>
            </div>
            <!-- [ Card ] end -->
        </div>
        <!-- [ Main Content ] end -->
    </div>
</div>
<!-- End Content-->

<script type="text/javascript">
    "use strict";

function getModeType(mode_type){
    if(mode_type == 'upload'){
        $('.show-upload').removeClass('d-none');
        $('.show-book-list').addClass('d-none');
        $('.show-testpaper-list').addClass('d-none');
        $('.show-link').addClass('d-none');
    }
    else if(mode_type == 'link'){
        $('.show-link').removeClass('d-none');  
        $('.show-book-list').addClass('d-none');
        $('.show-testpaper-list').addClass('d-none');
        $('.show-upload').addClass('d-none');  
    }else if(mode_type == 'book-list'){
        $('.show-book-list').removeClass('d-none');
        $('.show-testpaper-list').addClass('d-none');
        $('.show-link').addClass('d-none');  
        $('.show-upload').addClass('d-none');
    }else{
        $('.show-testpaper-list').removeClass('d-none');
        $('.show-link').addClass('d-none');  
        $('.show-upload').addClass('d-none');
    }
}
  
function getELessonType(type){
    if(type == 'Video'){
        $('.video-type').removeClass('d-none');
        $('.show-link').addClass('d-none'); 
        $('.eTest-type').addClass('d-none');
        $('.show-upload').addClass('d-none');
        $('.ebook-type').addClass('d-none'); 
    }else if(type == 'Live'){
        $('.video-type').addClass('d-none');
        $('.eTest-type').addClass('d-none');
        $('.show-book-list').addClass('d-none');
        $('.show-testpaper-list').addClass('d-none');
        $('.show-link').removeClass('d-none');  
        $('.ebook-type').addClass('d-none');  
    }else if(type == 'Ebook'){
        $('.video-type').addClass('d-none');      
        $('.ebook-type').removeClass('d-none');
        $('.show-testpaper-list').addClass('d-none');
        $('.eTest-type').addClass('d-none');
        $('.show-link').addClass('d-none');      
    }else{
        $('.eTest-type').removeClass('d-none');
        $('.ebook-type').addClass('d-none');
        $('.video-type').addClass('d-none');
        $('.show-link').addClass('d-none');
        $('.show-upload').addClass('d-none');
    }
}      

</script>

@endsection

