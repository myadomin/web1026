 
//照片墙效果
window.onload = function(){

var aLi = document.getElementById('ul1').getElementsByTagName('li');
var oInput = document.getElementsByTagName('input')[0];
var arr = new Array();
var nZIndex = 1;
var nearLi = null;


//循环每一个li
for(var i=0; i<aLi.length; i++){
	//每个li准备好left top值 用于后续绝对定位 从而可以拖拽
	aLi[i].style.left = aLi[i].offsetLeft + 'px';
	aLi[i].style.top = aLi[i].offsetTop + 'px';

	//二维数组 预存所有li还没开始拖拽前的left top 因为之后拖拽这个left top就会不断变化了
	arr.push([aLi[i].offsetLeft, aLi[i].offsetTop]);

	//给当前的每个li加一个index属性 便于后续知道任何一个li的left top存储在arr哪个位置
	aLi[i].index = i;

	//所有图片都可以被拖拽
	Drag(aLi[i]);
}


//这里不能写在上面的for里面 如果写在上面的for里面 当aLi[0] left top赋值后就马上position定位 
//aLi[0]就脱离文档流了 后面的aLi[1]马上占据了原来的aLi[0]位置 最后所有图片都在aLi[0]原来的位置了
for(var i=0; i<aLi.length; i++){
	aLi[i].style.position = 'absolute';
	aLi[i].style.margin = '0px';
}


//点击按钮随机换位图片 换位就是aLi[i]的left变成预存好的arr数组的[x]的[0]的值
//所以对于每一个aLi[i] 可以随机出一个不重复的0-8之间的值 作为arr[x][0]赋值给left
oInput.onclick = function(){
	// var arrRandom = [0, 1, 2, 3, 4, 5, 6, 7, 8];
	//不能写死这个准备随机排序的数组 如果后续不是9张图片那整个程序就不能复用了
	var arrRandom = [];
	for(var i=0; i<aLi.length; i++){   //形成[0,1,2......X]  X就是图片数-1
		arrRandom[i] = i;
	}
	arrRandom = arrRandom.sort(function(num1, num2){   //形成随机排序的数组 arrRandom 
		return Math.random() - 0.5;
	});

	for(var i=0; i<aLi.length; i++){  //arrRandom[i]可能是0-8之间的任何一个数 并且和前面的不重复
		bufferMove(aLi[i],{"left":arr[arrRandom[i]][0], "top":arr[arrRandom[i]][1]});
		aLi[i].index = arrRandom[i];  //换位后 当前的aLi[i]的index也要及时更新为arrRandom[i]
	}
}


//拖拽
function Drag(obj){
	obj.onmousedown = function(ev){
		var oEvent = ev || event;    
		var disX = oEvent.clientX  - this.offsetLeft;
		var disY = oEvent.clientY  - this.offsetTop;

		//拖拽过程中 寻找obj最近的li
		document.onmousemove = function(ev){   
			var oEvent = ev || event;   	
			obj.style.zIndex = nZIndex++;  		//当前被拖拽的对象 z-indx永远最大
			obj.style.left = oEvent.clientX  - disX + 'px';
			obj.style.top = oEvent.clientY  - disY + 'px';

			nearLi = getNearLi(obj);  	 	    //得到被碰撞到的最近的li对象 或者没有碰撞到得到的false
			for(var i=0; i<aLi.length; i++){   
				aLi[i].style.border = 'none';   //先把所有的li边框去掉
			}
			if(nearLi){   						//如果找到了碰撞到的最近的li对象
				nearLi.style.border = '2px dashed #360';  //给最近的li加上边框    
			}
			obj.style.border = '2px dashed #360';  
			
			return false;       
		}

		//鼠标抬起 换位置
		document.onmouseup = function(){
			document.onmousemove = null;
			document.onmouseup = null;

			if(nearLi){  //如果在鼠标松开的时候 有碰撞到的离的最近的li
				var objLeft = arr[obj.index][0];    	//提取之间预存好的 被拖拽obj开始拖拽前的left top
				var objTop =  arr[obj.index][1];
				var nearLiLeft = arr[nearLi.index][0]; 	//提取nearLi的left top
				var nearLiTop =  arr[nearLi.index][1];
				
				bufferMove(obj,{"left":nearLiLeft, "top":nearLiTop});  //位置互换
				bufferMove(nearLi,{"left":objLeft, "top":objTop});
				
				var tmp = obj.index;   		//obj与nearLi换位后 各自index也要互换  
				obj.index = nearLi.index;   //保证下次换位获取的 objLeft = arr[obj.index][0]正确
				nearLi.index = tmp;

				obj.style.border = 'none';  //去边框
				nearLi.style.border = 'none';
			}else{   	//如果在鼠标松开的时候 没有碰撞到任何的li obj回到原位置
				bufferMove(obj,{"left":arr[obj.index][0], "top":arr[obj.index][1]});
				obj.style.border = 'none';   
			}
		}

		return false;  
	}
}


//在当前被拖拽对象中找到被碰撞到的li 在这些li里找到离这个拖拽对象最近的li
//如果有找到返回对象 没有找到返回false
function getNearLi(obj){
	var value = 9999;
	var index = -1;

	//循环所有的li对象
	for(var i=0; i<aLi.length; i++){ 
		if(isPunk(obj, aLi[i]) && aLi[i] != obj){    //找到被碰撞到的这些li
			var distance = getDistance(obj, aLi[i]); //得到被碰撞的这些li与被拖拽对象obj的距离 

			//得到与被碰撞对象obj距离最近的li的index
			if(distance < value){
				value = distance;
				index = i;      
			}
		}
	}

	//如果index不是初始值了 说明有碰撞到 返回碰撞到的距离obj最近的li
	if(index != -1){            
		return aLi[index];
	}else{          	//否则所以没有碰撞到任何li
		return false;
	}
}


//检测obj1是否碰撞到obj2 返回布尔值
function isPunk(obj1, obj2){
	var left1 = obj1.offsetLeft;
	var right1 = obj1.offsetLeft + obj1.offsetWidth;
	var top1 = obj1.offsetTop;
	var bottom1 = obj1.offsetTop + obj1.offsetHeight;
	var left2 = obj2.offsetLeft;
	var right2 = obj2.offsetLeft + obj2.offsetWidth;
	var top2 = obj2.offsetTop;
	var bottom2 = obj2.offsetTop + obj2.offsetHeight;

	if(right1<left2 || left1>right2 || bottom1<top2 || top1>bottom2){
		return false;   //没有碰撞到
	}else{
		return true;    //碰撞到了
	}
}


//勾股定理 得到两个对象间的距离值
function getDistance(obj1, obj2){
	var a = obj1.offsetLeft - obj2.offsetLeft;
	var b = obj1.offsetTop - obj2.offsetTop;
	var dis = Math.sqrt(a*a + b*b);
	return dis;
}

}


