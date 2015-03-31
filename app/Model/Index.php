<?php 
App::uses('AppModel', 'Model');
/**
 * Member  Model
 */
class Index extends AppModel {
	var $useTable = false;
	var $tablePrefix = 'sxy_';
	
	
	/*
	 * 查询菜单列表
	 */
	function getMenue(){
		$sql = "select * from ".Configure::read('prefix')."navs";
		$res = $this->query($sql);
		$res = cakeRstoRs($res, Configure::read('prefix').'navs');
		return $res;
		//print_R($res);exit;
	}
	/*
	 * 取广告列表
	 */
	function getindexads(){
		$sql = "select * from ".Configure::read('prefix')."ads where position=1";
		$res = $this->query($sql);
		$res = cakeRstoRs($res, Configure::read('prefix').'ads');
		return $res;
	}
	
	function getoneNews($id=null){
		if($id){
			$where = " where id=$id";
		}else{
			$where = " order by id desc limit 1";
		}
		$sql = "select * from ".Configure::read('prefix')."news $where";
		$res = $this->query($sql);
		$res = cakeRstoRs($res, Configure::read('prefix').'news');
		return $res;
	}
	function getoneProduct($id){
		$sql = "select * from ".Configure::read('prefix')."contents where id=$id and status=1";
		$res = $this->query($sql);
		$res = cakeRstoRs($res, Configure::read('prefix').'contents');
		return $res;
	}
	function getShenlist($addarr,$limit=''){
		$where = $this->getWhere($addarr);
		$sql = "select * from ".Configure::read('prefix')."contents where ".$where.' order by id desc';
		$sql.=$limit;
		$res = $this->query($sql);
		return  cakeRstoRs($res, Configure::read('prefix').'contents');
	}
	
	//获取总的记录条数
	function getShencount($data){
		$where = $this->getWhere($data);
		$sql = "SELECT count(1) as count FROM ".Configure::read('prefix')."contents   WHERE ".$where;
		$res = $this->query($sql);
		return $res[0][0]['count'];
	}
	function getWhere($data){
		$where = rand(1,9);
		if(!empty($data['rid'])){
			$where .= " and rid = '".$data['rid']."'";
		}
		if(!empty($data['rids'])){
			$where .= " and rid in(".$data['rids'].")";
		}
		return $where.' and status=1';
	}
	function findsonid($rid){
		$sql = "select * from ".Configure::read('prefix')."navs where parent_id=$rid";
		$res = $this->query($sql);
		return  cakeRstoRs($res, Configure::read('prefix').'navs');
	}
	function getProductslist($addarr,$limit=''){
		$where = $this->getWhere($addarr);
		$sql = "select * from ".Configure::read('prefix')."products where ".$where;
		$sql.=$limit;
		$res = $this->query($sql);
		return  cakeRstoRs($res, Configure::read('prefix').'products');
	}
	//获取总的记录条数
	function getProductscount($data){
		$where = $this->getWhere($data);
		$sql = "SELECT count(1) as count FROM ".Configure::read('prefix')."products   WHERE ".$where;
		$res = $this->query($sql);
		return $res[0][0]['count'];
	}
	
	 function getRightlist(){
		$sql = "select * from ".Configure::read('prefix')."goods";
		$res = $this->query($sql);
		return  cakeRstoRs($res, Configure::read('prefix').'goods');
	} 
	function getcatname($rid){
		$sql = "select title from ".Configure::read('prefix')."goods where id=$rid";
		$res = $this->query($sql);
		return  cakeRstoRs($res, Configure::read('prefix').'goods');
	}
	
	function getOnepro($id){
		$sql = "select * from ".Configure::read('prefix')."products where id=$id";
		$res = $this->query($sql);
		$res = cakeRstoRs($res, Configure::read('prefix').'products');
		return $res;
	}
	function getNavsid($module,$action){
		$sql = "select id from ".Configure::read('prefix')."navs where module='$module' and action='$action'";
		$res = $this->query($sql);
		$res = cakeRstoRs($res, Configure::read('prefix').'navs');
		return $res;
	}
	function getBanner($position){
		$sql = "select * from ".Configure::read('prefix')."ads where position=$position";
		$res = $this->query($sql);
		$res = cakeRstoRs($res, Configure::read('prefix').'ads');
		return $res[0];
	}
	function getnavsinfo($rid){
		$sql = "select * from ".Configure::read('prefix')."navs where id=$rid";
		$res = $this->query($sql);
		$res = cakeRstoRs($res, Configure::read('prefix').'navs');
		return $res[0];
	}
	

}
?>