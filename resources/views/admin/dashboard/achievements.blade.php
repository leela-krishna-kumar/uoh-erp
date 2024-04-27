{{-- Attendence Modal --}}
<div id="achievements" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Academic Achievements Report</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">

                <div class="container">

                    {{-- <h5>BTech</h5> --}}
                    <!-- [ Data table ] start -->
                    <div class="table-responsive">
                        <table id="export-table2" class="display table nowrap table-striped table-hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Achievement Type</th>
                                    <th>Count</th>
                                   
                                    <th>Action</th>
                                    
                                </tr>
                            </thead>
                            <tbody>

                                @php
                                    $achieves = ['Books Published', 'Journals', 'Seed Grants', 'Funded Research', 'Patent', 'Awards', 'Workshops Attended'];
                                    $lv = ['cl', 'el', 'al', 'hpl', 'v', 'ccl', 'g', 'scl', 'ml' ];
                                    $i=1;
                                @endphp

                                @foreach ($achieves as $achieve)

                                @php
                                    $p = rand(10,80);
                                    // $a = 26 - $p;
                                @endphp

                                <tr>
                                    <td>{{ $achieve }}</td>
                                    <td>{{ $p }}</td>                                 
                                    <td><a target="_blank" type="button" href="{{ url('admin/faculty-achievements/' . strtolower(str_replace(' ', '-', $achieve))) }}" class="btn btn-success btn-sm">View</a> </td>                                                              
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