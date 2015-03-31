<?php 
App::uses('BaseController', 'Controller');
class BackstageController extends BaseController {
	
	  function index(){
	  	if (function_exists('gd_info')) {
            $gd = gd_info();
            $gd = $gd['GD Version'];
       	 } else {
            $gd = "不支持";
        }
        $info = array(
        	1=>array(
        		'param'=>'操作系统',
        		'values'=>'PHP_OS'
        	),
        	2=>array(
        		'param'=>'主机名IP端口',
        		'values'=> $_SERVER['SERVER_NAME'] . ' (' . $_SERVER['SERVER_ADDR'] . ':' . $_SERVER['SERVER_PORT'] . ')'
        	),
            3=>array(
            	'param'=>'运行环境',
            	'values'=> $_SERVER["SERVER_SOFTWARE"]
            ),
            4=>array(
            	'param'=>'PHP运行方式',
            	'values'=> php_sapi_name()
            ),
            5=>array(
            	'param'=>'程序目录',
            	'values'=> ROOT
            ),
            6=>array(
            	'param'=>'MYSQL版本',
            	'values'=> function_exists("mysql_close") ? mysql_get_client_info() : '不支持'
            ),
            7=>array(
            	'param'=>'GD库版本',
            	'values'=> $gd
            ),
            8=>array(
            	'param'=>'上传附件限制',
            	'values'=> ini_get('upload_max_filesize')
            ),
            9=>array(
            	'param'=>'执行时间限制',
            	'values'=> ini_get('max_execution_time') . "秒"
            ),
            10=>array(
            	'param'=>'剩余空间',
            	'values'=> round((@disk_free_space(".") / (1024 * 1024)), 2) . 'M'
            ),
            11=>array(
            	'param'=>'服务器时间',
            	'values'=> date("Y年n月j日 H:i:s")
            ),
            12=>array(
            	'param'=>'北京时间',
            	'values'=> gmdate("Y年n月j日 H:i:s", time() + 8 * 3600)
            ),
            13=>array(
            	'param'=>'采集函数检测',
            	'values'=> ini_get('allow_url_fopen') ? '支持' : '不支持'
            ),
            14=>array(
            	'param'=>'register_globals',
            	'values'=> get_cfg_var("register_globals") == "1" ? "ON" : "OFF"
            ),
            15=>array(
            	'param'=>'magic_quotes_gpc',
            	'values'=> (1 === get_magic_quotes_gpc()) ? 'YES' : 'NO'
            ),
            16=>array(
            	'param'=>'magic_quotes_runtime',
            	'values'=> (1 === get_magic_quotes_runtime()) ? 'YES' : 'NO'
            )
        );
        $this->set('server_info', $info);
		$this->set('currentNav','网站管理 > 系统信息');
	  }
}
?>