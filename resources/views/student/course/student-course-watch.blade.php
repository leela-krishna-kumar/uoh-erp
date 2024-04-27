@extends('student.layouts.student-watch-master')
@section('content')
    <!-- Main Contents -->
    <div id="wrapper" class="course-watch">  

        <!-- Main Contents -->
        <div class="main_content h-screen flex justify-center items-center">
             
            <ul class="w-full " id="video_tabs">

                <li class="d-none" id="vedio_container">
                    <div class="embed-video">
                        <iframe id="vedio_container_src" src="" frameborder="0"uk-video="automute: true" allowfullscreen uk-responsive></iframe>
                    </div>
                </li>
                <li class="d-none" id="live_container">
                    <div class="embed-video">
                        <iframe id="live_container_src" src="" frameborder="0" allowfullscreen uk-responsive></iframe>
                    </div>
                </li>
                <li class="" id="ebook_container">
                    <div class="embed-video">
                        <div id="PDFKIT"></div>
                    </div>
                </li>
                <li class="d-none" id="test_container">
                    <div class="embed-video">
                        <iframe id="test_container_src" src="" frameborder="0" allowfullscreen uk-responsive></iframe>
                    </div>
                </li>
            </ul>
        </div>
        @include('student.layouts.inc.student-watch-sidebar')
    </div>     
<!-- Main Contents -->

@endsection

{{-- <script src="{{ asset('assets/js/student-dashboard.js')}}"></script> --}}
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script src="{{ asset('assets/dist/pspdfkit.js') }}"></script>
    <script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.11.338/pdf.min.js"></script>

    <script>
        PSPDFKit.load({
            container: "#PDFKIT",
            // document: pdf_path,
              document: "http://localhost/project/CodeEasy-Laravel/core/storage/upload/chart-pdf/traffic_pub_gen19.pdf",
        })
        .then(function(instance) {
            console.log("PSPDFKit loaded", instance);
        })
        .catch(function(error) {
            console.error(error.message);
        });
    </script>
<script>
    $(document).ready(function(){
        console.log("okkkkkk");
        var e_lesson_id = {{ $e_lesson_id }}; // Assuming $e_lesson_id is a PHP variable passed to the view
        console.log(e_lesson_id);
        // is_elesson = $('#is_elesson').val();
        // if(is_elesson == 1){
        //     getLinkVal(e_section_id);
        // }
        getLinkVal(e_lesson_id);
    });
    function getLinkVal(key){
        console.log(key);
        link = $('#get_link'+key).data('link');
        type = $('#get_link'+key).data('type');
        console.log('Link:', link);
        console.log('Type:', type);
        course_id = $('#get_link'+key).data('course_id');
        lesson_id = $('#get_link'+key).data('lesson_id');
        student_id = $('#get_link'+key).data('student_id');

        // $.ajax({
        //     url: "{{ route('admin.ecourse-progress.update') }}",
        //     method: 'get',
        //     data: {student_id:student_id,course_id:course_id,lesson_id:lesson_id},
        //     success: function(result){
        //         console.log(result.data);
        //     }
        // });

        $.ajax({
                url: "/getCourseLesson",
                method: 'get',
                data: { lesson_id: lesson_id },
                success: function(response){
                    link = response.data ? response.data : '';
                    console.log("Hello");
                    console.log(response.data);
                    console.log(link);
                    $.ajax({
                        url: "{{ route('admin.ecourse-progress.update') }}",
                        method: 'get',
                        data: { student_id: student_id, course_id: course_id, lesson_id: lesson_id },
                        success: function(result){
                            console.log(result.data);
                        }
                    });
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching lesson:", error);
                }
            });
        if(type == 'Video'){
            $('#live_container').addClass('d-none');
            $('#test_container').addClass('d-none');
            $('#ebook_container').addClass('d-none');
            $('#vedio_container_src').attr('src',link);
            $('#vedio_container').removeClass('d-none');
        }else if(type == 'Live'){
            $('#vedio_container').addClass('d-none');
            $('#test_container').addClass('d-none');
            $('#ebook_container').addClass('d-none');
            $('#live_container').removeClass('d-none');
            $('#live_container_src').attr('src',link);
        }else if(type == 'Ebook'){
            $('#vedio_container').addClass('d-none');
            $('#live_container').addClass('d-none');
            $('#test_container').addClass('d-none');
            $('#ebook_container').removeClass('d-none');
            $('#ebook_container_src').attr('src',link);
        }else if(type == 'Test'){
            $('#vedio_container').addClass('d-none');
            $('#live_container').addClass('d-none');
            $('#ebook_container').addClass('d-none');
            $('#test_container').removeClass('d-none');
            $('#test_container_src').attr('src',link);
        }
    }
</script>

