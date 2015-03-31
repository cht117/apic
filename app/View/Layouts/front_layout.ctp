<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php if($this->params['controller']=='Index') {echo "辽宁参仙源酒业";}else{echo $btitle.'_'.$news['title'] .$stitle.'|参仙源酒业';}?></title>
<link rel="stylesheet" type="text/css" href="<?php echo $this->base; ?>/css/reset.css" />
<link rel="stylesheet" type="text/css" href="<?php echo $this->base; ?>/css/sxyjy.css" />
<script type="text/javascript" src="<?php echo $this->base; ?>/js/jquery-1.9.0.min.js"></script>
<script type="text/javascript" src="<?php echo $this->base; ?>/js/frontjs.js"></script>
<script type="text/javascript" src="<?php echo $this->base; ?>/js/jquery.js"></script>
<!--[if IE 6]>
<script src="js/tpcl.js"></script>
<script>DD_belatedPNG.fix('.sxyjy_headcon img,.sxyjy_search img,.appyy_phone img,.appyy_jtimgcon li em img,span img'); </script>
<![endif]-->
</head>

<body>
<div class="sxyjy_content">
	<div class="sxyjy_head">
    	<div class="sxyjy_headcon">
        	<a href="<?php echo $rooturl;?>"class="logo"><img src="<?php echo $this->base; ?>/images/sxyjy_logo.png" width="273" height="118" /></a>
            <div class="sxyjy_nav">
            	<ul>
            	<?php foreach($menulist as $k=>$v){?>
                    <li>
                    	<a <?php if($this->params['controller']==$v['module']):?>class="on cur_on"<?php endif;?>href="<?php echo $this->base.'/'.$v['module'].'/'.$v['action'];?>"><?php echo $v['nav_name'];?></a>
                    		<?php if($v['childs']){ $arr = $v['childs'];}?>
                        <div class="sxyjy_tc" style="display:none;">
                       		 <?php foreach($arr as $k=>$v){?>
                       	 <span><a href="<?php echo $this->base.'/'.$v['module'].'/'.$v['action'];?>" ><i><?php echo $v['nav_name'];?></i></a></span>
                        	<?php }?>    
                        </div>
                        
                    </li>
                   
                    <?php }?>
                </ul>
            </div>
            <div class="sxyjy_search">
            	<span class="search">
                	<input type="text" name="txtsearch" class="txtsearch" id = "keywords" value="<?php echo isset($data['keyword'])?$data['keyword']:'请输入关键词'?>" onfocus = "if(this.value=='请输入关键词'){this.value='';}" onblur = "if(this.value==''){this.value='请输入关键词';}"  onkeydown="enterIn(event,'s($(\'#keywords\').val(),1)')"/>
                    <a href="javascript:void(0);" class="search" onclick="s($('#keywords').val(),1);"><i></i></a>
                </span>
            	<a href="http://www.shenxianyuan.com/" target="_blank" class="intojlb"><img src="<?php echo $this->base; ?>/images/sxyjy_intosxy.png" width="200" height="25" /></a>
            </div>
        </div>
    </div>
     <?php echo $content_for_layout; ?>  
 	<!--  <div class="sxyjy_beian <?php if($this->params['controller']!='Index'):?>sxyjy_beiana<?php endif;?> ">COPYRIGHT © 2013 SHENXIANYUAN ALL RIGHTS RESERVED  ICP 备案号：辽ICP备13002947  Powered by xinhongru</div>-->
        </div>
     <div class="sxyjy_beian sxyjy_beianb" <?php if($this->params['controller']!='Index'):?> style="margin-top:-70px";<?php endif;?>>
            <a rel="home" title="碧水投资集团" href="http://www.bishui.com.cn" target="_blank">碧水投资集团</a>
            <em>|</em>
            <a rel="home" title="参仙源企业" href="http://www.sxyshenye.com" target="_blank">参仙源参业</a>
            <em>|</em>
            <a rel="home" title="参仙源会员俱乐部" href="http://www.shenxianyuan.com" target="_blank">参仙源会员俱乐部</a>
            <em>|</em>
            <a rel="home" title="天桥沟森林公园" href="http://www.tianqiaogou.com.cn" target="_blank">天桥沟森林公园</a>
            <span>COPYRIGHT © 2013 SHENXIANYUAN ALL RIGHTS RESERVED  ICP 备案号：辽ICP备13002947 </span>
        </div>
    </div>
</div>
</body>
</html>
  