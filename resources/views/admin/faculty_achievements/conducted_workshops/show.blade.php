
    <!-- create modal content -->
    <div id="showworkshop-{{ $workshop->id }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form class="needs-validation" novalidate action="{{ url('admin/faculty-achievements/workshops-attended/' . $workshop->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel">{{ Auth::user()->full_name}} workshops-conducted </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                       <div class="row mt-4">
                            <div class="col-5">
                                <b>Workshop Name</b>
                            </div>
                            <div class="col-7">
                                {{ $workshop->workshop_name }}
                            </div>
                       </div>
                       <div class="row mt-4">
                            <div class="col-5">
                                <b>Number Of Participants</b>
                            </div>
                            <div class="col-7">
                                {{ $workshop->no_of_participants }}
                            </div>
                       </div>

                       <div class="row mt-4">
                            <div class="col-5">
                                <b>From Date</b>
                            </div>
                            <div class="col-7">
                                {{ $workshop->from_date }}
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-5">
                                <b>To Date</b>
                            </div>
                            <div class="col-7">
                                {{ $workshop->to_date }}
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-times"></i> {{ __('btn_close') }}</button>
                        {{-- <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> {{ __('btn_save') }}</button> --}}
                    </div>
                </form>
            </div>
        </div>
    </div>
