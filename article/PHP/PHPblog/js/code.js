function code(){
	//点击验证码图片 刷新验证码
	var oImg = document.getElementById("code");
	oImg.onclick = function(){
		//点击图片后 此图片的src变为 code.php?tm=随机小数 这样就实现了code.php的刷新
		this.src = "code.php?tm="+Math.random();
	}
}
