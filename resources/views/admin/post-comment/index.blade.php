@extends('admin.layouts.master')
@section('title', $title)
@section('content')

<!-- Start Content-->
<div class="main-body">
    <div class="page-wrapper">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>{{@$post->content}} {{ $title }} </h5>
                    </div>
                    <div class="card-block">
                        @can($access.'-create')
                        <a href="{{ route($route.'.create',['post_id' =>@$post->id]) }}" class="btn btn-primary"><i class="fas fa-plus"></i> {{ __('btn_add_new') }}</a>
                        @endcan

                        <a href="{{ route($route.'.index') }}" class="btn btn-info"><i class="fas fa-sync-alt"></i> {{ __('btn_refresh') }}</a>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5>{{@$post->content}} {{$title}} {{ __('list') }}</h5>
                    </div>
                    <div class="card-block">
                        <!-- [ Data table ] start -->
                        <div class="table-responsive">
                            <table class="display table nowrap table-striped table-hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ __('Role') }}</th>
                                        <th>{{ __('Comment By') }}</th>
                                        <th>{{ __('Comment') }}</th>
                                        <th>{{ __('Likes') }}</th>
                                        <th>{{ __('field_action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($rows->count() > 0) 
                                        @foreach($rows as $key => $row )
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{@$row->role ? $row->role->name : 'N/A'}}</td>
                                                <td>{{ @$row->createdBy->first_name }}{{ @$row->createdBy->last_name }}</td>
                                                <td>{{Str::limit($row->comment,50)}}</td>
                                                <td>
                                                    <!-- <a href="{{ route('admin.post-likes.index', ['post_id' =>$row->id]) }}"> -->
                                                        <span><i class="fa fa-thumbs-up"></i> {{ $row->likes->count() }}</span>
                                                    <!-- </a> -->
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
                                    @else 
                                        <tr>
                                            <td class="text-center no-export" colspan="8">No Data Found...</td>
                                        </tr>
                                    @endif
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