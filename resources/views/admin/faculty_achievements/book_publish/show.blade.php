@extends('admin.layouts.master')
@section('title', $title)
@section('content')

<div class="main-body">
    <div class="page-wrapper">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>{{ $title }} </h5>
                    </div>
                </div>
            </div>

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
                        <div class="table-responsive">
                            <table class="table table-bordered border-primary" style="width:100%">
                                <tbody>
                                    <tr>
                                        <td><b>Staff Id</b></td>
                                        <td> {{ $publish->staff_id }}</td>
                                    </tr>
                                    <tr>
                                        <td><b>Teacher Name</b></td>
                                        @php
                                          $user = App\User::where('staff_id', $publish->staff_id)->first();
                                            if($user)
                                            {
                                                $name = $user->first_name . ' ' . $user->last_name;
                                            }else {
                                                $name = '';
                                            }
                                          @endphp
                                        <td> {{ $name }}</td>
                                    </tr>
                                    <tr>
                                        <td><b>Published Book Title</b></td>
                                        <td> {{ $publish->published_book_title }}</td>
                                    </tr>
                                    <tr>
                                        <td><b>Published Chapter Title</b></td>
                                        <td> {{ $publish->published_chapter_title }}</td>
                                    </tr>
                                    <tr>
                                        <td><b>Publication Year</b></td>
                                        <td> {{ $publish->publication_year }}</td>
                                    </tr>
                                    <tr>
                                        <td><b>ISBN Number</b></td>
                                        <td> {{ $publish->isbn_number }}</td>
                                    </tr>
                                    <tr>
                                        @php
                                        if($publish->same_affiliating_institute == 1)
                                        {
                                            $institute = 'Yes';
                                        } else {
                                            $institute = 'No';
                                        }
                                        @endphp
                                        <td><b>Same Affiliating Institute</b></td>
                                        <td> {{ $institute }}</td>
                                    </tr><tr>
                                        <td><b>Publisher Name</b></td>
                                        <td> {{ $publish->publisher_name	 }}</td>
                                    </tr>
                                  </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('page_js')

@yield('sub-script')

@endsection