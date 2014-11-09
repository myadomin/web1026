//HTML5--canvas
window.onload = function(){

	//第一部分：基础操作 ------------------------------
	var oC1 = document.getElementById('canvas1');
	var oGc1 = oC1.getContext('2d');

	//画一条线段
	oGc1.beginPath();			//打开路径 
	oGc1.lineWidth = 3;  		//定义路径宽度是4px
	oGc1.strokeStyle = '#0f0'; 	//定义路径颜色
	oGc1.moveTo(20,20);  		//定义路径的起始点 画布的left20 top20
	oGc1.lineTo(100,50); 		//定义路径的终结点
	oGc1.closePath();			//关闭路径 保证这里的设置不影响下一次操作
	oGc1.stroke();				//画线
	
	//画三角形
	oGc1.beginPath();
	oGc1.lineWidth = 10; 
	oGc1.strokeStyle = "#405";
	oGc1.fillStyle = '#a53';
	oGc1.moveTo(500, 250);
	oGc1.lineTo(700, 250);
	oGc1.lineTo(500, 400);
	oGc1.lineTo(500, 250);
	oGc1.closePath();			//关闭路径
	oGc1.stroke();				//画线
	oGc1.fill();				//填充
	
	//画矩形边框
	oGc1.beginPath();					//打开路径
	oGc1.lineWidth = 10;  				//路径边框宽度3px 如果不定义就默认1px 但是会出现2px 解决办法就是位置加0.5
	oGc1.strokeStyle = '#97F'; 			//路径边框颜色  
	oGc1.lineJoin="round";				//圆形边角
	oGc1.closePath();					//关闭路径
	oGc1.strokeRect(400, 50, 100, 50); 	//位置 画线
	
	//画实心矩形 
	oGc1.beginPath();					//打开路径
	oGc1.fillStyle = '#47F'; 			//填充矩形的颜色  
	oGc1.closePath();					//关闭路径
	oGc1.fillRect(550, 50, 100, 50);	//位置 填充
	oGc1.clearRect(560, 60, 30, 30);	//位置 清除填充
	
	//画一个空心圆形
	oGc1.beginPath();	//打开路径
	oGc1.lineWidth = 3;  		 
	oGc1.strokeStyle = '#49F'; 	 
	oGc1.arc(200, 100, 50, 0, 2*Math.PI); //200px 100px圆心坐标 50px半径 从弧度0绘制到弧度2*Math.PI(360度)
	oGc1.closePath();	//关闭路径
	oGc1.stroke();		//画线

	//画一个实心圆形
	oGc1.beginPath();	//打开路径
	oGc1.fillStyle = '#953';   	 
	oGc1.arc(320, 100, 50, 0, 2*Math.PI); 
	oGc1.closePath();	//关闭路径
	oGc1.stroke(); 		//画线
	oGc1.fill();		//填充

	//画文字
	oGc1.beginPath();	//打开路径
	oGc1.font = '40px 黑体';
	oGc1.lineWidth = 1;
	oGc1.strokeStyle = '#A4F';
	oGc1.fillStyle = '#94a';
	oGc1.closePath();	//关闭路径
	oGc1.strokeText('基础操作', 20, 200);  	//空心字  
	oGc1.fillText('基础操作', 200, 200);	//实心字  
	
	//旋转线条 
	for(var i=0; i<=6; i++){
		oGc1.save();					//save restore 保证translate rotate等的设置都是私有的 不影响下面
		oGc1.beginPath();				//打开路径	
		oGc1.translate(600,500);		//设定旋转点的坐标  
		oGc1.rotate(i*50*Math.PI/180);	//设定旋转角度 旋转之后的绘图
		oGc1.lineWidth = 6;  	 
		oGc1.strokeStyle = '#38A';
		oGc1.moveTo(0, 0);
		oGc1.lineTo(100, 0);
		oGc1.closePath();				//关闭路径
		oGc1.stroke();					//画线
		oGc1.restore();
	}

	//旋转图片 
	var oImg = new Image();
	oImg.src = 'http://www.w3school.com.cn/i/eg_tulip.jpg';
	// oImg.src = "source/111.jpg";			 
	oImg.onload = function(){
		for(var i=0; i<=12; i++){
			oGc1.save();					//save restore 保证translate rotate等的设置都是私有的 不影响其他循环
			oGc1.translate(250,500);		//设定旋转点的坐标  
			oGc1.rotate(i*30*Math.PI/180);	//设定旋转角度 旋转绘图
			oGc1.drawImage(oImg, -200, -133, 400, 266);	//以自身中心点旋转
			oGc1.restore();
		}
	}
	
	//填充图片为背景
	/*var oImg2 = new Image();
	oImg2.src = "http://www.w3school.com.cn/i/eg_tulip.jpg";
	oImg2.onload = function(){
		oGc1.beginPath();
		var bg = oGc1.createPattern(oImg2, 'repeat');
		oGc1.fillStyle = bg;
		oGc1.fillRect(600, 200, 650, 250);
		oGc1.closePath();
	}*/



	//第二部分：鼠标模拟钢笔画线 ------------------------------
	var oC2 = document.getElementById('canvas2');
	var oGc2 = oC2.getContext('2d');
	var nWidth = 1;

	oGc2.beginPath();	 
	oGc2.font = '26px 黑体';
	oGc2.closePath();	
	oGc2.fillText('在此区域 按下鼠标左键移动 模拟钢笔画线', 50, 50);		 

	oC2.onmousedown = function(ev){
		oGc2.beginPath();				//用beginPath closePath包围 保证下一次的lineWidth等设置 不影响上一次
		var ev = ev || event;
		var scrollLeft = document.documentElement.scrollLeft||document.body.scrollLeft;  
		var scrollTop = document.documentElement.scrollTop||document.body.scrollTop;
		var nLeft = ev.clientX - this.offsetLeft + scrollLeft;
		var nTop = ev.clientY - this.offsetTop + scrollTop;
		oGc2.lineWidth = nWidth++;		//lineWidth不断加粗
		oGc2.strokeStyle = '#F19';
		oGc2.moveTo(nLeft, nTop);		//按下鼠标瞬间 设定划线起始点

		document.onmousemove = function(ev){
			var ev = ev || event;
			var nLeft = ev.clientX - oC2.offsetLeft + scrollLeft;
			var nTop = ev.clientY - oC2.offsetTop + scrollTop;
			oGc2.lineTo(nLeft, nTop);	//鼠标移动过程中 设定划线终止点
			oGc2.stroke();				//划线
		}

		document.onmouseup = function(){
			document.onmousemove = null;
			document.onmouseup = null;
		}
		oGc2.closePath();	
	}



	//第三部分：模拟块体animate ------------------------------
	var oC3 = document.getElementById('canvas3');
	var oGc3 = oC3.getContext('2d');
	var oBtn1 = document.getElementById('btn1');
	var num = 0;

	oGc3.beginPath();	 
	oGc3.font = '26px 黑体';
	oGc3.closePath();	
	oGc3.fillText('在此区域 模拟块体animate', 50, 30);

	oGc3.fillStyle = '#67F'; 			//填充矩形的颜色  
	oGc3.fillRect(0, 50, 50, 50);		//指定位置 填充
	
	oBtn1.onclick = function(){
		setInterval(function(){
			oGc3.clearRect(0, 50, oC3.width, oC3.height);		//每次循环开始前 清除画布 从0 50开始清除整个画布
			oGc3.fillRect(0 + num++, 50 + num++, 50, 50);		//清除完毕 重新画一个块体
		}, 10);
	}



	//第四部分：画一个钟表 ------------------------------
	var oC4 = document.getElementById('canvas4');
	var oGc4 = oC4.getContext('2d');

	oGc4.beginPath();	 
	oGc4.font = '26px 黑体';
	oGc4.closePath();	
	oGc4.fillText('在此区域 画一个钟表 时间等同于当前电脑时间', 20, 30);

	toDraw(300, 300, 150);		//中心点300 300 钟表半径150

	function toDraw(x, y, r){
		//定时器循环 每秒钟重画一次 
		setInterval(function(){
			//每次循环进来先清除画布
			oGc4.clearRect(0, 100, oC4.width, oC4.height);

			//循环 形成60等分的刻度盘 作为分钟
			oGc4.beginPath();	
			oGc4.strokeStyle = '#f38';
			for(var i=0; i<60; i++){
				oGc4.moveTo(x, y);
				oGc4.arc(x, y, r, i*6*Math.PI/180, (i+1)*6*Math.PI/180, false);		
			}
			oGc4.stroke();			//stroke必须放在循环外
			oGc4.closePath();

			//画个白色圆盘 盖住分钟刻度的一部分
			oGc4.beginPath();
			oGc4.fillStyle = '#fff';
			oGc4.moveTo(x, y);
			oGc4.arc(x, y, r-10, 0, 2*Math.PI);		//白色圆盘 就是0-360度	
			oGc4.closePath();
			oGc4.fill();

			//循环 形成12等分的刻度盘 作为时钟
			oGc4.beginPath();	
			oGc4.strokeStyle = '#f38';
			oGc4.lineWidth = 3;		//时钟刻度稍微粗一点
			for(var i=0; i<12; i++){
				oGc4.moveTo(x, y);
				oGc4.arc(x, y, r, i*30*Math.PI/180, (i+1)*30*Math.PI/180, false);		
			}
			oGc4.stroke();			//stroke必须放在循环外
			oGc4.closePath();

			//画个白色圆盘 盖住时钟刻度的一部分
			oGc4.beginPath();
			oGc4.fillStyle = '#fff';
			oGc4.moveTo(x, y);
			oGc4.arc(x, y, r-25, 0, 2*Math.PI);		
			oGc4.closePath();
			oGc4.fill();

			//获取当前时分秒
			var oDate = new Date();
			var oHour = oDate.getHours();
			var oMin = oDate.getMinutes();
			var oSec = oDate.getSeconds();

			//获取时分秒对应的弧度
			var oHoursValue = ((oHour+oMin/60)*30-90)*(Math.PI/180);	// +oMin/60 修正时针
			var oMinsValue = (oMin*6-90)*(Math.PI/180);
			var oSecsValue = (oSec*6-90)*(Math.PI/180);

			//画时针
			oGc4.beginPath();
			oGc4.strokeStyle = '#360';
			oGc4.lineWidth = 6;
			oGc4.moveTo(x, y);
			oGc4.arc(x, y, r-70, oHoursValue, oHoursValue);		//x度--x度	等同于画线条
			oGc4.closePath();
			oGc4.stroke();

			//画分针
			oGc4.beginPath();
			oGc4.strokeStyle = '#360';
			oGc4.lineWidth = 4;
			oGc4.moveTo(x, y);
			oGc4.arc(x, y, r-50, oMinsValue, oMinsValue);	 
			oGc4.closePath();
			oGc4.stroke();

			//画秒针
			oGc4.beginPath();
			oGc4.strokeStyle = '#360';
			oGc4.lineWidth = 2;
			oGc4.moveTo(x, y);
			oGc4.arc(x, y, r-30, oSecsValue, oSecsValue);		 
			oGc4.closePath();
			oGc4.stroke();
		}, 1000);
	}



	//第五部分：旋转并循环变大变小 ------------------------------
	var oC5 = document.getElementById('canvas5');
	var oGc5 = oC5.getContext('2d');
	var oBtn5 = document.getElementById('btn5');
	var ang = 0;		
	var size = 0;
	var dir = 0;

	oGc5.beginPath();	 
	oGc5.font = '26px 黑体';
	oGc5.closePath();	
	oGc5.fillText('在此区域 画一个矩形 旋转并循环变大变小', 20, 30);

	oBtn5.onclick = function(){
		setInterval(function(){
			oGc5.clearRect(0, 50, oC5.width, oC5.height);
			if(size == 100){
				dir = -1;
			}else if(size == 0){
				dir = 1;
			}
			size += dir;	//循环过程中 size从0到100再到0
			ang++;			//度数累加1

			oGc5.save();
			oGc5.translate(400, 250);			//设定旋转点的坐标 
			oGc5.rotate(ang*Math.PI/180);		//设定旋转角度  
			oGc5.scale(size/50, size/50);		//设定放大比例 0到2到0
			oGc5.fillRect(-50,-50, 100, 100);	//以-50 -50为坐标(相对旋转点坐标) 画一个100 100的矩形 也就是以自身中心旋转
			oGc5.restore();
		},30);
	}
	


	//第六部分：背景渐变 图像数据对象 ------------------------------
	var oC6 = document.getElementById('canvas6');
	var oGc6 = oC6.getContext('2d');
	var ang = 0;		
	var size = 0;
	var dir = 0;

	oGc6.beginPath();	 
	oGc6.font = '26px 黑体';
	oGc6.closePath();	
	oGc6.fillText('背景渐变', 20, 30);

	//线性渐变
	oGc6.beginPath();
	//从坐标50 50开始线性渐变到坐标200 200
	var my_gradient = oGc6.createLinearGradient(50, 50, 150, 150);
	//线条渐变的颜色变化
	my_gradient.addColorStop(0, 'red');			//线起始
	my_gradient.addColorStop(0.5, 'yellow');	//线中间 黄
	my_gradient.addColorStop(1, 'blue');		//线终止
	oGc6.fillStyle = my_gradient;
	oGc6.fillRect(50, 50, 100, 100);
	oGc6.closePath();

	//放射渐变
	oGc6.beginPath();
	//圆心300 150 半径50的圆 外部开始渐变 知道圆心300 150 半径100的圆终止
	var my_gradient = oGc6.createRadialGradient(250, 100, 20, 250,100,50);
	//放射渐变的颜色变化
	my_gradient.addColorStop(0, 'red');			//放射起始
	my_gradient.addColorStop(0.5, 'yellow');	//放射中间 黄
	my_gradient.addColorStop(1, 'blue');		//放射终止
	oGc6.fillStyle = my_gradient;
	oGc6.fillRect(200, 50, 100, 100);
	oGc6.closePath();

	//文字居中
	oGc6.beginPath();
	oGc6.font = '40px impact';		//font必须设置这两项 
	oGc6.textBaseline = 'top';		//以文字顶部为基准线
	var w = oGc6.measureText('上下左右居中').width;	//获取当前文字的宽度
	oGc6.closePath();
	oGc6.fillText('上下左右居中', (oC6.width-w)/2, (oC6.height-40)/2);	//当前文字的高度就是40px的40

	//阴影设置
	oGc6.save()					//阴影设置不影响后续
	oGc6.beginPath();
	oGc6.font = '40px impact';
	oGc6.fillStyle = '#93A';
	oGc6.shadowOffsetX = 10;	//阴影X偏移10px
	oGc6.shadowColor = 'red';	//阴影颜色是红色
	oGc6.shadowBlur = 3;		//阴影模糊程度3(0-100)
	oGc6.closePath();
	oGc6.fillText('我有阴影', 200, 300);
	oGc6.restore();

	//获取图像数据对象 
	oGc6.beginPath();
	oGc6.fillStyle = '#92B';
	oGc6.fillRect(100, 350, 100, 100);
	oGc6.closePath();
	var oImageData = oGc6.getImageData(100, 350, 100, 100);	//这个图像对象范围是100, 350, 100, 100 正好是上面画的矩形
	// alert(oImageData.width);		//宽度 100
	// alert(oImageData.height);		//高度 100
	// alert(oImageData.data.length)	//40000 100*100*4(4代表RGBA)
	// alert(oImageData.data[0]);		//153	第一个像素的 R 
	// alert(oImageData.data[1]);		//34	第一个像素的 G
	// alert(oImageData.data[2]);		//187	第一个像素的 B
	// alert(oImageData.data[3]);		//255	第一个像素的 A 透明度

	//修改上面的图像数据 然后放回画布上
	for(var i=0; i<oImageData.width*oImageData.height; i++){
		oImageData.data[4*i] = 134;		//修改R
		oImageData.data[4*i+1] = 104;	//G
		oImageData.data[4*i+2] = 31;	//B
		oImageData.data[4*i+3] = 108;	//A
	}
	oGc6.putImageData(oImageData, 250, 350);

	//创建全新的图片数据对象 然后放回画布上
	var oNewImageData = oGc6.createImageData(100,100);	//宽高 100 100
	for(var i=0; i<oNewImageData.width*oNewImageData.height; i++){
		oNewImageData.data[4*i] = 114;		//R
		oNewImageData.data[4*i+1] = 169;	//G
		oNewImageData.data[4*i+2] = 126;	//B
		oNewImageData.data[4*i+3] = 218;	//A
	}
	oGc6.putImageData(oNewImageData, 400, 350);			//位置 500 350



	//第七部分：文字绘制 ------------------------------
	var oC7 = document.getElementById('canvas7');
	var oGc7 = oC7.getContext('2d');
	var aLi7 = document.getElementById('ul7').getElementsByTagName('li');

	oGc7.beginPath();	 
	oGc7.font = '27px 黑体';
	oGc7.closePath();	
	oGc7.fillText('文字绘制 ', 20, 30);

	for(var i=0; i<aLi7.length; i++){
		aLi7[i].onclick = function(){
			//点击文字 相应文字画到画布上
			oGc7.clearRect(0, 50, oC7.width, oC7.height);	//每次点击 清除上一次的文字
			oGc7.beginPath(); 
			var h = 200;
			oGc7.fillStyle = 'red';
			oGc7.font = h + 'px impact';	//先设置完字体大小后 才去量字体宽度
			oGc7.textBaseline = 'top';		//设置基准点 才能准确定义高度
			var w = oGc7.measureText(this.innerHTML).width;		
			oGc7.closePath();
			oGc7.fillText(this.innerHTML, (oC7.width-w)/2, (oC7.height-h)/2);

			//获取这个文字形成的图像数据对象 
			var oImg7 = oGc7.getImageData((oC7.width-w)/2, (oC7.height-h)/2, w, h);
			oGc7.clearRect(0, 50, oC7.width, oC7.height);	//获取到图像数据后 清除文字

			//形成新的图像
			var arr7 = randomArr(w*h, w*h/5);				//随机取1/5的像素点索引
			var oNew7 = oGc7.createImageData(w,h);			//宽高  
			for(var i=0; i<arr7.length; i++){				//只绘制1/5的像素点
				oNew7.data[4*arr7[i]] = oImg7.data[4*arr7[i]];
				oNew7.data[4*arr7[i] + 1] = oImg7.data[4*arr7[i] + 1];
				oNew7.data[4*arr7[i] + 2] = oImg7.data[4*arr7[i] + 2];
				oNew7.data[4*arr7[i] + 3] = oImg7.data[4*arr7[i] + 3];
			}
			oGc7.putImageData(oNew7, (oC7.width-w)/2, (oC7.height-h)/2);	//位置
		}
	}

	//从iAll个数组元素 随机取出iNow个数组元素 组成新数组
	function randomArr(iAll, iNow){
		var arr = [];
		var newArr = [];

		//形成数组arr [0, 1, 2...., iAll]
		for(var i=0; i<iAll; i++){
			arr.push(i);
		}

		//形成数组newArr 长度是iNow 数组元素是arr的随机数组元素
		for(var i=0; i<iNow; i++){
			newArr.push( arr.splice( Math.floor(Math.random()*arr.length), 1 ) );
		}

		return newArr;
	}



	//第八部分：图片反色加渐变 ------------------------------
	var oC8 = document.getElementById('canvas8');
	var oGc8 = oC8.getContext('2d');

	oGc8.beginPath();	 
	oGc8.font = '28px 黑体';
	oGc8.closePath();	
	oGc8.fillText('图片反色加渐变 ', 20, 30);

	oImg8 = new Image();
	// oImg8.src = "http://www.w3school.com.cn/i/eg_tulip.jpg";
	oImg8.src = "source/111.jpg";			 
	oImg8.onload = function(){
		oGc8.drawImage(oImg8, 50, 50, 400, 200);
		var oImageData8 = oGc8.getImageData(50, 50, 400, 200);	//获取图像数据对象
		var oNewImageData8 = oGc8.createImageData(400, 200);	//创建空白的图像数据对象 宽高
		var w = oImageData8.width;
		var h = oImageData8.height;
		//枚举每个像素点 进行读取及设置每个像素点的RGBA
		for(var i=0; i<h; i++){			 
			for(var j=0; j<w; j++){		 
				var result = [];
				var color = getXY(oImageData8, j, i);	//获取每个像素点的RGBA
				result[0] = 255 - color[0];				//每个像素点的RGBA反色
				result[1] = 255 - color[1];
				result[2] = 255 - color[2];
				result[3] = 255 * i/h;					//透明的渐变
				setXY(oNewImageData8, j, i, result);	//设置空白的图像数据对象的每个像素点RGBA
			}
		}
		oGc8.putImageData(oNewImageData8, 50, 250);		//形成新的图像 位置
	}

	//读取obj图像数据对象的x,y坐标的像素点RGBA 存入数组返回
	function getXY(obj, x, y){
		var w = obj.width;
		var h = obj.height;
		var colorArr = [];
		//坐标x y对应的像素点 是第几y*w+x个像素点
		colorArr[0] = obj.data[4*((y*w)+x)];
		colorArr[1] = obj.data[4*((y*w)+x) + 1];
		colorArr[2] = obj.data[4*((y*w)+x) + 2];
		colorArr[3] = obj.data[4*((y*w)+x) + 3];
		return colorArr;
	}

	//设置obj图像数据对象的x,y坐标的像素点RGBA colorArr存储了RGBA
	function setXY(obj, x, y, colorArr){
		var w = obj.width;
		var h = obj.height;
		//坐标x y对应的像素点 是第几y*w+x个像素点
		 obj.data[4*((y*w)+x)] = colorArr[0];
		 obj.data[4*((y*w)+x) + 1] = colorArr[1];
		 obj.data[4*((y*w)+x) + 2] = colorArr[2];
		 obj.data[4*((y*w)+x) + 3] = colorArr[3];
	}



	//第九部分：马赛克效果 ------------------------------
	var oC9 = document.getElementById('canvas9');
	var oGc9 = oC9.getContext('2d');

	oGc9.beginPath();	 
	oGc9.font = '28px 黑体';
	oGc9.closePath();	
	oGc9.fillText('马赛克效果 ', 20, 30);

	oImg9 = new Image();
	// oImg9.src = "http://www.w3school.com.cn/i/eg_tulip.jpg";
	oImg9.src = "source/111.jpg";			 
	oImg9.onload = function(){
		oGc9.drawImage(oImg9, 50, 50, 400, 200);
		var oImageData9 = oGc9.getImageData(50, 50, 400, 200);	//获取图像数据对象
		var oNewImageData9 = oGc9.createImageData(400, 200);	//创建空白的图像数据对象 宽高
		var w = oImageData9.width;
		var h = oImageData9.height;
		var mosaic = 5;
		var stepW = w/mosaic;		//变化mosaic 就能变化马赛克模糊度
		var stepH = h/mosaic;
		//枚举一个个小格子 设定每个小格子随机的RGBA
		for(var i=0; i<stepH; i++){			 	 
			for(var j=0; j<stepW; j++){		
				//获取每个小格子内的随机坐标的RGBA
				var color = getXY(oImageData9, j*mosaic+Math.floor(Math.random()*mosaic), i*mosaic+Math.floor(Math.random()*mosaic))
				//获取到后 每个小格子都各自用相同的RGBA 填充自己格子内的每个像素
				for(var k=0; k<mosaic; k++){
					for(var l=0; l<mosaic; l++){
						setXY(oNewImageData9, j*mosaic+l, i*mosaic+k, color);
					}
				}
			}
		}
		oGc9.putImageData(oNewImageData9, 50, 250);		//形成新的图像 位置
	}



	//第十部分：图像合成 ------------------------------
	var oC10 = document.getElementById('canvas10');
	var oGc10 = oC10.getContext('2d');

	oGc10.beginPath();	 
	oGc10.font = '28px 黑体';
	oGc10.closePath();	
	oGc10.fillText('图像合成', 20, 30);

	//调节透明度
	oGc10.save();		//透明设置不影响下面
	oGc10.fillStyle="red";
	oGc10.fillRect(50, 50, 100, 100);
	oGc10.globalAlpha=0.2;
	oGc10.fillStyle="blue";
	oGc10.fillRect(100, 100, 100, 100);
	oGc10.fillStyle="green";
	oGc10.fillRect(150, 150, 100, 100);
	oGc10.restore();

	//合成覆盖
	oGc10.fillStyle="red";
	oGc10.fillRect(50, 300, 100, 100);
	oGc10.globalCompositeOperation="source-over";		//源图像在上面
	oGc10.fillStyle="blue";
	oGc10.fillRect(100, 350, 100, 100);

	oGc10.fillStyle="red";
	oGc10.fillRect(250, 300, 100, 100);
	oGc10.globalCompositeOperation="destination-over";	//目标图像在上面
	oGc10.fillStyle="blue";
	oGc10.fillRect(300, 350, 100, 100);



	//第十一部分：刮刮卡
	var c = document.getElementById("mycanvas");
	var ctx = c.getContext("2d");
	ctx.fillStyle="blue";
	ctx.fillRect(0, 0, 300, 150);

	c.onmousedown = function(){	
		c.onmousemove = function(ev){
			var ev = ev || window.event;
			var scrollLeft = document.documentElement.scrollLeft || document.body.scrollLeft;
			var scrollTop = document.documentElement.scrollTop || document.body.scrollTop;
			var nLeft = ev.clientX - this.offsetLeft + scrollLeft;
			var nTop = ev.clientY - this.offsetTop + scrollTop;
			ctx.clearRect(nLeft, nTop, 20, 20);
		}
		c.onmouseup = function(){
			this.onmouseup = null;
			this.onmousemove = null;
		}
	}


}





