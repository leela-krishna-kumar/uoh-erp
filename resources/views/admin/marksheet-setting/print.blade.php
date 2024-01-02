<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width,maximum-scale=1.0">
    <title>{{ $title }}</title>
    
    <style type="text/css" media="print">
    @media print {
      @page { size: A4 portrait; margin: 10px auto; }   
      @page :footer { display: none }
      @page :header { display: none }
      body { margin: 15mm 15mm 15mm 15mm; }
      table, tbody {page-break-before: auto;}
    }
    table, img, svg {
      break-inside: avoid;
    }
    .template-container {
      -webkit-transform: scale(1.0);  /* Saf3.1+, Chrome */
      -moz-transform: scale(1.0);  /* FF3.5+ */
      -ms-transform: scale(1.0);  /* IE9 */
      -o-transform: scale(1.0);  /* Opera 10.5+ */
      transform: scale(1.0);
    }
    </style>
   <link rel="stylesheet" type="text/css" href="{{ asset('dashboard/css/prints/marksheet.css') }}" media="screen, print">

    @php 
    $version = App\Models\Language::version(); 
    @endphp
    @if($version->direction == 1)
    <!-- RTL css -->
    <style type="text/css" media="screen, print">
    .template-container {
      direction: rtl;
    }
    .template-container .top-meta-table tr td,
    .template-container .top-meta-table tr th {
      float: right;
      text-align: right;
    }
    .table-no-border.receipt thead th:nth-child(1), 
    .table-no-border.receipt td:nth-child(1), 
    .table-no-border.receipt .tfoot th:nth-child(1) {
      text-align: right;
    }
    .template-container .table-no-border tr td.temp-logo {
      float: none;
    }
    .table-no-border.receipt .exam-title {
      text-align: right !important;
    }
    </style>
    @endif
</head>
<body>
<div class="template-container printable" style="width: {{ $marksheet->width }}; height: {{ $marksheet->height }};">
  <div class="template-inner">
    <!-- Header Section -->
    <table class="table-no-border">
        <tbody>
            <tr>
                <td class="temp-logo">
                  <div class="inner">
                    @if(is_file('uploads/'.$path.'/'.$marksheet->logo_left))
                    <img src="{{ asset('uploads/'.$path.'/'.$marksheet->logo_left) }}" alt="Logo">
                    @endif
                  </div>
                </td>
                <td class="temp-title">
                  <div class="inner">
                    <h2>{{ $marksheet->title }}</h2>
                  </div>
                </td>
                <td class="temp-logo last">
                  <div class="inner">
                    @if(is_file('uploads/'.$path.'/'.$marksheet->logo_right))
                    <img src="{{ asset('uploads/'.$path.'/'.$marksheet->logo_right) }}" alt="Logo">
                    @endif
                  </div>
                </td>
            </tr>
        </tbody>
    </table>
    <!-- Header Section -->
    <table class="table-no-border top-meta-table">
      <tbody>
          <tr>
              <td class="meta-data">{{ __('field_student_id') }}</td>
              <td class="meta-data width2">: </td>

              <td class="meta-data">{{ __('field_starting_year') }}</td>
              <td class="meta-data">: </td>
          </tr>
          <tr>
              <td class="meta-data">{{ __('field_name') }}</td>
              <td class="meta-data width2">: </td>
              <td class="meta-data">{{ __('field_ending_year') }}</td>
              <td class="meta-data">: </td>
          </tr>
          <tr>
              <td class="meta-data">{{ __('field_gender') }}</td>
              <td class="meta-data width2">: 
              </td>
              <td class="meta-data">{{ __('field_dob') }}</td>
              <td class="meta-data">:
              </td>
          </tr>
          <tr>
              <td class="meta-data">{{ __('field_batch') }}</td>
              <td class="meta-data width2">:</td>
              <td class="meta-data">{{ __('field_total_credit_hour') }}</td>
              <td class="meta-data">:</td>
          </tr>
          <tr>
              <td class="meta-data">{{ __('field_program') }}</td>
              <td class="meta-data width2">: </td>

              <td class="meta-data">{{ __('field_cumulative_gpa') }}</td>
              <td class="meta-data">: </td>
          </tr>
      </tbody>
    </table>
  <!-- Header Section -->

  <br/>

  <!-- Header Section -->
  <table class="table-no-border marksheet">
      <thead>
          <tr>
              <th>{{ __('field_code') }}</th>
              <th class="width2">{{ __('field_subject') }}</th>
              <th>{{ __('field_credit_hour') }}</th>
              <th>{{ __('field_point') }}</th>
              <th>{{ __('field_grade') }}</th>
          </tr>
      </thead>
  </table>
  <!-- Header Section -->
    <!-- Header Section -->
    <table class="table-no-border">
      <tbody>
          <tr>
              <td class="temp-footer">
                <div class="inner">
                  <p>{!! $marksheet->footer_left !!}</p>
                </div>
              </td>
              <td class="temp-footer">
                <div class="inner">
                  <p>{!! $marksheet->footer_center !!}</p>
                </div>
              </td>
              <td class="temp-footer last">
                <div class="inner">
                  <p>{!! $marksheet->footer_right !!}</p>
                </div>
              </td>
          </tr>
      </tbody>
    </table>
    <!-- Header Section -->
  </div>
</div>

    <!-- Print Js -->
    <script src="{{ asset('dashboard/plugins/jquery/js/jquery.min.js') }}"></script>
    <script src="{{ asset('dashboard/plugins/print/js/jQuery.print.min.js') }}"></script>

    <script type="text/javascript">
    $( document ).ready(function() {
      "use strict";
      $.print(".printable");
    });
    </script>

</body>
</html>