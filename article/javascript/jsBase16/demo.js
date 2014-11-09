//基于JQ的选项卡组件开发

/**
 * title 基于JQ的选项卡组件开发
 * options: index, event, delay
 * methods: getContent
 * events: beforeClick afterClick
 */


//主函数
$(function(){

	//t1 具备选项卡点击切换功能
	var t1 = new Tab();
	t1.init('div1', {});  

	//t2 具备选项卡hover切换功能 并且能获取当前选项卡内容
	var t2 = new Tab();
	t2.init('div2', {
		event: 'mouseover'
	});
	t2.getContent();

	//t3 具备选项卡hover切换并延时200ms执行功能 并且能获取当前选项卡内容
	var t3 = new Tab();
	t3.init('div3', {
		event: 'mouseover',
		delay: 200
	});
	t3.getContent();      					//methods

	//t4 具备选项卡点击切换功能 刷新进入被选中的选项卡永远是第三个 具备beforeClick afterClick自定义事件
	var t4 = new Tab();
	t4.init('div4', {
		index: 2               				//options
	});
	//在原生JS中需要自己写模拟绑定自定义事件函数bindEvent 用JSON层级存储好函数
	//然后自己写fireEvent函数来主动触发自定义事件 释放执行JSON层级存储好的函数
	//在jquery中 直接用on就能完成bindEvent功能 直接用trigger就能主动触发自定义事件
	$(t4).on('beforeClick', function(){   	//events
		alert('点击前');
	});
	$(t4).on('afterClick', function(){
		alert('点击后');
	});

});


//构造函数
function Tab(){
	this.oParent = null;
	this.aInput = null;
	this.aDiv = null;
	this.settings = { 
		//默认参数  
		index: 0,
		event: 'click',
		delay: 0,
	}
}


//初始化
Tab.prototype.init = function(oParent, options){
	//有配置参数就用配置参数 没有就用默认参数
	$.extend(this.settings, options);   

	this.oParent = $('#' + oParent);
	this.aInput = this.oParent.find('input');
	this.aDiv = this.oParent.find('div');
	this.nowsel();
	this.change();
}


//刷新进来 显示Tab的第一个卡还是第n个卡 默认第一个卡 也就是index为0
Tab.prototype.nowsel = function(){
	this.aInput.eq(this.settings.index).addClass('active').siblings('input').removeClass('active');
	this.aDiv.eq(this.settings.index).show().siblings('div').hide(); 
}


//Tab切换
Tab.prototype.change = function(){
	//预存this 
	var _this = this;   		
	var timer = null;

	//事件触发
	$(this).trigger('beforeClick');   
	
	//on绑定的事件就是参数event的值
	this.aInput.on(this.settings.event, function(){
		//预存this 
		var _eventObj = this; 

		//对于t3 会延迟200ms执行show函数
		if(_this.settings.delay){  
			timer = setTimeout(function(){
				show(_this, _eventObj); 
			}, _this.settings.delay);
		}else{
			show(_this, _eventObj);
		}
	}).mouseout(function(){
		//如果还没到200ms 还没执行show就移出了 那就清除这个定时器不再切换
		clearInterval(timer);     
	});	
}


//show函数封装
//_this是构造函数实例化出来的对象 _eventObj是当前被触发事件的对象
function show(_this, _eventObj){ 
	//触发自定义的beforeClick事件     
	$(_this).trigger('beforeClick');  

	//执行选项卡切换
	$(_eventObj).addClass('active').siblings('input').removeClass('active');
	_this.aDiv.eq($(_eventObj).index()).show().siblings('div').hide();

	//触发自定义的afterClick事件 
	$(_this).trigger('afterClick');  
}


//在Tab中动态生成获取当前页内容按钮 点击这个按钮弹出Tab当前页的内容
Tab.prototype.getContent = function(){
	var _this = this;
	this.oParent.append('<input type="button" value="获取当前页内容" class="btn" />');
	this.oParent.find('.btn').click(function(){
		var iNow = _this.oParent.find('.active').index();
		alert($(this).siblings('div').eq(iNow).html());
	})
}

