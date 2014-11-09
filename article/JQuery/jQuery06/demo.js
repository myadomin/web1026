
//拖拽模拟滚动条
$(function(){

//函数调用	
drag($("#top_block"));        	//让上面滚动条里面的块体可以被拖拽，同时移动文本
drag($("#right_block"));      	//让右边滚动条里面的块体可以被拖拽，同时移动文本
wheel($("#right_block"));     	//让右边滚动条里面的块体跟随鼠标滚轮移动，同时移动文本


//拖拽函数
function drag(obj){
	var rightBarHeight = parseInt($("#right_bar").height());                                   //右边滚动条高度
	var rightBarHeightRange = parseInt($("#right_bar").height()-$("#right_block").height());   //右边滚动块体可以移动的高度
	var txtHeight = parseInt($("#txt").height());                                              //文本整体高度	
	var topBarWidth = parseInt($("#top_bar").width());                                         //上边滚动条宽度
	var topBarWidthRange = parseInt($("#top_bar").width()-$("#top_block").width());            //上边滚动块体可以移动的宽度
	var txtWidth = parseInt($("#txt").width());                                                //文本整体宽度
	
	obj.mousedown(function(ev){
		var disX = ev.pageX - $(this).offset().left;
		var disY = ev.pageY - $(this).offset().top;
		_this = this;

		$(document).mousemove(function(ev){
			var barOffsetLeft = obj.parent().offset().left;   //为了让两个滚动条共用这一个drag函数，这里不能写死滚动条的左边距，
			var barOffsetTop = obj.parent().offset().top;     //只能用参数传进来的当前对象的父节点的滚动条左边距
			var barWidth = obj.parent().width();              //滚动条宽度高度，拖拽块体的宽度高度，用同样的方法，不能写死
			var barHeight = obj.parent().height();
			var blockWidth = obj.width();
			var blockHeight = obj.height();
			var nLeft = ev.pageX - barOffsetLeft - disX;
			var nTop = ev.pageY - barOffsetTop - disY;
			
			if(nLeft < 0){
				nLeft = 0;
			}
			if(nLeft > barWidth - blockWidth){     		//限定块体的拖拽范围
				nLeft = barWidth - blockWidth;
			}
			if(nTop < 0){
				nTop = 0;
			}
			if(nTop > barHeight - blockHeight){
				nTop = barHeight - blockHeight;
			}
			obj.css({left:nLeft+"px",top:nTop+"px"});  	//拖拽块体移动

			if(obj.attr("id") == "top_block"){   		//只移动上面的滚动条的时候 
				var txtLeft = ((txtWidth-topBarWidth+blockWidth)/topBarWidthRange)*nLeft;   //文本的left与上边滚动块体的left成一定比例
				var txtTop = _this.upTop;                //上下距离保持上一次右边滚动条拖拽抬起时的位置
				$("#txt").css({left:-txtLeft+"px",top:txtTop+"px"});
			}
			if(obj.attr("id") == "right_block"){   		 //只移动右边的滚动条的时候
				var txtLeft = _this.upLeft;              //左右距离保持上一次上面滚动条拖拽抬起时的位置
				var txtTop = ((txtHeight-rightBarHeight)/rightBarHeightRange)*nTop;         //文本的top与右边滚动块体的top成一定比例
				$("#txt").css({left:txtLeft+"px",top:-txtTop+"px"});
			}	

			return false;                           	 
		})
		.mouseup(function(){
			_this.upLeft = $("#txt").css("left");   	 //每次鼠标抬起时，记录当前的left top位置，为下一次拖拽的txtLeft txtTop做准备
			_this.upTop = $("#txt").css("top");     	 //如果这里用var 那下一次txtLeft就不认识upLeft了，所以用_this.upLeft，既能下一次认识，又不污染全局    
			$(this).unbind();
		}); 

		return false;	                              	 //阻止默认事件 阻止按下后选中文本
	});
}


//鼠标滚轮
function wheel(obj){
	var iSpeed = 10;
	var rightBarHeight = parseInt($("#right_bar").height());                                        //右边滚动条高度
	var rightBarHeightRange = parseInt($("#right_bar").height()-$("#right_block").outerHeight());   //右边滚动块体可以移动的高度
	var txtHeight = parseInt($("#txt").height());                                                   //文本整体高度
	
	$("#box").mousewheel(function(ev,d){ 	      	//应用插件，第一个ev参数，第二个d参数(鼠标滚轮往上为1，鼠标滚轮往下为-1)
		var blockTop = parseInt(obj.css("top"));    //一旦鼠标滚轮事件开始 滚动块体top初始值就是他当前的top值，
		if(d == 1){                                 //注意如果css中不写top，那IE第一次读取top是NaN，所以必须写
			blockTop = blockTop - iSpeed;           //往上滚轮一次，右边的滚动块体往上移动10
			if(blockTop <= 0){                      //滚动块体Top小于0就为0
				blockTop = 0;
			}	
		}
		if(d == -1){                                              
			blockTop = blockTop + iSpeed;        	//往下滚轮一次，右边的滚动块体往下移动10
			if(blockTop >= rightBarHeightRange){    //滚动块体Top大于他可以移动的高度，就为他可以移动的高度
				blockTop = rightBarHeightRange;
			}	 
		}
		
		$("#right_block").css("top",blockTop+"px");	//设置右边滚动块体的top
		
		var txtTop = ((txtHeight-rightBarHeight)/rightBarHeightRange)*blockTop;   //文本的top与右边滚动块体的top成一定比例 
		$("#txt").css("top",-txtTop);
		
		$("input").val(d);	

		return false;   	//一旦在$("#box")范围内开始触发鼠标滚轮事件 就阻止掉浏览器窗口的鼠标滚轮事件
	});
}
	 

});
 

