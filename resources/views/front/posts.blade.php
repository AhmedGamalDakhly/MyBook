<div class="posts-container">
    @if(isset($posts))
    @foreach($posts as $post)
        @php  $postOwnerProfile= $post->profile;
              $comments= $post->comments;
              $commentsCount=count($comments);
              $sharesCount= count($post->shares);
              $likesCount=$post['like_count'];
        @endphp
        <div class="post-box flex-col" >
            <div class="post-header">
              @if($post['type']=="shared")
                 <div class="flex-row">
                     <a href="{{route('profile.route',$postOwnerProfile['user_id'])}}"><img class="circle-icon profile-image" src="{{asset($postOwnerProfile['path'].$postOwnerProfile['image'])}}" alt="icon"/></a>
                     <a href=" {{route('profile.route',$postOwnerProfile['user_id'])}} "><p class="post-owner">{{$postOwnerProfile['name']}}</p></a>
                     <p>   Shared   </p>
                     <a href=" {{route('profile.route',$post->sharedPost->profile['user_id'])}} "><p class="post-owner">{{$post->sharedPost->profile['name']}}</p></a>
                            <p>'s  Post</p>
                     <a href=""><p class="time">20h <span> . </span></p></a>
                </div>
            @else
            <div class="flex-row">
                <a href="{{route('profile.route',$postOwnerProfile['user_id'])}}"><img class="circle-icon profile-image" src="{{asset($postOwnerProfile['path'].$postOwnerProfile['image'])}}" alt=""/></a>
                <div class="">
                    <a href=" {{route('profile.route',$postOwnerProfile['user_id'])}} "><p class="post-owner">{{$postOwnerProfile['name']}}</p></a>
                    <a href=""><p class="time">20h <span> . </span></p></a>
                </div>
            </div>
            @endif
                  @can('delete',$post)
                      <i  class=" menu align-self-start fas fa-trash delete-post" postID="{{$post['id']}}"></i>
                  @endif
            </div>
        <div class="post-body">
            <p class="text"> {!! $post['text'] !!}</p>
            @if($post['image']!==null)
            <div class="media">
                <img src="{{$post['image']}}" alt=""/>
            </div>
             @endif
            @if($post['type']=="shared")

            <div class="post-box shared-post flex-col">
                <div class="post-header">
                    <div class="flex-row">
                        <a href="{{route('profile.route',$postOwnerProfile['user_id'])}}"><img class="circle-icon profile-image" src="{{$postOwnerProfile['path'].$postOwnerProfile['image']}}" alt=""/></a>
                        <div class="">
                            <a href=" {{route('profile.route',$postOwnerProfile['user_id'])}} "><p class="post-owner">{{$postOwnerProfile['name']}}</p></a>
                            <a href=""><p class="time">20h <span> . </span></p></a>
                        </div>
                    </div>
                </div>
                <div class="post-body">
                    <p class="text"> {{$post->sharedPost['text']}}</p>
                    @if($post->sharedPost['image']!==null)
                        <div class="media">
                            <img src="{{$post->sharedPost['image']}}" alt=""/>
                        </div>
                    @endif
                </div>
            </div>
            @endif
        </div>

        <div class="post-footer">
            <div class="post-meta clearfix">
                <a href="" class="likes"><span class="like-count">{{$likesCount == 0 ? " " : $likesCount.' Likes'}} </span></a>
                <a href="" class="comments"><span> {{$commentsCount == 0 ? " " :$commentsCount.' Comments'}} </span></a>
                <a href="" class="shares"><span>   {{$sharesCount   == 0 ? " " : $sharesCount.' Shares'}} </span></a>
            </div>
            <hr style="width: 100%">
            <div class="post-actions flex-row justify-space-around "   content-id="{{$post['id']}}">
                <a  class="like image_text-link  flex-1 flex-center @if($post->isLiked($currentUserProfile['user_id']))  liked @endif ">
                    <i class="icon  far fa-thumbs-up"></i>
                    <p class="text">Like</p>
                </a>
                <div class="comment image_text-link flex-1 flex-center">
                    <i class="icon  fas fa-comment"></i>
                    <p class="text">Comment</p>
                </div>
                <a class="share image_text-link flex-1 flex-center" >
                    <i class="icon fas fa-share"></i>
                    <p class="text">Share</p>
                </a>
            </div>
            <hr style="width: 100%">
        </div>
        <div class="post-comments">
            @include('errors')
            <form class="new-comment flex-row align-items-center" id="addCommentForm"  method="POST" postID="{{$post['id']}}" action="{{route('addNewComment.route',$post['id'])}}">
                @csrf
                <a href="{{route('profile.route',$currentUserProfile['user_id'])}}" ><img class="profile-icon circle-icon" src="{{asset($currentUserProfile['path'].$currentUserProfile['image'])}}" alt=""/></a>
                <input type="text" hidden  class="hidden" name="page_id" value="{{$pageID}}"/>
                <input type="text" hidden  class="hidden" name="page_type" value="{{$pageType}}"/>
                <div class="options" >
                    <input type="text" name="text" placeholder="Write a Comment"/>
                    <div class="file-upload-wrapper ">
                        <input class="upload-btn "  type="file"  id="uploadCommentImg" name="uploaded_file"/>
                        <label class="upload-label"  for="uploadCommentImg" >
                            <i class="label-icon fas fa-camera"></i>
                        </label>
                    </div>
                    <input type="submit"  hidden class="post-btn hidden" name="comment_btn" value="Comment"/>
                </div>
            </form>
            @foreach($comments as $comment)
                <?php $commentOwnerProfile= $comment->profile ; ?>
            <div class="comment flex-row">
                <div class="header " >
                    <div class="link-wrapper" >
                        <a href="{{route('profile.route',$commentOwnerProfile['user_id'])}}" class="image_text-link">
                            <img class="image" src="{{asset($commentOwnerProfile['path'].$commentOwnerProfile['image'])}}" alt=""/>
                        </a>
                    </div>
                </div>
                <div class="body flex-col">
                    <a href="{{$commentOwnerProfile['path'].$commentOwnerProfile['image']}}" class="text">{{$commentOwnerProfile['name']}}</a>
                    <p>
                      {{$comment['text']}}
                    </p>
                    @if($comment['image']!==null)
                        <div class="media ">
                            <img class="comment-img" src="{{$comment['image']}}" alt=""/>
                        </div>
                    @endif
                    <div class="comment-actions flex-row " contentID="{{$comment['id']}}">
                        <a class="text like @if($post['is_liked'])  liked @endif">Like</a>
                        <span>.</span>
                        <a class="text reply">Reply</a>
                        <span>.</span>
                        <a class="text time">2hr</a>
                    </div>
                    <div class="replys flex-col">
                        @foreach($comment->replys as $reply)
                            <?php $replyOwnerProfile= $reply->profile ; ?>
                            <div class="comment comment-reply flex-row">
                            <div class="header " >
                                <div class="link-wrapper" >
                                    <a href="{{route('profile.route',$replyOwnerProfile['user_id'])}}" class="image_text-link">
                                        <img class="image" src="{{$replyOwnerProfile['path'].$replyOwnerProfile['image']}}" alt=""/>
                                    </a>
                                </div>
                            </div>
                            <div class="body flex-col">
                                <a href="{{route('profile.route',$replyOwnerProfile['user_id'])}}" class="text">Ahmed Gamal</a>
                                <p>
                                   {{$reply['text']}}
                                </p>
                                @if($reply['image']!==null)
                                    <div class="media ">
                                        <img class="comment-img" src="{{$reply['image']}}" alt=""/>
                                    </div>
                                @endif
                                <div class="comment-actions flex-row " contentID="{{$reply['id']}}">
                                    <a class="text like">Like</a>
                                    <span>.</span>
                                    <a class="text">Reply</a>
                                    <span>.</span>
                                    <a class="text time">2hr</a>
                                </div>
                            </div>
                        </div>
                        @endforeach

                        <form class="new-comment flex-row align-items-center" id="addReplyForm"  method="POST" commentID="{{$comment['content_id']}}" action="{{route('addNewReply.route',$comment['id'])}}">
                            @include('errors')
                            @csrf
                            <a href="" ><img class="profile-icon circle-icon" src="{{$currentUserProfile['path'].$currentUserProfile['image']}}" alt=""/></a>
                            <input type="text" hidden  class="hidden" name="page_id" value="{{$pageID}}"/>
                            <input type="text" hidden  class="hidden" name="page_type" value="{{$pageType}}"/>
                            <div class="options" >
                                <input type="text" name="text" placeholder="Write a Comment"/>
                                <div class="file-upload-wrapper ">
                                    <input class="upload-btn "  type="file"  id="uploadReplyImg" name="uploaded_file"/>
                                    <label class="upload-label"  for="uploadReplyImg" >
                                        <i class="label-icon fas fa-camera"></i>
                                    </label>
                                </div>
                                <input type="submit"  hidden class="post-btn hidden" name="reply_btn" value="Comment"/>
                            </div>
                        </form>

                    </div>
                </div>
                <div class="footer">

                </div>
                <div class="menu">
                    <i class="icon fas fa-ellipsis-h"></i>
                </div>

            </div>
            @endforeach
        </div>
    </div>
        @endforeach
    @endif
</div>
