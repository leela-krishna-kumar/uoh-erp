<!DOCTYPE html>
<html>

<head>
    <title>Image | {{ getSetting('app_name') }}</title>
    <meta charset="utf-8">
    <link href="{{ asset('frontend') }}/utilities/styles/layout.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{ asset('frontend') }}/utilities/jquery_ui/themes/start/jquery-ui.min.css">
    <script src="{{ asset('frontend') }}/utilities/jquery/jquery-1.12.4.min.js"></script>
    <script src="{{ asset('frontend') }}/utilities/jquery_ui/jquery-ui.min.js"></script>
    <!--Image viewer-->
    <link rel="stylesheet"
        href="{{ asset('frontend') }}/utilities/verySimpleImageViewer/css/jquery.verySimpleImageViewer.css">
    <script type="text/javascript"
        src="{{ asset('frontend') }}/utilities/verySimpleImageViewer/js/jquery.verySimpleImageViewer.js"></script>
    <!--officeToHtml-->
    <script src="{{ asset('frontend') }}/utilities/officeToHtml.js"></script>
    <link rel="stylesheet" href="{{ asset('frontend') }}/utilities/officeToHtml.css">
</head>

<body id="top">
    <div class="wrapper row3">
        <main class="hoc  clear">
            <div style="overflow: hidden;width: -webkit-fill-available; ">
                <div id="resolte-contaniner" style="width: 100%; height:90vh; overflow: auto;"></div>
            </div>
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
