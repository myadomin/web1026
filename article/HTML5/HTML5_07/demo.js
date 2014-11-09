
//HTML5地理位置与本地存储
window.onload = function(){

	//第一部分：获取当前地理位置 通过navigator.geolocation对象
	var oBtn1 = document.getElementById('btn1');
	var oTxt1 = document.getElementById('txt1');
	//单次请求返回地理位置getCurrentPosition() 电脑模拟经常请求不到
	oBtn1.onclick = function(){
		oTxt1.value = '';
		//调用navigator.geolocation对象下的getCurrentPosition()方法 
		//参数1：成功的回调函数
		//参数2：错误回调函数
		//参数3：可选 配置json
		navigator.geolocation.getCurrentPosition(function(position){
			oTxt1.value += '经度:' + position.coords.longitude+'\n';
			oTxt1.value += '纬度 :' + position.coords.latitude+'\n';
			oTxt1.value += '准确度 :' + position.coords.accuracy+'\n';
			oTxt1.value += '海拔 :' + position.coords.altitude+'\n';
			oTxt1.value += '海拔准确度 :' + position.coords.altitudeAcuracy+'\n';
			oTxt1.value += '行进方向 :' + position.coords.heading+'\n';
			oTxt1.value += '地面速度 :' + position.coords.speed+'\n';
			oTxt1.value += '时间戳:' + new Date(position.timestamp)+'\n';	
		},function(err){	
			// err.code 失败所对应的编号
			// 0  :  不包括其他错误编号中的错误
			// 1  :  用户拒绝浏览器获取位置信息
			// 2  :  尝试获取用户信息，但失败了
			// 3  :  设置了timeout值，获取位置超时了
			alert(err.code);
		},{
			enableHighAcuracy : true,	//更精确的查找 默认false
			timeout : 50000,			//请求50000毫秒还没成功 就报错超时
			maximumAge : 5000   		//两次请求间隔5000毫秒内 算一次请求
		})
	}
	//多次自动请求返回地理位置watchPosition() 类似定时器 
	//watchPosition()参数同上 只是多了一个frequency配置参数 代表多久自动请求一次
	//清除自动请求clearWatch() 类似清除定时器



	//第二部分：地理位置显示到百度地图
	var oInput = document.getElementById('input1');
	oInput.onclick = function(){
		navigator.geolocation.getCurrentPosition(function(position){
			var y = position.coords.longitude;
			var x = position.coords.latitude;	//获取经纬度
			var map = new BMap.Map("div1");
			var pt = new BMap.Point(y, x);

			map.centerAndZoom(pt, 14);			//地图初始范围
			map.enableScrollWheelZoom();		//地图可缩放

			var myIcon = new BMap.Icon("m.png", new BMap.Size(30,30));
			var marker2 = new BMap.Marker(pt,{icon:myIcon});  //创建位置标注
			map.addOverlay(marker2); 			//显示位置

			var opts = {
			  width : 200,     		//信息窗口宽度
			  height: 60,     		//信息窗口高度
			  title : "我的位置"  	//信息窗口标题
			}
			var infoWindow = new BMap.InfoWindow("在这里", opts);  	//创建信息窗口对象
			map.openInfoWindow(infoWindow,pt); 						//开启信息窗口
		});	
	}



	//第三部分：应用sessionStorage localStorage进行本地存储 操作类似cookie
	//相比cookie的好处是 可以存储5M的内容 而且不需要和服务器端交互
	//sessionStorage不能跨页面共享数据 关闭页面就没有了
	//localStorage永久保存数据到本地 可以跨页面 任何时候都有 除非删除

	/*var oSet = document.getElementById('set');
	var oGet = document.getElementById('get');
	var oRemove = document.getElementById('remove');
	var oContent = document.getElementById('content');

	oSet.onclick = function(){
		// window.sessionStorage.setItem('name', oContent.value);	
		window.localStorage.setItem('name', oContent.value);
		// window.localStorage.name = oContent.value;		//另一种方法
	}

	oGet.onclick = function(){
		// alert(window.sessionStorage.getItem('name'));
		alert(window.localStorage.getItem('name'));
		// alert(window.localStorage.name);					//另一种方法
	}

	oRemove.onclick = function(){
		// window.sessionStorage.removeItem('name');
		window.localStorage.removeItem('name');
		// window.localStorage.name = null;					//另一种方法
	}

	// window.sessionStorage.clear();	//清除所有本地数据
	// window.localStorage.clear();

	//storage事件 注意当前页面不会触发 其他页面改变设置值才触发此事件
	window.addEventListener('storage', function(ev){
		alert('事件触发了');
		console.log(ev.key);			//5个属性 
		console.log(ev.newValue);		 
		console.log(ev.oldValue);
		console.log(ev.storageArea);
		console.log(ev.url);
	}, false);*/
	


	//第四部分：利用localStorage 做多页面数据同步
	//打开两个相同的此页面 假如A页面勾选了苹果西瓜 那另外一个B页面会自动勾选苹果西瓜 形成多页面数据自动同步
	var oCheck = document.getElementById('check');
	var aInput = oCheck.getElementsByTagName('input');

	//当前页面 把选取的和未选取的水果分别存储到sel nosel里
	for(var i=0; i<aInput.length; i++){
		aInput[i].onclick = function(){
			if(this.checked){	 
				// alert('存储sel')
				window.localStorage.setItem('sel', this.value);
			}else{				 
				// alert('存储nosel')
				window.localStorage.setItem('nosel', this.value);
			}	
		}
	}

	//上面的当前页面一旦存储了sel或者nosel 这里的其他页面就会触发下面的函数
	//经过触发事件的处理后 当前页面勾选变化 其他页面的勾选也会同步变化
	window.addEventListener('storage', function(ev){
		if(ev.key == 'sel'){	//上面的当前页面存储了sel
			// alert('sel');
			for(var i=0; i<aInput.length; i++){			//那就循环这个其他页面里的所有input	
				if(aInput[i].value == ev.newValue){		//如果其他页面的某个checkbox value值等于当前页面最近勾选的value值
					aInput[i].checked = true;			//那就选中这个其他页面对应的某个checkbox
				}				
			}
		}else if(ev.key == 'nosel'){
			// alert('nosel');
			for(var i=0; i<aInput.length; i++){			//同上
				if(aInput[i].value == ev.newValue){
					aInput[i].checked = false;			//取消选中
				}
			}
		}
	}, false);


}








