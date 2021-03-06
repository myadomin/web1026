﻿

//一：面向对象 混合构造函数形成过程-------------------------------------------- 
//window.onload = function(){

//1：给新对象obj1 obj2加上属性和方法
/*var obj1 = new Object();    	//新对象1
obj1.name = 'luo';          	//属性 对比变量
obj1.age = 30;
obj1.showName = function(){ 	//方法 对比函数
	alert(this.name);
}
obj1.showAag = function(){
	alert(this.age);
}
obj1.showName();
obj1.showAag();

var obj2 = new Object();		//新对象2
obj2.name = 'wan';
obj2.age = 26;
obj2.showName = function(){
	alert(this.name);
}
obj2.showAag = function(){
	alert(this.age);
}
obj2.showName();
obj2.showAag();*/


//2：但是上面如果要创造100个对象就要写100次 所以用下面的工厂方式 用函数抽象重复的部分
/*function createPerson(theName, theAge){  
	//原料 每运行一次这个函数就new一个对象出来
	var obj = new Object();
	//加工 给这个新对象添加上属性和方法              
	obj.name = theName;
	obj.age = theAge;
	obj.showName = function(){
		alert(this.name);
	}
	obj.showAge = function(){
		alert(this.age);
	}
	//出厂 最终返回出这个new的对象 这个对象就具备了某些属性和方法了
	return obj;
}
//实例化的对象1
obj1 = createPerson('luo', 30);  //运行函数 传入参数 得到一个新对象 这个新对象有了相应的方法 属性
alert(obj1.name);
alert(obj1.age);
obj1.showName();
obj1.showAge();
//实例化的对象2
obj2 = createPerson('wan', 26);
alert(obj2.name);
alert(obj2.age);
obj2.showName();
obj2.showAge();
//方法各自都是独立的 并不是同一个方法 只是长的一样
alert(obj1.showName == obj2.showName);  //false*/


//3：但是上面的工厂模式存在两个问题
//问题1：每次实例化的时候没有new 比如arr = new Array()这些都有new
//问题2：每次实例化一个对象 就要给这个对象添加一次长得一样的 但是并不是同一个方法的方法 太耗资源


//4：关于new之后 函数内部this的变化
/*function aaa(){
	alert(this);
}
aaa();    		   		//object Window 如果不加new 此时this就是window对象
new aaa();         		//object Object 如果加了new 此时this变成了一个新对象(new Object)
//也就是说 new后 系统就自己创建了一个新对象(var this = new Obeject)
//同时系统自动将这个对象返回了(return this)
//所以在上面的构造函数中new构造函数 然后obj全部用this替换掉 
//同时var obj = new Obeject以及return obj 都不需要写了 系统已经做了 所以如下解决方法*/


//5：解决3-问题1 工厂模式没有new的问题
//obj全部用this替换掉  var obj = new Obeject以及return obj都不需要写了 系统已经做了
/*function createPerson(theName, theAge){
	//原料
	// var this = new Object();    //new后 系统就做了这一步 自己不用写
	//加工
	this.name = theName;           //this就是下面new出的新对象
	this.age = theAge;
	this.showName = function(){
		alert(this.name);
	}
	this.showAge = function(){
		alert(this.age);
	}
	//出厂
	// return this;                //new后 系统就做了这一步 自己不用写
}
var obj1 = new createPerson('luo', 30);
obj1.showName();
obj1.showAge();*/


//6：原型prototype的理解
/*var arr1 = new Array(1,13,15,7);   
var arr2 = new Array(2,4,11);      
arr1.sum = function(){        	//给arr1添加方法
	var result = 0;
	for(var i=0; i<this.length; i++){
		result += this[i];
	}
	return result;
}
alert(arr1.sum());     			//输出数组arr1的数组元素累加结果
// alert(arr2.sum());  			//报错 因为aar2下面并没有sum方法
//而不管是arr1 arr2 或者之后定义的任何的arrx = new Array(xx,xx,xx);
//他们都是实例化出来的数组对象 所以可以在数组对象Array(类)上 添加原型方法sum 
//那所有实例化出来的数组对象arrx下面都会有sum方法了 所以如下给Array(类)添加原型方法
Array.prototype.sum = function(){
	var result = 0;
	for(var i=0; i<this.length; i++){
		result += this[i];
	}
	return result;
}
alert(arr2.sum());  
//这样所有的实例化出的数组对象 下面都有sum方法了 可以正确输出了
//上面是添加的是系统给的Array(类) 而我们实际应用一般不去改动系统定义对象(类) 
//所以一样是在Object对象(类)下面添加一些我们要的原型方法 然后实例化出的对象都能有这个方法*/


