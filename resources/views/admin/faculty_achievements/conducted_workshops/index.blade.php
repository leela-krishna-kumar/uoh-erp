@extends('admin.layouts.master')
@section('title', $title)
@section('content')

<style>
    td {
    max-width: 200px;
    overflow: hidden;
    white-space: nowrap;
    text-overflow: ellipsis;
  }
</style>

<div class="main-body">
    <div class="page-wrapper">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>{{ $title }} </h5>
                    </div>
                    <div class="card-block">

                        @can($access.'-create')
                        <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#createworkshop-{{ Auth::user()->id }}" type="button" class="btn btn-info"><i class="fas fa-plus"></i> {{ __('btn_add_new') }}</a>
                        @endcan

                        <a href="{{ url('admin/faculty-achievements/workshops-conducted') }}" class="btn btn-info"><i class="fas fa-sync-alt"></i> {{ __('btn_refresh') }}</a>

                        <br /> <br />

                        <form method="GET" action="{{ url('admin/faculty-achievements/workshops-attended') }}">
                            <fieldset class="row">
                                <div class="form-group col-md-2">
                                    <label for="membership_id"> Type</label>
                                    <select class="form-control" name="type" id="title_of_paper">
                                        <option value="" selected>{{ __('Select') }}</option>
                                        <option value="Workshop">Workshop</option>
                                        <option value="FDP">FDP</option>
                                        <option value="PDP">PDP</option>
                                        <option value="Orientation Program">Orientation Program</option>
                                        <option value="Seminar">Seminar</option>
                                        <option value="NPTEL">NPTEL</option>
                                        <option value="Conference">Conference</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="membership_id">From Date</label>
                                    <input type="date" class="form-control date" name="from_date" id="dob">
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="membership_id">To Date</label>
                                    <input type="date" class="form-control date" name="to_date" id="dob">
                                </div>
                                <div class="form-group col-md-2">
                                    <button type="submit" class="btn btn-info btn-filter"><i class="fas fa-search"></i> {{ __('btn_search') }}</button>
                                </div>
                                <div class="form-group col-md-2">
                                </div>
                            </fieldset>
                        </form>


                    </div>

                </div>


            </div>
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-block">
                        <div class="table-responsive">
                            <table id="basic-table" class="display table nowrap table-striped table-hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        @if(auth()->user()->hasRole('Super Admin'))
                                        <th>Teacher Name - Staff Id</th>
                                        {{-- <th>Teacher Staff Id</th> --}}
                                        @endif
                                        {{-- <th>Number of Participants</th> --}}
                                        <th>Workshop Name</th>
                                        {{-- <th>From Date</th>
                                        <th>To Date</th> --}}
                                        <th>Brochure Link</th>
                                        <th>Brochure Attach</th>
                                        <th>Certificate Link</th>
                                        <th>Certificate Attach</th>
                                        <th>Schedule Link</th>
                                        <th>Schedule Attach</th>
                                        <th>Type</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                  @foreach($workshops as $key => $workshop)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        @if(auth()->user()->hasRole('Super Admin'))
                                            @php
                                                $user = App\User::where('staff_id', $workshop->staff_id)->first();
                                                $teacher_name = $user ? $user->first_name . ' ' . $user->last_name : '';
                                            @endphp
                                            <td>{{ $teacher_name }} - {{ $workshop->staff_id }}</td>
                                            {{-- <td>{{ $workshop->staff_id }}</td> --}}
                                        @endif
                                        {{-- <td>{{ @$workshop->no_of_participants }}</td> --}}
                                        <td>{{ @$workshop->workshop_name }}</td>
                                        {{-- <td>{{ @$workshop->from_date }}</td>
                                        <td>{{ @$workshop->to_date }}</td> --}}
                                        <td>
                                            @if($workshop->brochure_link != null && $workshop->brochure_link != '')
                                            <a href="{{ @$workshop->brochure_link }}" target="_blank" class="btn btn-icon btn-primary btn-sm">  <i class="fas fa-eye"></i></a>
                                            @endif
                                        </td>
                                        <td>
                                            @if($workshop->brochure_attach != null && $workshop->brochure_attach != '')
                                            <button type="button" class="btn btn-icon btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#brochureattachdocument-{{ $workshop->id }}"><i class="fas fa-eye"></i></button>
                                            @include('admin.faculty_achievements.conducted_workshops.attach')
                                            @endif
                                        </td>

                                        <td>
                                            @if($workshop->certificate_link != null && $workshop->certificate_link != '')
                                            <a href="{{ @$workshop->certificate_link }}" target="_blank" class="btn btn-icon btn-primary btn-sm">  <i class="fas fa-eye"></i></a>
                                            @endif
                                        </td>
                                        <td>
                                            @if($workshop->certificate_attach != null && $workshop->certificate_attach != '')
                                            <button type="button" class="btn btn-icon btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#certificateattachdocument-{{ $workshop->id }}"><i class="fas fa-eye"></i></button>
                                            @include('admin.faculty_achievements.conducted_workshops.attach')
                                            @endif
                                        </td>

                                        <td>
                                            @if($workshop->schedule_link != null && $workshop->schedule_link != '')
                                            <a href="{{ @$workshop->schedule_link }}" target="_blank" class="btn btn-icon btn-primary btn-sm">  <i class="fas fa-eye"></i></a>
                                            @endif
                                        </td>
                                        <td>
                                            @if($workshop->schedule_attach != null && $workshop->schedule_attach != '')
                                            <button type="button" class="btn btn-icon btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#scheduleattachdocument-{{ $workshop->id }}"><i class="fas fa-eye"></i></button>
                                            @include('admin.faculty_achievements.conducted_workshops.attach')
                                            @endif
                                        </td>

                                        <td>{{ @$workshop->workshop_type }}</td>
                                        <td>

                                            @can($access.'-action')

                                                <button type="button" class="btn btn-icon btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#showworkshop-{{ $workshop->id }}">
                                                    <i class="far fa-eye"></i>
                                                </button>
                                                @include('admin.faculty_achievements.conducted_workshops.show')

                                                @can($access.'-edit')
                                                    @if($workshop->staff_id == auth()->user()->staff_id)
                                                        <button type="button" class="btn btn-icon btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#editworkshop-{{ $workshop->id }}">
                                                            <i class="far fa-edit"></i>
                                                        </button>
                                                        @include('admin.faculty_achievements.conducted_workshops.edit')
                                                    @else
                                                        {{-- @can($access.'-edit')
                                                        <button type="button" class="btn btn-icon btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#editworkshop-{{ $workshop->id }}">
                                                            <i class="far fa-edit"></i>
                                                        </button>
                                                        @include('admin.faculty_achievements.conducted_workshops.edit')
                                                        @endcan --}}
                                                    @endif
                                                @endcan

                                                @can($access.'-delete')
                                                    @if($workshop->staff_id == auth()->user()->staff_id)
                                                        <button type="button" class="btn btn-icon btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteworkshop-{{ $workshop->id }}">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>
                                                        @include('admin.faculty_achievements.conducted_workshops.delete')

                                                    @else
                                                        {{-- @can($access.'-delete')
                                                        <button type="button" class="btn btn-icon btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteworkshop-{{ $workshop->id }}">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>
                                                        @include('admin.faculty_achievements.conducted_workshops.delete')
                                                        @endcan --}}
                                                    @endif
                                                @endcan
                                            @endcan
                                        </td>
                                    </tr>
                                  @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('admin.faculty_achievements.conducted_workshops.create')


@endsection
@section('page_js')
<script>
    $(document).ready(function() {
        var urlParams = new URLSearchParams(window.location.search);
        var workshopType = urlParams.get('type');
        $("select[name='type']").val(workshopType);
        var fromDate = urlParams.get('from_date');
        $("input[name='from_date']").val(fromDate);

        var toDate = urlParams.get('to_date');
        $("input[name='to_date']").val(toDate);
    });
</script>

@yield('sub-script')

@endsection
