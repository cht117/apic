<?php
    /**
     * 系统主配置
     * 解释: (kf)给开发用的配置
     */
    //主域名
	Configure::write('ROOTURL','http://hdcc.okooo.com/');
	//(kf)是否校验登录开关  1为开 0为不校验登录。
	Configure::write('mustLogin',1);
	//数据库前缀
	Configure::write('prefix','sxy_');
	/**
	 * cookie-config
	 */
	//cookie作用域
	Configure::write('COOKIENAME','LMF');
	//cookie作用域
	Configure::write('COOKIEURL','.okooo.com');
	//有效期 cookie
	Configure::write('COOKIETIME',36000);
	//Cookie Path
	Configure::write('COOKIEPATH','/');
	//cookie密钥
	Configure::write('COOKIEKEY',"#lmf!#@DSSDAQW");	
	//登录密钥
	Configure::write('loginkey','zslmfkf!@#$%^&*)(*&%%^%');
	/**
	 * 核心配置
	 */
	//memcache开关.
	Configure::write('IfMemcache',1);
	Configure::write('MemcacheConfig',array('server'=>'103.29.135.98','port'=>'11212'));
?>
