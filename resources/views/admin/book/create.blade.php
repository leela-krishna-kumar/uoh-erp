@extends('admin.layouts.master')
@section('title', $title)
@section('content')

<!-- Start Content-->
<div class="main-body">
    <div class="page-wrapper">
        <!-- [ Main Content ] start -->
        <div class="row">
          <form class="needs-validation" novalidate action="{{ route($route.'.store') }}" method="post" enctype="multipart/form-data">
            @csrf
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


                    <div class="card-block">
                        <!-- Form Start -->
                        <fieldset class="row scheduler-border">
                        <div class="form-group col-md-4">
                            <label for="category">{{ __('field_category') }} <span>*</span></label>
                            <select class="form-control" name="category" id="category" required>
                                <option value="">{{ __('select') }}</option>
                                @foreach( $categories as $category )
                                <option value="{{ $category->id }}" @if(old('category') == $category->id) selected @endif>{{ $category->title }}</option>
                                @endforeach
                            </select>

                            <div class="invalid-feedback">
                              {{ __('required_field') }} {{ __('field_category') }}
                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="title">{{ __('field_title') }} <span>*</span></label>
                            <input type="text" class="form-control" name="title" id="title" value="{{ old('title') }}" required>

                            <div class="invalid-feedback">
                              {{ __('required_field') }} {{ __('field_title') }}
                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="isbn">{{ __('field_isbn') }} <span>*</span></label>
                            <input type="text" class="form-control" name="isbn" id="isbn" value="{{ old('isbn') }}" required>

                            <div class="invalid-feedback">
                              {{ __('required_field') }} {{ __('field_isbn') }}
                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="author">{{ __('field_author') }} <span>*</span></label>
                            <input type="text" class="form-control" name="author" id="author" value="{{ old('author') }}" required>

                            <div class="invalid-feedback">
                              {{ __('required_field') }} {{ __('field_author') }}
                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="publisher">{{ __('field_publisher') }}</label>
                            <input type="text" class="form-control" name="publisher" id="publisher" value="{{ old('publisher') }}">

                            <div class="invalid-feedback">
                              {{ __('required_field') }} {{ __('field_publisher') }}
                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="edition">{{ __('field_edition') }}</label>
                            <input type="text" class="form-control" name="edition" id="edition" value="{{ old('edition') }}">

                            <div class="invalid-feedback">
                              {{ __('required_field') }} {{ __('field_edition') }}
                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="publish_year">{{ __('field_publish_year') }}</label>
                            <input type="text" class="form-control" name="publish_year" id="publish_year" value="{{ old('publish_year') }}">

                            <div class="invalid-feedback">
                              {{ __('required_field') }} {{ __('field_publish_year') }}
                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="language">{{ __('field_language') }}</label>
                            <input type="text" class="form-control" name="language" id="language" value="{{ old('language') }}">

                            <div class="invalid-feedback">
                              {{ __('required_field') }} {{ __('field_language') }}
                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="price">{{ __('field_price') }} ({!! $setting->currency_symbol !!})</label>
                            <input type="text" class="form-control autonumber" name="price" id="price" value="{{ old('price') }}">

                            <div class="invalid-feedback">
                              {{ __('required_field') }} {{ __('field_price') }}
                            </div>
                        </div>

                        <div class="form-group col-md-2">
                          <div class="switch d-inline m-r-10">
                              <label>{{ __('eBook') }}</label>
                              <input type="checkbox" id="is_e_book" name="is_e_book" class="book-type"value="1">
                              <label for="is_e_book" class="cr"></label>
                          </div>
                        </div>

                        <div class="form-group col-md-2">
                          <div class="switch d-inline m-r-10">
                            <label>{{ __('Physical Book') }}</label>
                              <input type="checkbox" id="is_physical_book" name="is_physical_book"  value="1">
                              <label for="is_physical_book" class="cr"></label>
                          </div>
                        </div>

                        <div class="form-group col-md-4 d-none show-link">
                          <label for="">{{ __('Link') }} <span>*</span></label>
                          <input type="url" class="form-control autonumber" name="link" id="link" value="" >
                        </div>

                      </div>

                      </fieldset>

                      <fieldset class="row scheduler-border">
                        <legend>{{ __('field_account') }}</legend>


                        <div class="form-group col-md-4">
                            <label for="call_no">{{ __('field_call_no') }}</label>
                            <input type="text" class="form-control" name="call_no" id="call_no" value="{{ old('call_no') }}">

                            <div class="invalid-feedback">
                              {{ __('required_field') }} {{ __('field_call_no') }}
                            </div>
                        </div>

                        {{-- <div class="form-group col-md-4">
                            <label for="from_acc_no">{{ __('field_from_accession_no') }}<span>*</span></label>
                            <input type="number" min="0" max="99" class="form-control" name="from_acc_no" id="from_acc_no" value="{{ old('from_acc_no') }}" required>

                            <div class="invalid-feedback">
                              {{ __('required_field') }} {{ __('field_from_accession_no') }}
                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="to_acc_no">{{ __('field_to_accession_no') }}<span>*</span></label>
                            <input type="number" min="0" max="99" class="form-control" name="to_acc_no" id="to_acc_no" value="{{ old('to_acc_no') }}" required>

                            <div class="invalid-feedback">
                              {{ __('required_field') }} {{ __('field_to_accession_no') }}
                            </div>
                        </div> --}}

                        <div class="form-group col-md-4">
                            <label for="acc_no">{{ __('field_accession_no') }}<span>*</span></label>
                            <input type="number" min="0" max="99" class="form-control" name="acc_no" id="acc_no" value="{{ old('acc_no') }}" required>

                            <div class="invalid-feedback">
                              {{ __('required_field') }} {{ __('field_accession_no') }}
                            </div>
                        </div>


                        <div class="form-group col-md-4">
                            <label for="volume">{{ __('field_volume') }}</label>
                            <input type="text" class="form-control" name="volume" id="volume" value="{{ old('volume') }}">

                            <div class="invalid-feedback">
                              {{ __('required_field') }} {{ __('field_volume') }}
                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="currency">{{ __('field_currency') }}</label>
                            <input type="text" class="form-control" name="currency" id="currency" value="{{ old('currency') }}">

                            <div class="invalid-feedback">
                              {{ __('required_field') }} {{ __('field_currency') }}
                            </div>
                        </div>
                      </fieldset>

                      <fieldset class="row scheduler-border">
                        <legend>{{ __('field_book') }}</legend>

                        <div class="form-group col-md-4">
                            <label for="department">{{ __('field_department') }}</label>
                            <input type="text" class="form-control" name="department" id="department" value="{{ old('department') }}">

                            <div class="invalid-feedback">
                              {{ __('required_field') }} {{ __('field_department') }}
                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="category">{{ __('field_subject') }} <span>*</span></label>
                            <select class="form-control" name="subject_id" id="subject_id" required>
                                <option value="">{{ __('select') }}</option>
                                @foreach( $subjects as $subject )
                                <option value="{{ $subject->id }}" @if(old('category') == $subject->id) selected @endif>{{ $subject->subject }}</option>
                                @endforeach
                            </select>

                            <div class="invalid-feedback">
                              {{ __('required_field') }} {{ __('field_subject') }}
                            </div>
                        </div>

                        {{-- <div class="form-group col-md-4">
                            <label for="subject">{{ __('field_subject') }}</label>
                            <input type="text" class="form-control" name="subject" id="subject" value="{{ old('subject') }}">

                            <div class="invalid-feedback">
                              {{ __('required_field') }} {{ __('field_subject') }}
                            </div>
                        </div> --}}

                        <div class="form-group col-md-4">
                            <label for="course">{{ __('field_course') }}</label>
                            <input type="text" class="form-control" name="course" id="course" value="{{ old('course') }}">

                            <div class="invalid-feedback">
                              {{ __('required_field') }} {{ __('field_course') }}
                            </div>
                        </div>


                        <div class="form-group col-md-4">
                            <label for="book_type">{{ __('field_book_type') }}</label>
                            <input type="text" class="form-control" name="book_type" id="book_type" value="{{ old('book_type') }}">

                            <div class="invalid-feedback">
                              {{ __('required_field') }} {{ __('field_book_type') }}
                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="book_size">{{ __('field_book_size') }}</label>
                            <input type="text" class="form-control" name="book_size" id="book_size" value="{{ old('book_size') }}">

                            <div class="invalid-feedback">
                              {{ __('required_field') }} {{ __('field_book_size') }}
                            </div>
                        </div>

                        <div class="form-group col-md-4">
                          <label for="no_of_pages">{{ __('field_no_of_pages') }}</label>
                          <input type="text" class="form-control" name="no_of_pages" id="no_of_pages" value="{{ old('no_of_pages') }}">

                          <div class="invalid-feedback">
                            {{ __('required_field') }} {{ __('field_no_of_pages') }}
                          </div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="issue_books">{{ __('field_issue_books') }}</label>
                            <input type="text" class="form-control" name="issue_books" id="issue_books" value="{{ old('issue_books') }}">

                            <div class="invalid-feedback">
                              {{ __('required_field') }} {{ __('field_issue_books') }}
                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="ref_books">{{ __('field_ref_books') }}</label>
                            <input type="text" class="form-control" name="ref_books" id="ref_books" value="{{ old('ref_books') }}">

                            <div class="invalid-feedback">
                              {{ __('required_field') }} {{ __('field_ref_books') }}
                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="supplier">{{ __('field_supplier') }}</label>
                            <input type="text" class="form-control" name="supplier" id="supplier" value="{{ old('supplier') }}">

                            <div class="invalid-feedback">
                              {{ __('required_field') }} {{ __('field_supplier') }}
                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="invoice_no">{{ __('field_invoice_no') }}</label>
                            <input type="text" class="form-control" name="invoice_no" id="invoice_no" value="{{ old('invoice_no') }}">

                            <div class="invalid-feedback">
                              {{ __('required_field') }} {{ __('field_invoice_no') }}
                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="invoice_date">{{ __('field_invoice_date') }}</label>
                            <input type="date" class="form-control" name="invoice_date" id="invoice_date" value="{{ old('invoice_date') }}">

                            <div class="invalid-feedback">
                              {{ __('required_field') }} {{ __('field_invoice_date') }}
                            </div>
                        </div>
                      </fieldset>

                      <fieldset class="row scheduler-border">
                        <div class="form-group col-md-4">
                            <label for="enclose_type">{{ __('field_enclose_type') }}</label>
                            <input type="text" class="form-control" name="enclose_type" id="enclose_type" value="{{ old('enclose_type') }}">

                            <div class="invalid-feedback">
                              {{ __('required_field') }} {{ __('field_enclose_type') }}
                            </div>
                        </div>


                        <div class="form-group col-md-4">
                            <label for="enclose_items">{{ __('field_enclose_items') }}</label>
                            <input type="text" class="form-control" name="enclose_items" id="enclose_items" value="{{ old('enclose_items') }}">

                            <div class="invalid-feedback">
                              {{ __('required_field') }} {{ __('field_enclose_items') }}
                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="ddc_1">{{ __('field_ddc_1') }}</label>
                            <input type="text" class="form-control" name="ddc_1" id="ddc_1" value="{{ old('ddc_1') }}">

                            <div class="invalid-feedback">
                              {{ __('required_field') }} {{ __('field_ddc_1') }}
                            </div>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="ddc_2">{{ __('field_ddc_2') }}</label>
                            <input type="text" class="form-control" name="ddc_2" id="ddc_2" value="{{ old('ddc_2') }}">

                            <div class="invalid-feedback">
                              {{ __('required_field') }} {{ __('field_ddc_2') }}
                            </div>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="ddc_3">{{ __('field_ddc_3') }}</label>
                            <input type="text" class="form-control" name="ddc_3" id="ddc_3" value="{{ old('ddc_3') }}">

                            <div class="invalid-feedback">
                              {{ __('required_field') }} {{ __('field_ddc_3') }}
                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="prefix">{{ __('field_prefix') }}</label>
                            <input type="text" class="form-control" name="prefix" id="prefix" value="{{ old('prefix') }}">

                            <div class="invalid-feedback">
                              {{ __('required_field') }} {{ __('field_prefix') }}
                            </div>
                        </div>


                        <div class="form-group col-md-4">
                            <label for="suffix">{{ __('field_suffix') }}</label>
                            <input type="text" class="form-control" name="suffix" id="suffix" value="{{ old('suffix') }}">

                            <div class="invalid-feedback">
                              {{ __('required_field') }} {{ __('field_suffix') }}
                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="rack_no">{{ __('field_rack_no') }}</label>
                            <input type="text" class="form-control" name="rack_no" id="rack_no" value="{{ old('rack_no') }}">

                            <div class="invalid-feedback">
                              {{ __('required_field') }} {{ __('field_rack_no') }}
                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="sub_rack_no">{{ __('field_sub_rack_no') }}</label>
                            <input type="text" class="form-control" name="sub_rack_no" id="sub_rack_no" value="{{ old('sub_rack_no') }}">

                            <div class="invalid-feedback">
                              {{ __('required_field') }} {{ __('field_sub_rack_no') }}
                            </div>
                        </div>




                        <div class="form-group col-md-4">
                            <label for="publisher_place">{{ __('field_publisher_place') }}</label>
                            <input type="text" class="form-control" name="publisher_place" id="publisher_place" value="{{ old('publisher_place') }}">

                            <div class="invalid-feedback">
                              {{ __('required_field') }} {{ __('field_publisher_place') }}
                            </div>
                        </div>
                      </fieldset>

                      <fieldset class="row scheduler-border">
                        <div class="form-group col-md-6">
                            <label for="description">{{ __('field_description') }}</label>
                            <textarea class="form-control" name="description" id="description">{{ old('description') }}</textarea>

                            <div class="invalid-feedback">
                              {{ __('required_field') }} {{ __('field_description') }}
                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="note">{{ __('field_note') }}</label>
                            <textarea class="form-control" name="note" id="note">{{ old('note') }}</textarea>

                            <div class="invalid-feedback">
                              {{ __('required_field') }} {{ __('field_note') }}
                            </div>
                        </div>

                      </fieldset>
                        <!-- Form End -->
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> {{ __('btn_save') }}</button>
                    </div>
                    </form>
                </div>
            </div>
            <!-- [ Card ] end -->
        </div>
        <!-- [ Main Content ] end -->
    </div>
</div>
<!-- End Content-->

<script src="{{ asset('dashboard/plugins/jquery/js/jquery.min.js') }}"></script>
<script type="text/javascript">
  $(document).ready(function() {
    $('.book-type').on('change',function() {
      if(this.checked){
        $('.show-link').removeClass('d-none');
      }else{
        $('.show-link').addClass('d-none');
      }
    });
  });
</script>
@endsection
