@php
    $courses = ['ECE', 'EEE', 'CSE', 'IT', 'Mech', 'Civil'];
@endphp


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
                                    <th>#</th>
                                    <th>RANK RANGE</th>
                                    <th>Total Students</th>

                                    {{-- @foreach ($courses as $course)
                                        <th>{{ $course }}</th>
                                    @endforeach --}}
                                </tr>
                            </thead>
                            <tbody>
                                
                                @foreach($eamcet as $key => $e)

                              @php
                                //  dd($e);
                              @endphp  

                                <tr>
                                    <td>{{  $key+1 }}</td> 
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
