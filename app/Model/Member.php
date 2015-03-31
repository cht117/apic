<?php 
App::uses('AppModel', 'Model');
/**
 * Member  Model
 */
class Member extends AppModel {
	var $name = 'member';
	var $tablePrefix = 'sxy_';
	
	/*
	 * 获取用户信息
	 */
	function getInfoById($uid){
		$sql = "select * from ".Configure::read('prefix')."members where uid=$uid";
		$res = $this->query($sql);
		return  cakeRstoRs($res, Configure::read('prefix').'members');
	}
	/**
	 * 查询列表
	 */
	function  getlist($addarr,$limit=''){
		$where = $this->getWhere($addarr);
		$sql = "select * from ".Configure::read('prefix')."members where ".$where;
		$sql.=$limit;
		$res = $this->query($sql);
		return  cakeRstoRs($res, Configure::read('prefix').'members');
	}
	//获取总的记录条数 
	function getcount($data){
		$where = $this->getWhere($data);
		$sql = "SELECT count(1) as count FROM ".Configure::read('prefix')."members   WHERE ".$where;
		$res = $this->query($sql);
		return $res[0][0]['count'];
	}
	/**
	 * 查询数据操作
	 * Enter description here ...
	 * @param unknown_type $table
	 * @param unknown_type $where
	 */
	public function checkinfo($table,$con,$where = null){
		$sql = 'select '.$con.' from '.$table.' where '.rand(1, 9);
		if(!empty($where)){
			foreach($where as $k => $v){
					$sql .= ' and '.$k.'="'.$v.'"';
				}
		}
		$res = $this->query($sql);
		$res = cakeRstoRs($res,$table);
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

		$sql = "INSERT INTO ".Configure::read('prefix')."members (".$sqlk.") VALUES (".$sqlv.")";
		$this->query($sql);
		return $this->getDataSource()->lastInsertId();
	}
	function getWhere($data){
		$where = rand(1,9)." and status = ".$data['status'];
		if(!empty($data['email'])){
	  			$where .= " and email = '".$data['email']."'";
	  	}
		return $where;
	}
	/**
	 * 校验登录信息
	 */
    function getudata($username,$pwd){
    	$sql = "select * from ".Configure::read('prefix')."members where ".rand(1, 9). " and email = '$username'";
    	$info = $this->query($sql);
    	$res = cakeRstoRs($info,Configure::read('prefix').'members');
		return $res;
    }
	/**
	 * 查询登录用户的信息
	 * @params	$con		查询条件
	 * @return 	$userinfo	用户信息
	 **/
	function getloginmemberinfo($con)
	{
		$sql =  " select uid,email,nickname,roleids from ".
				Configure::read('prefix')."members where 1  and ".$con;
		$userinfo = $this->query($sql);
		return $userinfo;
	}
	/**
	 * 修改操作
	 */
	function modify($fields,$tab,$con='1')
	{
		$field = '';
		foreach ($fields as $key=>$val)
		{
			if($field=='')
			{
				$field .= $key.'="'.$val.'"';
			}
			else
			{
				$field .= ','.$key.'="'.$val.'"';
			}
		}
		$sql = "UPDATE $tab SET ".$field." WHERE $con";
	 	$rows = $this->query($sql);
		return TRUE;
	}
	/**
	 * 删除操作
	 */
	function del($tab,$where){
		$sql = "delete from ".$tab." where ".$where;
		$res = $this->query($sql);
		return TRUE;
	}
}
?>