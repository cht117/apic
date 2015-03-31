<?php
define('PAGE_SIZE', 10);
define('Front_LAYOUT', 'front_layout');
define('After_LAYOUT', 'after_layout');
/**
 *前台首页
 */
Configure::write('index', array(
'viewPath' => 'Index',
'layout' => Front_LAYOUT,
'_model' => 'Index',
'_searchFields' => array()
));
/**
 *前台企业介绍
 */
Configure::write('company', array(
'viewPath' => 'Company',
'layout' => Front_LAYOUT,
'_model' => 'Index',
'_searchFields' => array()
));
/**
 *参之源
 */
Configure::write('shensource', array(
'viewPath' => 'Shensource',
'layout' => Front_LAYOUT,
'_model' => 'Index',
'_searchFields' => array()
));
/**
 *酒之源
 */
Configure::write('wine', array(
'viewPath' => 'Wine',
'layout' => Front_LAYOUT,
'_model' => 'Index',
'_searchFields' => array()
));
/**
 *酒之源
 */
Configure::write('winesource', array(
'viewPath' => 'Winesource',
'layout' => Front_LAYOUT,
'_model' => 'Index',
'_searchFields' => array()
));
/**
 * 后台首页
 */
Configure::write('backstage', array(
'viewPath' => 'Backstage',
'layout' => After_LAYOUT,
'_model' => 'Member',
'_searchFields' => array()
));
/**
 * 后台权限管理
 */
Configure::write('access', array(
'viewPath' => 'Access',
'layout' => After_LAYOUT,
'_model' => 'Roles',
'_searchFields' => array()
));
/**
 * 后台用户管理
 */
Configure::write('member', array(
'viewPath' => 'Member',
'layout' => After_LAYOUT,
'_model' => 'Member',
'_searchFields' => array()
));
/**
 * 资讯管理
 */
Configure::write('news', array(
'viewPath' => 'News',
'layout' => After_LAYOUT,
'_model' => 'News',
'_searchFields' => array()
));
/**
 * 产品管理
 */
Configure::write('product', array(
'viewPath' => 'Product',
'layout' => After_LAYOUT,
'_model' => 'Product',
'_searchFields' => array()
));
/**
 * 内容管理
 */
Configure::write('content', array(
'viewPath' => 'Content',
'layout' => After_LAYOUT,
'_model' => 'Content',
'_searchFields' => array()
));
/**
 * 网站功能
 */
Configure::write('siteinfo', array(
'viewPath' => 'Siteinfo',
'layout' => After_LAYOUT,
'_model' => 'Member',
'_searchFields' => array()
));
/**
 * 广告位管理
 */
Configure::write('adp', array(
'viewPath' => 'Adp',
'layout' => After_LAYOUT,
'_model' => 'Adp',
'_searchFields' => array()
));
/**
 * 活动分类管理
 */
Configure::write('cate', array(
'viewPath' => 'Cate',
'layout' => After_LAYOUT,
'_model' => 'Cate',
'_searchFields' => array()
));
/**
 * 活动分类管理
 */
Configure::write('eventpic', array(
'viewPath' => 'Eventpic',
'layout' => After_LAYOUT,
'_model' => 'Eventpic',
'_searchFields' => array()
));


/**
 * 全局 高亮 搜索
 */
Configure::write('search', array(
'viewPath' => 'Search',
'layout' => Front_LAYOUT,
'_model' => 'Index',
'_searchFields' => array()
));
?>
