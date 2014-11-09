
//主模块1 包含drag及scale子模块
define(function(require, exports, module){
	
	var oInpnut = document.getElementById('input1');
	var oDiv1 = document.getElementById('div1');
	var oDiv2 = document.getElementById('div2');
	var oDiv3 = document.getElementById('div3');

	// 引入drag模块 调用drag方法
	// 调用require方法时 无论drag.js相对当前这个main.js文件是怎样的相对路径 都统一用./drag.js调用
	require('./drag.js').drag(oDiv3);

	oInpnut.onclick = function(){
		oDiv1.style.display = 'block';
		// 引入scale模块 调用scale方法 统一./scale.js调用
		require('./scale.js').scale(oDiv1, oDiv2);
	}

	//exports name属性 供外部调用
	exports.name = '主模块1';

});
