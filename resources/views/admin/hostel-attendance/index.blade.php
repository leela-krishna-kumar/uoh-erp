@extends('admin.layouts.master')
@section('title', $title)
@section('content')

<!-- Start Content-->
<div class="main-body">
    <div class="page-wrapper">
        <!-- [ Main Content ] start -->
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>{{ $title }} </h5>
                        {{-- <div class="pt-0 float-right mt-0">
                           <a href="#" class="btn btn-primary pl-0">{{ __('Bulk Attendance') }}</a>
                         </div> --}}
                    </div>
                    {{-- @dd(can($access.'-create')); --}}
                    <div class="card-block d-flex justify-content-between">
                        <div>
                            @can($access.'-create')
                            <a href="{{ route($route.'.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> {{ __('btn_add_new') }}</a>
                            @endcan
                            <a href="{{ route($route.'.index') }}" class="btn btn-info"><i class="fas fa-sync-alt"></i> {{ __('btn_refresh') }}</a>
                        </div>
                        <form action="{{ route($route.'.store') }}" method="post">
                            @csrf
                            <div>
                                <input type="text" name="roll_no" required class="form-control" style="display: inline; width: 200px;">
                                <button type="submit" class="btn btn-primary">{{ __('btn_save') }}</button>
                            </div>
                        </form>
                    </div>

                    <div class="card-block">
                        <form class="needs-validation" novalidate method="get" action="{{ route($route.'.index') }}">
                            <div class="row gx-2">
                                {{-- @include('common.inc.student_search_filter') --}}
                                <div class="form-group col-md-3">
                                    <label for="hostel">Hostel <span>*</span></label>
                                    <select class="form-control hostel" name="hostel" id="hostel" required>
                                      <option value="">{{ __('select') }}</option>
                                      <!-- <option value="all" @if( $selected_hostel == 'all')selected @endif>{{ __('all') }}</option> -->
                                      @if(isset($hostels))
                                      @foreach($hostels->sortBy('id') as $hostel )
                                      <option value="{{ $hostel->id }}" @if( $selected_hostel == $hostel->id) selected @endif>{{ $hostel->name }}</option>
                                      @endforeach
                                      @endif
                                    </select>

                                    <div class="invalid-feedback">
                                      {{ __('required_field') }} Hostel
                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="rooms">Room's</label>
                                    <select class="form-control select2 rooms" name="rooms[]" id="rooms" multiple>
                                      <option value="" >{{ __('select') }}</option>
                                      <!-- <option value="all" @if( $selected_rooms == 'all')selected @endif>{{ __('all') }}</option> -->
                                      @if(isset($rooms))
                                      @foreach($rooms->sortBy('id') as $room )
                                      {{-- <option value="{{ $room->id }}" @if( $selected_rooms == $room->id) selected @endif>{{ $room->name }}</option> --}}
                                      <option value="{{ $room->id }}" @if(in_array($room->id, $selected_rooms)) selected @endif>{{ $room->name }}</option>
                                      @endforeach
                                      @endif
                                    </select>

                                    <div class="invalid-feedback">
                                      {{ __('required_field') }} Rooms
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                      <div class="switch d-inline m-r-10">
                                          <label for="from_date">From Date </label>
                                          <input type="date"class="form-control" id="from_date" name="from_date" value="{{$selected_from_date}}" >
                                          <label for="date" class="cr"></label>
                                      </div>
                                  </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                      <div class="switch d-inline m-r-10">
                                          <label for="to_date">To Date </label>
                                          <input type="date"class="form-control" id="to_date" name="to_date" value="{{$selected_to_date}}" >
                                          <label for="date" class="cr"></label>
                                      </div>
                                  </div>
                                </div>

                                <div class="form-group col-md-3">
                                    <button type="submit" class="btn btn-info btn-filter"><i class="fas fa-search"></i> {{ __('btn_search') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-sm-12">
                <div class="card">
                    <div class="card-block">
                        <!-- [ Data table ] start -->
                        <div class="table-responsive">
                            <table id="basic-table" class="display table nowrap table-striped table-hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Student Name</th>
                                        <th>Student Id</th>
                                        <th>Room </th>
                                        <th>Status</th>
                                        {{-- <th>{{ __('Direction') }}</th> --}}
                                        <th>{{ __('Date') }}</th>
                                        <th>{{ __('Action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  @foreach($rows as $key => $row)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>

                                        {{-- <td>{{ @$row->student->first_name ?? "--" }} {{@$row->student->last_name}}</td> --}}
                                        <td>{{ @$row->student->first_name ?? "--" }} {{@$row->student->last_name}}</td>
                                        <td>
                                             @if($row)
                                            <a href="{{ route('admin.student.show', $row->id) }}">
                                                #{{ $row->student_id ?? '' }}
                                            </a>
                                            @endif
                                        </td>
                                        <td>{{$row->hostel_name}}</td>
                                        <td>
                                            @if($row->status  == 'P')
                                            <span class="badge badge-info" >P</span>
                                            @elseif ($row->status  == 'A')
                                            <span class="badge badge-danger">A</span>
                                            @else
                                             {{ $row->status }}
                                            @endif
                                        </td>

                                        @php
                                        //  $student = Student::where('id',$row->student_id)->first();
                                        $student = App\Models\Student::where('id',$row->student_id)->first();
                                         @endphp
                                         {{-- <td>{{ $student}}</td> --}}
                                        {{-- <td>
                                            @if($row->direction == 1)
                                            <span class="badge badge-info">In</span>
                                            @else
                                            <span class="badge badge-danger">Out</span>
                                            @endif
                                        </td> --}}
                                        {{-- <td>{{ $row->date }}</td> --}}
                                        <td>{{ \Carbon\Carbon::parse($row->date)->format('d-m-Y') }}</td>

                                        <td>

                                            @can($access.'-edit')
                                            <a href="{{ route($route.'.edit', $row->id) }}" class="btn btn-icon btn-primary btn-sm">
                                                <i class="far fa-edit"></i>
                                            </a>
                                            @endcan

                                            @can($access.'-delete')
                                            <button type="button" class="btn btn-icon btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal-{{ $row->id }}">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                            <!-- Include Delete modal -->
                                            @include('admin.layouts.inc.delete')
                                            @endcan
                                        </td>
                                    </tr>
                                  @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- [ Data table ] end -->
                    </div>
                </div>
            </div>
        </div>
        <!-- [ Main Content ] end -->
    </div>
</div>
<!-- End Content-->

@endsection
@section('page_js')
@yield('sub-script')
<script>
     $(".hostel").on('change',function(e){
      e.preventDefault(e);
      var rooms=$(".rooms");
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      $.ajax({
        type:'POST',
        url: "{{ route('filter-rooms') }}",
        data:{
          _token:$('input[name=_token]').val(),
          hostel:$(this).val()
        },
        success:function(response){
            //   console.log("Okk");
            // var jsonData=JSON.parse(response);
            $('option', rooms).remove();
            $('.rooms').append('<option value="">{{ __("Select") }}</option>');
            $.each(response, function(){
              $('<option/>', {
                'value': this.id,
                'text': this.name
              }).appendTo('.rooms');
            });
          }

      });
    });
</script>
@endsection
