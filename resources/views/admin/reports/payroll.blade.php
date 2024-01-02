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
                        <h5>{{ 'Payroll' }} {{ __('list') }}</h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-2 col-md-4 col-sm-12">
                <div class="rounded border border-2 bg-light shadow-sm">
                    <div class="ms-2">
                        <p class="mt-1 mb-0 text-dark">Total Gross Pay</p>
                    </div>
                    <div class="ms-2">
                       <span class="mb-1 fs-5 fw-700 text-dark">50 Lakhs</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-4 col-sm-12">
                <div class="rounded border border-2 bg-light shadow-sm">
                    <div class="ms-2">
                        <p class="mt-1 mb-0 text-dark">Total Deductions</p>
                    </div>
                    <div class="ms-2">
                       <span class="mb-1 fs-5 fw-700 text-dark">1.5 Lakhs</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-4 col-sm-12">
                <div class="rounded border border-2 bg-light shadow-sm">
                    <div class="ms-2">
                        <p class="mt-1 mb-0 text-dark">Total Net Pay</p>
                    </div>
                    <div class="ms-2">
                        <span class="mb-1 fs-5 fw-700 text-dark">48.5 Lakhs</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-4 col-sm-12">
                <div class="rounded border border-2 bg-light shadow-sm">
                    <div class="ms-2">
                        <p class="mt-1 mb-0 text-dark">Average Gross Pay</p>
                    </div>
                    <div class="ms-2">
                       <span class="mb-1 fs-5 fw-700 text-dark">0.9 Lakhs</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-4 col-sm-12">
                <div class="rounded border border-2 bg-light shadow-sm">
                    <div class="ms-2">
                        <p class="mt-1 mb-0 text-dark">Total No Emplo. & Staff</p>
                    </div>
                    <div class="ms-2">
                       <span class="mb-1 fs-5 fw-700 text-dark">210</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-4 col-sm-12">
                <div class="rounded border border-2 bg-light shadow-sm">
                    <div class="ms-2">
                        <p class="mt-1 mb-0 text-dark">Average Net Pay</p>
                    </div>
                    <div class="ms-2">
                       <span class="mb-1 fs-5 fw-700 text-dark">0.8 Lakhs</span>
                    </div>
                </div>
            </div> 
        </div>
        <div class="row mt-5">
            <div class="col-lg-6 col-sm-12">
                <div class="border bg-white">
                    <div class="px-5 py-5">
                       <p class="px-3 py-3">Chart Comming Here.........</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-sm-12">
                <div class="border bg-white">
                    <div class="px-5 py-5">
                       <p class="px-3 py-3">Chart Comming Here.........</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="d-flex justify-content-center">
                <div class="border bg-white px-5 py-5">
                    <p class="">Comming Char Here.......................................</p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Content-->

@endsection