
//拖拽模块drag
define(function(require, exports, module){

	//exports drag方法 供外部调用
	exports.drag = function(obj){
		obj.onmousedown = function(ev){
			var oEvent = ev || window.event;
			var disX = ev.clientX - obj.offsetLeft;
			var disY = ev.clientY - obj.offsetTop;

			document.onmousemove = function(ev){
				var oEvent = ev || window.event;
				var maxLeft = document.documentElement.clientWidth - obj.offsetWidth;
				var maxTop = document.documentElement.clientHeight - obj.offsetHeight;
				var l = ev.clientX - disX;
				var t = ev.clientY - disY

				//引入range模块 调用range方法 限制拖拽范围
				l = require('./range.js').range(l, maxLeft, 0);
				t = require('./range.js').range(t, maxTop, 0);
				
				obj.style.left = l + 'px';
				obj.style.top = t + 'px';
			}

			document.onmouseup = function(){
				document.onmousemove = null;
				document.onmouseup = null;
			}

			return false;
		}
	}

	// 查看当前模块对象 
	// console.log(module);
});