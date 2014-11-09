window.onload = function(){
	var aDd = document.getElementsByTagName("dd");
	for(var i=0 ; i<aDd.length ; i++){
		aDd[i].onclick = function(){         //一个js只能被一个php或者html应用 不能同时被两个引用 这个js被face.php引用 
			var oImg = this.getElementsByTagName("img")[0];     //如果被两个应用 就没法知道获得的dom节点到底是哪个文件的dom了
			var oFaceImg = opener.document.getElementById("face_img");  //为了得到父窗口register.php的文本节点 用opener.document查找
			var oFaceInput = opener.document.getElementById("face_input");
			oFaceImg.src = oImg.alt;     //将父窗口register.php的这个图片节点的src 替换为被打开窗口face.php中被点击的图片的alt
			oFaceInput.value = oImg.alt; //将父窗口register.php的id="face_input"的input节点的value值 
		}                                //设置为face.php中被点击的图片的alt 便于后续表单提交信息到服务器
	}
}
