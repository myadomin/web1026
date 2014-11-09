
//无缝滚动
$(function(){
	var nLiWidth = $("#scroll li").innerWidth();     //li有padding 所以用innerWidth
	var nLiNum = $("#scroll li").size();             //获取li的个数
	var nUlWidth = 2*nLiNum*nLiWidth;                 
	var nDivWidth = nLiNum*nLiWidth;                
	var oUl = $("#scroll");
	var oDiv = $("#wrap");
	var iLeft = 0;
	var iSpeed = -2;
	var time = null;

	//动态让ul的宽度为2倍的li个数乘以li宽度 动态设置div宽度
  	oUl.css({width:nUlWidth+"px"});   
	oDiv.css({width:nDivWidth+"px"});   

	//复制一份ul在原ul后面 产生新ul便于后续无缝滚动
	oUl.html(oUl.html() + oUl.html())   
	
	//点击改变速度正负 从而改变运动方向						
	$("#left").click(function(){      
		iSpeed = -Math.abs(iSpeed);
	})
	$("#right").click(function(){
		iSpeed = Math.abs(iSpeed);
	})

	//自动轮播
	time = setInterval(scroll,10);
	
	//hover启动停止轮播
	oUl.hover(function(){
		clearInterval(time);
	},function(){
		time = setInterval(scroll,10);
	});
	
	//轮播
  	function scroll(){
  		//每次循环 都获取一次当前的left值
	  	var NowLeft = parseInt(oUl.css("left"));      
		//判断当前的left值 
		if(NowLeft <= -nUlWidth/2){    //左移动 如果走到新ul一半的时候 迅速拉回到前一半ul             
			iLeft = 0;
		}else if(NowLeft >=0){
			iLeft = -nUlWidth/2;		//右移动 一开始就迅速拉到后一半ul 
		}
		//每次循环 iLeft在自身上累加一次速度 也就是匀速运动
		iLeft += iSpeed;                              
		oUl.css({left:iLeft+"px"});	
	}

});

