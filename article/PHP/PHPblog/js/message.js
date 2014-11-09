window.onload = function () {
	code();
	
	var fm = document.getElementsByTagName('form')[0];
	fm.onsubmit = function () {  
		//内容长度验证
		if (fm.content.value.length < 10 || fm.content.value.length > 200) {
			alert('输入的内容不得小于10位或者大于200位');
			fm.content.focus(); //将焦点以至表单字段
			return false;         
		}
		
		//验证码验证
		if (fm.code.value.length != 4) {
			alert('验证码必须是4位');
			fm.code.value = ''; //清空
			fm.code.focus(); //将焦点以至表单字段
			return false;
		}
		return true;
	}
	
};