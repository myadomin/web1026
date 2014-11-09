

//用面向对象与继承 封装拖拽功能
window.onload = function(){
	var oDiv1 = document.getElementById("box1");
 	var oDiv2 = document.getElementById("box2");
 	var oDiv3 = document.getElementById("box3");
	var oDiv4 = document.getElementById("box4");
	var oDiv5 = document.getElementById("box5");
	var oDiv6 = document.getElementById("box6");

	//限制为当前窗口的拖拽
	limitDrag(oDiv1); 

	//限制为当前窗口的拖拽 传参限定oDiv2的上半部分才可以被拖拽                                  
	limitDrag(oDiv2, 150, 75); 

	//面向对象写的无限制拖拽             
	var d3 = new Drag(oDiv3);

	//面向对象写的无限制拖拽 oDiv4的上半部分才可以被拖拽                  
	var d4 = new Drag(oDiv4, 150, 75);

	//面向对象写的限制为当前窗口的拖拽             
	var d5 = new LimitDrag(oDiv5);   

	//面向对象写的限制为当前窗口的拖拽 传参限定oDiv4的上半部分才可以被拖拽              
	var d6 = new LimitDrag(oDiv6, 150, 75); 
}
	

	
//一：limitDrag 限制为当前窗口的拖拽 
//1：必须参数obj，选传参数xRange yRange(通过设置这两个参数，来设定obj的某些区域才可以被拖拽)
//2：obj css position可以设置为fixed或者absolute定位，会自动检测决定是否加滚动条。
//3：默认开启限定为当前窗口的限定范围拖拽(obj css是fixed或者obj是absolute定位而且上层父级没有relative)
//4：如果absolute定位，而且某层父级有relative，希望拖拽范围限定在这层父级内，那if限定范围的时候
//nLeft>xxx部分的clientWidth需要改动为 obj.parentNode.offsetWidth（多层父级就多加几个parentNode）
//如果希望拖拽范围限定在整个窗口，那if限定范围的时候，所有判断值都需要减去这层父级的相对窗口的offset
function limitDrag(obj,xRange,yRange){
	obj.onmousedown = function(ev){
		var oEvent = ev||event
		if(getStyle(obj,"position") == "absolute"){ 
			//如果css设置的是absolute定位 那后续计算就需要加上scrollLeft                    
			var scrollLeft = document.documentElement.scrollLeft||document.body.scrollLeft;  
			var scrollTop = document.documentElement.scrollTop||document.body.scrollTop;
		}else if(getStyle(obj,"position") == "fixed"){ 
			//如果css设置的是fixed定位 那后续计算就不需要加上scrollLeft 所以为0                 
			var scrollLeft = 0; 
			var scrollTop = 0;
		}

		//由于clientX不算滚动条 obj是absolute定位那要加上滚动条距离scrollLeft才是真正的disX
		//同理下面的nLeft部分也要改成oEvent.clientX + scrollLeft - disX  if限定也要加scrollLeft
		//如果obj是fixed定位，就是相对当前窗口的定位，this.offsetLeft就算进了scrollLeft，所以三个地方都不需要加scrollLeft
		//一般实际应用fixed缺点是无论如何移动 滚动条obj一直在那个位置
		//absolute的缺点是如果在他的某层父级有relative 而又想把拖拽限定在这层父级内
		//那if限定范围的时候clientWidth需要改动为 obj.parentNode.offsetWidth（多层父级就多加几个parentNode）
		var disX = oEvent.clientX + scrollLeft - this.offsetLeft; 
		var disY = oEvent.clientY + scrollTop - this.offsetTop;

		//设定obj的某些区域onmousedown 拖拽才有效 
		//当被点击的disX大于xRange参数或者disY大于参数yRange 就跳出函数不能拖拽                                                                                      
		if(disX>xRange||disY>yRange){                                     
			return;                                                                      
		}
    	
		document.onmousemove = function(ev){
			var oEvent = ev||event;
			var nLeft = oEvent.clientX + scrollLeft - disX;
			var nTop = oEvent.clientY + scrollTop - disY;
			var clientWidth = document.documentElement.clientWidth||document.body.clientWidth;    
			var clientHeight = document.documentElement.clientHeight||document.body.clientHeight;
			
			if(nLeft < scrollLeft){               
				nLeft = scrollLeft;
			}
			if(nLeft > clientWidth - obj.offsetWidth + scrollLeft){     
				nLeft = clientWidth - obj.offsetWidth + scrollLeft;
			}
			if(nTop < scrollTop){
				nTop = scrollTop;
			}
			if(nTop > clientHeight - obj.offsetHeight + scrollTop){
				nTop = clientHeight - obj.offsetHeight + scrollTop;
			}
			
			obj.style.left = nLeft + "px";
			obj.style.top = nTop + "px";
		}
		
		document.onmouseup = function(){
			this.onmousemove = null;
			this.onmouseup = null;
		}

		//阻止默认事件 阻止拖动过程中选择oDiv内部文字
		return false;           
	}	
}
	

	
//二：Drag 用面向对象写的拖拽函数(不限定拖拽范围)	
function Drag(obj,xRange,yRange){
	var _this = this;
	obj.onmousedown = function(ev){ 
		_this.fnDown(this,xRange,yRange,ev);   
		return false;  	  
	};
}

