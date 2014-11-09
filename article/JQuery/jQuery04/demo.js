
//各种下拉菜单
$(function(){

//一：测试按钮部分 -----------------------------------------------------------------
$("#show input").click(function(){
	var num = $(this).index();
	//传参为true 就清除这个函数的所有事件 
	dropDown1(1);            
	dropDown2(1);            
	dropDown3(1);
	dropDown4(1);
	//清除所有jquery函数的遗留事件
	$("#menu div ul").unbind();  
	$("#menu div").unbind();
	$(document).unbind();
	//css设置还原到刚刷新进页面的初始值
	$("#menu div ul").css({display:"none",height:"auto",overflow:"visible"});  
	switch(num){
		case 1:
			dropDown1();
			$("span").html("原生JS函数dropDown1：鼠标移入移出，菜单缓冲型下拉，缓冲引入自己写的move.js")
			break;
		case 2:
			dropDown2();
			$("span").html("原生JS函数dropDown2：鼠标点击，菜单缓冲型下拉,缓冲引入自己写的move.js")
			break;
		case 3:
			dropDown3();
			$("span").html("原生JS函数dropDown3：鼠标移入移除，菜单显示隐藏")
			break;
		case 4:
			dropDown4();
			$("span").html("原生JS函数dropDown4：鼠标点击，菜单显示隐藏")
			break;
		case 5:
			dropDown5();
		  $("span").html("jquery函数dropDown5：鼠标移入移出，菜单弹型下拉，弹性引入JQ的jquery.easing.1.3.js")
		break;
		case 6:
			dropDown6();
		  $("span").html("jquery函数dropDown6：鼠标点击，菜单延时缓冲下拉，缓冲引入JQ的jquery.easing.1.3.js")
		break;
		case 7:
			dropDown7();
		  $("span").html("jquery函数dropDown7：鼠标移入移除，菜单显示隐藏")
		break;
		case 8:
			dropDown8();
		  $("span").html("jquery函数dropDown8：鼠标点击，菜单显示隐藏")
		break;
	}	
})



//二：原生js实现各类型菜单(html及css共用一套，所以css ul的height,overflow,display都js动态设置) -----------------
//dropDown1：鼠标移入移出，菜单缓冲型下拉，js中设置css ul height:0同时overflow:hidden，通过js把各ul的height值缓冲型增大从而形成下拉效果
//dropDown2：鼠标点击，菜单缓冲型下拉，下拉效果同上，注意阻止冒泡。
//dropDown3：鼠标移入移除，菜单显示隐藏
//dropDown4：鼠标点击，菜单显示隐藏
function dropDown1(flag){
	var oDiv = document.getElementById("menu");
	var aDiv = oDiv.getElementsByTagName("div");
	for(var i=0 ; i<aDiv.length ; i++){
		var oUl = aDiv[i].getElementsByTagName("ul")[0]; 

		//预存当前ul的高度  
		oUl.style.display = "block";             //css默认的是display:none 需要先block才能正确得到offsetHeight  
		oUl.style.height = "auto";               //每一次循环开始 这里不能写死具体是多少高度 每个ul都不同 所以用auto 各个ul该是多少就是多少 
		var iHeight = oUl.offsetHeight;          //只有ul显示的时候 才会有offsetHeight 所以上面先让他显示 这里在得到他的实际高度  
		oUl.style.height = "0px";                //得到后 ul继续高度为0
		oUl.style.overflow = "hidden";           //然后ul溢出隐藏
		oUl.height = iHeight;                    //每一次循环 都把当前的oUl对象的height属性设置为这次循环得到的当前oUl对象的实际高度
		
		//hover事件
		aDiv[i].onmouseover = function(ev){	
			var oUl = this.getElementsByTagName("ul")[0];
			//当前被鼠标放上去的oUl对象的实际高度 通过上面预存的height属性取出来 
			bufferMove(oUl,{"height":oUl.height});    
		}
		aDiv[i].onmouseout = function(){
			var oUl = this.getElementsByTagName("ul")[0];
			bufferMove(oUl,{"height":0});
		} 	
		
		//如果传参为true 就清除这个函数的所有事件
		if(flag){
			aDiv[i].onmouseover = null;    
			aDiv[i].onmouseout = null;
		}		
	}
}


function dropDown2(flag){
	var oDiv = document.getElementById("menu");
	var aDiv = oDiv.getElementsByTagName("div");
	for(var i=0 ; i<aDiv.length ; i++){
		var oUl = aDiv[i].getElementsByTagName("ul")[0];    
		
		//预存当前ul的高度  
		oUl.style.display = "block";           
		oUl.style.height = "auto";               
		var iHeight = oUl.offsetHeight;            
		oUl.style.height = "0px";              
		oUl.style.overflow = "hidden";         
		oUl.height = iHeight;                    
		
		//点击事件
		aDiv[i].onclick = function(ev){
			hideAll();                                	//先隐藏所有菜单
			var oUl = this.getElementsByTagName("ul")[0]; 
			var oEvent = ev||event;      
			bufferMove(oUl,{"height":oUl.height});     	//点击的oUl对象的实际高度 通过上面预存的height属性取出来
			oEvent.cancelBubble = true;               	//阻止冒泡到document
		}
		
		//除了3个点击区域 点击任何区域都隐藏
		document.onclick = function(){
			hideAll();                               
		} 

		//隐藏所有ul
		function hideAll(){
			var aUl = oDiv.getElementsByTagName("ul"); 
			for(var i=0 ; i<aUl.length ; i++){
				bufferMove(aUl[i],{"height":0});
			}
		}

		//如果传参为true 就清除这个函数的所有事件
		if(flag){
			aDiv[i].onclick = null;
			document.onclick = null;
		}	
	}
}


function dropDown3(flag){
	var oDiv = document.getElementById("menu");
	var aDiv = oDiv.getElementsByTagName("div");
	for(var i=0 ; i<aDiv.length ; i++){
		aDiv[i].getElementsByTagName("ul")[0].style.display = "none";   
		
		aDiv[i].onmouseover = function(){
			var oUl = this.getElementsByTagName("ul")[0];
			oUl.style.height = "auto";          
			oUl.style.display = "block";
			
			var aLi = oUl.getElementsByTagName("li");
			for(var i=0 ; i<aLi.length ; i++){
				aLi[i].onmouseover = function(){
					this.style.background = "#ccc";
				}
				aLi[i].onmouseout = function(){
					this.style.background = "#fff";
				}
			}
		}
		
		aDiv[i].onmouseout = function(){
			var oUl = this.getElementsByTagName("ul")[0];
			oUl.style.display = "none";
		}
		
		if(flag){
			aDiv[i].onmouseover = null;
			aDiv[i].onmouseout = null;
		}		
	}
}


function dropDown4(flag){
	var oDiv = document.getElementById("menu");
	var aDiv = oDiv.getElementsByTagName("div");
	for(var i=0 ; i<aDiv.length ; i++){
		aDiv[i].getElementsByTagName("ul")[0].style.display = "none";   
		
		aDiv[i].onclick = function(ev){
			hideAll();
			var oUl = this.getElementsByTagName("ul")[0];
			oUl.style.height = "auto";     
			oUl.style.display = "block";
			var oEvent = ev||event;
			oEvent.cancelBubble = true;
		}
		
		document.onclick = function(){
			hideAll();
		}
		
		if(flag){
			aDiv[i].onclick = null;
			document.onclick = null;
		}	
		
		function hideAll(){
			var aUl = oDiv.getElementsByTagName("ul");  //隐藏所有ul
			for(var i=0 ; i<aUl.length ; i++){
				aUl[i].style.display = "none";
			}
		}
	}
}



//三：jquery实现各类型菜单---------------------------------------------------------
//dropDown5：鼠标移入移出，菜单弹性下拉，缓冲引入JQ的jquery.easing.1.3.js 
//dropDown6：鼠标点击，菜单缓冲型下拉， 
//dropDown7：鼠标移入移除，菜单显示隐藏
//dropDown8：鼠标点击，菜单显示隐藏
//引入query.easing.1.3.js 在时间参数后面加上相应easing参数(必须先写时间参数，后面再写easing参数才有效果)
 
function dropDown5(){
	$("#menu div").hover(function(){ 
	  	$(this).find("ul").slideDown(1000,'easeInOutElastic');
	},function(){
		//如果快速移入移出 也只保留最后一次的移入移出 之前的动画队列全部被sotp清空
		$(this).find("ul").stop(true).slideUp(1000,'easeOutElastic');  
	});
}

function dropDown6(){
	$("#menu div").click(function(){
		$(this).find("ul").slideDown(500,"easeOutBack")  	//3：当前被点击的这个div区域的ul菜单slideDown
		.parent().siblings("div").find("ul").slideUp(500,"easeInBack");   //4：其他的div区域的ul菜单全部上拉，siblings("div")就是除了当前div的同级兄弟div
	  	return false;                           			//2：阻止冒泡 三个div区域点击不触发下面的菜单上拉 
	})
	$(document).click(function(){                 
		$("#menu div ul").slideUp(500,"easeInBack");		//1：点击任何区域都是菜单上拉
	})
}

function dropDown7(){
	$("#menu div").hover(function(){ 
	  	$(this).find("ul").show();
	},function(){
		$(this).find("ul").hide();   
	});
}

function dropDown8(){
	$("#menu div").click(function(){
		$(this).find("ul").show()
		.parent().siblings("div").find("ul").hide();
		return false;
	});
	$(document).click(function(){
		$("#menu div ul").hide();
	})
}
 
 

//四：面向对象写法 --------------------------------------------------------------
//DropDown1：鼠标移入移出，菜单缓冲型下拉， 
//DropDown2：鼠标点击，菜单缓冲型下拉， 
//DropDown3：鼠标移入移除，菜单显示隐藏
//DropDown4：鼠标点击，菜单显示隐藏
	
//实例化
//var dropDown = new DropDown1("menu");
//var dropDown = new DropDown2("menu");
//var dropDown = new DropDown3("menu");
//var dropDown = new DropDown4("menu");
//var dropDown = new DropDown1("other_menu");
//var dropDown = new DropDown2("other_menu");
//var dropDown = new DropDown3("other_menu");
var dropDown = new DropDown1("other_menu");

function DropDown1(id){
	var oDiv = document.getElementById(id);
	this.aDiv = oDiv.getElementsByTagName("div");
	_this = this;  
	
	for(var i=0 ; i<this.aDiv.length ; i++){
		var oUl = this.aDiv[i].getElementsByTagName("ul")[0]; 
		oUl.style.display = "block";            
		oUl.style.height = "auto";                                                                                                                   
		oUl.height = oUl.offsetHeight;                                                                                                              
		oUl.style.height = "0px";                                                                                                                    
		oUl.style.overflow = "hidden";                                                                                                                                                                                                                         
	  
		this.aDiv[i].onmouseover = function(){
			_this.higher(this);
		}
		this.aDiv[i].onmouseout = function(){
			_this.lower(this);
		} 		
	}
}
DropDown1.prototype.higher = function(theMouseoverDiv){	
	var oUl = theMouseoverDiv.getElementsByTagName("ul")[0]; 
	bufferMove(oUl,{"height":oUl.height});     
}
DropDown1.prototype.lower = function(theMouseoutDiv){	
	var oUl = theMouseoutDiv.getElementsByTagName("ul")[0]; 
	bufferMove(oUl,{"height":0});     
}


function DropDown2(id){
	var oDiv = document.getElementById(id);
	this.aDiv = oDiv.getElementsByTagName("div");
	var _this = this;
	for(var i=0 ; i<this.aDiv.length ; i++){
		var oUl = this.aDiv[i].getElementsByTagName("ul")[0];   
		oUl.style.display = "block";              
		oUl.style.height = "auto";                 
		oUl.height = oUl.offsetHeight;               
		oUl.style.height = "0px";                
		oUl.style.overflow = "hidden";           
		
		this.aDiv[i].onclick = function(ev){
			_this.higher(ev,this,oDiv);      //ev this oDiv分别一一对应higher的ev theClickDiv oDiv
		}
		document.onclick = function(){
			_this.hideAll(oDiv);             //hideAll方法需要传递oDiv对象给到hideAll函数               
		} 
	}
}
DropDown2.prototype.higher = function(ev,theClickDiv,oDiv){
	this.hideAll(oDiv);                          //接受了上面的oDiv 再传递给hideAll
	var oUl = theClickDiv.getElementsByTagName("ul")[0];
	bufferMove(oUl,{"height":oUl.height});     
	this.oEvent = ev||event;          
	this.oEvent.cancelBubble = true;              
}
DropDown2.prototype.hideAll = function(oDiv){         
	this.aUl = oDiv.getElementsByTagName("ul");  //oDiv在构造函数中是局部变量 需要通过_this.higher(ev,this,oDiv); _this.hideAll(oDiv)传递过来
	for(var i=0 ; i<this.aUl.length ; i++){
		bufferMove(this.aUl[i],{"height":0});
	}
}
		
		 
function DropDown3(id){
	var oDiv = document.getElementById(id);
	this.aDiv = oDiv.getElementsByTagName("div");
	var _this = this;
	for(var i=0 ; i<this.aDiv.length ; i++){
		this.aDiv[i].getElementsByTagName("ul")[0].style.display = "none";   //隐藏所有菜单
		this.aDiv[i].onmouseover = function(){   
			_this.show(this);                     
		}
		this.aDiv[i].onmouseout = function(){
			_this.hide(this);
		}	
	}
}
DropDown3.prototype.show = function(theMouseoverDiv){     		//每次show()函数调用 参数都是当前被mouseover的div
	var oUl = theMouseoverDiv.getElementsByTagName("ul")[0];  	//当前被mouseover的div下的第一个ul
	oUl.style.display = "block";
	
	var aLi = oUl.getElementsByTagName("li");   	//当前被mouseover的div下的所有li进行移入移出变色 这一层不准备再写一层了
	for(var i=0 ; i<aLi.length ; i++){
		aLi[i].onmouseover = function(){
			this.style.background = "#ccc";
		}
		aLi[i].onmouseout = function(){
			this.style.background = "#fff";
		}
	}
}
DropDown3.prototype.hide = function(theMouseoutDiv){
	var oUl = theMouseoutDiv.getElementsByTagName("ul")[0];
	oUl.style.display = "none";
}


function DropDown4(id){
	var oDiv = document.getElementById(id);
	this.aDiv = oDiv.getElementsByTagName("div");
	_this = this;
	for(var i=0 ; i<this.aDiv.length ; i++){
		this.aDiv[i].getElementsByTagName("ul")[0].style.display = "none";    
		
		this.aDiv[i].onclick = function(ev){
			_this.hideAll(oDiv);
			_this.show(ev,this);
		}
		
		document.onclick = function(){
			_this.hideAll(oDiv);
		}

	}
}
DropDown4.prototype.show = function(ev,theClickDiv){
	var oUl = theClickDiv.getElementsByTagName("ul")[0];
	oUl.style.display = "block";
	this.oEvent = ev||event;
	this.oEvent.cancelBubble = true;
}
DropDown4.prototype.hideAll = function(oDiv){
	this.aUl = oDiv.getElementsByTagName("ul");  
	for(var i=0 ; i<this.aUl.length ; i++){
		this.aUl[i].style.display = "none";
	}
}



//五：竖向下拉菜单
$("#color_menu .color").click(function(){
	$(this).next().slideDown("slow","easeInElastic")        //easeInOutElastic  easeOutBounce
	.parent().siblings().find("ul").slideUp("slow","easeInElastic");
})



//六：多层级下拉菜单
$("#multi_menu li").hover(function(){                     	//所有的li(各个层级)都加上移入移出事件
	$(this).children("ul").stop(true).slideDown(200);       //当前被移入的li的子元素ul(也就是菜单)下拉 只保留最近一次下拉动画
},function(){
	$(this).children("ul").stop(true).slideUp(10);          //当前被移出的li的子元素ul(也就是菜单)上拉
});



})


