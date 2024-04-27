
@php
    $courses = ['ECE', 'EEE', 'CSE', 'IT', 'Mech', 'Civil'];
@endphp

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
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($hostel_data as $hostel)    
                                
                                @php
                                    $hostel_d = App\Models\Hostel::find($hostel->hostel_id);
                                @endphp

                                    <tr>
                                        <td>{{ $hostel_d->name ?? '--' }}</td>
                                        <td>{{ $hostel->count }}</td>
                                        <td><a target="_blank" type="button" href="{{ url('admin/hostel-student?hostel=' . $hostel->hostel_id. '&faculty=&program=&session=&semester=&section=') }}" class="btn btn-success btn-sm">View</a> </td>                                                              
                                                                                    
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

