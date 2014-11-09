
//拖动放大模块scale
define(function(require, exports, module){

	//exports scale方法 供外部调用
	exports.scale = function(obj1, obj2){
		obj2.onmousedown = function(ev){
			var oEvent = ev || window.event;
			var downX = ev.clientX;
			var downY = ev.clientY;
			var downWidth = obj1.offsetWidth;
			var downHeight = obj1.offsetHeight;

			document.onmousemove = function(ev){
				var oEvent = ev || window.event;
				var w = ev.clientX - downX + downWidth;
				var h = ev.clientY - downY + downHeight;

				//引入range模块 调用range方法 限制拖动放大范围
				w = require('./range.js').range(w, 400, 100);
				h = require('./range.js').range(h, 400, 100)

				obj1.style.width = w + 'px';
				obj1.style.height = h + 'px';
			}

			document.onmouseup = function(){
				document.onmousemove = null;
				document.onmouseup = null;
			}
		}
	}

});