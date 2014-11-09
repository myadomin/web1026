window.onload = function(){
	var Amessage = document.getElementsByName("message");
	var Afriend = document.getElementsByName("friend");
	var Aflower = document.getElementsByName("flower");
	for(var i=0; i<Amessage.length; i++){
		Amessage[i].onclick = function(){
			//alert(this.title);
			centerWindow("message.php?id="+this.title, "message", 250, 400);
		}
	}
	for(var i=0; i<Afriend.length; i++){
		Afriend[i].onclick = function(){
			//alert(this.title);
			centerWindow("friend.php?id="+this.title, "friend", 250, 400);
		}
	}
	for(var i=0; i<Aflower.length; i++){
		Aflower[i].onclick = function(){
			//alert(this.title);
			centerWindow("flower.php?id="+this.title, "flower", 250, 400);
		}
	}
}

function centerWindow(url, name, height, width){
	var left = (screen.width - width)/2;
	var top = (screen.height - height)/2;
	window.open(url, name, "height="+height+",width="+width+",left="+left+",top="+top);
	//window.open('','','width=200,height=100') 第三个参数是一个整体的字符串 所以上面这样用++写
}