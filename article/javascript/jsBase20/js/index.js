
//第一部分：主程序 -----------------------------------
window.onload = function(){

	var oName = document.getElementById('name');
	
	//使用grunt.js后 引用合并文件main.min.js
	seajs.use('./js/dist/main.min.js', function(arg){
		oName.innerHTML = '当前调用主模块1'
	});

}




//第二部分：如何使用grunt.js，把4个模块文件合并为main.min.js一个模块文件 --------------------
//一：安装nodejs npm grunt
//1：安装nodejs 安装后同时也安装好了npm(包管理工具) 通过npm才能进行后续的Grunt安装与管理
//2：安装Grunt的命令行接口：打开cmd 输入 npm install -g grunt-cli
//这条命令会把grunt命令植入到你的系统路径中 这样就可以在任意目录下运行Grunt命令并执行
//3: 安装最新版本的Grunt：输入 npm install grunt --save-dev
//如果当前命令行是C:\Users\domin>npm install grunt --save-dev 那grunt就安装在C:\Users\domin下
//参考第2条 grunt随便安在哪里其实都可以 
//4: 查看是否安装成功：输入 grunt -version 如果成功就出现版本号


//二：创建package.json配置文件(在当前项目的js目录下)
/*{
	"name": "demo2",			//自身项目名称
	"version": "0.1.0",			//自身项目版本号
	"devDependencies": {		//引入的插件	
		"grunt": "~0.4.2",		//引入grunt 
		"grunt-cmd-transport": "~0.3.0",	//引入文件依赖管理插件	
		"grunt-cmd-concat": "~0.2.7",		//引入合并文件的插件
		"grunt-contrib-uglify": "~0.3.2"	//引入压缩文件插件
	}
}*/
//然后在当前项目的js目录下输入命令行 npm install
//这样就在js目录下创建了node_modules文件夹 在这个文件夹下安装了上面的四个插件


//三：创建Gruntfile.js配置文件(在当前项目的js目录下)
//详细写法见Gruntfile.js文件
//然后在当前项目的js目录下输入命令行 grunt
//这样就执行完文件依赖管理 合并文件 压缩文件三个功能 最终在dist目录下形成合并文件main.min.js
//然后在index.js中引用模块1就改写成seajs.use('./js/dist/main.min.js')
//这样就只需要引用一个合并文件 而不需要像之前通过./js/main.js引用4个模块文件 减少了http请求


//四：什么是文件依赖管理？
//在没有合并'main.js', 'drag.js', 'scale.js', 'range.js'这四个文件之前
//他们的写法都是define(function(require, exports, module){xxx require(xxx) xxx}
//如果合并用常规的合并插件grunt-contrib-concat的话 就只是简单的把4个文件合并到main.js一个文件中
//简单合并后 例如main.js模块中require('./drag.js')就找不到了 因为文件都合并到main.js中 没有drag.js了
//所以必须用符合cmd规范的合并插件grunt-cmd-concat 并且合并前要用grunt-cmd-transport插件做依赖管理
//grunt-cmd-transport的作用就是在合并前的所有define函数里添加了2个参数
//变成了define("main", [ "./drag", "./range", "./scale" ], function(require, exports, module){xxx}
//这样在合并后的main.js文件中 每个模块都有自己的id(第一个参数) 及关联的模块(第二个参数) 形成依赖管理




