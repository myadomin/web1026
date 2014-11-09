<?php
//正则表达式 尽量用单引号 双引号会解析/等字符

echo preg_match('/PHP/','PHP').'\n';    	//匹配 返回1
echo preg_match('/PHP/','pHP').'<br/>';   //不匹配 返回0 区分大小写的
	
// $mode = '/php/';
// $string = 'xxxphpxxxxx';      			//也是匹配 只要字符串有连在一起的php三个字母 都能匹配 区分大小写
// $mode = '/ph+p/';                   //包含1个或多个h
// $string = 'xxxphhhhpxxx';           //匹配
// $mode = '/ph*p/';                   //包含0个或多个h
// $string = 'xxxppxxx';            	  //匹配
// $mode = '/ph?p/';                   //包含0个或一个h
// $string = 'xxxphpxxx';              //匹配
// $mode = '/p..p/';                  	//一个点对于一个任意的字符 必须一一对应 不能多一个或少一个
// $string = 'xxxpaixpxxx';            //匹配
// $mode = '/p.*p/';                 	//包括0个或多个任意的字符
// $string = 'xxxpa阿斯蒂芬ixpxxx';    //匹配pp之间 0个或多个任意字符都可以
// $mode = '/ph{3,7}p/';               //包含3-7个h
// $string = 'xxxphhhhpxxx';           //匹配 4个h
// $mode = '/ph{3,}p/';               	//包含3个以上的h
// $string = 'xxxphhhhhhhhhhhpxxx';    //匹配 是3个以上的h
// $mode = '/php$/';                  	//从尾部匹配php三个字母
// $string = 'xsfs阿多xxphp';     	  	//匹配 是最尾部匹配的php
// $mode = '/^php/';                 	//从头部匹配php三个字母
// $string = 'php啊3df';      				  //匹配 是最尾部匹配的php
// $mode = '/^php$/';                 	//从头部匹配php并且从尾部也匹配php三个字母
// $string = 'php';     							  //匹配 这就是相等了
// $mode = '/php|asp/';             	  //匹配php或者asp都算匹配了
// $string = 'asp';      	   			    //匹配 这就相当于相等了

// $mode = '/[a-z]/';             	    //匹配默认从前往后匹配(相当于前面加了^) 一旦匹配到一个a-z的小写字母就算匹配了
// $string = 'p2sdfsdfer';     	      //匹配 第一个开始匹配的就是p p是小写字母 所以算匹配了 后面就不再判断匹配了  
// $mode = '/[a-z]$/';             	  //这个是从后面开始匹配 后面第一个是r 就算匹配成功了 后面不再判断匹配了 
// $string = '2sdfsdfer';     	    		//匹配  如果这里不用$ 默认就从前开始匹配 第一个是2那就不匹配了
// $mode = '/^[a-z]|[a-z]$/';          //从前面从后面第一次匹配的都是字母
// $string = '1aaa';     	            //匹配 因为从后面第一次匹配到的是字母  aaa1也匹配 1aaa1就不匹配了
// $mode = '/[a-zA-Z0-9_]/';           //从头开始匹配 只要第一个准备匹配的是小写大写字母 0-9以及_都可以
// $string = '1aaa';     	            //匹配 因为从后面第一次匹配到的是字母  aaa1也匹配 1aaa1就不匹配了
// $mode = '/[^a-e]/';       //只要第一个准备匹配的不是a-e的字母就行 写进中括号里面的^代表非
// $string = '1aaa';	
// $mode = '/\w/';           //匹配所有 小写大写字母0-9 
// $string = 'ADFaaa';	
// $mode = '/\W/';           //匹配所有 非小写大写字母0-9 
// $string = '￥ADFaaa';	
// $mode = '/\d/';           //匹配所有 数字字符
// $string = '3aaa';	
// $mode = '/\d/';           //匹配所有 非数字字符
// $string = '啊3aaa';	
// $mode = '/php\b/';        //\b前面的p是单词边界 也就是是文本最后 或者后面是空格
// $string = 'php a';	      //匹配 后面是空格
// $mode = '/ph\+p/';        //\+ 把+功能去掉 他就是字符+
// $string = 'ph+p';	        //匹配  
// $mode = '/php/i';         //i 不区分大小写
// $string = 'PHP';	        //匹配 
// $mode = '/php/i';         //i 不区分大小写
// $string = 'PHP';	        //匹配  
$mode = '/ph p/x';        //x 忽略规则中的空格
$string = 'php';	        //匹配 如果没有x 那就必须 ph p才能匹配了  
if(preg_match($mode,$string)){
	echo '匹配了';
}else{
	echo '不匹配';
}
echo '<br/>';
		
