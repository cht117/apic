<?php 
App::uses('BaseController', 'Controller');
/*
 * 前台首页控制器
 */

class ShensourceController extends BaseController {
	var $uses= array('News','Member','Index');
	public function beforeFilter(){
		parent::beforeFilter ();
		$res =$this->Index->findsonid(3);
		$this->set('right',$res);
		$btitle = "参之源";
		$this->set('btitle',$btitle);
	}
	function index(){
		$rid = 3;
		$ridarr = $this->Index->findsonid($rid);
		//print_R($ridarr);exit;
		foreach($ridarr as $k=>$v){
			$arr[]=$v['id'];
		}
		$rids = implode(',',$arr);
		$data = isset($this->data)?$this->data:'';
		$params['order']=isset($data['order'])?$data['order']:"id asc";
		$params['rids'] = $rid.','.$rids;
		$rowsPerPage = $this->pagenum?$this->pagenum:20;
		$currentPage = empty($data['page']) ? 1 : $data['page'];
		$total = $this->Index->getShencount($params);
		$searchWhere = $this->deal_url($data);
		$mpurl = $this->base."/Shensource/feature?".$searchWhere;//分页跳转链接
		$start = $this->usePage ( 10, $total, $mpurl );
		$limit = "  limit $start,10 ";
		$list=$this->Index->getShenlist($params,$limit);
		
		$this->set('list',$list);
		$this->render ( 'list' );
	}
	//特点
	function feature(){
		$rid = 9;
		$data = isset($this->data)?$this->data:'';
		$params['order']=isset($data['order'])?$data['order']:"id asc";
		$params['rid'] = $rid;
		$rowsPerPage = $this->pagenum?$this->pagenum:20;
		$currentPage = empty($data['page']) ? 1 : $data['page'];
		$total = $this->Index->getShencount($params);
		$searchWhere = $this->deal_url($data);
		$mpurl = $this->base."/Shensource/feature?".$searchWhere;//分页跳转链接
		$start = $this->usePage ( 10, $total, $mpurl );
		$limit = "  limit $start,10 ";
		$list=$this->Index->getShenlist($params,$limit);
		
		$stitle = "野山参特点";
		$this->set('stitle',$stitle);
		$this->set('list',$list);
		$this->render ( 'list' );
	}
	//基地
	function address (){
		$rid = 10;
		$data = isset($this->data)?$this->data:'';
		$params['order']=isset($data['order'])?$data['order']:"id asc";
		$params['rid'] = $rid;
		$rowsPerPage = $this->pagenum?$this->pagenum:20;
		$currentPage = empty($data['page']) ? 1 : $data['page'];
		$total = $this->Index->getShencount($params);
		$searchWhere = $this->deal_url($data);
		$mpurl = $this->base."/Shensource/address?".$searchWhere;//分页跳转链接
		$start = $this->usePage ( 10, $total, $mpurl );
		$limit = "  limit $start,10 ";
		$list=$this->Index->getShenlist($params,$limit);
		
		$stitle = "天桥沟野山参基地";
		$this->set('stitle',$stitle);
		$this->set('list',$list);
		$this->render ( 'list' );
	}
	//野山参
	function wild (){
		$rid =11;
		$data = isset($this->data)?$this->data:'';
		$params['order']=isset($data['order'])?$data['order']:"id asc";
		$params['rid'] = $rid;
		$rowsPerPage = $this->pagenum?$this->pagenum:20;
		$currentPage = empty($data['page']) ? 1 : $data['page'];
		$total = $this->Index->getShencount($params);
		$searchWhere = $this->deal_url($data);
		$mpurl = $this->base."/Shensource/wild?".$searchWhere;//分页跳转链接
		$start = $this->usePage ( 10, $total, $mpurl );
		$limit = "  limit $start,10 ";
		$list=$this->Index->getShenlist($params,$limit);
		
		$stitle = "天桥沟牌野山参";
		$this->set('stitle',$stitle);
		$this->set('list',$list);
		$this->render ( 'list' );
	}
	//文化
	function culture (){
		$rid = 12;
		$data = isset($this->data)?$this->data:'';
		$params['order']=isset($data['order'])?$data['order']:"id asc";
		$params['rid'] = $rid;
		$rowsPerPage = $this->pagenum?$this->pagenum:20;
		$currentPage = empty($data['page']) ? 1 : $data['page'];
		$total = $this->Index->getShencount($params);
		$searchWhere = $this->deal_url($data);
		$mpurl = $this->base."/Shensource/culture?".$searchWhere;//分页跳转链接
		$start = $this->usePage ( 10, $total, $mpurl );
		$limit = "  limit $start,10 ";
		$list=$this->Index->getShenlist($params,$limit);
		
		$stitle = "参文化";
		$this->set('stitle',$stitle);
		$this->set('list',$list);
		$this->render ( 'list' );
	}
	function desc (){
		$id = $_GET['id']?$_GET['id']:exit();
		$news = $this->Index->getoneProduct($id);
		//获取作者名称
		$nickname = $this->Member->getInfoById($news[0]['uid']);
		$news[0]['nickname'] = $nickname[0]['nickname'];
		$this->set('news',$news[0]);
		$res = $this->Index->getnavsinfo($news[0]['rid']);
		$this->set('module',$res['module']);
		$this->set('action',$res['action']);
		$stitle = $res['nav_name'];
		$this->set('stitle',$stitle);
	}
	
	
	
	
}

?>
