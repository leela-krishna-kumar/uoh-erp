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
    <link rel="stylesheet" type="text/css" href="{{ asset('dashboard/css/prints/receipt.css') }}" media="screen, print">

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

<div class="template-container printable" style="width: {{ $print->width }}; height: {{ $print->height }};">
  <div class="template-inner">
    <!-- Header Section -->
    <table class="table-no-border">
        <tbody>
            <tr>
                <td class="temp-logo">
                  <div class="inner">
                    @if(is_file('uploads/'.$path.'/'.$print->logo_left))
                    <img src="{{ asset('uploads/'.$path.'/'.$print->logo_left) }}" alt="Logo">
                    @endif
                  </div>
                </td>
                <td class="temp-title">
                  <div class="inner">
                    <h2>{{ $print->title }}</h2>
                  </div>
                </td>
                <td class="temp-logo last">
                  <div class="inner">
                    @if(is_file('uploads/'.$path.'/'.$print->logo_right))
                    <img src="{{ asset('uploads/'.$path.'/'.$print->logo_right) }}" alt="Logo">
                    @endif
                  </div>
                </td>
            </tr>
        </tbody>
    </table>
    <!-- Header Section -->
    <!-- Header Section -->
    <table class="table-no-border top-meta-table">
        <tbody>
            <tr>
                <td class="meta-data">{{ __('field_student_id') }}</td>
                <td class="meta-data value width2">: </td>
                <td class="meta-data">{{ __('field_transaction_id') }}</td>
                <td class="meta-data value">: </td>
            </tr>
            <tr>
                <td class="meta-data">{{ __('field_name') }}</td>
                <td class="meta-data value width2">:</td>
                <td class="meta-data">{{ __('field_due_date') }}</td>
                <td class="meta-data value">: 
                </td>
            </tr>
            <tr>
                <td class="meta-data">{{ __('field_program') }}</td>
                <td class="meta-data value width2">:</td>
                <td class="meta-data">{{ __('field_pay_date') }}</td>
                <td class="meta-data value">: 
                </td>
            </tr>
            <tr>
                <td class="meta-data">{{ __('field_session') }}</td>
                <td class="meta-data value width2">: </td>
                <td class="meta-data">{{ __('field_payment_method') }}</td>
                <td class="meta-data value">: 
                </td>
            </tr>
            <tr>
                <td class="meta-data">{{ __('field_semester') }}</td>
                <td class="meta-data value width2">: </td>
                <td class="meta-data">{{ __('field_batch') }}</td>
                <td class="meta-data value">: </td>
            </tr>
        </tbody>
    </table>
    <!-- Header Section -->

    <!-- Header Section -->
    <table class="table-no-border receipt">
        <thead>
            <tr>
                <th class="width2">{{ __('field_fees_type') }}</th>
                <th>{{ __('field_amount') }}</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td colspan="2" class="exam-title"></td>
            </tr>
            <tr class="border-bottom">
                <td>{{ __('field_fee') }}</td>
                <td>
                </td>
            </tr>
            <tr class="border-bottom">
                <td>{{ __('field_discount') }}</td>
                </td>
            </tr>
            <tr class="border-bottom">
                <td>{{ __('field_fine_amount') }}</td>
                <td>+ 
                </td>
            </tr>
            <tr class="tfoot">
                <th>{{ __('field_total') }}:</th>
                <th>=
                </th>
            </tr>
        </tbody>
    </table>
    <!-- Header Section -->

    <!-- Header Section -->
    <table class="table-no-border">
        <tbody>
            <tr>
                <td class="temp-footer">
                  <div class="inner">
                    <p>{!! $print->footer_left !!}</p>
                  </div>
                </td>
                <td class="temp-footer">
                  <div class="inner">
                    <p>{!! $print->footer_center !!}</p>
                  </div>
                </td>
                <td class="temp-footer last">
                  <div class="inner">
                    <p>{!! $print->footer_right !!}</p>
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