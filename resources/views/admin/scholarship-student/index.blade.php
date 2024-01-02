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
                        <h5>{{$scholarship->title}} {{ $title }} </h5>
                    </div>
                    <div class="card-block">
                        @can($access.'-create')
                        <a href="{{ route($route.'.create',['scholarship_id'=>request()->get('scholarship_id')]) }}" class="btn btn-primary"><i class="fas fa-plus"></i> {{ __('btn_add_new') }}</a>
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
                                        <th>{{ __('Student Name') }}</th>
                                        <th>
                                            {{ __('field_program') }}
                                            <div class="hr-1"></div>
                                            {{ __('field_session') }}
                                        </th>
                                        <th>
                                            {{ __('field_semester') }}
                                            <div class="hr-1"></div>
                                            {{ __('field_section') }}
                                        </th>
                                        <th>{{ __('Phone') }}</th>
                                        <th>{{ __('Amount') }}</th>
                                        <th>{{ __('Status') }}</th>
                                        <th>{{ __('Date') }}</th>
                                       
                                        <th>{{ __('Action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  @foreach($rows as $key => $row)
                                  @php
                                    $enroll = \App\Models\Student::enroll($row->student->id);
                                  @endphp
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        {{-- <td>{{$row->full_name}}</td> --}}
                                        <td>{{@$row->student->first_name.' '.@$row->student->last_name}}</td>
                                        <td>
                                            {{ @$row->student->program->shortcode ?? '--' }}
                                                <div class="hr-1"></div>
                                            {{ $enroll->session->title ?? '--' }}
                                        </td>
                                        <td>
                                            {{ $enroll->semester->title ?? '--' }}
                                                <div class="hr-1"></div>
                                            {{ $enroll->section->title ?? '--' }}
                                        </td>
                                        <td>{{@$row->student->phone}}</td>
                                        <td>
                                            @if(isset($setting->decimal_place))
                                            {{ number_format((float)$row->amount, $setting->decimal_place, '.', '') }} 
                                            @else
                                            {{ number_format((float)$row->amount, 2, '.', '') }} 
                                            @endif 
                                            {!! $setting->currency_symbol !!}
                                        </td>

                                       <td>
                                            <span class="badge badge-{{ App\Models\ScholarshipStudent::STATUSES[$row->status]['color'] }}">{{ App\Models\ScholarshipStudent::STATUSES[$row->status]['label'] }}</span>
                                        </td>

                                        <td>{{$row->date}}</td>
                                       
                                        <td>
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