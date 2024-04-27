@extends('admin.layouts.master')
@section('title', $title)
@section('content')

<!-- Start Content-->
<div class="main-body">
    <div class="page-wrapper">
        <!-- [ Main Content ] start -->
        <div class="row">
            @can($access.'-create')
            <div class="col-md-4">
                <form class="needs-validation" novalidate action="{{ route($route.'.store') }}" method="post" enctype="multipart/form-data" id="test_paper">
                @csrf
                <input type="hidden" class="disclaimer-value" name="disclaimer" value="">
                    <div class="card">
                        <div class="card-header">
                            <h5>{{ __('btn_create') }} {{ $title }}</h5>
                        </div>
                        <div class="card-block">
                            <!-- Form Start -->
                            <div class="form-group">
                                <label for="title" class="form-label">{{ __('field_title') }} <span>*</span></label>
                                <input type="text" class="form-control" name="title" id="title" value="{{ old('title') }}">

                                <div class="invalid-feedback">
                                  {{ __('required_field') }} {{ __('field_title') }}
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="type">{{ __('field_type') }} <span>*</span></label>
                                <select class="form-control" name="type" id="type" required>
                                    @foreach (App\Models\TestPaper::TYPES as $key => $class)
                                    <option value="{{$key}}" @if( old('type') == 1 ) selected @endif>{{ $class['label'] }}</option>
                                    @endforeach
                                </select>

                                <div class="invalid-feedback">
                                {{ __('required_field') }} {{ __('field_type') }}
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="duration" class="form-label">{{ __('Duration') }} ({{ __('In min.') }})<span>*</span></label>
                                <input type="number" class="form-control" name="duration" id="duration" value="{{ old('duration') }}" min="1">

                                <div class="invalid-feedback">
                                  {{ __('required_field') }} {{ __('duration') }}
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="title" class="form-label">{{ __('Start Date') }} <span>*</span></label>
                                <input type="date" class="form-control" name="started_from" id="started_from" value="">

                                <div class="invalid-feedback">
                                  {{ __('required_field') }} {{ __('Start Date') }}
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="end_date" class="form-label">{{ __('field_end_date') }} <span>*</span></label>
                                <input type="date" class="form-control date" name="end_date" id="end_date" value="{{ old('end_date') }}" required>

                                <div class="invalid-feedback">
                                  {{ __('required_field') }} {{ __('field_end_date') }}
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="disclaimer" class="form-label">{{ __('Disclaimer') }} <span>*</span></label> <br />
                                {{-- <div id="toolbar-container0"></div>
                                <div id="txt_area0"></div> --}}

                                <textarea name="disclaimer" class="form-control" rows="3" required></textarea>

                                <div class="invalid-feedback">
                                  {{ __('required_field') }} {{ __('Start Date') }}
                                </div>
                            </div>
                            <!-- Form End -->
                        </div>
                        <div class="card-footer">
                            <button type="submit" class=" btn btn-success"><i class="fas fa-check"></i> {{ __('btn_save') }}</button>
                        </div>
                    </div>
                </form>
            </div>
            @endcan
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5>{{ $title }} {{ __('list') }}</h5>
                    </div>
                    <div class="card-block">
                        <!-- [ Data table ] start -->
                        <div class="table-responsive">
                            <table id="basic-table" class="display table nowrap table-striped table-hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ __('field_title') }}</th>
                                        <th>{{ __('field_type') }}</th>
                                        <th>{{ __('Start Date') }}</th>
                                        <th>{{ __('End Date') }}</th>
                                        <th>{{ __('field_action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  @foreach($rows as $key => $row)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                      
                                        <td>{{ $row->title }}</td>
                                        <td>
                                            {{@App\Models\TestPaper::TYPES[$row->type]['label']}}
                                        </td>
                                        <td>{{ $row->started_from }}</td>
                                        <td>{{ $row->end_date }}</td>
                                        <td>
                                            @can($access.'-edit')
                                            <button type="button" class="btn btn-icon btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editModal-{{ $row->id }}" onclick="initilizeEditor('{{$row->id}}')">
                                                <i class="far fa-edit"></i>
                                            </button>
                                            <!-- Include Edit modal -->
                                            @include($view.'.edit')
                                            @endcan
                                            <a href="{{ route('admin.test-paper.show', $row->id) }}" class="btn btn-icon btn-sm btn-success"><i class="fas fa-eye"></i></a>
                                            
                                            <a href="{{ route($route.'-user.create',['test_paper_id' =>$row->id]) }}" class="btn btn-icon btn-primary btn-sm" title="Assign User">
                                                <i class="far fa-plus"></i>
                                            </a>

                                            @can($access.'-delete')
                                            <button type="button" class="btn btn-icon btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal-{{ $row->id }}">
                                                <i class="fas fa-trash-alt"></i>
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
<script src="https://cdn.ckeditor.com/ckeditor5/37.1.0/decoupled-document/ckeditor.js"></script>
<script type="text/javascript">
    "use strict";
        let editor;
        $(window).on('load', function (){
            initilizeEditor(0)
        }); 
        function initilizeEditor(row){
        $('#txt_area'+row).addClass('ck-editor');
            DecoupledEditor
            .create( document.querySelector('.ck-editor'),{
                ckfinder: {
                    uploadUrl: "{{route('admin.question-bank.ckeditor.upload').'?_token='.csrf_token()}}",
                }
            })
            .then( newEditor => {
                editor = newEditor;
                const toolbarContainer = document.querySelector( '#toolbar-container'+row );
    
                toolbarContainer.appendChild( editor.ui.view.toolbar.element );
            } )
            .catch( error => {
                console.error( error );
            } );
        }
        $('.onclick-event').on('click',function(){
            $('.disclaimer-value').val(editor.getData());
            $('#test_paper').submit();
        });

</script>
@endsection
