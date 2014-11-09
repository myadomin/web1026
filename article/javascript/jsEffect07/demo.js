
//图片360度旋转展示
window.onload = function(){
	var oDiv = document.getElementById('scroll_img');
	var oDivLeft = oDiv.offsetLeft;
	var oDivWidth = oDiv.offsetWidth;
	var num = 0;

	//创建77个img 第一张显示 其他都隐藏
	for(var i=0 ; i<77 ; i++){
		var oNewImg = document.createElement('img');
		oNewImg.src = 'img/aa ('+(i+1)+').jpg';
		oNewImg.style.display = 'none';
		if(i == 0){
			oNewImg.style.display = 'block';
		}
		oDiv.appendChild(oNewImg);
	}
	//获取aImg及oShowImg 必须等for完毕在这里才能获取
	var aImg = oDiv.getElementsByTagName('img')
	var oShowImg = aImg[0];
	
	//在图片区域拖拽 形成num从76到0到76到16的变化 通过num的变化显示第num个img 其他img隐藏
	oDiv.onmousedown = function(ev){
		oDiv.onmousemove = function(ev){
			var oEvent = ev || event;
			var x = oEvent.clientX; 

			//规定拖拽的鼠标坐标范围
			if(x < oDivLeft){                  
				x = oDivLeft;
			}
			if(x > oDivLeft + oDivWidth){
				x = oDivLeft + oDivWidth;
			}   
			//拖拽形成num的变化 假如200<x<841所以76-parseInt((x-200)/5)%77是76到第二轮的16                            
			num = 76 - parseInt((x-oDivLeft)/5)%77; 
	  		document.title = num; 		

	  		//通过num的变化显示第num个img 其他img隐藏
			oShowImg.style.display = 'none'      
            aImg[num].style.display = 'block';  
            oShowImg = aImg[num];
			
	  		return false;
		}
		
		document.onmouseup = function(){
			oDiv.onmousemove = null;
			document.onmouseup = null;
		}

		return false;
	}
}

