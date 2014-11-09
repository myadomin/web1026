//块体跟随及右键菜单及拖拽应用

window.onload = function(){
 
//1：移动鼠标形成一路div跟随走
var oDiv = document.getElementById('follow');
var aDiv = oDiv.getElementsByTagName("div");
var oBtn = document.getElementById("btn");
var nDivLeft = oDiv.offsetLeft;
var nDivtop = oDiv.offsetTop;
var scrollLeft = document.documentElement.scrollLeft||document.body.scrollLeft;  
var scrollTop = document.documentElement.scrollTop||document.body.scrollTop;
oBtn.onclick = function(){
	//document下 鼠标一移动 就开始触发函数
	document.onmousemove = function(ev){		
		var oEvent = ev||event;
		//下面的循环不包括aDiv[0]，所以在这里加绝对定位  
		aDiv[0].style.left = oEvent.clientX - nDivLeft + scrollLeft + 'px';
		aDiv[0].style.top = oEvent.clientY - nDivtop + scrollTop + 'px';
		aDiv[0].style.position = "absolute"; 
		
		//必须是累减 5=4 4=3 3=2 2=1 1=0 即5等同原来4的位置 4等同原来3的位置 以此类推  
		//如果是累加 1=0 2=1 3=2 4=3 5=4 最后1 2 3 4 5都等于0的位置了 所以不行
		for(var i=aDiv.length-1 ; i>0 ; i--){       
			aDiv[i].style.position = "absolute";    
			aDiv[i].style.left = aDiv[i-1].style.left;
			aDiv[i].style.top = aDiv[i-1].style.top;
		}	
	}
}


//2：自建右键菜单
var oUl = document.getElementById("menu");
var aLi = oUl.getElementsByTagName("li");

//右键触发事件 默认是出现右键菜单 
document.oncontextmenu = function(ev){   
	var oEvent = ev||event
	oUl.style.display = 'block';
	scrollLeft = document.documentElement.scrollLeft||document.body.scrollLeft;
	scrollTop = document.documentElement.scrollTop||document.body.scrollTop;
	//ul左边距等于鼠标X坐标加上滚动X距离（如果有滚动条）
	oUl.style.left =oEvent.clientX + scrollLeft + 'px'; 
	oUl.style.top = oEvent.clientY + scrollTop + 'px'; 
	return false;				//阻值出现默认右键菜单
}

document.onclick = function(){   //左键点击任意区域的左键 ul消失 
	oUl.style.display = 'none';
}
oUl.onclick = function(ev){      //左键点击ul部分 ul不消失
	var oEvent = ev||event;
	oUl.style.display = 'block';
	//阻止oUl1下的冒泡行为 oUl1区域不被上面的document.onclick行为覆盖 所以在ul区域点左键不会消失ul
	oEvent.cancelBubble = true;  
}

//移入移出 菜单变色
for(var i=0 ; i<aLi.length ; i++){
	aLi[i].onmouseover = function(){
		this.style.backgroundColor = "#2a4";
	}
	aLi[i].onmouseout = function(){
		this.style.backgroundColor = "#ccc";
	}
}
	

//3：块体按下产生虚线框 拖拽虚线框 放手后块体移动到虚线框
//面向对象写法 具体见下面的构造函数
var box1 = new DashedDrag();
box1.init('box1');
var box2 = new DashedDrag();
box2.init('box2');

  
//4：拖拽框体右下角 改变框体大小  
var oFrame = document.getElementById("frame");      
var oDrag = document.getElementById('drag'); 
   
oDrag.onmousedown = function(ev){
	var oEvent = ev||event;
	diffX = oEvent.clientX - this.offsetLeft;       
	diffY = oEvent.clientY - this.offsetTop;

	document.onmousemove = function(ev){            
		var oEvent = ev||event;
		var x = oEvent.clientX - diffX;
		var y = oEvent.clientY - diffY;	
		document.title = (x +"||"+y);	
		//因为oDrag是相对oFrame的绝对定位 所以oDrag在拖拽过程中的left top大概就等于oFrame的宽度和高度
		//一旦oDrag开始拖动 就不断的把left和top赋值给了oFrame的高度和宽度，从而oFrame变大变小
		//因为oDrag本身有10px的大小，所以oFrame宽度高度要加10px
		oFrame.style.width = x + 10 + 'px';   
		oFrame.style.height = y + 10 + 'px';  
		return false;						
	}									
		                                         
	document.onmouseup = function(){
		document.onmousemove = null;
		document.onmouseup = null;
	}

	return false;  
}
	

//5：留言板效果
var oBtn = document.getElementById("btn1");
var oTxt = document.getElementById("txt1");
var oDiv = document.getElementById("div1");

oBtn.onclick = function(){
	var oNewDiv = document.createElement("div");
	var aNewDiv = oDiv.getElementsByTagName("div");

	oNewDiv.innerHTML = toBreakWord(oTxt.value , 36); //如果向一个框体输入innerHTML，而且全是英文或数字，只有出现空格他才会换行。
	oTxt.value = "";                                  //如果一直没空格就一直不换行(即使这个框体本身就加了宽度也不换)
													  //那为了防止这种情况下不换行 那就将一串强行在36个字符后加上空格(36个英文字符正好等于框体宽度)
	if(aNewDiv.length == 0){						  //然后将已在在36个字符后加上空格的这串字符串输入到框体
		oDiv.appendChild(oNewDiv);                      //如果还没有插入过子元素 那就插入子元素
	}else{ 
		oDiv.insertBefore(oNewDiv,aNewDiv[0]);          //如果之前插入过子元素了 那新插入的子元素 插入到上一次插入的子元素的前面
	}

	var iHeight = oNewDiv.offsetHeight;               //offsetHeight 必须是oNewDiv这个元素显现出来的时候才有 所以必须先记录高度 在设置高度为0
	oNewDiv.style.height = "0px";                     //一旦设置了oNewDiv的高度为0后 offsetHeight就只有5了(padding上下4 边框1) 所以先记录iHeight
	bufferMove(oNewDiv,{height:iHeight},function(){
		bufferMove(oNewDiv,{opacity:100});
	});		 
}

}

 
//拖拽虚线框
function DashedDrag(){
	this.diffX = 0;
	this.diffY = 0;
	//创建this.oNewDiv属性 便于在fnDown fnMove fnUp三个函数中都被认识
	this.oNewDiv = null;  
}

