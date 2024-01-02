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
                        <h5>{{ 'Fee Payment Tracking' }} {{ __('list') }}</h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            {{-- <div class=""> --}}
                <div class="d-flex justify-content-center">
                    <div class="rounded border border-2 bg-light shadow-sm px-3">
                        <div class="ms-2">
                            <p class="mt-1 mb-0 text-dark">Fee Collection & O/S</p>
                        </div>
                        <div class="ms-2">
                            <span class="mb-1 fs-5 fw-700 text-dark">25Lac/70Lac</span>
                        </div>
                    </div>
                </div>
            {{-- </div> --}}
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