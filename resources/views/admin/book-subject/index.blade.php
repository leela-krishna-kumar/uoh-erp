@extends('admin.layouts.master')
@section('title', $title)
@section('content')

<!-- Start Content-->
<div class="main-body">

    <div class="page-wrapper">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Filter By</h5>
                    </div>
                    <div class="card-block">
                        <form class="needs-validation" novalidate method="get" action="{{ route($route.'.index') }}">
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <label for="start_date" class="form-label">Select Start Date <span>*</span></label>
                                    <input type="date" class="form-control date" name="start_date" id="start_date" value="{{ old('start_date') }}" required>
                                </div>
    
                                <div class="form-group col-md-3">
                                    <label for="last_date" class="form-label">Select Last Date <span>*</span></label>
                                    <input type="date" class="form-control date" name="end_date" id="end_date" value="{{ old('end_date') }}" required>
                                </div>
                                <div class="form-group col-md-3">
                                    <button type="submit" class="btn btn-info btn-filter"><i class="fas fa-search"></i> {{ __('btn_filter') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ Main Content ] start -->
        <div class="row">
            @can($access.'-create')
            <div class="col-md-4">
                <form class="needs-validation" novalidate action="{{ route($route.'.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <h5>{{ __('btn_create') }} {{ $title }}</h5>
                            <div>
                                <label for="color" class="form-label">{{ __('field_default') }} </label>
                                <input type="checkbox" name="is_default" id="is_default" checked>
                            </div>
                        </div>
                        <div class="card-block">
                             <!-- Form Start -->                           
                               <div class="col-12"> 
                                      <div class="form-group {{ $errors->has('user_id') ? 'has-error' : ''}}">
                                        <label for="book_id" class="control-label">{{ __('field_book_id') }}<span class="text-danger">*</span> </label>
                                         <select name="book_id" class="form-control select2" id="book_id">
                                            <option value="" readonly>Select Book</option>
                                            @foreach ($books as $book)
                                                <option value="{{ $book->id }}">{{ $book->title }}</option>
                                            @endforeach
                                         </select>
                                           <div class="invalid-feedback">
                                               {{ __('required_field') }} {{ __('field_book_id') }}
                                           </div>
                                     </div>
                                </div>
                                                
                                <div class="form-group">
                                    <label for="Subject" class="form-label">{{ __('field_book_subject') }}</label>
                                    <input type="text" class="form-control" name="subject" id="subject" value="{{ old('subject') }}">

                                    <div class="invalid-feedback">
                                    {{ __('required_field') }} {{ __('field_book_subject') }}
                                    </div>
                                </div>                         
                            
                            <!-- Form End -->
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> {{ __('btn_create') }}</button>
                        </div>
                    </div>
                </form>
            </div>
            @endcan
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5>{{ $title }} {{ __('list') }}</h5>
                    </div>
                    <div class="card-block">
                        <!-- [ Data table ] start -->
                        <div class="table-responsive">
                            <table id="basic-table" class="display table nowrap table-striped table-hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ __('field_book_id') }}</th>
                                        <th>{{ __('field_book_subject') }}</th>
                                        <th>{{ __('Action') }}</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                  @foreach( $rows as $key => $row )
                                  {{-- @php
                                      $rolesIds = json_decode($row['role_id']);
                                  @endphp --}}
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{@$row->book->title ??'--' }}</td>
                                        <td>{{ @$row->subject }}</td>
                                        <td>
                                            {{-- @if($row->is_default == 0)
                                            <a href="{{ route($route.'-user.create',['event_id' =>$row->id]) }}" class="btn btn-icon btn-success btn-sm">
                                                <i class="fas fa-user"></i>
                                            </a>
                                            @endif --}}
                                            @can($access.'-edit')
                                            <button type="button" class="btn btn-icon btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editModal-{{ $row->id }}">
                                                <i class="far fa-edit"></i>
                                            </button>
                                            <!-- Include Edit modal -->
                                            @include($view.'.edit')
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