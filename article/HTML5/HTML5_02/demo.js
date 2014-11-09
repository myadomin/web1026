//HTML5播放器
window.onload = function(){

	//第一部分：自定义播放器
	var oVideo1 = document.getElementById('video1');
	var oBtn2 = document.getElementById('btn2');
	var oBtn3 = document.getElementById('btn3');
	var oBtn4 = document.getElementById('btn4');
	var oBtn5 = document.getElementById('btn5');
	var oBtn6 = document.getElementById('btn6');
	var oBtn7 = document.getElementById('btn7');
	var oBtn8 = document.getElementById('btn8');
	var oBtn9 = document.getElementById('btn9');
	var oBtn10 = document.getElementById('btn10');
	var oBtn11 = document.getElementById('btn11');
	
	oBtn2.onclick = function(){
		oVideo1.play();     	//视频对象.play() 播放方法
	}
	oBtn3.onclick = function(){
		oVideo1.pause();     	//暂停方法
	}
	oBtn4.onclick = function(){
		oVideo1.currentTime += 10;  	//设置.currentTime属性 快进10秒
	}
	oBtn5.onclick = function(){
		oVideo1.currentTime -= 10;
	}
	oBtn6.onclick = function(){
		if(oBtn6.innerHTML == '静音'){
			oVideo1.muted = true;   	//设置.muted为true 就是静音
			oBtn6.innerHTML = '不静音';
		}else{
			oVideo1.muted = false;   	//设置.muted为true 就是静音
			oBtn6.innerHTML = '静音'
		}	
	}
	oBtn7.onclick = function(){
		oVideo1.playbackRate = 3;  		//设置.playbackRate属性 正常倍数基础上加速3倍
	}
	oBtn8.onclick = function(){
		oVideo1.playbackRate = 0.3; 	//正常倍数基础上减速3倍
	}
	oBtn9.onclick = function(){
		oVideo1.playbackRate = 1;  		//正常倍数 
	}
	oBtn10.onclick = function(){
		oVideo1.volume += 0.1; 			//音量加0.1  默认是最大音量1
	}
	oBtn11.onclick = function(){
		oVideo1.volume -= 0.1;  		//音量减0.1
	}
	

	//第二部分：模拟钢琴
	var oUl1 = document.getElementById('ul1');
	var aLi1 = oUl1.getElementsByTagName('li');
	var oAudio1 = document.getElementById('audio1');

	for(var i=0; i<aLi1.length; i++){
		aLi1[i].onmouseover = function(){
			oAudio1.src = this.getAttribute('au');
			oAudio1.play();
		}
	}


	//第三部分：模仿优酷微缩视频
	var oV3 = document.getElementById('video3');
	var oC3	= document.getElementById('canvas3');
	var oGc3 = oC3.getContext('2d');

	oC3.width = oV3.videoWidth/2;
	oC3.height = oV3.videoHeight/2;
	setInterval(function(){
		//drawImage除了画图还能画视频 画布坐标0 0 宽度oC3.width 高度oC3.height 画布css fixed定位
		oGc3.drawImage(oV3, 0, 0, oC3.width, oC3.height);	
	},30);


}








