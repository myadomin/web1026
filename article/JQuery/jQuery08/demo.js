
//表单美化
$(function(){
	
	//1：美化进度条
	var flag = true;
	$("#warp input").click(function(){
		//只准点击一次按钮 再次点击无效
		if(flag){                                       
			var allProgressWidth = $("#warp").width();
			var nWidth = 0;
			var nNum = 0;
			var timer = setInterval(function(){
				//定时器 nWidth每隔一段时间增加1%的总进度条长度的长度
				nWidth += allProgressWidth/100;            
				nNum += 1;
				if(nWidth == allProgressWidth){
					clearInterval(timer);
				}
			//定时器 每隔一段时间改变div #progress的width
		  	$("#progress").css("width",nWidth+"px");    
		  	$("#warp p span").html(nNum+"%");		
			},50);
		}
		flag = false;                                   
	});
	
	
	//2：美化上传
	$("#file_wrap span").click(function(){
		//点击已美化的span 就触发#unload的点击事件 相当于点击了被隐藏的type=file的input #unload
		$("#upload").click();                  
	});
	//每当#upload变化一次(点击上传一次) 就重新输出当前被上传的文件名
	$("#upload").change(function(){           
		var sVal = $("#upload").val();          
		$("#text").val(sVal);                   
	});
 	
 	
 	//3：美化radio单选
  	$("#radio_wrap div").click(function(){
  		//当第n个被美化的div被点击就 触发第n个radio input的点击事件 相当于第n个radio input被点击
  		$("#radio_wrap input").eq($(this).index()).click();
  		//当前被点击的div背景设为class="checking" 兄弟节点div class="" 模拟被点击                             
  		$(this).attr("class","checking").siblings().attr("class",""); 
  	});
  
  
  	//4：美化checkbox
  	$("#checkbox_wrap div").click(function(){
  		//当前第n个div被点击就触发第n个checkbox input的点击事件 相当于第n个checkbox input被点击
  		$("#checkbox_wrap input").eq($(this).index()).click();
  		//当前被点击的div背景toggleClass class="checking" 模拟被点击       
  		$(this).toggleClass("checking");                          
  	});
  
  
  	//5：美化select
	$("span").click(function(){ 
		//span区域点击的话 就让ul上拉下拉                               
		$("#select_wrap ul").slideToggle(50);
		return false;
	});
	$(document).click(function(){
		$("#select_wrap ul").slideUp(50);
	});
	//鼠标移入哪个li 就让哪个li变色 模拟option外观
	$("#select_wrap ul li").mouseover(function(){               
		$(this).css("background","#1ae").siblings().css("background","");
	})
	.click(function(){
		$("#select_wrap option").eq($(this).index()).click();	 	//第n个li点击 就触发第n个option的点击
		$("#select_wrap .content").text($(this).text());       		//第n个li点击 就输入第n个li的文本作为span.content的文本
		$(this).parent().hide();                                    //点击事件最后，隐藏ul
	});
  

});
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 



