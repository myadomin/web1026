
//关于为什么要加遮罩层
//因为如果不加遮罩层 那onmouseover out就要加在oSmall上面
//那onmouseover后就会出现oFloat 而oFloat的z-index必定是大于oSmall的 然后就又触发了oSmall的onmouseout事件
//onmouseout后oFloat又会消失 消失后又会触发oSmall的onmouseover事件 然后oFloat又出现 最后oFloat不断出现消失
//所以加上遮罩层 把onmouseover out加在遮罩层上 并且遮罩层的z-index大于oFloat 
//这样oFloat出现后 遮罩层是在oFloat之上 遮罩层还依然是onmouseover 
//另一种解决办法：如果不想加遮罩层 而是直接在oSmall上加鼠标移入移出事件 
//那onmouseover onmouseout分别改成onmouseenter onmouseleave 
//这样虽然oFloat在oSmall上面 但是oFloat是oSmall的子元素 onmouseenter leave事件会自动忽略子元素的存在
window.onload = function(){
	var oFloat = document.getElementById("float_pic");
	var oMark = document.getElementById("mark");
	var oSmall = document.getElementById("small_pic");
	var oImg1 = document.getElementById('img1');
	var oBig = document.getElementById('big_pic');
	var oImg2 = document.getElementById('img2');
  
	oMark.onmouseover = function(ev){
		oFloat.style.display = "block";
		oBig.style.display = "block";
	}
		 
  	oMark.onmouseout = function(){
	  	oFloat.style.display = "none"; 
	  	oBig.style.display = "none";  
	}
	
	oMark.onmousemove = function(ev){        
		oEvent = ev||event;
		x = oEvent.clientX - oFloat.offsetHeight/2;        	//这里用的是fixed相对整个窗口的定位  首先通过这行计算让鼠标永远处于oFloat中心
		y= oEvent.clientY  - oFloat.offsetHeight/2;        	//如果#float_pic用absolute定位 那就是x再减去oSmall.offsetLeft 下面的判断值也减去oSmall.offsetLeft
		
		if(x < (oSmall.offsetLeft + 1 + oImg1.offsetLeft)){   	//再通过这4个判断显示oFloat  move范围
				x = oSmall.offsetLeft + 1 + oImg1.offsetLeft;
		}
		if(x > (oSmall.offsetLeft + 1 + oImg1.offsetLeft + oImg1.offsetWidth - oFloat.offsetWidth)){
				x = oSmall.offsetLeft + 1 + oImg1.offsetLeft + oImg1.offsetWidth - oFloat.offsetWidth;
		}
		if(y < (oSmall.offsetTop + 1 + oImg1.offsetTop)){
				y = oSmall.offsetTop + 1 + oImg1.offsetTop;
		}
		if(y > (oSmall.offsetTop + 1 + oImg1.offsetTop + oImg1.offsetHeight - oFloat.offsetHeight)){
				y = oSmall.offsetTop + 1 + oImg1.offsetTop + oImg1.offsetHeight - oFloat.offsetHeight;
		}
		//document.title = oSmall.offsetLeft +"||"+ oImg1.offsetLeft +"||"+ oSmall.offsetWidth +"||"+ oFloat.offsetHeight/2;
		
		oFloat.style.left = x + 'px';
		oFloat.style.top = y + 'px';	
		
		//计算oFloat与大图移动比例
		var rate = (oImg2.offsetWidth - oBig.offsetWidth)/(oImg1.offsetWidth - oFloat.offsetWidth)
		oImg2.style.left =  - rate * (x - (oSmall.offsetLeft + 1 + oImg1.offsetLeft)) + "px";		 
		oImg2.style.top =  - rate * (y - (oSmall.offsetTop + 1 + oImg1.offsetTop)) + "px";	
	}	 
}


 