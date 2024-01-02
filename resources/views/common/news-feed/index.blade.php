@php
    $disableHeader = true;
@endphp
@extends('common.layouts.master')

@section('content')

<!-- Start Content-->
@section('content')
   <style>
    .post-button{
    transition-timing-function: cubic-bezier(.4,0,.2,1);
    transition-duration: 167ms;
    align-items: center;
    border-radius: 2px;
    cursor: pointer;
    font-family: inherit;
    font-weight: 600;
    display: inline-flex;
    justify-content: center;
    overflow: hidden;
    padding: 7px 15px;
    border-radius: 50px;
    color: #fff;
    background-color: #4963d9;
}
.uk-modal-header{
    border-top-right-radius: 10px;
    border-top-left-radius: 10px;
}
.uk-modal-footer{
    border-bottom-right-radius: 10px;
    border-bottom-left-radius: 10px;
}
.post-user-img{
    height: 60px;
    width: 60px;
    border-radius: 50px;
    object-fit: contain;
}
.user-post-name{
     margin-top: 10px;
     margin-left: 8px;   
}
.user-post-name h2{
    font-size: 18px;
    font-weight: 500;
    line-height: 13px !important;
}
.user-post-name p{
     font-size: 13px;   
}
.post-area{
    border-radius: 10px;
    padding: 10px;
}
/* .post-area:hover{
    background-color: #ebebeb !important;
} */
.close-post-area{
    height: 30px;
    width: 30px;
    border-radius: 50px;
    padding: 8px;
    transition: all 0.2s;
}
.close-post-area:hover{
    background-color: #ebebeb !important;
}
textarea::placeholder{
    font-size: 16px;
    color: #645e5e;
}
.profile-img{
        height: 80px !important;
        width: 80px !important;
        object-fit: contain !important;
    }
    .post-modal-button{
        width: 100%;
        padding: 14px 20px 14px 20px !important;
        border: 1px solid rgb(165, 155, 155);
        border-radius: 50px;
        text-align: left;
        font-weight: 700;
        padding-left: 10px;
        font-size: 14px !important;
        transition: all 0.2ms;
    }
    .post-modal-button:hover{
      background-color: rgba(235,235,235,1);
    }
    @media(max-width:576px){
        .b-block{
            display: block !important;
        }
        .max-width-100{
            max-width: 100% !important;
        }
        .pl-25{
        padding:11px 35px !important;
       }
    }

    /* Profile */

    .card-link{
    color:rgb(49, 49, 173);
    }
    .fs-13{
        font-size: 13px;
    }
    .feed-identity a:hover{
    background-color: #696363 !important;
    }
    .profile-card{
        width: 280px;
        height: auto;
        background-color: #ffffff;
        margin: 0 auto;
        box-shadow: 0px 1px 3px 0px rgba(0, 0, 0, 0.15);
    }

    .card_profile_img {
        width: 90px;
        height: 90px;
        background-color: #868d9b;
        background: url("https://source.unsplash.com/7Sz71zuuW4k");
        background-repeat: no-repeat;
        background-size: cover;
        background-position: center;
        border: 2px solid #ffffff;
        border-radius: 120px;
        margin: 0 auto;
        margin-top: -60px;

    }

    .card_background_img {
        width: 100%;
        height: 85px;
        background-color: #e1e7ed;
        background: url("https://source.unsplash.com/9wg5jCEPBsw");
        background-repeat: no-repeat;
        background-size: cover;
        background-position: center;
    }

    .user_details p {
        margin-bottom: 11px;
        font-size: 13px;
        color: #868d9b;
        line-height: 18px;
    }

    .user_details h3 {
        margin-top: 10px;
        font-size: 18px;
        font-weight: 500;
        color: #33363b;
    }

    .card_count {
        padding: 10px 0px;
        border-top: 1px solid #dde1e7;
    }
    .card-prime{
        padding: 15px 12px !important;
    }
    .count p {
        margin-top: -10px;
    }
    .writing-assistant:hover{
    background-color: red !important;
    }
    .writing-assistant p{
        font-size: 13px;
        line-height: 16px;
    }
    .writing-assistant h3{
    font-weight: 600 !important;
    }
    .resent-discover{
    margin-top:10px;
    }
    .list-group-item a{
        font-size: 12px;
        color: #373232;
        line-height: 28px;
    }
    .resent-update-title h6{
        font-size: 15px;
        font-weight: 600;
    }
    .dropdown-content {
    position: absolute;
    margin-top: 20px;
    background-color: #f9f9f9;
    min-width: 128px;
    overflow: auto;
    box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
    z-index: 1;
    display: none;
    right: 0;
    margin-right: 40px;
}

