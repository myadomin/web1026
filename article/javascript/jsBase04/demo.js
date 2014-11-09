//DOM基本操作及简单优化

window.onload = function(){

	//1：DOM操作实例
	prepareSlideshow();
	
}

function moveElement(elementID,xFinal,yFinal,interval){   //参数都不加分号，后续是字符串的，具体到位置自己加分号
	var elem = document.getElementById(elementID);
	if(!elem.style.left){
		elem.style.left = '0px';                   //加了这两句，在prepareSlideshow()中就不需要初始化初始位置了
	}
	if(!elem.style.top){
		elem.style.top = '0px';
	}
	var xPos = parseInt(elem.style.left);
	var yPos = parseInt(elem.style.top);
	
  clearTimeout(elem.movement);                //每次开启定时器 清空上一次的定时器
         
	if(xPos == xFinal && yPos == yFinal){  
		return true;								    
	} 															  
	if(xPos<xFinal){		
		dist = Math.ceil((xFinal - xPos)/10);			//离得越远 每次移动的距离dist越多 所以移动的越快		   
		xPos = xPos + dist;											   
	}															    
	if(xPos>xFinal){		
	  dist = Math.ceil((xPos - xFinal)/10);
		xPos = xPos - dist;												                                  
	}															  
	if(yPos<yFinal){	
		dist = Math.ceil((yFinal - yPos)/10);							 
		yPos = yPos + dist;                         
	} 															 
	if(yPos>yFinal){ 		
		dist = Math.ceil((yPos - yFinal)/10);		 
		yPos = yPos - dist;								 
	}
	elem.style.left = xPos + 'px';
	elem.style.top = yPos + 'px'; 	
	
	var repeat = 'moveElement("'+elementID+'",'+xFinal+','+yFinal+','+interval+')'
  	elem.movement = setTimeout(repeat,interval);	       //回调 形成类似setInterval
}	

function prepareSlideshow(){
	var slideshow = document.createElement('div');     //在js DOM里面创建div和img 而不是写在HTML里 
	var preview = document.createElement('img');       //这样即使用户不开启JS 也能平稳退化 看不到滚动图片 也不影响其他效果
	var oTitle = document.getElementById('js_title');
	slideshow.appendChild(preview);
	document.body.insertBefore(slideshow, oTitle);
	slideshow.setAttribute('id','slideshow');          //创建的id=slideshow的div在css中设置了宽度100溢出隐藏 这样值显示400宽度图片的1/4
	preview.setAttribute('id','preview');
	preview.setAttribute('src','aa.jpg');
	
	var preview = document.getElementById('preview');
	preview.style.position = 'absolute';               //图片绝对定位
	
	var list = document.getElementById('linklist');
	var links = list.getElementsByTagName('a');        //给每个a加事件
	links[0].onmouseover = function(){
		moveElement('preview',-100,0,20);              //调用运动函数
	}		
	links[1].onmouseover = function(){
		moveElement('preview',-200,0,20);
	}
	links[2].onmouseover = function(){
		moveElement('preview',-300,0,20);
	}	
} 
 
 