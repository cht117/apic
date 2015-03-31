<?php 
App::uses('AppModel', 'Model');
/**
 * Member  Model
 */
class Roles extends AppModel {
	var $name = 'roles';
	var $tablePrefix = 'sxy_';
	
	/**
	 * 查询列表
	 */
	function  getlist($addarr,$limit=''){
		$where = $this->getWhere($addarr);
		$sql = "select * from ".Configure::read('prefix')."roles where ".$where;
		$sql.=$limit;
		$res = $this->query($sql);
		return  cakeRstoRs($res, Configure::read('prefix').'roles');
	}
	//获取总的记录条数 
	function getcount($data){
		$where = $this->getWhere($data);
		$sql = "SELECT count(1) as count FROM ".Configure::read('prefix')."roles   WHERE ".$where;
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
		$res = $this->query($sql);
		$res = cakeRstoRs($res,$table);
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
		if(!empty($data['chname'])){
	  			$where .= " and channelname = '".$data['chname']."'";
	  		}
		return $where;
	}
	/**
	 * 查询角色列表信息
	 */
	function getLists()
	{
		$fields = 'id,pid,func_desc,action_name,update_time,is_menu,controller,pmenu';
		$sql = 'SELECT '.$fields.' FROM '.Configure::read('prefix').'funcs WHERE pid=0 ';
		$result = $this->query($sql);
		return  $result;
	}
	/**
	 * 获取功能信息
	 * @param string $fields 查询范围
	 * @param string $condition 查询条件
	 * @return array $res 返回结果信息
	 */
	function getfuncInfo($fields = '*',$table,$condition = '1 = 1')
	{
		$sql = "SELECT $fields FROM ".$table." where $condition";
		$res = $this->query($sql);
		return $res;
	}
	/**
	 * 添加权限
	 * $rid:角色id
	 * $fid：功能id
	 */
	function rolefadd($rid,$fid,$controller,$action)
	{
		$this->isSlave=false;
		$if_exist = $this->addBefore($rid,$fid,$controller,$action);
		if(empty($if_exist))
		{
			$sql = "INSERT INTO ".Configure::read('prefix')."rolefuncs (rid,fid,controller,action_name) VALUES ('$rid','$fid','$controller','$action')";
			$this->query($sql);
		}
	}
	/**
	 * 根据角色id和功能id获取是否存在
	 * @param int 		$rid
	 * @param int 		$fid
	 * @param string 	$controller
	 * @param string	$action
	 */
	function addBefore($rid,$fid,$controller,$action)
	{
		$sql = "SELECT 1 FROM ".Configure::read('prefix')."rolefuncs WHERE rid='$rid' && fid ='$fid'";
		$if_exist = $this->query($sql);
		return $if_exist;
	}

	/**
	 * 删除权限
	 * $rid:角色id
	 * $fid：功能id
	 */
	function del($rid,$fid)
	{
		$sql = "DELETE FROM ".Configure::read('prefix')."rolefuncs WHERE rid='$rid' && fid ='$fid'";
		$this->query($sql);
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
		$sql = "UPDATE ".Configure::read('prefix')."funcs SET $qsql WHERE id='$id'";
		$this->query($sql);
		return $this->getAffectedRows();
	}
	/**
	 * 根据功能fid更新功能信息
	 * $func:修改后的功能信息
	 */
	function update($func)
	{
		$has_funcs = $this->getRoleFuncInfo('fid,controller,action_name','fid ='.$func['id']);
		if(!empty($has_funcs))
		{
			$this->query("UPDATE ".Configure::read('prefix')."rolefuncs SET controller = '$func[controller]',action_name='$func[action_name]' WHERE fid='$func[id]'");
		}
	}
	/**
	 * @param unknown_type $user_roleids
	 * @param unknown_type $pemnu
	 * @return mixed
	 */
	public function contrllSqlSecond($user_roleids,$pemnu)
	{
		$sql = "SELECT distinct b.id,b.controller,b.action_name,b.func_desc FROM ".Configure::read('prefix')."rolefuncs as a,".Configure::read('prefix')."funcs as b ";
		$sql .= "WHERE a.rid in($user_roleids) AND a.fid = b.id AND b.is_menu = 1 AND b.pmenu = '" . $pemnu ['b'] ['id'] . "'";
		//echo $sql;exit;
		$cmenus = $this->query ( $sql );
		return $cmenus;
	}
	/**
	 * 获取到父级角色
	 */
	public function contrllSqlFirst($rid)
	{
		$sql = "SELECT b.id,b.controller,b.action_name,b.func_desc FROM ".Configure::read('prefix')."rolefuncs as a,".Configure::read('prefix')."funcs as b ";
		$sql .= "WHERE a.rid = '$rid' AND a.fid=b.id AND b.is_menu = 1 AND b.pmenu = 0";
		$pmenus = $this->query ( $sql );
		return $pmenus;
	}
	
}
?>