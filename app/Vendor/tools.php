<?php
define('TOOLREQUIRE','1');
//错误提示
function showmsg($msg,$tzurl=-1){
	if($tzurl==-1)$tzurl = 'history.go(-1);';
	$str = "<script>alert('".$msg."');if(window.parent) window.parent.location.href='".$tzurl."'; else window.location.href='".$tzurl."';</script>";
	echo $str;
}

//自动创建目录
function make_dir($folder)
{
    $reval = false;

    if (!file_exists($folder))
    {
        /* 如果目录不存在则尝试创建该目�? */
        @umask(0);

        /* 将目录路径拆分成数组 */
        preg_match_all('/([^\/]*)\/?/i', $folder, $atmp);

        /* 如果第一个字符为/则当作物理路径处�? */
        $base = ($atmp[0][0] == '/') ? '/' : '';

        /* 遍历包含路径信息的数�? */
        foreach ($atmp[1] AS $val)
        {
            if ('' != $val)
            {
                $base .= $val;

                if ('..' == $val || '.' == $val)
                {
                    /* 如果目录�?.或�??..则直接补/继续下一个循�? */
                    $base .= '/';

                    continue;
                }
            }
            else
            {
                continue;
            }

            $base .= '/';

            if (!file_exists($base))
            {
                /* 尝试创建目录，如果创建失败则继续循环 */
                if (@mkdir(rtrim($base, '/'), 0777))
                {
                    @chmod($base, 0777);
                    $reval = true;
                }
            }
        }
    }
    else
    {
        /* 路径已经存在。返回该路径是不是一个目�? */
        $reval = is_dir($folder);
    }

    clearstatcache();

    return $reval;
}

function is_utf8($string) {
	return preg_match('%^(?:[\x09\x0A\x0D\x20-\x7E]| [\xC2-\xDF][\x80-\xBF]
         |     \xE0[\xA0-\xBF][\x80-\xBF] 
         | [\xE1-\xEC\xEE\xEF][\x80-\xBF]{2}
         |     \xED[\x80-\x9F][\x80-\xBF] 
         |     \xF0[\x90-\xBF][\x80-\xBF]{2}
         | [\xF1-\xF3][\x80-\xBF]{3}
         |     \xF4[\x80-\x8F][\x80-\xBF]{2}
         )*$%xs', $string);
}
	//
function read_file($filename,$method="rb"){
	if($handle=@fopen($filename,$method)){
		@flock($handle,LOCK_SH);
		$filedata=@fread($handle,@filesize($filename));
		@fclose($handle);
	}
	return $filedata;
}
	//写目�?
function func_dir_create($newdir , $prefix = ""){
	$dirary=explode("/",$newdir);
	$real_dir=$prefix;
	foreach ($dirary as $d){
		$real_dir=$real_dir.$d."/";
		if (!is_dir($real_dir)) {
	        @mkdir($real_dir);
	        @chmod($real_dir, 0777);
		}
	}
	return $real_dir;
}
	 //写文
function write_file($filename,$data,$method="rb+",$iflock=1){
	@touch($filename);
	$handle=@fopen($filename,$method);
	if($iflock){
		@flock($handle,LOCK_EX);
	}
	@fputs($handle,$data);
	if($method=="rb+") @ftruncate($handle,strlen($data));
	@fclose($handle);
	@chmod($filename,0777);	
	if( is_writable($filename) ){
		return 1;
	}else{
		return 0;
	}
}
	
	//转换cakephp数组键�??
