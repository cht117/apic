<?php
foreach(array(
	'FILE_SEND_IP' => '61.135.210.63',
	'FILE_SEND_PORT' => 7010,
	'FILE_SEND_VERIFICATION' => '333314  ',
	'FILE_SEND_PATH' => '/mnt/pic4/uploadfile/',
	'FILE_SEND_BIGFILE_PREFIX' => '410',
	'FILE_SEND_SMALLFILE_PREFIX' => '481',
	'FILE_SEND_URL_PREFIX' => 'http://hemsfile.zhongso.com/',
	'FILE_UPLOAD_TEMP' => './tmp/',
) as $key=>$value) define($key, $value);

function sendFile($strFilePath, $strType, $strMd5, $typeid=''){
	set_time_limit(0);
	
	$strFill = chr(0);

	if(!is_string($strType) || !($strType == 'big' || $strType == 'small'))
		return -1;
	
	if(!is_string($strFilePath) || strlen(trim($strFilePath)) == 0)
		return -2;
	
	$strFileExtName = pathinfo($strFilePath);
	//获取文件后缀转换成小写
	$strFileExtName = strtolower($strFileExtName['extension']);
	if(!is_string($strMd5) || strlen(trim($strMd5)) == 32){
		$strMd5 = md5_file($strFilePath);
	}
	#先根据上传方的文件生成一个16位的十六进制的文件MD5（需要保证MD5的唯一性，否则会覆盖）
	$strMd5 = substr($strMd5, 8, 16);

	$strSendCount = '1       ';
	
	$socket = socket_create(AF_INET, SOCK_STREAM, 0);

	if($socket === false) return -3;
	
//	socket_set_block ($socket);

	stream_set_timeout($socket, 5);
	
	if(!socket_connect(
		$socket, constant('FILE_SEND_IP'), constant('FILE_SEND_PORT'))
	){
		$errorcode = socket_last_error();
		$errormsg = socket_strerror($errorcode);
		var_dump($errormsg); 
		return -4;
	}

	if(!socket_write(
		$socket, constant('FILE_SEND_VERIFICATION'), 8)
	) return -5;

	
	if(!socket_write($socket, $strSendCount, 8)){
		return -6;
	}

	$intSize = filesize($strFilePath);

	$strSize = (string)$intSize;
	for($i = strlen($strSize); $i<8; $i++) $strSize .= $strFill;
	
	if(!socket_write($socket, $strSize, 8)){
		return -7;
	}
	
	$strFileName  = '';
	#在文件MD5前增加3位（前期使用“410”），变成19位的文件ID。
	$strFileName .= ($strType == 'big')?
	constant('FILE_SEND_BIGFILE_PREFIX'):constant('FILE_SEND_SMALLFILE_PREFIX');

	$strFileName .= $strMd5;
    #在文件ID前增加2级路径：文件MD5的第1,2位为一级目录，第3,4位为二级目录
	$strPath  = constant('FILE_SEND_PATH');
	$strPath .= substr($strMd5, 0, 2).'/';
	$strPath .= substr($strMd5, 2, 2).'/';
	$strPath .= "$strFileName.$strFileExtName";
	$strFileName=$strPath;
	for($i = strlen($strPath); $i<100; $i++) $strPath.= $strFill;

	if(!socket_write($socket, $strPath, 100)){
		return -8;
	}
	
	$objFile = fopen($strFilePath, 'r');

	$strFile = fread($objFile, $intSize);
	// var_dump($socket,$strFile,$intSize);
	// var_dump(socket_write($socket, $strFile, $intSize));
	// var_dump(socket_write($socket, $strFile, $intSize));exit;
	if(!socket_write($socket, $strFile, $intSize)){
		return -9;
	}
	
	if(
		intval(socket_read($socket, 8)) !=
		intval(constant('FILE_SEND_VERIFICATION')) ||
		intval(socket_read($socket, 8)) != 1
	) {
		return -10;
	}
	fclose($objFile);
	socket_close($socket);
	$strFileName=str_replace(constant('FILE_SEND_PATH'), '', $strFileName);
	#最后在前面加上路径，在后面加上后缀。
	return constant('FILE_SEND_URL_PREFIX').$strFileName;
}

/*$strImageUrl = '';

if(!empty($_FILES)){
	if(is_array($_FILES['file']) && $_FILES['file']['error'] == 0 && $_FILES['file']['type'] == 'image/jpeg'){
		$strTempImageFilePath = constant('IMAGE_UPLOAD_TEMP').'temp_'.md5(rand()).'.jpg';
		move_uploaded_file($_FILES['file']['tmp_name'], $strTempImageFilePath); 
		$strImageUrl = sendImage($strTempImageFilePath, 'big', md5_file($strTempImageFilePath));
		unlink($strTempImageFilePath);
	}
}*/
?>
