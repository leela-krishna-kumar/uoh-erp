@extends('admin.layouts.master')
@section('title','')
@section('content')

<!-- Start Content-->
<div class="main-body">
    <div class="page-wrapper">
        <!-- [ Main Content ] start -->
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>{{ 'Employee & Staff Management' }} {{ __('list') }}</h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 col-sm-12">
                <div class="px-5">
                    <div class="rounded border border-2 bg-light shadow-sm">
                        <div class="ms-3">
                            <p class="mt-1 mb-0 text-dark">Employee Staff Conut</p>
                        </div>
                        <div class="ms-3">
                        <span class="mb-1 fs-5 fw-700 text-dark">80/130</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-sm-12">
                <div class="px-5">
                    <div class="rounded border border-2 bg-light shadow-sm">
                        <div class="ms-3">
                            <p class="mt-1 mb-0 text-dark">Employee Attendance</p>
                        </div>
                        <div class="ms-3">
                        <span class="mb-1 fs-5 fw-700 text-dark">70/80</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-sm-12">
                <div class="px-5">
                    <div class="rounded border border-2 bg-light shadow-sm">
                        <div class="ms-3">
                            <p class="mt-1 mb-0 text-dark">Employee Attendance</p>
                        </div>
                        <div class="ms-3">
                            <span class="mb-1 fs-5 fw-700 text-dark">120/130</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-lg-4 col-sm-12">
                <div class="border bg-white">
                    <div class="px-5 py-5">
                       <p class="px-3 py-3">Chart Comming Here.........</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-sm-12">
                <div class="border bg-white">
                    <div class="px-5 py-5">
                       <p class="px-3 py-3">Chart Comming Here.........</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-sm-12">
                <div class="border bg-white">
                    <div class="px-5 py-5">
                       <p class="px-3 py-3">Chart Comming Here.........</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Content-->

@endsection