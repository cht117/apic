<?php 
App::uses('BaseController', 'Controller');
/*
 * 前台首页控制器
 */

class WinesourceController extends BaseController {
	var $uses= array('News','Member','Index');
	public function beforeFilter(){
		parent::beforeFilter ();
		$res =$this->Index->findsonid(5);
		$this->set('right',$res);
		$sons = $this->Index->findsonid(20);
		$this->set('sons',$sons);
		$btitle = "参酒之源";
		$this->set('btitle',$btitle);
	}
	function index(){
		$rid = 5;
		$ridarr = $this->Index->findsonid($rid);
		//print_R($ridarr);exit;
		foreach($ridarr as $k=>$v){
			$arr[]=$v['id'];
		}
		$rids = implode(',',$arr);
		$data = isset($this->data)?$this->data:'';
		$params['order']=isset($data['order'])?$data['order']:"id asc";
		$params['rids'] = $rid.','.$rids.',23,24,25,26';
		$rowsPerPage = $this->pagenum?$this->pagenum:20;
		$currentPage = empty($data['page']) ? 1 : $data['page'];
		$total = $this->Index->getShencount($params);
		$searchWhere = $this->deal_url($data);
		$mpurl = $this->base."/Winesource/index?".$searchWhere;//分页跳转链接
		$start = $this->usePage ( 10, $total, $mpurl );
		$limit = "  limit $start,10 ";
		$list=$this->Index->getShenlist($params,$limit);
		
		$this->set('list',$list);
		$this->render ( 'list' );
	}
	//产品介绍
	function intro(){
		$rid = 20;
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
		$mpurl = $this->base."/Winesource/intro?".$searchWhere;//分页跳转链接
		$start = $this->usePage ( 10, $total, $mpurl );
		$limit = "  limit $start,10 ";
		$list=$this->Index->getShenlist($params,$limit);
		$stitle = "产品介绍";
		$this->set('stitle',$stitle);
		$this->set('list',$list);
		$this->render ( 'list' );
		/* $data = isset($this->data)?$this->data:'';
		$params['order']=isset($data['order'])?$data['order']:"id asc";
		$rowsPerPage = $this->pagenum?$this->pagenum:20;
		$currentPage = empty($data['page']) ? 1 : $data['page'];
		$total = $this->Index->getProductscount($params);
		$searchWhere = $this->deal_url($data);
		$mpurl = $this->base."/Winesource/desc?".$searchWhere;//分页跳转链接
		$start = $this->usePage ( 10, $total, $mpurl );
		$limit = "  limit $start,10 ";
		$list=$this->Index->getProductslist($params,$limit);
		$stitle = "产品介绍";
		$this->set('stitle',$stitle);
		$this->set('list',$list);
		$this->render ( 'list' ); */
	}
	//产品特点
	function feature (){
		$rid = 21;
		$data = isset($this->data)?$this->data:'';
		$params['order']=isset($data['order'])?$data['order']:"id asc";
		$params['rid'] = $rid;
		$rowsPerPage = $this->pagenum?$this->pagenum:20;
		$currentPage = empty($data['page']) ? 1 : $data['page'];
		$total = $this->Index->getShencount($params);
		$searchWhere = $this->deal_url($data);
		$mpurl = $this->base."/Winesource/feature?".$searchWhere;//分页跳转链接
		$start = $this->usePage ( 10, $total, $mpurl );
		$limit = "  limit $start,10 ";
		$list=$this->Index->getShenlist($params,$limit);
		$stitle = "产品特点";
		$this->set('stitle',$stitle);
		$this->set('list',$list);
		$this->render ( 'list' );
	}
	//文化
	function culture (){
		$rid = 22;
		$data = isset($this->data)?$this->data:'';
		$params['order']=isset($data['order'])?$data['order']:"id asc";
		$params['rid'] = $rid;
		$rowsPerPage = $this->pagenum?$this->pagenum:20;
		$currentPage = empty($data['page']) ? 1 : $data['page'];
		$total = $this->Index->getShencount($params);
		$searchWhere = $this->deal_url($data);
		$mpurl = $this->base."/Winesource/culture?".$searchWhere;//分页跳转链接
		$start = $this->usePage ( 10, $total, $mpurl );
		$limit = "  limit $start,10 ";
		$list=$this->Index->getShenlist($params,$limit);
		
		$stitle = "参酒文化";
		$this->set('stitle',$stitle);
		$this->set('list',$list);
		$this->render ( 'list' );
	}
	/* function detaile (){
		$id = $_GET['id']?$_GET['id']:exit();
		$news = $this->Index->getoneProduct($id);
		//获取作者名称
		$nickname = $this->Member->getInfoById($news[0]['uid']);
		$news[0]['nickname'] = $nickname[0]['nickname'];
		$this->set('news',$news[0]);
		
		$stitle = "详情";
		$this->set('stitle',$stitle);
	} */
	function desc (){
		$id = $_GET['id']?$_GET['id']:exit();
		$news = $this->Index->getoneProduct($id);
		//获取作者名称
		$nickname = $this->Member->getInfoById($news[0]['uid']);
		$news[0]['nickname'] = $nickname[0]['nickname'];
		$this->set('news',$news[0]);$res = $this->Index->getnavsinfo($news[0]['rid']);
		$this->set('module',$res['module']);
		$this->set('action',$res['action']);
		$stitle = $res['nav_name'];
		$this->set('stitle',$stitle);
	}
	
