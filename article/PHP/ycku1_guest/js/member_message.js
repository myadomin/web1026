window.onload = function () {
	var all = document.getElementById('all');
	var fm = document.getElementsByTagName('form')[0];
	
	all.onclick = function () {
		//form.elements获取表单内的所有表单，checked表示已选
		for (var i=0;i<fm.elements.length;i++) {
			if (fm.elements[i].name!='chkall') {
				//如果chkall勾选  其他表单就全勾选  如果chkall不勾选  前台表单就全部勾选
				fm.elements[i].checked = fm.chkall.checked;
			}
		}
	};
	
	//如果不点击确定  就阻止掉后面的php跳转 
	fm.onsubmit = function () {
		if (confirm('确定要删除这些？')) {
			return true;
		} 
		return false;
	};
};