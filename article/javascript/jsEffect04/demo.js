
//原理分析 
//给document加onmousemove事件 及时得到当前鼠标坐标点和图片中心点
//得到这两个点后通过勾股定理得到两点间的距离dsitance 
//构建数学公式 形成distance越小图片放大比率越大
window.onload = function(){
	var aImg = document.getElementsByTagName('img');
	var oMenu = document.getElementById('menu');
	var aInput = document.getElementsByTagName('input');
	var imgWidth = aImg[0].offsetWidth;
	var imgHeight = aImg[0].offsetHeight;  //预存还没开始变化的图片的宽高

	document.onmousemove = function(ev){
		var oEvent = ev || event;
		var mouseX = oEvent.clientX;
		var mouseY = oEvent.clientY;

		//对所有图片开始进行处理
		for(var i=0; i<aImg.length; i++){
			//centerX centerY分别表示各个图片的中心点的left top值
			//centerX为图片的offsetLeft加父级的offsetLeft加上自身宽度的一半 
			//这里aImg元素是absolute定位 所有的浏览器offsetLeft都是相对父级距离 不需要考虑兼容性
			var centerX = aImg[i].offsetLeft + oMenu.offsetLeft + aImg[i].offsetWidth/2;
			var centerY = aImg[i].offsetTop + oMenu.offsetTop + aImg[i].offsetWidth/2;

			//diffX代表鼠标点left值与某个图片中心点的left值的差值 
			var diffX = mouseX - centerX;
			var diffY = mouseY - centerY;

			//应用勾股定理 得出鼠标点距离某个图片中心点的距离 就是diffX平方加diffY平方然后开平方差 
			var distance = Math.sqrt(Math.pow(diffX, 2) + Math.pow(diffY, 2));

			//我们希望distance越小 图片越大  distance越大 图片越小 得出如下比例rate
			//rate介于1到2之间 参数150决定了旁边其他的图片相对当前图片的大小 可以不断调整
			var rate = 2 - distance/150;    
			if(rate < 1){     
				rate = 1;
			}
			aInput[i].value = rate;  //数据验证
			
			//为什么这里用imgWidth预存好的宽高 是为了以后图片改变了图片大小 这个程序还可以复用
			//那为什么计算centerX的时候不能用预存好的imgwidth 
			//因为每次mouseover都要及时计算一次aImg[i].offsetWidth 这样才能保证得到正确的中心点坐标
			aImg[i].style.width = imgWidth * rate + 'px';
			aImg[i].style.height = imgHeight * rate + 'px';

		}
	}
}