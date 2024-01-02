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
                                        <th>{{ __('DB Table Name') }}</th>
                                        <th>{{ __('btn_import') }}</th>
                                        <th>{{ __('btn_export') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <!-- <td>{{ trans_choice('module_staff', 2) }}</td> -->
                                        <td>Staff</td>
                                        <td>
                                            <form class="needs-validation" novalidate action="{{ route('admin.bulk.import', ['table' => 'users']) }}" method="post" enctype="multipart/form-data">
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
                                            <a href="{{ route('admin.bulk.export', ['table' => 'users']) }}" class="btn btn-info"><i class="fas fa-download"></i> {{ __('btn_export') }}</a>
                                        </td>
                                    </tr>

                                    

                                    <tr>
                                        <td>{{ trans_choice('module_application', 2) }}</td>
                                        <td>
                                        <form class="needs-validation" novalidate action="{{ route('admin.bulk.import', ['table' => 'applications']) }}" method="post" enctype="multipart/form-data">
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
                                            <a href="{{ route('admin.bulk.export', ['table' => 'applications']) }}" class="btn btn-info"><i class="fas fa-download"></i> {{ __('btn_export') }}</a>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>{{ trans_choice('module_subject', 2) }}</td>
                                        <td>
                                        <form class="needs-validation" novalidate action="{{ route('admin.bulk.import', ['table' => 'subjects']) }}" method="post" enctype="multipart/form-data">
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
                                            <a href="{{ route('admin.bulk.export', ['table' => 'subjects']) }}" class="btn btn-info"><i class="fas fa-download"></i> {{ __('btn_export') }}</a>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>{{ trans_choice('module_book', 2) }}</td>
                                        <td>
                                        <form class="needs-validation" novalidate action="{{ route('admin.bulk.import', ['table' => 'books']) }}" method="post" enctype="multipart/form-data">
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
                                            <a href="{{ route('admin.bulk.export', ['table' => 'books']) }}" class="btn btn-info"><i class="fas fa-download"></i> {{ __('btn_export') }}</a>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>{{ trans_choice('module_faculty', 2) }}</td>
                                        <td>
                                        <form class="needs-validation" novalidate action="{{ route('admin.bulk.import', ['table' => 'faculties']) }}" method="post" enctype="multipart/form-data">
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
                                            <a href="{{ route('admin.bulk.export', ['table' => 'faculties']) }}" class="btn btn-info"><i class="fas fa-download"></i> {{ __('btn_export') }}</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>{{ trans_choice('module_program', 2) }}</td>
                                        <td>
                                        <form class="needs-validation" novalidate action="{{ route('admin.bulk.import', ['table' => 'programs']) }}" method="post" enctype="multipart/form-data">
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
                                            <a href="{{ route('admin.bulk.export', ['table' => 'programs']) }}" class="btn btn-info"><i class="fas fa-download"></i> {{ __('btn_export') }}</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>{{ trans_choice('module_chapter', 2) }}</td>
                                        <td>
                                        <form class="needs-validation" novalidate action="{{ route('admin.bulk.import', ['table' => 'chapters']) }}" method="post" enctype="multipart/form-data">
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
                                            <a href="{{ route('admin.bulk.export', ['table' => 'chapters']) }}" class="btn btn-info"><i class="fas fa-download"></i> {{ __('btn_export') }}</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>{{ trans_choice('module_topic', 2) }}</td>
                                        <td>
                                        <form class="needs-validation" novalidate action="{{ route('admin.bulk.import', ['table' => 'topics']) }}" method="post" enctype="multipart/form-data">
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
                                            <a href="{{ route('admin.bulk.export', ['table' => 'topics']) }}" class="btn btn-info"><i class="fas fa-download"></i> {{ __('btn_export') }}</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>{{ trans_choice('module_designation', 2) }}</td>
                                        <td>
                                        <form class="needs-validation" novalidate action="{{ route('admin.bulk.import', ['table' => 'designations']) }}" method="post" enctype="multipart/form-data">
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
                                            <a href="{{ route('admin.bulk.export', ['table' => 'designations']) }}" class="btn btn-info"><i class="fas fa-download"></i> {{ __('btn_export') }}</a>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>{{ trans_choice('module_class_room', 2) }}</td>
                                        <td>
                                        <form class="needs-validation" novalidate action="{{ route('admin.bulk.import', ['table' => 'class_rooms']) }}" method="post" enctype="multipart/form-data">
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
                                            <a href="{{ route('admin.bulk.export', ['table' => 'class_rooms']) }}" class="btn btn-info"><i class="fas fa-download"></i> {{ __('btn_export') }}</a>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>{{ trans_choice('module_student', 2) }}</td>
                                        <td>
                                        <form class="needs-validation" novalidate action="{{ route('admin.bulk.import', ['table' => 'students']) }}" method="post" enctype="multipart/form-data">
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
                                            <a href="{{ route('admin.bulk.export', ['table' => 'students']) }}" class="btn btn-info"><i class="fas fa-download"></i> {{ __('btn_export') }}</a>
                                        </td>
                                    </tr> 
                                    <tr>
                                        <td>{{ trans_choice('module_subject_adddrop', 2) }}</td>
                                        <td>
                                            <form class="needs-validation" novalidate action="{{ route('admin.bulk.import', ['table' => 'student_enroll_subject']) }}" method="post" enctype="multipart/form-data">
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
                                            <a href="{{ route('admin.bulk.export', ['table' => 'student_enroll_subject']) }}" class="btn btn-info"><i class="fas fa-download"></i> {{ __('btn_export') }}</a>
                                        </td>
                                    </tr> 
                                    <tr>
                                        <td>{{ trans_choice('module_project', 2) }}</td>
                                        <td>
                                            <form class="needs-validation" novalidate action="{{ route('admin.bulk.import', ['table' => 'projects']) }}" method="post" enctype="multipart/form-data">
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
                                            <a href="{{ route('admin.bulk.export', ['table' => 'projects']) }}" class="btn btn-info"><i class="fas fa-download"></i> {{ __('btn_export') }}</a>
                                        </td>
                                    </tr> 
                                    <tr>
                                        <td>{{ trans_choice('module_ecourses', 2) }}</td>
                                        <td>
                                            <form class="needs-validation" novalidate action="{{ route('admin.bulk.import', ['table' => 'e_courses']) }}" method="post" enctype="multipart/form-data">
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
                                            <a href="{{ route('admin.bulk.export', ['table' => 'e_courses']) }}" class="btn btn-info"><i class="fas fa-download"></i> {{ __('btn_export') }}</a>
                                        </td>
                                    </tr> 
                                    <tr>
                                        <td>{{ trans_choice('module_elesson', 2) }}</td>
                                        <td>
                                            <form class="needs-validation" novalidate action="{{ route('admin.bulk.import', ['table' => 'e_lessons']) }}" method="post" enctype="multipart/form-data">
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
                                            <a href="{{ route('admin.bulk.export', ['table' => 'e_lessons']) }}" class="btn btn-info"><i class="fas fa-download"></i> {{ __('btn_export') }}</a>
                                        </td>
                                    </tr> 
                                    <tr>
                                        <td>{{ trans_choice('module_esection', 2) }}</td>
                                        <td>
                                            <form class="needs-validation" novalidate action="{{ route('admin.bulk.import', ['table' => 'e_sections']) }}" method="post" enctype="multipart/form-data">
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
                                            <a href="{{ route('admin.bulk.export', ['table' => 'e_sections']) }}" class="btn btn-info"><i class="fas fa-download"></i> {{ __('btn_export') }}</a>
                                        </td>
                                    </tr> 
                                    <tr>
                                        <td>{{ trans_choice('module_question_bank', 2) }}</td>
                                        <td>
                                            <form class="needs-validation" novalidate action="{{ route('admin.bulk.import', ['table' => 'question_banks']) }}" method="post" enctype="multipart/form-data">
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
                                            <a href="{{ route('admin.bulk.export', ['table' => 'question_banks']) }}" class="btn btn-info"><i class="fas fa-download"></i> {{ __('btn_export') }}</a>
                                        </td>
                                    </tr> 
                                    <tr>
                                        <td>{{ trans_choice('module_test_paper', 2) }}</td>
                                        <td>
                                            <form class="needs-validation" novalidate action="{{ route('admin.bulk.import', ['table' => 'test_papers']) }}" method="post" enctype="multipart/form-data">
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
                                            <a href="{{ route('admin.bulk.export', ['table' => 'test_papers']) }}" class="btn btn-info"><i class="fas fa-download"></i> {{ __('btn_export') }}</a>
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