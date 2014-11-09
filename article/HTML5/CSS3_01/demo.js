//2D操作 IE9+ firebox chorme
window.onload = function(){


	//第一部分：css3模拟钟表 -----------------------------------------
	var oClock = document.getElementById('clock');
	var oUl1 = document.getElementById('ul1'); 

	//动态生成60个li 
	for(var i=0; i<60; i++){
		var oLi = document.createElement('li');
		oUl1.appendChild(oLi);
	}

	//画分钟刻度 设定60个li的css transform: rotate(xxxdeg) 
	var aLi = oUl1.getElementsByTagName('li');
	for(var i=0; i<aLi.length; i++){
		aLi[i].style.transform = 'rotate(' + 6*i + 'deg)';
		aLi[i].style.webkitTransform = 'rotate(' + 6*i + 'deg)';	 
	}

	//每秒循环
	showTime();
	setInterval(function(){
		showTime();
	}, 1000);
	//设定时分秒针 根据当前电脑时间 设定css transform: rotate(xxxdeg) 
	function showTime(){
		var nHour = new Date().getHours();
		var nMin = new Date().getMinutes();
		var nSec = new Date().getSeconds();
		var oHour = document.getElementById('hour');
		var oMin = document.getElementById('min');
		var oSec = document.getElementById('sec');
		oHour.style.transform = 'rotate(' + 30*(nHour+nMin/60) + 'deg)';
		oMin.style.transform = 'rotate(' + 6*(nMin+nSec/60) + 'deg)';
		oSec.style.transform = 'rotate(' + 6*nSec + 'deg)';
		oHour.style.webkitTransform = 'rotate(' + 30*(nHour+nMin/60) + 'deg)';
		oMin.style.webkitTransform = 'rotate(' + 6*(nMin+nSec/60) + 'deg)';
		oSec.style.webkitTransform = 'rotate(' + 6*nSec + 'deg)';
	}
	


	//第二部分：扇形菜单 -----------------------------------------
	var oHome = document.getElementById('home');
	var aMenuList = document.getElementById('menu').getElementsByTagName('div');
	var menuFlag = true;

	oHome.onclick = function(){
		if(menuFlag){	//展开
			//改变后面5个div的css transform: translate(xxpx, xxpx)
			for(var i=1; i<aMenuList.length; i++){
				//假设5个菜单平均分配在半径为200的圆轨迹的0度到90度 得出如下left top值
				var nLeft = 200*Math.cos(22.5*(i-1)*Math.PI/180);
				var nTop = 200*Math.sin(22.5*(i-1)*Math.PI/180);
				if(i == 5){		//在较低版本的chorme firefox浏览器中 cos90度不是0 而是无限接近0
					nLeft = 0;	//就会造成translate(0px, 200px)不能正确运动 所以这里强制设置为0
				}
				aMenuList[i].style.transform = 'translate('+ nLeft +'px, '+ nTop +'px)';
				aMenuList[i].style.webkitTransform = 'translate('+ nLeft +'px, '+ nTop +'px)';
			}
		}else{		//收缩
			for(var i=1; i<aMenuList.length; i++){
				aMenuList[i].style.transform = 'translate(0px, 0px)';
				aMenuList[i].style.webkitTransform = 'translate(0px, 0px)';
			}
		}
		menuFlag = !menuFlag;
	}


}


