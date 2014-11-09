
//仿网易TabSwtich
$(function(){
	var iNow = 0;
	var time = null;
	var tabNum = $(".index li").size();
	
	//当前被mouseover的li的index给到iNow 进行变化 
	$(".index li").mouseover(function(){   
		iNow = $(this).index();             
		setTimeout(tabSwitch, 50);         
	});
	
	//自动播放
	time = setInterval(autoPlay,2000);  
	
	//hover开关定时器
	$("#tab").hover(function(){      		 
		clearInterval(time);
	},function(){
		time = setInterval(autoPlay,2000);   
	});

	//微博标签页效果
	$(".content div.weibo dl").hover(function(){
		$(this)
			.stop(true)                     	//快速移动鼠标，也就是快速改变dl对象的时候，上一次的dl立即结束动画 
	      	.animate({height:"141px"},200)      //当前被放上鼠标的dl开始展开到高度141px
	      	.css("background","#F7F7F7")       
	      	.find("dt a").css("font-weight","bold")
	      	.parent().parent()  					//返回this节点
			.siblings()                            	//this节点的兄弟节点 也就是其他的7个dl
	      	.stop(true)                        		//快速切其他7个dl 就要立刻结束7个dl之前的动画
			.animate({height:"46px"},200)          	//其他7个dl全部向46高度收缩
			.find("dt a").css("font-weight","");   	//其他7个dl的标题全部还原为不加粗  
	},function(){
		$(this).css("background","#fff");
	});	

	//根据不同的全局变量iNow进行标签切换
  	function tabSwitch(){
		$(".index li").attr("class","").eq(iNow).attr("class","active");
		$(".content div").hide().eq(iNow).show();
	}
	
	//定时循环变化iNow
	function autoPlay(){
		iNow++;                             
		if(iNow == tabNum){ 
			iNow =0;
		}
		tabSwitch();
	}

	//微博标签页效果方法二：
	//把布局改一下，每个dl下一个dt一个dd，当鼠标放上某个dl后，所有的dd全部slideUp，当前被放上鼠标的dd slideDowm

});

