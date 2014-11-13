window.onload = function () {
	//点击验证码图片  img重新src code.php 刷新验证码
	var oCode = document.getElementById('code');
	oCode.onclick = function(){
		//避免缓存不刷新
		this.src = "code.php?time=" + new Date().getTime();
	}
	
	//表单验证
	var fm = document.getElementsByTagName('form')[0];
	fm.onsubmit = function() {
		//验证码验证
		if (fm.code.value.length != 4) {
			alert('验证码必须是4位');
			fm.code.focus(); //将焦点以至表单字段
			return false;
		}
		if (fm.content.value.length < 10 || fm.content.value.length > 200) {
			alert('内容不得小于10位，大于200位！');
			fm.content.focus(); //将焦点以至表单字段
			return false;
		}
	};
};