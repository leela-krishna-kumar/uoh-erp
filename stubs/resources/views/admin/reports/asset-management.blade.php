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
                        <h5>{{ 'Asset Management' }} {{ __('list') }}</h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3 col-sm-12">
                <div class="px-5">
                    <div class="rounded border border-2 bg-light shadow-sm">
                        <div class="ms-3">
                            <p class="mt-1 mb-0 text-dark">Total No. of Assets</p>
                        </div>
                        <div class="ms-3">
                        <span class="mb-1 fs-5 fw-700 text-dark">1000</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-12">
                <div class="px-5">
                    <div class="rounded border border-2 bg-light shadow-sm">
                        <div class="ms-3">
                            <p class="mt-1 mb-0 text-dark">Total Asset Value</p>
                        </div>
                        <div class="ms-3">
                        <span class="mb-1 fs-5 fw-700 text-dark">25 Lakhs</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-12">
                <div class="px-5">
                    <div class="rounded border border-2 bg-light shadow-sm">
                        <div class="ms-3">
                            <p class="mt-1 mb-0 text-dark">Active Assets</p>
                        </div>
                        <div class="ms-3">
                            <span class="mb-1 fs-5 fw-700 text-dark">900</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-12">
                <div class="px-5">
                    <div class="rounded border border-2 bg-light shadow-sm">
                        <div class="ms-3">
                            <p class="mt-1 mb-0 text-dark">Inactive Assets</p>
                        </div>
                        <div class="ms-3">
                            <span class="mb-1 fs-5 fw-700 text-dark">100</span>
                        </div>
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
    </div>
</div>
<!-- End Content-->

@endsection