//7：解决问题3-问题2 给工厂模式添加原型方法
//最终形成构造函数+原型方法的混合模式
/*function CreatePerson(theName, theAge){     //规定构造函数首字母都大写
	this.name = theName;                    //属性 根据参数的不同都不同
	this.age = theAge;
}
CreatePerson.prototype.showName = function(){   //方法 不管是什么参数 作用都是showName 作用一样
	alert(this.name);                           //放在原型方法里
}
CreatePerson.prototype.showAge = function(){
	alert(this.age);
}
var obj1 = new CreatePerson('luo', 30);  
obj1.showName();                        //实例化的对象obj1下面有了showName方法
obj1.showAge();
var obj2 = new CreatePerson('wan', 26);
obj2.showName();					    //实例化的对象obj2下面也有了showName方法
obj2.showAge();
alert(obj1.showName == obj2.showName);  //并且这两个方法是同一个方法了*/

//}




//二：用面向对象 改写面向过程选项卡------------------------------------------------- 
//1：原来的面向过程的选项卡 
/*window.onload = function(){
	var oDiv = document.getElementById('div1');
	var aBtn = oDiv.getElementsByTagName('input');
	var aDiv = oDiv.getElementsByTagName('div');
	aBtn[0].className = 'active';       //页面一刷新 初始见到的就是第一个按钮附上 class="active" 按钮是红色的  原来的所有按钮不加任何CSS
	aDiv[0].style.display = 'block';    //页面一刷新 初始见到的就是第一个框体就是div部分的第一个div框体   原来的div框体全部隐藏
	for(i=0 ; i<aBtn.length ; i++){     //开始循环按钮，任何三个按钮的 onclick函数就绪
		aBtn[i].index = i;   	    	//先保存按钮序列号
		aBtn[i].onclick = function(){   //一旦某个按钮有点击行为就开始触发这个函数
			for(i=0 ; i<aBtn.length ; i++){    //将所有的按钮class去除  将所有的div全部隐藏
				aBtn[i].className = '';
				aDiv[i].style.display = 'none';
			}
			this.className = 'active';         //给被点击的那个按钮加上 class="active"   this相当于aBtn[i]被点击的那个按钮 但是这里不能写aBtn[i] 下同
			aDiv[this.index].style.display = 'block';  //被点击的那个按钮有一个序列号 这个序列号对应的div的框体显示
		}
	}
}*/


//2：第一步改写 程序可以运行 不能有函数嵌套 把嵌套的函数提出来 
//函数被提出后 可以加全局变量 以便让被提取的函数能够认识变量 
/*window.onload = function(){
	var oDiv = document.getElementById('div1');
	aBtn = oDiv.getElementsByTagName('input');
	aDiv = oDiv.getElementsByTagName('div');
	aBtn[0].className = 'active';        
	aDiv[0].style.display = 'block';    
	for(i=0 ; i<aBtn.length ; i++){     
		aBtn[i].index = i;   					 
		aBtn[i].onclick = tab;
	};
}
function tab(){    
	for(i=0 ; i<aBtn.length ; i++){    
		aBtn[i].className = '';
		aDiv[i].style.display = 'none';
	};
	this.className = 'active';         
	aDiv[this.index].style.display = 'block';   
} */


