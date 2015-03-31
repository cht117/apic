<?php 
App::uses ( 'AppController', 'Controller' );
App::uses ( 'vendor', 'tools' );
class BaseController extends AppController {
	static public $treeList = array(); //存放无限分类结果如果一页面有多个无限分类可以使用 Tool::$treeList = array(); 清空
	var $admin_big_menu = array();
	
	var $rooturl;
	
	var $data;
	
	var $cookieConfig;
	
	var $glo_roles;			//获取角色列表
	
	var $login_username;
	
	var $glo_rolefuncs;		//获取权限列表
	
	var $memcache;			//memcache实例化
	
	var $right_menu;		//菜单标示
	
	var $pagenum=20;			//全局分页条数

	var $loginMemberData = array();
	
	function globals() {
		$config = Configure::read(strtolower($this->params['controller']));
		// 将配置项作为$this的属性
		if(!empty($config)){
			foreach ($config as $key => $val) {
				$this->$key = $val;
				}
		}
	 /*  $this->ifmemcache = Configure::read('IfMemcache');
		if ($this->ifmemcache == 1) {
			 require_once('Component/MemcacheClass.php');			
			 $memcacheConfig = Configure::read('MemcacheConfig');
			 $this->memcache=new MemcacheClass($memcacheConfig['server'],$memcacheConfig['port']);
		}*/
	}
	/**
	 * 设置页面的静态变量
	 *
	 */
	protected function setViewVars() {
		$this->set($this->params['controller'].'Info', Configure::read($this->params['controller'].'Info'));
		// 当前模块的地址
		$this->set('blockUrl', $this->base.'/'.$this->params['controller']);
		$this->notice = Configure::read('admin_big_menu');
		$this->set ('menu', $this->notice );
		//获取角色信息
		$this->getGlobalRoles();
		//获取权限信息
		$this->getGlobalRoleFuncs();
		$this->login_username = empty($this->login_username)?$this->get_cookies ( Configure::read('prefix').'name',1 ):$this->login_username;
		if (! empty ( $this->login_username )) {
			/* =========用户登录信息============ */
			$logindata = cakeRstoRs ( $this->getLoginMember ($this->login_username), Configure::read('prefix').'members' );
			$this->loginMemberData = $logindata [0];
			/* =========初始化主菜单============ */
			$main_menu = $this->getUserMainMenu($this->loginMemberData ['roleids']);
			$menu  = $this->show_menu($main_menu);
			$this->set ( 'menu',  $menu);
			$this->set ( 'MainMeun',$main_menu);
			$this->set ( 'pmenu_count',count($main_menu));
			$this->set ( 'right_menu',$this->right_menu);
			$this->set ( 'loginMemberData',$this->loginMemberData);
			$this->set ( 'login_username', $this->loginMemberData ['email'] );
			$role_rule = $this->getRoleRule ();
			if (in_array (strtolower($this->params ['action']),($role_rule[strtolower($this->params ['controller'])]))) {
					$this->get_rights ( $this->params ['controller'], $this->params ['action'], $this->loginMemberData ['roleids'] );
			}
		}elseif (!in_array(strtolower($this->params ['controller']),$this->NotLoginController())){
			$this->redirect(array('controller' => 'Login', 'action' => 'index'));//跳转到登录页
		}
	}
	function beforeFilter() {	
		$this->globals ();				//调用全局参数
		if(empty($this->login_username)){
			$newarray = $this->NotLoginController();
			array_shift($newarray);
			$overall = $newarray;
		}else{
			 $overall = $this->NotLoginController();
		}
		$debug = in_array(strtolower($this->params ['controller']),$overall)?'':$this->setViewVars();
		// 接收url 传过来的参数 包括 get post 以及cakephp 的传参方式 所有的参数都可以直接在$this->data 中获取
		$this->data = array_merge ( $this->request->data, $this->request->params ['named'] );
		$this->data = array_merge ( $this->data, $this->request->query );
		if (array_key_exists("url", $this->data)) {
			unset($this->data['url']);
		}
		$bans = $this->getBanner();
		$rightlist = $this->getRight();
		$tree=$this->build_tree(0);
		$this->set('menulist',$tree);
		$this->set('rightlist',$rightlist);
		$this->set('bans',$bans);
		$this->set('rooturl',Configure::read('ROOTURL'));
	}
	/**
	 * 封装url地址（分页使用）
	 */                 
	function deal_url($data = null) {
		$where = array ();
		unset($data['url']);
		unset($data['type']);
		foreach ( $data as $k => $v ) {
			if ($k != "page" && $v != "") {
				$where [] = $k . "=" . urlencode ( trim ( $v ) );
			}
		}
		$search_where = implode ( "&", $where );
		return $search_where;
	}
	/**
	 * usePage 分页公共方法
	 * $rowsPerPage 每页显示数量
	 * $total 记录总条数
	 * $mpurl 页码链接地址
	 * method 普通分页 默认为get， 表单分页 method 传post
	 *
	 * 返回值 $start 起始查询数， 用于查询结果集limit
	 */
	function usePage($rowsPerPage=2, $total, $mpurl, $method = 'get') {
		if(!$rowsPerPage)$rowsPerPage =$this->pagenum;
		$data = isset ( $_REQUEST ) ? $_REQUEST : '';
		$currentPage = empty ( $data['page'] ) ? 1 : $data ['page'];
		$pagetotal = ceil ( $total / $rowsPerPage );
		if ($currentPage > $pagetotal && $pagetotal) {
			$currentPage = $pagetotal;
		}
		$start = ($currentPage - 1) * $rowsPerPage;
		if ($method == 'get') {
			$pagehtml = $this->Page->makeMulitpages ( $mpurl, $currentPage, $total, $rowsPerPage );
		} else {
			$pagehtml = $this->Page->makeMulitpageposts ( $currentPage, $total, $rowsPerPage );
		}
		$this->set ( 'currentPage', $currentPage );
		$this->set ( 'mpurl', $mpurl );
		$this->set ( 'pagehtml', $pagehtml );
		$this->set ( 'total', $total );
		$this->set ( 'maxPage', ceil ( $total / $rowsPerPage ) );
		$this->set ( 'currentPage', $currentPage );
		$this->set ( 'rowsPerPage', $rowsPerPage );
		$minstart = $currentPage * $rowsPerPage - 2;
		$this->set ( 'minstart', $start + 1 );
		$this->set ( 'maxend', $start + $rowsPerPage );
		return $start;
	}
	//不需要验证登录的控制器集合
	private function NotLoginController(){
			$array = array('login','index','company','shensource','wine','winesource','search'
					   );
			return $array;
	}
	/**
	 * 读取权限
	 *
	 * @param string $controller
	 *        	当前的控制器;
	 * @param string $action
	 *        	当前action;
	 * @param string $roleids
	 *        	用户角色id集合
	 * @return 不存在当前权限弹出提示并返回上一页面
	 */
	function get_rights($controller, $action, $roleids) {
		// 合作方管理员的权限需要特殊处理：运营经理不能创建合作方管理员，但是可以管理并且继承其权限,请开发人员注意！
		$this->loadModel ( 'Roles' );
		$has_right = 0;

		$rids = array();
		// 判断是否拥有子角色权限
		foreach (explode(',',$roleids) as $roleid)
		{
			$rids[] = $roleid;
			if($this->glo_roles[$roleid]['is_extend'])
			{
				foreach($this->glo_roles as $role_v)
				{
					if($role_v['pid'] == $roleid)
					{
						$rids[] = $role_v['id'];
					}
				}
			}
		}
		foreach ( $rids as $rid ) {
			if (empty($rid)) continue;
			// 获取每一角色的功能id集合,
			$fid_arr = $this->glo_rolefuncs[$rid];
			if(empty($fid_arr)) continue;
			// 获取功能的详细信息，与当前的路径相比较，验证是否存在权限
			foreach ( $fid_arr as $v ) {
				if (strtolower($v['controller']) == strtolower($controller) &&
				(strtolower($v['action_name']) == strtolower($action))) {
					$has_right = 1;
					break;
				}
			}
			if ($has_right) {
				break;// 如果当前角色已检查到该权限，则不再循环其他角色
			}
		}
		if (! $has_right) {
			echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
			echo "<script> alert('非法操作');history.back(-1)</script>";
			exit();
		}
	}
	private function getGlobalRoles(){
		$this->glo_roles = array();
		$global_roles = $this->getChildGlobalRoles();
		$this->glo_roles = $global_roles;
	 }
   //获取角色信息(从数据库查询)
	private function getChildGlobalRoles (){
		$new_global_roles = array();
		$this->loadModel ( 'Member' );
		$sql = "select id,role_name,pid,is_extend from ".Configure::read('prefix')."roles ";
		$global_roles = $this->Member->query($sql);
		$global_roles = cakeRstoRs ( $global_roles, Configure::read('prefix').'roles' );
		foreach($global_roles as $role_v)
		{
			$new_global_roles[$role_v['id']] = $role_v;
		}
		return $new_global_roles;
	}
	//获取权限信息（读取缓存）
	private function getGlobalRoleFuncs()
	{
		$this->glo_rolefuncs = array();
		if($this->memcache){
			$global_rolefuncs =	$this->memcache->get('getsrpGlobalRoleFuncs');
			if(empty($global_rolefuncs))
			{
				$global_rolefuncs = $this->getChildGlobalRoleFuncs();
				$this->memcache->set('getsrpGlobalRoleFuncs',$global_rolefuncs);
			}
		}else{
			$global_rolefuncs = $this->getChildGlobalRoleFuncs();
		}
		$this->glo_rolefuncs = $global_rolefuncs;
	}
//获取权限信息(从数据库查询)
	private function getChildGlobalRoleFuncs ()
	{
		$new_global_rolefuncs = array();
		$this->loadModel ( 'Member' );
		$sql = "select rid,fid,controller,action_name from ".Configure::read('prefix')."rolefuncs ";
		$global_rolefuncs = $this->Member->query($sql);
		$global_rolefuncs = cakeRstoRs ( $global_rolefuncs, Configure::read('prefix').'rolefuncs' );
		foreach($global_rolefuncs as $rolefunc_v)
		{
			$new_global_rolefuncs[$rolefunc_v['rid']][] = $rolefunc_v;
		}
		return $new_global_rolefuncs;
	}
	public function getUserMainMenu($user_roleids, $is_ucenter = 0, $tid = 0, $uid = 0) {
		$user_main_menu = $this->getMainMenu ( $user_roleids, 0, $tid );
		$this->menu_count = $this->getMenuCount ( $user_main_menu );
		$this->right_menu = $this->getRightMenu ( $user_main_menu, $uid );
		return $user_main_menu;
	}
	/**
	 * 加载主菜单(根据当前角色)
	 *
	 * @param string $user_roleids
	 *        	用户角色集合;
	 * @return 返回主菜单
	 */
	function getMainMenu($user_roleids,$is_ucenter=0,$tid = 0) {
		$this->loadModel ( 'Roles' );
		$menus1 = array ();
		$right_menu = array();
		$rids = $this->getRealRoleids($user_roleids,$tid);
		$rids = explode(',',$rids);
		if(empty($rids)) return array();
		// 加载9个二级菜单
		foreach ( $rids as $rid ) {
			if(empty($rid))continue;
			// 取出当前角色拥有的父级菜单
			$pmenus = $this->Roles->contrllSqlFirst($rid);
			if (empty ( $pmenus )) continue;
			foreach ( $pmenus as $pemnu ) {
				$menus1 [$pemnu ['b'] ['controller']] = $pemnu ['b'];
				// 获取父菜单下的子菜单
				$cmenus = $this->Roles->contrllSqlSecond($user_roleids,$pemnu);
				$menus1 [$pemnu ['b'] ['controller']] ['cmenu'] = $cmenus;
				//获取右边的菜单
				if(empty($cmenus)) continue;
				foreach($cmenus as $cmenu)
				{
					$right_menu[$cmenu['b']['id']] = $cmenu['b'];
				}
			}
		}
		if($is_ucenter)
		{
			$right_arr = empty($right_menu)?array():array_slice($right_menu,0);
			return $right_arr;
		}
		return $menus1;
	}
//判断当前用户是否有合作方管理员的权限和内部审核员的权限
	public function getRealRoleids($user_roleids,$tid)
	{
		if($tid == 0){
			$user_roleids_arr = explode(',',$user_roleids);
			if(in_array('5',$user_roleids_arr))
			{
				$user_roleids_arr = array_remove($user_roleids_arr,'5');
			}
		}
		return $user_roleids;

	}
//获取主菜单数量
	function getMenuCount($user_main_menu){
		foreach($user_main_menu as $k => $v){
			foreach($v['cmenu'] as $vk){
				$level2[] = $vk['b'];
			}
		}
		return sizeof($level2);
	}
// 获取登录用户信息
	public  function getLoginMember($username,$type = 1) {
		$this->loadModel ( 'Member' );
		$con = " email = '" . $username . "'";
		$memberData = $this->Member->getloginmemberinfo ( $con );
		return $memberData;
	}
	/**
	 * 获取当前需要判断的权限
	 */
	private function getRoleRule() {
		$this->loadModel ( 'Roles' );
		// 获取所有的父角色
		$new_arr = array ();
		if($this->memcache){
			$proles = $this->memcache->get('srp_funcs');
			if(empty($proles))
			{
				$proles = $this->Roles->getfuncInfo ( 'id,action_name,controller',Configure::read('prefix').'funcs');
				$this->memcache->set('srp_funcs',$proles);
			}
		}else{
			$proles = $this->Roles->getfuncInfo ( 'id,action_name,controller',Configure::read('prefix').'funcs');
		}
		foreach ( $proles as $p => $role ) {
			$new_arr [strtolower($role [Configure::read('prefix').'funcs'] ['controller'])] [] = strtolower($role [Configure::read('prefix').'funcs'] ['action_name']);
		}
		return $new_arr;
	}
	//获取用户快捷指向
	function getRightMenu($user_main_menu,$uid=0){
		foreach($user_main_menu as $k => $v){
				foreach($v['cmenu'] as $vk){
					$level2[] = $vk['b'];
				}
			}
		$this->right_menu = array_slice($level2,0);
		
		return $this->right_menu;
	}
	/*
	 * 显示一级菜单
	 */
	function show_menu($cache){
		$count = count($cache);
        $i = 1;
        $menu = "";
        foreach ($cache as $url => $name) {
            if ($i == 1) {
                $css = $url == $this->params['controller'] || !$cache[$this->params['controller']] ? "fisrt_current" : "fisrt";
                $menu.='<li class="' . $css . '"><span><a href="' .$this->base.'/'.$name['controller'].'/'.$name['action_name'].'">' . $name['func_desc'] . '</a></span></li>';
            } else if ($i == $count) {
                $css = $url == $this->params['controller'] ? "end_current" : "end";
                $menu.='<li class="' . $css . '"><span><a href="' .$this->base.'/'.$name['controller'].'/'.$name['action_name'].'">' .  $name['func_desc'] . '</a></span></li>';
            } else {
                $css = $url == $this->params['controller'] ? "current" : "";
                $menu.='<li class="' . $css . '"><span><a href="' .$this->base.'/'.$name['controller'].'/'.$name['action_name'].'">' .  $name['func_desc'] . '</a></span></li>';
            }
            $i++;
        }
        return $menu;
	}
	function findChild($arr,$id){
		$childs=array();
		foreach ($arr as $k => $v){
			if($v['parent_id']== $id){
				$childs[]=$v;
			}
		}
		return $childs;
	}
	function build_tree($root_id){
		$this->loadModel ( 'Index' );
		$res = $this->Index->getMenue();
		$childs=$this->findChild($res,$root_id);
		if(empty($childs)){
			return null;
		}
		foreach ($childs as $k => $v){
			$rescurTree=$this->build_tree($v['id']);
			if( null !=   $rescurTree){
				$childs[$k]['childs']=$rescurTree;
			}
		}
		return $childs;
	}
	
	//取右列的分类
	function getRight(){
		$this->loadModel ( 'Index' );
		$res = $this->Index->getRightlist();
		return $res;
	}
	function getBanner(){
		$this->loadModel ( 'Index' );
		$module = $this->params['controller'];
		$action = $this->params['action'];
		//看是否存在此导航
		$navs = $this->Index->getNavsid($module,$action);
		if(empty($navs)){
			return true;
		}else{
			$res = $this->Index->getBanner($navs[0]['id']);
		}
		return $res;
	}
	/**
     * 无限级分类
     * @access public 
     * @param Array $data     //数据库里获取的结果集 
     * @param Int $pid             
     * @param Int $count       //第几级分类
     * @return Array $treeList   
     */
    static public function tree(&$data,$pid = 0,$count = 1) {
        foreach ($data as $key => $value){
            if($value['pid']==$pid){
                $value['Count'] = $count;
                self::$treeList []=$value;
                unset($data[$key]);
                self::tree($data,$value['id'],$count+1);
            } 
        }
        return self::$treeList ;
    }
}
?>