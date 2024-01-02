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
                        <h5>{{ 'Receipts and Invoices' }} {{ __('list') }}</h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3 col-sm-12">
                <div class="px-5">
                    <div class="rounded border border-2 bg-light shadow-sm">
                        <div class="ms-3">
                            <p class="mt-1 mb-0 text-dark">Total Number of Receipts</p>
                        </div>
                        <div class="ms-3">
                        <span class="mb-1 fs-5 fw-700 text-dark">6000</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-12">
                <div class="px-5">
                    <div class="rounded border border-2 bg-light shadow-sm">
                        <div class="ms-3">
                            <p class="mt-1 mb-0 text-dark">Total Number of Invoices</p>
                        </div>
                        <div class="ms-3">
                        <span class="mb-1 fs-5 fw-700 text-dark">8000</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-12">
                <div class="px-5">
                    <div class="rounded border border-2 bg-light shadow-sm">
                        <div class="ms-3">
                            <p class="mt-1 mb-0 text-dark">Total Revenue</p>
                        </div>
                        <div class="ms-3 mb-3">
                            <span class="mb-1 fs-5 fw-700 text-dark">35,00,000/-</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-12">
                <div class="px-5">
                    <div class="rounded border border-2 bg-light shadow-sm">
                        <div class="ms-3">
                            <p class="mt-1 mb-0 text-dark">Total Outstanding Payments</p>
                        </div>
                        <div class="ms-3">
                            <span class="mb-1 fs-5 fw-700 text-dark">100</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="d-flex justify-content-center">
                <div class="border bg-white px-5 py-5">
                    <p class="py-5">Comming Char Here.......................................</p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Content-->

@endsection