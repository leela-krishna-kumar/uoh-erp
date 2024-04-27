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
                        <h5>Fee Receive Bulk</h5>
                    </div>

                    <div class="card-block">
                        <form class="needs-validation" novalidate method="get" action="{{ route('admin.fees-student.quick-received-bulk') }}">
                            <div class="row gx-2">
                                <div class="form-group col-md-3">
                                    <label for="student">{{ __('field_student_id') }} <span>*</span></label>
                                    <select class="form-control select2" name="student" id="student" required>
                                        <option value="">{{ __('select') }}</option>
                                        @foreach($students as $student)
                                        <option value="{{ $student->id }}" @if($selected_student == $student->id) selected @endif>{{ $student->id }} - {{ $student->first_name }} {{ $student->last_name }}</option>
                                        @endforeach
                                    </select>

                                    <div class="invalid-feedback">
                                      {{ __('required_field') }} {{ __('field_student_id') }}
                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <button type="submit" class="btn btn-info btn-filter"><i class="fas fa-search"></i> {{ __('btn_search') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>

                    @if(isset($row))
                    <div class="card-block">
                        @php
                            $enroll = \App\Models\Student::enroll($row->id);
                        @endphp

                        @php
                            $total_credits = 0;
                            $total_cgpa = 0;
                        @endphp
                        @foreach( $row->studentEnrolls as $key => $item )

                            @if(isset($item->subjectMarks))
                            @foreach($item->subjectMarks as $mark)

                                @php
                                $marks_per = round($mark->total_marks);
                                @endphp

                                @foreach($grades as $grade)
                                @if($marks_per >= $grade->min_mark && $marks_per <= $grade->max_mark)
                                @php
                                if($grade->point > 0){
                                $total_cgpa = $total_cgpa + ($grade->point * $mark->subject->credit_hour);
                                $total_credits = $total_credits + $mark->subject->credit_hour;
                                }
                                @endphp
                                @break
                                @endif
                                @endforeach

                            @endforeach
                            @endif

                        @endforeach

                        <div class="row">
                            <div class="col-md-6">
                                <fieldset class="row gx-2 scheduler-border">
                                    <legend>{{ __('tab_basic_info') }}</legend>
                                    <p><mark class="text-primary">{{ __('field_student_id') }}:</mark> #{{ $row->student_id }}</p>
                                    <hr/>

                                    <p><mark class="text-primary">{{ __('field_name') }}:</mark> {{ $row->first_name }} {{ $row->last_name }}</p>
                                    <hr/>

                                    <p><mark class="text-primary">{{ __('field_gender') }}:</mark> 
                                        @if( $row->gender == 1 )
                                        {{ __('gender_male') }}
                                        @elseif( $row->gender == 2 )
                                        {{ __('gender_female') }}
                                        @elseif( $row->gender == 3 )
                                        {{ __('gender_other') }}
                                        @endif
                                    </p><hr/>

                                    <p><mark class="text-primary">{{ __('field_total_credit_hour') }}:</mark> {{ round($total_credits, 2) }}</p>
                                    <hr/>

                                    <p><mark class="text-primary">{{ __('field_cumulative_gpa') }}:</mark> 
                                        @php
                                        if($total_credits <= 0){
                                            $total_credits = 1;
                                        }
                                        $com_gpa = $total_cgpa / $total_credits;
                                        echo number_format((float)$com_gpa, 2, '.', '');
                                        @endphp
                                    </p>
                                    <hr/>
                                </fieldset>
                            </div>
                            <div class="col-md-6">
                                <fieldset class="row gx-2 scheduler-border">
                                    <legend>{{ __('field_academic_information') }}</legend>
                                    <p><mark class="text-primary">{{ __('field_batch') }}:</mark> {{ $row->batch->title ?? '' }}</p><hr/>

                                    <p><mark class="text-primary">{{ __('field_program') }}:</mark> {{ $row->program->title ?? '' }}</p><hr/>

                                    <p><mark class="text-primary">{{ __('field_session') }}:</mark> {{ $enroll->session->title ?? '' }}</p><hr/>

                                    <p><mark class="text-primary">{{ __('field_semester') }}:</mark> {{ $enroll->semester->title ?? '' }}</p><hr/>

                                    <p><mark class="text-primary">{{ __('field_section') }}:</mark> {{ $enroll->section->title ?? '' }}</p><hr/>
                                </fieldset>
                            </div>
                        </div>
                    </div>
                    @endif


                    @if (isset($student_fee_data) && count($student_fee_data) != 0)                        
                   
                    
                    <form class="needs-validation" novalidate action="{{ route($route.'.quick.received.store.bulk') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="card-block">


                          <!-- [ Data table ] start -->
                          <div class="table-responsive">
                            <table class="display table table-striped">
                                <thead>
                                    <tr>
                                        <th>
                                            <div class="checkbox checkbox-success d-inline">
                                                <input type="checkbox" id="checkbox" class="all_select" checked>
                                                <label for="checkbox" class="cr" style="margin-bottom: 0px;"></label>
                                            </div>
                                        </th>
                                        <th>Fee Type</th>
                                        <th>Fee Amount</th>
                                        <th>Paid Amount</th>
                                        <th>Due Amount</th>
                                        <th>Discount</th>
                                        <th>Fine</th>
                                        {{-- <th>Fee to be paid<br /> <span style="font-size: 11px;">(Due Amount - Discount + Fine)</span></th> --}}
                                        <th>Paying Amount </th>
                                        <th>Due Date</th>
                                        <th>Pay Date</th>
                                        <th>Status</th>
                                       
                                        {{-- <th>{{ __('field_point') }}</th>
                                        <th>{{ __('field_grade') }}</th> --}}
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($student_fee_data as $student_fee)
                                        @if ($student_fee['fee_amount'] != 0)    
                                        
                                        {{-- <input type="hidden" name="fee_id" value="{{ $student_fee->id }}" /> --}}

                                            @php
                                                $fee_category = App\Models\FeesCategory::where('id', $student_fee->category_id)->first();
                                                $due_amount = $student_fee->fee_amount - $student_fee->paid_amount;
                                            @endphp
                                            <tr>
                                                <td>
                                                    <div class="checkbox checkbox-primary d-inline">
                                                        <input type="checkbox" name="fee_ids[]" id="checkbox-{{ $student_fee->id }}" value="{{ $student_fee->id }}" checked>
                                                        <label for="checkbox-{{ $student_fee->id }}" class="cr"></label>
                                                    </div>
                                                </td>
                                                <td>{{  $fee_category->title }} </td>
                                                <td><input readonly type="number" class="form-control" name="fee_amount[]" id="fee_amount{{ $student_fee->id }}" value="{{ $student_fee->fee_amount }}" required></td>                                
                                                <td><input readonly type="number" class="form-control" value="{{ $student_fee->paid_amount }}" required></td>                                

                                                <td><input readonly type="number" class="form-control" name="due_amount[]" id="due_amount{{ $student_fee->id }}" value="{{ $due_amount }}" required></td>                                
                                                
                                                <td><input type="number" class="form-control" name="discount_amount[]" id="discount{{ $student_fee->id }}" max="{{ $due_amount }}" value="{{ $student_fee->discount_amount }}" required></td>                                
                                                <td><input type="number" class="form-control" name="fine_amount[]" id="fine{{ $student_fee->id }}" max="{{ $due_amount }}" value="{{ $student_fee->fine_amount }}" required></td>
                                                
                                                {{-- <td><input readonly type="number" class="form-control" name="fee_to_be_paid[]" id="fee_to_be_paid{{ $student_fee->id }}" max="{{ $due_amount }}" value="{{ $due_amount - $student_fee->discount_amount + $student_fee->fine_amount }}" required></td>                                 --}}
                                                
                                                <td><input type="number" class="form-control paying_amount" onkeyup="netAmountCalc()" name="paid_amount[]" id="paid_amount{{ $student_fee->id }}" max="{{ $due_amount }}" value="0" required></td>
                                                
                                                <td><input type="date" class="form-control date" name="due_date[]" id="due_date" value="{{ date('Y-m-d') }}" required></td>      
                                                <td><input type="date" class="form-control date" name="pay_date[]" id="pay_date" value="{{ date('Y-m-d') }}" required></td>     
                                                
                                                <td>
                                                    @if($student_fee->status == 3)
                                                    <span class="badge badge-pill badge-warning">Partially Paid</span>
                                                    {{-- @elseif($row->status == 2)
                                                    <span class="badge badge-pill badge-danger">{{ __('status_canceled') }}</span> --}}
                                                    @elseif($student_fee->status == 0)
                                                    <span class="badge badge-pill badge-primary">{{ __('status_pending') }}</span>
                                                    @endif
                                                </td>

                                                {{-- <div class="invalid-feedback">
                                                    {{ __('required_field') }} {{ __('field_discount') }}
                                                  </div> --}}

                                            </tr>

                                            <script>

                                            </script>

                                        @endif
                                    @endforeach
                                    
                                </tbody>                               
        
                            </table>
                        </div>
                        <!-- [ Data table ] end -->

                        <script>

                        function netAmountCalc(){
                            
                            var x = document.querySelectorAll(".paying_amount");
                            var total = 0;
                            for(var i=0;i<x.length;i++)
                            {
                            total+=Number(x[i].value);
                            }
                           // console.log(total);

                           document.getElementById("net_amount_1").value = total;                            
                        }

                        </script>



                      <div class="row" style="padding-top: 15px;">
                        <!-- Form Start -->                                         

                        <div class="form-group col-md-6">
                            <label for="paid_amount" class="form-label">Total Amount ({!! $setting->currency_symbol !!}) <span>*</span></label>
                            <input type="text" class="form-control" name="net_amount_1" id="net_amount_1" value="0" readonly required>

                            <div class="invalid-feedback">
                              {{ __('required_field') }} {{ __('field_net_amount') }}
                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="payment_method" class="form-label">{{ __('field_payment_method') }} <span>*</span></label>
                            <select class="form-control" name="payment_method" id="payment_method" required>
                                <option value="">{{ __('select') }}</option>
                                <option value="1" @if( old('payment_method') == 1 ) selected @endif>{{ __('payment_method_card') }}</option>
                                <option value="2" @if( old('payment_method') == 2 ) selected @endif>{{ __('payment_method_cash') }}</option>
                                <option value="3" @if( old('payment_method') == 3 ) selected @endif>{{ __('payment_method_cheque') }}</option>
                                <option value="4" @if( old('payment_method') == 4 ) selected @endif>{{ __('payment_method_bank') }}</option>
                                <option value="5" @if( old('payment_method') == 5 ) selected @endif>{{ __('payment_method_e_wallet') }}</option>
                            </select>

                            <div class="invalid-feedback">
                              {{ __('required_field') }} {{ __('field_payment_method') }}
                            </div>
                        </div>

                        <div class="form-group col-md-12">
                            <label for="note" class="form-label">{{ __('field_note') }}</label>
                            <textarea class="form-control" name="note" id="note">{!! old('note') !!}</textarea>
                        </div>
                        <!-- Form End -->
                      </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-success"><i class="fas fa-check"></i>Pay</button>
                    </div>
                    </form>

                    @else

                        @if (isset($student_fee_data))
                            <h3 style="text-align: center;"> No Fee Dues Found</h3>
                        @endif                    

                    @endif

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

    <script type="text/javascript">
        "use strict";

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

        function feesCalculator() {
          var fee_amount = $("input[name='fee_amount']").val();
          var fine_amount = $("input[name='fine_amount']").val();
          var discount_amount = $("input[name='discount_amount']").val();
          var paid_amount = $("input[name='paid_amount']").val();
          
          //
          if (isNaN(parseFloat(fee_amount))) fee_amount = 0;
          if (isNaN(parseFloat(fine_amount))) fine_amount = 0;
          if (isNaN(parseFloat(discount_amount))) discount_amount = 0;
          $("input[name='fee_amount']").val(fee_amount);
          $("input[name='fine_amount']").val(fine_amount);
          $("input[name='discount_amount']").val(discount_amount);

          // Set Value
          var net_total = (parseFloat(fee_amount) - parseFloat(discount_amount)) + parseFloat(fine_amount);
          $("input[name='paid_amount']").val(net_total);
        }

        $("#student").on('change',function(e){
            $('#category').trigger('change');
        });
        $("#category").on('change',function(e){
            $.ajax({
                type:'POST',
                url: "{{ route('get-fee-amount') }}",
                data:{
                    _token:$('input[name=_token]').val(),
                    fees_type_id: $(this).val(),
                    student_id: $('#student').find(':selected').data('student_id'),
                },
                success:function(response){
                    $('#fee_amount').val(response);
                    $('#fee_amount').trigger('keyup');
                }

            });
        });
    </script>
@endsection