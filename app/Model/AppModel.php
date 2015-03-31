<?php
/**
 * Application model for CakePHP.
 *
 * This file is application-wide model file. You can put all
 * application-wide model-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Model
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Model', 'Model');
App::import ( 'vendor', 'tools' );

/**
 * Application model for Cake.
 *
 * Add your application-wide methods in the class below, your models
 * will inherit them.
 *
 * @package       app.Model
 */
class AppModel extends Model {
	/**
     * 过滤数据源
     * -----------------------------------
     *
     * @param   $array 数据源
     * 
     * @param   $item:字段节点
     * 
     * @param   $talbe:表名，无前缀的表名
     * 
     * @return  data
     *
     */
	function filterdata($array,$item,$talbe){
		$k = $talbe=='category'?'cid':'id';
		$tk = $talbe=='category'?'pid':'parent_id';
		foreach ($array as $key=>$val){
			/*取出所有的二级功能	*/
			$clists = self::checkinfo(Configure::read('prefix').$talbe,'*',array($item=>$val[$k]));
			foreach ($clists as $ck=>$clist){
					if($clist[$tk]){
						$client_info = self::checkinfo(Configure::read('prefix').$talbe,'*',array($item=>$clist[$tk]));
					}
			}
			/*	组成新列表显示在前台	*/
			$array[$key]['cinfo'] = $clists;
		}
		return $array;
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
	 * 获取栏目
	 */
	function Product($data){
		 $catedata = $this->checkinfo(Configure::read('prefix').'navs','id,parent_id as pid,nav_name');
	     $newdata = $this->tree($catedata);
	     return $newdata;
	}
	/**
	 * 添加sphinx 数据源  add by  hd
	 * @param $typeid	  数据源类型，目前暂定为 1为：新闻数据2：参仙源3:酒之源4：参酒之源 
     * @param $id 		 与新闻表，内容表是一一对应的。
     * @param $adddate	  添加时间
     * $param $url    此参数是临时加上去的，方便sphinx搜索引擎搜索到的数据，方便跳至详细页
     * @param $data  需要入库的数据源，但是只需两个字段，这里我全给传来了，方便之后在有什么需求，不用改的太多。
	 */
	function addsphinx($typeid,$id,$url,$data){
		$info = array (
				"typeid" =>$typeid, 
				"id" =>$id,
				"url" =>$url,
				"data"=>$data,
				"adddate" => time()
		);
		$this->addsphinxs ( $info ); // 插入数据源记录
	}
	/**
	 * 添加sphinx 数据源
	 */
	public function addsphinxs($info){
		$url = '';
		switch ($info['url']) {
				case 1:
				$url = '/Company/news';
					break;
				case 3:
				case 9:
				case 10:
				case 11:
				case 12:
				$url = '/Shensource/desc';
					break;
				case 4:
				case 14:
				case 15:
				case 16:
				case 17:
				case 18:
				case 19:
				$url = '/Shensource/desc';
					break;
				case 5:
				case 20:
				case 21:
				case 22:
				case 23:
				case 24:
				case 25:
				case 26:
				$url = '/Winesource/desc';	
					break;
				default:
						# 其他
				break;	
		}
		$img_url = isset($info['data']['img_url'])?$info['data']['img_url']:$info['data']['image_url'];
		$sql .= "insert into v9_search(`typeid`,`id`,`adddate`,`url`,`img_url`,`title`,".
				"`summary`) ";
		$sql .= " values('".$info['typeid']."','".$info['id']."','".$info['adddate']."','".
				$url."','".$img_url."','".$info['data']['title']."','".$info['data']['summary']."')";
		$this->query($sql);
		return true;
	}
	/**
	 * 修改数据源
	 * @param $data	  数据源
	 * @param $ids  修改id 
	 */
	function editsphinx($data,$ids){
		$sql = "update v9_search set `title`='".$data['title']."',`summary`='".$data['summary']."' where ".rand(1, 9)." and id =".$ids;
		$this->query($sql);
		return true;
	}
	/**
     * 无限级分类
     * @access public 
     * @param Array $data     //数据库里获取的结果集 
     * @param Int $pid             
     * @param Int $count       //第几级分类
     * @return Array $treeList   
     */
	function tree(&$data,$pid = 0,$count = 0) {
	    if(!isset($data['odl'])){
	        $data=array('new'=>array(),'odl'=>$data);
	    }
	    foreach ($data['odl'] as $k => $v){
	        if($v['pid']==$pid){
	            $v['Count'] = $count;
	            $data['new'][]=$v;
	            unset($data['odl'][$k]);
	            $this->tree($data,$v['id'],$count+1);
	        } 
	    }
	    return $data['new'] ;
	 }
}
