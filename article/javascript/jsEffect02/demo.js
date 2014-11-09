
//倒计时效果
window.onload = function(){
	var oInput1 = document.getElementById('input1');		
	var oInput2 = document.getElementById('input2');	
	var oInput3 = document.getElementById('input3');	 
	var oBox2 = document.getElementById('box2');
	var oOutput1 = document.getElementById('output1');	
	var oDay = document.getElementById('day');
	var oHour = document.getElementById('hour');
	var oMin = document.getElementById('min');
	var oSec = document.getElementById('sec');
	var Ftime = null;
	
	oBox2.onclick = function(){
		org1 = oInput1.value                     //每次点击 保存按下按钮后的原始输入值
		org2 = oInput2.value
		org3 = oInput3.value
		updateTime();                            //每次点击执行一次函数 得到最新的时间戳差值 这句必须写在点击事件下
		Ftime = setInterval(updateTime,1000);    //每次点击重新开启定时器 后续的过期时间会跳出程序停止定时器 后续的重新输入input value也会停掉定时器	         
	}
	
	function updateTime(){
		var oDateEnd = new Date();                        	//new两个Date对象出来，这个用于设置为输入框内的年月日及0分秒等
		var oDateNow = new Date();							//这个不设置，所以操作时，他永远是当前的时间
		oDateEnd.setFullYear(parseInt(oInput1.value));    	//通过setxxxx方法，设置新new出来的oDateEnd对象的年月日等
		oDateEnd.setMonth(parseInt(oInput2.value) - 1);   	//记得设置月的时候 减一。
		oDateEnd.setDate(parseInt(oInput3.value));
		oDateEnd.setHours(0);
		oDateEnd.setMinutes(0);
		oDateEnd.setSeconds(0);	
		iRemain = (oDateEnd.getTime() - oDateNow.getTime())/1000;   //通过.getTime() 得到输入时间和当前时间的毫秒数，相减除1000就是差多少秒 
		
		if(iRemain<0){                         	//如果输入的时间早于现在的时间 那就全0 并停掉定时器 并打印 然后迅速跳出函数
			oDay.innerHTML = setDigit(0,4);
			oHour.innerHTML = setDigit(0,2);
			oMin.innerHTML = setDigit(0,2);
			oSec.innerHTML = setDigit(0,2);
			clearInterval(Ftime);             	//注意这里必须要停掉定时器，否则函数从头执行 到了alert之后再return出去 过1000函数又从头执行到return
			alert('已过期时间');
			return;
		}
		
		var iDay = parseInt(iRemain/86400);  	//通过以下的方法 将相差的秒数，算成多少天 小时 分钟 秒
		iRemain %= 86400;
		var iHour = parseInt(iRemain/3600);
		iRemain %= 3600;
		var iMin = parseInt(iRemain/60);
		iRemain %= 60;
		var iSec = parseInt(iRemain); 
	
		oDay.innerHTML = setDigit(iDay,4);
		oHour.innerHTML = setDigit(iHour,2);
		oMin.innerHTML = setDigit(iMin,2);
		oSec.innerHTML = setDigit(iSec,2);
		oOutput1.innerHTML = oInput1.value + "年" + oInput2.value + "月" + oInput3.value + "日"
		
		if(oInput1.value!=org1||oInput2.value!=org2||oInput3.value!=org3){ //如果输入值和按按钮之前的值不同了 也就是重新输入值的时候
			oDay.innerHTML = setDigit(0,4);        
			oHour.innerHTML = setDigit(0,2);
			oMin.innerHTML = setDigit(0,2);
			oSec.innerHTML = setDigit(0,2);
			clearInterval(Ftime);                //那就全0 并停掉定时器 然后迅速跳出函数 必须再按按钮才能重新开启定时器
			return;
		}
	}	 
	 
	function setDigit(num,n){
		var str = '' + num ;   //等同于'num'（这样写如果传入num本身就是字符串就会报错）,所以还是''+比较好。 
		while(str.length<n){   //n就是要用前面的0补成几位数 例如要补成3位 n就是3。
				str = '0' + str;   //往前面填零
		}
		return str;
	}

}








