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
                            <h5>{{ $title }}</h5>
                        </div>
                        <div class="card-block">
                            <form class="needs-validation" novalidate method="get"
                                action="{{ route('admin.counsellor-report.index') }}">
                                <div class="row gx-2">
                                    <div class="form-group col-md-3">
                                        <label for="teacher">{{ __('field_teacher') }} <span>*</span></label>
                                        <select class="form-control select2" name="teacher" id="teacher" required>
                                            <option value="">{{ __('select') }}</option>
                                            @foreach ($teachers as $teacher)
                                                <option value="{{ $teacher->id }}"
                                                    @if ($selected_staff == $teacher->id) selected @endif>
                                                    {{ $teacher->staff_id }} - {{ $teacher->first_name }}
                                                    {{ $teacher->last_name }}</option>
                                            @endforeach
                                        </select>

                                        <div class="invalid-feedback">
                                            {{ __('required_field') }} {{ __('field_teacher') }}
                                        </div>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <button type="submit" class="btn btn-info btn-filter"><i class="fas fa-search"></i>
                                            {{ __   ('btn_search') }}</button>
                                    </div>
                                    <div class="form-group col-md-6  mt-4 d-flex justify-content-end">
                                        <a href="{{ route('admin.counsellor-report.index') }}" class="btn btn-info"><i
                                                class="fas fa-sync-alt"></i> {{ __('btn_refresh') }}</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                        @if (isset($rows))
                            <div class="card">
                                <div class="card-block">
                                    <!-- [ Data table ] start -->
                                    <div class="table-responsive">
                                        <table id="basic-table" class="display table nowrap table-striped table-hover"
                                            style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Student Name</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                @foreach ($rows as $key => $row)
                                                    <tr>
                                                        <td>{{ $key + 1 }}</td>
                                                        <td>
                                                            {{ @$row->first_name }} {{ @$row->last_name }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- [ Data table ] end -->
                                </div>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
            <!-- [ Main Content ] end -->
        </div>
    </div>
    <!-- End Content-->

@endsection