//3：第二步改写 将变量变成构造函数的属性即this下的属性 将函数变成构造函数的方法（原型方法）  
//不能运行 因为this指向不正确
/*function TabSwitch(id){
	var oDiv = document.getElementById(id);
	this.aBtn = oDiv.getElementsByTagName('input');  //变量都变成一个构造函数的属性 即this下的属性
	this.aDiv = oDiv.getElementsByTagName('div');
	this.aBtn[0].className = 'active';        
	this.aDiv[0].style.display = 'block';    
	for(i=0 ; i<this.aBtn.length ; i++){     
		this.aBtn[i].index = i;   					 
		this.aBtn[i].onclick = this.tab;        	 //函数都变成一个构造函数的方法（原型方法）  
	};
}
TabSwitch.prototype.tab = function(){    
	for(i=0 ; i<this.aBtn.length ; i++){    
		aBtn[i].className = '';
		aDiv[i].style.display = 'none';
	};
	this.className = 'active';         
	this.aDiv[this.index].style.display = 'block';   
} 
window.onload = function(){
	var oTab = new TabSwitch('div1');
}*/


//4：用定时器的时候 容易出现this指向混乱 
//定时器在构造函数里面setTimeout或者setInterval("this.xxx",1000) 分号里面的this必定指向window  
/*function Aaa(){
		this.a = 12;
		setInterval("this.show()",1000);    //这里的this指向window  所以this.show is not a function 
}
Aaa.prototype.show = function(){
		alert(this);            //object Window
		alert(this.a);          //undefined 因为没有window.a 如果外围加了全局变量var a = 10 那么window.a = 10
}
var obj1 = new Aaa();   
//为了改变this不指向window而应该指向构造函数对象 做如下的改写
function Aaa(){
		this.a = 12;
		_this = this;
		setInterval("_this.show()" ,1000);    //这里的_this指向构造函数对象
}
Aaa.prototype.show = function(){
		//alert(this);                   
		alert(this.a);                  //12
}
var obj1 = new Aaa(); */


//5：事件函数 容易出现this指向混乱 
//事件函数中的this是指向事件对象的 不是指向构造函数对象的
/*function Bbb(){
	this.b = 5;
	_this = this;              //用_this保持构造函数对象
	var oBtn = document.getElementById('btn1');
	oBtn.onclick = function(){
		//this.show();          //这里this指向的是oBtn对象，oBtn对象上并没有show()方法
		_this.show();           //构造函数对象上才有show()方法
	}
}
Bbb.prototype.show = function(){
		alert(this.b);
}
var obj1 = new Bbb();
obj1.show();*/


//6：最终改写 修正this的指向
//一部分this要指向构造函数 一部分this要指向被点击的事件对象 用_this=this预存构造函数对象
function TabSwitch(id){
	this.oDiv = document.getElementById(id);
	this.aBtn = this.oDiv.getElementsByTagName('input');   
	this.aDiv = this.oDiv.getElementsByTagName('div');
	this.aBtn[0].className = 'active';        
	this.aDiv[0].style.display = 'block';  
	var _this = this;                         //预存构造函数对象
	for(i=0 ; i<this.aBtn.length ; i++){     
		this.aBtn[i].index = i;   					 
		this.aBtn[i].onclick = function(){  //原来的this.tab()的this指向的是被点击的按钮对象 而被点击的按钮对象上面并没有tab方法
			_this.tab(this);                //所以被点击对象下再写个函数 在他里面放上构造函数对象下的tab方法  _this.tab()
		};     
	};
}

TabSwitch.prototype.tab = function(theClickBtn){     //通过上面的_this.tab(this) 给这个函数接收到了上面的this 上面的this代表的就是被点击的按钮
	for(i=0 ; i<this.aBtn.length ; i++){    
		this.aBtn[i].className = '';
		this.aDiv[i].style.display = 'none';
	};
	theClickBtn.className = 'active';                 
	this.aDiv[theClickBtn.index].style.display = 'block';  
} 	

/*window.onload = function(){
	var oTab = new TabSwitch('div1');                //在最下面的onload调用
	oTab.autoPlay();
}*/

