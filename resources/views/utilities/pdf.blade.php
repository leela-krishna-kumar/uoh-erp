<!DOCTYPE html>
<html>

<head>
    <title>PDF | {{ getSetting('app_name') }} </title>
    <meta charset="utf-8">
    <link href="{{ asset('frontend') }}/utilities/styles/layout.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{ asset('frontend') }}/utilities/jquery_ui/themes/start/jquery-ui.min.css">
    <script src="{{ asset('frontend') }}/utilities/jquery/jquery-1.12.4.min.js"></script>
    <script src="{{ asset('frontend') }}/utilities/jquery_ui/jquery-ui.min.js"></script>
    <!--PDF-->
    <link rel="stylesheet" href="{{ asset('frontend') }}/utilities/pdf/pdf.viewer.css">
    <script src="{{ asset('frontend') }}/utilities/pdf/pdf.js"></script>
    <!--officeToHtml-->
    <script src="{{ asset('frontend') }}/utilities/officeToHtml.js"></script>
    <link rel="stylesheet" href="{{ asset('frontend') }}/utilities/officeToHtml.css">
</head>

<body id="top">
    <style>
        @media screen and (max-width: 900px){
            .hoc {
                max-width: 100% !important;
            }
        }
        #resolte-contaniner{
            width: 100%; height: 90vh; overflow-y: auto; overflow-x: hidden;
        }
        #secondaryOpenFile, #secondaryPrint, #secondaryDownload{
            display: none !important;
        }
    </style>
    <div class="wrapper row3">
        <main class="hoc clear">
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
                $(".sdb_holder li").removeClass("active");
                $(this).parent().addClass("active");
                var id = $(this).attr("id");
                $("#head-name").html($(this).html());
                $("#description").hide();
                $("#resolte-contaniner").html("");
                $("#resolte-contaniner").show();
                $("#resolte-text").show();
                if (id != "demo_input") {

                    $("#select_file").hide();
                    var file_path = "{{ $path }}";
                    $("#a_file").html("{{ $path }}").attr("href",
                        file_path);
                    $("#a_file").show();
                    $("#file_p").show();

                    $("#resolte-contaniner").officeToHtml({
                        url: file_path,
                        pdfSetting: {
                            setLang: "",
                            openFileBtn: false,
                            secondaryopenFileBtn: false,
                            printBtn: false,
                            downloadBtn: false,
                            setLangFilesPath: "" /*"include/pdf/lang/locale" - relative to app path*/
                        }
                    });
                } else {

                    $("#select_file").show();
                    $("#file_p").show();
                    $("#a_file").hide();

                    $("#resolte-contaniner").officeToHtml({
                        inputObjId: "select_file",
                        pdfSetting: {
                            setLang: "",
                            openFileBtn: false,
                            secondaryopenFileBtn: false,
                            printBtn: false,
                            downloadBtn: false,
                            setLangFilesPath: "" /*"include/pdf/lang/locale" - relative to app path*/
                        }
                    });
                }
            });
        }(jQuery));
    </script>
</body>

</html>
