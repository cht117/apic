<?php 
App::uses('BaseController', 'Controller');
/*
 * 前台首页控制器
 */

class CompanyController extends BaseController {
	var $uses= array('News','Member','Index');
	public function beforeFilter(){
		parent::beforeFilter ();
		$res =$this->Index->findsonid(2);
		$this->set('right',$res);
		$btitle = "企业介绍";
		$this->set('btitle',$btitle);
	}
	function index(){
		$rid=2;
		$params['rid']=$rid;
		$res = $this->Index->getShenlist($params);
		$nickname = $this->Member->getInfoById($res[0]['uid']);
		$res[0]['nickname'] = $nickname[0]['nickname'];
		$this->set('news',$res[0]);
		

	}
	function intro(){
		$rid=6;
		$params['rid']=$rid;
		$res = $this->Index->getShenlist($params);
		$nickname = $this->Member->getInfoById($res[0]['uid']);
		$res[0]['nickname'] = $nickname[0]['nickname'];
		$this->set('news',$res[0]);
		$stilte="公司概况";
		$this->set('stitle',$stilte);
		$this->render('index');
	}
	function newslist(){
		$data = isset($this->data)?$this->data:'';
		$params['title']=isset($data['title'])?addslashes(trim($data['title'])):'';
		$params['order']=isset($data['order'])?$data['order']:"id asc";
		$rowsPerPage = $this->pagenum?$this->pagenum:20;
		$currentPage = empty($data['page']) ? 1 : $data['page'];
		$total = $this->News->getcount($params);
		$searchWhere = $this->deal_url($data);
		$mpurl = $this->base."/Company/newslist?".$searchWhere;//分页跳转链接
		$start = $this->usePage ( 10, $total, $mpurl );
		$limit = "  limit $start,10 ";
		$list=$this->News->getList($params,$limit);
		$this->set('list',$list);
		$this->set('data',$data);
		$stilte="新闻动态";
		$this->set('stitle',$stilte);
	}
	function news (){
		$id = $_GET['id']?$_GET['id']:exit();
		$news = $this->Index->getoneNews($id);
		//获取作者名称
		$nickname = $this->Member->getInfoById($news[0]['uid']);
		$news[0]['nickname'] = $nickname[0]['nickname'];
		$this->set('news',$news[0]);
		 $stilte="新闻动态";
		$this->set('stitle',$stilte); 
	}

	function about(){
		$rid=8;
		$params['rid']=$rid;
		$res = $this->Index->getShenlist($params);
		$nickname = $this->Member->getInfoById($res[0]['uid']);
		$res[0]['nickname'] = $nickname[0]['nickname'];
		$this->set('news',$res[0]);
		$stilte="联系我们";
		$this->set('stitle',$stilte);
		$this->render('index');
	}
	
	
	
}

?>
