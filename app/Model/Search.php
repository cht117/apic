<?php 
App::uses('AppModel', 'Model');
/**
 * Siteinfo  Model
 */
class Search extends AppModel {
	public $useTable = false;
	public $useDbConfig = 'default';
	
	function getdata($ids,$limit=''){
		$where = $this->getWhere($ids);
		$sql = "select typeid,id,adddate,url,img_url,title,summary from v9_search where ".$where;
		$sql.=$limit;
		$res = $this->query($sql);
		return  cakeRstoRs($res, 'v9_search');
	}
	function getcount($ids){
		$where = $this->getWhere($ids);
		$sql = "SELECT count(1) as count FROM v9_search WHERE ".$where;
		$res = $this->query($sql);
		return $res[0][0]['count'];
	}
	function  getWhere($ids){
		$where = rand(1,9)." and searchid in (".$ids.")";
		return $where;
	}
}
	
	