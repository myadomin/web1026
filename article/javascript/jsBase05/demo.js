//表格及表单DOM操作


window.onload = function(){

	//第一部分：表格的DOM操作 ------------------------------------------------

	//1：表格的元素提取（相对于其他元素提取 有简写方法）
	//var oTab = document.getElementById('tab1');
	//普通元素提取 输出莫莫
	//alert(oTab.getElementsByTagName('tbody')[0].getElementsByTagName('tr')[2].getElementsByTagName('td')[1].innerHTML); 
	//表格特有元素提取 输出莫莫
	//alert(oTab.tBodies[0].rows[2].cells[1].innerHTML)  

	var oTab = document.getElementById('tab1');
	var oBtn2 = document.getElementById('btn2');
	var oBtn3 = document.getElementById('btn3');
	var oTxt3 = document.getElementById('txt3');
	var oBtn4 = document.getElementById('btn4');
	var oTxt4 = document.getElementById('txt4');
	var oBtn5 = document.getElementById('btn5');
	//2：隔行变灰色 同时鼠标放上去变黄色 并且不改变原来隔行的灰色
	oBtn2.onclick = function(){	
		var oldBackground = null;		//预存原颜色
		for(var i=0 ; i<oTab.tBodies[0].rows.length ; i++){
			if(i%2 == 0){				//取模 隔行变色
				oTab.tBodies[0].rows[i].style.background = '#ccc';
			}else{
				oTab.tBodies[0].rows[i].style.background = '';
			}
			oTab.tBodies[0].rows[i].onmouseover = function(){
				oldBackground = this.style.background;       //保持在鼠标还没放上来前的原颜色
				this.style.background = 'yellow';
			}
			oTab.tBodies[0].rows[i].onmouseout = function(){
				this.style.background = oldBackground;       //恢复到鼠标还没放上来前的原颜色
			}
		}
	}


	//3：表格的行添加及删除
	oBtn3.onclick = function(){
		//添加一个tr 注意IE6下innerHTML第一个&lt字符 会有bug
		var oTr = document.createElement('tr');
		oTr.innerHTML = '<td>'+oTab.tBodies[0].rows.length+'</td><td>'+oTxt3.value+'</td><td><a href = "#">删除</a></td>';
		oTab.tBodies[0].appendChild(oTr);
			
		var aA = oTab.tBodies[0].getElementsByTagName('a');       
		for(var i=0 ; i<aA.length ; i++){      
			aA[i].onclick = function(){       //对于每个a 一旦有点击事件 就删除他那行(父父节点)
				oTab.tBodies[0].removeChild(this.parentNode.parentNode); 
			}
		}	
	}


	//4：搜索匹配内容的行
	oBtn4.onclick = function(){	
		var aTr = oTab.tBodies[0].rows;

		for(var i=0 ; i<aTr.length ; i++){                				 
			var cellsTxt = aTr[i].cells[1].innerHTML.toLowerCase();  //获取每一行的第二列的内容 并转化为小写
			var inputTxt = oTxt4.value.toLowerCase();                //获取文本框输入的内容

			if(cellsTxt.search(inputTxt) != -1){    //利用search函数查找 只要inputTxt是cellsTxt中任意位置的相连的任意个数的字符串 就不会返回-1
				aTr[i].style.background = 'yellow';        	
			}else{
				aTr[i].style.background = '';
			}	
	  	}	
	}


	//5：对每一行重新排序 依据表格的某一列数值大小
	var change = false;
	oBtn5.onclick = function(){
		change=!change;                                  	//每次点击都转换一次boolea值 从而升序降序转换
		
		var arr = [];
		for(var i=0 ; i<oTab.tBodies[0].rows.length ; i++){
			arr[i] = oTab.tBodies[0].rows[i];            	//1：先将rows多个对象的集合 转换成数组
		}

		arr.sort(function(tr1,tr2){                      	//2：再对这个数组进行排序 排序依据表格某一行的第一列里面的数字大小
			if(change){
				return parseInt(tr1.cells[0].innerHTML) - parseInt(tr2.cells[0].innerHTML);
			}else{
				return parseInt(tr2.cells[0].innerHTML) - parseInt(tr1.cells[0].innerHTML);
			}
		});
		
		for(var i=0 ; i<arr.length ; i++){                	//3：将tr节点按照升序 依次重新作为tbody的节点
			oTab.tBodies[0].appendChild(arr[i]);       		//.appendChlid方法其实有两次操作  先从父节点解除 再作为父节点的最末子节点
		}			 
	}
	


	//第二部分：表单的DOM操作 ------------------------------------------------

	//6：form的获取方法
	// var oForm = document.getElementById('myForm');
	// var oForm = document.getElementsByTagName('form')[0];
	// var oForm = document.forms[0];   	//针对form特有的 推荐用这个 
	
	//7：表单控件的获取 就是form下面的input textarea select等
	// var oForm = document.forms[0];
	// alert(oForm.elements.length);    	//表单元素个数
	// alert(oForm.elements[3].value);  	 
	// alert(oForm.elements[6].value);  	 
	// alert(oForm.elements[7].value);  	//获取第7个表单元素的value
	// alert(oForm.elements[0].name);   	//获取第0个表单元素的name
	
	//8：option的选取
	// var oSelect = document.getElementById('mySelect');   //获取select
	// alert(oSelect.options[0].text);                      //获取第一个option的文本
	// alert(oSelect.options.length);                       //获取option的长度
 
 	//9:简单的表单验证
	var oForm = document.forms[0];
	var oUser = document.getElementsByName('user')[0];
	var oPass = document.getElementsByName('pass')[0];
	
	oForm.onsubmit = function(){                  	//当提交时
		if(oUser.value== ''){   					//如果没填姓名
			alert('没有填姓名');
			return false;      						//阻止提交
		}else if(oPass.value == ''){
			alert('没有填密码');
			return false; 
		}
	}
	
	oForm.onreset = function(){             		//当重置时
		return confirm('你确定全部重置？');			//用户点确定返回true 点取消回false 
	}
 
 
}



















	
