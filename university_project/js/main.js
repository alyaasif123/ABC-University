
function LikePost(id)
{
	$.ajax({
		url: 'like_dislike.php',
		type: 'POST',
		data: {
			id: id,
			type : 1,
		},
		error: function() {
			alert('An error has occurred');
		},
		dataType: 'json',
		success: function(data) {
			//data = JSON.parse(data);
			
			if (data['result'] != '' && data['count'] != '') {
				$('#dislike_'+id).removeClass('likeactive');
				$('#like_'+id).addClass('likeactive');
				$('#like_'+id+' span').html(data['like']);
				$('#dislike_'+id+' span').html(data['dislike']);
			}
		}
	});
}

function DislikePost(id)
{
	$.ajax({
		url: 'like_dislike.php',
		type: 'POST',
		data: {
			id: id,
			type : 2,
		},
		error: function() {
			alert('An error has occurred');
		},
		dataType: 'json',
		success: function(data) {
			//data = JSON.parse(data);
			
			if (data['result'] != '' && data['count'] != '') {
				$('#like_'+id).removeClass('likeactive');
				$('#dislike_'+id).addClass('likeactive');
				$('#like_'+id+' span').html(data['like']);
				$('#dislike_'+id+' span').html(data['dislike']);
			}
		}
	});
}

function viewPage(id)
{
	$.ajax({
		url: 'idea_view_count.php',
		type: 'POST',
		data: {
			id: id
		},
		error: function() {
			alert('An error has occurred');
		},
		dataType: 'json',
		success: function(data) {
			window.location.href = 'view_idea.php?idea='+id;
		}
	});
}

$(function () {
  $('[data-toggle="tooltip"]').tooltip();
});
