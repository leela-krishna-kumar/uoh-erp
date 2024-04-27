@extends('admin.layouts.master')
@section('title', $title)
@section('content')

<!-- Start Content-->
<div class="main-body">
    <div class="page-wrapper">
        <!-- [ Main Content ] start -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5>{{ $title }}</h5>
                    </div>
                    <div class="card-block">
                        <!-- [ Data table ] start -->
                        <div class="table-responsive">
                            <table class="display table nowrap table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Achivements </th>
                                        <th>{{ __('btn_import') }}</th>
                                        <th>{{ __('btn_export') }} Sample File</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <!-- <td>{{ trans_choice('module_staff', 2) }}</td> -->
                                        <td>Number of Books/Book Chapter/Conferences</td>
                                        <td>
                                            <form class="needs-validation" novalidate action="{{ route('admin.faculty-achievements.bulk-import', ['table' => 'staff_book_publishions']) }}" method="post" enctype="multipart/form-data">
                                                @csrf
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <input type="file" name="import" class="form-control" required>
                                                    </div>
                                                    <div class="col-md-6">
                                                    <button type="submit" class="btn btn-success"><i class="fas fa-upload"></i> {{ __('btn_import') }}</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.faculty-achievements.bulk-export', ['table' => 'staff_book_publishions']) }}" class="btn btn-info"><i class="fas fa-download"></i> {{ __('btn_export') }}</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Journals</td>
                                        <td>
                                        <form class="needs-validation" novalidate action="{{ route('admin.faculty-achievements.bulk-import', ['table' => 'journals']) }}" method="post" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">

                                            <div class="col-md-6">
                                            <input type="file" name="import" class="form-control" required>
                                            </div>

                                            <div class="col-md-6">
                                            <button type="submit" class="btn btn-success"><i class="fas fa-upload"></i> {{ __('btn_import') }}</button>
                                            </div>
                                        </div>
                                        </form>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.faculty-achievements.bulk-export', ['table' => 'journals']) }}" class="btn btn-info"><i class="fas fa-download"></i> {{ __('btn_export') }}</a>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>Seed Grant</td>
                                        <td>
                                        <form class="needs-validation" novalidate action="{{ route('admin.faculty-achievements.bulk-import', ['table' => 'seedgrants']) }}" method="post" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">

                                            <div class="col-md-6">
                                            <input type="file" name="import" class="form-control" required>
                                            </div>

                                            <div class="col-md-6">
                                            <button type="submit" class="btn btn-success"><i class="fas fa-upload"></i> {{ __('btn_import') }}</button>
                                            </div>
                                        </div>
                                        </form>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.faculty-achievements.bulk-export', ['table' => 'seedgrants']) }}" class="btn btn-info"><i class="fas fa-download"></i> {{ __('btn_export') }}</a>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>Funded Research & Consultancy Projects</td>
                                        <td>
                                        <form class="needs-validation" novalidate action="{{ route('admin.faculty-achievements.bulk-import', ['table' => 'funded_research']) }}" method="post" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">

                                            <div class="col-md-6">
                                            <input type="file" name="import" class="form-control" required>
                                            </div>

                                            <div class="col-md-6">
                                            <button type="submit" class="btn btn-success"><i class="fas fa-upload"></i> {{ __('btn_import') }}</button>
                                            </div>
                                        </div>
                                        </form>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.faculty-achievements.bulk-export', ['table' => 'funded_research']) }}" class="btn btn-info"><i class="fas fa-download"></i> {{ __('btn_export') }}</a>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>Patents</td>
                                        <td>
                                        <form class="needs-validation" novalidate action="{{ route('admin.faculty-achievements.bulk-import', ['table' => 'patent']) }}" method="post" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">

                                            <div class="col-md-6">
                                            <input type="file" name="import" class="form-control" required>
                                            </div>

                                            <div class="col-md-6">
                                            <button type="submit" class="btn btn-success"><i class="fas fa-upload"></i> {{ __('btn_import') }}</button>
                                            </div>
                                        </div>
                                        </form>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.faculty-achievements.bulk-export', ['table' => 'patent']) }}" class="btn btn-info"><i class="fas fa-download"></i> {{ __('btn_export') }}</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Awards/Recognitions</td>
                                        <td>
                                        <form class="needs-validation" novalidate action="{{ route('admin.faculty-achievements.bulk-import', ['table' => 'awards']) }}" method="post" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">

                                            <div class="col-md-6">
                                            <input type="file" name="import" class="form-control" required>
                                            </div>

                                            <div class="col-md-6">
                                            <button type="submit" class="btn btn-success"><i class="fas fa-upload"></i> {{ __('btn_import') }}</button>
                                            </div>
                                        </div>
                                        </form>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.faculty-achievements.bulk-export', ['table' => 'awards']) }}" class="btn btn-info"><i class="fas fa-download"></i> {{ __('btn_export') }}</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Workshop Attended</td>
                                        <td>
                                        <form class="needs-validation" novalidate action="{{ route('admin.faculty-achievements.bulk-import', ['table' => 'staff_conducted_workshops']) }}" method="post" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">

                                            <div class="col-md-6">
                                            <input type="file" name="import" class="form-control" required>
                                            </div>

                                            <div class="col-md-6">
                                            <button type="submit" class="btn btn-success"><i class="fas fa-upload"></i> {{ __('btn_import') }}</button>
                                            </div>
                                        </div>
                                        </form>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.faculty-achievements.bulk-export', ['table' => 'staff_conducted_workshops']) }}" class="btn btn-info"><i class="fas fa-download"></i> {{ __('btn_export') }}</a>
                                        </td>
                                    </tr>


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
