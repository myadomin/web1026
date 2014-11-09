
//窗口永远居中
//1：$(window).width() 当前可视窗口的大小 可视窗口变大变小($(window).resize触发)他也会变大变小。
//2：$(document).width() 当前整个文档的大小 在这里body设置为宽度2400 所以他永远是2400 
//3：$(window).scrollLeft() 窗口的滚动条左距离 拖动滚动条可以触发$(window).scroll 
//4：outerWidth() innerWidth() Width()
//5：通过stop(true)只保留最后一次animate
//6：ev.pageX就是鼠标点击位置相对当前窗口(窗口缩放也可以)的横坐标(把滚动条距离也算进去了)。
//7：原生js的oEvent.clientX也是鼠标点击位置相对当前窗口(窗口缩放也可以)的横坐标，但是没有算进去滚动条距离
//8：$(this).offset().left就是当前对象绝对定位后相对于相对定位父级的左距离
$(function(){

	//刷新进入页面 就让框体居中
	center(); 


	//resize scroll触发居中
	$(window)
		.resize(function(){      	//一旦窗口大小变化 就执行一次center(),获取最新$(window).width()
			center();
		})
		.scroll(function(){     	//一旦滚动 就执行一次center(),获取最新的$(window).scrollLeft()
			center();
		});


	//居中
	function center(){
		var nLeft = ($(window).width()-$("#box").outerWidth())/2 + $(window).scrollLeft();   
		var nTop = ($(window).height()-$("#box").outerWidth())/2 + $(window).scrollTop(); 
		//scroll会快速叠加很多animate，通过stop(true)只保留最后一次animate   
		$("#box").stop(true).animate({left:nLeft+"px",top:nTop+"px"},100,"linear");  	 
	}
	
	
	//点击按钮显示 点击X关闭
	$("#button").click(function(){
		$("#box").show();
	})
	.next().find("h4 a").click(function(){
		$("#box").hide();
	});
	

	//拖拽弹窗 限制在当前窗口
	$("#box h4").mousedown(function(ev){            
		var disX = ev.pageX - $(this).offset().left;   
		var disY = ev.pageY - $(this).offset().top;   
		
		$(document).mousemove(function(ev){
			var iLeft = ev.pageX - disX;                
			var iTop = ev.pageY - disY;  
			//限制在当前窗口             
			if(iLeft < $(window).scrollLeft()){          
				iLeft = $(window).scrollLeft();
			}
			if(iLeft > $(window).width() - $("#box").outerWidth() + $(window).scrollLeft()){  
				iLeft = $(window).width()-$("#box").outerWidth() + $(window).scrollLeft();   
			}
			if(iTop < $(window).scrollTop()){
				iTop = $(window).scrollTop();
			}
			if(iTop > $(window).height() - $("#box").outerHeight() + $(window).scrollTop()){    
				iTop = $(window).height()-$("#box").outerHeight() + $(window).scrollTop();       
			}
			$("#box").css({left:iLeft+"px",top:iTop+"px"});
		});
		
		$(document).mouseup(function(){
			$(document).unbind();
		});	
	})
	.parent().mousedown(function(){         
		return false;
	});
	

});


