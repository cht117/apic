<?php 
App::uses('Base', 'Model');
/**
 * Member  Model
 */
class Cate extends Base {
	var $name = 'category';
/**
	 * 查询列表
	 */
	function  getlist($addarr=array(),$limit='',$order="sort desc,id desc"){
		$where = $this->getWhere($addarr);
		$sql = "select * from ".Configure::read('prefix').$this->name." where ".$where." order by ".$order ;
		$sql.=$limit;
		$res = $this->query($sql);
		return  cakeRstoRs($res, Configure::read('prefix').$this->name);
	}
	
	
}
?>