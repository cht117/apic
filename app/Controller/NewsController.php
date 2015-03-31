<?php 
/**
 * 网站咨询管理控制器
 */
App::uses('BaseController', 'Controller');
App::import ( 'Vendor', 'uploadfile' );
class NewsController extends BaseController {
		public $newstatus = array(
						1=>'已发布',  
						2=>'待审核'
		);
		var $uses= array('News','Member');
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
		$params['title']=isset($data['title'])?addslashes(trim($data['title'])):'';
		$params['order']=isset($data['order'])?$data['order']:"id desc";
		$rowsPerPage = $this->pagenum?$this->pagenum:20;
		$currentPage = empty($data['page']) ? 1 : $data['page'];
		$total = $this->News->getcount($params);
		$searchWhere = $this->deal_url($data);
		$mpurl = $this->base."/News/index?".$searchWhere;//分页跳转链接
		$start = $this->usePage ( 20, $total, $mpurl );
		$limit = "  limit $start,20 ";
		$list=$this->News->getList($params,$limit);
		foreach ($list as $key=>$item){
			 $list[$key]['newstatus'] = isset($item['status'])?$this->newstatus[$item['status']]:'';//词条状态
			 $list[$key]['cname'] = $this->News->getAllCateNameById($item['cid']);
			 $uname = $this->News->checkinfo(Configure::read('prefix').'members','nickname',array('uid'=>$item['uid'])); 
			 $list[$key]['uname'] = $uname[0]['nickname'];
		}
		$this->set('list',$list);
		$this->set('data',$data);
		$this->set('currentNav','资讯管理 > 资讯列表');
	}
	
	/**
	 * 发布新闻
	 */
	function add(){
	    $data = isset($this->data)?$this->data:'';
	    if($_SERVER['REQUEST_METHOD']=='POST'){
	    	 echo json_encode($this->News->addNews($data,$this->loginMemberData['uid']));
	    	 exit();
	    }else{
	    	$this->set("list", $this->News->category($data,$_POST));
	    	if(!empty($data['nid'])){
	    		$list = $this->News->checkinfo(Configure::read('prefix').'news','*',array('id'=>$data['nid']));
	    		$this->set("info",$list[0]);
	    	}
			$this->set('data',$data);
			$this->set('currentNav','资讯管理 > 添加编辑新闻');
	    }
	}
	/**
	 * 新闻分类管理
	 */
	function category(){
		$data = isset ( $this->data ) ? $this->data : '';
		// $params['chname']=isset($data['chname'])?addslashes(trim($data['chname'])):'';
		// $params['order']=isset($data['order'])?$data['order']:"id asc";
		$total = $this->News->getcount ( $params );
		$searchWhere = $this->deal_url ( $data );
		$mpurl = $this->base . "/News/category?" . $searchWhere; // 分页跳转链接
		$start = $this->usePage ( $this->pagenum, $total, $mpurl );
		$limit = "  limit $start,".$this->pagenum;
		$list = $this->News->getList ( $params, $limit );
		$this->set ( 'list', $list );
		$this->set ( 'data', $data );
		
		
		

	}
	function cadd(){
	if ($_SERVER ['REQUEST_METHOD'] == 'POST') {
			$func_data = $this->data ? $this->data : '';
			var_dump($func_data);exit;
			$msg = '';
			$res = $this->News->cadd( $func_data); /* 添加功能 */
			var_dump($res);exit;
			if (! $func_data ['id']) {
				
				$msg = '添加';
			} else {
				$msg = '修改';
			}
			if ($res==1) {
				echo json_encode ( array (
						"status" => 1,
						"info" => $msg . "成功",
						'url' => Configure::read ( 'ROOTURL' ) . 'News/category'
				) );
				exit ();
			}elseif ($res==2) {
				echo json_encode ( array (
						"status" => 1,
						"info" => "分类已经存在",
						'url' => Configure::read ( 'ROOTURL' ) . 'News/category'
				) );
				exit ();
			}  
			
			else {
				echo json_encode ( array (
						"status" => 0,
						"info" => $msg . "失败",
						'url' => Configure::read ( 'ROOTURL' ) . 'News/category'
				) );
				exit ();
			}
		} else {
			//echo 222;exit;
			//var_dump($func_data);exit;
			$id  = isset($_REQUEST ['id'])?intval($_REQUEST ['id']):0;
			//echo $id;exit;
			if ($id ) {
				$list = $this->News->checkinfo ( Configure::read ( 'prefix' ) . 'category', '*', array (
						'id' => $id
				) );
				$this->set ( "info", $list [0] );
			}
		}
	
	}
	
	
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
				$return['error']= 0;
				$return['url'] = $strImageUrl;
	       	 }else {
	        	@unlink($file['tmp_name']);
	        	$return['message'] = '对不起, 图片未上传成功';
	        	$return['state']    = '';
	        	}    
            }
        }
	    del_dir($this->getSavePath());
        echo json_encode( $return );
        exit;
	}
	/**
	 * 检查文章标题是否合法
	 */
	function checkNewsTitle(){
		$data = isset($this->data)?$this->data:'';
	 	$where = array('title'=>addslashes($data['title']));
        if(empty($data['title'])){
            echo json_encode(array("status" => 0, "info" => "请输入标题"));
            exit();
        }
        $checktitle = $this->News->checkinfo(Configure::read('prefix').'news','*',$where);
        if (!empty($checktitle)) {
            echo json_encode(array("status" => 0, "info" => "已经存在，请修改标题"));
            exit();
        } else {
            echo json_encode(array("status" => 1, "info" => "可以使用"));
            exit();
        }
	}
	/**
	 * 删除新闻
	 */
	function del(){
		$data = $this->data?$this->data:'';
		$nid = $data['nid'];
		if(!$nid){exit('Error...');}
		$where = rand(1, 9)." and id = ".$nid;
		$del = $this->Member->del(Configure::read('prefix').'news',$where);
		$backurl = Configure::read('ROOTURL')."News/index";
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
	 * 设置推荐
	 * Enter description here ...
	 */
 	function changeAttr(){
 		$data = $this->data?$this->data:'';
        $where = rand(1, 9)." and id=".$data['nid'];
        $config['is_recommend'] = $data['types']?'0':'1';
      	$editattr = $this->News->modify($config,Configure::read('prefix').'news',$where);
        if($editattr){
            echo json_encode(array("status" => 1, "info" =>'<img src=/img/action_'.$config['is_recommend'].'.png border="0">'));
            exit;
        }
        return false;
    }
    /**
     * 设置状态
     */
    function changestatus(){
    	$data = $this->data?$this->data:'';
    	$where = rand(1, 9)." and id=".$data['nid'];
        $config['status'] = $data['types']==1?'2':'1';
      	$editattr = $this->News->modify($config,Configure::read('prefix').'news',$where);
        if($editattr){
            echo json_encode(array("status" => 1, "info" => $this->newstatus[$config['status']]));
            exit;
        }
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