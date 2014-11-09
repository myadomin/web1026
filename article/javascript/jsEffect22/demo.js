
//图片居中无缝轮播图 
//1 应用relative布局让图片永远居中
//2 通过改变相对定位的left形成无缝轮播 
window.onload = function(){
	var oUl = document.getElementById('wrap').getElementsByTagName('ul')[0];
	var aLi = oUl.getElementsByTagName('li');
	var oImg1 = aLi[0].getElementsByTagName('img')[0];
	var aA = document.getElementsByTagName('a');
	var nImgWidth = oImg1.offsetWidth;					//一个图片的宽度	
	oUl.style.width = nImgWidth * aLi.length + 'px';	//ul的宽度等于图片宽度乘图片个数 后续任何宽度任何个数图片都能适应
	var iNow = 0;		//保存当前图片的索引 被点击轮播自动轮播共享使用
	var Timer = null;
	var oMark = document.getElementById('mark');

	//大于1000的任何屏幕宽度 永远显示图片中间部分
	center();							//刷新进来执行一次
	window.onresize = function(){		
		clearInterval(Timer);			//如果缩放 就停止自动轮播
		setTimeout(autoPlay(), 100);	//缩放完毕 100毫秒后再开启自动轮播
		center();						//每次缩放窗口执行一次
	}

	//点击轮播
	for(var i=0; i<aA.length; i++){
		aA[i].index = i;
		aA[i].onclick = function(){
			iNow = this.index;
			for(var i=0; i<aA.length; i++){
				aA[i].className = '';
			}
			aA[iNow].className = 'active';
			//注意 任何的绝对定位改变left的运动 在IE下必须先设定好left:0px top:0px 否则不会动
			bufferMove( oUl, { "left": -iNow*nImgWidth+'px' } );	
		}
		//三个a按钮层级高于oUl 所以也要加入移入移出开启停止自动轮播
		aA[i].onmouseover = function(){		
			clearInterval(Timer);
		}
		aA[i].onmouseout = function(){
			autoPlay();
		}
	}

	//开启自动轮播 
	autoPlay();

	//移入停止自动轮播 移出开启自动轮播
	oUl.onmouseover = function(){
		clearInterval(Timer);
	}
	oUl.onmouseout = function(){
		autoPlay();
	}

	//自动轮播
	function autoPlay(){
		Timer = setInterval(function(){
			iNow ++;
			for(var i=0; i<aA.length; i++){
				aA[i].className = '';
			}
			//无缝轮播(另一种实现方法：将这里的三张图再复制出三张图 放在后面)
			if( iNow == (aA.length) ){								
				aA[0].className = 'active';	
				//当移到最后一张图的时候 通过改变相对定位的left 将第一张图拉到最后一张图后面
				oImg1.style.left = (aA.length)*nImgWidth + 'px';	
				flag = false;
				//被拉到最后位置的第一张图开始移动 加入(nImgWidth-getInner().width)/2是让任何宽度的显示器看见的都是图片中间部分
				bufferMove( oUl, {"left": -(aA.length)*nImgWidth - (nImgWidth - getInner().width)/2 + 'px'}, function(){
					//移动完后 将第一张图还原到原来的位置 将整个ul还原到刷新进来的位置
					iNow = 0;										
					oImg1.style.left = -(nImgWidth - getInner().width)/2 + 'px';	 
					oUl.style.left = 0 + 'px';						 
				});
			}else{
				aA[iNow].className = 'active';
				bufferMove( oUl, { "left": -iNow*nImgWidth+'px' } );
			}	
		}, 3000);
	}

	//永远显示图片的中间部分
	function center(){
		for(var i=0; i<aLi.length; i++){
			var nViewWidth = getInner().width;	
			if(nViewWidth > 1000){
				//如果当前显示器宽度大于1000 那动态变化img relative的left 永远显示图片的中间部分		
				aLi[i].getElementsByTagName('img')[0].style.left = -(nImgWidth - nViewWidth)/2 + 'px';
			}else{	
				//否则img relative的left值固定					
				aLi[i].getElementsByTagName('img')[0].style.left = -(nImgWidth - 1000)/2 + 'px';
			}
		}
	}

}


//获取当前视窗宽度高度
function getInner(){
	if(typeof window.innerWidth){    	//高版本各浏览器 W3C标准
		return{
			width:window.innerWidth,	//返回字面量形式 getInner().width = window.innerWidth
			height:window.innerHeight
		}
	}else{
		return{                     	//兼容IE低版本浏览器
			width:document.documentElement.clientWidth,  
			height:document.documentElement.clientHeight
		}
	}
} 

