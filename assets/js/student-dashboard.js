$(document).ready(function(){
    is_elesson = $('#is_elesson').val();
    if(is_elesson == 1){
        getLinkVal(0);
    }
});
function getLinkVal(key){
    link = $('#get_link'+key).data('link');
    type = $('#get_link'+key).data('type');
    course_id = $('#get_link'+key).data('course_id');
    lesson_id = $('#get_link'+key).data('lesson_id');
    student_id = $('#get_link'+key).data('student_id');
    $.ajax({
        url: "{{ route('admin.ecourse-progress.update') }}",
        method: 'get',
        data: {student_id:student_id,course_id:course_id,lesson_id:lesson_id},
        success: function(result){
            console.log(result.data);
        }
    });
    if(type == 0){
        $('#live_container').addClass('d-none');
        $('#test_container').addClass('d-none');
        $('#ebook_container').addClass('d-none');
        $('#vedio_container_src').attr('src',link);
        $('#vedio_container').removeClass('d-none');
    }else if(type == 1){
        $('#vedio_container').addClass('d-none');
        $('#test_container').addClass('d-none');
        $('#ebook_container').addClass('d-none');
        $('#live_container').removeClass('d-none');
        $('#live_container_src').attr('src',link);
    }else if(type == 2){
        $('#vedio_container').addClass('d-none');
        $('#live_container').addClass('d-none');
        $('#test_container').addClass('d-none');
        $('#ebook_container').removeClass('d-none');
        $('#ebook_container_src').attr('src',link);
    }else if(type == 3){
        $('#vedio_container').addClass('d-none');
        $('#live_container').addClass('d-none');
        $('#ebook_container').addClass('d-none');
        $('#test_container').removeClass('d-none');
        $('#test_container_src').attr('src',link);
    }
}