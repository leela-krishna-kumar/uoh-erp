@extends('admin.layouts.master')
@section('title', $title)
@section('content')

 <div class="row">
            @can($access.'-action')
            <!-- [ Card ] start -->
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5>{{ $title }}</h5>
                    </div>

                   <form class="needs-validation" novalidate action="{{ route($route.'.store') }}" method="post" enctype="multipart/form-data">
                       @csrf
                        <div class="card-block mb-0">
                        <div class="row">
                            <!-- Form Start -->
                                <div class="form-group col-md-6">
                                    <label for="book">{{trans_choice('module_accordion_book',1) }} <span>*</span></label>
                                    <select class="form-control select2" name="book_id" id="book_id" required>
                                        <option value="">{{ __('select') }}</option>
                                        @foreach( $books as $book )
                                        <option value="{{ $book->id }}"> {{ $book->title }}</option>
                                        @endforeach
                                    </select>

                                    <div class="invalid-feedback">
                                    {{ __('required_field') }} {{trans_choice('module_accordion_book',1) }}
                                    </div>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="member">{{trans_choice('module_accordion_department',1) }}</label>
                                    <select class="form-control select2" name="department_id" id="department_id">
                                        <option value="">{{ __('select') }}</option>
                                        @foreach( $depatments as $depatment )
                                        <option value="{{ $depatment->id }}"> {{ $depatment->title }}</option>
                                        @endforeach
                                    </select>

                                    {{-- <div class="invalid-feedback">
                                    {{ __('required_field') }} {{ __('module_accordion_department') }}
                                    </div> --}}
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="member">{{trans_choice('module_accordion_status',1) }}<span>*</span></label>
                                    <select class="form-control select2" name="status" id="status" required>
                                        <option value="">{{ __('select') }}</option>
                                        @foreach( $statuses as $key => $status )
                                        <option value="{{ $key }}"> {{ $status['label'] }}</option>
                                        @endforeach
                                    </select>

                                    <div class="invalid-feedback">
                                    {{ __('required_field') }} {{trans_choice('module_accordion_status',1) }}
                                    </div>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="accordion_no">{{trans_choice('module_accession_no',1) }} <span>*</span></label>
                                    <input type="number" class="form-control" name="accordion_no" id="accordion_no" value="{{old('accordion_no')}}" required>

                                    <div class="invalid-feedback">
                                    {{ __('required_field') }} {{ __('module_accession_no') }}
                                    </div>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="note">{{trans_choice('module_accordion_note',1) }}</label>
                                    <textarea type="text" class="form-control" name="note" id="note" cols="20" rows="5" value="{{old('note')}}"></textarea>
                                    <div class="invalid-feedback">
                                    {{ __('required_field') }} {{ __('module_accordion_note') }}
                                    </div>
                                </div>
                              <!-- Form End -->
                          </div>
                        </div>
                          <div class="card-footer pt-0 float-right mt-0">
                              <button type="submit" class="btn btn-success"><i class="fas fa-plus"></i> {{ __('btn_save') }}</button>
                          </div>
                  </form>
                </div>
            </div>
            <!-- [ Card ] end -->
            @endcan
        </div>

@endsection