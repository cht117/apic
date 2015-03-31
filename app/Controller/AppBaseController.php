<?php
App::uses ( 'BaseController', 'Controller' );
class AppBaseController extends BaseController {
 	/*  var $uses = array (
			'Base' 
	);   */
	var $obj = null;
	 function __construct(){
		$obj = $this->loadModel($this->modelClass);
		
	}
	
	
	//public $modelClass = null;
	function index() {
		//var_dump($this->modelClass->getcount($params));exit;
		$this->pagenum = 5;
		$data = isset ( $this->data ) ? $this->data : '';
		// $params['chname']=isset($data['chname'])?addslashes(trim($data['chname'])):'';
		// $params['order']=isset($data['order'])?$data['order']:"id asc";
		//var_dump($this->loadModel());exit;
		$total = $this->$obj->getcount ( $params );
		$searchWhere = $this->deal_url ( $data );
		$mpurl = $this->base . "/Cate1/index?" . $searchWhere; // 分页跳转链接
		$start = $this->usePage ( $this->pagenum, $total, $mpurl );
		$limit = "  limit $start,".$this->pagenum;
		$list = $this->$obj->getlist ( $params, $limit );
		$this->set ( 'list', $list );
		$this->set ( 'data', $data );
	}
	
	/**
	 * 添加功能
	 * 
	 * @return void
	 */
	function add() {
		if ($_SERVER ['REQUEST_METHOD'] == 'POST') {
			$func_data = $this->data ? $this->data : '';
			$msg = '';
			if (! $func_data ['id']) {
				$res = $this->Cate->add ($func_data); /* 添加功能 */
				$msg = '添加';
			} else {
				$res = $this->Cate->edit ($func_data, intval( $func_data ['id'] ) );
				$msg = '修改';
			}
			if ($res) {
				echo json_encode ( array (
						"status" => 1,
						"info" => $msg . "成功",
						'url' => Configure::read ( 'ROOTURL' ) . 'Cate/index' 
				) );
				exit ();
			} else {
				echo json_encode ( array (
						"status" => 0,
						"info" => $msg . "失败",
						'url' => Configure::read ( 'ROOTURL' ) . 'Cate/index' 
				) );
				exit ();
			}
		} else {
			//echo 222;exit;
			//var_dump($func_data);exit;
			$id  = isset($_REQUEST ['id'])?intval($_REQUEST ['id']):0;
			//echo $id;exit;
			if ($id ) {
				$list = $this->Cate->checkinfo (array (
						'id' => $id  
				) );
				$this->set ( "info", $list [0] );
			}
		}
	}
	/* 删除
	*/
	function del(){
		$data = $this->data?$this->data:'';
		$id = intval($data['id']);
		if(!$id){exit('Error...');}
		$where = rand(1, 9)." and id = ".$id;
		$del = $this->Cate->del($id);
		//var_dump($del);exit;
		if($del){
			echo json_encode ( array (
						"status" => 1,
						"info" => "删除成功",
						'url' => Configure::read ( 'ROOTURL' ) . 'Cate/index' 
				) );
				exit ();
		}else{
			$msg="删除成功";
			echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
			echo "<script> alert('".$msg."');window.location='".$backurl."'</script>";
			exit;
		}
	}
}
?>