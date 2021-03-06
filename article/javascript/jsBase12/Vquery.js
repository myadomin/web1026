﻿//模仿jQuery做MyQuery简单封装


function $(vArg){
	return new MyQuery(vArg);     	//$(vArg)就等同于new MyQuery(vArg) 
}								 

//构造函数
function MyQuery(vArg){      		//后续的$()括号里面的参数可能是 1：function  2：字符串  3：this(对象)  
	this.elements = [];           	//数组 用来保存选取的DOM对象
	
	//根据传入的vArg参数的情况 进行相应操作
	switch(typeof vArg){   
		case 'function': 
			//如果MyQuery()的参数是函数 就执行onload加载事件 jQuery中做了很多domReady等操作 这里只做onload                   	
			myAddEvent(window,'load',vArg); 	
			break;								 
		case 'string':  
			//如果MyQuery()的参数是字符串 就是选择元素节点 有#box .box box三种情况                      	
			switch(vArg.charAt(0)){            	              
				case '#':                      	//#box形式 选出的元素存到this.elements数组
					var obj = document.getElementById(vArg.substring(1));   
					this.elements.push(obj);  	 
					break;
				case '.':               		//.box形式 选出类数组的元素集合存到this.elements数组
					this.elements = getByClass(document,vArg.substring(1)); 
					break;                  	
				default:                       	//box形式 选出类数组的元素集合存到this.elements数组
					this.elements = document.getElementsByTagName(vArg);  
			}																						 
			break;																		 		
		case 'object':
			//如果MyQuery()的参数是this等对象 存对象到this.elements数组 并且返回的还是MyQuery对象 
			this.elements.push(vArg);        	
	}
}


//点击事件
//$('.box').click(fn) 就等同于function(fn){xxx}(fn) 匿名函数接受传参自我执行
MyQuery.prototype.click = function(fn){
	//$('.box')的时候this.elements数组就预存好了getByClass的元素集合 给这些元素绑定click事件
	for(var i=0 ; i<this.elements.length ; i++){
		myAddEvent(this.elements[i], 'click', fn);
	}
	//所有的原型方法最终都return MyQuery对象 便于连缀操作
	return this;
}


//显示
MyQuery.prototype.show = function(){
	for(var i=0 ; i<this.elements.length ; i++){
		this.elements[i].style.display = 'block';
	}
	return this;
}


//隐藏
MyQuery.prototype.hidd = function(){
	for(var i=0 ; i<this.elements.length ; i++){
		this.elements[i].style.display = 'none';
	}
	return this;
}


//设置鼠标移入移出方法
MyQuery.prototype.hover = function(fnOver,fnOut){      
	for(var i=0 ; i<this.elements.length ; i++){			 
		myAddEvent(this.elements[i],'mouseover',fnOver);  
		myAddEvent(this.elements[i],'mouseout',fnOut);    
	}
	return this;
}


//获取及设置css 传入字符串或json
MyQuery.prototype.css = function(attr,value){
	//如果是两个参数 那就是设置css
	if(arguments.length == 2){                       
		for(var i=0 ; i<this.elements.length ; i++){
			this.elements[i].style[attr] = value;         
		}																							 
	}

	if(arguments.length == 1){ 
		//传入的是一个参数而且attr是字符串 就是获取css计算后的样式                       
		if(typeof attr == 'string'){                     
 			return getStyle(this.elements[0],attr); 
		}else{   //传入的是一个参数而且attr是json 那就是设置css 
			//遍历所有选出的元素                             
			for(var i=0 ; i<this.elements.length ; i++){ 
				//每个元素对attr json进行遍历 设置css 
				for(var k in attr){                              
					this.elements[i].style[k] = attr[k];     
				}
			}	
		}
	}
	return this;
}