.dropdown-content a {
    color: black;
    padding: 6px 14px;
    text-decoration: none;
    display: block;
    text-align: left;
}

.dropdown-content a:hover {
    background-color: #f1f1f1;
}

.dropdown-content.show {
    display: block;
}
   </style>
    <!-- Main Contents -->
    <div class="main_content">
        <div class="container">
            <div class="row b-block">
                <div class="col-3 max-width-100 mt-lg-0 mt-4">
                    @include('common.news-feed.include.profile')
                </div>
                <div class="col-6 max-width-100 mt-lg-0 mt-4">
                    @include('common.news-feed.include.posts')
                </div>
                <div class="col-3 max-width-100 mt-lg-0 mt-4">
                    @include('common.news-feed.include.latest-updates')
                </div>
            </div>
        </div>
    </div>
    <div id="like_container">
        @include('common.news-feed.modal.likes')
    </div>
    @include('common.news-feed.modal.create-post')

    <!-- Main Contents -->
</div>
@endsection
@push('script')
<script>
    function postComments(id){
        UIkit.modal('#addPost').show();
    }
    function storePostLikes(id){
        var oldCount = $('#like_count_'+id).text();
        $.ajax({
            url: '{{ route("news-feed.store-likes") }}',
            method: 'POST',
            data: {_token:$('input[name=_token]').val() , post_id:id},
            success: function(res) {
                $('#like_count_'+id).text(res);
                if(oldCount > res){
                    $('#store_post_likes_'+id).html(`<i class="fa fa-thumbs-up"></i><span class="font-bold"> Like </span>`);
                }else{
                    $('#store_post_likes_'+id).html(`<i class="fa fa-thumbs-up" style="color: #007bff"></i> <span class="font-bold" style="color: #007bff"> Liked </span>`);
                }

            }
            
        })
    }

    function storePostCommentLikes(id,post_id){
        var oldCount = $('#comment_like_count_'+id+'_'+post_id).text();
        $.ajax({
            url: '{{ route("news-feed.store-comment-likes") }}',
            method: 'POST',
            data: {_token:$('input[name=_token]').val() , post_id:post_id,id:id},
            success: function(res) {
                if(oldCount > res){
                    $('#store_comment_likes_'+id+'_'+post_id).html(`<i class="fa fa-thumbs-up"></i>`);
                }else{
                    $('#store_comment_likes_'+id+'_'+post_id).html(`<i class="fa fa-thumbs-up" style="color: #007bff"></i>`);
                }
                $('#comment_like_count_'+id+'_'+post_id).text(res);
            }
            
        })
    }

    function storePostComments(id){
        var comment = $('#comment_'+id).val();
        var commentContainer = $('#comment_container_'+id);
        if(comment != ''){
            $.ajax({
                url: '{{ route("news-feed.store-comments") }}',
                method: 'POST',
                data: {_token:$('input[name=_token]').val() , post_id:id, comment : comment},
                success: function(res) {
                    commentContainer.hide();
                    commentContainer.html(res)
                    $('#comment_count_'+id).text($('#new_comment_count_'+id).val());
                    commentContainer.show();
                    $('#comment').val('');
                }
                
            })
        }
    }

    
    function getPostComments(id){
        var commentContainer = $('#comment_container_'+id);
        if (commentContainer.css('display') === 'none') {
            $.ajax({
                url: '{{ route("news-feed.get-comments") }}',
                method: 'GET',
                data: {post_id:id},
                success: function(res) {
                    commentContainer.html(res)
                    commentContainer.show();
                }
            })
        } else {
            commentContainer.hide();
        }
    }
    function getPostLikes(id){
        $.ajax({
            url: '{{ route("news-feed.get-likes") }}',
            method: 'GET',
            data: {post_id:id},
            success: function(res) {
                $('#like_container').html(res)
                UIkit.modal('#postLikes').show();
            }
            
        })
    }

    function getPostCommentLikes(id,post_id){
        $.ajax({
            url: '{{ route("news-feed.get-comment-likes") }}',
            method: 'GET',
            data: {post_id:post_id,id:id},
            success: function(res) {
                $('#like_container').html(res)
                UIkit.modal('#postLikes').show();
            }
            
        })
    }

    $('.check-type').on('change',function(){
        let type = $(this).val();
        //4 = Link Type
        if(type == 4){
            $('.media-input').addClass('d-none'); 
            $('.link-input').removeClass('d-none');
        }else{
            $('.link-input').addClass('d-none'); 
            $('.media-input').removeClass('d-none');
        }
    });
</script>
@endpush
            