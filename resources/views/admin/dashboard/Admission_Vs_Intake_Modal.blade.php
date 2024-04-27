
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
                                    <td>{{ $intake_data->intake_count ?? '--'}} </td>     
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

