<?php 
App::uses('AppModel', 'Model');
/**
 * Member  Model
 */
class Base extends AppModel {
	var $name = null;
	var $useTable = false;
	//var $tablePrefix = 'sxy_';
	var $tbl='';
	function __construct(){		
		$this->tbl = Configure::read('prefix').$this->name;		
	}
	
	/**
	 * 查询列表
	 */
	function  getlist($addarr=array(),$limit='',$order="id desc"){
		$where = $this->getWhere($addarr);
		$sql = "select * from ".Configure::read('prefix').$this->name." where ".$where." order by ".$order ;
		$sql.=$limit;
		$res = $this->query($sql);
		return  cakeRstoRs($res, Configure::read('prefix').$this->name);
	}
	//获取总的记录条数 
	function getcount($data=array()){
		$where = $this->getWhere($data);
		$sql = "SELECT count(1) as count FROM ".Configure::read('prefix').$this->name." WHERE ".$where;
		$res = $this->query($sql);
		return $res[0][0]['count'];
	}
	/**
	 * 查询数据操作
	 * Enter description here ...
	 * @param unknown_type $table
	 * @param unknown_type $where
	 */
	function checkinfo($where = null,$con="*",$table){
		$sql = 'select '.$con.' from '.Configure::read('prefix').$this->name.' where '.rand(1, 9);
		if(!empty($where)){
			foreach($where as $k => $v){
					$sql .= ' and '.$k.'="'.$v.'"';
				}
		}
		//echo $sql;exit;
		$res = $this->query($sql);
		$res = cakeRstoRs($res,Configure::read('prefix').$this->name);
		//var_dump($res);exit;
		return $res;
	}
	/**
	 * 添加用户
	 */
	function add($data)
	{
		$sqlk = $sqlv = '';
		foreach($data as $k=>$v)
		{
			$sqlk .= ','.$k;
			$sqlv .= ",'$v'";
		}
		$sqlk = substr($sqlk,1);
		$sqlv = substr($sqlv,1);

		 $sql = "INSERT INTO ".Configure::read('prefix').$this->name." (".$sqlk.") VALUES (".$sqlv.")";
		$this->query($sql);
		return $this->getDataSource()->lastInsertId();
	}
	function getWhere($data){
		$where = rand(1,9);
		return $where;
	}
	
	/**
	 * 删除
	 * 
	 */
	function del($id)
	{
		$sql = "DELETE FROM ".Configure::read('prefix').$this->name." WHERE id=$id";
		$this->query($sql);
		return $this->getAffectedRows();
	}
	/**
	 * 编辑功能
	 */
	function edit($data,$id)
	{
		$qsql = '';
		foreach($data as $k=>$v)
		{
			$qsql .= ','.$k."="."'$v'";
		}
		$qsql = substr($qsql,1);
		$sql = "UPDATE ".Configure::read('prefix').$this->name." SET $qsql WHERE id='$id'";
		$this->query($sql);
		return $this->getAffectedRows();
	}
	
	
}
?>