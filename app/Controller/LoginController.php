<?php 
App::uses('BaseController', 'Controller');
class LoginController extends BaseController {
	
	var $uses = array('Member');
	
	var $components = array('Userlogin','Cookie');
	
	function index(){
		$this->layout="";
		$username  = $this->get_cookies('sxy_name',1);
		if(empty($username)){
			return false;
		}
		$right_menu = array_slice($this->right_menu,0,1);
		if(!empty($right_menu) ){
			/*	跳转到第一个菜单	*/
			$this->redirect(array('controller' => 'Backstage', 'action' => 'index'));//跳转到登录页
		}else{
			$errorurl = Configure::read('ROOTURL').'login';
			$this->redirect($errorurl);
		}
	}
	
	function login(){
		 $post = isset($this->data)?$this->data:'';
		 $username = $post['username']?$post['username']:exit(0);
		 $pwd=$this->encrypt($post['pwd']);
		 $memberData = array();
		 if(!empty($post)){
		 	$udata  = $this->Member->getudata($username,$pwd);	
		 	if(empty($udata)){
		 		 echo json_encode(array("status" => 0, "info" => "账号密码错误！"));
		 		 exit;
		 	}
		 	if($pwd!=$udata[0]['pwd']){
		 		 echo json_encode(array("status" => 0, "info" => "密码错误！"));
		 		 exit;
		 	}
		 	$memberData['user_id'] = $udata[0]['uid'];
			$memberData['user_name'] = $udata[0]['email'];
		    $resultCode = $this->Userlogin->doLogin($username,$pwd,$memberData,$this->cookieConfig);
		    if($resultCode == 1) {
		    	 echo json_encode(array("status" => 200, "info" => "登录成功"));
		    	 exit;
		    }
		 }
	}
	function logout(){
	/*	同步退出写入退出登录cookies	*/
		$data = isset($this->data)?$this->data:'';
		$this->Userlogin->logout($this->cookieConfig);
		if($data['type']=='zmz'){
			$errorurl = Configure::read('ROOTURL').'User/index';
			$this->redirect($errorurl);
		}else{
			$this->redirect($this->webroot);
		}
	}
}
?>