function cakeRstoRs($rs,$tablename){
	$result = array();
	foreach ($rs as $key=>$value){
		$result[$key] = $value[$tablename];
	}
	return $result;
} 
   //数组排序
  function sysSortArray($ArrayData,$KeyName1,$SortOrder1 = "SORT_ASC",$SortType1 = "SORT_REGULAR") {     if(!is_array($ArrayData))   
    {         return $ArrayData;     
    }      
     $ArgCount = func_num_args();     
     for($I = 1;$I < $ArgCount;$I ++){
     	$Arg = func_get_arg($I);
        if(!eregi("SORT",$Arg)){
        	$KeyNameList[] = $Arg;
        	$SortRule[]    = '$'.$Arg;
         }else{
         	$SortRule[]    = $Arg;      
            }
          } 
        foreach($ArrayData AS $Key => $Info){
        	foreach($KeyNameList AS $KeyName)
        	{ 
        		            ${$KeyName}[$Key] = $Info[$KeyName];
        	         }
             }  
                  $EvalString = 'array_multisort('.join(",",$SortRule).',$ArrayData);';    
                   eval ($EvalString);     
                   return $ArrayData; 
  }
   
  //分页Html拼装
function makeMulitpage($mpurl,$page,$total,$pernum){
	        $maxpage = ceil($total/$pernum);
		    $page = $page>$maxpage?$maxpage:$page;
		    $page=$page>1?$page:1;
		    $multipage = "";
		   if($maxpage>1){
		   	
				$offset = 2;
				if($maxpage<=5){
					$from = 1;
					$to = $maxpage;
				}else{
					$from = $page - $offset;
					$to = $from + 4;
					if($from < 1) {
						$from = 1;
						$to = 5;
					}
					if($to>$maxpage){
						$to=$maxpage;
						$from=$maxpage-4;
					}
				}
				$multipage.= $page==1?"":"<a href='{$mpurl}&page=1' class='margin5'><img border='0' src='http://pigimg.zhongso.com/space/gallery252/gmwzgwy/1727260-left.jpg' /> 首页</a>&nbsp;";
				$multipage.= $page==1?"":("<a href='{$mpurl}&page=".($page-1)."' class='margin5'>上一页</a>&nbsp;");
				for($i = $from; $i <= $to; $i++) {
					$multipage .= ($i == $page) ? "<span style='color:red;'>$i</span>&nbsp;" :"<a href='{$mpurl}&page={$i}'><span class='pagedown'>$i</span></a>&nbsp;";
				}
				$multipage.= $page==$maxpage?"":("<a href='{$mpurl}&page=".($page+1)."' class='margin5'>下一页</a>&nbsp;");
				$multipage.= $page==$maxpage?"":"<a href='{$mpurl}&page={$maxpage}' class='margin5'>尾页 <img src='http://pigimg.zhongso.com/space/gallery252/gmwzgwy/1727261-right.jpg?1303700057'  border='0' /></a>&nbsp;";
				$multipage.= "<span class='margin5'>共{$total}结果</span>";
			}else{
				
				$multipage = "<span class='margin5'>共{$total}结果</span>";
			}
			
			return $multipage;
}
function fenye($mpurl,$page,$total,$pernum){
	        $maxpage = ceil($total/$pernum);
		    $page = $page>$maxpage?$maxpage:$page;
		    $page=$page>1?$page:1;
		    $multipage = "";
		   if($maxpage>1){
		   	
				$offset = 2;
				if($maxpage<=5){
					$from = 1;
					$to = $maxpage;
				}else{
					$from = $page - $offset;
					$to = $from + 4;
					if($from < 1) {
						$from = 1;
						$to = 5;
					}
					if($to>$maxpage){
						$to=$maxpage;
						$from=$maxpage-4;
					}
				}
				$multipage.= $page==1?"<li><div class='nofront'></div></li>":"<li><a href='{$mpurl}/page:1' class='front03'></a></li>&nbsp;";
				$multipage.= $page==1?"<li><div class='nofront02'></div></li>":("<li><a href='{$mpurl}/page:".($page-1)."' class='front04'></a></li>&nbsp;");
				$multipage.="<li><div class='jgbg'></div></li>";
				$multipage.="<li><div class='mte6'>第<select onchange='tz(\"{$mpurl}/page:\"+this.options[this.selectedIndex].value)'>";
				for($i = $from; $i <= $to; $i++) {
					$multipage .= ($i == $page)?"<option value='$i' onclick='window.location.href=\"{$mpurl}/page:{$i}\"' selected>$i</option>&nbsp;" :"<option value='$i' >$i</option>&nbsp;";
				}
				$multipage.="</select>页，共<span>$maxpage</span>页</div></li>";
				$multipage.="<li><div class='jgbg'></div></li>";
				$multipage.= $page==$maxpage?"<li><div class='nonext'></div></li>":("<li><a href='{$mpurl}/page:".($page+1)."' class='next03'></a></li>&nbsp;");
				$multipage.= $page==$maxpage?"<li><div class='nonext02'></div></li>":"<li><a href='{$mpurl}/page:{$maxpage}' class='next04'></a></li>&nbsp;";
			}else{
				$multipage.= "<li><div class='nofront'></div></li>";
				$multipage.= "<li><div class='nofront02'></div></li>";
				$multipage.="<li><div class='jgbg'></div></li>";
				$multipage.="<li><div class='mte6'>第<select>";
				$multipage .=  "<option value='1' selected>1</option>&nbsp;";
				$multipage.="</select>页，共<span>1</span>页</div></li>";
				$multipage.="<li><div class='jgbg'></div></li>";
				$multipage.= "<li><div class='nonext'></div></li>";
				$multipage.= "<li><div class='nonext02'></div></li>";
			}
			return $multipage;
}
//两数组去
function fixdouble($arr1,$arr2){
	 $myarray=array_merge($arr1,$arr2);
     $myarray=array_unique($myarray);
     $rstr = '';
     foreach ($myarray as $key=>$value){
     	$rstr.=$value.'\r\n';
     }
     return $rstr;
}

