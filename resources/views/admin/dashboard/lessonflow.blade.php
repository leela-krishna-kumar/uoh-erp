{{-- Attendence Modal --}}
<div id="lessonflow" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Lesson Plan</h5>
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
                                    <th>Program</th>
                                    <th>Year & Semester</th>
                                    <th>Subject</th>
                                    <th>Completion Status</th>
                                    <th>Action</th>
                                    {{-- @foreach ($courses as $course)
                                        <th>{{ $course }}</th>
                                    @endforeach --}}
                                </tr>
                            </thead>
                            <tbody>

                                @php
                                    $months = ['Programming', 'Compiler Design', 'Computer Networks'];
                                    $lv = ['cl', 'el', 'al', 'hpl', 'v', 'ccl', 'g', 'scl', 'ml' ];
                                    $i=1;
                                @endphp

                                @foreach ($months as $month)

                                @php
                                    $p = rand(75,95);
                                @endphp

                                <tr>
                                    <td>CSE</td>
                                    <td>{{ $i++ }}-2</td>
                                    <td>{{ $month }}</td>
                                    <td>{{ $p }}%</td>                                  
                                    <td><a target="_blank" type="button" href="{{ url('admin/chapter') }}" class="btn btn-success btn-sm">View</a> </td>                                                              
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