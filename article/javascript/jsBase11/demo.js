
//运动函数封装 最终封装成move.js
window.onload = function(){

	//一：测试封装函数 ----------------------------------------- 
	var oDiv1 = document.getElementById("div1");
	var oDiv2 = document.getElementById("div2");
	var oDiv3 = document.getElementById("div3");
	var oDiv4 = document.getElementById("div4");
	var oDiv5 = document.getElementById("div5");
	var aDiv = document.getElementsByTagName("div");

	//1：缓冲运动
	//每个对象有单独的obj.timer定时器，多个对象的各自运动互不影响
	//通过json的for in 每个对象可以同时改变自身多个属性
	//通过函数回调 每个对象能形成链式运动
	oDiv1.onclick = function(){
		bufferMove(oDiv1, {"left":"800px", "opacity":"0.2"}, function(){
			bufferMove(oDiv1, {"left":"300px", "opacity":"1"});
		}); 
	}
	
	//2：匀速运动
	//每个对象有单独的obj.timer定时器，多个对象的各自运动互不影响
	//通过json的for in 每个对象可以同时改变自身多个属性
	//通过函数回调 每个对象能形成链式运动
	oDiv2.onclick = function(){
		uniMove(oDiv2,{"left":"800px", "opacity":"0.3"},function(){
			uniMove(oDiv2,{"width":"250px", "opacity":"1"});
		});  
	}
	
	//3：弹性运动
	//每个对象有单独的obj.timer定时器，多个对象的各自运动互不影响
	//通过json的for in 每个对象可以同时改变自身多个属性
	//通过函数回调 每个对象能形成链式运动 不支持opacity的变化
	oDiv3.onclick = function(){
		elaMove(oDiv3,{"left":"800px", "width":"200px"},function(){
			elaMove(oDiv3,{"width":"100px"});
		}); 
	}
	
	//4：碰撞运动
	oDiv4.onclick = function(){
		colliMove(oDiv4); 
	}
	
	//5：其他运动 模拟重力
	oDiv5.onclick = function(){
		otherMove(oDiv5);   
	}
 
}

 

//二：缓冲运动函数封装过程 -----------------------------------------
function getStyle(obj,attr){
	if(obj.currentStyle){
		return obj.currentStyle[attr];
	}else{
		return getComputedStyle(obj,false)[attr];
	}
}
//1:某个对象的某个属性值 改变到某个属性值的运动封装
/*function bufferMove1(obj,attr,iTarget){
	clearInterval(obj.fMove);
	obj.fMove = setInterval(function(){
		if(attr == 'opacity'){              //如果传入的参数是 opacity
			iCur = parseInt(parseFloat(getStyle(obj,attr)) * 100);		//那么iCur就是取小数 为了避免小数计算 乘以100取整
		}else{
			iCur = parseInt(getStyle(obj,attr));                       	//获取计算后的（一般是css里）任何一个属性值都可以
		}
		iSpeed = (iTarget - iCur)/8;                                   	//获取的属性值相对目标值 做缓冲型数值变化
		
		if(iSpeed > 0){
			iSpeed = Math.ceil(iSpeed);
		}
		if(iSpeed < 0){
			iSpeed = Math.floor(iSpeed);
		}
		
		if(iTarget == iCur){
			clearInterval(obj.fMove);
		}else{
			if(attr == 'opacity'){                                      //如果传入的参数是 opacity
				obj.style[attr] = (iCur + iSpeed)/100 + '';             //W3C 最后将数字转换为字符串
				obj.style.filter = 'alpha(opacity:'+(iCur+iSpeed)+')';  //低版本IE  		
			}else{
				obj.style[attr] = iCur + iSpeed + 'px';                 //缓冲型的每次数值变化 体现到css样式里去，一直循环一直体现
			}
		}
	},20);
}*/