//分析文件返回数组
function rexml($data){
	 $dataArr = explode("\r\n",$data);
	 array_pop($dataArr);
	 $rsArr = array();
	 foreach ($dataArr as $key=>$value){
	 	$valueArr = explode('###',$value);
        $rsArr[$key]['title'] = $valueArr[0];
        $rsArr[$key]['id'] = $valueArr[1];
        $rsArr[$key]['isget'] = $valueArr[2];
	 }
	 return $rsArr;
} 
//更新文件节点状
function updatedatastatus($dataRs,$keyword,$type){
	 $str = '';
	 foreach($dataRs as $key=>$value){
	 	if($value['title']==$keyword){
	      $str.=$value['title']."###".$value['id']."###".$type."\r\n";
	 	}else{
	 	  $str.=$value['title']."###".$value['id']."###".$value['isget']."\r\n";
	 	}	
	 }
	 return $str;
}

//获取分类名称数据
function getCateName($cateRs,$v){
	$v = explode("###",$v);
	$rstr = '';
	foreach ($cateRs as $key=>$value){
		foreach($v as $vid){
			if($vid==$value['pid'])$rstr.=$value['name'].",";
		}
	}
	return $rstr;
}

//获取分类名称
function getCateNameOne($cateRs,$cid){
	$rstr = '';
	foreach ($cateRs as $key=>$value){
		
			if($cid==$value['pid']){$rstr.=$value['name'];break;}
		
	}
	return $rstr;
}
//解析XML并返回
function makeinfolistformail($cids,$cateRs,$igId){
	    $cidsArr = explode("###",$cids);
    	$html = '';
    	$dom = new DOMDocument();
    	$moreurl = 'http://www.zhongsou.net/%E9%A4%90%E9%A5%AE%E8%A1%8C%E4%B8%9A/channel/13356016';
    	//if(is_utf8($igId))$igId = iconv('UTF-8','GBK',$igId);
    	foreach ($cidsArr as $key=>$value){
    		$catename = getCateNameOne($cateRs,$value);
    		if(!is_utf8($catename))$catename = iconv('GBK','UTF-8',$catename);
    		if(!is_utf8($igId))$igId = iconv('GBK','UTF-8',$igId);
    		$html .= '<div class="nTab"><div class="TabTitle">
            <ul id="myTab0">
            <li class="active">
              <div align="center">'.$catename.'</div>
              </li>
              </li>
            </ul>
          </div>
        <div class="TabContent">
          <div id="myTab0_Content0">
            <table width="99%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#E8E8E8" style="margin-bottom:3px">
              <tr>
                <td width="67%" align="center" valign="top" bgcolor="#F6F6F6"><strong>标题 </strong></td>
                  
                  <td width="19%" align="center" valign="top" bgcolor="#F6F6F6"><strong>时间 </strong></td>
                </tr>';
    		
    		//$catename = iconv('UTF-8','GBK',$catename);
    		
    		$url = "http://202.108.2.45/news/news_xmls.cgi?w=&b=1&st=5&cl=".$catename."&sl=".$igId;
    		$xml = @file_get_contents($url);
    		$xml = str_replace('GBK','utf-8',$xml);
    		$xml = iconv('gbk','UTF-8',$xml);
    		if(@$dom->loadXML(trim($xml))){
		   	 $results = $dom->getElementsByTagName('news');	 
		   	 if(count($results)>=0){
	         foreach ($results as $result){
			    $pubtime = $result->getElementsByTagName('pubtime');
			    $pubtime = $pubtime->item(0)->nodeValue;
			    //$pubtime = iconv('GBK','UTF-8',$pubtime);
			    $title = $result->getElementsByTagName('title');
			    $title = $title->item(0)->nodeValue;
			    //$title = iconv('GBK','UTF-8',$title);
			    $url = $result->getElementsByTagName('url');
			    $url = $url->item(0)->nodeValue;
			    //$url = iconv('GBK','UTF-8',$url);
			    $html .='<tr>
                <td bgcolor="#FFFFFF"><a href="'.$url.'" target="_blank">'.$title.'</a></td>              
                <td align="center" bgcolor="#FFFFFF">'.$pubtime.'</td>
                </tr>
                ';
	         }
		   	 }
	         $html.=' </table>
            <div align="right"><a href="'.$moreurl.'" target="_blank">更多&gt;&gt;</a></div>
          </div>
             </div>
        </div>';
	   }
    }
    
    return $html;
}


   function mymd5($string,$action="EN"){
    $secret_string = 'a*b#5*j,.^&;?.%#@!'; 

    if($string=="") return ""; 
    if($action=="EN") $md5code=substr(md5($string),8,10); 
    else{ 
        $md5code=substr($string,-10); 
        $string=substr($string,0,strlen($string)-10); 
    } 
    //$key = md5($md5code.$_SERVER["HTTP_USER_AGENT"].$secret_string);
	$key = md5($md5code.$secret_string); 
    $string = ($action=="EN"?$string:base64_decode($string)); 
    $len = strlen($key); 
    $code = ""; 
    for($i=0; $i<strlen($string); $i++){ 
        $k = $i%$len; 
        $code .= $string[$i]^$key[$k]; 
    } 
    $code = ($action == "DE" ? (substr(md5($code),8,10)==$md5code?$code:NULL) : base64_encode($code)."$md5code"); 
    return $code; 
}
function GetIP()
{
 if(!empty($_SERVER["HTTP_CLIENT_IP"]))
 $cip = $_SERVER["HTTP_CLIENT_IP"];
 else if(!empty($_SERVER["HTTP_X_FORWARDED_FOR"]))
 $cip = $_SERVER["HTTP_X_FORWARDED_FOR"];
 else if(!empty($_SERVER["REMOTE_ADDR"]))
 $cip = $_SERVER["REMOTE_ADDR"];
 else
 $cip = "unknown";
 return $cip;
 } 
 
 
 function cut_str($string, $sublen, $start = 0, $code = 'UTF-8')
{
    if($code == 'UTF-8')
    {
        $pa = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|\xe0[\xa0-\xbf][\x80-\xbf]|[\xe1-\xef][\x80-\xbf][\x80-\xbf]|\xf0[\x90-\xbf][\x80-\xbf][\x80-\xbf]|[\xf1-\xf7][\x80-\xbf][\x80-\xbf][\x80-\xbf]/";
        preg_match_all($pa, $string, $t_string);
 
        if(count($t_string[0]) - $start > $sublen) return join('', array_slice($t_string[0], $start, $sublen))."...";
        return join('', array_slice($t_string[0], $start, $sublen));
    }
    else
    {
        $start = $start*2;
        $sublen = $sublen*2;
        $strlen = strlen($string);
        $tmpstr = '';
 
        for($i=0; $i< $strlen; $i++)
        {
            if($i>=$start && $i< ($start+$sublen))
            {
                if(ord(substr($string, $i, 1))>129)
                {
                    $tmpstr.= substr($string, $i, 2);
                }
                else
                {
                    $tmpstr.= substr($string, $i, 1);
                }
            }
            if(ord(substr($string, $i, 1))>129) $i++;
        }
        if(strlen($tmpstr)< $strlen ) $tmpstr.= "...";
        return $tmpstr;
    }
}
//转义字符
function zhuanyi($arr)
{
	$newArr = array();
	$str='';

	if($arr)
	{
		foreach($arr as $k=>$val)
		{
			$newArr[$k]=addcslashes($val,"'");
		}
		//var_dump($newArr);exit;
		return $newArr;
	}
	return false;
}
/**
 * 将字符串替换成函数
 * 在list.ctp中使用，将‘#(.*)#’形式的字符串用$v数组中相应的键值进行替换
 */

