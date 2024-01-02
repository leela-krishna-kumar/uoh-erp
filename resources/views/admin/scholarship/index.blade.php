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
                        <h5>{{ $title }} </h5>
                    </div>
                    <div class="card-block">
                        @can($access.'-create')
                        <a href="{{ route($route.'.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> {{ __('btn_add_new') }}</a>
                        @endcan

                        <a href="{{ route($route.'.index') }}" class="btn btn-info"><i class="fas fa-sync-alt"></i> {{ __('btn_refresh') }}</a>
                    </div>
                </div>
            </div>

            <div class="col-sm-12">
                <div class="card">
                    <div class="card-block">
                        <!-- [ Data table ] start -->
                        <div class="table-responsive">
                            <table id="basic-table" class="display table nowrap table-striped table-hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ __(' Title') }}</th>
                                        <th>{{ __('Scholarship Provider') }}</th>
                                        <th>{{ __('Received Amount') }}</th>
                                        <th>
                                            {{ __('From Date') }}
                                            <div class="hr-1"></div>
                                            {{ __('To Date') }}
                                        </th>
                                        <th>{{ __('Disbursed Amount') }}</th>
                                        <th>{{ __('Balanced Amount') }}</th>
                                        <th>{{ __('Status') }}</th>
                                        <th>{{ __('Beneficiaries') }}</th>
                                        <th>{{ __('Action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  @foreach($rows as $key => $row)
                                    @php
                                        $balancedAmount = $row->received_amount-$row->students->sum('amount');
                                        if ($balancedAmount < 0) {
                                            $status = \App\Models\Scholarship::STATUS_OVER_QUOTA;
                                        } elseif ($row->students->sum('amount') == 0) {
                                            $status = \App\Models\Scholarship::STATUS_NO_QUOTA;
                                        } else{
                                            $status = \App\Models\Scholarship::STATUS_HAVE_QUOTA;
                                        }
                                    @endphp
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $row->title }}</td>
                                        <td>{{ $row->donors ? $row->donors->donor_name : '-' }}</td>
                                        
                                        <td>
                                            @if(isset($setting->decimal_place))
                                            {{ number_format((float)$row->received_amount, $setting->decimal_place, '.', '') }} 
                                            @else
                                            {{ number_format((float)$row->received_amount, 2, '.', '') }} 
                                            @endif 
                                            {!! $setting->currency_symbol !!}
                                        </td>

                                        {{-- <td>{{ $row->received_amount }}</td> --}}
                                        <td>
                                            {{ $row->from_date }}
                                            <div class="hr-1"></div>
                                            {{ $row->to_date }}
                                        </td>
                                        <td>
                                            @if(isset($setting->decimal_place))
                                            {{ number_format((float)$row->students->sum('amount'), $setting->decimal_place, '.', '') }} 
                                            @else
                                            {{ number_format((float)$row->students->sum('amount'), 2, '.', '') }} 
                                            @endif 
                                            {!! $setting->currency_symbol !!}
                                        </td>
                                        
                                        <td>
                                            <div class="@if($balancedAmount < 0) text-danger @endif">
                                                @if(isset($setting->decimal_place))
                                                    {{ number_format((float)abs($balancedAmount), $setting->decimal_place, '.', '') }} 
                                                @else
                                                    {{ number_format((float)abs($balancedAmount), 2, '.', '') }} 
                                                @endif 
                                                {!! $setting->currency_symbol !!}
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge badge-{{ \App\Models\Scholarship::STATUSES[$status]['color'] }}">
                                                {{ \App\Models\Scholarship::STATUSES[$status]['label'] }}
                                            </span>
                                        </td>
                                        <td class="text-center">{{ $row->students->count() }}</td>
                                        <td>
                                            <a href="{{ route('admin.scholarship-student.index',['scholarship_id'=> $row->id]) }}" class="btn btn-icon btn-success btn-sm">
                                                <i class="fas fa-users"></i>
                                            </a>

                                            @can($access.'-edit')
                                            <a href="{{ route($route.'.edit', $row->id) }}" class="btn btn-icon btn-primary btn-sm">
                                                <i class="far fa-edit"></i>
                                            </a>
                                            @endcan
                                            
                                            @can($access.'-delete')
                                            <button type="button" class="btn btn-icon btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal-{{ $row->id }}">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                            <!-- Include Delete modal -->
                                            @include('admin.layouts.inc.delete')
                                            @endcan
                                        </td>
                                    </tr>
                                  @endforeach
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