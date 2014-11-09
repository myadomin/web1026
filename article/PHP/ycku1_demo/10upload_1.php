<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<p>针对 10upload.php</p>
<form enctype="multipart/form-data" action="10upload.php" method="post">
　	<input type="hidden" name="MAX_FILE_SIZE" value="1000000" />
　	上传文件: <input type="file" name="userfile"/>  
	<input type="submit" value="上传" />   <!--点击上传后 就跳到10upload.php页面 并让超级全局变量$_FILES数组有值了 -->
</form>
