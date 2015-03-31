<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
App::uses('Controller', 'Controller');
/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
	var $components = array (
			'Page',
			'Cookie',
			'Session',
	     );
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
	    return md5($this->C("AUTH_CODE") . md5($data));
	}
/**
	 *
	 * 设置cookie
	 * @param string $name
	 * @param string $value
	 * @param string $expire
	 * @param string $path
	 * @param string $domain
	 */
	function set_cookies($name, $value, $expire=0, $path='/', $domain='',$is_encode=false) {
		if (! isset ( $name ) || ! isset ( $value )) {
			return;
		}
		if (! isset ( $expire )) {
			$expire = 0;//不设置过期时间，会话cookie,关闭浏览器自动删除cookie
		}
		if (! isset ( $path )) {
			$path = '/';
		}
		$domain =$domain?$domain: Configure::read("COOKIEURL");
		if($is_encode)
		{
			ob_start();
			setcookie ( $name, empty($value)?'':$this->authcode($value,'CODE'), $expire, $path, $domain );
			ob_end_flush();
		}else{
			ob_start();
			setcookie ( $name,$value, $expire, $path, $domain );
			ob_end_flush();
		}
	}
	/**
	 *
	 *
	 *
	 * 根据name读取cookie
	 *
	 * @param string $name
	 */
	function get_cookies($name,$is_decode = false) {
		$_COOKIE [$name]=isset($_COOKIE [$name])?$_COOKIE [$name]:'';
		if($is_decode)
		{
			return $this->authcode($_COOKIE [$name],'DECODE');
		}
		return $_COOKIE [$name];
	}
	function authcode($string, $operation = 'DECODE', $key = '', $expiry = 0) {
		$key = $key?$key:Configure::read('HEMS2_COOKIEMI');
	    // 动态密匙长度，相同的明文会生成不同密文就是依靠动态密匙
	    // 加入随机密钥，可以令密文无任何规律，即便是原文和密钥完全相同，加密结果也会每次不同，增大破解难度。
	    // 取值越大，密文变动规律越大，密文变化 = 16 的 $ckey_length 次方
	    // 当此值为 0 时，则不产生随机密钥
	    //$ci = & get_instance();
		//$ci->load->config('common');
		$ckey_length = 4;
		// 密匙
		$key = md5($key);
	
	    // 密匙a会参与加解密
	    $keya = md5(substr($key, 0, 16));
	    // 密匙b会用来做数据完整性验证
	    $keyb = md5(substr($key, 16, 16));
	    // 密匙c用于变化生成的密文
	    $keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length): substr(md5(microtime()), -$ckey_length)) : '';
	    // 参与运算的密匙
	    $cryptkey = $keya.md5($keya.$keyc);
	    $key_length = strlen($cryptkey);
	    // 明文，前10位用来保存时间戳，解密时验证数据有效性，10到26位用来保存$keyb(密匙b)，解密时会通过这个密匙验证数据完整性
	    // 如果是解码的话，会从第$ckey_length位开始，因为密文前$ckey_length位保存 动态密匙，以保证解密正确
	    $string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0).substr(md5($string.$keyb), 0, 16).$string;
	    $string_length = strlen($string);
	    $result = '';
	    $box = range(0, 255);
	    $rndkey = array();
	    // 产生密匙簿
	    for($i = 0; $i <= 255; $i++) {
	        $rndkey[$i] = ord($cryptkey[$i % $key_length]);
	    }
	    // 用固定的算法，打乱密匙簿，增加随机性，好像很复杂，实际上并不会增加密文的强度
	    for($j = $i = 0; $i < 256; $i++) {
	        $j = ($j + $box[$i] + $rndkey[$i]) % 256;
	        $tmp = $box[$i];
	        $box[$i] = $box[$j];
	        $box[$j] = $tmp;
	    }
	    // 核心加解密部分
	    for($a = $j = $i = 0; $i < $string_length; $i++) {
	        $a = ($a + 1) % 256;
	        $j = ($j + $box[$a]) % 256;
	        $tmp = $box[$a];
	        $box[$a] = $box[$j];
	        $box[$j] = $tmp;
	        // 从密匙簿得出密匙进行异或，再转成字符
	        $result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
	    }
	    
	    if($operation == 'DECODE') {
	        // 验证数据有效性，请看未加密明文的格式
	        
	        if((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16)) {
	            return substr($result, 26);
	        } else {
	            return '';
	        }
	    } else {
	        // 把动态密匙保存在密文里，这也是为什么同样的明文，生产不同密文后能解密的原因
	        // 因为加密后的密文可能是一些特殊字符，复制过程可能会丢失，所以用base64编码
	        return $keyc.str_replace('=', '', base64_encode($result));
	    }
	}
function _ajaxjson($code, $msg = '', $url = '', $id = '') {
		$returndata = array (
				"code" => $code,
				"msg" => $msg,
				"url" => $url,
				"id" => $id
		);
		echo json_encode ( $returndata );
		exit ();
	}
}
