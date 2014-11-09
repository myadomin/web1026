
//三角函数应用1
window.onload = function(){

	//1：绘制sin曲线
	var oBtn1 = document.getElementById('btn1');
	var oBtn1flag = false;
	oBtn1.onclick = function(){
		//只有第一次onclick事件有效
		if(oBtn1flag){
			return
		}
		oBtn1flag = true;

		var oDivSin = document.getElementById('sin');
		var oDivSinLeft = parseInt(getStyle(oDivSin, "left"));
		var oDivSinTop = parseInt(getStyle(oDivSin, "top"));
		var TimerSin = null;
		var num = 0;    	//角度
		var value = 100;    //波峰放大倍数

		var TimerSin = setInterval(function(){
			num++;     		 
			//x轴表示角度 角度每20ms加一
			oDivSin.style.left = oDivSinLeft + num + 'px';
			//y轴就是x轴对应角度通过Math.sin函数算出的值 
			//sin的参数必须是弧度 num度对应的弧度就是num*Math.PI/180
			oDivSin.style.top = oDivSinTop - Math.sin(num*Math.PI/180)*value + 'px';

			//如果degree累加了361次后 也就是361度后 关闭定时器 不再绘制曲线
			if(num == 361){       
				clearInterval(TimerSin);
			}

			//绘制轨迹 就是每次循环生成一个div 他的left top等于当次循环oDivSin的left top
			var oMarkSin = document.createElement('div'); 
			oMarkSin.className = 'mark';
			oMarkSin.style.background = 'red';
			document.body.appendChild(oMarkSin);
			oMarkSin.style.left = oDivSin.offsetLeft + 'px';
			oMarkSin.style.top = oDivSin.offsetTop + 'px';

		}, 20);

	}


	//2：圆周运动函数封装 封装详情见下面
	var oRed = document.getElementById('red');
	var oYellow = document.getElementById('yellow');
	var oBlue = document.getElementById('blue');
	var oGreen = document.getElementById('green');
	var oBtn2 = document.getElementById('btn2');
	var clickFlag = false;
	oBtn2.onclick = function(){
		//只有第一次onclick事件有效
		if(clickFlag){
			return
		}
		clickFlag = true;

		//圆心400 400 轨迹颜色#8E9 8000毫秒走完一圈
		circularMotion(oRed, 400, 400, '#8E9', 8000); 
		//圆心400 400 轨迹颜色#A38 10000毫秒走完一圈 
		circularMotion(oYellow, 400, 400, '#A38', 10000);
		//圆心400 400 轨迹颜色#591 12000毫秒走完一圈
		circularMotion(oBlue, 400, 400, '#591', 12000);
		//圆心400 400 轨迹颜色#901 6000毫秒走完一圈	
		circularMotion(oGreen, 400, 400, '#901', 6000);	
	}	

}


//封装circularMotion的过程 ------------------------------------------
//第一步 做圆周运动的起始点位置固定从度数0开始
/*function circularMotion(obj, centerX, centerY, time){
	var degree = 0; 			     //定义度数 
	var radian = 0;                  //定义弧度
	var flag = true;                 //开关

	var oDivCenter = document.createElement('div');  	//创建绿色小点作为圆心 测试用
	oDivCenter.className = 'center';
	document.body.appendChild(oDivCenter);
	oDivCenter.style.left = centerX - oDivCenter.offsetWidth/2 + 'px';
	oDivCenter.style.top = centerY - oDivCenter.offsetHeight/2 + 'px';

	var objX = parseInt(getStyle(obj, 'left'));  		//得到obj的left值  
	var objY = parseInt(getStyle(obj, 'top'));
	var radius = getDistance(objX, objY, centerX, centerY);  //计算出半径radius

	setInterval(function(){
		degree++;        						//当前度数 每30ms度数加1度
		radian = (degree/180)*Math.PI;     		//当前弧度
		
		// Math.cos(radian) = tmpX/radius; 		//通过sin cos得到这两个公式
		// Math.sin(radian) = tpmY/radius;      //计算出下面的tmpX tpmY

		// tmpX = Math.cos(radian)*radius; 
		// tpmY = Math.sin(radian)*radius;      

		//centerX + Math.cos(radian)*radius算出的是obj左上点 所以是obj左上点做圆周运动
		//所以再减去obj.offsetWidth/2 就是obj中心点做圆周运动了
		obj.style.left = centerX + Math.cos(radian)*radius - obj.offsetWidth/2 + 'px';  
		obj.style.top = centerY + Math.sin(radian)*radius - obj.offsetHeight/2 + 'px';

		if(degree == 361){                      //如果degree累加到361 关闭开关 不再创建oDivMark
			flag = false;
		}
		if(flag){                               //degree从1到360 每加1创建一个oDivMark 形成圆型轨迹
			var oDivMark = document.createElement('div');
			oDivMark.className = 'mark';
			document.body.appendChild(oDivMark);
			oDivMark.style.left = centerX + Math.cos(radian)*radius - oDivMark.offsetWidth/2 + 'px';  
			oDivMark.style.top = centerY + Math.sin(radian)*radius - oDivMark.offsetHeight/2 + 'px';
		}

	},time/360);

}*/