Drag.prototype.fnDown = function(obj,xRange,yRange,ev){   
	var _this = this;  
	//oEvent本身只属于当前事件函数 所以不需要this.变量 不会污染全局                                    
	var oEvent = ev||event;                                   
	 
	if(getStyle(obj,"position") == "absolute"){ 
		//this.scrollTop专属于当前对象                     
		this.scrollLeft = document.documentElement.scrollLeft||document.body.scrollLeft; 
		this.scrollTop = document.documentElement.scrollTop||document.body.scrollTop;  
	}else if(getStyle(obj,"position") == "fixed"){                 
		this.scrollLeft = 0; 
		this.scrollTop = 0;
	}
	
	this.disX = oEvent.clientX + this.scrollLeft - obj.offsetLeft;    
	this.disY = oEvent.clientY + this.scrollTop - obj.offsetTop;  
                  
	if(this.disX>xRange||this.disY>yRange){                                                           
		return;                                                                      
	}
	
	document.onmousemove = function(ev){
		_this.fnMove(obj,ev);
	}
	document.onmouseup = function(){
		_this.fnUp();
	}    
}		

Drag.prototype.fnMove = function(obj,ev){
	oEvent = ev||event;
	//nLeft不会在其他函数中应用 可以设定为私有变量 可以不用this.nLeft
	var nLeft = oEvent.clientX + this.scrollLeft - this.disX;  
	var nTop = oEvent.clientY + this.scrollTop - this.disY;
	obj.style.left = nLeft + "px";
	obj.style.top = nTop + "px";
}

Drag.prototype.fnUp = function(){
	document.onmousemove = null;
	document.onmouseup = null;
}



//三：LimitDrag 通过面向对象继承Drag形成LimitDrag(限定拖拽范围)
function LimitDrag(obj,xRange,yRange){  
	//通过对象冒充 继承所有的属性          
	Drag.call(this,obj,xRange,yRange);
}

for(var i in Drag.prototype){ 
	//拷贝基础 通过for in所有原型方法 继承所有的原型方法                    
	LimitDrag.prototype[i] = Drag.prototype[i];  
}

//改写新的LimitDrag.prototype.fnMove，在这里加上限制拖拽范围
LimitDrag.prototype.fnMove = function(obj,ev){    
	oEvent = ev||event;
	var nLeft = oEvent.clientX + this.scrollLeft - this.disX;
	var nTop = oEvent.clientY + this.scrollTop - this.disY;
	
	var clientWidth = document.documentElement.clientWidth||document.body.clientWidth;    
	var clientHeight = document.documentElement.clientHeight||document.body.clientHeight;
	if(nLeft < this.scrollLeft){               
		nLeft = this.scrollLeft;
	}
	if(nLeft > clientWidth - obj.offsetWidth + this.scrollLeft){     
		nLeft = clientWidth - obj.offsetWidth + this.scrollLeft;
	}
	if(nTop < this.scrollTop){
		nTop = this.scrollTop;
	}
	if(nTop > clientHeight - obj.offsetHeight + this.scrollTop){
		nTop = clientHeight - obj.offsetHeight + this.scrollTop;
	}
	
	obj.style.left = nLeft + "px";
	obj.style.top = nTop + "px";
}



//获取计算后的css样式
function getStyle(obj,attr){
	if(window.getComputedStyle){
		return window.getComputedStyle(obj,null)[attr];
	}else if(obj.currentStyle){
		return obj.currentStyle[attr];
	}
}