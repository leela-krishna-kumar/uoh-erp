{{-- Attendence Modal --}}
<div id="attendence" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Monthly Attendence Report</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">

                <div class="container">


                    <div class="card">

                        <div class="card-header">
                            <p>
    
                            Casual Leave: <span class="text-danger">cl</span></span>
                            | Earned Leave: <span class="text-danger">el</span></span>
                            | Academic Leave: <span class="text-danger">al</span></span>
                            | Half Pay Leave: <span class="text-danger">hpl</span></span>
                            | Vacation: <span class="text-danger">v</span></span>
                            | Compensatory Casual Leave: <span class="text-danger">ccl</span></span>                        
                            | General: <span class="text-danger">g</span></span>
                            | SCL: <span class="text-danger">scl</span></span>
                            | Maternity Leave: <span class="text-danger">el</span></span>
                            </p>
                        </div>

                    </div>

                    {{-- <h5>BTech</h5> --}}
                    <!-- [ Data table ] start -->
                    <div class="table-responsive">
                        <table id="export-table1" class="display table nowrap table-striped table-hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Month</th>
                                    <th>Total Present</th>
                                    <th>Total Absent</th>
                                    <th>Type of leaves</th>
                                    <th>Action</th>
                                    {{-- @foreach ($courses as $course)
                                        <th>{{ $course }}</th>
                                    @endforeach --}}
                                </tr>
                            </thead>
                            <tbody>

                                @php
                                    $months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
                                    $lv = ['cl', 'el', 'al', 'hpl', 'v', 'ccl', 'g', 'scl', 'ml' ];
                                    $i=1;
                                @endphp

                                @foreach ($months as $month)

                                @php
                                    $p = rand(24,26);
                                    $a = 26 - $p;
                                @endphp

                                <tr>
                                    <td>{{ $i }}</td>
                                    <td>{{ $month }}</td>
                                    <td>{{ $p }}</td>                                   
                                    <td>{{ $a }}</td>
                                    <td>@if ($a > 0) {{ $lv[rand(0,7)] }} - {{$a}} @else - @endif  </td>     
                                    <td><a target="_blank" type="button" href="{{ url('admin/staff-daily-report?shift=1&month=' . $i++  .'&year=2024') }}" class="btn btn-success btn-sm">View</a> </td>                                                              
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