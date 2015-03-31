<?php 
App::uses('AppModel', 'Model');
/**
 * Member  Model
 */
class Adp extends AppModel {
	var $name = 'adp';
	var $tablePrefix = 'sxy_';
	
	/**
	 * 查询列表
	 */
	function  getlist($addarr=array(),$limit=''){
		$where = $this->getWhere($addarr);
		$sql = "select * from ".Configure::read('prefix')."adps where ".$where;
		$sql.=$limit;
		$res = $this->query($sql);
		return  cakeRstoRs($res, Configure::read('prefix').'adps');
	}
	//获取总的记录条数 
	function getcount($data=array()){
		$where = $this->getWhere($data);
		$sql = "SELECT count(1) as count FROM ".Configure::read('prefix')."adps   WHERE ".$where;
		$res = $this->query($sql);
		return $res[0][0]['count'];
	}
	/**
	 * 查询数据操作
	 * Enter description here ...
	 * @param unknown_type $table
	 * @param unknown_type $where
	 */
	function checkinfo($table,$con,$where = null){
		$sql = 'select '.$con.' from '.$table.' where '.rand(1, 9);
		if(!empty($where)){
			foreach($where as $k => $v){
					$sql .= ' and '.$k.'="'.$v.'"';
				}
		}
		//echo $sql;exit;
		$res = $this->query($sql);
		$res = cakeRstoRs($res,$table);
		//var_dump($res);exit;
		return $res;
	}
	/**
	 * 添加用户
	 */
	function add($data,$table)
	{
		$sqlk = $sqlv = '';
		foreach($data as $k=>$v)
		{
			$sqlk .= ','.$k;
			$sqlv .= ",'$v'";
		}
		$sqlk = substr($sqlk,1);
		$sqlv = substr($sqlv,1);

		 $sql = "INSERT INTO ".$table." (".$sqlk.") VALUES (".$sqlv.")";
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
		$sql = "DELETE FROM ".Configure::read('prefix')."adps WHERE id=$id";
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
		$sql = "UPDATE ".Configure::read('prefix')."adps SET $qsql WHERE id='$id'";
		$this->query($sql);
		return $this->getAffectedRows();
	}
	
	
}
?>