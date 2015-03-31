<?php 
/**
 * 网站功能管理控制器
 */
App::uses('BaseController', 'Controller');
App::import ( 'Vendor', 'uploadfile' );
class SiteinfoController extends BaseController {
		public $newstatus = array(
						0=>'正常'
		);
		var $uses= array('Siteinfo');
		public $config = array( //预上线环境
					'cmourl'=>'http://cmo2014.gotoip2.com/test/'
					);
		public $ftplink = array(
							'hostname'=>'125.65.113.13',
							'username'=>'cmo2014',
							'password'=>'zs123456',
							'path'=>'/wwwroot/test/'
							);
		public function beforeFilter(){
				parent::beforeFilter ();
				$this->connftp();
			}
		function index(){
			$data = isset($this->data)?$this->data:'';
			$params['nav_name']=isset($data['nav_name'])?addslashes(trim($data['nav_name'])):'';
			$params['order']=isset($data['order'])?$data['order']:"id asc";
			$rowsPerPage = $this->pagenum?$this->pagenum:20;
			$currentPage = empty($data['page']) ? 1 : $data['page'];
			$total = $this->Siteinfo->getcount($params,'navs');
			$searchWhere = $this->deal_url($data);
			$mpurl = $this->base."/Siteinfo/index?".$searchWhere;//分页跳转链接
			$start = $this->usePage ( 20, $total, $mpurl );
			$limit = "  limit $start,20";
			$list=$this->Siteinfo->getlist($params,'navs',$limit);
			foreach ($list as $key=>$item){
				 $list[$key]['newstatus'] = isset($item['status'])?$this->newstatus[$item['status']]:'';//词条状态
			}
			$this->set('list',$list);
			$this->set('data',$data);
			$this->set('currentNav','菜单管理 > 菜单列表');
		}
	
