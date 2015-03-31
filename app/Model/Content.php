<?php 
App::uses('AppModel', 'Model');
/**
 * Content  Model
 */
class Content extends AppModel {
	var $name = 'contents';
	var $tablePrefix = 'sxy_';
/**
	 * 查询列表
	 */
	function  getlist($addarr,$limit=''){
		$where = $this->getWhere($addarr);
		$sql = "select * from ".Configure::read('prefix')."contents where ".$where;
		$sql.=$limit;
		$res = $this->query($sql);
		return  cakeRstoRs($res, Configure::read('prefix').'contents');
	}
	//获取总的记录条数 
	function getcount($data){
		$where = $this->getWhere($data);
		$sql = "SELECT count(1) as count FROM ".Configure::read('prefix')."contents  WHERE ".$where;
		$res = $this->query($sql);
		return $res[0][0]['count'];
	}
	function getWhere($data){
		$where = rand(1,9);
		if(!empty($data['email'])){
	  			$where .= " and email = '".$data['email']."'";
	  	}
		return $where;
	}
	/**
	 * 添加产品
	 */
	function addContent($data,$uid){
		 $adddata = array();
		 $info = $data['info'];
		 $act = $data['act'];
		 if(empty($info['title'])){
	            return array('status' => 0, 'info' => "请输入标题！",'url'=>Configure::read('ROOTURL').'Content/add');
	       }
	      $adddata['cid'] = $info['cid'];
	      $adddata['title'] = addslashes($info['title']);
	      $adddata['status'] = $info['status'];
	      $adddata['keywords'] = $info['keywords'];
	      $adddata['description'] = $info['description'];
	      $adddata['summary'] = $info['summary'];
	      $adddata['content'] = addslashes($info['content']);
	      $adddata['uid'] = $uid;
	      $adddata['rid'] = $info['rid'];
	      $adddata['is_recommend'] = $info['status'];
	      $adddata['image_url'] = $data['image_url'];
		  if ($act == 'add') {//添加分类
		  	 $adddata['create_time'] = time();
		  	 $where = array('title'=>$adddata['title']);
		  	 $checktitle = $this->checkinfo(Configure::read('prefix').'contents','*',$where);
		      if (!empty($checktitle)) {
		      		 return array('status' => 0, 'info' => "已经存在，请修改标题");
		      }
		  	 $addcontent = self::add($adddata,Configure::read('prefix').'contents');
			if($addcontent) {
						$this->addsphinx($adddata['rid'],$addcontent,$adddata['rid'],$adddata);
			            return array('status' => 1, 'info' => "已经发布", 'url'=>Configure::read('ROOTURL').'Content/index');
			      } else {
			            return array('status' => 0, 'info' => "发布失败，请刷新页面尝试操作");
			 }
	      }else{
	      	$where = rand(1, 9)." and id =".$data['coid'];
	      	if(self::modify($adddata,Configure::read('prefix').'contents',$where)) {
	      		$this->editsphinx($adddata,$data['coid']);
			            return array('status' => 1, 'info' => "修改成功", 'url'=>Configure::read('ROOTURL').'Content/index');
			      } else {
			            return array('status' => 0, 'info' => "发布失败，请刷新页面尝试操作");
			 }
	      }
		  
	}
	//递归获取所有栏目名
	function getAllNavNameById($id){
		$cateInfo=self::getnavinfobyid($id);
		$parent_id=$cateInfo[0]['parent_id'];
		$navname=$cateInfo[0]['nav_name'];
		if($parent_id>0){
			$navname=self::getAllNavNameById($parent_id).'>'.$navname;
		}
		return $navname;

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
	 * 添加新闻
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
	/**
	 * 根据id获得栏目信息
	 * @param unknown_type $id
	 * @return Ambigous <multitype:unknown, multitype:unknown >
	 */
	function getnavinfobyid($id){
		$sql="select parent_id,nav_name from ".Configure::read('prefix')."navs where ".rand(1,9)." and  id= '".$id."'";
		$res=$this->query($sql);
		$res=cakeRstoRs($res,Configure::read('prefix').'navs');
		return $res;
	}
}
?>