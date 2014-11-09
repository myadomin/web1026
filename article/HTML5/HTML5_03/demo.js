
//HTML5的拖拽操作 支持IE10+ chrome firefox
window.onload = function(){


	//第一部分：拖拽的基本操作 ------------------------------------
	var oUl1 = document.getElementById('ul1');
	var aLi = oUl1.getElementsByTagName('li');
	var oDiv1 = document.getElementById('div1');
	var i = 0;

	//被拖拽体
	for(var i=0; i<aLi.length; i++){
		aLi[i].index = i;
		aLi[i].ondragstart = function(ev){
			var ev = ev || event;
			//在火狐下 必须设置setData才能开始拖拽 setData getData在IE下无效
			ev.dataTransfer.setData('index', this.index);
			this.style.background = 'red';
		}

		aLi[i].ondrag = function(){			//静止不动也算ondarg
			this.innerHTML = '拖拽中' + i++;
		}

		aLi[i].ondragend = function(){
			this.style.background = 'blue';
		}
	}

	//拖拽目标
	oDiv1.ondragenter = function(){
		this.innerHTML = '被拖拽体进入我了';
	}

	oDiv1.ondragover = function(ev){
		var ev = ev || event;
		this.innerHTML = '被拖拽体在我上面' + (i++);
		ev.preventDefault();
	}

	oDiv1.ondrop = function(ev){
		// alert('被拖拽体在我上面释放鼠标触发，要触发我必须阻止掉ondragover默认事件');
		var ev = ev || event;
		//通过之前setData设置好的index 这里通过getData提取
		oUl1.removeChild(aLi[ev.dataTransfer.getData('index')]);
		for(var i=0; i<aLi.length; i++){	//及时更新索引
			aLi[i].index = i;
		}
	}

	oDiv1.ondragleave = function(){
		this.innerHTML = '被拖拽体离开我了';
	}



	//第二部分：拖拽硬盘图片到目标 ------------------------------------
	var oDiv2 = document.getElementById('div2');
	var oUl2 = document.getElementById('ul2');

	oDiv2.ondragenter = function(){
		this.innerHTML = '可以释放了';
	}

	oDiv2.ondragover = function(ev){
		var ev = ev || event;
		ev.preventDefault();		//阻止默认事件 下面的ondrop才有效
	}

	oDiv2.ondragleave = function(){
		this.innerHTML = '可以将硬盘里的图片拖到我这个区域';
	}

	oDiv2.ondrop = function(ev){
		var ev = ev || event;
		ev.preventDefault();		//也阻止本身的默认事件 这样被拖动的硬盘图片就不会被浏览器打开
		
		var fs = ev.dataTransfer.files;				//获取被拖放文件的集合
		for(var i=0; i<fs.length; i++){	
			if(fs[i].type.indexOf('image') != -1){	//是图片才做如下操作
				var fd = new FileReader();			//获取文件对象
				fd.readAsDataURL(fs[i]);
				fd.onload = function(){
					var oLi = document.createElement('li');
					var oImg = document.createElement('img');
					oImg.src = this.result;			//通过this.result得到被拖放图片的src
					oLi.appendChild(oImg);
					oUl2.appendChild(oLi);			//生成到ul下
				}
			}else{
				alert('请上传图片类型的文件');
			}
		}
	}



	//第三部分：拖拽商品到购物车 ------------------------------------
	var oUl3 = document.getElementById('ul3');
	var aLi3 = oUl3.getElementsByTagName('li');
	var oCart = document.getElementById('cart');
	var oMoneyNum = document.getElementById('money_number');
	var json = {};

	//被拖拽对象
	for(var i=0; i<aLi3.length; i++){
		aLi3[i].ondragstart = function(ev){				//开始拖拽
			var title = this.getElementsByTagName('p')[0].innerHTML;
			var price = this.getElementsByTagName('p')[1].innerHTML;
			var ev = ev || event;
			ev.dataTransfer.setData('title', title);	//存储title信息
			ev.dataTransfer.setData('price', price);	//存储price信息
		}
	}

	//拖拽目标 购物车
	oCart.ondragover = function(ev){
		var ev = ev || event;
		ev.preventDefault();		//阻止默认事件 下面的ondrop才有效
	}

	oCart.ondrop = function(ev){
		var ev = ev || event;
		ev.preventDefault();		//阻止默认事件 防止浏览器打开图片
		var title = ev.dataTransfer.getData('title');	//读取title信息
		var price = ev.dataTransfer.getData('price')	//读取price信息
		var aP = oCart.getElementsByTagName('p');

		if(json[title] != true){	//如果没有添加过这本书 添加到购物车
			var oP = document.createElement('p');
		
			var oSpan1 = document.createElement('span');
			oSpan1.innerHTML = 1 + '本';
			oSpan1.className = 'box1';
			oP.appendChild(oSpan1);

			var oSpan2 = document.createElement('span');
			oSpan2.innerHTML = title;	
			oSpan2.className = 'box2';
			oP.appendChild(oSpan2);

			var oSpan3 = document.createElement('span');
			oSpan3.innerHTML = price;	
			oSpan3.className = 'box3';
			oP.appendChild(oSpan3);

			oCart.appendChild(oP);
			json[title] = true;		//当前书名拖放到购物车后 存储标示到json
		}else{						//如果添加过本书 找到本书 数量加1
			for(var i=0; i<aP.length; i++){
				var oSpan1 = aP[i].getElementsByTagName('span')[0];
				var oSpan2 = aP[i].getElementsByTagName('span')[1];
				var oSpan3 = aP[i].getElementsByTagName('span')[2];
				if(oSpan2.innerHTML == title){	//找到已添加过的那本书
					oSpan1.innerHTML = parseInt(oSpan1.innerHTML) + 1 + '本';	//数量加1
					oSpan3.innerHTML = parseInt(oSpan3.innerHTML) + parseInt(price) + '元';	//加一个单价
				}
			}
		}

		var nMoney_total = 0;
		for(var i=0; i<aP.length; i++){		//计算合计金额
			var oSpan3 = aP[i].getElementsByTagName('span')[2];
			nMoney_total += parseInt(oSpan3.innerHTML);	
		}
		oMoneyNum.innerHTML = nMoney_total;
	}


}








