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
                        <h5>Library Attendence</h5>
                    </div>

                    <div class="card-block">
                        <form class="needs-validation" novalidate method="get" action="{{ route($route.'.index') }}">
                            <div class="row gx-2">
                                <div class="form-group col-md-3">
                                    <label for="hostel">Student Roll No <span>*</span></label>
                                    <input autofocus type="text" class="form-control" name="search_roll" value="{{ $selected_student }}" id="search_roll" required>
                                    <div class="invalid-feedback">
                                      {{ __('required_field') }} {{ __('field_hostel') }}
                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <button type="submit" class="btn btn-info btn-filter"><i class="fas fa-search"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>

                    @if(isset($row))
                    <div class="card-block">
                        {{-- @php
                            $enroll = \App\Models\Student::enroll($row->id);
                        @endphp --}}

                       
                        <div class="row">
                            <div class="col-md-12">

                                @if ($library_attendence_roll_latest != null && $library_attendence_roll_latest->out_time == null)
                                    <form class="needs-validation" novalidate method="post" action="{{ route($route.'.update', $library_attendence_roll_latest->id) }}">
                                        @method('put')
                                @else
                                    <form class="needs-validation" novalidate method="post" action="{{ route($route.'.store') }}">
                                @endif

                                    @csrf

                                    <fieldset class="row gx-2 scheduler-border">
                                        <legend>{{ __('field_academic_information') }}</legend>

                                        <div class="col-md-3">
                                        <p><mark class="text-primary">Roll Number:</mark> #{{ $selected_student }}</p>
                                        </div>

                                        <input type="hidden" name="roll_no" value="{{ $row->roll_no }}" />

                                        <input type="hidden" name="student_id" value="{{ $row->id }}" />


                                        <input type="hidden" name="name" value="{{ $row->first_name }} {{ $row->last_name }}" />

                                        <div class="col-md-3">                        
                                        <p><mark class="text-primary">{{ __('field_name') }}:</mark> {{ $row->first_name }} {{ $row->last_name }}</p>
                                        </div>

                                        <div class="col-md-3">                                    
                                        <p><mark class="text-primary">{{ __('field_batch') }}:</mark> {{ $row->batch->title ?? '' }}</p>
                                        </div>

                                        <div class="col-md-3">
                                        <p><mark class="text-primary">{{ __('field_program') }}:</mark> {{ $row->program->title ?? '' }}</p>
                                        </div>

                                        <div class="col-md-3">
                                        <p><mark class="text-primary">{{ __('field_session') }}:</mark> {{ $row->session->title ?? '' }}</p>
                                        </div>

                                        <div class="col-md-3">
                                        <p><mark class="text-primary">{{ __('field_semester') }}:</mark> {{ $row->semester->title ?? '' }}</p><hr/>
                                        </div>

                                        <div class="col-md-3">
                                        <p><mark class="text-primary">{{ __('field_section') }}:</mark> {{ $row->section->title ?? '' }}</p><hr/>
                                        </div>

                                        <hr />

                                        {{-- <p><mark class="text-primary">{{ __('field_gender') }}:</mark> 
                                            @if( $row->gender == 1 )
                                            {{ __('gender_male') }}
                                            @elseif( $row->gender == 2 )
                                            {{ __('gender_female') }}
                                            @elseif( $row->gender == 3 )
                                            {{ __('gender_other') }}
                                            @endif
                                        </p><hr/> --}}

                                        <br />


                                        
                                        <div class="form-group col-md-5">
                                            <label for="hostel" class="text-primary"><b>IN Time</b><span>*</span></label>
                                            <input type="datetime-local" class="form-control" @if ($library_attendence_roll_latest != null && $library_attendence_roll_latest->out_time == null) readonly @endif name="in_time" value="@php echo \Carbon\Carbon::now(); @endphp" required>
                                            <div class="invalid-feedback">
                                                {{ __('required_field') }} {{ __('field_hostel') }}
                                            </div>
                                        </div>

                                        @if ($library_attendence_roll_latest != null && $library_attendence_roll_latest->out_time == null)

                                        <div class="form-group col-md-5">
                                            <label for="hostel" class="text-primary"><b>OUT Time</b><span>*</span></label>
                                            <input type="datetime-local" class="form-control" name="out_time" required>
                                            <div class="invalid-feedback">
                                            {{ __('required_field') }} {{ __('field_hostel') }}
                                            </div>
                                        </div>
                                            
                                        @endif

                                        <div class="form-group col-md-2">
                                        
                                        </div>                                  


                                        <div class="form-group text-end" style="float:right;">
                                            <button type="submit" class="btn btn-success btn-filter">Check
                                                @if ($library_attendence_roll_latest != null && $library_attendence_roll_latest->out_time == null)
                                                    OUT
                                                @else
                                                    IN
                                                @endif                                            
                                            </button>
                                        </div>

                                    </fieldset>       
                                
                                </form>

                            </div>
                            {{-- <div class="col-md-6">
                                <fieldset class="row gx-2 scheduler-border">
                                    <legend>{{ __('field_academic_information') }}</legend>
                                   
                                </fieldset>
                            </div> --}}
                        </div>
                    </div>
                    @endif


                    <div class="card-block">
                        <!-- [ Data table ] start -->
                        <div class="table-responsive">
                            <table id="basic-table" class="display table nowrap table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Roll Number</th>
                                        <th>Name</th>
                                        <th>IN Time</th>
                                        <th>OUT Time</th>
                                        <th>{{ __('field_action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($library_attendence as $key => $library_a)   
                                    
                                    @php
                                        $row = $library_a;
                                    @endphp
                                    
                                  <tr>
                                    <td>{{ $key }}</td>
                                    <td> {{ $library_a->roll_no }} </td>
                                    <td> {{ $library_a->name }} </td>
                                    <td> {{ $library_a->in_time }} </td>
                                    <td> {{ $library_a->out_time }} </td>

                                    <td> 
                                        <a class="btn btn-icon btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#laedit{{ $library_a->id }}" >
                                            <i class="far fa-edit"></i>
                                        </a>           
                                        
                                        @include('admin.library-attendence.edit')


                                            <button type="button" class="btn btn-icon btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal-{{ $row->id }}">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                            <!-- Include Delete modal -->
                                            @include('admin.layouts.inc.delete')
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
            <!-- [ Card ] end -->
        </div>
        <!-- [ Main Content ] end -->
    </div>
</div>
<!-- End Content-->

@endsection

@section('page_js')

   
@endsection