
//图片延迟加载
$(function(){
	//下拉 滚动条事件
	$(window).scroll(function(){
		//延迟100毫秒执行scroll事件 效果一样但是更平滑  
		setTimeout(function(){ 
			//尽量在each外面提取预存scrollTop等 如果在each内重复提取 浪费资源
			var scrollTop = $(window).scrollTop();  
			var windowHeight = $(window).height();   

			//每次scroll就循环每一张需要延迟加载的图片
			$('.dealy_load img').each(function(){
				//如果视窗高度加上滚动条高度大于此图片相对顶部偏移高度 也就是拖滚动条马上要看见图片的时候
				if((scrollTop + windowHeight) >= $(this).offset().top){
					//把图片的src替换成真正的图片地址
					$(this).attr('src', $(this).attr('xsrc'));
				}
			});
		}, 100);    
	});

});


