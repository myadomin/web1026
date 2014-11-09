
//jquery插件开发原理
//一：jquery插件的基本结构 
/*;(function($){	//匿名函数自我执行并传参数 保证插件代码不污染其他文件js代码 同时内部能用$代替jQuery对象

	//插件代码		

})(jQuery);*/		//传入jQuery到参数$ 便于$在内部调用*/


//二：jQuery.extend(obj)添加全局的方法 后续调用时 $.xxx()  
//jQuery.fn.extend(obj)在DOM对象上添加方法 后续调用时 $('elem').xxx()


//三：编写一个下拉菜单插件 方法名nav 调用就是$('elem').nav()
;(function($){
	$.fn.extend({							//局部方法 添加在jQuery.fn.extend上
		nav: function(json){				//传入json 作为配置参数

			//默认参数
			options = {						
				"color" : 'orange', 
				"background" : 'red', 
				"sec" : 1500
			};

			//配置参数覆盖默认参数
			for(var attr in json){		
				//json配置参数传入的key如果有就覆盖默认参数的key-value 没有就用默认参数的key-value	
				options[attr] = json[attr];	
			}

			//功能实现
			$('.nav').css({					
				"display":"none"
			}).parent().hover(function(){	
				//多次移入移出 stop清除上一次运动
				$(this).find('.nav').stop().slideDown(options.sec);
			},function(){
				$(this).find('.nav').stop().slideUp(options.sec);
			}).find('li').css({
				"color": options.color,
				"background": options.background
			});

			//最终返回jQuery对象 保证链式调用方法
			// alert(this instanceof jQuery);
			return this;					
		}
	});
})(jQuery);



