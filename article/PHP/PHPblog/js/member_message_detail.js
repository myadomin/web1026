window.onload = function(){
	var oBack = document.getElementById("back");
	var oDelete = document.getElementById("delete");
	oBack.onclick = function(){
		history.back();
	}
	oDelete.onclick = function(){
		if(confirm('你确定要删除此短信')){
			location.href = 'member_message_detail.php?action=delete&id='+this.name;
		}
	}
}