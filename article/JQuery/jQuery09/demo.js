
//图片放大效果 
$(function(){

	//1：图片放大的原理 
	//宽度增加100的同时就marginLeft -50px,高度增加100的同时就marginTop -50px
	//必须保证width的增加和marginLeft的变化统一在一个固定时间内同时完成 才会平滑 
	$("#more_bigger").mouseover(function(){
		//每次animate前通过stop立刻停止上一次的动画
		$(this).stop().animate({"width":"200px", "marginLeft":"-50px", "height":"200px", "marginTop":"-50px"} ,200);
	}).mouseout(function(){
		$(this).stop().animate({"width":"100px", "marginLeft":"0px", "height":"100px", "marginTop":"0px"} ,200);
	});
	

	//2：多张图片的放大 函数整体封装
	//如果要被放大的图片不挤压其他的图片 那么图片必须是绝对定位脱离文档流。 
	//#img_test通过左浮排列好了9张图片，不可能对着9张一张张去做绝对定位（假如1000张那更不可能）
	//通过原生JS的offsetLeft或者JQ的相对父级距离position().left进行浮动转绝对定位
	//封装成函数  
	/**
	 * objs 要被放大的对象们
	 * rate 放大的倍数
	 * nSpeed 被放大的速度
	 */
	function enlarge(objs, rate, speed){
		var iZIndex = 1;

		//将浮动变成绝对定位 脱离文档流
		objs.each(function(){
			var nLeft = $(this).position().left + parseInt($(this).css('marginLeft'));
			var nTop = $(this).position().top + parseInt($(this).css('marginTop'));

			//设置left top的css值，注意这里的left top值要加上marginLeft marginTop的值 因为后续要全部清掉margin
			$(this).css({"left": nLeft+'px', "top": nTop+'px'}).html(nLeft +"||"+ nTop) ;

			//预存各对象的原始的宽度高度值 预存为当前对象的nWidth nHeight属性
			$(this).attr('nWidth', parseInt($(this).width()));
			$(this).attr('nHeight', parseInt($(this).height()));
		})
		.each(function(){
			//必须重新开一个循环 在这个循环里绝对定位 然后清除所有margin
			$(this).css({"position": "absolute", "margin": "0px"});
		})
		.hover(function(){
			var nToWidth = rate * $(this).attr('nWidth');
			var nMarginLeft = (nToWidth - $(this).attr('nWidth'))/2;
			var nToHeight = rate * $(this).attr('nHeight');
			var nMarginTop = (nToHeight - $(this).attr('nHeight'))/2;
			
			//当前被hover的z-index永远最大 按rate比例进行放大
			$(this).css({'zIndex': iZIndex++})
			.stop().animate({
				'width': nToWidth + 'px',
				'marginLeft': -nMarginLeft + 'px',
				'height': nToHeight + 'px',
				'marginTop': -nMarginTop + 'px'
			}, speed);
		},function(){
			var nToWidth = 1 * $(this).attr('nWidth')
			var nMarginLeft = 0;
			var nToHeight = 1 * $(this).attr('nHeight');
			var nMarginTop = 0;
			
			//回复到原始的宽度高度
			$(this).stop().animate({
				'width': nToWidth + 'px',
				'marginLeft': -nMarginLeft + 'px',
				'height': nToHeight + 'px',
				'marginTop': -nMarginTop + 'px'  
			}, speed);
		});
	}

	//应用到$("#img_test li")上 放大2.5被 放大速度是200毫秒完成
	enlarge($("#img_test li"), 2.5, 200);
	// bigger($("#img_test li"), 2.5, 200);

	//应用到$("#img_show li img")上 放大2.5被 放大速度是300毫秒完成
	enlarge($("#img_show li img"), 2.0, 300);
	// bigger($("#img_show li img"), 2.0, 300);


	//3: 用css3实现
	function bigger(objs, rate, speed){
		var iZIndex = 1;
		objs.css('transition', speed/1000 + 's linear')
		.hover(function(){
			$(this).css({'zIndex': iZIndex++, 'transform': 'scale(' + rate + ', ' + rate +')'});
		},function(){
			$(this).css('transform', 'scale(1, 1)');
		});
	}

});


