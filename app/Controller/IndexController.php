<?php 
App::uses('BaseController', 'Controller');
/*
 * 前台首页控制器
 */

class IndexController extends BaseController {
	var $uses = array('Index');
	
	function index(){
	
	//取广告
	$ads = $this->Index->getindexads();
	$news = $this->Index->getoneNews();
	$rid=2;
	$params['rid']=$rid;
	$res = $this->Index->getShenlist($params);
	$this->set('company',$res[0]);
	$this->set('news',$news);
	$this->set('ads',$ads);
	}
}

?>
