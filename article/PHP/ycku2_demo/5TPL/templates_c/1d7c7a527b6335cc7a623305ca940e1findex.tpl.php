<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $this->_config['webname'] ?></title>
<link rel="stylesheet" type="text/css" href="demo.css"/>
<script type="text/javascript" src="demo.js"></script>
</head>
<body>

当前页数是：<?php echo $this->_config['pagesize'] ?><br/>

<?php echo $this->_vars['name'] ?> <?php echo $this->_vars['content'] ?><br/>

<?php if($this->_vars['a']){ ?> 
	<div>我是一号界面</div>
<?php }else{ ?>
	<div>我是二号界面</div>
<?php } ?>

<?php /*我是php的注释*/ ?>

<?php foreach($this->_vars['array'] as $key=>$value){ ?>
	<?php echo $key ?>...<?php echo $value ?><br/> 
<?php } ?>

<?php include $this->_vars['file']; ?> 

</body> 
</html>    
      
     
     
     