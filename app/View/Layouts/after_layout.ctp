<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>参仙源后台管理-<?php echo $title_for_layout?></title>
        <link href="<?php echo $this->base; ?>/css/adminstyle.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo $this->base; ?>/css/skins/default.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="<?php echo $this->base; ?>/js/jquery-1.9.0.min.js"></script>
        <script type="text/javascript" src="<?php echo $this->base; ?>/js/functions.js"></script>
        <script type="text/javascript" src="<?php echo $this->base; ?>/js/jquery.form.js"></script>
        <script type="text/javascript" src="<?php echo $this->base; ?>/js/asyncbox/asyncbox.js"></script> 
        <script type="text/javascript" src="<?php echo $this->base; ?>/js/base.js"></script> 
   		<?php  
			//echo APP;exit;
			if(file_exists(APP.'/View/Elements/'.ucfirst($this->request->params['controller']).'.ctp'))
			{
			echo $this->element(ucfirst($this->request->params['controller']));
			}
			?>
    </head>
    <body>
        <div class="wrap">
            <div id="Top">
		    <div class="logo"><a target="_blank" href="<?php echo $rooturl;?>"><img src="/img/Admin/logo.png" /></a></div>
		    <div class="help"><a href="javascript:void(0)" target="_blank">使用帮助</a><span><a href="javascript:void(0)" target="_blank">关于</a></span></div>
		    <div class="menu">
		    	<ul>
		    		<?php echo $menu;?>
		    	</ul>
		        
         </div>
      </div>
	<div id="Tags">
	    <div class="userPhoto"><img src="/img/Admin/userPhoto.jpg" /> </div>
	    <div class="navArea">
	        <div class="userInfo"><div><a href="javascript:void(0)" class="sysSet"><span>&nbsp;</span>系统设置</a> <a href="/login/logout" class="loginOut"><span>&nbsp;</span>退出系统</a></div>欢迎您，<?php echo $login_username;?></div>
	        <div class="nav"><font id="today"><php><?php echo date("Y-m-d H:i:s");?></php></font></div>
	    </div>
	</div>
	<div class="clear"></div>
            <div class="mainBody">
            <div id="Left" style="height: 532px; margin-left: 0px;">
			  <?php echo $this->element('left');?>
			</div>
                <div id="Right"  style="height: 450px; width: 1136px;" >
						<?php echo $content_for_layout;?>
                </div>
            </div>
        </div>
        <div class="clear"></div>
        <?php echo $this->element('foot');?>
    </body>
</html>
