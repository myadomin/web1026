
//商品放大镜
$(function(){

//所有图片 具备放大镜效果
$("#pic").hover(function(ev){
	//鼠标放上图片后 显示遮罩层 显示大图
	$(this).find("span").show(); 	                         
	$("#big_pic_wrap").show();
	
	$(document).mousemove(function(ev){                    
		var nPicoffsetLeft = $("#pic").offset().left;
		var nPicoffsetTop = $("#pic").offset().top;
		var nSpanWidth = $("#pic span").width();
		var nSpanHeight = $("#pic span").height();
		var nPicWidth = $("#pic").width();
		var nPicHeight = $("#pic").height();
		var nBigPicWidth = $("#big_pic_wrap img").width();
		var nBigPicHeight = $("#big_pic_wrap img").height();
		var nBigWrapWidth = $("#big_pic_wrap").width();
		var nBigWrapHeight = $("#big_pic_wrap").height();
		var nLeft = ev.pageX - nPicoffsetLeft - nSpanWidth/2;
		var nTop = ev.pageY - nPicoffsetTop - nSpanHeight/2;

		//限制拖拽范围
		if(nLeft < 0){
			nLeft = 0;
		}
		if(nLeft > nPicWidth - nSpanWidth){
			nLeft = nPicWidth - nSpanWidth;
		}
		if(nTop < 0){
			nTop = 0;
		}
		if(nTop > nPicHeight - nSpanHeight){
			nTop = nPicHeight - nSpanHeight;
		}

		//遮罩层的拖拽
		$("#pic span").css({left:nLeft+"px",top:nTop+"px"}); 

		//大图移动和遮罩层的移动成一定比例
		var nBigLeft = -(nBigPicWidth-nBigWrapWidth)/(nPicWidth-nSpanWidth)*nLeft;       
		var nBigTop = -(nBigPicHeight-nBigWrapHeight)/(nPicHeight-nSpanHeight)*nTop;
		$("#big_pic_wrap img").css({left:nBigLeft+"px",top:nBigTop+"px"});                
	});
},function(){
	$(this).find("span").hide();
	$("#big_pic_wrap").hide();
});


//tabSwtich 匿名函数自我执行 创建私有作用域  
(function(){       			 
	var iNow = 0;          
	var iBtn = 0;
	var liWidth = $(".tab_wrap ul li").innerWidth();
	var liNum = $(".tab_wrap ul li").size();

	 //当前被放上鼠标的小图 记录index 再执行tab函数
	$(".tab_wrap ul li").mouseover(function(){
		iNow = $(this).index();                     
		tab(iNow);
	})

	//点击的按钮 移动小图位置 同时改变iNow 以改变图片及小图边框
	$(".next").click(function(){	                
		if(iNow == liNum-1){    //限定iNow最大到5
			iNow = liNum-2;
		}
		iNow++;
		tab(iNow);

		if(iBtn >= 2){      	//限定点击按钮2次到头后跳出函数
			return;
		}
		iBtn++;
		$(".tab_wrap ul").animate({left:-iBtn*liWidth+"px"},100);
	})
	
	//点击的按钮 移动小图位置 同时改变iNow 以改变图片及小图边框
	$(".prev").click(function(){
		if(iNow == 0){
			iNow = 1;
		}
		iNow--;
		tab(iNow);

		if(iBtn == 0){
			return;
		}
		iBtn--;
		$(".tab_wrap ul").animate({left:-iBtn*liWidth+"px"},100);
	});

})();


//根据iNow做tab切换
function tab(iNow){
	$(".tab_wrap ul li").attr("class","").eq(iNow).attr("class","active");
	$("#pic img").hide().eq(iNow).show();
	$("#big_pic_wrap img").hide().eq(iNow).show();
}
 
});
 
 