//点击循环事件
MyQuery.prototype.toggle = function(){   
	//先用_arguments = arguments预存参数
  	var _arguments = arguments;            
	for(var i=0 ; i<this.elements.length ; i++){
		addToggle(this.elements[i]);
	}

	//这种写法情况下 每个this.elements[i]各自的count都是独立计数的
	//例如 $('.divs').toggle(fn1,fn2,fn3); 选取了很多class=divs的元素 每个元素的各自fnx是独立的
	//不在原型方法上加入任何的参数 之后调用toggle(fn1,fn2,......fnn)随便放多少个参数都可以
	//用_arguments[x]来代表是第几个参数 也就是代表着fn1 fn2...里面具体哪个函数.
	//刚开始的时候count=0 也就是_arguments[0],也就是fn1，点击就触发fn1 然后count++变成1 
	//如果再点击，那这时就是_arguments[1],也就是fn2了，然后count++变成2了
	//如果一直持续点击，那就是一直到count = _arguments.length - 1 也就是一直执行到最后一个参数代表的函数fnn
	//通过%的方法,如果之后还持续点击，那就开始又从fn1开始循环执行
	//_arguments[x]代表了fn1 fn2 fn3们 但是为了便于toggle里面能运行this 而且this指向的还是被toggle的对象（也就是被onclick对象,也就是obj)
	//所以采用对象冒充 把_arguments[x]变成function(){_argument[x].call(obj)}
	function addToggle(obj){                             
		var count = 0;
		myAddEvent(obj, 'click', function(){
			//这里的arguments是当前函数的参数 而不是原型方法的参数 所以用_arguments先预存了
	      	_arguments[count%_arguments.length].call(obj);  
	      	count++;
    	});
	}	

	return this;
}


//获取及设置属性
MyQuery.prototype.attr = function(attr, value){   
	if(arguments.length == 2){
		//两个参数 就是设置某个某些节点下的属性值    
		for(var i=0 ; i<this.elements.length ; i++){
			this.elements[i].style[attr] = value;        
		}
	}else{ 
		//一个参数就是读取某些节点下的属性值 返回值是数组 而不是MyQuery对象
		var arr = []; 
		for(var i=0 ; i<this.elements.length ; i++){  
			arr.push(getStyle(this.elements[i], attr));
		}
		return arr;
	}	
	return this;
}


//获取第n个元素 返回的依然是MyQuery对象 可以继续连缀 $('div').eq(n).css(xx)	
//this.elements[n]就代表了第n+1个元素对象 但是直接return这个元素对象 就不能连缀了 因为这个对象下没有原型方法
//所以变成$(this.elements[n]) 也就是$(对象) 在构造函数中执行 case 'object':this.elements.push(vArg); 
//所以结果就是把this.elements[n]变成构造函数实例化出的this.elements[0]这个对象，这个对象是构造函数实例化出的对象 所以下面是有css方法的
MyQuery.prototype.eq = function(n){   
	return $(this.elements[n]);   
}			


//获取第n个元素 返回的是原生对象 
MyQuery.prototype.get = function(n){   
	return this.elements[n];   
}	


//查找元素 $('xxx').find(str);
//问题：为什么这里不能像MyQuery构造函数里default:this.elements = document.getElementsByTagName(vArg);这样写 
//也就是defalut下 直接只写 aResult = this.elements[i].getElementsByTagName(str);
//因为上面有for循环 第一次循环 aEle = this.elements[0].getElementsByTagName(str);
//而第二次aEle = this.elements[1].getElementsByTagName(str),那就是第二次的aEle覆盖了前面的aEle 所以不行
//必须this.elements[0].getElementsByTagName(str)的元素集合push进aRsult数组,下一次循环再把this.elements[1].getElementsByTagName(str) push进去 直到i          
MyQuery.prototype.find = function(str){     
	var aResult = [];  

	//循环$(xxx)选出的元素集合this.elements                     
	for(var i=0 ; i<this.elements.length ; i++){ 
		//对于每个this.elements[i] 进行find(str)的str情况判断 
		switch(str.charAt(0)){                      
			case '.':   
				//.box情况                         
				var aEle = getByClass(this.elements[i], str.substring(1));    
				//通过getByClass函数返回一个数组 将这个数组嫁接到结果数组aResult里去
				aResult = aResult.concat(aEle);				 											
				break	
			default:  
				//box情况                           
				var aEle = this.elements[i].getElementsByTagName(str);      
				//aEle不是数组就不能被concat 所以不能和上面一样concat嫁接 所以用自己写的appendArr嫁接到结果数组													
				appendArr(aResult, aEle);    
		}					
	}

	//返回aRsult数组 就不是MyQuery对象 就不能操作css等原型方法了
	//return aResult    

	//先实例化一个MyQuery对象obj 将aResult存入到this.elements数组里 返回obj对象
	var obj = $();  
	obj.elements = aResult;  
	return obj;         
}