//2：链式缓冲运动 在上面的基础上增加链式运动 也就是一个运动完成后能自动接着第二次....第n次运动
/*function bufferMove2(obj,attr,iTarget,fn){
	clearInterval(obj.fMove);
	obj.fMove = setInterval(function(){
		if(attr == 'opacity'){             
			iCur = parseInt(parseFloat(getStyle(obj,attr)) * 100);		 
		}else{
			iCur = parseInt(getStyle(obj,attr));                       
		}
		iSpeed = (iTarget - iCur)/8;                                 
		
		if(iSpeed > 0){
			iSpeed = Math.ceil(iSpeed);
		}
		if(iSpeed < 0){
			iSpeed = Math.floor(iSpeed);
		}
		
		if(iTarget == iCur){
			clearInterval(obj.fMove);       	//满足运动结束条件后 停止定时器
			if(fn){                         	//同时判断是否有第四个参数 如果有就执行第四个参数回调函数
				fn();                       	//如果第四个参数函数也是bufferMove 那就形成了链式运动
			}
		}else{
			if(attr == 'opacity'){                                       
				obj.style[attr] = (iCur + iSpeed)/100 + '';            
				obj.style.filter = 'alpha(opacity:'+(iCur+iSpeed)+')';  
			}else{
				obj.style[attr] = iCur + iSpeed + 'px';                
			}
		}
	},20);
}*/


//3：再在上面的基础上 改进做n个属性的缓冲型数值变化 改进opacity操作
//最终形成缓冲运动函数的封装
/* 缓冲运动
 * obj 运动对象
 * json 运动目标属性 如{"left":"800px","opacity":"0.5"} 
 * fn 回调函数
 */
