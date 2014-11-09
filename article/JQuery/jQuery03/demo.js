
//仿淘宝无缝图片轮播
$(function(){
	var nImgLiWidth = $("#wrap").innerWidth();
	var nImgLiNum = $("#imgs li").size();    //5
	var nImgUlWidth = 2*nImgLiNum*nImgLiWidth;     //10*XX 为了无缝滚动 ul为2倍原ul
 	var iNow = 0;
 	var timer = null;
 	
 	//动态设置ul宽度 然后为了无缝滚动复制一个ul出来
	$("#imgs").css("width", nImgUlWidth+"px").html($("#imgs").html() + $("#imgs").html()); 

 	//点击1 2 3..变化iNow 形成轮播 
  	$("#buttons li").click(function(){
  		iNow = $(this).index();            	 
		scroll();
  	})

	//点击左右按键轮播  
	$(".next").click(function(){
		scrollLeft();
	}); 
	$(".prev").click(function(){
		scrollRight();
	}); 
 	
 	//自动轮播
	timer = setInterval(scrollLeft,2000);

	//hover启动停止自动轮播
	$("#wrap").hover(function(){
		clearInterval(timer);
		$("span").show();
	},function(){
		timer = setInterval(scrollLeft,2000);    
		$("span").hide();
	}); 

	//通过iNow++ 向左边轮播
	function scrollLeft(){						  
		if(iNow == nImgLiNum){   
			//准备移到第6张的时候 迅速用第0张替换           
			$("#imgs").css("left",0+"px");  	
			iNow = 0;
		}
		iNow++;                  					
		scroll();
	} 
	
	//通过iNow-- 向右边轮播
	function scrollRight(){
		if(iNow == 0){
			//准备移到第0张的时候 迅速用第6张替换 
			$("#imgs").css("left",-(nImgUlWidth/2)+"px"); 
			iNow = nImgLiNum;
		}
		iNow--;													
		scroll();
	} 
	
	//根据iNow 轮播
	function scroll(){
		$("#mark").html($("img").eq(iNow).attr("title"));
		$("#buttons li").attr("class","").eq(iNow).attr("class","active");
		$("#imgs").animate({left:-iNow*nImgLiWidth},300,"swing");
		//对于scrollLeft 会出现iNow = 5 此时没有eq(5) 将其换成eq(0)加上button颜色class   
		if(iNow == nImgLiNum){  
			$("#buttons li").eq(0).attr("class","active");   
		}
	}	

});



















