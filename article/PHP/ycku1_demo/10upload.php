<?php
header('Content-Type:text/html; charset=utf-8');
//上传文件

print_r($_FILES);  //超级全局变量 空值
// 如果点击了10upload_1.php的上传 就会跳转到这个页面 然后$_FILES数组就有值了
// Array ( [userfile] => Array ( [name] => mm3.jpg [type] => image/jpeg [tmp_name] => C:\Windows\Temp\phpD7FB.tmp [error] => 0 [size] => 4282 ) )
echo "<br/>";
echo $_FILES['userfile']['name']."\n";
echo $_FILES['userfile']['type']."\n";
echo $_FILES['userfile']['tmp_name']."\n";
echo $_FILES['userfile']['error']."\n";
echo $_FILES['userfile']['size']."<BR/>"; //mm3.jpg  image/jpeg  C:\Windows\Temp\php1F3C.tmp  0  4282 



//接收来之10upload_1的图片上传  在10upload_2页面上显示出来
//如果上传错误 提示相应信息 然后跳出程序
if ($_FILES['userfile']['error'] > 0) {
	switch ($_FILES['userfile']['error']) {
		case 1: echo "<script>alert('上传文件超过约定值1');history.back();</script>";
		break;
		case 2: echo "<script>alert('上传文件超过约定值2');history.back();</script>";
		break;
		case 3: echo "<script>alert('部分被上传');history.back();</script>";
		break;
		case 4: echo "<script>alert('没有任何文件被上传');history.back();</script>";
		break;
	}
	exit;
}

//只用于传jpg png gif图片 传其他类型的东西提示后 跳出程序
switch ($_FILES['userfile']['type']) {
	case 'image/jpeg' :  //火狐
		break;
	case 'image/pjpeg' : //IE
		break;
	case 'image/gif' :
		break;
	case 'image/png' : //火狐
		break;
	case 'image/x-png' : //IE
		break;
	default: echo "<script>alert('本站只允许jpg、gif、png图片！');history.back();</script>";
	exit;
}

//确定是否上传到临时文件夹 再确定是否上传到目标文件夹
//如果全部通过 程序没有跳出 那就上传成功了 把文件从临时路径移动到了目标路径uploads/文件原名称
//这样每次去10upload_1点击一次上传 就会执行一次这个函数 就上传了一张图片到uploads文件夹里了
if(is_uploaded_file($_FILES['userfile']['tmp_name'])){ //文件上传到了临时文件夹了
	if(!move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/'.$_FILES['userfile']['name'])){
		echo "<script>alert('文件从临时文件夹移动到目标文件夹不成功,可能目标文件夹不存在');history.back();</script>";
		exit();   //跳出
	}	
}else{
	echo "<script>alert('文件还没上传到了临时文件夹路径');history.back();</script>";
	exit();  //跳出
}

//上传成功后 就跳转到10upload_2.php页面  并且?url=xxxx 便于10upload_2.php页面用get接收url的值 从而得到上传图片的文件名
echo "<script>alert('文件上传成功');location.href='10upload_2.php?url=".$_FILES['userfile']['name']."';</script>";



?>