//为什么上面的tab可以变成function(){tab();}
/*window.onload = function(){
	var aaa = function(){
		alert(11);
	}
	var bbb = function(){
		aaa();         	//aaa()就是上面函数的执行结果 就是alert(11)这句话
	};
	aaa();   			//弹出11
	bbb();   			//也是弹出11
	//所以说明 aaa定义为匿名函数后 可以aa=匿名函数 也可以写成function(){匿名函数();}的形式
}*/


//总结：改写面向过程程序为面向对象程序的步骤如下:
//1：原函数不能有函数套函数，将被嵌套的函数全部提取出来。
//2：将局部变量全部改成全局变量
//3：将变量全部变成构造函数this下的属性.
//4：将提取出来的函数全部变成原型方法
//5：this指向混乱 特别事件函数及定时器函数 通过某个作用域先存_this=this 再将_this放入其他作用域




//三：面向对象继承 拷贝继承 -------------------------------------------- 
//window.onload = function(){

//1：.call()继承属性 原型链继承方法
/*function Person(name,age){					//父类
	this.name = name;
	this.age = age;
}
Person.prototype.showName = function(){
	alert(this.name);
}
Person.prototype.showAge = function(){
	alert(this.age);
}

function Worker(name,age,job){				//子类继承了父类的属性和方法 并且有自己的方法
	//person.call(name,age)就等同于上面的Person函数的执行结果 也就是那两句话
	//person.call(this,name,age) 就是在上面的基础上 仅仅改变this指向当前的Worker实例化出的对象
	Person.call(this,name,age);  
	this.job = job;                
}
Worker.prototype = Person.prototype;   	  	//通过原型链 来继承父级的方法
Worker.prototype.showJob = function(){
	alert(this.job);
}

worker1 = new Worker('luo',30,'coder');   	//实例化
alert(worker1.name);    				  	//说明已经继承了父函数的属性
worker1.showAge();      			      	//说明已经继承了父函数的方法
alert(Person.prototype.showJob);   	 		//出现问题 原来的父函数也有showJob方法了    
//通过原型链继承方法后 父类也有子类方法了 子类影响了父类 这个肯定不行*/


//2：为什么 Worker.prototype = Person.prototype后 子类方法影响了父类方法？
//var arr1 = [1,2,3];
//var arr2 = arr1;
//arr2.push(4);
//alert(arr1);    //1,2,3,4  为什么这个也会变成和arr2一样呢？
//alert(arr2);    //1,2,3,4  这个可以理解 因为 arr2.push(4);
//因为arr2 =arr1的过程就相当于 arr2的指针也指向了arr1指针指向的内存区域 他们共用同一片内存区域 所以对arr2添加任何东西都相当于给arr1添加东西
//所以上面Worker.prototype = Person.prototype后 Person.prototype添加了showJob方法 Worker.prototype也就有了showJob方法
//那arr2如何先获取arr1 同时不指向同一片内存避免互相影响呢
/*var arr1 = [1,2,3];
var arr2 = [];             		//arr1和arr2指向不同的内存区域
for(var i in arr1){
		arr2[i] = arr1[i];     	//把arr1的每个元素从arr1的内存复制到arr2指向的内存区域去
}
arr2.push(4);
alert(arr2);    				//1,2,3,4  成功push了4进栈
alert(arr1);    				//1,2,3    arr1并不受arr2影响 说明arr2指针是指向的另外的内存区域  
//所以结论是用for in改写上面的Worker.prototype = Person.prototype; */


