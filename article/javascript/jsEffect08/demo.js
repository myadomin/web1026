//土豆网右下角效果
//运动函数的链式运动
window.onload = function(){
	var oBtn = document.getElementById("but");
	var oBottom = document.getElementById("v_bottom");
	var oBox = document.getElementById("v_box");
	var oClose = document.getElementById("btn_close");
	
	oBtn.onclick = function(){
		bufferMove(oBottom,{"right":"0px"},function(){
			oBox.style.display = "block";
			bufferMove(oBox,{"bottom":"0px"});
		})
	}
	
	oClose.onclick = function(){
		bufferMove(oBox,{"bottom":"-315px"},function(){
			oBox.style.display = "none";
			bufferMove(oBottom,{"right":"-165px"});
		})
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

//获取css属性
function getStyle(obj,attr){
	if(obj.currentStyle){
		return obj.currentStyle[attr];
	}else{
		return getComputedStyle(obj,false)[attr];
	}
}

