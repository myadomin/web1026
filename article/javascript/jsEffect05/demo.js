//苹果官网弹性运动

window.onload = function(){
	var aLi = document.getElementById("img_ul").getElementsByTagName("li");
	var nextBtn = document.getElementById("next");
	var prevBtn = document.getElementById("prev");
	var disX = aLi[0].offsetWidth;
	var oSpan = document.getElementById("active");
 	

 	//所有的li都是float left布局形成了一行 后续要运动操作li就必须变成absolute而且样式依然不变 如下操作进行这个变化
 	//首先设置li的的left值为他的offsetLeft 
	for(var i=0 ; i<aLi.length ; i++){                 
		aLi[i].style.left = aLi[i].offsetLeft + "px";
	}
	//li都得到left以后（必须都得到之后） 将所有li设置为绝对定位 所以下面和上个循环不能写进一个循环里
	//这样布局没有任何变化 由原来的左浮变成了li绝对定位（相对父级是ul）便于后续运动 ul父级div负责溢出隐藏一半li   
	for(var i=0 ; i<aLi.length ; i++){          
		aLi[i].style.position = "absolute";       
	}                                                     


	//左移动 先依次移动ul前半部分的li 过了800毫秒后再依次移动后半部分                                                   
	nextBtn.onclick = function(){                    
		var fristLiLeft = parseInt(getStyle(aLi[0],"left")); 

		//除非第一个li在位置0 那点击nextBtn才有效 elaMove可能会在很短的几个瞬间处于0位置 但是时间非常短 所以不会出问题 
		//这样moveToLeftHalf moveToRightHalf函数中的各自定时器才能不同时开启 如果同时开启就会混乱
		//如果让定时器timer变为全局变量 两个函数共有 一进moveToLeftHalf函数就清除time也不行 那6张图片的某张还没开始移动就清除time了 所以只有这种办法
	  	if(fristLiLeft != 0){                  
	  		return;                              
	  	}   

	  	//从第0张到第aLi.length/2张图片(ul前半部分)开始依次运动
	    moveToLeftHalf(0);  

	    //800ms后第aLi.length/2张到aLi.length/2张(ul后半部分)开始依次运动                           
		setTimeout(function(){               
			moveToLeftHalf(aLi.length/2);
		},800);
	  	
	  	//底部小按钮的运动
		elaMove(oSpan,{"left":553});
		this.className = "btn_color";
		prevBtn.className = "";  	
	}
		
	//右移动 先依次移动ul前半部分的li 过了800毫秒后再依次移动后半部分  
	prevBtn.onclick = function(){                     
		var lastLiLeft = parseInt(getStyle(aLi[11],"left"));

	  	if(lastLiLeft != (aLi.length/2-1)*disX){       
	  		return;																			
	  	}
	  	
	    moveToRightHalf(aLi.length-1);

		setTimeout(function(){
			moveToRightHalf(aLi.length/2-1);
		},800);
		
		elaMove(oSpan,{"left":413});
		this.className = "btn_color";
		nextBtn.className = "";
	}


	//左移动 让第firstImgIndex张到firstImgIndex+aLi.length/2张图片 依次每隔100毫秒开始移动
	function moveToLeftHalf(firstImgIndex){               
	  var i = firstImgIndex;
		var timer = setInterval(function(){
			elaMove(aLi[i],{"left":(i-aLi.length/2)*disX});
			i++;	
			if(i >= (firstImgIndex + aLi.length/2)){
				clearInterval(timer);
			};
		},100);	
	}
	

	//右移动 让第firstImgIndex张到firstImgIndex-aLi.length/2张图片 依次每隔100毫秒开始移动
	function moveToRightHalf(firstImgIndex){              
	  var i = firstImgIndex;
		var timer = setInterval(function(){
			elaMove(aLi[i],{"left":(i)*disX});
			i--;	
			if(i <= (firstImgIndex - aLi.length/2)){
				clearInterval(timer);
			};	
		},100);	  	
	}; 
	                                                   
}