DashedDrag.prototype.init = function(id){
	this.oDiv = document.getElementById(id);
	var _this = this;

	this.oDiv.onmousedown = function(ev){
		_this.fnDown(ev);

		document.onmousemove = function(ev){
			_this.fnMove(ev);
			return false;	
		}

		document.onmouseup = function(){
			_this.fnUp();
		}

		return false;  
	}
}

DashedDrag.prototype.fnDown = function(ev){
	//js动态创建宽度高度及位置属性 如果div1变成了别的div也能复用 因为宽度高度及位置是this.oDiv决定的
	//一旦点击 就产生一个oNewDiv 和div重合起来 并且带2px虚线边框
	this.oNewDiv = document.createElement('div');       
	document.body.appendChild(this.oNewDiv);          
	this.oNewDiv.style.width = this.oDiv.offsetWidth - 2 + 'px';   //由于带了border 所以宽高要各小2px
	this.oNewDiv.style.height = this.oDiv.offsetHeight - 2 + 'px'; 
	this.oNewDiv.style.left = this.oDiv.offsetLeft + 'px';              
	this.oNewDiv.style.top = this.oDiv.offsetTop + 'px';
	this.oNewDiv.style.position = "absolute";
	this.oNewDiv.style.border = "2px dashed #666";

	var oEvent = ev||event;
	this.diffX = oEvent.clientX - this.oNewDiv.offsetLeft;        //拖拽这个虚线框div
	this.diffY = oEvent.clientY - this.oNewDiv.offsetTop;
}

