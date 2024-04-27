<!-- Edit modal content -->

@php
    $courses = ['ECE', 'EEE', 'CSE', 'IT', 'Mech', 'Civil'];
@endphp


{{-- Admission Vs Intake Modal --}}
<div id="siat" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Students Admission Vs Intake</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">

                <div class="container">

                    {{-- <h5>BTech</h5> --}}
                    <!-- [ Data table ] start -->
                    <div class="table-responsive">
                        <table id="export-table1" class="display table nowrap table-striped table-hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Course</th>
                                    <th>Branch</th>
                                    <th>Admission</th>
                                    <th>Intake</th>
                                    <th>Action</th>
                                    {{-- @foreach ($courses as $course)
                                        <th>{{ $course }}</th>
                                    @endforeach --}}
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($active_students_branch_wise as $students_branch_wise)

                                @php

                                // dd($students_branch_wise);

                                    $intake_data = App\Models\StudentIntake::where('faculty', $students_branch_wise->faculty_id)
                                                ->where('program', $students_branch_wise->program_id)
                                                ->where('batch', $students_branch_wise->batch_id)
                                                ->first();
                                @endphp

                                <tr>
                                    <td>{{ $students_branch_wise->batch->title ?? '--' }}</td>
                                    <td>{{ $students_branch_wise->program->shortcode ?? '--' }}</td>                                   
                                    <td>{{ $students_branch_wise->count ?? '--' }}</td>
                                    <td>{{ $intake_data->intake_count}} </td>     
                                    <td><a target="_blank" type="button" href="{{ url('admin/admission/student?faculty=' . $students_branch_wise->faculty_id .'&program='. $students_branch_wise->program_id . '&session=' . $students_branch_wise->session_id . '&semester=' . $students_branch_wise->semester_id . '&section=all&status=all') }}" class="btn btn-success btn-sm">View</a> </td>                                                              
                                </tr>
                                @endforeach 



                            </tbody>
                        </table>
                    </div>
                    <!-- [ Data table ] end -->

                    {{-- <div class="row" style="padding:10px;">
                    <div class="col-md-12"> --}}

                    <div class="card-block">
                        {{-- <center>
                        <div id="attendence1_barchart_material" style="height:auto;"></div>
                    </center> --}}
                        {{-- </div> --}}
                    </div>

                </div>

                {{-- <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-times"></i>
                    {{ __('btn_close') }}</button>
                <button type="submit" class="btn btn-success"><i class="fas fa-check"></i>
                    {{ __('btn_save') }}</button>
            </div> --}}

            </div>

        </div>
    </div>
</div>



{{-- Eamcet Rank Range Modal --}}
<!-- Edit modal content -->
<div id="swerr" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Students with Eamcet Ranks Range</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            </div>

            <div class="modal-body">
                <div class="container">
                    <!-- [ Data table ] start -->
                    <div class="table-responsive">
                        <table id="export-table2" class="display table nowrap table-striped table-hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th>RANK RANGE</th>
                                    <th>Total Students</th>

                                    {{-- @foreach ($courses as $course)
                                        <th>{{ $course }}</th>
                                    @endforeach --}}
                                </tr>
                            </thead>
                            <tbody>
                                
                                @foreach($eamcet as $e)

                              @php
                                //  dd($e);
                              @endphp  

                                <tr>
                                    <td>{{  $e['range'] }}</td>                                  
                                    <td>{{ $e['student_count'] }}</td>
                                </tr>
                                @endforeach
                               
                            </tbody>
                        </table>
                    </div>
                    <!-- [ Data table ] end -->

                    {{-- <div class="row" style="padding:10px;">
                    <div class="col-md-12"> --}}
                    {{-- <center>
                        <div id="attendence1_barchart_material" style="height:auto;"></div>
                    </center> --}}
                    {{-- </div>
                    </div> --}}

                </div>

            </div>

        </div>
    </div>
</div>


{{-- Seat Types --}}
<!-- Edit modal content -->
<div id="swst" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Students with Seat Type</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            </div>

            <div class="modal-body">
                <div class="container">

                    {{-- <h5>BTech</h5> --}}
                    <!-- [ Data table ] start -->
                    <div class="table-responsive">
                        <table id="export-table3" class="display table nowrap table-striped table-hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Course</th>    
                                    <th>Branch</th>    
                                    <th>Seat Type</th>  
                                    <th>Total</th>                                   

                                    {{-- @foreach ($courses as $course)
                                        <th>{{ $course }}</th>
                                    @endforeach --}}

                                    {{-- @foreach ($seat_type_ids as $seat_type_ida)

                                    @php
                                        $seat_type = App\Models\SeatType::find($seat_type_ida->seat_type_id);
                                    @endphp
                                        <th>{{ $seat_type->name }}</th>
                                    @endforeach --}}
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($seat_type_ids_branch_wise as $seat_type_id_branch_wise)

                                @php
                                        $seat_type = App\Models\SeatType::find($seat_type_id_branch_wise->seat_type_id);
                                    @endphp
                                   
                                    <tr>
                                        <th>{{ $seat_type_id_branch_wise->batch->title ?? '--' }}</th>
                                        <th>{{ $seat_type_id_branch_wise->program->shortcode ?? '--' }}</th>                                       
                                        <td>{{ $seat_type->name }}</td>
                                        <td>{{ $seat_type_id_branch_wise->seat_type_count_bw }}</td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                    <!-- [ Data table ] end -->


                 <!--    <h5>MTech</h5>
                   <div class="table-responsive">
                        <table class="display table nowrap table-striped table-hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Seat Type</th>

                                    @foreach ($courses as $course)
                                        <th>{{ $course }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($seat_type_ids as $seat_type_ida)
                                    @php
                                        //dd($seat_type_ida->seat_type_id);
                                        $seat_type = App\Models\SeatType::find($seat_type_ida->seat_type_id);
                                        //  $ece = App\Models\SeatType::find($seat_type_ida->seat_type_id);
                                    @endphp

                                    <tr>
                                        <td>{{ $seat_type->name }}</td>
                                        @for ($i = 0; $i < 6; $i++)
                                            <td>200</td>
                                        @endfor
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div> -->
                    <!-- [ Data table ] end -->

                    {{-- <div class="row" style="padding:10px;">
                    <div class="col-md-12"> --}}
                    {{-- <center>
                        <div id="attendence1_barchart_material" style="height:auto;"></div>
                    </center> --}}
                    {{-- </div>
                    </div> --}}

                </div>

            </div>

        </div>
    </div>
</div>




{{-- Hostel Occupancy --}}
<!-- Edit modal content -->
<div id="ssw" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Hostel Occupancy</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            </div>



            <div class="modal-body">
                <div class="container">
                    <!-- [ Data table ] start -->
                    <div class="table-responsive card material-table">
                        <table id="export-table4" class="display table nowrap table-striped table-hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Hostel Name</th>
                                    <th>Total Students</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($hostel_data as $hostel)    
                                
                                @php
                                    $hostel_d = App\Models\Hostel::find($hostel->hostel_id);
                                @endphp

                                    <tr>
                                        <td>{{ $hostel_d->name }}</td>
                                        <td>{{ $hostel->count }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- [ Data table ] end -->

                    {{-- <div class="row" style="padding:10px;">
                    <div class="col-md-12"> --}}
                    {{-- <center>
                        <div id="attendence1_barchart_material" style="height:auto;"></div>
                    </center> --}}
                    {{-- </div>
                    </div> --}}

                </div>

            </div>

        </div>
    </div>
</div>


<script>

    
