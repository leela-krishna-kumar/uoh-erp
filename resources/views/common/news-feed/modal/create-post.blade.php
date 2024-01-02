
    <div id="addPost" uk-modal>
        <div class="uk-modal-dialog" style="border-radius: 10px !important;">
            <button class="uk-modal-close-default close-post-area" type="button" uk-close></button>
            <div class="uk-modal-header">
                <div href="#" class="bg-primary">
                    <div class="d-flex align-items-center col-lg-5 post-area">
                        <img src="{{asset('dashboard/images/user/avatar-1.jpg') }}" class="post-user-img">
                        <div class="user-post-name">
                            <h2 class="uk-modal-title">{{ $row->first_name }} {{ $row->last_name }}</h2>
                            <p>Post to Anyone</p>
                        </div>
                    </div>
                </div>
            </div>
            <form class="needs-validation" action="{{ route($route.'.store-post') }}" method="post" enctype="multipart/form-data">
                <div class="uk-modal-body">
                    @csrf
                    <div class="row">
                        <div class="form-group col-md-12">
                            <textarea name="content" class="form-control bg-white" id="exampleFormControlTextarea1" rows="4" placeholder="what do you want to talk about?" style="padding: 10px;"></textarea>
                        </div>

                    </div>
                </div>
                <div class="uk-modal-footer text-right">
                    <button type="submit" class="btn btn-success post-button"><i class="fas fa-check mr-2"></i> {{ __('Post') }}</button>
                </div>
            </form>
        </div>
    </div>
