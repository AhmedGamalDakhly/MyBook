//JQUERY coding
$(document).ready(function(){
	// new post section
	$(".hidden").hide();
	$("#newpost-text").focus(function(){
		$("#newpost-text").animate({height: '100px'},"slow");
		$(".hidden").fadeIn("slow");
		$(".hidden").animate({right: '100px'},"slow");

	});

	// like button

	$(".like-btn").click(function(){
		var myParent=$(this).parents(".post-footer");
		var post_id=$(this).parents().attr("data");
		let targetURL="like_handle.php";
		let likeBtn=$(this);
		$.post(
		targetURL,
		{
			content_id:post_id,
			type:"post"
		},
		function(respnseTxt,statusTxt){
			let contentData=jQuery.parseJSON(respnseTxt);
			//console.log(contentData.like_count);
		//	console.log(contentData);
			let likeCounter=myParent.children(".post-meta").find(".like-count");
			likeCounter.text(contentData.like_count);
			let liked = jQuery.parseJSON(contentData.current_user_like);
			if(liked){
				likeBtn.children().addClass("liked");
			}else{
				likeBtn.children().removeClass("liked");
			}
		}
		);

	});

		// delete post
	$(".delete-btn").click(function(){
		let myParent=$(this).parents(".post-box");
		let postID=myParent.attr("value");
		let targetURL="delete_post_handle.php";
		let deleteBtn=$(this);
		$.post(
		targetURL,
		{
			post_id:postID,
			type:"post"
		},
		function(respnseTxt,statusTxt){
			//let responseData=jQuery.parseJSON(respnseTxt);
			//console.log(contentData.like_count);
				myParent.remove();
				console.log(respnseTxt);

			}
		);

	});

	//like comment
		$(".like-comment").click(function(){
		var myParent=$(this).parents(".comment-actions");
		var post_id=myParent.attr("data");
		let targetURL="like_handle.php";
		let likeComment=$(this);
		$.post(
		targetURL,
		{
			content_id:post_id,
			type:"comment"
		},
		function(respnseTxt,statusTxt){
			let contentData=jQuery.parseJSON(respnseTxt);
			//console.log(contentData.like_count);
		//	console.log(contentData);
			let likeCounter=likeComment.children("span");
			likeCounter.text(contentData.like_count);
			let liked = jQuery.parseJSON(contentData.current_user_like);
			if(liked){
				likeComment.addClass("liked");
			}else{
				likeComment.removeClass("liked");
			}
		}
		);

	});







});
