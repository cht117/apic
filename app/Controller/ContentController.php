<?php 
/**
 * 产品管理管理控制器
 */
App::uses('BaseController', 'Controller');
class ContentController extends BaseController {
	public $newstatus = array(
							1=>'已发布',  
							2=>'待审核'
			);
		var $uses= array('Content','News');
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
	/**
	 * 内容管理列表
	 * Enter description here ...
	 */
	function index(){
		$data = isset($this->data)?$this->data:'';
		$params['title']=isset($data['title'])?addslashes(trim($data['title'])):'';
		$params['order']=isset($data['order'])?$data['order']:"id desc";
		$rowsPerPage = $this->pagenum?$this->pagenum:20;
		$currentPage = empty($data['page']) ? 1 : $data['page'];
		$total = $this->Content->getcount($params);
		$searchWhere = $this->deal_url($data);
		$mpurl = $this->base."/Content/index?".$searchWhere;//分页跳转链接
		$start = $this->usePage ( 20, $total, $mpurl );
		$limit = "  limit $start,20 ";
		$list=$this->Content->getList($params,$limit);
		foreach ($list as $key=>$item){
			 $list[$key]['newstatus'] = isset($item['status'])?$this->newstatus[$item['status']]:'';//词条状态
			 $list[$key]['cname'] = $this->News->getAllCateNameById($item['cid']);
			  $list[$key]['navname'] = $this->Content->getAllNavNameById($item['rid']);
			 $uname = $this->Content->checkinfo(Configure::read('prefix').'members','nickname',array('uid'=>$item['uid'])); 
			 $list[$key]['uname'] = isset($uname[0]['nickname'])?$uname[0]['nickname']:'';
		}
		$this->set('list',$list);
		$this->set('data',$data);
		$this->set('currentNav','内容管理 > 内容列表');
	}
	/**
	 * 发布内容
	 */
	function add(){
	 	$data = isset($this->data)?$this->data:'';
	    if($_SERVER['REQUEST_METHOD']=='POST'){
	    	 echo json_encode($this->Content->addContent($data,$this->loginMemberData['uid']));
	    	 exit();
	    }else{
	    	$this->set("list", $this->News->category($data,$_POST)); //获取分类
	    	$this->set('proinfo',$this->Content->Product($data));//获取栏目
	    	if(!empty($data['coid'])){
	    		$list = $this->Content->checkinfo(Configure::read('prefix').'contents','*',array('id'=>$data['coid']));
	    		$this->set("info",$list[0]);
	    	}
	    	$this->set('data',$data);
			$this->set('currentNav','产品管理 > 发布产品');
	    }
	}
	/**
	 * 检测标题是否成立
	 */
	function checkContentTitle(){
		$data = isset($this->data)?$this->data:'';
	 	$where = array('title'=>addslashes($data['title']));
        if(empty($data['title'])){
            echo json_encode(array("status" => 0, "info" => "请输入标题"));
            exit();
        }
        $checktitle = $this->News->checkinfo(Configure::read('prefix').'contents','*',$where);
        if (!empty($checktitle)) {
            echo json_encode(array("status" => 0, "info" => "已经存在，请修改标题"));
            exit();
        } else {
            echo json_encode(array("status" => 1, "info" => "可以使用"));
            exit();
        }
	}
	/**
	 * 设置推荐
	 * Enter description here ...
	 */
 	function changeAttr(){
 		$data = $this->data?$this->data:'';
        $where = rand(1, 9)." and id=".$data['coid'];
        $config['is_recommend'] = $data['types']?'0':'1';
      	$editattr = $this->Content->modify($config,Configure::read('prefix').'contents',$where);
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
    	$where = rand(1, 9)." and id=".$data['coid'];
        $config['status'] = $data['types']==1?'2':'1';
      	$editattr = $this->Content->modify($config,Configure::read('prefix').'contents',$where);
        if($editattr){
            echo json_encode(array("status" => 1, "info" => $this->newstatus[$config['status']]));
            exit;
        }
    }
	/**
	 * 删除新闻
	 */
	function del(){
		$data = $this->data?$this->data:'';
		$nid = $data['coid'];
		if(!$nid){exit('Error...');}
		$where = rand(1, 9)." and id = ".$nid;
		$del = $this->Content->del(Configure::read('prefix').'contents',$where);
		$backurl = Configure::read('ROOTURL')."Content/index";
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