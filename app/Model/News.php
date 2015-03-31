<?php 
App::uses('AppModel', 'Model');
/**
 * news  Model
 */
class News extends AppModel {
	var $name = 'news';
	var $tablePrefix = 'sxy_';
	
	/**
	 * 查询列表
	 */
	function  getlist($addarr,$limit=''){
		$where = $this->getWhere($addarr);
		$sql = "select * from ".Configure::read('prefix')."news where ".$where." order by id desc";
		$sql.=$limit;
		$res = $this->query($sql);
		return  cakeRstoRs($res, Configure::read('prefix').'news');
	}
	//获取总的记录条数 
	function getcount($data){
		$where = $this->getWhere($data);
		$sql = "SELECT count(1) as count FROM ".Configure::read('prefix')."news   WHERE ".$where;
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
	 * 分类添加操作
	 */
	public function cadd($data)
	{
		$checkname = self::checkinfo(Configure::read('prefix').'category','*',array('name'=>$data['name']));
		if($checkname)
		{
			return 2;
		}
		else{
			if(!$data['id'])
			{
				$res = self::add($data,Configure::read('prefix').'category');
			}
			else {
				$where = rand(1, 9)." and cid =".$data['id'];
				$res = self::modify($data,Configure::read('prefix').'category',$where);
			}
			return res;
		}
		
	}
	
	
	
	
	function category($data,$post){
		if(!empty($data)){
			$act = isset($post['act'])?$post['act']:'';
            $data = isset($post['data'])?$post['data']:'';
            $data['name'] = addslashes(isset($data['name'])?$data['name']:'');
			if ($act == "add") { //添加分类
				if(empty($data['name'])){
			            echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
						echo "<script> alert('分类名称不能为空');window.location='/News/category'</script>";
						exit();
	       		}
				$checkname = self::checkinfo(Configure::read('prefix').'category','*',array('name'=>$data['name']));
                if(empty($checkname)) {
                	if(self::add($data,Configure::read('prefix').'category')){
                		echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
				        echo "<script> alert('已经成功添加到系统中');window.location.href='/News/category'</script>";
				        exit();
                	}else{
                		echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
				        echo "<script> alert('添加失败');window.location.href='/News/category'</script>";
				        exit();
                	}
                   // return (self::add($data,Configure::read('prefix').'category')) ? array('status' => 1, 'info' => '分类 ' . $data['name'] . ' 已经成功添加到系统中', 'url'=>Configure::read('ROOTURL').'News/category') : array('status' => 0, 'info' => '分类 ' . $data['name'] . ' 添加失败','url'=>Configure::read('ROOTURL').'News/category');
                } else {
                	 echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
				     echo "<script> alert('系统中已经存在分类');window.location='/News/category'</script>";
				     exit();
                }
            } else if ($act == "edit") { //修改分类
                if (empty($data['name'])) {
                    unset($data['name']);
                }
                if ($data['pid'] == $data['cid']) {
                    unset($data['pid']);
                }
                return ($M->save($data)) ? array('status' => 1, 'info' => '分类 ' . $data['name'] . ' 已经成功更新', 'url' => U('News/category', array('time' => time()))) : array('status' => 0, 'info' => '分类 ' . $data['name'] . ' 更新失败');
            }else if ($act == "del") { //删除分类
                unset($data['pid'], $data['name']);
                return ($M->where($data)->delete()) ? array('status' => 1, 'info' => '分类 ' . $data['name'] . ' 已经成功删除', 'url' => U('News/category', array('time' => time()))) : array('status' => 0, 'info' => '分类 ' . $data['name'] . ' 删除失败');
            }else{
            	$catedata = self::checkinfo(Configure::read('prefix').'category','*',array('pid'=>0));
            	$newdata = $this->filterdata($catedata,'pid','category');
				return $newdata;
            }
		}else{
			$catedata = self::checkinfo(Configure::read('prefix').'category','*',array('pid'=>0));
			$newdata = $this->filterdata($catedata,'pid','category');
			return $newdata;
		}
	}
	/**
	 * 添加新闻
	 */
	function addNews($data,$uid){
	 $adddata = array();
	 $info = $data['info'];
	 $act = $data['act'];
	 if(empty($info['title'])){
            return array('status' => 0, 'info' => "请输入标题！",'url'=>Configure::read('ROOTURL').'News/add');
        }
      $adddata['cid'] = isset($info['cid'])?$info['cid']:0;
      $adddata['title'] = addslashes($info['title']);
      $adddata['status'] = $info['status'];
      $adddata['keywords'] = $info['keywords'];
      $adddata['description'] = $info['description'];
      $adddata['summary'] = $info['summary'];
      $adddata['sucess'] = $info['sucess'];
      $adddata['error'] = $info['error'];
      $adddata['content'] = addslashes($info['content']);
      $adddata['uid'] = $uid;
      $adddata['is_recommend'] = $info['status'];
      $adddata['img_url'] = $data['image_id'];
      if ($act == 'add') {//添加新闻
        $where = array('title'=>$adddata['title']);
      	$checktitle = $this->checkinfo(Configure::read('prefix').'news','*',$where);
	      if (!empty($checktitle)) {
	      		 return array('status' => 0, 'info' => "已经存在，请修改标题");
	      }
        $adddata['create_time'] = time();
      	$addnews = self::add($adddata,Configure::read('prefix').'news');
	      if($addnews){ //并且添加sphinx 数据源信息。
	      		 $this->addsphinx(1,$addnews,1,$adddata);
	            return array('status' => 1, 'info' => "已经发布", 'url'=>Configure::read('ROOTURL').'News/index');
	        } else {
	            return array('status' => 0, 'info' => "发布失败，请刷新页面尝试操作");
	    }
      }elseif ($act == 'edit'){
      		$where = rand(1, 9)." and id =".$data['nid'];
	      	if(self::modify($adddata,Configure::read('prefix').'news',$where)) {
	      		$this->editsphinx($adddata,$data['nid']);
			            return array('status' => 1, 'info' => "修改成功", 'url'=>Configure::read('ROOTURL').'News/index');
			  } else {
			         return array('status' => 0, 'info' => "发布失败，请刷新页面尝试操作");
		}
      }
	   return array('status' => 0, 'info' => "添加失败,请联系管理员");
	}
	/**
	 * 添加分类
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
	
	//递归获取所有分类名
	function getAllCateNameById($id){
		$cateInfo=self::getcateinfobyid($id);
		$parent_id=$cateInfo[0]['pid'];
		$catename=$cateInfo[0]['name'];
		if($parent_id>0){
			$catename=self::getAllCateNameByid($parent_id).'>'.$catename;
		}
		return $catename;

	}
	/**
	 * 根据id获得分类信息
	 * @param unknown_type $id
	 * @return Ambigous <multitype:unknown, multitype:unknown >
	 */
	function getcateinfobyid($id){
		$sql="select pid,name,status from ".Configure::read('prefix')."category where ".rand(1,9)." and  cid= '".$id."'";
		$res=$this->query($sql);
		$res=cakeRstoRs($res,Configure::read('prefix').'category');
		return $res;
	}
	/**
	 * 修改操作
	 */
	function modify($fields,$tab,$con='1')
	{
		$sqlk = $sqlv = '';
		$sqlArr = array();
		$i = 0;
		foreach($fields as $k=>$v)
		{
			$sqlArr[$i]= "`".$k."`='".$v."'";
			$i++;
		}
		$field = implode(",", $sqlArr);
		  $sql = "UPDATE $tab SET ".$field." WHERE $con";
		$rows = $this->query($sql);
		return TRUE;
	}
}
?>