<div class="sxyjy_listcon">
    	<div class="sxyjy_listimg" style="height:217px; background:url(/images/listimg.jpg) no-repeat center top;"></div>
        <div class="sxyjy_list">
            <div class="sxyjy_listinfo">
                <div class="sxyjy_mbx">
                    <span><a href="<?php echo $rooturl;?>">首页</a> >搜索</span>
                </div>
                <div class="sxyjy_leftcon">
                    <div class="sxyjy_listleft">
                        <div class="cxy_gwlist">
                        	<?php if(!empty($list)):?>
                        	<?php foreach ($list as $key=>$item):?>
                        		<div class="cxy_listtop">
                                <span class="title"><?php echo $item['title']?></span>
                                <?php if(!empty($item['img_url'])):?>
                                	<span class="imgcon"><img src="<?php echo $item['img_url']?>" width="180" height="120" /></span>
                                <div class="cxy_rcon">
                                    <span class="titlecon"><?php echo  mb_substr($item['summary'],0,120);?>...</span>
                                    <span class="time">
                                        <em><?php echo date('Y-m-d',$item['adddate'])?></em>
                                        <a href="<?php echo $item['url']?>?id=<?php echo $item['id']?>" target="_blank"><i></i>更多</a>
                                    </span>
                                </div>
                                <?php else:?>
                                <div>
	                                    <span class="titlecon"><?php echo $item['summary']?></span>
	                                    <span class="time">
	                                        <em><?php echo date('Y-m-d',$item['adddate'])?></em>
	                                        <a href="<?php echo $item['url']?>?id=<?php echo $item['id']?>" target="_blank"><i></i>更多</a>
	                                    </span>
                                </div>
                                <?php endif;?>
                            </div>
                        	<?php endforeach;?>
                        	<?php else:?>
                        		   <font color="red">暂无数据!</font>
                        	<?php endif;?>                    
                        </div>
                    </div>                	
                </div>
                <div class="sxyjy_listright">
                	<span class="title"><a href="/Index/index" target="_blank">参仙源</a></span>
                    <ul>
                    	<li>
                        	<a href="/Company/index" target="_blank" class="jda">企业介绍</a>
                        </li>
                        <li>
                        	<a href="/Shensource/index" target="_blank" class="jda">参之源</a>
                        </li>
                        <li>
                        	<a href="/Wine/index" target="_blank" class="jda">酒之源</a>
                        </li>
                         <li>
                        	<a href="/Winesource/index" target="_blank" class="jda">参酒之缘</a>
                        </li>
                    </ul>
                </div>
            </div>            
        </div>
        <div class="sxyjy_footer">
		<?php echo $this->element('frontpage');?>