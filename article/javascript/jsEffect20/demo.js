
//图片预加载
$(function(){
	var iNow = 0;
	var nImgLength = $('.small_img img').size();


	//显示大图框体 以及加载图 遮罩锁屏
	$('.small_img img').click(function(){
		$('.big_img').show();  
		$('body').append('<div class="mark"></div>');  
		$('.mark').css({
			"width": $(document).width(),
			"height": $(document).height(),
			"position": "absolute",
			"left": "0px",
			"top": "0px",
			"zIndex": "9998",
			"background": "#ccc",
			"opacity": "0.4"
		});

		//创建Image对象 预加载真实图片
		var oNowImg = new Image();   			 
		var oPrevImg = new Image();   			  
		var oNextImg = new Image();   			 
		oNowImg.src = $(this).attr('big_src');  				//预加载被点击图片的真实大图
		oPrevImg.src = getPrevObj($(this)).attr('big_src');  	//预加载前一张真实大图
		oNextImg.src = getNextObj($(this)).attr('big_src');  	//预加载后一张真实大图

		//当图片对象预加载被点击对象的大图src完毕后
		$(oNowImg).load(function(){			 	
			$('.big_img img').attr({   
				//将大图框体里的图片src替换为真实大图 class换成真实大图的样式class      
				'src': this.src,             	
				'class': 'real_img'         
			});
		});

		//记录iNow
		iNow = $(this).index();	
	});


	//如果点击了右上角的X  
	$('.big_img span').click(function(){         
		$('.big_img').hide().find('img').attr({ //隐藏大图框体 
			'src': 'img/loading.gif',  			//同时将图片src还原为加载图src 
			'class': 'loading_img'     			//class还原为加载图样式class
		});

		$('.mark').remove();  					//取消遮罩
	});


	//点击prev后 当前大图显示的同时 他的前一张也预加载了(通过firebug网络图片查看 )
	$('.prev').click(function(){ 
		//首先将图片的src欢迎为加载图src class还原为加载图样式class 	           
		$('.big_img img').attr({               
			'src': 'img/loading.gif',  		  
			'class': 'loading_img'     		  
		});

		//全局变量iNow用于传递索引 如果是第一张的前一张 那索引就是最后一张的索引
		iNow--;								  
		if(iNow == -1){                       
			iNow = nImgLength - 1;
		}

		//创建一个新的Image对象 开始加载src
		var oNowImg = new Image();            
		oNowImg.src = $('.small_img img').eq(iNow).attr('big_src'); 
		//注意：这个src在前一次点击prev或者第一次开启大图的时候已实现预加载过了 为什么还在这里加载一次
		//因为可能用户点击的非常快速 前一次点击prev 这个src可能还没加载完毕 就跳到这里来了
		//而且这里必须加如下的.load事件 判断到这里的时候 这个src是否加载完毕
		//而为了.load事件判断 必须要有oNowImg对象 所以这里就再进行了一次oNowImg.src
		//如果oNowImg.src在前一次点击prev的时候src已加载完毕了 就会立即执行.load里面的语句 
		//加上oNowImg.src 也并不拖慢加载src的速度 另外如果所有图片都预加载过一遍了 
		//这里还是会执行oNowImg.src 但是会读取缓冲 速度非常快的进入到.laod里面的语句 也并不拖慢加载src速度

		//这个对象加载src完毕后 将大图框体里的图片src替换为真实大图 class换成真实大图的样式class		  
		$(oNowImg).load(function(){           
			// alert(this.src);
			$('.big_img img').attr({
				'src': this.src,                         
				'class': 'real_img'          
			});
		});

		//预先加载当前显示图片的前一张
		var oPrevImg = new Image();            
		oPrevImg.src = getPrevObj($('.small_img img').eq(iNow)).attr('big_src');
	});


	//点击next后 当前大图显示的同时 他的后一张也预加载了(通过firebug网络图片查看)
	$('.next').click(function(){
		$('.big_img img').attr({  
			'src': 'img/loading.gif',  			 
			'class': 'loading_img'     			 
		});

		iNow++;
		if(iNow == nImgLength){
			iNow = 0
		}

		var oNowImg = new Image();
		oNowImg.src = $('.small_img img').eq(iNow).attr('big_src');
		$(oNowImg).load(function(){
			// alert(this.src);
			$('.big_img img').attr({
				'src': this.src,             
				'class': 'real_img'          		
			});
		});

		//预先加载当前显示图片的后一张
		var oNextImg = new Image();   	
		oNextImg.src = getNextObj($('.small_img img').eq(iNow)).attr('big_src');
	});


	//获取obj对象的前一个兄弟节点 
	//如果obj对象是父节点的第一个子节点 那他的前一个兄弟节点就是父节点的最后一个子节点
	function getPrevObj(obj){
		var prevObj = obj.prev();
		if(prevObj.index() == -1){
			prevObj = obj.parent().children().last();
		}
		return prevObj;
	}
	// alert(getPrevObj($('.small_img img').eq(0)).index());


	//获取obj对象的后一个兄弟节点 
	//如果obj对象是父节点的最后一个子节点 那他的后一个兄弟节点就是父节点的第一个子节点
	function getNextObj(obj){
		var nextObj = obj.next();
		if(nextObj.index() == -1){
			nextObj = obj.parent().children().first();
		}
		return nextObj;
	}
	// alert(getNextObj($('.small_img img').eq(11)).index());
	
});

