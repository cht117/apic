<?php 
/**
 * 用于用户登录,退出等操作
 * 
 * @author 
 * @version 1.0
 */
class UserloginComponent extends Component 
{
	var $username = ''; //用户名
	
	var $pwd = ''; //用户密码
		
	var $components = array('Cookie');
	
	//用户登录操作。 
	function doLogin($username,$pwd,$memberData,$memoryLogin,$cookieConfig){
		#if(count($memberData)<=0 || md5($pwd) != $memberData['user_pwd']) return 0;
		$this->setLoginCookie($memberData,$memoryLogin,$cookieConfig);
		//成功返回1
		return 1;
	}
	/**
	 * 登录成功cookie
	 */
	private function setLoginCookie($memberData,$memoryLogin,$cookieConfig){
		$this->Cookie->name = Configure::read('COOKIENAME');
		$this->Cookie->time = $cookieConfig['time'];
		$this->Cookie->path = Configure::read('COOKIEPATH');
		$this->Cookie->domain = $cookieConfig['domain'];
		$this->Cookie->secure = false;
		$this->Cookie->key = Configure::read('COOKIEKEY');
		if($memoryLogin) $this->Cookie->time = 86400;
		/*
		$this->Cookie->write('u_name',$memberData['username']);
		$this->Cookie->write('roleid',$memberData['actorid']);
		$this->Cookie->write('uid',$memberData['id']);
		$this->Cookie->write('SKey',$memberData['password']);
		*/
		//同步登录后写入登录密钥cookie
		$this->set_cookies ( 'sxy_name', $memberData['user_name'],0,'/',Configure::read('COOKIEURL'),1 );//写入登录成功后的信息
		$login_key = md5($memberData['user_name'].Configure::read('loginkey'));
		$this->set_cookies('login_key', $login_key,0,'/',Configure::read('COOKIEURL'),1);
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
//退出登录
	function logout($cookieConfig){
		$this->Cookie->name = 'sxy';
		$this->Cookie->time = $cookieConfig['time'];
		$this->Cookie->path = '/';
		$this->Cookie->domain = $cookieConfig['domain'];
		$this->Cookie->secure = false;
		$this->Cookie->key = $cookieConfig['key'];
		/*
		$this->Cookie->write('u_name','');
		$this->Cookie->write('roleid','');
		$this->Cookie->write('uid','');
		$this->Cookie->write('SKey','');
		*/
		$_COOKIE['sxy']=array();
		setcookie("sxy[uid]",'',time()-1, '/');
		setcookie("sxy[u_name]",'',time()-1, '/');
		$this->del_cookies();
	}
	/**
 	 * 清空cookie
 	 */
 	function del_cookies($is_lock = 0)
 	{
		$this->set_cookies('sxy_name','',time()-36000);
		$this->set_cookies('login_key','',time()-36000);
		$this->set_cookies('sxylogin','',time()-36000);
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
}
?>