<?php 
App::uses('BaseController', 'Controller');
class AccessController extends BaseController {
	
	  var $uses= array('Roles','Member');
	  public $newstatus = array(
						1=>'启用',  
						2=>'禁用'
		);
	  function index(){
	  	$data = isset($this->data)?$this->data:'';
		$params['chname']=isset($data['chname'])?addslashes(trim($data['chname'])):'';
		$params['order']=isset($data['order'])?$data['order']:"id asc";
		$rowsPerPage = $this->pagenum?$this->pagenum:20;
		$currentPage = empty($data['page']) ? 1 : $data['page'];
		$total = $this->Roles->getcount($params);
		$searchWhere = $this->deal_url($data);
		$mpurl = $this->base."/Roles/index?".$searchWhere;//分页跳转链接
		$start = $this->usePage ( 20, $total, $mpurl );
		$limit = "  limit $start,20 ";
		$list=$this->Roles->getList($params,$limit);
		foreach ($list as $key=>$item){
			 $list[$key]['newstatus'] = isset($item['status'])?$this->newstatus[$item['status']]:'';//词条状态
		}
		$this->set('list',$list);
		$this->set('data',$data);
	  	$this->set('currentNav','权限管理 >管理员列表');
	  }
	  /**
	   * 添加角色
	   */
	  function addrole(){
	  	$data = $this->data?$this->data:'';
	  	if($_SERVER['REQUEST_METHOD']=='POST'){
			$name = isset($this->data['role_name'])?$this->data['role_name']:'';
			$status = isset($this->data['status'])?$this->data['status']:'';
			$remark = isset($this->data['remark'])?$this->data['remark']:'';
			$pid = isset($this->data['pid'])?$this->data['pid']:'';
			$data['create_time'] = time();
			if(empty($name)){
				echo json_encode(array("status" => 0, "info" => "角色组名称不能为空"));
				exit;
			}
			if(empty($pid)){
				echo json_encode(array("status" => 0, "info" => "父级组ID不能为空"));
				exit;
			}
	  	    if($this->Roles->add($data,Configure::read('prefix').'roles')){
               echo json_encode(array("status" => 1, "info" => "添加成功",'url'=>Configure::read('ROOTURL').'/Access/index'));
               exit;
            }else{
               echo json_encode(array("status" => 0, "info" => "添加会员失败"));
               exit;
            }
	  	}else{
	  		$data = isset ( $_REQUEST ) ? $_REQUEST : '';
	  		$roldata = $this->Roles->checkinfo(Configure::read('prefix').'roles','*');
			$this->set('roldata',$roldata);
	  		$this->set('data',$data);
	  	}
	  	$this->set('currentNav','权限管理 > 添加编辑角色');
	  }
	  /**
	   * 节点管理
	   */
	  function nodelist(){
	  	$data = $this->data?$this->data:'';
	  	$lists = $this->Roles->getLists();		/*	查询所有的功能列表	*/
		foreach($lists as $k=>$v){
			/*	取出所有的父级功能	*/
			if($v[Configure::read('prefix').'funcs']['is_menu'] && $v[Configure::read('prefix').'funcs']['pmenu']){
				$pinfo = $this->Roles->getfuncInfo('func_desc',Configure::read('prefix').'funcs','id='.$v[Configure::read('prefix').'funcs']['pmenu']);	
				$lists[$k][Configure::read('prefix').'funcs']['pmenu_name'] = $pinfo[0][Configure::read('prefix').'funcs']['func_desc'];
			}
			/*	取出所有的二级功能	*/
			$clists = $this->Roles->getfuncInfo('*',Configure::read('prefix').'funcs','pid = '.$v[Configure::read('prefix').'funcs']['id']);
			foreach($clists as $ck=>$clist){
				if($clist[Configure::read('prefix').'funcs']['is_menu'] && $clist[Configure::read('prefix').'funcs']['pmenu']){
					$client_info = $this->Roles->getfuncInfo('func_desc',Configure::read('prefix').'funcs','id='.$clist[Configure::read('prefix').'funcs']['pmenu']);
					$clists[$ck][Configure::read('prefix').'funcs']['pmenu_name'] = $client_info[0][Configure::read('prefix').'funcs']['func_desc'];
				}
			}
				/*	组成新列表显示在前台	*/
				$lists[$k]['cinfo'] = $clists;
		}
		$this->set('funcs', $lists);
	  	$this->set('currentNav','权限管理 > 节点管理');
	  }
	  /**
	 * 添加功能
	 * @return void
	 */
	  function add(){
	  	if($_SERVER['REQUEST_METHOD']=='POST'){	
	  		$func_data = $this->data?$this->data:'';
	  		$func_data['create_time'] = time();	
			$func_data['pmenu'] = $this->data['is_menu'] == 1 ? $this->data['pmenu']:0;
			if(trim($func_data['func_desc']) == ''){
				echo json_encode(array("status" => 0, "info" => "功能名称不能为空!"));
				exit;
			}
			if(trim($func_data['controller']) == ''){
				echo json_encode(array("status" => 0, "info" => "控制器不能为空!"));
				exit;
			}
			$func_data['pid'] = $func_data['pmenu'];
			$res = $this->Roles->add($func_data,Configure::read('prefix').'funcs');	/*	添加功能		*/
			if($res){
				 echo json_encode(array("status" => 1, "info" => "添加成功",'url'=>Configure::read('ROOTURL').'Access/nodelist'));
				 exit;
			}else{
				 echo json_encode(array("status" => 0, "info" => "添加失败",'url'=>Configure::read('ROOTURL').'Access/nodelist'));
				 exit;
			}
	  	}else{
	  		$func_lists = $this->Roles->getfuncInfo('id,func_desc',Configure::read('prefix').'funcs','pid=0');
			$this->set('func_lists',$func_lists);
	  	}
	  	$this->set('currentNav','权限管理 > 添加模块');
	  }
	  /**
	   * 权限分配
	   */
	  function changerole(){
	  	$data = $this->data?$this->data:'';
	  	if($_SERVER['REQUEST_METHOD']=='POST'){	
	  		$data =$this->data['rights'];
	  		foreach($data as $k=>$v){
	  			
				$role_funcs_array = array();
	  			$role_funcs = $this->Roles->getfuncInfo('fid',Configure::read('prefix').'rolefuncs','rid='.$k);
				foreach($role_funcs as $rv)
				{
					$role_funcs_array[] = $rv[Configure::read('prefix').'rolefuncs']['fid'];
				}
	  		if(is_array($v)){
					//循环所有的父级功能
					foreach($v as $ck=>$cv)
					{
						if(in_array($ck,$role_funcs_array))
						{
							//与原有权限比较，修改后与原有权限相同的则不做任何操作，不一致的则保留最后统一删除
							$arr_key_ck = array_keys($role_funcs_array,$ck);
							unset($role_funcs_array[$arr_key_ck[0]]);
						}else{
							$ck_info = $this->Roles->getfuncInfo('controller,action_name',Configure::read('prefix').'funcs','id ='.$ck);
							$this->Roles->rolefadd($k,$ck,$ck_info[0][Configure::read('prefix').'funcs']['controller'],$ck_info[0][Configure::read('prefix').'funcs']['action_name']);
						}
						//循环所有的子功能
						if(is_array($cv))
						{
							foreach($cv as $chk=>$chv)
							{
								if(in_array($chk,$role_funcs_array))
								{
									//已添加的权限保留，未添加的权限最后统一删除
									$arr_key_chk = array_keys($role_funcs_array,$chk);
									unset($role_funcs_array[$arr_key_chk[0]]);
								}else{
									$chk_info = $this->Roles->getfuncInfo('controller,action_name',Configure::read('prefix').'funcs','id ='.$chk);
									$this->Roles->rolefadd($k,$chk,$chk_info[0][Configure::read('prefix').'funcs']['controller'],$chk_info[0][Configure::read('prefix').'funcs']['action_name']);
								}
							}
						}
					}
				}
	  		//修改后的权限与原权限相比较，修改后不存在原有权限存在的则删除
				if(!empty($role_funcs_array))
				{
					foreach($role_funcs_array as $dv)
					{
						$this->Roles->del($k,$dv);
					}
				}
			}
	 		$backurl = Configure::read('ROOTURL')."Access/index";
			echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
			echo "<script> alert('修改成功');window.location='".$backurl."'</script>";
			exit();
	  	}else{
	  		//获取所有的角色名称
			$role_lists = $this->Roles->getfuncInfo('id,role_name',Configure::read('prefix').'roles','id='.$data['ids']);
	  		//获取所有的父功能，并把对应的子功能查找出来(便于显示树状列表)
			$func_lists = $this->Roles->getfuncInfo('id,pid,func_desc',Configure::read('prefix').'funcs','pid=0');
			foreach($func_lists as $fk=>$fv){
				$clists = $this->Roles->getfuncInfo('id,pid,func_desc',Configure::read('prefix').'funcs','pid = '.$fv[Configure::read('prefix').'funcs']['id']);
				$func_lists[$fk]['cinfo'] = $clists;
			}
	  		foreach($role_lists as $k=>$v){
			$role_lists[$k]['func'] = $func_lists ;
				//根据角色获取所有的功能id,并循环
				$funcs = $this->Roles->getfuncInfo('fid',Configure::read('prefix').'rolefuncs','rid='.$v[Configure::read('prefix').'roles']['id']);
				foreach($funcs as $func){
					foreach($func_lists as $flk=>$flv){
						//判断是否拥有父功能的权限
						if($flv[Configure::read('prefix').'funcs']['id'] == $func[Configure::read('prefix').'rolefuncs']['fid']){
							$role_lists[$k]['func'][$flk][Configure::read('prefix').'funcs']['has_right'] = 1;
						}
						//判断是否拥有子功能的权限
						foreach($flv['cinfo'] as $fck=>$fcv){
							if($fcv[Configure::read('prefix').'funcs']['id'] == $func[Configure::read('prefix').'rolefuncs']['fid']){
								
								$role_lists[$k]['func'][$flk]['cinfo'][$fck][Configure::read('prefix').'funcs']['has_right'] = 1;
							}
						}
					}
					
				}
			}
	  		$rolename = $this->Roles->checkinfo(Configure::read('prefix').'roles','role_name',array('id'=>$data['ids']));
			$this->set('rolename',$rolename[0]);
			$this->set('roleFuncs', $role_lists);
	  	}	
	  	$this->set('currentNav','权限管理 > 权限分配');
	  }
	  /**
	   * 后台管理员
	   */
	  function backuser(){
	  	$data = isset ( $_REQUEST ) ? $_REQUEST : '';
		$params['email']=isset($data['email'])?addslashes(trim($data['email'])):'';
		$params['order']=isset($data['order'])?$data['order']:"id desc";
		$params['status'] = 1;
		$rowsPerPage = $this->pagenum?$this->pagenum:20;
		$currentPage = empty($data['page']) ? 1 : $data['page'];
		$total = $this->Member->getcount($params);
		$searchWhere = $this->deal_url($data);
		$mpurl = $this->base."/Access/index?".$searchWhere;//分页跳转链接
		$start = $this->usePage ( 20, $total, $mpurl );
		$limit = "  limit $start,20 ";
		$list=$this->Member->getList($params,$limit);
		$this->set('list',$list);
		$this->set('data',$data);
		$this->set('currentNav','权限管理 > 后台管理员');
	  }
	  /**
	   * 添加后台用户
	   */
	  function addbackuser(){
	  		if($_SERVER['REQUEST_METHOD']=='POST'){
			$data = $this->data['info']?$this->data['info']:'';
			$email = $this->Member->checkinfo(Configure::read('prefix').'members','email',array('email'=>$data['email']));
	 		if(!empty($email)){
             		echo json_encode(array("status" => 0, "info" => "邮箱地址已存在！"));
             		exit;
         	}
		    if(!is_email($data['email'])){
               echo json_encode(array("status" => 0, "info" => "邮箱格式错误！"));
               exit;
           	}
			if($data['pwd']){
                if(getStringLength($data['pwd'])<6){
                    echo json_encode(array("status" => 0, "info" => "密码少于6位！"));
                    exit;
                }
                $data['pwd']=encrypt($data['pwd']);
            }else{
                 echo json_encode(array("status" => 0, "info" => "请输入密码！"));
                exit;
            }
            $data['status'] = 1;
            if($this->Member->add($data)){
                    echo json_encode(array("status" => 1, "info" => "添加会员成功",'url'=>Configure::read('ROOTURL').'Access/backuser'));
                    exit;
             }else{
                   echo json_encode(array("status" => 0, "info" => "添加会员失败"));
                    exit;
             }
		 }else{
			$data = isset ( $_REQUEST ) ? $_REQUEST : '';
			$roldata = $this->Roles->checkinfo(Configure::read('prefix').'roles','id,role_name');
			$this->set('roldata',$roldata);
			$this->set('data',$data);
		 }
	  }
	/**
	 * 修改会员
	 */
	function edit(){
		if($_SERVER['REQUEST_METHOD']=='POST'){
			$data = $this->data['info']?$this->data['info']:'';
		if($data['pwd']){
                if(getStringLength($data['pwd'])<6){
                    echo json_encode(array("status" => 0, "info" => "密码少于6位！"));
                    exit;
                }
                $data['pwd']=encrypt( $data['pwd']);
            }else{
                unset($data['pwd']);
            }
           $where = rand(1, 9)." and uid = ".$this->data['uid'];
		   if($this->Member->modify($data,Configure::read('prefix').'members',$where)){
                  echo json_encode(array("status" => 1, "info" => "修改会员成功",'url'=>Configure::read('ROOTURL').'Member/index'));
                  exit;
           }else{
                  echo json_encode(array("status" => 0, "info" => "修改会员失败"));
                  exit;
           }
		}else{
			$data = isset ( $_REQUEST ) ? $_REQUEST : '';
			$editdata = $this->Member->checkinfo(Configure::read('prefix').'members','*',array('uid'=>$data['uid']));
			$this->set('editdata',$editdata[0]);
			$this->set('data',$data);
			$this->set('currentNav','权限管理 > 编辑会员');
		}
	}
	/**
	 * 节点修改
	 */
	function funcedit(){
		$data = isset($this->data)?$this->data:'';
		if($_SERVER['REQUEST_METHOD']=='POST'){
			$func_data = $this->data;
			$func_data['pmenu'] = $this->data['is_menu'] == 1 ? $this->data['pmenu']:0;	
			$func_data['is_menu'] = $this->data['is_menu'] == 1 ? 1:0;
			if(trim($func_data['func_desc']) == ''){
				 	echo json_encode(array("status" => 0, "info" => "功能名称不能为空"));
                    exit;
			}
			if(trim($func_data['controller']) == ''){
				echo json_encode(array("status" => 0, "info" => "控制器不得为空"));
				exit();
			}
			if (array_key_exists("ids", $func_data)) {
				unset($func_data['ids']);
			}
			$res = $this->Roles->edit($func_data,$this->data['ids']);	/*	编辑功能操作	*/				
			echo json_encode(array("status" => 1, "info" => "修改成功",'url'=>Configure::read('ROOTURL').'Access/nodelist'));
            exit;	
		}else{
			$func_lists = $this->Roles->getfuncInfo('id,func_desc',Configure::read('prefix').'funcs','pid=0');
			$Func_info = $this->Roles->getfuncInfo('*',Configure::read('prefix').'funcs','id='.$data['ids']);							
			$Func_info = cakeRstoRs($Func_info,Configure::read('prefix').'funcs');	
			$this->set('func_lists',$func_lists);
			$this->set('Func_info',$Func_info);
		}
		$this->set('currentNav','权限管理 > 节点修改');
	}
}
?>