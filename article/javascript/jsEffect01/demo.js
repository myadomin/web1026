
//仿FLASH的幻灯片
window.onload = function(){
	var oMark1 = document.getElementById("mark_left");
	var oMark2 = document.getElementById("mark_right");
	var oPrev = document.getElementById("prev");
	var oNext = document.getElementById("next");
	var oSmallUl = document.getElementById("smallimg").getElementsByTagName("ul")[0];
	var aSmallLi = oSmallUl.getElementsByTagName("li");
	var iNow = 0;
	var iMinZindex = 2;
	var oBigUl = document.getElementById("bigimg").getElementsByTagName("ul")[0];
	var aBigLi = oBigUl.getElementsByTagName("li");
	var oTxt = document.getElementById("text");
	var oNumber = document.getElementById("number");
	var oPlayimg = document.getElementById("playimg");
	var Timer = null;
	oSmallUl.style.width = aSmallLi[0].offsetWidth * aSmallLi.length + 'px';
	//调试的时候设置个大宽度的oSmallUl而且溢出不隐藏，最终程序让整个oSmallUl宽度等于aSmallLi宽度*i，
	//这样就能自适应oSmallUl宽度，然后再外层div溢出隐藏,总之不要用任何数字写死某个参数
	//这样即使添加到6张以上图片程序也不需要修改
	

	//左右按钮 移入移出淡入淡出
	oPrev.onmouseover = oMark1.onmouseover = function(){    
		bufferMove(oPrev,{"opacity":"1"});									
	}    
	//因为oPrev之后需要点击行为 所以他的z-index层级必须在oMrak1层的上面 
	//如果不加oPrev.onmouseover只加oMark1的 那一旦移动到oPrev区域 就不算是oMark1的区域了 就不会让oPrev不透明了
	//IE7+ 这里必须先设定好oMark1的background css 然后oMark1.onmouseover才有效                                                
	oPrev.onmouseout = oMark1.onmouseout = function(){
		bufferMove(oPrev,{"opacity":"0"});
	}
	oNext.onmouseover = oMark2.onmouseover = function(){
		bufferMove(oNext,{"opacity":"1"});
	}
	oNext.onmouseout = oMark2.onmouseout = function(){
		bufferMove(oNext,{"opacity":"0"});
	}
	

	//1:开定时器 定时改变iNow 变化大图 
	function autoPlay(){      
		iNow++;
		if(iNow == aSmallLi.length){
			iNow = 0;
		}
		tab();
	}
	
	Timer = setInterval(autoPlay, 3000);
	oPlayimg.onmouseover = function(){
		//一旦鼠标进入整个大div区域 就停止自动播放 
		// alert(11);   
		clearInterval(Timer);          
	}
	oPlayimg.onmouseout = function(){ 
		//一旦鼠标离开整个大div区域 就继续自动播放    
		Timer = setInterval(autoPlay, 3000);
	}
	

	//2:点击按钮 改变iNow 变化大图
	oPrev.onclick = function(){	
		//通过按钮点击改变iNow 类似于aSmallLi[i].onclick点击改变iNow		 
		iNow--;                  		
		if(iNow == -1){
			iNow = aSmallLi.length-1;
		}
		tab();
	}
	oNext.onclick = function(){
		iNow++;
		if(iNow == aSmallLi.length){
			iNow = 0;
		}
		tab();
	}
		

	//3:小图点击 通过被点击小图的this.index改变iNow 变化大图
	for(var i=0 ; i<aSmallLi.length ; i++){
    aSmallLi[i].index = i;                 
    	//移入移出小图 透明不透明
		aSmallLi[i].onmouseover = function(){  
			bufferMove(this,{"opacity":"1"});
		} 
		aSmallLi[i].onmouseout = function(){
			if(this.index != iNow){ 
				//除了已经被点击的图片 其他图片移出的时候变透明 
				//由于一刷新进来iNow是初始值0 此时没有触发过点击事件（也就是没执行过iNow = this.index;）
				//所以是第0个li移出也不会变透明,不过第一个li本身就有class active所以本身一进来就是不透明的 所以没关系          		
				bufferMove(this,{"opacity":"0.6"}); 
			}																	 		
		}
		
		//点击小图 通过改变iNow变化相应的大图
		aSmallLi[i].onclick = function(){       
			if(this.index == iNow){ 
				//如果当前被点击的图片刚点击过一次了 那此次点击就什么都不做            
				return;												    
			}
			//点击小图 通过改变iNow变化相应的大图
			iNow = this.index;                    
			tab();
		}		
	}
	

  	//4:上面的1 2 3通过改变iNowi然后执行这个tab() 从而变化大图
	function tab(){
		for(var i=0 ; i<aSmallLi.length ; i++){ 
			//点击事件一开始 所有图片全透明   	     
			bufferMove(aSmallLi[i],{"opacity":"0.4"});
		}
		//被点击的那个图片不透明
		bufferMove(aSmallLi[iNow],{"opacity":"1"});    
		
		//被点击的那张图片对应的大图显示 并且大图从高度0变成原本高度从而造成类似下拉效果
		//由于6张大图全部是定位叠在一起的 第一张z-index是2 其他是1 所以一刷新显示的是第一张 
		//将被点击的那张z-index进行iMinZindex++ 也就是被点击小图对应的大图那张z-index变成3，然后显示了。
		//由于css中包裹图片的aBigLi设置了overflow:hidden，图片显示以后马上让这张大图的高度为0，这张图片又消失
		aBigLi[iNow].style.zIndex = iMinZindex++;    
		aBigLi[iNow].style.height = 0;
		//开始运动，让高度从0开始缓冲到oBigUl.offsetHeight，随着高度的增加，图片开始逐步显示，从而造成下拉刷新的效果
		bufferMove(aBigLi[iNow],{"height":oBigUl.offsetHeight});
		
		//当第i个li被点击后（第i个小图），ul的left也要随之相应左移动i-1个li的距离 
		//小图分别是第0 1 2 3 4 5张，当第1 2 3 4张的时候左移动iNow-1个aSmallLi宽度的距离
		//第0张移动0，第5张移动的和他上一张一样多 所以再加上判断第0张及最后一张（也就是第(aSmallLi.length-1)张，不要写死，后续可能添加图片到不止6张）
		if(iNow == 0){
				bufferMove(oSmallUl,{"left":"0px"}); 
		}else if(iNow == aSmallLi.length-1){
				bufferMove(oSmallUl,{"left":-(iNow-2)*aSmallLi[0].offsetWidth}); 
		}else{
				bufferMove(oSmallUl,{"left":-(iNow-1)*aSmallLi[0].offsetWidth}); 
		}
		
		//改变左右文本
		oTxt.innerHTML =  aSmallLi[iNow].getElementsByTagName("img")[0].alt;      
		oNumber.innerHTML = (iNow+1) + "/" + aSmallLi.length;
	}

}