DashedDrag.prototype.fnMove = function(ev){
	var oEvent = ev||event;
	var x = oEvent.clientX - this.diffX;
	var y = oEvent.clientY - this.diffY;		
	this.oNewDiv.style.left = x + 'px';                  
	this.oNewDiv.style.top = y + 'px';	 	
}

DashedDrag.prototype.fnUp = function(){
	document.onmousemove = null;
	document.onmouseup = null;
	this.oDiv.style.left = this.oNewDiv.style.left; //移动完毕鼠标抬起来的时候 让div迅速移到虚线框位置
	this.oDiv.style.top = this.oNewDiv.style.top;	 
	document.body.removeChild(this.oNewDiv);		//移动完毕鼠标抬起来的时候 移除这个虚线框DIV
}


//缓冲运动函数 -----------------------------------------
//每个对象有单独的obj.timer定时器 多个对象的各自运动互不影响
//通过json的for in 每个对象可以同时改变自身多个属性
//通过函数回调 每个对象能形成链式运动
function bufferMove(obj,json,fn){  
	var iCur = 0;
	var iSpeed = 0;  
	var bStop = true;        
	clearInterval(obj.fMove);

	obj.fMove = setInterval(function(){
		bStop = true;                       	//每次定时器一开始 就设置bStop为ture
		
		for(attr in json){                  	//遍历json
			if(attr == 'opacity'){             
				iCur = parseInt(parseFloat(getStyle(obj,attr)) * 100);		 
			}else{
				iCur = parseInt(getStyle(obj,attr));                       
			}
			iSpeed = (parseInt(json[attr]) - iCur)/8;                                 
			
			if(iSpeed > 0){
				iSpeed = Math.ceil(iSpeed);
			}
			if(iSpeed < 0){
				iSpeed = Math.floor(iSpeed);
			}
			
			//每个定时器周期里 for in 循环了n次 有n个同时进行的bufferMove函数 从而变化属性值 
			//n个bufferMove函数里只要有任意一个函数里的属性值还没到达终点 都会把bStop变为false  
			//当所有属性值都到达终点后 也就是n个bufferMove函数都不执行这句的时候  
			//这次定时器周期最后的bStop没有被变化为false 还是true   
			//当这次定时器周期的bStop还是ture的话 在定时器周期函数最后判断bStop为ture 那就关闭定时器了                     	
			if(parseInt(json[attr]) != iCur){   
				bStop = false;          	
			}                           	
                                          	
			if(attr == 'opacity'){                                       
				obj.style[attr] = (iCur + iSpeed)/100 + '';            
				obj.style.filter = 'alpha(opacity:'+(iCur+iSpeed)+')';  
			}else{
				obj.style[attr] = iCur + iSpeed + 'px';                
			}		
		}
		
		if(bStop){                     		//只要有任意一个还没到达终点 bStop会被变成false 不停止定时器
			clearInterval(obj.fMove);  		//当所有属性值都到达终点后 bStop不会变false 还是原来的true 停止定时器         
			if(fn){                                                    
				fn();                                                  
			}
		}
	},20);
}


function getStyle(obj,attr){
	if(obj.currentStyle){
		return obj.currentStyle[attr];
	}else{
		return getComputedStyle(obj,false)[attr];
	}
}


//对于strContent文本 强行在第intLen个字符后加上空格 让其换行 保证英文数字换行正确 
function toBreakWord(strContent,intLen){            
	var strTemp = "";
  	while(strContent.length > intLen){
		strTemp += strContent.substr(0,intLen) + " ";  
		strContent = strContent.substr(intLen,strContent.length);
  	}
	strTemp += strContent;
	return strTemp;
}	