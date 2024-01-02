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
                            <div class="card-block">
                                <form class="needs-validation" novalidate method="get" action="{{ route($route.'.create') }}">
                                    <div class="row gx-2">
                                        @include('common.inc.student_search_filter')
                                        <div class="form-group col-md-3">
                                            <button type="submit" class="btn btn-info btn-filter"><i class="fas fa-search"></i> {{ __('btn_filter') }}</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- [ Card ] end -->
                    @if(isset($rows))
                        @if(count($rows) > 0)
                            <div class="col-sm-12">
                                <form class="needs-validation" novalidate action="{{ route($route.'.store') }}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="card">
                                        <div class="card-block">
                                            <input type="hidden" name="student_ids" class="student_ids"value="">
        
                                            <!-- [ Data table ] start -->
                                            <div class="table-responsive">
                                                <table id="basic-table" class="display table nowrap table-striped table-hover" style="width:100%">
                                                    <thead>
                                                        <tr>
                                                            <th>
                                                                <div class="checkbox checkbox-success d-inline">
                                                                <input type="checkbox" id="checkbox" class="all_select">
                                                                  <label for="checkbox" class="cr" style="margin-bottom: 0px;"></label>
                                                                </div>
                                                            </th>
                                                            <th>{{ __('field_student_id') }}</th>
                                                            <th>{{ __('field_student') }}</th>
                                                            <th>{{ __('field_credit_hour_short') }}</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach( $rows as $key => $row )
                                                        <tr>
                                                            <td>
                                                                <div class="checkbox checkbox-primary d-inline">
                                                                    <input type="checkbox" data_id="{{ $row->id }}" id="checkbox-{{ $row->id }}" value="{{ $row->id }}">
                                                                    <label for="checkbox-{{ $row->id }}" class="cr"></label>
                                                                  </div>
                                                            </td>
                                                            <td>
                                                                <a href="{{ route('admin.student.show', $row->student->id) }}">
                                                                #{{ $row->student->student_id ?? '' }}
                                                                </a>
                                                            </td>
                                                            <td>{{ $row->student->name ?? '' }}</td>
                                                            <td>
                                                                @php
                                                                    $total_credits = 0;
                                                                    foreach($row->subjects as $subject){
                                                                        $total_credits = $total_credits + $subject->credit_hour;
                                                                    }
                                                                @endphp
                                                                {{ $total_credits }}
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            <!-- [ Data table ] end -->
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-block">
                                            <div class="row">
                                                
                                                <div class="col-md-6">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                              <div class="switch d-inline m-r-10">
                                                                  <label for="date">Date <span>*</span></label>
                                                                  <input type="date"class="form-control" id="date" name="date" value="" required>
                                                                  <label for="date" class="cr"></label>
                                                              </div>
                                                          </div>
                                                      </div>
                                                      <div class="col-md-12">
                                                          <label for="direction" class="mb-2">Direction <span>*</span></label>
                                                          <div class="form-group">
                                                            <div class="form-group d-inline">
                                                              <div class="radio radio-success d-inline">
                                                                  <input type="radio" name="direction" value="1" id="in" checked required>
                                                                  <label for="in" class="cr">{{ __('In') }}</label>
                                                              </div>
                              
                                                              <div class="radio radio-danger d-inline">
                                                                  <input type="radio" name="direction" value="2" id="out">
                                                                  <label for="out" class="cr">{{ __('Out') }}</label>
                                                              </div>
                              
                                                              <div class="invalid-feedback">
                                                              {{ __('required_field') }} {{ __('Direction') }}
                                                              </div>
                                                          </div>
                                                        </div>
                                                      </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group col-md-12">
                                                                <label for="note">Note <span>*</span></label>
                                                                <textarea type="text" class="form-control" name="note" id="note" rows="7" ></textarea required>
                                                                <div class="invalid-feedback">
                                                                    {{ __('required_field') }} {{ __('field_note') }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <button type="submit" class="btn btn-success saveBtn"><i class="fas fa-check"></i> {{ __('btn_save') }}</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        @else
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-block">
                                    <div class="text-center">
                                        <h6>No Student Found..</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    @endif
                </div>
                <!-- [ Main Content ] end -->
    </div>
</div>
<!-- End Content-->


@endsection

@section('page_js')
@yield('sub-script')
<script>
    $(document).ready(function() {
        $(".saveBtn").on('click',function(e){
            var numberOfChecked = $("input[data_id]:checked").length;
            if(numberOfChecked <= 0){
                e.preventDefault();
                alert("{{ __('select') }} {{ __('Student Id') }}");
            }
            var student_ids = [];
            $.each($("input[data_id]:checked"), function(){
                student_ids.push($(this).val());
            });
            $(".student_ids").val(student_ids.join(','));
        });
    });
    
    $(".all_select").on('click',function(e){
        if($(this).is(":checked")){
            // check all checkbox
            $("input:checkbox").prop('checked', true);
        }
        else if($(this).is(":not(:checked)")){
            // uncheck all checkbox
            $("input:checkbox").prop('checked', false);
        }
    });
</script>
@endsection


