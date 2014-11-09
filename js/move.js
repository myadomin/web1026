//运动函数 

function getStyle(obj,attr){
	if(obj.currentStyle){
		return obj.currentStyle[attr];
	}else{
		return getComputedStyle(obj,false)[attr];
	}
}


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

