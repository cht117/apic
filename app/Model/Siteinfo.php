<?php 
App::uses('AppModel', 'Model');
/**
 * Siteinfo  Model
 */
class Siteinfo extends AppModel {
	
	var $name = 'navs';
	var $tablePrefix = 'sxy_';
	
	/**
	 * 查询列表Siteinfo
	 */
	function  getlist($addarr,$table,$limit=''){
		$where = $this->getWhere($addarr,$table);
		$field = 'id,nav_name,parent_id as pid,module,action,create_time,update_time,status';
		$sql = "select ".$field." from ".Configure::read('prefix').$table ." where ".$where;
		$res = $this->query($sql);
		$info =  cakeRstoRs($res, Configure::read('prefix').$table);
		$data = $this->tree($info,0);
		return $data;
	}
	/**
	 * 轮播总的条数
	 **/
	 function carousel($addarr,$limit=''){
		$where = $this->getWhere($addarr,'ads');
		$sql = "select * from ".Configure::read('prefix')."ads where ".$where;
		$sql.=$limit;
		$res = $this->query($sql);
		return  cakeRstoRs($res, Configure::read('prefix').'ads');
	 }
	//获取总的记录条数 
	function getcount($data,$table){
		$where = $this->getWhere($data,$table);
		$sql = "SELECT count(1) as count FROM ".Configure::read('prefix').$table." WHERE ".$where;
		$res = $this->query($sql);
		return $res[0][0]['count'];
	}
	
	function getWhere($data,$table){
		$where = rand(1,9);
		if(!empty($data['email'])){
	  			$where .= " and email = '".$data['email']."'";
	  	}
		return $where;
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
	 * 添加导航
	 */
	function addnav($data){
		if(!empty($data)){
			$adddata = array();
			$act = $data['act'];
			if(empty($data['nav_name'])){
				 return array('status' => 0, 'info' => "请输入菜单名称！",'url'=>Configure::read('ROOTURL').'Siteinfo/add');
			}
			 $adddata['nav_name'] = $data['nav_name'];
     		 $adddata['parent_id'] = $data['parent_id'];
     		 $adddata['link'] = $data['link'];
     		 $adddata['target'] = $data['target'];
			if($act == "add"){
				 $adddata['create_time'] = time();
     			 if(self::add($adddata,Configure::read('prefix').'navs')) {
     			 	return array('status' => 1, 'info' => "已经发布", 'url'=>Configure::read('ROOTURL').'Siteinfo/index');
     			 }else{
     			 	return array('status' => 1, 'info' => "发布失败", 'url'=>Configure::read('ROOTURL').'Siteinfo/index');
     			 }
			}else{
				 $adddata['module'] = $data['module'];
     		 	 $adddata['action'] = $data['action'];
				 $where = rand(1, 9)." and id =".$data['id'];
				if(self::modify($adddata,Configure::read('prefix').'navs',$where)) {
					 return array('status' => 1, 'info' => "修改成功", 'url'=>Configure::read('ROOTURL').'Siteinfo/index');
				}else{
					return array('status' => 1, 'info' => "修改失败", 'url'=>Configure::read('ROOTURL').'Siteinfo/index');
				}
			}
		}
		return false;
	}
	/**
	 * 去他大爷的，啥几把玩意。。。。冗余代码吧，不他么封装了，整合方法了。。  
	 * 添加轮播图
	 */
	function addad($data,$uid){
			if($data){
				$adddata = array();
				$act = $data['act'];
				$info = $data['info'];
				$adddata['ad_name'] = $info['ad_name'];
	     		$adddata['ad_link'] = $info['ad_link'];
	     		$adddata['ad_img'] =  $info['ad_img'];
	     		$adddata['uid'] = $uid;
			if($act == "add"){
				 $adddata['create_time'] = time();
     			 if(self::add($adddata,Configure::read('prefix').'ads')) {
     			 	return array('status' => 1, 'info' => "成功发布", 'url'=>Configure::read('ROOTURL').'Siteinfo/adindex');
     			 }else{
     			 	return array('status' => 1, 'info' => "发布失败", 'url'=>Configure::read('ROOTURL').'Siteinfo/adindex');
     			 }
			}else{
				 $where = rand(1, 9)." and id =".$data['id'];
				if(self::modify($adddata,Configure::read('prefix').'ads',$where)) {
					 return array('status' => 1, 'info' => "修改成功", 'url'=>Configure::read('ROOTURL').'Siteinfo/adindex');
				}else{
					return array('status' => 1, 'info' => "修改失败", 'url'=>Configure::read('ROOTURL').'Siteinfo/adindex');
				}
			}
		}
			return false;
	}
	/**
	 * 添加导航
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