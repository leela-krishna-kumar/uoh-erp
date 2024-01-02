@extends('admin.layouts.master')
@section('title', $title)
@section('content')

<!-- Start Content-->
<div class="main-body">
    <div class="page-wrapper">
        <!-- [ Main Content ] start -->
        {{-- <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Filter By</h5>
                    </div>
                    <div class="card-block">
                        <form class="needs-validation" novalidate method="get" action="{{ route($route.'.index') }}">
                            <div class="row gx-2">
                                <div class="form-group col-md-3">
                                    <label for="media_type">{{ __('Select Type') }} <span>*</span></label>
                                    <select class="form-control" name="media_type" id="media_type" required>
                                        <option value="">{{ __('Select') }}</option>
                                        @foreach($mediaTypes as $key => $type)
                                            <option value="{{$key}}" @if($key == 0) selected @endif>{{ $type['label'] }}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">
                                      {{ __('required_field') }} {{ __('Type') }}
                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <button type="submit" class="btn btn-info btn-filter"><i class="fas fa-search"></i> {{ __('btn_search') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div> --}}
        <div class="row">
            @can($access.'-create')
            <div class="col-md-4">
                <form class="needs-validation" novalidate action="{{ route($route.'.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                    <div class="card">
                        <div class="card-header">
                            <h5>{{ __('btn_create') }} {{ $title }}</h5>
                        </div>
                        <div class="card-block">
                            <!-- Form Start -->
                            <div class="form-group">
                                <label for="content">{{ __('Content') }}</label>
                                <input type="text" class="form-control" name="content" id="content" value="{{ old('content') }}" required>

                                <div class="invalid-feedback">
                                  {{ __('required_field') }} {{ __('Content') }}
                                </div>
                            </div>
                            <!-- <div class="form-group">
                                <label for="role_id" class="form-label">{{ __('field_role') }} <span>*</span></label>
                                <select class="form-control select2" name="role_id" id="role_id" required>
                                    <option value="">{{ __('select') }}</option>
                                    @foreach($roles as $key => $role)
                                        @if($key === $roles->keys()->last())
                                            <option value="0">{{ __('field_student') }}</option>
                                        @endif
                                        <option value="{{ $role->id }}" @if(old('role_id') == $role->id) selected @endif>{{ $role->name }}</option>
                                    @endforeach
                                </select>

                                <div class="invalid-feedback">
                                  {{ __('required_field') }} {{ __('field_role') }}
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="status" class="form-label">Status <span>*</span></label>
                                <select class="form-control check-type" name="status" id="status" required>
                                    @foreach(App\Models\Post::STATUSES as $key => $type)
                                    <option value="{{$key}}" @if($key == 0) selected @endif>{{ $type['label'] }}</option>
                                    @endforeach
                                </select>

                                <div class="invalid-feedback">
                                  {{ __('required_field') }} {{ __('field_type') }}
                                </div>
                            </div> -->

                            <div class="form-group">
                                <label for="media_type" class="form-label">Type <span>*</span></label>
                                <select class="form-control check-type" name="media_type" id="media_type" required>
                                    <option value="">{{ __('Select') }}</option>
                                    @foreach($mediaTypes as $key => $type)
                                    <option value="{{$key}}" @if($key == 0) selected @endif>{{ $type['label'] }}</option>
                                    @endforeach
                                </select>

                                <div class="invalid-feedback">
                                  {{ __('required_field') }} {{ __('field_type') }}
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="media-input">
                                    <label for="media">{{ __('Media') }} <span>*</span></label>
                                    <input type="file" class="form-control" name="media" id="media" value="{{ old('media') }}">
                                </div>
                                <div class="link-input d-none">
                                    <label for="media">{{ __('Link') }} <span>*</span></label>
                                    <input type="text" class="form-control" name="media" id="media" value="{{ old('media') }}">
                                </div>
                                <div class="invalid-feedback">
                                {{ __('required_field') }} {{ __('field_media') }}
                                </div>
                            </div>
                            <!-- Form End -->
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> {{ __('btn_save') }}</button>
                        </div>
                    </div>
                </form>
            </div>
            @endcan
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5>{{$title}} {{ __('list') }}</h5>
                    </div>
                    <div class="card-block">
                        <!-- [ Data table ] start -->
                        <div class="table-responsive">
                            <table class="display table nowrap table-striped table-hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ __('Content') }}</th>
                                        <th>{{ __('Media Type') }}</th>
                                        <th>{{ __('Created By') }}</th>
                                        <th>{{ __('field_role') }}</th>
                                        <th>{{ __('Likes') }}</th>
                                        <th>{{ __('Comment') }}</th>
                                        <th>{{ __('Status') }}</th>
                                        <th>{{ __('field_action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  @foreach($rows as $key => $row )
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ Str::limit(@$row->content,30)}}</td>
                                        <td>{{ $row->media_type ? App\Models\Post::TYPES[$row->media_type]['label'] : "-" }}</td>
                                        <td>{{ $row->createdBy->first_name }}{{ $row->createdBy->last_name }}</td>
                                        <td>{{$row->role ? $row->role->name : 'Student'}}</td>
                                        
                                        <td>
                                            <a href="{{ route('admin.post-likes.index', ['post_id' =>$row->id]) }}">
                                                <span><i class="fa fa-thumbs-up"></i> {{ $row->likes->count() }}</span>
                                            </a>
                                        </td>

                                        <td>
                                            <a href="{{ route('admin.post-comment.index', ['post_id' =>$row->id]) }}">
                                                <span><i class="fas fa-comment"></i> {{ $row->comments->count() }}</span>
                                            </a>
                                        </td> 
                                        </td>
                                        
                                        <td>
                                            <span class="badge badge-pill badge-{{App\Models\Post::STATUSES[$row->status]['color']}}">{{ App\Models\Post::STATUSES[$row->status]['label'] }}</span>
                                        </td>
                                        <td>
                                            @can($access.'-edit')
                                            <button type="button" class="btn btn-icon btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editModal-{{ $row->id }}">
                                                <i class="far fa-edit"></i>
                                            </button>
                                            <!-- Include Edit modal -->
                                            @include($view.'.edit')
                                            @endcan

                                            @can($access.'-delete')
                                            <button type="button" class="btn btn-icon btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal-{{ $row->id }}"><i class="fas fa-trash-alt"></i>
                                            </button>
                                            <!-- Include Delete modal -->
                                            @include('admin.layouts.inc.delete')
                                            @endcan
                                        </td>
                                    </tr>
                                  @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- [ Data table ] end -->
                    </div>
                </div>
            </div>
        </div>
        <!-- [ Main Content ] end -->
    </div>
</div>

<!-- End Content-->
<script src="{{ asset('dashboard/plugins/jquery/js/jquery.min.js') }}"></script>

<script type="text/javascript">
    "use strict";
$('.check-type').on('change',function(){
    let type = $(this).val();
    //4 = Link Type
    if(type == 4){
        $('.media-input').addClass('d-none'); 
        $('.link-input').removeClass('d-none');
    }else{
        $('.link-input').addClass('d-none'); 
        $('.media-input').removeClass('d-none');
    }
});
</script>

@endsection