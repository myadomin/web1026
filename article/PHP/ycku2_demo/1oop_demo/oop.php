<?php
//面向对象基础
header("Content-type:text/html; charset=utf-8");

//PHP的oop基本写法 类比JAVA
/* class Person{
	private $_name;
	private $_age;
	CONST JOB = "coder";		//静态全局常量
	
	public function __construct($_name, $_age){	//构造方法	
		$this->_setName($_name);
		$this->_setAge($_age);
	}
	
	public function _setName($_name){
		$this->_name = $_name;
	}
	public function _setAge($_age){
		$this->_age = $_age;
	}
	public function _getName(){
		return  $this->_name;
	}
	public function _getAge(){
		return $this->_age;
	}
	
	public function _getInfo(){
		return "姓名：" . ($this->_getName()) . "，年龄：" . ($this->_getAge()) . "，职业：" . Person::JOB ;
	} 
	
	public function __destruct(){				//析构方法 最后执行
		echo "<br/>程序执行完毕";
	}
}

$per = new Person("张三", 30);
echo $per->_getInfo(); */


//PHP系统内置拦截器 __set() __get() 魔术方法
/* class Person{
	private $_name;
	private $_age;
	CONST JOB = "coder";
	
	public function __construct($_name, $_age){
		$this->__set(_name, $_name);
		$this->__set(_age, $_age);
	}
	
	private function __set($_key, $_value){		//_set() _get()不需要被外部调用 为了更好的封装型 做成private
		$this->$_key = $_value;
	}	
	private function __get($_key){
		return $this->$_key;
	}
	
	public function _getInfo(){
		return "姓名：" . ($this->__get(_name)) . "，年龄：" . ($this->__get(_age)) . "，职业：" . Person::JOB ;
	}
}

$per = new Person("张三", 30);
echo $per->_getInfo(); */


//静态方法  静态属性
/* class Person{
	public static function _run(){	//静态方法
		echo "我是静态方法，不需要new就可以被调用执行<br/>";
	}
	
	public static $_num = 0;		//静态属性
	public function _add(){
		self::$_num ++;
	}
}

Person::_run();			//静态方法  不需要new直接被调用执行

$per1 = new Person();
$per1->_add();
$per1->_add();
$per1->_add();			//静态属性 存储在data数据区 所有实例化对象共享属性值
echo "\$per1对象执行三次_add()后静态属性的值：" . Person::$_num;			//3

$per2 = new Person();
$per2->_add();			//4  因为per2与上面的per1共享$_num静态属性值
$per2->_add();			
$per2->_add();
echo "<br/>\$per2对象执行三次_add()后静态属性的值：" . Person::$_num;		//6 */


//继承
/* class Person{
	private  $_name;
	private  $_age;
	protected $_content = "父类方法";		//protected 子类通过$this->_content可以调用
	
	public function __construct($_name, $_age){
		$this->__set(_name, $_name);
		$this->__set(_age, $_age);
	}
	
	private function __set($_key, $_value){
		$this->$_key = $_value;
	}
	private function __get($_key){
		return $this->$_key;
	}
	
	public function PersonInfo(){
		return "姓名：" . ($this->__get(_name)) . "，年龄：" . ($this->__get(_age)) ;
	}
	
	public function say(){
		return $this->_content;
	}
}

class Student extends Person{
	private $_school;
	
	public function __construct($_name, $_age, $_school){
		parent::__construct($_name, $_age);		//继承父类构造方法
		$this->__set(_school, $_school);
	}
	
	private function __set($_key, $_value){		
		$this->$_key = $_value;
	}
	private function __get($_key){
		return $this->$_key;
	}
	
	public function StudentInfo(){				//自身子类方法   内部调用了PersonInfo()父类方法
		return parent::PersonInfo() . "，学校：" . $this->__get(_school) ;
	}
	
	public function say(){	//覆写父类方法  因为父类定义的$_content是protected 所以在子类可以通过$this->_content调用到
		return "我覆写了". $this->_content ."，我是子类方法";
	}
}

$stu1 = new Student("张三", 20, "清华大学");
echo $stu1->StudentInfo()."<br/>";
echo $stu1->say(); */


//抽象类  抽象方法  接口
/* abstract class Abs{								//抽象类(不能被new) 用于给子类继承用  可以有各个类型的属性及方法
	protected  $_content = "呵呵，";
	public function _absRun1(){					
		return $this->_content . "我是普通方法";
	}
	public abstract function _absRun2();		//必须有抽象方法(不能实现的方法，必须被子类覆写) 
}	

interface Int1{					//接口 用于被实现  只能有静态全局常量和抽象方法
	CONST INDEX1 = "Int1";		//静态全局常量
	function _intRun1();		//抽象方法 必须被覆写 一般省略掉public abstract(好像写abstract就报错)
}

interface Int2{
	CONST INDEX2 = "Int2";
	function _intRun2();
}

class Demo extends Abs implements Int1, Int2{	//只能继承一个抽象类  可以实现多个接口 可以同时继承和实现
	public function _absRun2(){
		return $this->_content . "我必须覆写了父类Abs的抽象方法";
	}	
	
	public function _intRun1(){
		return "我必须覆写接口" . Demo::INDEX1 . "的方法";
	}
	
	public function _intRun2(){
		return "我必须覆写接口" . Demo::INDEX2 . "的方法";
	}
}

$d1 = new Demo();
echo $d1->_absRun1()."<br/>";
echo $d1->_absRun2()."<br/>";
echo $d1->_intRun1()."<br/>";
echo $d1->_intRun2()."<br/>"; */