//3：实现继承最终版 拷贝继承 用for in改写上面的Worker.prototype = Person.prototype; 
/*function Person(name,age){			//父类
	this.name = name;
	this.age = age;
}
Person.prototype.showName = function(){
	alert(this.name);
}
Person.prototype.showAge = function(){
	alert(this.age);
}

function Worker(name,age,job){		//子类
	Person.call(this,name,age);    	//子类通过父级.call(this,xx,xx) 继承父级的属性
	this.job = job;                 //子类自有属性
}

for(var i in Person.prototype){    			    //Person.prototype就是很多方法的集合 就相当于一个数组
	//通过for in 用类似上面数组的操作方式进行继承后 之后子类的方法也不添加进父类的方法
	Worker.prototype[i] = Person.prototype[i];  
}    
Worker.prototype.showJob = function(){          //子类自有方法
		alert(this.job);
}

worker1 = new Worker('luo',30,'coder');   //实例化
alert(worker1.name);    				  //说明已经继承了父类的属性
worker1.showAge();      				  //说明已经继承了父类的方法
worker1.showJob();                        //说明子类自身的方法没问题
alert(Person.prototype.showJob);   		  //undefined  所以子类的方法不添加进父类了 
alert(Worker.prototype.showJob);          //子类自身的方法也保留了
alert(worker1 instanceof Worker);  		  //ture  instanceof用于判定某某实例如worker1是不是Worker的对象*/


//面向对象拷贝继承总结
//1：子类通过.call()对象冒充，继承父类属性，再添加自己的属性
//2：子类通过for in原型方法(拷贝继承)，继承父类原型方法，再添加自己的原型方法

//}




//四：面向对象类式继承 记得重新指定constructor ------------------------------------------
/*function Person(name, age){
	this.name = name;
	this.age = age;
	this.arr = [1, 2, 3];
}
Person.prototype.showName = function(){
	return this.name;
}
Person.prototype.showAge = function(){
	return this.age;
}

function Worker(name, age, job){   				//属性继承
	Person.call(this, name, age);
	this.job = job;
}

Worker.prototype = new Person();     			//类式继承
//必须重新指定constructor 否则子类constructor指向父类了
Worker.prototype.constructor = Worker;         
Worker.prototype.showJob = function(){
	return this.job;
}

var person1 = new Person('luo', 30);
var worker1 = new Worker('luo', 30, 'coder');
alert(worker1.showName());      			//luo 成功继承父类的方法和属性
// alert(person1.showJob());    			//报错 子类添加的方法 没有影响到父类 成功
// alert(worker1 instanceof Worker);   	   	//true
alert(worker1.constructor == Worker);   	//true  成功
alert(worker1.constructor == Person);   	//false  成功
*/




//五：面向对象拷贝继承 形成限制拖拽------------------------------------- 
window.onload = function(){
	var oTab = new TabSwitch('div1'); 			//div1 tab切换
	var drag = new Drag('div2');				//div2 拖拽
	var limitDrag = new LimitDrag('div3');		//div3 限制拖拽
}

//1：面向对象拖拽 无范围限制
function Drag(id){
	this.oDiv2 = document.getElementById(id);
	this.scrollLeft = 0;
	this.scrollTop = 0;
	this.disX = 0;
	this.disY = 0;
	var _this = this;    //预存this
	this.oDiv2.onmousedown = function(ev){
		_this.fnDown(ev, this);	
		return false;    //阻止文字选中
	};
}

Drag.prototype.fnDown = function(ev, theMouseDownObj){
	var oEvent = ev || event;  
	var _this = this;     
	this.scrollLeft = document.documentElement.scrollLeft || document.body.scrollLeft;
	this.scrollTop = document.documentElement.scrollTop || document.body.scrollTop;
	this.disX = oEvent.clientX + this.scrollLeft - theMouseDownObj.offsetLeft;
	this.disY = oEvent.clientY + this.scrollTop - theMouseDownObj.offsetTop;
	document.onmousemove = function(ev){
		_this.fnMove(ev); 
		return false;  
	};
	document.onmouseup = _this.fnUp;	
}

Drag.prototype.fnMove = function(ev){   
	var oEvent = ev || event;  
	nLeft = oEvent.clientX + this.scrollLeft - this.disX;
	nTop = oEvent.clientY + this.scrollTop - this.disY;
	this.oDiv2.style.left = nLeft + 'px';
	this.oDiv2.style.top = nTop + 'px';     
}

Drag.prototype.fnUp = function(){
	document.onmousemove = null;
	document.onmouseup = null;
}

//2：通过继承 形成限制拖拽
function LimitDrag(id){    		//属性继承
	Drag.call(this, id);
}

