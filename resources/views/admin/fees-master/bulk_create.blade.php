@extends('admin.layouts.master')
@section('title', $title)
@section('content')

<!-- Start Content-->
<div class="main-body">
    <div class="page-wrapper">
        <!-- [ Main Content ] start -->
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>{{ __('field_assign') }} {{ __('field_fee') }}</h5>
                    </div>
                    <div class="card-block">
                        <a href="{{ route($route.'.index') }}" class="btn btn-primary"><i class="fas fa-arrow-left"></i> {{ __('btn_back') }}</a>

                        <a href="{{ route($route.'.create') }}" class="btn btn-info"><i class="fas fa-sync-alt"></i> {{ __('btn_refresh') }}</a>
                    </div>

                    <div class="card-block">
                        <form class="needs-validation" novalidate method="get" action="{{ route('admin.fees-master-bulk.index') }}">
                            <div class="row gx-2">
                                @include('common.inc.fee_master_search_filter')
                                <div class="form-group col-md-3">
                                    <label for="seat_type_id">{{ __('field_seat_type') }} <span>*</span></label>
                                    <select class="form-control" name="seat_type_id" id="seat_type_id" required>
                                        <option value="">{{ __('select') }}</option>
                                        @foreach($seat_types as $seat_type )
                                        <option value="{{ $seat_type->id }}" @if(request()->seat_type_id == $seat_type->id) selected @endif>{{ $seat_type->name }}</option>
                                        @endforeach
                                    </select>

                                    <div class="invalid-feedback">
                                    {{ __('required_field') }} {{ __('field_seat_type') }}
                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <button type="submit" class="btn btn-info btn-filter"><i class="fas fa-search"></i> {{ __('btn_filter') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            @if(isset($rows))
            @if(count($rows) > 0)
            <div class="col-sm-12">

                <form action="{{ route('admin.fees-master-bulk.bulkStore') }}" class="needs-validation" novalidate method="post">
                @csrf
                <div class="card">
                    <div class="card-block">
                        <input type="text" name="faculty" value="{{ $selected_faculty }}" hidden>
                        <input type="text" name="program" value="{{ $selected_program }}" hidden>
                        <input type="text" name="session" value="{{ $selected_session }}" hidden>
                        <input type="text" name="semester" value="{{ $selected_semester }}" hidden>
                        <input type="text" name="section" value="{{ $selected_section }}" hidden>


                        <!-- [ Data table ] start -->
                        <div class="table-responsive">
                            <label for="title" class="form-label">{{ __('Choose Student who is submitting Fee') }} <span>*</span></label>
                            <table class="display table nowrap table-striped table-hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>
                                            <div class="checkbox checkbox-success d-inline">
                                                <input type="checkbox" id="checkbox" class="all_select" onclick="return false" checked>
                                                <label for="checkbox" class="cr" style="margin-bottom: 0px;"></label>
                                            </div>
                                        </th>
                                        <th>{{ __('field_student_id') }}</th>
                                        <th>{{ __('field_student') }}</th>
                                        <th>{{ __('field_credit_hour_short') }}</th>
                                        <th>{{ __('field_program') }}</th>
                                        <th>{{ __('field_session') }}</th>
                                        <th>{{ __('field_semester') }}</th>
                                        <th>{{ __('field_section') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  @foreach( $rows as $key => $row )
                                    <tr>
                                        <td>
                                            <div class="checkbox checkbox-primary d-inline">
                                                <input type="checkbox" onclick="return false" name="students[]" id="checkbox-{{ $row->id }}" value="{{ $row->id }}" checked>
                                                <label for="checkbox-{{ $row->id }}" class="cr"></label>
                                            </div>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.student.show', $row->student->id) }}">
                                            #{{ $row->student->student_id ?? '' }}
                                            </a>
                                        </td>
                                        <td>{{ $row->student->full_name }}</td>
                                        <td>
                                            @php
                                                $total_credits = 0;
                                                foreach($row->subjects as $subject){
                                                    $total_credits = $total_credits + $subject->credit_hour;
                                                }
                                            @endphp
                                            {{ $total_credits }}
                                        </td>
                                        <td>{{ $row->program->shortcode ?? '' }}</td>
                                        <td>{{ $row->session->title ?? '' }}</td>
                                        <td>{{ $row->semester->title ?? '' }}</td>
                                        <td>{{ $row->section->title ?? '' }}</td>
                                    </tr>
                                  @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- [ Data table ] end -->
                    </div>
                </div>

                <div class="card">
                    <div class="card-block">

                        <!-- [ Data table ] start -->
                        <div class="table-responsive">
                            <label for="title" class="form-label">{{ __('Choose Fees to assign to the students') }} <span>*</span></label>
                            <table class="display table nowrap table-striped table-hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>
                                            <div class="checkbox checkbox-success d-inline">
                                                <input type="checkbox" id="checkbox" class="all_select" onclick="return false" checked>
                                                <label for="checkbox" class="cr" style="margin-bottom: 0px;"></label>
                                            </div>
                                        </th>
                                        <th>Fee Type*</th>
                                        <th>Assign Date*</th>
                                        <th>Due Date*</th>
                                        <th>Amount (₹)*</th>
                                        <th>Amount Type</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @php
                                        $i=0;
                                    @endphp
                                    
                                    @foreach( $fee_type_master as $row )

                                    @if (round($row->amount) != 0)

                                    @php
                                        $category =  App\Models\FeesCategory::where('id', $row->fees_type_id)->first();
                                    @endphp
                                        
                                  
                                    <tr>
                                        <td>
                                            <div class="checkbox checkbox-primary d-inline">
                                                <input type="checkbox" onclick="return false" name="categorys[]" id="checkbox-{{ $category->id }}" value="{{ $category->id }}" checked>
                                                <label for="checkbox-{{ $category->id }}" class="cr"></label>
                                            </div>
                                        </td>

                                        <td>{{$category->title}}
                                        {{-- <input type="hidden" name="categorys[]" value="{{$category->title}}" /> --}}
                                        </td>
                                        <td>
                                                <input type="date" class="form-control" name="assign_date[]" id="assign_date" value="{{ date('Y-m-d') }}" readonly required>
                    
                                                <div class="invalid-feedback">
                                                    {{ __('required_field') }} {{ __('field_assign') }} {{ __('field_date') }}
                                                </div>
                                        </td>

                                        <td>
                                                <input type="date" class="form-control date" name="due_date[]" id="due_date" value="{{ date('Y-m-d') }}" min="{{ date('Y-m-d') }}" required>
                    
                                                <div class="invalid-feedback">
                                                  {{ __('required_field') }} {{ __('field_due_date') }}
                                                </div>
                                        </td>

                                        <td>                            
                                            <input type="number" class="form-control" name="amount[]" id="amount" value="{{$row->amount}}" min="0" readonly required>
                                        </td>
                                        <td>
                                            <div class="form-group col-md-6">
                                                <div class="radio d-inline" id="{{ $category->id }}">
                                                    <input type="radio" name="type[{{$i}}]" id="type_fixed{{ $category->id }}" value="1" @if( old('type') == null ) checked @elseif( old('type') == 1 )  checked @endif>
                                                    <label for="type_fixed{{ $category->id }}" class="cr">{{ __('amount_type_fixed') }}</label>
                                                </div>
                                                <div class="radio d-inline" id="{{ $category->id . rand() }}">
                                                    <input type="radio" name="type[{{$i}}]" id="type_per_credit{{ $category->id }}" value="2" @if( old('type') == 2 ) checked @endif>
                                                    <label for="type_per_credit{{ $category->id }}" class="cr">{{ __('amount_type_per_credit') }}</label>
                                                </div>

                                                {{-- <fieldset id="motorcyle{{rand()}}">
                                                    <input type="radio" value="Honda" name="motorcycle">
                                                    <label for="Honda">Honda</label><br>
                                                    <input type="radio" value="Yamaha" name="motorcycle">
                                                    <label for="Yamaha">Yamaha</label><br>
                                                  </fieldset><br>
                                                
                                                  Select a Car
                                                  <fieldset id="car{{rand()}}">
                                                    <input type="radio" value="Hyundai" name="car">
                                                    <label for="hyundai">Hyundai</label><br>
                                                    <input type="radio" value="Toyota" name="car">
                                                    <label for="toyota">Toyota</label><br>
                                                  </fieldset> --}}

                                            </div>
                                        </td>
                                      
                                    </tr>

                                    @php
                                    $i++;
                                @endphp

                                    @endif
                                  @endforeach
                                </tbody>
                            </table>



                            <p style="color: red">Note: Existing unpaid fee records will be replaced with above data*</p>

                           

                        </div>
                        <!-- [ Data table ] end -->

                        <div class="card-footer" style="float: right">
                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#confirmModal">
                                <i class="fas fa-check"></i> {{ __('btn_assign') }}
                            </button>
                            <!-- Include Confirm modal -->
                            @include($view.'.confirm')
                        </div>

                        
                    </div>

                    
                   
                </div>
                </form>
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
<script type="text/javascript">
"use strict";
// checkbox all-check-button selector
// $(".all_select").on('click',function(e){
//     if($(this).is(":checked")){
//         // check all checkbox
//         $("input:checkbox").prop('checked', true);
//     }
//     else if($(this).is(":not(:checked)")){
//         // uncheck all checkbox
//         $("input:checkbox").prop('checked', false);
//     }
// });

$("#category").on('change',function(e){
    $.ajax({
        type:'POST',
        url: "{{ route('get-fee-amount') }}",
        data:{
        _token:$('input[name=_token]').val(),
        fees_type_id: $(this).val(),
        seat_type_id: '{{ request()->seat_type_id }}',
        session_id: '{{ request()->session }}',
        faculty_id: '{{ request()->faculty }}',
        program_id: '{{ request()->program }}'
        },
        success:function(response){
            $('#amount').val(response);
        }

    });
});
</script>
@endsection