//继承抽象类  实现多态
/* abstract class Person{
	protected $_name;
	protected $_age;
	
	public function __construct($_name, $_age){
		$this->_set(_name, $_name);
		$this->_set(_age, $_age);
	}
	
	private function _set($_key, $_value){
		$this->$_key = $_value;
	}
	private function _get($_key){
		return $this->$_key;
	}
	
	public abstract function getInfo();		//定义抽象方法  子类必须实现这个方法  给出自己的信息
}

class Student extends Person{
	private $_score;		//学生特有 成绩
	
	public function __construct($_name, $_age, $_score){
		parent::__construct($_name, $_age);
		$this->_set(_score, $_score);
	}
	
	private function _set($_key, $_value){
		$this->$_key = $_value;
	}
	private function _get($_key){
		return $this->$_key;
	}
	
	public function getInfo(){
		return "姓名：" . $this->_get(_name) . "，年龄：" . $this->_get(_age) . "，分数：" . $this->_get(_score) ;
	}	
}

class Work extends Person{
	private $_salary;		//工人特有 工资
	
	public function __construct($_name, $_age, $_salary){
		parent::__construct($_name, $_age);
		$this->_set(_salary, $_salary);
	}
	
	private function _set($_key, $_value){
		$this->$_key = $_value;
	}
	private function _get($_key){
		return $this->$_key;
	}
	
	public function getInfo(){
		return "姓名：" . $this->_get(_name) . "，年龄：" . $this->_get(_age) . "，工资：" . $this->_get(_salary) ;
	}
}
//抽象类 定义了姓名 年龄 以及必须提供自己的信息这个功能
//实例化一个学生后 学生提供学生的信息  实例化一个工人后 工人提供工人的信息  实现多态
$stu = new Student("张三", 20, 88.5);
echo $stu->getInfo()."<br/>";	 
$work = new Work("李四", 30, 10000.6);
echo $work->getInfo(); */


//实现接口  实现多态
/* interface Usb{
	function start();
	function end();
}

class Flash implements Usb{	
	public function start(){
		echo "U盘开始工作";
	}
	public function end(){
		echo "U盘结束工作";
	}
}

class PrintM implements Usb{
	public function start(){
		echo "打印机开始工作";
	}
	public function end(){
		echo "打印机结束工作";
	}
}

class Computer{
	public function run($_device){	//传入设备对象
		$_device->start();
		echo "<br/>USB设备运行中<br/>";
		$_device->end();
	}	
}
//传入不同的设备对象  就有不同的运行结果  实现多态
$com = new Computer();
$com->run(new Flash());		 
echo "<br/><br/>";
$com->run(new PrintM()); */	 


//__autoload  魔术方法
/* function __autoload($_className){
	require strtolower($_className).".class.php";;
	echo $_className;
}
//只要被new 就会自动执行__autoload方法  此时$_className自动变成Autoload 所以就引用了autoload.class.php文件
$al = new Autoload(); */


//__call()  魔术方法
/* class Person{
	private function __call($_methodName, $_argList){	//必须有两个参数 分别是方法名 参数数组
		echo "方法名：" . $_methodName . "<br/>";
		print_r($_argList);
	}
}
$per = new Person();
//因为定义了__call魔术方法  Person类中没有定义go方法也不会报错 屏蔽了错误
$per->go("AA", "BB", "CC");	 */


//__toString() 魔术方法
/* class Person{
	private function __toString(){
		return "aaaa";
	} 
}
$per = new Person();
echo $per;		//如果定义了__toString()方法  只要执行打印  就会自动执行__toString()方法  不需要调用 */


//__clone() 魔术方法
/* class Person{
	public $_name = "张三";
	public function __clone(){
		echo "克隆进行中<br/>";
	}
}
$per1 = new Person();
$per2 = clone $per1;			//只要使用clone就会自动执行__clone()方法;
echo $per2->_name . "<br/>";	//张三
$per2->_name = "李四";
echo $per2->_name . "<br/>";	//李四
echo $per1->_name . "<br/>";	//还是张三  所以被克隆的对象$per2与$per1是独立的  指向不同的堆内存空间 */


//工具方法  查看类信息
/* class Computer{
 	public function _run(){

	}
	private function _go(){

	}
	public $_name = "联想";
	private $_mode = "i7";
}

class NoteComputer extends Computer{

}

interface Person{

}

$computer1 = new Computer();
$noteComputer1 = new NoteComputer();
echo class_exists("Computer");   		 //1 检测这个类是否存在 存在为ture
echo interface_exists("Person"); 		 //1 检测这个接口是否存在 存在为ture
echo method_exists($computer1, _go);     //1 查看对象 是否有某个方法
echo get_class($computer1);      		 //Computer 获取某个对象的类名
echo get_parent_class("NoteComputer");   //Computer 获取某个对象父类的类名
print_r(get_class_methods("Computer"));  //Array ( [0] => _run ) 获取公共方法
print_r(get_class_vars("Computer"));     //Array ( [_name] => 联想 ) 获取公共字段
echo is_a($noteComputer1, "Computer");   //判断对象 是否属于某个类名的类或子类
echo is_subclass_of($noteComputer1, "Computer"); //判断对象 是否属于某个类名的子类  */


//反射  查看类信息
/* class Computer{
	public function _run(){

	}
	public static function _aa(){

	}
	private function _go(){

	}
	public $_name = "联想";
	public static $_cpu;
	private $_mode = "i7";
	const PI = 3.14;
}

Reflection::export(new ReflectionClass("Computer"));   //反射  查看自定义类的所有信息
echo "<br/><br/>";
Reflection::export(new ReflectionClass("DateTime"));   //反射  查看系统类 的所有信息
echo "<br/><br/>";

$rc = new ReflectionClass("DateTime");		
echo $rc->getName()."<br/>";		//查看系统类DateTime的名称
print_r($rc->getConstants());		//查看系统类DateTime的常量 */


?>