//第二步 问题分析
//但是上面的函数有一个问题 由于起始var degree=0; 所以运动点永远是从degree=0开始做圆周运动
//为了让任意点从自身位置起始做圆周运动 起始定义的degree就不能为0了 而是这个点自身的originDegree
//从上面的obj.style.left = centerX + Math.cos(radian)*radius - obj.offsetWidth/2 + 'px'; 
//可以反推导 得到求出任意点起始originRadian的公式如下
// Math.cos(originRadian) = (objX - centerX)/radius;
// originRadian = Math.acos((objX - centerX)/radius);
// originDegree = (originRadian/Math.PI)*180;    
// originDegree = ((Math.acos((objX - centerX)/radius))/Math.PI)*180; 
//由于Math.acos()本身会出现正负的情况 所以当起始点在第一第二象限的时候originDegree要取反
//所以最终要判断象限决定originDegree是否取反 改进后的函数如下
/**
 * obj代表想做圆周运动的元素 必须css中设置好定位
 * centerX 圆周运动的圆心X坐标
 * centerY 圆周运动的圆心Y坐标
 * markColor 轨迹颜色
 * time 多少毫秒走一圈
 */
function circularMotion(obj, centerX, centerY, markColor, time){
	var originDegree = 0; 			 //定义起始位置的度数 
	var degree = 0  				 //定义实际位置的度数 
	var radian = 0;                  //定义弧度
	var flag = true;                 //开关

	//创建绿色小点作为圆心 测试用
	var oDivCenter = document.createElement('div');  		
	oDivCenter.className = 'center';
	document.body.appendChild(oDivCenter);
	oDivCenter.style.left = centerX - oDivCenter.offsetWidth/2 + 'px';
	oDivCenter.style.top = centerY - oDivCenter.offsetHeight/2 + 'px';

	//得到obj的left值 计算出半径radius 
	var objX = parseInt(getStyle(obj, 'left'));  			
	var objY = parseInt(getStyle(obj, 'top'));
	var radius = getDistance(objX, objY, centerX, centerY);	 

	//设置起始位置的度数
	originDegree = ((Math.acos((objX - centerX)/radius))/Math.PI)*180  
	//当起始点在第一第二象限的时候originDegree要取反
	if(objY < centerY){
		originDegree = -originDegree;
	}
	//将起始位置度数赋值给实际位置度数 做后面的累加
	degree = originDegree;                  	

	var Timer = setInterval(function(){
		degree++       							//实际位置度数 每30ms度数加1度
		radian = (degree/180)*Math.PI;     		//实际位置弧度
		
		// Math.cos(radian) = tmpX/radius; 		//通过sin cos得到这两个公式
		// Math.sin(radian) = tpmY/radius;      //计算出下面的tmpX tpmY

		// tmpX = Math.cos(radian)*radius; 
		// tpmY = Math.sin(radian)*radius;      

		//centerX + Math.cos(radian)*radius算出的是obj左上点 所以是obj左上点做圆周运动
		//所以再减去obj.offsetWidth/2 就是obj中心点做圆周运动了
		obj.style.left = centerX + Math.cos(radian)*radius - obj.offsetWidth/2 + 'px';  
		obj.style.top = centerY + Math.sin(radian)*radius - obj.offsetHeight/2 + 'px';

		//如果degree累加了360次后 关闭开关 不再创建oDivMark
		if(degree == originDegree + 361){      
			flag = false;
		}
		if(flag){      
			//degree每加1创建一个oDivMark 形成圆型轨迹                       
			var oDivMark = document.createElement('div');
			oDivMark.className = 'mark';
			oDivMark.style.background = markColor;
			document.body.appendChild(oDivMark);
			oDivMark.style.left = centerX + Math.cos(radian)*radius - oDivMark.offsetWidth/2 + 'px';  
			oDivMark.style.top = centerY + Math.sin(radian)*radius - oDivMark.offsetHeight/2 + 'px';
		}

	},time/360);

}


//勾股定理 计算两点间的距离 x1,y1代表第一个点的坐标点 y1,y2代表第二个点的坐标点
function getDistance(x1, y1, x2, y2){
	return Math.sqrt( Math.pow((x1-x2),2) + Math.pow((y1-y2),2) );
}

//获取计算后的属性
function getStyle(obj,attr){
	if(obj.currentStyle){               //IE
		return obj.currentStyle[attr];       
	}else{                              //W3C 
		return getComputedStyle(obj,false)[attr];
	}
}

