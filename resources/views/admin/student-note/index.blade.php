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
                        <h5>Filter By</h5>
                    </div>
                    <div class="card-block">
                        <form class="needs-validation" novalidate method="get" action="{{ route($route.'.index') }}">
                            <div class="row gx-2">
                                <div class="form-group col-md-4">
                                    <label for="program" class="form-label">{{ __('field_program') }} <span>*</span></label>
                                    <select class="form-control select2 check-program" name="program" id="program" required>
                                        <option value="">{{ __('Select') }}</option>
                                        @foreach($programs as $program)
                                            <option value="{{ $program->id }}" @if(request('program') == $program->id) selected @endif>{{ $program->title }}</option>
                                        @endforeach
                                    </select>
    
                                    <div class="invalid-feedback">
                                      {{ __('required_field') }} {{ __('field_program') }}
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="subject" class="form-label">{{ __('Subject') }} <span>*</span></label>
                                    <select class="form-control select2 subject" name="subject" id="subject" required>
                                        @if(request('subject'))
                                            @foreach($subjects as $subject)
                                                <option value="{{ $subject->id }}" @if(request('subject') == $subject->id) selected @endif>{{ $subject->title }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <div class="invalid-feedback">
                                      {{ __('required_field') }} {{ __('Subject') }}
                                    </div>
                                </div>
    
                                <div class="form-group col-md-4">
                                    <label for="student" class="form-label">{{ __('field_student') }} <span>*</span></label>
                                    <select class="form-control select2 student" name="student" id="student" required>
                                        @if(request('student'))
                                            @foreach($students as $student)
                                                <option value="{{ $student->id }}" @if(request('student') == $student->id) selected @endif>{{ $student->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
    
                                    <div class="invalid-feedback">
                                      {{ __('required_field') }} {{ __('field_student') }}
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
        </div>
        <!-- [ Main Content ] start -->
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
                                <label for="program" class="form-label">{{ __('field_program') }} <span>*</span></label>
                                <select class="form-control select2 check-program" name="program" id="program" required>
                                    <option value="">{{ __('Select') }}</option>
                                    @foreach($programs as $program)
                                        <option value="{{ $program->id }}" @if(old('program') == $program->id) selected @endif>{{ $program->title }}</option>
                                    @endforeach
                                </select>

                                <div class="invalid-feedback">
                                  {{ __('required_field') }} {{ __('field_program') }}
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="subject" class="form-label">{{ __('Subject') }} <span>*</span></label>
                                <select class="form-control select2 subject" name="subject" id="subject" required></select>
                                <div class="invalid-feedback">
                                  {{ __('required_field') }} {{ __('Subject') }}
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="student" class="form-label">{{ __('field_student') }} <span>*</span></label>
                                <select class="form-control select2 student" name="student" id="student" required>
                                </select>

                                <div class="invalid-feedback">
                                  {{ __('required_field') }} {{ __('field_student') }}
                                </div>
                            </div>


                            <div class="form-group">
                                <label for="title" class="form-label">{{ __('field_title') }} <span>*</span></label>
                                <input type="text" class="form-control" name="title" id="title" value="{{ old('title') }}" required>
                                <div class="invalid-feedback">
                                  {{ __('required_field') }} {{ __('field_title') }}
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="note" class="form-label">{{ __('field_note') }} <span>*</span></label>
                                <textarea class="form-control" name="note" id="note" required>{{ old('note') }}</textarea>
                                <div class="invalid-feedback">
                                  {{ __('required_field') }} {{ __('field_note') }}
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="attach" class="form-label">{{ __('field_attach') }}</label>
                                <input type="file" class="form-control" name="attach" id="attach" value="{{ old('attach') }}">
                                <div class="invalid-feedback">
                                  {{ __('required_field') }} {{ __('field_attach') }}
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
                        <h5>{{ $title }} {{ __('list') }}</h5>
                    </div>
                    <div class="card-block">
                        <!-- [ Data table ] start -->
                        <div class="table-responsive">
                            <table id="basic-table" class="display table nowrap table-striped table-hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ __('field_student_id') }}</th>
                                        <th>{{ __('field_student') }}</th>
                                        <th>{{ __('field_title') }}</th>
                                        <th>{{ __('field_status') }}</th>
                                        <th>{{ __('field_action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  @foreach( $rows as $key => $row )
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>
                                            @isset($row->noteable->student_id)
                                            <a href="{{ route('admin.student.show', $row->noteable->id) }}">
                                            #{{ $row->noteable->student_id ?? '' }}
                                            </a>
                                            @endisset
                                        </td>
                                        <td>{{ $row->noteable->name ?? '' }}</td>

                                        <td>{!! str_limit(strip_tags($row->title), 50, ' ...') !!}</td>
                                        <td>
                                            @if( $row->status == 1 )
                                            <span class="badge badge-pill badge-success">{{ __('status_active') }}</span>
                                            @else
                                            <span class="badge badge-pill badge-danger">{{ __('status_inactive') }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-icon btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#showModal-{{ $row->id }}">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <!-- Include Show modal -->
                                            @include($view.'.show')

                                            @if(is_file('uploads/'.$path.'/'.$row->attach))
                                            <a href="{{ asset('uploads/'.$path.'/'.$row->attach) }}" class="btn btn-icon btn-dark btn-sm" download><i class="fas fa-download"></i></a>
                                            @endif

                                            @can($access.'-edit')
                                            <button type="button" class="btn btn-icon btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editModal-{{ $row->id }}">
                                                <i class="far fa-edit"></i>
                                            </button>
                                            <!-- Include Edit modal -->
                                            @include($view.'.edit')
                                            @endcan

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

<script type="text/javascript">
    "use strict";
    $(document).ready(function(){
        $(".check-program").on('change',function(e){
        e.preventDefault(e);
        var subject=$(".subject");
        var student=$(".student");
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
            $.ajax({
            type:'POST',
            url: "{{ route('filter-subject') }}",
            data:{
                _token:$('input[name=_token]').val(),
                program:$(this).val()
            },
                success:function(response){
                    // var jsonData=JSON.parse(response);
                    $('option', subject).remove();
                    $('.subject').append('<option value="">{{ __("select") }}</option>');
                    $.each(response, function(){
                        $('<option/>', {
                        'value': this.id,
                        'text': this.title
                        }).appendTo('.subject');
                    });
                }
            });

            $.ajax({
            type:'POST',
            url: "{{ route('filter-students') }}",
            data:{
                _token:$('input[name=_token]').val(),
                program:$(this).val()
            },
            success:function(response){
                console.log(response);
                // var jsonData=JSON.parse(response);
                $('option', student).remove();
                $('.student').append('<option value="0">{{ __("all") }}</option>');
                $.each(response, function(){
                    $('<option/>', {
                    'value': this.id,
                    'text': this.first_name+' '+this.last_name
                    }).appendTo('.student');
                });
                }

            });
        });
    });
</script>


@endsection