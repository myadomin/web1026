//基础算法

window.onload = function(){


//1：递归算法
//递 不断的调用函数自身 直到达到停止条件
//归 必须要设定停止调用条件
function test1(num){
	if(num == 1){
		console.trace();        //firebug查看最终归的时候 依次调用了test1(1) test1(2) test1(3) test1(4)
		return 1;              	//归 停止条件
	}

	//arguments.callee(num-1)比直接test1(num-1)的好处是解耦 也就是函数名如果改成不是test1了 这个函数也能用 
	return num*(arguments.callee(num-1));    //递
} 
// alert(test1(4));


//2：原生sort()排序
/*var arr = [22, 3, 51, 6 ,17];
alert(arr.sort());     		//如果不传参数 只考虑数组元素的第一位进行升序排序 17,22,3,51,6
alert(arr.sort(function(){  //如果传入function参数 return的是负数或0 同上 
	return -0.9;
}));
alert(arr.sort(function(){  //如果传入function参数 return的是正数 
	return 3.9111;			//那只考虑数组元素的第一位进行降序排序 6,51,3,22,17
}));
alert(arr.sort(function(){  //每次两个元素比较 retrun的可能是正可能是负 所以形成随机排序
	return Math.random() - 0.5;   
}));
alert(arr.sort(function(num1, num2){  //每次两个元素比较 如果前一个大于后一个 那return的num1-num2就是正数
	return num1 - num2;               //return正数 那两者就要交换位置 多次两个元素比较后 形成正常升序3,6,17,22,5
}));*/


//3：利用递归进行快速排序
function quickSort(arr){
	if(arr.length == 0){   //归 设定终止递的条件 达到就归
		console.trace();
		return arr;
	}

	var middleIndex = Math.floor(arr.length/2);  
	//数组长度是奇数 那找到索引是中间的那个数 这里数组长度是偶数 那就索引对应的就是6 
	//将找到的这个元素 从原数组中切出来 返回数组middle 原数组arr也变化成没有这个元素的新数组了
	var middle = arr.splice(middleIndex, 1);

	var left = [];    
	var right = [];

	for(var i=0; i<arr.length; i++){  //遍历更改过的没有6的新数组
		if(arr[i] < middle){          //每个数组元素都和6比较一下
			left.push(arr[i]);        //如果这个数组元素小于6 就存入left数组
		}else{
			right.push(arr[i]);       //如果这个数组元素大于6 就存入right数组
		}
	}

	return quickSort(left).concat(middle, quickSort(right));
}
// alert(quickSort([12,5,37,6,22,40]));


//4：枚举算法
//需求如下 找出能让下面数学公式成立的相应数字 填入
// 　　枚 举 算 法 题            //第一行
//  *　　　 　     枚            //第二行
// --------------------
//  题 题 题 题 题 题            //第三行
var aP = document.getElementById('div1').getElementsByTagName('p');
var aSpan1 = aP[0].getElementsByTagName('span');
var aSpan2 = aP[1].getElementsByTagName('span');
var aSpan3 = aP[2].getElementsByTagName('span');
var oBtn1 = document.getElementById('btn1');

oBtn1.onclick = function(){
	for(var i=1; i<=9; i++){     //第一行对应的万位 '枚' 1-9的循环
		for(var j=0; j<=9; j++){	//第一行对应的千位 '举' 0-9的循环
			for(var k=0; k<=9; k++){	//第一行对应的百位 '算' 0-9的循环
				for(var m=0; m<=9; m++){	//第一行对应的十位 '法' 0-9的循环
					for(var n=0; n<=9; n++){	//第一行对应的个位 '题' 0-9的循环

						//最终在最内层 枚举 循环计算i*j*k*m*n次
						var a = 10000*i + 1000*j + 100*k + 10*m + 1*n;  //第一行数字
						var b = i; 										//第二行数字
						var c = n*111111;								//第三行的数字

						if(a*b == c){ 
							//枚举的所有可能性 都去判断是否数学公式成立 如果成立就替换字符为对应数字
							aSpan1[0].innerHTML = i;
							aSpan1[1].innerHTML = j;
							aSpan1[2].innerHTML = k;
							aSpan1[3].innerHTML = m;
							aSpan1[4].innerHTML = n;
							aSpan2[0].innerHTML = i;
							for(var x=0; x<6; x++){
								aSpan3[x].innerHTML = n;
							}
						}

					}
				}
			}
		}
	}
}


//5：枚举应用 添加如下城市 如果没添加过就添加 添加过就把此城市移到第一位
var aA = document.getElementById('div2').getElementsByTagName('a');
var oUl1 = document.getElementById('ul1');
var aLi = oUl1.getElementsByTagName('li');

for(var i=0; i<aA.length; i++){
	aA[i].onclick = function(){
		if(!hasAdd(this.innerHTML)){    //如果没有添加过 就添加
			var oLi = document.createElement('li');
			oLi.innerHTML = this.innerHTML;		
			if(!aLi[0]){                //如果添加第一个
				oUl1.appendChild(oLi);
			}else{                      //添加第n个 新添加的都在最上面
				oUl1.insertBefore(oLi, aLi[0]);
			}	
		}else{                         //如果添加过了 
			for(var i=0; i<aLi.length; i++){ 	//那点击后 枚举已添加的所有li
				if(aLi[i].innerHTML == this.innerHTML){ 	//某个li是添加过的
					oUl1.insertBefore(aLi[i], aLi[0]);  	//那这个li就插入到aLi[0]前面去
					//elem.insertBefore(a,b)其实有两部动作 第一步先把a从elem里remove掉
					//然后第二步 在b元素节点之前插入a元素节点 
					//所以 如果节点还没append到父节点上 那就直接第二步了 插到指定位置之前
					//而这里 aLi[i]已是append到父节点上的节点了 那insertBefore就是先remove aLi[i]
					//然后插到aLi[0]前面 利用这个特性也可以进行列表标题等的排序
				}
			}
		}	
	}
}

//如果添加过返回true 没有添加过返回false
function hasAdd(text){
	var flag = false;
	var aLi = document.getElementById('ul1').getElementsByTagName('li');

	for(var i=0; i<aLi.length; i++){   	//枚举所有的li
		if(aLi[i].innerHTML == text){ 	//如果传进来希望添加的字符串 在某个li下已经有了 说明添加过
			flag = true;               	//标志转换为true 
		}
	}

	return flag;
}



}