//缓冲运动
//每个对象有单独的obj.timer定时器，多个对象的各自运动互不影响
//通过json的for in 每个对象可以同时改变自身多个属性
//通过函数回调 每个对象能形成链式运动
function bufferMove(obj,json,fn){              
	clearInterval(obj.timer);
	var iCur = 0;
	var iTagrget = 0;
	var iSpeed = 0;
	
	obj.timer = setInterval(function(){
		var bStop = true;                                  //每次定时器一开始 就设置bStop为ture

		for(attr in json){                                 //attr变成了json的属性名，iTarget变成了json的属性值json[attr]  
			if(attr == 'opacity'){             
					iCur = parseInt(parseFloat(getStyle(obj,attr)) * 100);		 
			}else{
					iCur = parseInt(getStyle(obj,attr));                       
			}
			iTarget = parseInt(json[attr]);
			iSpeed = (iTarget - iCur)/8;                                 
			
			if(iSpeed > 0){
					iSpeed = Math.ceil(iSpeed);
			}
			if(iSpeed < 0){
					iSpeed = Math.floor(iSpeed);
			}
			                                               //每次定时器周期里 for in 循环了n次 有n个同时进行的startMove函数 从而变化属性值
			if(iTarget != iCur){                        	 //n个startMove函数里只要有任意一个函数里的属性值还没到达终点 都会把bStop变为false
					bStop = false;                             //当所有属性值都到达终点后 也就是n个startMove函数都不执行这句的时候 
			}                                              //这次定时器周期最后的bStop没有被变化为false 还是true 
		                                                 //当这次定时器周期的bStop还是ture的话 在定时器周期函数最后判断bStop为ture，那就关闭定时器了
			if(attr == 'opacity'){                                       
					obj.style[attr] = (iCur + iSpeed)/100 + '';            
					obj.style.filter = 'alpha(opacity:'+(iCur+iSpeed)+')';  
			}else{
					obj.style[attr] = iCur + iSpeed + 'px';                
			}		
		}
		
		if(bStop){                                       //只要有任意一个还没到达终点 bStop会被变成false 不停止定时器
			clearInterval(obj.timer);                      //当所有属性值都到达终点后 bStop不会变false 还是原来的true 停止定时器         
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
