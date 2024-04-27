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
                                        <th>{{ __('Staff Id') }}</th>
                                        <th>{{ __('Driver Name') }}</th>
                                        <th>Driver Phone</th>
                                        <th>Driver Email</th>
                                        <th>Adhar Card Number</th>
                                        <th>Adhar Card Image</th>
                                        <th>Driving License Number</th>
                                        <th>Driving License Image</th>
                                    </tr>
                                </thead>
                                <tbody>
                                
                                    @foreach($rows as $key => $row)
                                      <tr>
                                          <td>{{ $key + 1 }}</td>
                                          <td>{{ $row->staff_id }}</td>
                                          <td>{{ $row->first_name . ' ' . $row->last_name }}</td>
                                          <td>{{ $row->phone }}</td>
                                          <td>{{ $row->email }}</td>
                                          <td>{{ $row->aadhar }}</td>
                                          <td>
                                            <?php if($row->aadhar_image != null && $row->aadhar_image != ''): ?>
                                                <button type="button" class="btn btn-icon btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#driverAdharImage-{{ @$row->id }}">
                                                    <i class="fas fa-eye"></i>
                                                </button>

                                                @include('admin.fleets.image')
                                            <?php endif; ?>
                                          </td>
                                          <td>{{ $row->driving_license_number }}</td>
                                          <td>
                                            <?php if($row->driving_license_pic != null && $row->driving_license_pic != ''): ?>
                                                <button type="button" class="btn btn-icon btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#drivingLicenseImage-{{ @$row->id }}">
                                                    <i class="fas fa-eye"></i>
                                                </button>

                                                @include('admin.fleets.image')
                                            <?php endif; ?>
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