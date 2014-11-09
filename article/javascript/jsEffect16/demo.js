
//js分页函数封装及应用
window.onload = function(){

	//第一部分：封装分页函数page
	//传入不同的nowNum值 allNum值 形成不同的页码形态 回调函数arg1 arg2参数用于处理应用
	page({
		id: 'div1',
		nowNum: 7,
		allNum: 15,
		callBack: function(arg1, arg2){		
			//arg1就是nowNum的属性值  arg2就是allNum的属性值
			//根据封装好的page函数 在函数的最后给每个生成的页码a都加了onclick事件
			//之后点击任何一页 继续调用这个page函数 page函数继续回调这个callBack 
			//这里的arg1动态变化成之后点击的当前页 
			document.getElementById('content').innerHTML = '封装函数测试部分：当前页：' + arg1 + ' ，总共页' + arg2;
		}
	});


	//js分页函数封装
	function page(options){
		//必传参数id
		if( !options.id ){		
			return false;
		}
		var obj = document.getElementById(options.id);
		//选传参数 不传就是默认 下同
		var nowNum = options.nowNum || 1;		//当前页
		var allNum = options.allNum || 5;		//总页数
		var callBack = options.callBack || function(){};	//回调函数

		//首页 上一页 部分
		if( nowNum >= 4 && allNum >=6 ){
			var oA = document.createElement('a');
			oA.href = '#1';
			oA.innerHTML = '[首页]';
			obj.appendChild(oA);
		}
		if( nowNum >= 2){
			var oA = document.createElement('a');
			oA.href = '#' + (nowNum - 1);
			oA.innerHTML = '[上一页]';
			obj.appendChild(oA);
		}

		//页码 1 2 3 4 5...部分 只显示5个页码数字
		if( allNum <= 5 ){					//总页数小于等于5页 
			for( var i=1; i<=allNum; i++ ){	//产生allNum个a
				var oA = document.createElement('a');
				oA.href = '#' + i;
				if( i == nowNum ){		
					oA.innerHTML = i;
				}else{
					oA.innerHTML = '[' + i + ']';
				}
				obj.appendChild(oA);
			}	
		}else{								//总页数大于5页
			for( var i=1; i<=5; i++ ){		//只产生5个a
				var oA = document.createElement('a');

				if( nowNum == 1 || nowNum == 2 ){	//当前页是1 2  
					oA.href = '#' + (nowNum - 1 + i);
					if( i == nowNum ){						 
						oA.innerHTML = i;
					}else{
						oA.innerHTML = '[' + i + ']';
					}								//当前页是allNum allNum-1
				}else if( nowNum == allNum || nowNum == (allNum - 1) ){	
					oA.href = '#' + (allNum - 5 + i);
					if( i == ( 5 - ( allNum - nowNum ) ) ){
						oA.innerHTML = (allNum - 5 + i);
					}else{
						oA.innerHTML =  '[' + (allNum - 5 + i) + ']';
					}
				}else{								//当前页是其他   		
					oA.href = '#' + (nowNum - 3 + i);
					if( i == 3 ){							 
						oA.innerHTML = (nowNum - 3 + i);
					}else{
						oA.innerHTML = '[' + (nowNum - 3 + i) + ']';
					}
				}
				
				obj.appendChild(oA);
			}
		}

		//... 下一页 尾页 部分
		if( allNum - nowNum >= 1 ){
			var oA = document.createElement('a');
			oA.href = '#' + (nowNum + 1);
			oA.innerHTML = '[下一页]';
			obj.appendChild(oA);
		}
		if( nowNum <= (allNum - 3) && allNum >=6 ){		//出现尾页前面必出现...
			var oA = document.createElement('a');
			var oSpan = document.createElement('span');
			oA.href = '#' + allNum;
			oA.innerHTML = '[尾页]';
			oSpan.innerHTML = '...';
			obj.appendChild(oSpan);
			obj.appendChild(oA);
		}

		//回调函数 相当于function(arg1, arg2){alert('当前页：' + arg1 + ' ，总共页' + arg2);}(nowNum, allNum)
		callBack(nowNum, allNum);

		//给所有页码加上点击事件 点击任何页码再次调用page()
		var aA = obj.getElementsByTagName('a');
		for( var i=0; i<aA.length; i++ ){
			aA[i].onclick = function(){
				var clickNum = parseInt(this.getAttribute('href').substring(1));
				obj.innerHTML = '';			//清空所有a 

				page({						//再次调用page()	
					id: options.id,
					nowNum: clickNum,		//cliclkNum作为nowNum
					allNum: allNum,         //allNum由上面传递过来
					callBack: callBack  	//回调函数
				});

				return false;
			}
		}
	}



	// 第二部分：分页函数应用
	var json = {					// 模拟后台数据
			title: [
				'数据库第1条',
				'数据库第2条',
				'数据库第3条',
				'数据库第4条',
				'数据库第5条',
				'数据库第6条',
				'数据库第7条',
				'数据库第8条',
				'数据库第9条',
				'数据库第10条',
				'数据库第11条',
				'数据库第12条',
				'数据库第13条',
				'数据库第14条',
				'数据库第15条',
				'数据库第16条',
				'数据库第17条',
				'数据库第18条',
				'数据库第19条',
				'数据库第20条',
				'数据库第21条',
				'数据库第22条',
				'数据库第23条',
				'数据库第24条',
				'数据库第25条',
				'数据库第26条',
				'数据库第27条',
				'数据库第28条',
				'数据库第29条',
				'数据库第30条',
				'数据库第31条',
				'数据库第32条',
				'数据库第33条',
				'数据库第34条',
				'数据库第35条',
				'数据库第36条',
				'数据库第37条'
			]
		};
	var arr = [];
	var iNow = 9;

	//调用page函数 在callBack回调函数中应用now, all两个参数做应用操作
	page({
		id: 'pages',								
		nowNum: 1,									//当前页数
		allNum: Math.ceil((json.title.length)/10),	//总页数 根据后台数据决定
		callBack: function(now, all){				//now就是nowNum的属性值  all就是allNum的属性值
			//获取当前页应该具备li元素的个数num 除了最后一页应该都是10个li 
			var num = now*10 < json.title.length ? 10 : json.title.length - (now-1)*10;
			var oUl = document.getElementById('ul1');
			var aLi = oUl.getElementsByTagName('li');

			//第一次刷新进来 当前页数是1 创建10个li 后续点击页面不再创建li
			if( oUl.innerHTML == '' ){		//注意<ul id="ul1"></ul> ul标签间不能有任何空格 否则oUl.innerHTML就是空格字符串
				for(var i=0; i<10; i++){	//不管是不是最后一页 先创建好10个li  
					var oLi = document.createElement('li');
					oLi.innerHTML = json.title[(now-1)*10 + i];
					oUl.appendChild(oLi);
					//arr二维数组 预存left top
					arr.push( [aLi[i].offsetLeft, aLi[i].offsetTop] );
				}
				//从浮动改为定位布局
				for(var i=0; i<10; i++){	
					aLi[i].style.position = 'absolute';
					aLi[i].style.left = arr[i][0] + 'px';
					aLi[i].style.top = arr[i][1] + 'px';
					aLi[i].style.margin = '0px';
				}
			//后续点击页码 执行这里
			}else{	
				var timer = setInterval(function(){
					//收缩到一个点
					bufferMove(aLi[iNow], {"left": (getInner().width)/2, "top":(getInner().height)/2+150, "opacity":"0"});
					
					//收缩完毕 开始扩散(下面的else iNow在--)
					if( iNow == 0 ){	
						clearInterval(timer);

						//更换翻页的内容
						iNow = num - 1;
						for( var i=0; i<num; i++ ){
							aLi[i].innerHTML = json.title[ (now-1)*10 + i ];
						}

						//扩散回到原位置
						var timer2 = setInterval(function(){
							bufferMove(aLi[iNow], {"left": arr[iNow][0], "top":arr[iNow][1], "opacity":"1"});
							//扩散完毕
							if( iNow == 0 ){		
								clearInterval(timer2);
								iNow = num - 1;
							}else{
								iNow--;
							}
						},100);
					}else{
						iNow--;
					}
				}, 100);
			}
		}
	});

}


//获取当前视窗宽度高度
function getInner(){
	if(typeof window.innerWidth){    //高版本浏览器 W3C标准
		return{
			width:window.innerWidth, //返回字面量形式 getInner().width = window.innerWidth
			height:window.innerHeight
		}
	}else{
		return{                     //兼容低版本浏览器
			width:document.documentElement.clientWidth,  
			height:document.documentElement.clientHeight
		}
	}
} 


