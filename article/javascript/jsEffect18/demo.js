//3D轮播图
//主要原理：
//将每个元素的width left top index opacity等属性值存入数组 
//点击按钮后 通过arrRollPrev及arrRollNext函数 改变数组元素的排序 
//然后把数组元素重新赋值给每个元素 形成运动
window.onload = function(){
	var oPrev = getByClass(document, 'prev')[0];
	var oNext = getByClass(document, 'next')[0];
	var aLi = document.getElementsByTagName('ul')[0].getElementsByTagName('li');
	var arrWidth = [];
	var arrLeft = [];
	var arrTop = [];
	var arrZIndex = [];
	var arrOpacity = [];

	//将各个属性存入到相应数组中 
	for(var i=0; i<aLi.length; i++){
		arrWidth.push(getStyle(aLi[i], 'width'));
		arrLeft.push(getStyle(aLi[i], 'left'));
		arrTop.push(getStyle(aLi[i], 'top'));
		arrZIndex.push(getStyle(aLi[i], 'zIndex'));
		arrOpacity.push(getStyle(aLi[i], 'opacity'));
	}

	//点击一次 改变一次数组元素的位置 
	oPrev.onclick = function(){
		arrRollPrev(arrWidth);
		arrRollPrev(arrLeft);
		arrRollPrev(arrTop);
		arrRollPrev(arrZIndex);
		arrRollPrev(arrOpacity);
		change();
	}
	oNext.onclick = function(){
		arrRollNext(arrWidth);
		arrRollNext(arrLeft);
		arrRollNext(arrTop);
		arrRollNext(arrZIndex);
		arrRollNext(arrOpacity);
		change();
	}
	
	//例子 [1,2,3,4,5] 执行一次后 变成[2,3,4,5,1]
	function arrRollPrev(arr){
		var temp = arr.shift();
		arr.push(temp);
	}
  
	//例子 [1,2,3,4,5] 执行一次后 变成[5,1,2,3,4]
	function arrRollNext(arr){
		var temp = arr.pop();
		arr.unshift(temp);
	}

	//经过变化的数组元素 再赋值给DOM节点 形成运动效果
	function change(){
		for(var i=0; i<aLi.length; i++){
			aLi[i].style.zIndex = arrZIndex[i];
			bufferMove( aLi[i], { "width": arrWidth[i], "left": arrLeft[i], "top": arrTop[i], "opacity": arrOpacity[i] } );
		}
	}

}


//通过class获取元素
function getByClass(oParent,sClass){
	var aEle = oParent.getElementsByTagName('*');    
	var aResult = [];
	for(var i=0 ; i<aEle.length ; i++){
		if(aEle[i].className == sClass){
			aResult.push(aEle[i]);                     
		}
	}	
	return aResult;																  
}