for(var i in Drag.prototype){   //方法继承
	LimitDrag.prototype[i] = Drag.prototype[i];
}

LimitDrag.prototype.fnMove = function(ev){   //重写mousemove事件 增加限制拖拽范围功能  
	var oEvent = ev || event;  
	nLeft = oEvent.clientX + this.scrollLeft - this.disX;
	nTop = oEvent.clientY + this.scrollTop - this.disY;

	if(nLeft < this.scrollLeft){ 
		nLeft = this.scrollLeft;
	}
	if(nLeft > document.documentElement.clientWidth - this.oDiv2.offsetWidth + this.scrollLeft){
		nLeft = document.documentElement.clientWidth - this.oDiv2.offsetWidth + this.scrollLeft;
	}
	if(nTop < this.scrollTop){
		nTop = this.scrollTop;
	}
	if(nTop > document.documentElement.clientHeight - this.oDiv2.offsetHeight + this.scrollTop){
		nTop = document.documentElement.clientHeight - this.oDiv2.offsetHeight + this.scrollTop;
	}

	this.oDiv2.style.left = nLeft + 'px';
	this.oDiv2.style.top = nTop + 'px';     
}

//改写面向过程为面向对象并继承的步骤如下:
//1：原函数不能有函数套函数，将被嵌套的函数全部提取出来。
//2：将局部变量全部改成全局变量 先整体可以正常运行
//3：将变量全部变成构造函数this下的属性.
//4：将提取出来的函数全部变成原型方法
//5：this指向混乱 特别事件函数及定时器函数 通过某个作用域先存_this=this 再将_this放入其他作用域
//6：子函数通过.call()对象冒充，继承父函数属性，再添加自己的属性
//7：子函数通过for in原型方法(拷贝继承)，继承父函数原型方法，再添加自己的原型方法




//六：其他 -----------------------------------------------------
//window.onload = function(){

//1：json单例模式 只合适一个对象 不合适需要定义多个对象的情况
/*var json = {
	name:"luo",
	age:30,
	showName:function(){
		alert(this.name);
	},
	showAge:function(){
		alert(this.age);
	}
}
json.showName();
json.showAge();*/


//2：json命名空间 
/*var companyName = {};
companyName.man1 = {};   		//每个人用一个特定的空间 就算每个人都写了一个同名的函数getUser也互不影响
companyName.man2 = {};
companyName.man3 = {};
companyName.man1.getUser = function(){
	alert('man1 function');
}
companyName.man2.getUser = function(){
	alert('man2 function');
}
companyName.man3.getUser = function(){
	alert('man3 function');
}
companyName.man1.getUser();  	//每个人用一个特定
companyName.man2.getUser();
companyName.man3.getUser();*/


//3：hasOwnProperty 是否是自身独有属性
/*var arr = new Array();
arr.num1 = 10;
Array.prototype.num2 = 20;
alert(arr.num1);
alert(arr.hasOwnProperty('num1'));  //true num1是对象arr自身独有的属性 所以是true
alert(arr.num2);
alert(arr.hasOwnProperty('num2'));  //false num2是所有数组对象都有的属性 所以是false
*/


//4：constructor 查看对象的构造函数
/*function Aaa(){

}
var aaa1 = new Aaa();
alert(aaa1.constructor);  			//function Aaa(){} 也就是Aaa 所以下面是true
alert(aaa1.constructor == Aaa); 	//true 
*/


//5：json形式 必须重新指定constructor
/*function Aaa(){

}
Aaa.prototype = {
	constructor: Aaa,  //如果写成这种json形式 必须重新指定constructor
	job: 'coder'
}
var aaa1 = new Aaa();
alert(aaa1.constructor);  
alert(aaa1.constructor == Aaa);
//如果在json中不指定constructor 那就是function Object() {[native code]}
//如果指定了constructor为Aaa 那就是function Aaa() {}
//也就是说虽然内容上 json形式等同于 Aaa.prototype.job = 'coder'
//但是写成json形式后 constructor指向了Object 而不是Aaa了 所以要重新指定constructor*/

//}