function replace($str,$v,$isdanyin=''){
		preg_match_all("/#(.*)#/U",$str,$arr);
		$ss=$str;
		
		foreach($arr[1] as $keys=>$values){
			if($isdanyin)
			{
				$ss=str_replace("#$values#","$v[$values]",$ss);
			}else{
				$ss=str_replace("#$values#","'$v[$values]'",$ss);
			}
			
		}
		return $ss;	
	}
	
	/**
	 * 获取当前请求的url地址
	 */
	function curPageURL()
{
    $pageURL = 'http';

    if ($_SERVER["HTTPS"] == "on")
    {
        $pageURL .= "s";
    }
    $pageURL .= "://";

    if ($_SERVER["SERVER_PORT"] != "80")
    {
        $pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
    }
    else
    {
        $pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
    }
    return $pageURL;
}
	/*
	  * 二维数组按照某个值进行排序 (hd)
	 */
	function array_sort($arr, $keys, $type = 'asc') {
	    $keysvalue = $new_array = array();
	    foreach ($arr as $k => $v) {
	        $keysvalue[$k] = $v[$keys];
	    }
	    if ($type == 'asc') {
	        asort($keysvalue);
	    } else {
	        arsort($keysvalue);
	    }
	    reset($keysvalue);
	    foreach ($keysvalue as $k => $v) {
	        $new_array[$k] = $arr[$k];
	    }
	    return $new_array;
      }	
     function array_remove($array,$v){        // $array为操作的数组，$v为要删除的值
		foreach($array as $key=>$value){
			if($value == $v){       //删除值为$v的项
				unset($array[$key]);    //unset()函数做删除操作
			}
		}
		return $array;
	}
	/**
	 * 计算字符串长度 (hd)
	 */
	function getStringLength($str,$encode='utf-8'){
		    $jumpbit=strtolower($encode)=='gb2312'?2:3;//跳转位数
		    $strlen=strlen($str);//字符串长度
		    $pos=0;//位置
		    $charcount=0;//字符数量统计
		    for($pos=0;$pos<$strlen;){
		        if(ord(substr($str,$pos,1))>=0xa1){//0xa1（161）汉字编码开始
		            $pos+=$jumpbit;
		        }else{
		            ++$pos;
		        }
		        ++$charcount;
		    }
		    return $charcount;
		}
	/**
	 * 去除数组重复项(hd)
	 */
	function a_array_unique($array){//写的比较好  如果保留原来的键循环加key 不保留就不用
	   $out = array();
	  foreach ($array as $key=>$value) {
	       if (!in_array($value,$out)){
	           $out[] = $value;
	       }
	   }
	   return $out;
	} 
	//删除目录
	function del_dir($dir){
		if(!($mydir=@dir($dir))){
			return;
		}
		while ($file=$mydir->read()){
			if(is_dir("$dir$file") && $file!='.' && $file!='..'){ 
				@chmod("$dir$file", 0777);
				del_dir("$dir$file"); 
			}elseif (is_file("$dir/$file")){
				$file_time=@stat($file);	//读取文件的最后更新时间
				if(time()-$file_time>3600*24*14){
					@chmod("$dir/$file", 0777);
					@unlink("$dir/$file");
				}
			}
		}
		$mydir->close();
		@chmod($dir, 0777);
		@rmdir($dir);
	}
	//指定删除一个文件夹里的所有东西，类似于 rm *(hd)
	function deldir($dir) {
		 $dh=opendir($dir);
		 while ($file=readdir($dh)) {
		 	 if($file!="." && $file!="..") {
		 	 	$fullpath=$dir."/".$file;
		 	 	if(!is_dir($fullpath)) {
		 	 		 unlink($fullpath);
		 	 	}else {
		 	 		deldir($fullpath);
		 	 	}
		 	 }
		 }
		  closedir($dh);
		  if(rmdir($dir)) {
		  	 return true;
		  }else{
		  	 return false;
		  }
	}
	//自动将字节转换为 MB、KB  默认保留一位小数。
	function size2mb($size,$digits=1){
		$unit= array('','K','M','G','T','P');//单位数组，是必须1024进制依次的哦。
		$base= 1024;//对数的基数
		$i   = floor(log($size,$base));//字节数对1024取对数，值向下取整。
		return round($size/pow($base,$i),$digits).' '.$unit[$i] . 'B';
	}
	/**
  +----------------------------------------------------------
 * 功能：检测一个字符串是否是邮件地址格式
  +----------------------------------------------------------
 * @param string $value    待检测字符串
  +----------------------------------------------------------
 * @return boolean
  +----------------------------------------------------------
 */
