//文章列表百叶窗效果
window.onload = function(){

	var oUl1 = document.getElementById('ul1');
	var oUl2 = document.getElementById('ul2');
	
	toShow(oUl1);
	setTimeout(function(){
		toShow(oUl2);
	}, 2000);

	//百叶窗效果 函数封装
	function toShow(obj){
		var aDiv = obj.getElementsByTagName('div');
		var iNow = 0;
		var Timer = null;
		var flag = true;
		var timer = null;

		//每4ms启动一次变化
		setInterval(function(){
			clearInterval(timer);
			//所有标题 间隔100ms依次运动
			timer = setInterval(function(){
				if(iNow == aDiv.length){
					clearInterval(timer);
					flag = !flag;			//每次所有标题变化完毕 变化flag iNow置0
					iNow = 0;
				}else if(flag){				//通过判断flag 决定是上翻还是下翻
					bufferMove(aDiv[iNow], {"top": "0px"});		//下翻
					iNow ++;
				}else{
					bufferMove(aDiv[iNow], {"top": "-30px"});	//上翻
					iNow ++;
				}			
			}, 100);
		}, 4000);	

	}
}

