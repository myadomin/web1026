window.onload = function(){
	var aImg = document.getElementById('face').getElementsByTagName('img');

	for(var i=0; i<aImg.length; i++){
		aImg[i].onclick = function(){
			//face.php 点击某个头像后  更改打开它的register.php页面的对应DOM节点的src value值
			window.opener.document.getElementById('faceimg').src = this.src;
			window.opener.document.getElementById('faceinput').value = this.alt;
		}
	}	
}