@extends('admin.layouts.master')
@section('title', $title)
@section('content')

<!-- Start Content-->
<div class="main-body">
    <div class="page-wrapper">
        <!-- [ Main Content ] start -->
        <div class="row">
            <!-- [ Card ] start -->
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>{{ __('modal_add') }} {{ $title }}</h5>
                    </div>
                    <div class="card-block">
                        <a href="{{ route($route.'.index') }}" class="btn btn-primary"><i class="fas fa-arrow-left"></i> {{ __('btn_back') }}</a>

                        <a href="{{ route($route.'.create') }}" class="btn btn-info"><i class="fas fa-sync-alt"></i> {{ __('btn_refresh') }}</a>
                    </div>

                </div>
            </div>
            <form class="needs-validation" novalidate action="{{ route($route.'.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-block">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group col-md-12">
                                            <label for="donor_id">Donor Name<span>*</span></label>
                                            <select class="form-control select2" name="donor_id" id="donor_id" required>
                                                <option value="">{{ __('select') }}</option>
                                                @foreach($donors as $donor)
                                                <option value="{{ $donor->id }}">{{ $donor->donor_name }}</option>
                                                @endforeach
                                            </select>

                                            <div class="invalid-feedback">
                                            {{ __('required_field') }} {{ __('field_donor_id') }}
                                            </div>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="title">Title<span>*</span></label>
                                            <input type="text" class="form-control" name="title" id="title" value="{{ old('title') }}" required>
                                            <div class="invalid-feedback">
                                                {{ __('required_field') }} {{ __('field_title') }}
                                            </div>
                                        </div>

                                        <div class="form-group col-md-12">
                                            <label for="received_amount">Received Amount<span>*</span></label>
                                            <input type="number" class="form-control" name="received_amount" id="received_amount" value="{{ old('received_amount') }}" min="0" required>
        
                                            <div class="invalid-feedback">
                                            {{ __('required_field') }} {{ __('field_received_amount') }}
                                            </div>
                                        </div>
                                        <div class="form-group col-md-12 row">
                                            <div class="form-group col-md-6">
                                                <label for="from_date">From Date<span>*</span></label>
                                                <input type="date" class="form-control" name="from_date" id="from_date" value="{{ old('from_date') }}" required>
            
                                                <div class="invalid-feedback">
                                                {{ __('required_field') }} {{ __('field_from_date') }}
                                                </div>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="to_date">To Date<span>*</span></label>
                                                <input type="date" class="form-control" name="to_date" id="to_date" value="{{ old('to_date') }}" required>
            
                                                <div class="invalid-feedback">
                                                {{ __('required_field') }} {{ __('field_to_date') }}
                                                </div>
                                            </div>
                                          
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group col-md-12">
                                            <label for="note">Note<span>*</span></label>
                                            <textarea type="text" class="form-control" name="note" id="note" rows="12" required>{{ old('note') }}</textarea>
                                            <div class="invalid-feedback">
                                                {{ __('required_field') }} {{ __('field_note') }}
                                            </div>

                                        </div>
                                    </div>
                                </div>
                             </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> {{ __('btn_save') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
             
        
            <!-- [ Card ] end -->
        </div>
        <!-- [ Main Content ] end -->
    </div>
</div>
<!-- End Content-->

@endsection