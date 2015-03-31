<?php
/**
 * 全局高亮搜索  sphinx  add by  hd 
 */ 
App::uses('BaseController', 'Controller');
class SearchController extends BaseController{
	 public  $cl = '';
	 public  $adn = '103.7.220.217'; //服务器地址
	 public  $port = '9312'; //端口
	 var $uses= array('Search');
	public  function beforeFilter(){
				parent::beforeFilter ();
				$this->connsphinx();
		 }
	/**
	 * 关键词搜索
	 * Enter description here ...
	 */
	function index(){
	  $data = $this->data?$this->data:'';
	  $list = array();
	  if(!empty($data['keyword'])&&!empty($data)){
		  $keyword = !empty($data['keyword'])?$data['keyword']:'error';
		  $result = $this->cl->query($keyword,'index_search_main'); //已经通过sphinxspi接口查看出了关键词在索引中的权重，根据索引id 号我去数据源中拿数据，sphinx工作已经结束，下边需要mysql来工作了，
		  $ids = array_key_exists('matches',$result)?join(',',array_keys($result['matches'])):'0'; //将sphinx检索的索引id 取出。
		  $rowsPerPage = $this->pagenum?$this->pagenum:20;
		  $currentPage = empty($data['page']) ? 1 : $data['page'];
		  $total = $this->Search->getcount($ids);
		  $searchWhere = $this->deal_url($data);
		  $mpurl = $this->base."/Search/index?".$searchWhere;//分页跳转链接
		  $start = $this->usePage ( 20, $total, $mpurl );
		  $limit = "  limit $start,20";
		  $list=$this->Search->getdata($ids,$limit);
		  foreach ($list as $key=>$item){
		  	$opts = array(
					"before_match"=>"<font color='red'>",
					"after_match"=>"</font>"
				    );
		    $info = $this->cl->buildExcerpts($item,"index_search_main",$keyword,$opts);
		    $list[$key]['title'] = $info[5];
		    $list[$key]['summary'] = $info[6];
	 	 }
	  }
	  $this->set('btitle',$data['keyword']);
	  $this->set('list',$list);
	  $this->set('data',$data);
	}
	
//sphinx连接数 、汉子转拼音连接数
	private  function connsphinx(){
		include_once ('../Vendor/sphinxapi.php');
		$this->cl = new SphinxClient();
		$this->cl->SetServer($this->adn,$this->port);
	}
	
}
?>