function is_email($value) {
    return preg_match("/^[0-9a-zA-Z]+(?:[\_\.\-][a-z0-9\-]+)*@[a-zA-Z0-9]+(?:[-.][a-zA-Z0-9]+)*\.[a-zA-Z]+$/i", $value);
}
/**
 * 获取和设置配置参数 支持批量定义
 * @param string|array $name 配置变量
 * @param mixed $value 配置值
 * @param mixed $default 默认值
 * @return mixed
 */
function C($name=null, $value=null,$default=null) {
    static $_config = array();
    // 无参数时获取所有
    if (empty($name)) {
        return $_config;
    }
    // 优先执行设置获取或赋值
    if (is_string($name)) {
        if (!strpos($name, '.')) {
            $name = strtoupper($name);
            if (is_null($value))
                return isset($_config[$name]) ? $_config[$name] : $default;
            $_config[$name] = $value;
            return;
        }
        // 二维数组设置和获取支持
        $name = explode('.', $name);
        $name[0]   =  strtoupper($name[0]);
        if (is_null($value))
            return isset($_config[$name[0]][$name[1]]) ? $_config[$name[0]][$name[1]] : $default;
        $_config[$name[0]][$name[1]] = $value;
        return;
    }
    // 批量设置
    if (is_array($name)){
        $_config = array_merge($_config, array_change_key_case($name,CASE_UPPER));
        return;
    }
    return null; // 避免非法参数
}
	/**
	  +----------------------------------------------------------
	 * 加密密码
	  +----------------------------------------------------------
	 * @param string    $data   待加密字符串
	  +----------------------------------------------------------
	 * @return string 返回加密后的字符串
	 */
	function encrypt($data) {
	    return md5(C("AUTH_CODE") . md5($data));
	}
?>