@extends('admin.layouts.master')
@section('title', $title)
@section('content')

<!-- Start Content-->
<div class="main-body">
    <div class="page-wrapper">
        <!-- [ Main Content ] start -->
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                      @php $student = $row; @endphp
                      @php
                        $curr_enroll = \App\Models\Student::enroll($row->id);
                      @endphp

                      @if(is_file('uploads/'.$path.'/'.$row->photo))
                      <img src="{{ asset('uploads/'.$path.'/'.$row->photo) }}" class="card-img-top img-fluid profile-thumb" alt="{{ __('field_photo') }}" onerror="this.src='{{ asset('dashboard/images/user/avatar-1.jpg') }}';">
                      @else
                      <img src="{{ asset('dashboard/images/user/avatar-1.jpg') }}" class="card-img-top img-fluid profile-thumb" alt="{{ __('field_photo') }}">
                      @endif

                  <div class="card-header">
                    <h5 class="card-title">{{ $row->first_name }} {{ $row->last_name }}</h5>
                  </div>
                  <ul class="list-group list-group-flush">
                    @if(isset($row->student_id))
                    <li class="list-group-item"><mark class="text-primary">{{ __('field_student_id') }}</mark> : #{{ $row->student_id }}</li>
                    @endif
                    @if(isset($row->registration_no))
                    <li class="list-group-item"><mark class="text-primary">{{ __('field_registration_no') }}</mark> : #{{ $row->registration_no }}</li>
                    @endif

                    <li class="list-group-item"><mark class="text-primary">{{ __('field_batch') }}</mark> : {{ $row->batch->title ?? '' }}</li>
                    <li class="list-group-item"><mark class="text-primary">{{ __('field_program') }}</mark> : {{ $row->program->title ?? '' }}</li>
                    <li class="list-group-item"><mark class="text-primary">{{ __('field_phone') }}</mark> : {{ $row->phone }}</li>
                    <li class="list-group-item"><mark class="text-primary">{{ __('field_email') }}</mark> : {{ $row->email }}</li>

                    <li class="list-group-item"><mark class="text-primary">{{ __('field_admission_date') }}</mark> : 
                        @if(isset($setting->date_format))
                        {{ date($setting->date_format, strtotime($row->admission_date)) }}
                        @else
                        {{ date("Y-m-d", strtotime($row->admission_date)) }}
                        @endif
                    </li>

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

                    <li class="list-group-item"><mark class="text-primary">{{ __('field_total_credit_hour') }} :</mark> {{ number_format((float)$total_credits, 2, '.', '') }}</li>

                    <li class="list-group-item"><mark class="text-primary">{{ __('field_cumulative_gpa') }} :</mark> 
                        @php
                        if($total_credits <= 0){
                            $total_credits = 1;
                        }
                        $com_gpa = $total_cgpa / $total_credits;
                        echo number_format((float)$com_gpa, 2, '.', '');
                        @endphp
                    </li>
                  </ul>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-block">
                        <div class="">
                            <div class="row">
                                <div class="col-md-6">
                                    <fieldset class="row gx-2 scheduler-border">
                                    {{-- <p><mark class="text-primary">{{ __('field_father_name') }}:</mark> {{ $row->father_name }}</p><hr/>
                                    <p><mark class="text-primary">{{ __('field_father_occupation') }}:</mark> {{ $row->father_occupation }}</p><hr/>
                                    <p><mark class="text-primary">{{ __('field_mother_name') }}:</mark> {{ $row->mother_name }}</p><hr/>
                                    <p><mark class="text-primary">{{ __('field_mother_occupation') }}:</mark> {{ $row->mother_occupation }}</p><hr/> --}}

                                    <p><mark class="text-primary">{{ __('field_gender') }}:</mark> 
                                        @if( $row->gender == 1 )
                                        {{ __('gender_male') }}
                                        @elseif( $row->gender == 2 )
                                        {{ __('gender_female') }}
                                        @elseif( $row->gender == 3 )
                                        {{ __('gender_other') }}
                                        @endif
                                    </p><hr/>

                                    <p><mark class="text-primary">{{ __('field_dob') }}:</mark> 
                                        @if(isset($setting->date_format))
                                        {{ date($setting->date_format, strtotime($row->dob)) }}
                                        @else
                                        {{ date("Y-m-d", strtotime($row->dob)) }}
                                        @endif
                                    </p><hr/>

                                    <p><mark class="text-primary">{{ __('field_marital_status') }}:</mark> 
                                        @if( $row->marital_status == 1 )
                                        {{ __('marital_status_single') }}
                                        @elseif( $row->marital_status == 2 )
                                        {{ __('marital_status_married') }}
                                        @elseif( $row->marital_status == 3 )
                                        {{ __('marital_status_widowed') }}
                                        @elseif( $row->marital_status == 4 )
                                        {{ __('marital_status_divorced') }}
                                        @elseif( $row->marital_status == 5 )
                                        {{ __('marital_status_other') }}
                                        @endif
                                    </p><hr/>

                                    <p><mark class="text-primary">{{ __('mother_tongue') }}:</mark> 
                                        {{ @$row->motherTongue->name }}
                                    </p><hr/>

                                    <p><mark class="text-primary">{{ __('field_blood_group') }}:</mark> 
                                        @if( $row->blood_group == 1 )
                                        {{ __('A+') }}
                                        @elseif( $row->blood_group == 2 )
                                        {{ __('A-') }}
                                        @elseif( $row->blood_group == 3 )
                                        {{ __('B+') }}
                                        @elseif( $row->blood_group == 4 )
                                        {{ __('B-') }}
                                        @elseif( $row->blood_group == 5 )
                                        {{ __('AB+') }}
                                        @elseif( $row->blood_group == 6 )
                                        {{ __('AB-') }}
                                        @elseif( $row->blood_group == 7 )
                                        {{ __('O+') }}
                                        @elseif( $row->blood_group == 8 )
                                        {{ __('O-') }}
                                        @endif
                                    </p><hr/>

                                    <p><mark class="text-primary">{{ __('field_religion') }}:</mark> {{ $row->religion }}</p><hr/>

                                    <p><mark class="text-primary">{{ __('field_category') }}:</mark> {{ @$row->userCategory->name }}</p><hr/>

                                    <p><mark class="text-primary">{{ __('field_caste') }}:</mark> {{ @$row->casteName->name }}</p><hr/>

                                    <p><mark class="text-primary">{{ __('field_seat_type') }}:</mark> {{ @$row->seatType->name }}</p><hr/>
                                    
                                    <p><mark class="text-primary">{{ __('field_group_by') }}:</mark> {{ @$row->group->name }}</p><hr/>
                                    <p><mark class="text-primary">{{ __('field_identification_marks') }}:</mark> {{ @$row->identification_marks }}</p><hr/>
                                    </fieldset>

                                    <!-- <fieldset class="row gx-2 scheduler-border">
                                    <p><mark class="text-primary">{{ __('field_national_id') }}:</mark> {{ $row->national_id }}</p><hr/>
                                    <p><mark class="text-primary">{{ __('field_passport_no') }}:</mark> {{ $row->passport_no }}</p>
                                    </fieldset> -->
                                </div>
                                <div class="col-md-6">
                                    <fieldset class="row gx-2 scheduler-border">
                                    <legend>{{ __('field_present') }} {{ __('field_address') }}</legend>
                                    <p><mark class="text-primary">{{ __('field_country') }}:</mark> {{ $row->presentAddress->country->title ?? '' }}</p><hr/>
                                    <p><mark class="text-primary">{{ __('field_province') }}:</mark> {{ $row->presentAddress->state->title ?? '' }}</p><hr/>
                                    <p><mark class="text-primary">{{ __('field_district') }}:</mark> {{ $row->presentAddress->district->title ?? '' }}</p><hr/>
                                    <p><mark class="text-primary">{{ __('field_pincode') }}:</mark> {{ @$row->presentAddress->payload['pincode'] ?? '--' }}</p><hr/>
                                    <p><mark class="text-primary">{{ __('field_address1') }}:</mark> {{ @$row->presentAddress->payload['address_1'] ?? '--' }}</p>
                                    <p><mark class="text-primary">{{ __('field_address2') }}:</mark> {{ @$row->presentAddress->payload['address_2'] ?? '--' }}</p>
                                    </fieldset>
                                    
                                    <fieldset class="row gx-2 scheduler-border">
                                    <legend>{{ __('field_permanent') }} {{ __('field_address') }}</legend>
                                    <p><mark class="text-primary">{{ __('field_country') }}:</mark> {{ @$row->permanentAddress->country->title ?? '' }}</p><hr/>
                                    <p><mark class="text-primary">{{ __('field_province') }}:</mark> {{ @$row->permanentAddress->state->title ?? '' }}</p><hr/>
                                    <p><mark class="text-primary">{{ __('field_district') }}:</mark> {{ $row->permanentAddress->district->title ?? '' }}</p><hr/>
                                    <p><mark class="text-primary">{{ __('field_pincode') }}:</mark> {{ @$row->permanentAddress->payload['pincode'] ?? '--' }}</p><hr/>
                                    <p><mark class="text-primary">{{ __('field_address1') }}:</mark> {{ @$row->permanentAddress->payload['address_1'] ?? '--' }}</p>
                                    <p><mark class="text-primary">{{ __('field_address2') }}:</mark> {{ @$row->permanentAddress->payload['address_2'] ?? '--' }}</p>
                                    </fieldset>

                                    <fieldset class="row gx-2 scheduler-border">
                                    <p><mark class="text-primary">{{ __('field_hostel') }}:</mark> {{ $row->hostelRoom->room->hostel->name ?? '' }}</p><hr/>
                                    <p><mark class="text-primary">{{ __('field_room') }}:</mark> {{ $row->hostelRoom->room->name ?? '' }}</p><hr/>
                                    </fieldset>
                                    <fieldset class="row gx-2 scheduler-border">
                                    <p><mark class="text-primary">{{ __('field_route') }}:</mark> {{ $row->transport->transportRoute->title ?? '' }}</p><hr/>
                                    <p><mark class="text-primary">{{ __('field_vehicle') }}:</mark> {{ $row->transport->vehicle->number ?? '' }}</p>
                                    </fieldset>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="pills-transcript-tab" data-bs-toggle="pill" href="#pills-transcript" role="tab" aria-controls="pills-transcript" aria-selected="true">{{ __('tab_transcript') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="pills-educational-tab" data-bs-toggle="pill" href="#pills-educational" role="tab" aria-controls="pills-educational" aria-selected="false">{{ __('tab_educational_info') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="pills-fees-tab" data-bs-toggle="pill" href="#pills-fees" role="tab" aria-controls="pills-fees" aria-selected="false">{{ __('tab_fees_assign') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="pills-book-tab" data-bs-toggle="pill" href="#pills-book" role="tab" aria-controls="pills-book" aria-selected="false">{{ __('tab_book_issues') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="pills-notes-tab" data-bs-toggle="pill" href="#pills-notes" role="tab" aria-controls="pills-notes" aria-selected="false">{{ __('tab_notes') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="pills-leave-tab" data-bs-toggle="pill" href="#pills-leave" role="tab" aria-controls="pills-leave" aria-selected="false">{{ __('tab_leave') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="pills-documents-tab" data-bs-toggle="pill" href="#pills-documents" role="tab" aria-controls="pills-documents" aria-selected="false">{{ __('tab_documents') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="pills-banks-tab" data-bs-toggle="pill" href="#pills-banks" role="tab" aria-controls="pills-banks" aria-selected="false">{{ __('tab_bank_info') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="pills-guardians-tab" data-bs-toggle="pill" href="#pills-guardians" role="tab" aria-controls="pills-guardians" aria-selected="false">{{ __('tab_guardians_info') }}</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="pills-transcript" role="tabpanel" aria-labelledby="pills-transcript-tab">
                                @php
                                    $semesters_check = 0;
                                    $semester_items = array();
                                @endphp

                                @foreach($row->studentEnrolls as $key => $enroll)
                                    @if($enroll->session && $enroll->session->title && $semesters_check != $enroll->session->title)
                                        @php
                                            array_push($semester_items, array($enroll->session->title, $enroll->semester->title, $enroll->section->title));
                                            $semesters_check = $enroll->session->title;
                                        @endphp
                                    @endif
                                @endforeach

                                @foreach($semester_items as $key => $semester_item)
                                <div class="clearfix"></div>
                                <div class="table-responsive">
                                    <div class="card-header">
                                        <h5>{{ $semester_item[0] }} | {{ $semester_item[1] }} | {{ $semester_item[2] }}</h5>
                                    </div>
                                    <!-- [ Data table ] start -->
                                    <div class="table-responsive">
                                        <table class="display table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>{{ __('field_code') }}</th>
                                                    <th>{{ __('field_subject') }}</th>
                                                    <th>{{ __('field_credit_hour') }}</th>
                                                    <th>{{ __('field_point') }}</th>
                                                    <th>{{ __('field_grade') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $semester_credits = 0;
                                                    $semester_cgpa = 0;
                                                @endphp
                                                @foreach($row->studentEnrolls as $key => $item)
                                                @if($item->session && $item->semester && $semester_item[1] == $item->semester->title && $semester_item[0] == $item->session->title)
                                                    @foreach($item->subjects as $subject)
                                                        @php
                                                            $semester_credits = $semester_credits + $subject->credit_hour;
                                                            $subject_grade = null;
                                                        @endphp
                                                        
                                                        <tr>
                                                            <td>{{ $subject->code }}</td>
                                                            <td>
                                                                {{ $subject->title }}
                                                                @if($subject->subject_type == 0)
                                                                ({{ __('subject_type_optional') }})
                                                                @endif
                                                            </td>
                                                            <td>{{ round($subject->credit_hour, 2) }}</td>
                                                            <td>
                                                                @if(isset($item->subjectMarks))
                                                                @foreach($item->subjectMarks as $mark)
                                                                    @if($mark->subject_id == $subject->id && $mark->publish_date <= date('Y-m-d') && $mark->publish_time <= date('H:i:s'))
                                                                    @php
                                                                    $marks_per = round($mark->total_marks);
                                                                    @endphp
                                            
                                                                    @foreach($grades as $grade)
                                                                    @if($marks_per >= $grade->min_mark && $marks_per <= $grade->max_mark)
                                                                    {{ number_format((float)$grade->point * $subject->credit_hour, 2, '.', '') }}
                                                                    @php
                                                                    $semester_cgpa = $semester_cgpa + ($grade->point * $subject->credit_hour);
                                                                    $subject_grade = $grade->title;
                                                                    @endphp
                                                                    @break
                                                                    @endif
                                                                    @endforeach
                                            
                                                                    @endif
                                                                @endforeach
                                                                @endif
                                                            </td>
                                                            <td>{{ $subject_grade ?? '' }}</td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                            @endforeach
                                            
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th colspan="2">{{ __('field_term_total') }}</th>
                                                    <th>{{ $semester_credits }}</th>
                                                    <th>{{ number_format((float)$semester_cgpa, 2, '.', '') }}</th>
                                                    <th></th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                    <!-- [ Data table ] end -->
                                </div>
                                @endforeach
                            </div>
                            <div class="tab-pane fade" id="pills-educational" role="tabpanel" aria-labelledby="pills-educational-tab">
                                <div class="row">
                                    <div class="col-md-12">
                                        <fieldset class="row gx-2 scheduler-border">
                                        <p><mark class="text-primary">{{ __('field_batch') }}:</mark> {{ $row->batch->title ?? '' }}</p><hr/>
                                        <p><mark class="text-primary">{{ __('field_program') }}:</mark> {{ $row->program->title ?? '' }}</p><hr/>
                                        <p><mark class="text-primary">{{ __('field_session') }}:</mark> {{ $curr_enroll->session->title ?? '' }}</p><hr/>
                                        <p><mark class="text-primary">{{ __('field_semester') }}:</mark> {{ $curr_enroll->semester->title ?? '' }}</p><hr/>
                                        <p><mark class="text-primary">{{ __('field_section') }}:</mark> {{ $curr_enroll->section->title ?? '' }}</p><hr/>

                                        <p><mark class="text-primary">{{ __('field_status') }}:</mark> 
                                        @foreach($row->statuses as $key => $status)
                                            <span class="badge badge-primary">{{ $status->title }}</span>
                                        @endforeach
                                        </p><hr/>
                                        </fieldset>
                                    </div>
                                    <div class="col-md-12">
                                        <div>
                                            <h5 class="text-primary">{{ __('field_school_information') }}</h5>
                                         </div>
                                         @if ($school_educations->count() != 0)
                                         <div class="table-responsive">
                                            <table id="table" class="display table nowrap table-striped table-hover" style="width:100%">
                                               <thead>
                                                  <tr>
                                                        <th>#</th>
                                                        <th>{{ __('field_school_name') }}</th>
                                                        <th>{{ __('field_board') }}</th>
                                                        <th>{{ __('field_year_of_passing') }}</th>
                                                        <th>{{ __('field_exam_id') }}</th>
                                                        <th>{{ __('field_hall_ticket_no') }}</th>
                                                        <th>{{ __('field_marks') }}</th>
                                                        <th>{{ __('field_percenteage') }}</th>
                                                        <th>{{ __('GPA') }}</th>
                                                  </tr>
                                               </thead>
                                               <tbody>
                                                  @foreach($school_educations as $key => $school_education )
                                                     <tr>
                                                           <td>{{ $key + 1 }}</td>
                                                           <td>{{ @$school_education->payload['school_name'] }}</td>
                                                           <td>{{ @$school_education->payload['board'] }}</td>
                                                           <td>
                                                           {{ @$school_education->payload['year_of_passing'] }}
                                                           </td>
                                                           <td>
                                                           {{ @$school_education->payload['school_exam_id'] }}
                                                           </td>
                                                           <td>
                                                           {{ @$school_education->payload['hall_ticket_no'] }}
                                                           </td>
                                                           <td>
                                                           {{ @$school_education->payload['total_marks'] }} / {{ @$school_education->payload['obtain_marks'] }}
                                                           </td>
                                                           <td>
                                                           {{ @$school_education->payload['percentage'] }}
                                                           </td>
                                                           <td>
                                                           {{ @$school_education->payload['gpa'] }}
                                                           </td>
                                                     </tr>
                                                  @endforeach
                                               </tbody>
                                            </table>
                                         </div> 
                                         @else
                                            <div class="text-muted text-center">
                                                No data added yet!
                                            </div> 
                                         @endif
                                    </div>
                                    <div class="col-12">
                                        <div>
                                            <h5 class="text-primary">{{ __('field_college_information') }}</h5>
                                         </div>
                                         <!-- [ Data table ] start -->
                                         @if ($college_educations->count() != 0)
                                            <div class="table-responsive">
                                                <table id="table" class="display table nowrap table-striped table-hover" style="width:100%">
                                                <thead>
                                                    <tr>
                                                            <th>#</th>
                                                            <th>{{ __('field_collage_name') }}</th>
                                                            <th>{{ __('field_institution') }}</th>
                                                            <th>{{ __('field_graduation_year') }}</th>
                                                            <th>{{ __('field_exam_id') }}</th>
                                                            <th>{{ __('field_hall_ticket_no') }}</th>
                                                            <th>{{ __('field_graduation_point') }}</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($college_educations as $key => $college_education)
                                                        <tr>
                                                            <td>{{ $key + 1 }}</td>
                                                            <td>{{ @$college_education->payload['collage_name'] }}</td>
                                                            <td>
                                                            {{ @$college_education->payload['institution'] }}
                                                            </td>
                                                            <td>{{ @$college_education->payload['collage_graduation_year'] }}</td>
                                                            <td>
                                                            {{ @$college_education->payload['collage_exam_id'] }}
                                                            </td>
                                                            <td>
                                                            {{ @$college_education->payload['hall_ticket_no'] }}
                                                            </td>
                                                            <td>
                                                            {{ @$college_education->payload['collage_graduation_point'] }}
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                                </table>
                                            </div>
                                         @else
                                            <div class="text-muted text-center">
                                                    No data added yet!
                                            </div> 
                                         @endif
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="pills-fees" role="tabpanel" aria-labelledby="pills-fees-tab">
                                <!-- [ Data table ] start -->
                                @isset($fees)
                                <div class="table-responsive">
                                    <table id="basic-table" class="display table nowrap table-striped table-hover" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>{{ __('field_session') }}</th>
                                                <th>{{ __('field_semester') }}</th>
                                                <th>{{ __('field_fees_type') }}</th>
                                                <th>{{ __('field_fee') }}</th>
                                                <th>{{ __('field_discount') }}</th>
                                                <th>{{ __('field_fine_amount') }}</th>
                                                <th>{{ __('field_net_amount') }}</th>
                                                <th>{{ __('field_due_date') }}</th>
                                                <th>{{ __('field_status') }}</th>
                                                <th>{{ __('field_pay_date') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                          @foreach( $fees->sortByDesc('id') as $key => $row )
                                          @if($row->status == 0)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $row->studentEnroll->session->title ?? '' }}</td>
                                                <td>{{ $row->studentEnroll->semester->title ?? '' }}</td>
                                                <td>{{ $row->category->title ?? '' }}</td>
                                                <td>
                                                    @if(isset($setting->decimal_place))
                                                    {{ number_format((float)$row->fee_amount, $setting->decimal_place, '.', '') }} 
                                                    @else
                                                    {{ number_format((float)$row->fee_amount, 2, '.', '') }} 
                                                    @endif 
                                                    {!! $setting->currency_symbol !!}
                                                </td>
                                                <td>
                                                    @php 
                                                    $discount_amount = 0;
                                                    $today = date('Y-m-d');
                                                    @endphp

                                                    @isset($row->category)
                                                    @foreach($row->category->discounts->where('status', '1') as $discount)

                                                    @php
                                                    $availability = \App\Models\FeesDiscount::availability($discount->id, $row->studentEnroll->student_id);
                                                    @endphp

                                                    @if(isset($availability))
                                                    @if($discount->start_date <= $today && $discount->end_date >= $today)
                                                        @if($discount->type == '1')
                                                            @php
                                                            $discount_amount = $discount_amount + $discount->amount;
                                                            @endphp
                                                        @else
                                                            @php
                                                            $discount_amount = $discount_amount + ( ($row->fee_amount / 100) * $discount->amount);
                                                            @endphp
                                                        @endif
                                                    @endif
                                                    @endif
                                                    @endforeach
                                                    @endisset


                                                    @if(isset($setting->decimal_place))
                                                    {{ number_format((float)$discount_amount, $setting->decimal_place, '.', '') }} 
                                                    @else
                                                    {{ number_format((float)$discount_amount, 2, '.', '') }} 
                                                    @endif 
                                                    {!! $setting->currency_symbol !!}
                                                </td>
                                                <td>
                                                    @php
                                                        $fine_amount = 0;
                                                    @endphp
                                                    @if(empty($row->pay_date) || $row->due_date < $row->pay_date)
                                                        
                                                        @php
                                                        $due_date = strtotime($row->due_date);
                                                        $today = strtotime(date('Y-m-d')); 
                                                        $days = (int)(($today - $due_date)/86400);
                                                        @endphp

                                                        @if($row->due_date < date("Y-m-d"))
                                                        @isset($row->category)
                                                        @foreach($row->category->fines->where('status', '1') as $fine)
                                                        @if($fine->start_day <= $days && $fine->end_day >= $days)
                                                            @if($fine->type == '1')
                                                                @php
                                                                $fine_amount = $fine_amount + $fine->amount;
                                                                @endphp
                                                            @else
                                                                @php
                                                                $fine_amount = $fine_amount + ( ($row->fee_amount / 100) * $fine->amount);
                                                                @endphp
                                                            @endif
                                                        @endif
                                                        @endforeach
                                                        @endisset
                                                        @endif
                                                    @endif


                                                    @if(isset($setting->decimal_place))
                                                    {{ number_format((float)$fine_amount, $setting->decimal_place, '.', '') }} 
                                                    @else
                                                    {{ number_format((float)$fine_amount, 2, '.', '') }} 
                                                    @endif 
                                                    {!! $setting->currency_symbol !!}
                                                </td>
                                                <td>
                                                    @php
                                                    $net_amount = ($row->fee_amount - $discount_amount) + $fine_amount;
                                                    @endphp

                                                    @if(isset($setting->decimal_place))
                                                    {{ number_format((float)$net_amount, $setting->decimal_place, '.', '') }} 
                                                    @else
                                                    {{ number_format((float)$net_amount, 2, '.', '') }} 
                                                    @endif 
                                                    {!! $setting->currency_symbol !!}
                                                </td>
                                                <td>
                                                    @if(isset($setting->date_format))
                                                    {{ date($setting->date_format, strtotime($row->due_date)) }}
                                                    @else
                                                    {{ date("Y-m-d", strtotime($row->due_date)) }}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($row->status == 1)
                                                    <span class="badge badge-pill badge-success">{{ __('status_paid') }}</span>
                                                    @else
                                                    <span class="badge badge-pill badge-danger">{{ __('status_pending') }}</span>
                                                    @endif
                                                </td>
                                                <td></td>
                                            </tr>

                                          @elseif($row->status == 1)

                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $row->studentEnroll->session->title ?? '' }}</td>
                                                <td>{{ $row->studentEnroll->semester->title ?? '' }}</td>
                                                <td>{{ $row->category->title ?? '' }}</td>
                                                <td>
                                                    @if(isset($setting->decimal_place))
                                                    {{ number_format((float)$row->fee_amount, $setting->decimal_place, '.', '') }} 
                                                    @else
                                                    {{ number_format((float)$row->fee_amount, 2, '.', '') }} 
                                                    @endif 
                                                    {!! $setting->currency_symbol !!}
                                                </td>
                                                <td>
                                                    @if(isset($setting->decimal_place))
                                                    {{ number_format((float)$row->discount_amount, $setting->decimal_place, '.', '') }} 
                                                    @else
                                                    {{ number_format((float)$row->discount_amount, 2, '.', '') }} 
                                                    @endif 
                                                    {!! $setting->currency_symbol !!}
                                                </td>
                                                <td>
                                                    @if(isset($setting->decimal_place))
                                                    {{ number_format((float)$row->fine_amount, $setting->decimal_place, '.', '') }} 
                                                    @else
                                                    {{ number_format((float)$row->fine_amount, 2, '.', '') }} 
                                                    @endif 
                                                    {!! $setting->currency_symbol !!}
                                                </td>
                                                <td>
                                                    @if(isset($setting->decimal_place))
                                                    {{ number_format((float)$row->paid_amount, $setting->decimal_place, '.', '') }} 
                                                    @else
                                                    {{ number_format((float)$row->paid_amount, 2, '.', '') }} 
                                                    @endif 
                                                    {!! $setting->currency_symbol !!}
                                                </td>
                                                <td>
                                                    @if(isset($setting->date_format))
                                                    {{ date($setting->date_format, strtotime($row->due_date)) }}
                                                    @else
                                                    {{ date("Y-m-d", strtotime($row->due_date)) }}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($row->status == 1)
                                                    <span class="badge badge-pill badge-success">{{ __('status_paid') }}</span>
                                                    @else
                                                    <span class="badge badge-pill badge-danger">{{ __('status_pending') }}</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if(isset($setting->date_format))
                                                    {{ date($setting->date_format, strtotime($row->pay_date)) }}
                                                    @else
                                                    {{ date("Y-m-d", strtotime($row->pay_date)) }}
                                                    @endif
                                                </td>
                                            </tr>
                                          @endif
                                          @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                @endif
                                <!-- [ Data table ] end -->
                            </div>
                            <div class="tab-pane fade" id="pills-book" role="tabpanel" aria-labelledby="pills-book-tab">
                                <!-- [ Data table ] start -->
                                <div class="table-responsive">
                                    <table id="basic-table2" class="display table nowrap table-striped table-hover" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>{{ __('field_isbn') }}</th>
                                                <th>{{ __('field_book') }}</th>
                                                <th>{{ __('field_issue_date') }}</th>
                                                <th>{{ __('field_due_return_date') }}</th>
                                                <th>{{ __('field_return_date') }}</th>
                                                <th>{{ __('field_status') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                          @isset($student->member)
                                          @foreach( $student->member->issuReturn->sortByDesc('id') as $key => $row )
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $row->book->isbn ?? '' }}</td>
                                                <td>{{ $row->book->title ?? '' }}</td>
                                                <td>
                                                    @if(isset($setting->date_format))
                                                    {{ date($setting->date_format, strtotime($row->issue_date)) }}
                                                    @else
                                                    {{ date("Y-m-d", strtotime($row->issue_date)) }}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if(isset($setting->date_format))
                                                    {{ date($setting->date_format, strtotime($row->due_date)) }}
                                                    @else
                                                    {{ date("Y-m-d", strtotime($row->due_date)) }}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if(!empty($row->return_date))
                                                    @if(isset($setting->date_format))
                                                        {{ date($setting->date_format, strtotime($row->return_date)) }}
                                                    @else
                                                        {{ date("Y-m-d", strtotime($row->return_date)) }}
                                                    @endif
                                                    @endif
                                                </td>
                                                <td>
                                                    @if( $row->status == 0 )
                                                    <span class="badge badge-pill badge-danger">{{ __('status_lost') }}</span>

                                                    @elseif( $row->status == 1 )
                                                    @if($row->due_date < date("Y-m-d"))
                                                    <span class="badge badge-pill badge-danger">{{ __('status_delay') }}</span>
                                                    @else
                                                    <span class="badge badge-pill badge-primary">{{ __('status_issued') }}</span>
                                                    @endif

                                                    @elseif( $row->status == 2 )
                                                    <span class="badge badge-pill badge-success">{{ __('status_returned') }}</span>
                                                    @if($row->due_date < $row->return_date)
                                                    <span class="badge badge-pill badge-danger">{{ __('status_delayed') }}</span>
                                                    @endif
                                                    @endif
                                                </td>
                                            </tr>
                                          @endforeach
                                          @endisset
                                        </tbody>
                                    </table>
                                </div>
                                <!-- [ Data table ] end -->
                            </div>
                            <div class="tab-pane fade" id="pills-notes" role="tabpanel" aria-labelledby="pills-notes-tab">
                                <!-- [ Data table ] start -->
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>{{ __('field_date') }}</th>
                                                <th>{{ __('field_title') }}</th>
                                                <th>{{ __('field_note') }}</th>
                                                <th>{{ __('field_attach') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($student->notes->where('status', 1)->sortBy('id') as $note)
                                            <tr>
                                                <td>
                                                @if(isset($setting->date_format))
                                                {{ date($setting->date_format, strtotime($note->created_at)) }}
                                                @else
                                                {{ date("Y-m-d", strtotime($note->created_at)) }}
                                                @endif
                                                </td>
                                                <td>{{ $note->title }}</td>
                                                <td>{{ $note->description }}</td>
                                                <td>
                                                @if(is_file('uploads/note/'.$note->attach))
                                                <a href="{{ asset('uploads/note/'.$note->attach) }}" class="btn btn-sm btn-icon btn-dark" download><i class="fas fa-download"></i></a>
                                                @endif
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <!-- [ Data table ] end -->
                            </div>
                            <div class="tab-pane fade" id="pills-leave" role="tabpanel" aria-labelledby="pills-leave-tab">
                                <!-- [ Data table ] start -->
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>{{ __('field_leave_date') }}</th>
                                                <th>{{ __('field_days') }}</th>
                                                <th>{{ __('field_apply_date') }}</th>
                                                <th>{{ __('field_status') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($student->leaves->sortByDesc('id') as $leave)
                                            <tr>
                                                <td>
                                                    @if(isset($setting->date_format))
                                                        {{ date($setting->date_format, strtotime($leave->from_date)) }}
                                                    @else
                                                        {{ date("Y-m-d", strtotime($leave->from_date)) }}
                                                    @endif
                                                    -
                                                    @if(isset($setting->date_format))
                                                        {{ date($setting->date_format, strtotime($leave->to_date)) }}
                                                    @else
                                                        {{ date("Y-m-d", strtotime($leave->to_date)) }}
                                                    @endif
                                                </td>
                                                <td>{{ (int)((strtotime($leave->to_date) - strtotime($leave->from_date))/86400) + 1 }}</td>
                                                <td>
                                                    @if(isset($setting->date_format))
                                                        {{ date($setting->date_format, strtotime($leave->apply_date)) }}
                                                    @else
                                                        {{ date("Y-m-d", strtotime($leave->apply_date)) }}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if( $leave->status == 1 )
                                                    <span class="badge badge-pill badge-success">{{ __('status_approved') }}</span>
                                                    @elseif( $leave->status == 2 )
                                                    <span class="badge badge-pill badge-danger">{{ __('status_rejected') }}</span>
                                                    @else
                                                    <span class="badge badge-pill badge-primary">{{ __('status_pending') }}</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <!-- [ Data table ] end -->
                            </div>
                            <div class="tab-pane fade" id="pills-documents" role="tabpanel" aria-labelledby="pills-documents-tab">
                                <!-- [ Data table ] start -->
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>{{ __('field_title') }}</th>
                                                <th>{{ __('field_document') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>{{ __('field_photo') }}</td>
                                                <td>
                                                @if(is_file('uploads/'.$path.'/'.$student->photo))
                                                    <img src="{{ asset('uploads/'.$path.'/'.$student->photo) }}" class="img-fluid field-image" onerror="this.src='{{ asset('dashboard/images/user/avatar-1.jpg') }}';">
                                                @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>{{ __('field_signature') }}</td>
                                                <td>
                                                @if(is_file('uploads/'.$path.'/'.$student->signature))
                                                    <img src="{{ asset('uploads/'.$path.'/'.$student->signature) }}" class="img-fluid field-image" onerror="this.src='{{ asset('dashboard/images/user/avatar-1.jpg') }}';">
                                                @endif
                                                </td>
                                            </tr>
                                            @foreach($student->documents as $document)
                                            <tr>
                                                <td>{{ $document->title }}</td>
                                                <td>
                                                @if(is_file('uploads/'.$path.'/'.$document->attach))
                                                <a target="__blank" href="{{ asset('uploads/'.$path.'/'.$document->attach) }}" class="btn btn-sm btn-icon btn-dark" download><i class="fas fa-download"></i></a>
                                                @endif
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <!-- [ Data table ] end -->
                            </div>
                            @isset($bank_details)
                                <div class="tab-pane fade" id="pills-banks" role="tabpanel" aria-labelledby="pills-banks-tab">
                                    <!-- [ Data table ] start -->
                                    <div class="table-responsive">
                                        <table id="basic-table" class="display table nowrap table-striped table-hover" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Bank</th>
                                                    <th>Account Holder</th>
                                                    <th>Account No.</th>
                                                    <th>IFSC Code</th>
                                                    <th>Type</th>
                                                    <th>Branch</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($bank_details as $key => $bank_detail)
                                                    <tr>
                                                        <td>{{ $key + 1 }}</td>
                                                        <td>{{ @$bank_detail->payload['bank_name'] }}</td>
                                                        <td>
                                                        {{ @$bank_detail->payload['account_holder_name'] }}
                                                        </td>
                                                        <td>
                                                        {{ @$bank_detail->payload['account_no'] }}
                                                        </td>
                                                        <td>
                                                        {{ @$bank_detail->payload['ifsc_code'] }}
                                                        </td>
                                                        <td>
                                                        {{ @$bank_detail->payload['type'] }}
                                                        </td>
                                                        <td>
                                                        {{ @$bank_detail->payload['branch'] }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- [ Data table ] end -->
                                </div>
                            @endisset

                            @isset($guardian_details)
                                <div class="tab-pane fade" id="pills-guardians" role="tabpanel" aria-labelledby="pills-guardians-tab">
                                    <!-- [ Data table ] start -->
                                    <div class="table-responsive">
                                        <table id="table" class="display table nowrap table-striped table-hover" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>{{ __('field_relation') }}</th>
                                                    <th>Name</th>
                                                    <th>Email</th>
                                                    <th>Occupation</th>
                                                    <th>Annual Income</th>
                                                    <th>Phone</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($guardian_details as $key => $guardian_detail)
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ @$guardian_detail->relation->name }}</td>
                                                    <td>
                                                      {{ @$guardian_detail->name }}
                                                    </td>
                                                    <td>
                                                    <a href="mailto:{{ @$guardian_detail->email }}"class="btn-link"  title="{{ @$guardian_detail->email }}">{{ @$guardian_detail->email }}</a>    
                                                    </td>
                                                    <td>
                                                      {{ @$guardian_detail->occupation }}
                                                    </td>
                                                    <td>
                                                    @if(@$guardian_detail->annual_income == 1)
                                                    {{ __('Below 1 Lac') }}
                                                    @elseif(@$guardian_detail->annual_income == 2)
                                                    {{ __('1 - 3 Lacs') }}
                                                    @elseif(@$guardian_detail->annual_income == 3)
                                                    {{ __('3 -5 Lacs') }}
                                                    @elseif(@$guardian_detail->annual_income == 4)
                                                    {{ __('5 - 8 Lacs') }}
                                                    @elseif(@$guardian_detail->annual_income == 5)
                                                    {{ __('8 - 10 Lacs') }}
                                                    @elseif(@$guardian_detail->annual_income == 6)
                                                    {{ __('10 - 15 Lacs') }}
                                                    @elseif(@$guardian_detail->annual_income == 6)
                                                    {{ __('More than 15 Lacs') }}
                                                    @elseif(@$guardian_detail->annual_income == 7)
                                                    {{ __('More than 15 Lacs') }}
                                                    @else
                                                    {{@$guardian_detail->annual_income}}
                                                    @endif
                                                        <!-- @if(@$guardian_detail->annual_income) ₹ @endif{{ @$guardian_detail->annual_income }} -->
                                                    </td>
                                                    <td>
                                                        <a href="tel:{{ @$guardian_detail->phone }}" class="btn-link" title="{{ @$guardian_detail->phone }}">{{ @$guardian_detail->phone }}</a>    
                                                      <!-- {{ @$guardian_detail->phone }} -->
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                      </div>
                                    <!-- [ Data table ] end -->
                                </div>
                            @endisset
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ Main Content ] end -->
    </div>
</div>
<!-- End Content-->

@endsection