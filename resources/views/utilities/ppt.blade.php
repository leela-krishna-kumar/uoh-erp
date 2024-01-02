<!DOCTYPE html>
<html>

<head>
    <title>PPT | {{ getSetting('app_name') }} </title>
    <meta charset="utf-8">
   <link href="{{ asset('frontend') }}/utilities/styles/layout.css" rel="stylesheet" type="text/css">
  <link rel="stylesheet" href="{{ asset('frontend') }}/utilities/jquery_ui/themes/start/jquery-ui.min.css">
  <script src="{{ asset('frontend') }}/utilities/jquery/jquery-1.12.4.min.js"></script>
  <script src="{{ asset('frontend') }}/utilities/jquery_ui/jquery-ui.min.js"></script>
  <!--Docs-->
  <script src="{{ asset('frontend') }}/utilities/docx/jszip-utils.js"></script>
  <!--PPTX-->
  <link rel="stylesheet" href="{{ asset('frontend') }}/utilities/PPTXjs/css/pptxjs.css">
  <link rel="stylesheet" href="{{ asset('frontend') }}/utilities/PPTXjs/css/nv.d3.min.css">
  <link rel="stylesheet" href="{{ asset('frontend') }}/utilities/revealjs/reveal.css">

  <script type="text/javascript" src="{{ asset('frontend') }}/utilities/PPTXjs/js/filereader.js"></script>
  <script type="text/javascript" src="{{ asset('frontend') }}/utilities/PPTXjs/js/d3.min.js"></script>
  <script type="text/javascript" src="{{ asset('frontend') }}/utilities/PPTXjs/js/nv.d3.min.js"></script>
  <script type="text/javascript" src="{{ asset('frontend') }}/utilities/PPTXjs/js/pptxjs.js"></script>
  <script type="text/javascript" src="{{ asset('frontend') }}/utilities/PPTXjs/js/divs2slides.js"></script>
  <!--All Spreadsheet -->
  <script type="text/javascript" src="{{ asset('frontend') }}/utilities/SheetJS/xlsx.full.min.js"></script>
  <!--officeToHtml-->
  <script src="{{ asset('frontend') }}/utilities/officeToHtml.js"></script>
  <link rel="stylesheet" href="{{ asset('frontend') }}/utilities/officeToHtml.css">
</head>

<body id="top">
    <div class="wrapper row3">
        <main class="hoc  clear">
            <!--<div id="resolte-contaniner" style="display:none;"></div>-->
            <div style="overflow: hidden;width: -webkit-fill-available; ">
                <div id="resolte-contaniner" style="width: 100%; height:90vh; overflow: auto;"></div>
            </div>
            <!-- / main body -->
            <div class="clear"></div>
        </main>
    </div>

    <script>
        (function($) {
            $(document).ready(function() {
                var file_path = "{{ $path }}";
                $("#resolte-contaniner").officeToHtml({
                    url: file_path,
                    pdfSetting: {
                        setLang: "",
                        setLangFilesPath: "" /*"include/pdf/lang/locale" - relative to app path*/
                    }
                });
            });
        }(jQuery));
    </script>
</body>

</html>
