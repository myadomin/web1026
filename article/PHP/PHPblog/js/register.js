
window.onload = function(){

	//点击选择头像图片区域 打开face.php窗口
	var oFace = document.getElementById("face_img");
	oFace.onclick = function(){
		faceWindow = window.open('face.php','face','width=400,height=400,top=0,left=0,scrollbars=1');	
	}
	
	//执行验证码程序
	code();

	//表单验证 能用客户端验证的 尽量用客户端 当点击提交onsubmit的时候 js开始验证 
	//如果不合法 就return false阻止onsubmit事件  否则return true
	var fm = document.getElementsByTagName('form')[0];
	fm.onsubmit = function () {      
		
		//用户名验证
		if (fm.username.value.length < 2 || fm.username.value.length > 20) {
			alert('用户名不得小于2位或者大于20位');
			fm.username.value = ''; //清空
			fm.username.focus(); //将焦点以至表单字段
			return false;         
		}
		if (/[<>\'\"\ ]/.test(fm.username.value)) {
			alert('用户名不得包含非法字符');
			fm.username.value = ''; //清空
			fm.username.focus(); //将焦点以至表单字段
			return false;
		}
		
		//密码验证
		if (fm.password.value.length < 6) {
			alert('密码不得小于6位');
			fm.password.value = ''; //清空
			fm.password.focus(); //将焦点以至表单字段
			return false;
		}
		if (fm.password.value != fm.notpassword.value) {
			alert('密码和密码确认必须一致');
			fm.notpassword.value = ''; //清空
			fm.notpassword.focus(); //将焦点以至表单字段
			return false;
		}
		
		//密码提示与回答
		if (fm.question.value.length < 2 || fm.question.value.length > 20) {
			alert('密码提示不得小于2位或者大于20位');
			fm.question.value = ''; //清空
			fm.question.focus(); //将焦点以至表单字段
			return false;
		}
		if (fm.answer.value.length < 2 || fm.answer.value.length > 20) {
			alert('密码回答不得小于2位或者大于20位');
			fm.answer.value = ''; //清空
			fm.answer.focus(); //将焦点以至表单字段
			return false;
		}
		if (fm.answer.value == fm.question.value) {
			alert('密码提示和密码回答不得相等');
			fm.answer.value = ''; //清空
			fm.answer.focus(); //将焦点以至表单字段
			return false;
		}
		
		//邮箱验证
		if (!/^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/.test(fm.email.value)) {
			alert('邮件格式不正确');
			fm.email.value = ''; //清空
			fm.email.focus(); //将焦点以至表单字段
			return false;
		}
		
		//QQ号码
		if (fm.qq.value != '') {
			if (!/^[1-9]{1}[\d]{4,9}$/.test(fm.qq.value)) {
				alert('QQ号码不正确');
				fm.qq.value = ''; //清空
				fm.qq.focus(); //将焦点以至表单字段
				return false;
			}
		}
		
		//网址
		if (fm.url.value != 'http://') {
			if (!/^https?:\/\/(\w+\.)?[\w\-\.]+(\.\w+)+$/.test(fm.url.value)) {
				alert('网址不合法');
				fm.url.value = ''; //清空
				fm.url.focus(); //将焦点以至表单字段
				return false;
			}
		}
		
		//验证码验证 只验证是否是4位
		if (fm.code.value.length != 4) {
			alert('验证码必须是4位');
			fm.code.value = ''; //清空
			fm.code.focus(); //将焦点以至表单字段
			return false;
		}
		
		faceWindow.close();	 //关闭face.php窗口
	
		return true;   //如果到这里 上面都没有return false出去 就说明js部分验证通过 在js验证通过之前 就关闭face.php窗口
	};

	
}