//preg_grep
$language = array('php','asp','jsp','ruby','python');
$newarray = preg_grep('/p$/',$language);   //第一个参数是规则 第二个参数是被放入的数组 函数最终返回的是一个新数组
print_r($newarray);    //Array ( [0] => php [1] => asp [2] => jsp ) 
echo '<br/>';
$newarray2 = preg_grep('/^p/',$language);  //找出$language数组中开头是p的数组元素 返回新数组
print_r($newarray2);     //Array ( [0] => php [4] => python ) 
echo '<br/>';
	
//验证电子邮件  //注意一定要前面加^ 后面加$ 否则之后判断匹配$string的第一个
//$mode = '/(用户名)@(网址).(域名)/'; 
//用户名可以是所有的大小写字母及数字 以及_ . 以及只能2-255位 所以是([a-zA-Z0-9_\.]{2,255})
//网址可以是所有的大小写字母及数组 以及- 以及只能1-255位 所以是([a-zA-Z0-9\-]{1,255})
//域名部分可以是所有的小写字母 以及2-4位 所以是 ([a-z]{2,4})
//$mode = '/^([a-zA-z0-9_\.]{2,255})@([a-zA-Z0-9\-]{1,255}).([a-z]{2,4})$/';  //将[a-zA-Z0-9_]用[\w]代替
$mode = '/^([\w\.]{2,255})@([\w\-]{1,255}).([a-z]{2,4})$/';            //注意一定要前面加^ 后面加$ 否则之后判断匹配$string的第一个
$string = 'aA4do.m_in@1Aa6-3.com';              //符合规则   
if(preg_match($mode,$string)){
	echo '电子邮件合法';
}else{
	echo '电子邮件不合法';
}
echo '<br/>';

preg_match_all('/php[1-6]/','php5dsphp6asfsphp7',$out);
print_r($out);   // Array ( [0] => php5 [1] => php6 ) ) 
echo '<br/>';
	
echo preg_replace('/php[1-6]/','python','this is a php5,this is a php6');
//this is a python,this is a python 将符合/php[1-6]/规则的字符串替换成python
echo '<br/>';

//解决贪婪问题
//$mode = '/([b])(.*)([/b])/';    		 //先分组 分三组 中间一组是任意字符. 0个或多个*  
//$mode = '/(\[b\])(.*)(\[\/b\])/';    //然后[ ] / 全部要转义 所以都加上\
$mode = '/(\[b\])(.*)(\[\/b\])/U';     //这样的规则 会匹配第一个[b] 一直到最后一个[/b] 所以要禁止贪婪 加上U
$replace = '<strong>\2</strong>';      //两个标签之间 可以填充任何符合 \2的规则 也就是规则中的中间一组的规则
$string = 'this is a [b]php5[/b],this is a [b]php6[/b]';
echo preg_replace($mode,$replace,$string);
echo '<br/>';
	
print_r(preg_split('/[\.@]/','adomin.aa@163.com'));
//Array ( [0] => adomin [1] => aa [2] => 163 [3] => com ) 
//用.以及@切割字符串 记得外围一定要加[]S

?>