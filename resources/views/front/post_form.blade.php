<!-- *********** add new post ************ -->
<div class="new-post-section" >
    <form class="post-inputs flex-row align-items-center" method="POST" action="{{route('addNewPost.route')}}" enctype="multipart/form-data" ownerID="" ownerType="">
        @csrf
        @include('errors')
        <img class="profile-icon circle-icon " src="{{$currentUserProfile['path'].$currentUserProfile['image']}}" alt=""/>
        <textarea id="newpost-text"  class="post-text" type="text" name="text" ></textarea>
        <div class="file-upload-wrapper hidden">
            <input class="upload-btn "  type="file"  id="uploadImg" name="uploaded_file"/>
            <label class="upload-label"  for="uploadImg" >
                <i class="label-icon fas fa-camera"></i>
            </label>
            <input type="text" hidden class="hidden" name="page_id" value="{{$pageID}}"/>
            <input type="text" hidden class="hidden" name="page_type" value="{{$pageType}}"/>
            <input type="submit" class="post-btn hidden" name="post_btn" value="Post"/>
        </div>
    </form>
    <div class="add-media flex-row justify-content-center">
        <div class="text_icon-box">
            <i class="icon far fa-images"></i>
            <h4 class="text">Contacts</h4>
        </div>
        <div class="text_icon-box">
            <i class="icon far fa-grin"></i>
            <h4 class="text">Contacts</h4>
        </div>
    </div>
</div>
