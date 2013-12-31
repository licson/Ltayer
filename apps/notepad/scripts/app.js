$(function(){
	$("#new_title").change(function(){
		$("#w_file_name h1").text($("#new_title").val());
	});
});