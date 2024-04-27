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
                    
                    </div>
                    <div class="card-block">
                        <a href="{{ route('admin.placed-student.student-list') }}" class="btn btn-info"><i class="fas fa-sync-alt"></i> {{ __('btn_refresh') }}</a>

                        <form class="needs-validation mt-3" novalidate method="get" action="{{ route('admin.placed-student.student-list') }}">
                            <div class="row gx-2">
                                <div class="form-group col-md-3">
                                    <div class="form-group">
                                      <div class="switch d-inline m-r-10">
                                          <label for="from_date">From Date </label>
                                          <input type="date"class="form-control" id="from_date" name="from_date" value="{{$selected_from_date}}" >
                                          <label for="date" class="cr"></label>
                                      </div>
                                  </div>
                                </div>
                                <div class="form-group col-md-3">
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
                    <div class="card-header d-flex justify-content-between">
                        <h5> {{ $title }} List</h5>
                    </div>
                    <div class="card-block">
                        <!-- [ Data table ] start -->
                        <div class="table-responsive">
                            <table id="basic-table" class="display table nowrap table-striped table-hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>S.No.</th>
                                        <th>{{__('ID')}}</th>
                                        <th>{{ __('Student Name') }}</th>
                                        <th>Company Name</th>
                                        <th>{{ __('Status') }}</th>
                                        <th>{{ __('Package') }}</th>
                                        <th>{{ __('Note') }}</th>
                                        {{-- <th>{{__('Action')}}</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                  @foreach( $rows as $key => $row )
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $row->getPrefix('id')}}</td>
                                        <td>{{ @$row->student->name }}</td>
                                        <td>
                                            @php
                                            $company = App\Models\Company::find($row->company_id);
                                            @endphp
                                            {{ $company->name ?? '' }}
                                        </td>
                                        
                                        <td>
                                            {{-- {{$row->status}} --}}
                                            <span class="badge badge-{{ App\Models\PlacedStudent::STATUSES[$row->status]['color'] }}">{{ App\Models\PlacedStudent::STATUSES[$row->status]['label'] }}</span>
                                        </td>
                                        {{-- <td>{{$row->package}} LPA</td> --}}
                                        <td>
                                            @if($row->package != 0)
                                                {{$row->package}} LPA
                                            @endif
                                        </td>
                                        <td>{{$row->note}}</td>

                                        {{-- <td>
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
                                        </td> --}}
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
