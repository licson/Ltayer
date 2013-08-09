$(document).on('pageinit',function(){
	$('a[data-id]').on('tap',function(e){
		e.preventDefault();
		$.mobile.changePage('app.php?id='+$(this).attr('data-id'),true);
	});
});