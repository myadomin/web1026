
//关于iframe的操作
window.onload = function(){ 

//1：iframe基本操作
/*iframe和div等元素一样 都能进行width border overflow等所有CSS操作
在html加scrolling="no"去除滚动条 不能在css中加overflow:hidden 因为IE不兼容 
iframe src属性指向一个文件(例如src="111.html") 深度刷新后就能在iframe内部载入这个文件
iframe name属性设定后(例如name="iframe1")  然后其他a标签设置target="iframe1" 
就能将a的href="xx.html"文件载入到这个iframe1中去
iframe对象具备onload事件 iframe引入的子文档加载完毕就触发
但是IE低版本不能直接onload 必须用现代绑定attachEvent('onload', function(){xx});*/


//2：父文档改变iframe子文档的字体颜色
//***注意*** 获取父文档的oBtn1元素时 document前要加上parent 否则找不到元素 
//***注意*** 加了parent后chorme必须在服务器环境下运行 否认浏览器还是不认识oBtn1等元素
var oBtn1 = parent.document.getElementById('btn1');		
var oIframe1 = parent.document.getElementById('iframe1');
oBtn1.onclick = function(){
	//找到子文档111.html的window对象(oIframe1.contentWindow) 然后oIframe1.contentWindow.document找到子文档DOM
	oIframe1.contentWindow.document.getElementById('div1').style.color = 'red';
}


//3：iframe子文档改变父文档的字体颜色
//在111.html等子文档中写下如下js代码
/*window.onload = function(){  
	var oBtn2 = document.getElementById('btn2');
	oBtn2.onclick = function(){
		//111.html子文档通过window.parent就能找到父文档window 然后window.parent.document找到父文档DOM
		window.parent.document.getElementById('span1').style.color = 'red';
	}
}*/


//4：iframe框体高度如何自适应子文档高度
//iframe框体不能设置死高度 因为这个iframe中后续会加载多个不同高度的子文档 如何自适应高度？
//一刷新进来 就获取获取当前子文档的body高度 
//这里不能获取body的height 因为在IE下是auto 所以这里获取高度是body的offsetHeight
var iFrameDocumentHeight = oIframe1.contentWindow.document.body.offsetHeight;
oIframe1.style.height = iFrameDocumentHeight + 'px';  

//对于a标签 它href了子文档(子文档有各自不同的高度) 点击a后再次执行上面的语句 来重设iframe框体的高度
var aA = document.getElementsByTagName('a');
for(var i=0; i<aA.length; i++){
	aA[i].onclick = function(){
		//这里必须等iframe对象加载子文档完毕后 再获取子文档的高度
		//***注意*** IE低版本不能直接onload 必须用现代绑定attachEvent('onload', function(){xx});
		addEvent(oIframe1, "load" ,function(){
			var iFrameDocumentHeight = oIframe1.contentWindow.document.body.offsetHeight;
			oIframe1.style.height = iFrameDocumentHeight + 'px';
		})	 
	}
}


//5：另一种实现自适应高度的方法 在111.html 222.html等子文档分别写上
/*window.onload = function(){
	parent.document.getElementById('iframe1').style.height =  document.body.offsetHeight + 'px'; 
}*/


function addEvent(obj,type,fn){
	if(typeof obj.addEventListener != 'undefined'){   //W3C  
		obj.addEventListener(type,fn,false); 
	}else if(typeof obj.attachEvent != 'undefined'){  //兼容IE低版本 
		obj.attachEvent('on'+type,fn);
	}
}


}



 






 