function bufferMove(obj,json,fn){  
	var iCur = 0;
	var iTarget = 0;
	var iSpeed = 0;  
	var bStop = true;        
	clearInterval(obj.fMove);

	obj.fMove = setInterval(function(){
		bStop = true;                       	//每次定时器一开始 就设置bStop为ture
		
		for(attr in json){                  	//for in json 同时做n个属性的缓冲型数值变化
			if(attr == 'opacity'){   
				//对于opacity属性 传入0.x 然后放大100倍进行操作 后续赋值再除以100         
				iCur = parseInt(parseFloat(getStyle(obj,attr)) * 100);	
				iTarget = parseInt(parseFloat(json[attr]) * 100);		 
			}else{
				iCur = parseInt(getStyle(obj,attr)); 
				iTarget = parseInt(json[attr]);                       
			}
			iSpeed = (iTarget - iCur)/8;                                 
			
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
			if(iTarget != iCur){   
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



//三：匀速运动函数封装 -----------------------------------------
/* 匀速运动
 * obj 运动对象
 * json 运动目标属性 如{"left":"800px","opacity":"0.5"} 
 * fn 回调函数
 */
function uniMove(obj,json,fn){  
	var iCur = 0;  
	var iTarget = 0; 
	var Speed = 10;							//要改变运动速度 只有进函数内部改这里的数值
	var bStop = true; 
	clearInterval(obj.fMove);

	obj.fMove = setInterval(function(){
		bStop = true;                     	//每次定时器一开始 就设置bStop为ture

		for(attr in json){                	//for in json 同时做n个属性的缓冲型数值变化
			if(attr == 'opacity'){    
				//对于opacity属性 传入0.x 然后放大100倍进行操作 后续赋值再除以100         
				iCur = parseInt(parseFloat(getStyle(obj,attr)) * 100);	
				iTarget = parseInt(parseFloat(json[attr]) * 100);		          
			}else{
				iCur = parseInt(getStyle(obj,attr));
				iTarget = parseInt(json[attr]);                       
			}	                                
			
			if(iTarget - iCur > 0){
				iSpeed = Speed;          		
			}
			if(iTarget - iCur < 0){
				iSpeed = -Speed;
			}
			
			if( Math.abs(iTarget - iCur) < Math.abs(iSpeed) ){  	//如果最后一次的运动 目标值和当前值相差小于一个iSpeed 
				iSpeed = iTarget - iCur;							//那iSpeed就等于iTarget - iCur
			}
                                              
			if(iTarget != iCur){                       
				bStop = false;                   
			}
			else{									
				iSpeed = 0;              	//一旦某个json属性等于属性值后这个属性值变化的iSpeed变为0 以免最后还多加一次
			}                                              
                                             
			if(attr == 'opacity'){                                       
				obj.style[attr] = (iCur + iSpeed)/100 + '';            
				obj.style.filter = 'alpha(opacity:'+(iCur+iSpeed)+')';  
			}else{
				obj.style[attr] = iCur + iSpeed + 'px';                
			}		
		}
		
		if(bStop){                       	//只要有任意一个还没到达终点 bStop会被变成false 不停止定时器
			clearInterval(obj.fMove);    	//当所有属性值都到达终点后 bStop不会变false 还是原来的true 停止定时器         
			if(fn){                                                    
				fn();                                                  
			}
		}
	},20);
}



//四：弹性运动函数封装过程 -----------------------------------------
//1：加速 减速运动 形成类似永动的钟摆运动
/*function elaMove1(){
	clearInterval(timer);
	var oDiv1 = document.getElementById("div1");
	timer = setInterval(function(){
		if(oDiv1.offsetLeft < 300){ 	//类似永动的钟摆运动
				iSpeed1 += 1;           //加速运动 速度 0 1 2....正方向越来越快 一直到300速度达到最大 然后进入下一句
		}else{
				iSpeed1 -= 1;			//减速运动 速度 从最大 到最大-1 最大-2... 正方向速度越来越慢 一直到0 达到最右边
		}                       		//然后往回走 速度-1 -2...一直到offseLeft=300到达最大负速度 然后进入上面一句 负速度越来越小直到0 到达最左边
		
		//document.title = iSpeed;   	//可以增大定时间隔时间 拿这句看看速度的变化
		oDiv1.style.left = oDiv1.offsetLeft + iSpeed1 + "px";
	},30)
}*/


//2：永动钟摆运动的基础上 形成弹性运动 起始速度很大之后越来越小
//在上面的继承上封装提取出obj和iTarget 去掉timer = null;var iSpeed = 0;的全局变量声明 做成每个独立对象函数的私有部分
//外部除了选取元素 不留任何变量 这样各个对象间就不会互相影响了 
/*function elaMove2(obj,iTarget){
	clearInterval(obj.timer);                      //每个对象有自己的定时器 因为这里timer是属性 可以不先定义
	var iSpeed = 0;                                //每个对象有自己的私有变量iSpeed及初始速度 不影响其他对象iSpeed

	obj.timer = setInterval(function(){  
		//模拟现实中的摩擦力或空气阻力 形成真实世界弹性运动 改变5和0.7可以形成不同风格的弹性                                
    	iSpeed += (iTarget - obj.offsetLeft)/5;    //提取出obj和iTarget
    	iSpeed *= 0.7;		
			
		obj.style.left = obj.offsetLeft + iSpeed + "px";
		//从这句可以看出 指定的例子2中最终要到的位置不是指定位置 甚至可能相差2-3px 因为每次循环iSpeed的小数被忽略了
		document.title = obj.offsetLeft + "||" + iTarget;  
	},30)
}*/


//3：解决上面iSpeed小数被忽略的问题   
/*function elaMove3(obj,iTarget){
		clearInterval(obj.timer);                     
		var iSpeed = 0;                                
		var left = obj.offsetLeft;      	//私有化每个obj对象的left起始值为自身的obj.offsetLeft
		obj.timer = setInterval(function(){            
        	iSpeed += (iTarget - obj.offsetLeft)/5;    
        	iSpeed *= 0.7;
        	left = left + iSpeed;          	//left是预存的容器

          	//用left代替原来的obj.offsetLeft + iSpeed，因为left每次都可以存已加上iSpeed后形成的小数
          	//那这样相加n次的left 最终结果还是完全等于iTarget       
			obj.style.left = left + "px";  
			//从这句可以看出 指定的例子2中最终要到的位置就是指定位置了
			document.title = obj.offsetLeft + "||" + iTarget + "||" +iSpeed;  
		},30)
}*/


//4：最终位置是对了 可是由于小数积累下来的误差 最后时刻会形成多次1px的左右晃动
//正好还需要加上定时器停止条件 那当速度绝对值小于1而且目标点与最终位置小于1就停下 并且停止前强制最终位置等于指定位置
/*function elaMove4(obj,attr,iTarget,fn){
	clearInterval(obj.timer); 
	var iCur = 0;
	var iSpeed = 0;
	var iTarget = 0;                            
	var content = parseInt(getStyle(obj,attr));   	//容器初始值
	                                       
	obj.timer = setInterval(function(){    
		iCur = parseInt(getStyle(obj,attr));      	//循环获取改变或的属性值 基本就是left top一类的可以为负数的相对父级的绝对定位值
	    iSpeed += (iTarget - iCur)/5;             	//改变这个5 越大就冲的越慢
	    iSpeed *= 0.7;                            	//改变这个0.7 越大就摆动的幅度越大
	    content = content + iSpeed;                	//content容器暂存 每次循环累加保证每次小数不被舍去 最终能完全到达目标点
	  	
	  	//当速度绝对值小于1而且目标点与最终位置小于1就停下
	    if( Math.abs(iSpeed)<1 && Math.abs(content - iTarget)<1 ){  
    		clearInterval(obj.timer);
    		obj.style[attr] = iTarget + "px";    	//停下可能有1px误差 强行定住
    		if(fn){                             	//连缀                                           
				fn();                                                  
			}
	   
	    }else{	   
			obj.style[attr] = content + "px";                  		      
		}	
		//从这句可以看出 指定的例子2中最终要到的位置就是指定位置了	 
		// document.title = obj.offsetLeft + "||" + iTarget + "||" +iSpeed; 
	},30)
}	*/


//5：加上attr遍历及fn回调函数 最终形成elaMove弹性运动函数
/* 弹性运动
 * obj 运动对象
 * json 运动目标属性 如{"left":"800px","top":"50px"}  
 * fn 回调函数
 * 由于弹性运动会过界目标点 所以height opacity等不能为负值的属性不能用弹性运动
 */
function elaMove(obj,json,fn){
	clearInterval(obj.timer);                     
	var iCur = 0;
	var iSpeed = 0;
	var iTarget = 0;       
	                              
	obj.timer = setInterval(function(){
		var bStop = true;  
		
		for(attr in json){
			if(attr != "opacity"){
				iCur = parseFloat(getStyle(obj,attr));          		//由于每次循环iSpeed会形成小数 所以这里获取iCur用parseFloat
				iTarget = parseInt(json[attr]);
			    iSpeed += (iTarget - iCur)/5;                        	//冲击速度 改变这个5 越大就冲的越慢
			    iSpeed *= 0.7;                                       	//模拟摩擦力 改变这个0.7 越大说明摩擦力越小 摆动的幅度越大 如果为1 那就是永动钟摆运动了
		
			    if( Math.abs(iSpeed)<1 && Math.abs(iCur - iTarget)<1){ 	//当速度绝对值小于1而且目标点与最终位置小于1就停下
			    	obj.style[attr] = iTarget + "px";                	//停下可能有1px误差 强行定住
			    }else{	 	 
		    		obj.style[attr] = iCur + iSpeed + "px";  
		    		bStop = false;                 		      
				}		 
				document.title = iTarget +"||"+ iSpeed +"||"+ (iCur - iTarget);
			}
		}	
		
		if(bStop){       								//只要有任意一个还没到达终点 bStop会被变成false 不停止定时器
			clearInterval(obj.timer);                   //当所有属性值都到达终点后 bStop不会变false 还是原来的true 停止定时器         
			if(fn){                                                    
				fn();                                                  
			}
		}	
	},30)
}	



//五：碰撞运动函数封装 -----------------------------------------
/* 匀速碰撞运动
 * obj 运动对象
 * 实际应用记得设置定时器停止条件 
 * 需要设定碰撞的四周的位置从而设定碰撞到哪里回弹 
 */
function colliMove(obj){
	var iSpeedX = 15;
	var iSpeedY = 20; 
	var leftEnd = 0;  			//在这里设置碰撞四周的位置 这里的div是绝对定位的相对父级是窗口 所以设置四周为窗口的四周边线
	var rightEnd = document.documentElement.clientWidth - obj.offsetWidth;
	var topEnd = 0;
	var bottomEnd = document.documentElement.clientHeight - obj.offsetHeight;

	setInterval(function(){
		var iCurX = parseInt(getStyle(obj,"left")); 
		var iCurY = parseInt(getStyle(obj,"top"));
		var l = iCurX + iSpeedX
		var t = iCurY + iSpeedY
		
		if(l < leftEnd){
			iSpeedX *= -1;		//到边界 速度反向
			l = leftEnd;
		}
		if(l > rightEnd){
			iSpeedX *= -1;
			l = rightEnd;
		}
		if(t < topEnd){
			iSpeedY *= -1;
			t = topEnd;
		}
		if(t > bottomEnd){
			iSpeedY *= -1;
			t = bottomEnd;
		}

		obj.style.left = l + "px";
		obj.style.top = t + "px";
		
		document.title = iCurY +"||" + iSpeedY + "||||||x:" + iCurX +"||" + iSpeedX;
	},30);
}



//六：其他运动 -----------------------------------------
/* 其他运动
 * obj 运动对象
 * 如下函数式模拟重力及横向重力运动 实际应用记得设置定时器停止条件 
 * 在限定了碰撞范围的基础上 通过调参数模拟重力等现实运动
 */
function otherMove(obj){
	var iSpeedX = 0;    	//在这里设置初始的X Y方向速度
	var iSpeedY = 9; 
	var rateX = 0;      	//在这里模拟反弹后的减速度 在iSpeedY不等于0的情况下 例如Y设置小于1可以模拟重力 设置大于1越弹越快
	var rateY = 0.8;
	var acceX = 0;      	//(accelerated speed) 在这里加模拟加速度的值 设置值越大下落越快
	var acceY = 3; 
	var leftEnd = 0;    	//在这里设置碰撞四周的位置 这里的div是绝对定位的相对父级是窗口 所以设置四周为窗口的四周边线
	var rightEnd = document.documentElement.clientWidth - obj.offsetWidth;
	var topEnd = 0;
	var bottomEnd = document.documentElement.clientHeight - obj.offsetHeight;
	//以上数字都要调 不合适封装 例如模拟重力情况 设置如上 各种情况下记得找方法设置定时器停止条件 
	//速度为0停止  或者循环多了多少轮 或者速度到达多少停止等

	setInterval(function(){
		iSpeedX += acceX;         		//模拟重力或者横向重力下沉的感觉
		iSpeedY += acceY;
		
		var iCurX = parseInt(getStyle(obj,"left")); 
		var iCurY = parseInt(getStyle(obj,"top"));
		var l = iCurX + iSpeedX
		var t = iCurY + iSpeedY
		
		if(l < leftEnd){
			iSpeedX *= -rateX;        
			l = leftEnd;
		}
		if(l > rightEnd){
			iSpeedX *= -rateX;
			l = rightEnd;
		}
		if(t < topEnd){
			iSpeedY *= -rateY;  		//将1改成小数比例乘 模拟被弹起后的重力影响
			t = topEnd;
		}
		if(t > bottomEnd){
			iSpeedY *= -rateY;
			t = bottomEnd;
		}
		
		if(Math.abs(iSpeedX) < 1){    	//iSpeedX Y变成小数后 -0.x可能出问题 直接变为0
			iSpeedX = 0;
		}
		if(Math.abs(iSpeedY) < 1){                    
			iSpeedY = 0;
		}

		obj.style.left = l + "px";
		obj.style.top = t + "px";
		
		//document.title = iCurY +"||" + iSpeedY + "||||||x:" + iCurX +"||" + iSpeedX;
    	//最终l t能固定在碰撞位置 都是iSpeed会一直按0到iSpeedY（-rateY）间一直跳 此例子设置情况下就是 0到-2.4间循环跳
    	//实际应用需要设定定时器停止条件 记得打这句看看
	},30);
}