	/**
	 * 添加导航
	 */
	function add_nav(){
		 $data = $this->data?$this->data:'';
		 $branchs = $this->loginMemberData['roleids'];
		 if($_SERVER['REQUEST_METHOD']=='POST'){
		 	echo json_encode($this->Siteinfo->addnav($data));
	    	exit();
		 }else{
		 	$catedata = $this->Siteinfo->checkinfo(Configure::read('prefix').'navs','id,parent_id as pid,nav_name');
		 	$newdata = $this->tree($catedata);
		 	if(!empty($data['naid'])){
		 		$editdata = $this->Siteinfo->checkinfo(Configure::read('prefix').'navs','*',array('id'=>$data['naid']));
		 		$this->set('info',$editdata[0]);
		 	}
		 	$this->set('currentNav','网站设置 > 添加编辑菜单');
		 	$this->set('data',$data);
		 	$this->set('branchs',$branchs);
		 	$this->set('pinfo',$newdata);
		 }
	}
	/**
	 * 删除导航
	 */
	function del(){
		$data = $this->data?$this->data:'';
		$table = '';
		$types = isset($data['types'])?$data['types']:'';
		switch ($types) {
			 case 'index':
				 $table = 'navs';
				 break;
			 case 'adindex':
			 	 $table = 'ads';
				 break;	 
			default:
  			     $table = 'navs';	
		}
		$naid = $data['naid'];
		if(!$naid){exit('Error...');}
		$where = rand(1, 9)." and id = ".$naid;
		$del = $this->Siteinfo->del(Configure::read('prefix').$table,$where);
		$backurl = Configure::read('ROOTURL')."Siteinfo/index";
		if($del){
			$msg="删除成功";
			echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
			echo "<script> alert('".$msg."');window.location='".$backurl."'</script>";
			exit();
		}else{
			$msg="删除成功";
			echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
			echo "<script> alert('".$msg."');window.location='".$backurl."'</script>";
            exit;
		}
		
	}
		/**
		 *  轮播管理
		 */
		function adindex(){
			$data = isset($this->data)?$this->data:'';
			$params['ad_name']=isset($data['ad_name'])?addslashes(trim($data['ad_name'])):'';
			$params['order']=isset($data['order'])?$data['order']:"id asc";
			$rowsPerPage = $this->pagenum?$this->pagenum:20;
			$currentPage = empty($data['page']) ? 1 : $data['page'];
			$total = $this->Siteinfo->getcount($params,'ads');
			$searchWhere = $this->deal_url($data);
			$mpurl = $this->base."/Siteinfo/index?".$searchWhere;//分页跳转链接
			$start = $this->usePage ( 20, $total, $mpurl );
			$limit = "  limit $start,20 ";
			$list=$this->Siteinfo->carousel($params,$limit);
			foreach ($list as $key=>$item){
				 $list[$key]['newstatus'] = isset($item['status'])?$this->newstatus[$item['status']]:'';//词条状态
				 $uname = $this->Siteinfo->checkinfo(Configure::read('prefix').'members','nickname',array('uid'=>$item['uid'])); 
			 	 $list[$key]['uname'] = $uname[0]['nickname'];
			}
			$this->set('list',$list);
			$this->set('data',$data);
			$this->set('currentNav','网站功能 >轮播管理');
	}
	/**
	 * 添加轮播
	 */
	function addad(){
		$data = $this->data?$this->data:'';
		  if($_SERVER['REQUEST_METHOD']=='POST'){
		  	 	 echo json_encode($this->Siteinfo->addad($data,$this->loginMemberData['uid']));
	    	 	 exit();
		  }else{
		  	$this->set('proinfo',$this->Siteinfo->Product($data));//获取栏目
		  	if(!empty($data['aid'])){
		 		$editdata = $this->Siteinfo->checkinfo(Configure::read('prefix').'ads','*',array('id'=>$data['aid']));
		 		$this->set('info',$editdata[0]);
		 	}
		  }
		 $this->set('data',$data);
	}
	/**
	 * 轮播上传操作
	 * Enter description here ...
	 */
	function Upload(){
		@header("Expires: 0");
        @header("Cache-Control: private, post-check=0, pre-check=0, max-age=0", FALSE);
        @header("Pragma: no-cache");
		$file = $_FILES['imgFile'];
		$return = array();
		$fname = uniqid().'original.jpg';
        $pic_path = $this->getSavePath().$fname;
        if($file ["error"] != 0 || ! is_uploaded_file ( $file ["tmp_name"] )) {
            if ($file ['error'] == 1) {
                $return['message'] = '图片大小只能是小于2M';
                $return['code'] = '0';
            }if(strpos($file['type'],"image")===false){
            	$return['message']='图片只能是JPG/PNG/GIF格式';
            	$return['code'] = '0';
            }
        }else{
       		 if(empty($file)){
            	$return['message'] = '对不起, 图片未上传成功, 请再试一下';
        		$return['code']    = '0';
            }
             $maxsize = 2 * 1024 * 1024;
            $filetype = strtolower ( substr ( $file ["name"], strrpos ( $file ["name"], "." ) + 1, strlen ( $file ["name"] ) ) );
         	if ($file ['size'] > $maxsize) {
         		$return['message']='图片大小只能是小于2M';
         		$return['code'] = '0';
            }elseif(!in_array($filetype,array('jpg','gif','png','JPG','GIF','PNG'))){
            	$return['message']='图片只能是JPG/PNG/GIF格式';
            	$return['code']='0';	
            }else{
            	if(@copy($file['tmp_name'], $pic_path) || @move_uploaded_file($file['tmp_name'], $pic_path)) 
	       	 {
				$strImageUrl = sendFile ( $pic_path,'big', md5_file ( $pic_path ) );
				header('Content-type: text/html; charset=UTF-8');
				$return['img_url'] = $strImageUrl;
				$return['code']= '1';
	       	 }else {
	        	@unlink($file['tmp_name']);
	        	$return['message'] = '对不起, 图片未上传成功';
	        	$return['state']    = '';
	        	}    
            }
        }

      	del_dir($this->getSavePath());
        echo  '<script type="text/javascript" charset="utf-8">top.parent.uploadpic('.json_encode( $return ).')</script>';  	
        exit;
	}
	//ftp连接数 、汉子转拼音连接数
		public function connftp(){
			require_once ('../Vendor/ftp.php');
			$this->ftp = new Ftp();
			$this->ftp->connect($this->ftplink);
		}
		function getSavePath(){
	        $savePath = APP."tmp/original/";
	 		if (! file_exists ( $savePath )) {
	           make_dir($savePath);
	        }
	        return $savePath;
	        
	    }
}
?>