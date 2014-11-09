<?php

//模板类  生成缓存文件
class Templates{
	
	private $_vars = array();	//创建数组字段  用于预存注入的变量  因为是数组所以可以动态接收多个变量(个数随便)  
	private $_config = array();	//创建数组字段  用于预存XML配置  动态接收多个变量(个数随便)
	
	//构造方法  验证各个目录是否存在  预存好XML配置  以备后续Parser类使用
	public function __construct(){
		if( !is_dir(TPL_DIR) || !is_dir(TPL_C_DIR) || !is_dir(CACHE) ){
			exit('模板目录或编译目录或缓存目录不存在，请手工设置');
		}
		//把XML中的name value对 存储到$_config数组中  便于在parser.class.php中调用
		$_slf = simplexml_load_file('config/profile.xml');
		$_taglib = $_slf->taglib;	//是一个数组  数组元素是所有的tablib标签内容
		foreach($_taglib as $_tag){	//遍历上面的数组 赋值
			$this->_config["$_tag->name"] = $_tag->value;	//$_tag->name必须外围是双引号才能解析
		}
	}
	
	//assign()方法  预存好注入的变量   以备后续Parser类使用
	public function assign($_key, $_value){
		if( isset($_key) && !empty($_key) ){	//第一个参数模板变量必须设置且不为空
			$this->_vars[$_key] = $_value;		//设置下标为模板变量的数组元素值是传入的第二个参数
		}else{
			exit('请设置模板变量');
		}
	}
	
	//display()方法  通过.tpl模板文件生成编译文件  根据编译文件生成缓存文件  根据情况引用新缓存文件还是旧缓存文件
	public function display($_file){
		$_tplFile = TPL_DIR.$_file;		//C:\AppServ\www\phpStudy\ycku2_demo\5TPL/templates/index.tpl
		if(!file_exists($_tplFile)){	//判断上面路径的文件是否存在
			exit('模板文件不存在');
		}
		$_parFile = TPL_C_DIR.md5($_file).$_file.'.php';	//templates_c下的编译文件路径
		$_cacheFile = CACHE.md5($_file).$_file.'.html';		//缓存文件  静态文件
		
		//第一次刷新进入页面  才执行后面的载入新生成缓存文件  如果后续刷新运行相同文件  就直接载入已生成的缓冲文件  后续都不执行了以节约性能
		//缓冲器必须开启  编译文件 缓冲文件必须存在  模板文件没有修改过  编译文件没有修改过  4个条件同时具备 
		//这样如果没改动index.tpl 那从第二次刷新开始  就载入的是原先就生成好的缓冲文件  如果改动index.tpl后  那就去执行下面生成新的缓冲文件
		if( IS_CACHE && file_exists($_cacheFile) && file_exists($_parFile) && 
		(filemtime($_tplFile)<=filemtime($_parFile)) && (filemtime($_parFile)<=filemtime($_cacheFile)) ){
			echo '现在载入的是原先就生成好的缓冲文件<br/>';
			require $_cacheFile;
			return;
		}

		//如果编译文件已经有了  就不再重复生成编译文件以节约性能  但是如果模板.tpl文件修改了(模板文件修改时间大于编译文件) 那就要再次生成编译文件
		if( !file_exists($_parFile) || filemtime($_tplFile)>filemtime($_parFile) ){	
			//进入Parser类  生成编译文件  
			require ROOT_PATH.'/includes/Parser.class.php';
			$_parser = new Parser($_tplFile);
			$_parser->complie($_parFile); 
		}
		
		//经过上面的parser类编译后  index.php引入编译文件xxxx.tpl.php
		require $_parFile;	
		
		//如果开启了ob_start()缓存区的话  形成新的缓冲文件
		if(IS_CACHE){
			//因为上面已经require了编译文件  所以这里的ob_get_contents()就是获取编译文件 然后暂存到缓存文件$_cacheFile
			file_put_contents($_cacheFile, ob_get_contents());
			//再清除缓存区  就是去掉上面require的编译文件
			ob_end_clean();
			//然后require已经暂存好的缓冲文件$_cacheFile
			require $_cacheFile;
		}		
	}		
}

?>