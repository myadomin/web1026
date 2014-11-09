
//限制取值范围模块range
define(function(require, exports, module){

	//exports range方法 供外部调用
	exports.range = function(value, max, min){
		if(value > max){
			return max;
		}else if(value < min){
			return min;
		}else{
			return value;
		}
	}

});