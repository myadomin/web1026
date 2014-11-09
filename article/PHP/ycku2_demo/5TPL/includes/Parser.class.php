<?php

//模板解析类  从Templates类中接收到$_tplFile模板文件  经过一系列的解析后生成$_parFile编译文件 然后回到display()引用$_parFile编译文件
class Parser{
	
	private $_tpl;
	
	//构造方法  获取模板文件里的内容
	public function __construct($_tplFile){
		if( !($this->_tpl = file_get_contents($_tplFile)) ){
			exit('模板文件读取错误');
		}
	}
	
	//解析普通变量
	private function parVar(){
		$_pattern = '/\{\$([\w]+)\}/';	//{$xxx} xxx是一个或多个的字母数字下划线
		if( preg_match($_pattern, $this->_tpl) ){	//在模板文件中如果查找到有匹配{$xxx}
			//将模板文件$this->_tpl中的{$xxx}替换成<?php echo $this->_vars[xxx] ?\> 其中xxx在正则中()是一个分组  下面用$1代替他
			$this->_tpl = preg_replace($_pattern, "<?php echo \$this->_vars['$1'] ?>", $this->_tpl);
		}
	}
	
	//解析if语句
	private function parIf(){
		$_pattern1 = '/\{if\s+\$([\w]+)\}/';	//{if $xx} 空格一个或多个 xx一个或多个字母数字下划线
		if( preg_match($_pattern1, $this->_tpl) ){
			//将{if $xx} 替换成  <?php if($this->_vars['a']){ ?\> 'a'是需要注入的变量
			$this->_tpl = preg_replace($_pattern1, "<?php if(\$this->_vars['$1']){ ?>", $this->_tpl);
		}
		$_pattern2 = '/\{\/if\}/';				//{/if}
		if( preg_match($_pattern2, $this->_tpl) ){
			//<?php } ?\>
			$this->_tpl = preg_replace($_pattern2, "<?php } ?>", $this->_tpl);
		}
		$_pattern3 = '/\{else\}/';				//{else}
		if( preg_match($_pattern3, $this->_tpl) ){
			//<?php }else{ ?\>
			$this->_tpl = preg_replace($_pattern3, "<?php }else{ ?>", $this->_tpl);
		}
	}
	
	//解析注释
	private function parCommon(){
		$_pattern = '/{#}(.*){#}/';		//{#}xxx{#} xxx0个或多个任意字符
		if( preg_match($_pattern, $this->_tpl) ){
			// /*xxx*/
			$this->_tpl = preg_replace($_pattern, "<?php /*$1*/ ?>", $this->_tpl);
		}
	} 
	
	//解析foreach语句
	private function parForEach(){
		$_patternStart = '/\{foreach\s+\$([\w]+)\(([\w]+),([\w]+)\)\}/';	//{foreach $array(key,value)}
		$_patternEnd = '/\{\/foreach\}/'; 		//{/foreach}
		$_patternContent = '/\{@([\w]+)\}/';	//{@key}
		if( preg_match($_patternStart, $this->_tpl) ){
			if( preg_match($_patternEnd, $this->_tpl) ){
				//<?php foreach($this->_vars['array'] as $key=>$value){ ?\>
				$this->_tpl = preg_replace($_patternStart, "<?php foreach(\$this->_vars['$1'] as \$$2=>\$$3){ ?>", $this->_tpl);
				//<?php } ?\>
				$this->_tpl = preg_replace($_patternEnd, "<?php } ?>", $this->_tpl);
				if( preg_match($_patternContent, $this->_tpl) ){
					//<?php echo $key ?\>  <?php echo $value ?\>
					$this->_tpl = preg_replace($_patternContent, "<?php echo \$$1 ?>", $this->_tpl);
				}
			}else{
				echo '错误：foreach语句没有结尾标签';
			}
		}
	}
	
	//解析include语句
	private function parInclude(){
		$_pattern = '/\{include\s+\"([\w\.\-]+)\"\}/';	//{include "file"}
		if( preg_match($_pattern, $this->_tpl) ){
			//<?php include $this->_vars['file']; ?\> forInclude.php注入'file'
			$this->_tpl = preg_replace($_pattern, "<?php include \$this->_vars['$1']; ?>", $this->_tpl);
		}
	}
	
	//解析系统变量
	private function parConfig(){
		$_pattern = '/<!--\{([\w\.\-]+)\}-->/';		//<!--{xx}-->
		if( preg_match($_pattern, $this->_tpl) ){
			//<?php echo $this->_config['xx'] ?\> xx已经存储在_config数组中
			$this->_tpl = preg_replace($_pattern, "<?php echo \$this->_config['$1'] ?>", $this->_tpl);
		}
	}
	
	//解析模板文件
	public function complie($_parFile){
		//解析模板内容  为下面的编译文件生成准备
		$this->parVar();
		$this->parIf();
		$this->parCommon();
		$this->parForEach();
		$this->parInclude();
		$this->parConfig();
		//生成编译文件xxx.tpl.php
		if( !(file_put_contents($_parFile, $this->_tpl)) ){
			exit('编译文件生成错误');
		}
	}		
}

?>