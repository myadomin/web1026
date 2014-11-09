
//弹窗的组件开发
window.onload = function(){
	var aInput = document.getElementsByTagName('input');
	aInput[0].onclick = function(){
		var dialog0 = new Dialog();
		dialog0.init({   
			iNow: 0      
		});
	}
	aInput[1].onclick = function(){
		var dialog1 = new Dialog();
		dialog1.init({   
			iNow: 1,     
			title: '公告',
			width: 200,
			height: 300,
			position: 'rightBottom'
		});
	}
	aInput[2].onclick = function(){
		var dialog2 = new Dialog();
		dialog2.init({ 
			//配置参数  
			iNow: 2,     	//唯一标示符 必传
			title: '遮罩',	//窗口标题
			width: 300,		//宽度高度
			height: 300,
			position: 'centerBottom',	//弹窗位置
			mark: true					//是否遮罩
		});
	}
}

//构造函数 参数设定
function Dialog(){
	this.oLogin = null;
	this.oMark = null;
	this.settings = { 
		//默认参数  
		title: '登录',
		width: 300,
		height: 300,
		position: 'center',
		mark: false
	}
}

//存储唯一标示符
Dialog.prototype.json = {}

//初始化
Dialog.prototype.init = function(options){
	for(var i in options){
		//有设置配置参数就用配置参数 否则用默认参数
		this.settings[i] = options[i];  
	}
	//如果第一次创建dialog0窗口 那json[options.iNow] 也就是json.0不存在 所以是undefined
	//然后就执行窗口创建 并且挂上窗口关闭事件
	//这些执行完毕后 随便给json[options.iNow] 也就是json.0赋个值就行
	//下次再点击创建dialog0窗口 json.0已经存在 不是undefined了 就不会执行这一段
	//而此时json.1 json.2仍然是undefined 他们还是可以创建
	//如果点击了关闭dialog0窗口 此时就把json[options.iNow] 也就是json.0 再赋值到undefined
	//下一次就能继续创建dialog0窗口
	if(this.json[options.iNow] == undefined){
		this.create();
		this.fnClose();
		this.json[options.iNow] = true;
	}
}

//创建窗口
Dialog.prototype.create = function(){
	this.oLogin = document.createElement('div');
	this.oLogin.className = 'login';
	this.oLogin.innerHTML = 	'<div class="header">'+
									'<span class="title">'+this.settings.title+'</span>'+
									'<span class="close">X</span>'+
								'</div>'+
								'<div class="content">'+
									'内容'+
								'</div>'
	document.body.appendChild(this.oLogin);

	this.setData();
}

//设置窗口属性
Dialog.prototype.setData = function(){
	this.oLogin.style.width = this.settings.width + 'px';
	this.oLogin.style.height = this.settings.height + 'px';

	if(this.settings.position == 'center'){
		this.oLogin.style.left = (viewWidth() - this.oLogin.offsetWidth) / 2 + 'px';
		this.oLogin.style.top = (viewHeight() - this.oLogin.offsetHeight) / 2 + 'px';
	}
	if(this.settings.position == 'rightBottom'){
		this.oLogin.style.left = (viewWidth() - this.oLogin.offsetWidth) + 'px';
		this.oLogin.style.top = (viewHeight() - this.oLogin.offsetHeight) + 'px';
	}
	if(this.settings.position == 'centerBottom'){
		this.oLogin.style.left = (viewWidth() - this.oLogin.offsetWidth) / 2 + 'px';
		this.oLogin.style.top = (viewHeight() - this.oLogin.offsetHeight) + 'px';
	}

	if(this.settings.mark){
		this.createMark();
	}
}

//添加遮罩
Dialog.prototype.createMark = function(){
	this.oMark = document.createElement('div');
	this.oMark.id = 'mark';
	document.body.appendChild(this.oMark);
	this.oMark.style.width = viewWidth() + 'px';
	this.oMark.style.height = viewHeight() + 'px';
	this.oMark.style.left = 0 + 'px';     //必须设置0px 否则他不会覆盖已存在的按钮
	this.oMark.style.top = 0 + 'px';
}

//关闭事件
Dialog.prototype.fnClose = function(){
	var oClose = this.oLogin.getElementsByTagName('span')[1];
	var _this = this;
	oClose.onclick = function(){
		document.body.removeChild(_this.oLogin);
		if(_this.settings.mark){
			document.body.removeChild(_this.oMark);
		}
		//已关闭了这个窗口 就让这个窗口的json.x继续赋值为undefined 便于下次再创建这个窗口
		_this.json[_this.settings.iNow] = undefined;
	}
}

function viewWidth(){
	return document.documentElement.clientWidth;
}
function viewHeight(){
	return document.documentElement.clientHeight;
}


