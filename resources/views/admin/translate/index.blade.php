@extends('admin.layouts.master')
@section('title', $title)
@section('page_css')
<style>
    #pieChart{
        max-width: 100% !important;
        max-height: 500px !important;
    }
</style>
@endsection

@section('content')
@php 
    $from_date = now()->subDay(1)->format('Y-m-d');
    $to_date = now()->format('Y-m-d');
@endphp
<!-- Start Content-->
<div class="main-body">
    <div class="page-wrapper">
        <!-- [ Main Content ] start -->
        <div class="row">
            <!-- [ Data table ] start -->
            <div class="col-sm-12">
                <div class="card">
                    @can($access.'-create')
                    <div class="card-header">
                        <form class="needs-validation" novalidate method="POST" action="{{ route('admin.translations.create') }}">
                            @csrf
                            <div class="row">
                                <div class="form-group col">
                                    <a href="{{ route($route.'.index') }}" class="btn btn-info"><i class="fas fa-sync-alt"></i> {{ __('btn_refresh') }}</a>
                                </div>
                                <div class="form-group col">
                                    <input type="text" name="key" class="form-control" placeholder="{{ __('field_key') }}..." required>

                                    <div class="invalid-feedback">
                                        {{ __('required_field') }} {{ __('field_key') }}
                                    </div>
                                </div>
                                <div class="form-group col">
                                    <input type="text" name="value" class="form-control" placeholder="{{ __('field_value') }}..." required>

                                    <div class="invalid-feedback">
                                        {{ __('required_field') }} {{ __('field_value') }}
                                    </div>

                                </div>
                                <div class="form-group col">
                                    <button type="submit" class="btn btn-success"><i class="fas fa-plus"></i> {{ __('btn_add_new') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    @endcan
                    <div class="card-block">
                        <div class="table-responsive">
                            <table id="basic-table" class="display table nowrap table-striped table-hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>{{ __('field_key') }}</th>

                                        @if($languages->count() > 0)
                                            @foreach($languages as $language)
                                                <th>{{ $language->name }}({{ $language->code }})</th>
                                            @endforeach
                                        @endif

                                        @can($access.'-delete')
                                        <th>{{ __('field_action') }}</th>
                                        @endcan
                                    </tr>
                                </thead>
                                <tbody>

                                    @if($columnsCount > 0)
                                    @foreach($columns[0] as $columnKey => $columnValue)
                                        <tr>
                                            <td><a href="#" class="translate-key" data-title="Enter Key" data-type="text" data-pk="{{ $columnKey }}" data-url="{{ route('admin.translation.update.json.key') }}">{{ $columnKey }}</a></td>

                                            @for($i=1; $i<=$columnsCount; ++$i)

                                            <td><a href="#" data-title="Enter Translate" class="translate" data-code="{{ $columns[$i]['lang'] }}" data-type="textarea" data-pk="{{ $columnKey }}" data-url="{{ route('admin.translation.update.json') }}">{{ isset($columns[$i]['data'][$columnKey]) ? $columns[$i]['data'][$columnKey] : '' }}</a></td>

                                            @endfor

                                            @can($access.'-delete')
                                            <td><button data-action="{{ route('admin.translations.destroy', $columnKey) }}" class="btn btn-icon btn-danger btn-sm remove-key"><i class="fas fa-trash-alt"></i></button></td>
                                            @endcan
                                        </tr>
                                    @endforeach
                                    @endif

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ Data table ] end -->
        </div>
        <!-- [ Main Content ] end -->
    </div>
</div>
<!-- End Content-->

@endsection