	/* function getcat(){
		$rid = $_GET['rid']?$_GET['rid']:exit();
		$stitle = $this->Index->getcatname($rid);
		$data = isset($this->data)?$this->data:'';
		$params['order']=isset($data['order'])?$data['order']:"id asc";
		$params['rid'] = $rid;
		$rowsPerPage = $this->pagenum?$this->pagenum:20;
		$currentPage = empty($data['page']) ? 1 : $data['page'];
		$total = $this->Index->getProductscount($params);
		$searchWhere = $this->deal_url($data);
		$mpurl = $this->base."/Winesource/getcat?".$searchWhere;//分页跳转链接
		$start = $this->usePage ( 10, $total, $mpurl );
		$limit = "  limit $start,10 ";
		$list=$this->Index->getProductslist($params,$limit);
		
		$this->set('stitle',$stitle[0]['title']);
		$this->set('list',$list);
		$this->render ( 'list' );
	} */
	
	//臻品品鉴版国参酒
	function zhen (){
		$rid = 23;
		$data = isset($this->data)?$this->data:'';
		$params['order']=isset($data['order'])?$data['order']:"id asc";
		$params['rid'] = $rid;
		$rowsPerPage = $this->pagenum?$this->pagenum:20;
		$currentPage = empty($data['page']) ? 1 : $data['page'];
		$total = $this->Index->getShencount($params);
		$searchWhere = $this->deal_url($data);
		$mpurl = $this->base."/Winesource/culture?".$searchWhere;//分页跳转链接
		$start = $this->usePage ( 10, $total, $mpurl );
		$limit = "  limit $start,10 ";
		$list=$this->Index->getShenlist($params,$limit);
	
		$stitle = "臻品品鉴版国参酒";
		$this->set('stitle',$stitle);
		$this->set('list',$list);
		$this->render ( 'list' );
	}
	function fifteen (){
		$rid = 24;
		$data = isset($this->data)?$this->data:'';
		$params['order']=isset($data['order'])?$data['order']:"id asc";
		$params['rid'] = $rid;
		$rowsPerPage = $this->pagenum?$this->pagenum:20;
		$currentPage = empty($data['page']) ? 1 : $data['page'];
		$total = $this->Index->getShencount($params);
		$searchWhere = $this->deal_url($data);
		$mpurl = $this->base."/Winesource/culture?".$searchWhere;//分页跳转链接
		$start = $this->usePage ( 10, $total, $mpurl );
		$limit = "  limit $start,10 ";
		$list=$this->Index->getShenlist($params,$limit);
	
		$stitle = "15年典藏版国参酒";
		$this->set('stitle',$stitle);
		$this->set('list',$list);
		$this->render ( 'list' );
	}
	function thirty (){
		$rid = 25;
		$data = isset($this->data)?$this->data:'';
		$params['order']=isset($data['order'])?$data['order']:"id asc";
		$params['rid'] = $rid;
		$rowsPerPage = $this->pagenum?$this->pagenum:20;
		$currentPage = empty($data['page']) ? 1 : $data['page'];
		$total = $this->Index->getShencount($params);
		$searchWhere = $this->deal_url($data);
		$mpurl = $this->base."/Winesource/culture?".$searchWhere;//分页跳转链接
		$start = $this->usePage ( 10, $total, $mpurl );
		$limit = "  limit $start,10 ";
		$list=$this->Index->getShenlist($params,$limit);
	
		$stitle = "30年珍藏版国参酒";
		$this->set('stitle',$stitle);
		$this->set('list',$list);
		$this->render ( 'list' );
	}
	
	function seventy (){
		$rid = 26;
		$data = isset($this->data)?$this->data:'';
		$params['order']=isset($data['order'])?$data['order']:"id asc";
		$params['rid'] = $rid;
		$rowsPerPage = $this->pagenum?$this->pagenum:20;
		$currentPage = empty($data['page']) ? 1 : $data['page'];
		$total = $this->Index->getShencount($params);
		$searchWhere = $this->deal_url($data);
		$mpurl = $this->base."/Winesource/culture?".$searchWhere;//分页跳转链接
		$start = $this->usePage ( 10, $total, $mpurl );
		$limit = "  limit $start,10 ";
		$list=$this->Index->getShenlist($params,$limit);
	
		$stitle = "70年密藏版国参酒";
		$this->set('stitle',$stitle);
		$this->set('list',$list);
		$this->render ( 'list' );
	}
	
}

?>
