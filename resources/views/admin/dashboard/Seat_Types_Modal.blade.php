
@php
    $courses = ['ECE', 'EEE', 'CSE', 'IT', 'Mech', 'Civil'];
@endphp


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
                                    <th>Action</th>   
                             

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
                                        {{-- <td><a target="_blank" type="button" href="{{ url('admin/admission/student?batch=' . $seat_type_id_branch_wise->batch_id. '&program='. $seat_type_id_branch_wise->program_id . '&SeatType='.$seat_type->name. '&status=all') }}" class="btn btn-success btn-sm">View</a> </td>  --}}
                                        <td><a target="_blank" type="button" href="{{ url('admin/admission/student?faculty='.$seat_type_id_branch_wise->faculty_id. '&program='. $seat_type_id_branch_wise->program_id .  '&session=' . $seat_type_id_branch_wise->session_id . '&semester=' . $seat_type_id_branch_wise->semester_id . '&section=all&status=all&seat_type=' .$seat_type->id) }}" class="btn btn-success btn-sm">View</a> </td>    
                                        {{-- <td><a target="_blank" type="button" href="{{ url('admin/admission/student?faculty='.$seat_type_id_branch_wise->batch_id. '&program='. $seat_type_id_branch_wise->program_id .   '&session=all&semester=all&section=all&status=all&seat_type=' .$seat_type->name.) }}" class="btn btn-success btn-sm">View</a> </td>      --}}

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

