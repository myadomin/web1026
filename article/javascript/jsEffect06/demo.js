
//腾讯视频tabSwtich
//主要原理
//所有p大图全部通过绝对定位叠在一起 一刷新进来除了第一张全部透明 
//点击小图js中变化某张大图的透明度为1 从而显现这样大图
//通过按钮的点击 让小图形成的ul运动 
window.onload = function(){
	var oDiv = document.getElementById("box");
	var oIco = document.getElementById('ico');
	var oPic = document.getElementById('pic');
	var oText = document.getElementById('text');
	var oBtn1 = document.getElementById('btn1');
	var oBtn2 = document.getElementById('btn2');
	var aIcoLi = oIco.getElementsByTagName('li');
	var aPicLi = oPic.getElementsByTagName('li');
	var aTextLi = oText.getElementsByTagName('li');
	var iNow = 0;
	var iBtn = 0;
	var timer = null;
	aTextLi[0].style.display = "block";
	
	//给每个icoLi加上index 每个被点击icoLi的index给到全局iNow 然后调用tab()
	for(var i=0 ; i<aIcoLi.length ; i++){
		aIcoLi[i].index = i;                   
		aIcoLi[i].onclick = function(){	
			iNow = this.index;	                
			tab();	
		}
	}
	
	//自动播放
	timer = setInterval(autoPlay,2500);       
	oDiv.onmouseover = function(){
		clearInterval(timer);
	}
	oDiv.onmouseout = function(){
		timer = setInterval(autoPlay,2500);
	}	

	//以iBtn记录被点击的次数 做相应的ul移动
	oBtn2.onclick = function(){                      
		if(iBtn < aIcoLi.length/2){                                  
 			iBtn++;
			bufferMove(oIco, {"left":-(iBtn) * aIcoLi[0].offsetWidth});	
		}
		BtnStyle();
	}
	oBtn1.onclick = function(){
	 	if(iBtn > 0){ 
 			iBtn--;
			bufferMove(oIco, {"left":-(iBtn) * aIcoLi[0].offsetWidth});	
		}		
		BtnStyle();
	}

	//通过iNow的自动加1 调用tab()
  	function autoPlay(){ 
		iNow++;                         
		if(iNow == aIcoLi.length){
			iNow = 0;	 
		}
		tab();	
								
		if(iNow >= iBtn + aIcoLi.length/2){                //通过当前的iNow 转化为相应的iBtn 从而变化ul left
			iBtn = iNow - (aIcoLi.length/2 - 1);                    
		}else if(iNow<iBtn){
			iBtn = iNow;
		}
		bufferMove(oIco,{"left":-(iBtn) * aIcoLi[0].offsetWidth});	
		BtnStyle();			 
	}

	//根据不同的iNow 做对应的图片淡入淡出 对应的字体现实 对应的icoLi样式变化
	function tab(){                             
		for(var i=0 ; i<aIcoLi.length ; i++){
			aIcoLi[i].className = '';
			aTextLi[i].style.display = 'none';
			aPicLi[i].style.opacity = 0;
		}
		aIcoLi[iNow].className = 'active';
		aTextLi[iNow].style.display = 'block';
		bufferMove(aPicLi[iNow], {opacity:"1"});
	}

	//左右按钮的样式变化
	function BtnStyle(){
		oBtn1.className = "";
		oBtn2.className = "";
		if(iBtn == aIcoLi.length/2){
			oBtn2.className = "move_end";
		}
		if(iBtn == 0){
			oBtn1.className = "move_end";
		}		
	}
	 
}


