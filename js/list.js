
$(function(){

	$('.content_left .tabs li').click(function(){
		$('.content_left').children('div').eq($(this).index()).show().siblings('div').hide();
		$(this).addClass('active').siblings().removeClass('active');
	});

});