//找出当前这个节点处于兄弟节点的第几个 $('xxx').index()
MyQuery.prototype.index = function(){  
	//找到$('xxx')选出的元素this.elements[0]的父节点的所有子节点
	var aBrother = this.elements[0].parentNode.children;
	for(var i=0 ; i<aBrother.length ; i++){
		//遍历这些所有子节点 当第i个子节点就是this.elements[0] 返回i
		if(aBrother[i] == this.elements[0]){
			return i;
		}
	}
	return this;
}


//绑定事件
MyQuery.prototype.bind = function(sEv, fn){
	for(var i=0 ; i<this.elements.length ; i++){
		myAddEvent(this.elements[i], sEv, fn);
	}
}


//设置innerHTML
MyQuery.prototype.html = function(str){
	for(var i=0; i<this.elements.length; i++){
		//如果没有传入参数 就是获取innerHTML
		if(arguments.length == 0){
			return this.elements[i].innerHTML;
		}
		//如果没有传入str参数 就是设置innerHTML
		this.elements[i].innerHTML = str;
	}
	return this;
}


//插件入口
MyQuery.prototype.extend = function(name, fn){
	MyQuery.prototype[name] = fn;
};



//函数部分
//1：现代事件绑定
//为什么要对象冒充到obj？ myAddEvent在整个MyQuery库中，只有两种情况用到它。
//第一种情况，$(函数)的时候(这个$就是写jQuery的第一个$), 也就是构造函数中判断到 case 'function': 下的myAddEvent
//所以obj被传进来的是window,经过function(){fn.call(obj);}的对象冒充，window对象冒充后变成window对象，等于没变，
//第二种情况，调用click hover等方法的时候会用到myAddEvent，例如hover下的myAddEvent(this.elements[i],'mouseover',fnOver);
//而在IE下执行到obj.attachEvent('on'+sEv,fn);的时候（假如不把fn改成function(){fn.call(obj)}） 
//就算obj在此例子中是 this.elements[i] ，但是IE下执行obj.attachEvent('on'+sEv,fn)后对象还是window而不是obj
//所以通过加上function(){fn.call(obj)}，把对象从window强制改成obj 这样在hover之类的方法下$(this)的this就正确指向了obj
function myAddEvent(obj,sEv,fn){
	if(obj.attachEvent){				      		//IE低版本
		obj.attachEvent('on'+sEv,function(){
			//由于IE下这里的this永远指向window 所以用对象冒充让this正确指向到obj 
			//如果fn函数最终return false 就开始下面的阻止默认事件    
			if(false == fn.call(obj)){				  
				event.cancelBubble = true;       
				return false;    
			}                      
		});
	}else{											//w3c IE高版本
		obj.addEventListener(sEv,function(ev){
			//本来w3c下直接fn 并不需要function(){fn.call(obj)}对象冒充的 
			//但是为了加上阻止默认事件和冒泡 也对象冒充一下 反正没影响           
			if(false == fn.call(obj)){         
				ev.cancelBubble = true;
				ev.preventDefault();
			}
		},false);  
	}
}


//2：class获取元素
function getByClass(oParent,sClass){
	var aElem = oParent.getElementsByTagName("*");
	var aResult = [];
	var re = new RegExp("\\b" + sClass + "\\b","i") 	//sClass左边右边必须是单词边界(\转义\b 所以是\\b)
	for(var i=0 ; i<aElem.length ; i++){            	//也就是sClass左右不能再是字母 而是空格或=等
		if(re.test(aElem[i].className)){ 				//这样就算class= aa bb cc 这里也是真 就能选取aElem[i]了
			aResult.push(aElem[i]);
		}
	}
	return aResult;
}


//3：获取计算后的样式
function getStyle(obj,attr){
	if(obj.currentStyle){                   //IE
		return obj.currentStyle[attr];
	}else{                                  //W3C
		return getComputedStyle(obj,false)[attr];
	}
}


//4：一个数组元素全部放入另一个数组
function appendArr(arr1,arr2){
	for(var i=0 ; i<arr2.length ; i++){
		arr1.push(arr2[i]);
	}
}




