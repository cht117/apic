   <?php echo $this->element('banner');?>
    <div class="sxyjy_mbx">
                    <span><a href="/Index/index">首页</a> ><a href="/Company/index"><?php echo $btitle ;?></a><?php if($stitle):?>  > <i><?php echo $stitle;?></i><?php endif;?></span>
                </div>
                <div class="sxyjy_leftcon">
                    <div class="sxyjy_listleft">
                        <div class="cxy_gwlist">
                           <?php foreach($list as $k=>$v){?>
                            <div class="cxy_listtop">
                                <span class="title"><a href="/Company/news?id=<?php echo $v['id'];?>"><?php echo  $v['title'];?></a></span>
                                <span class="imgcon"><a href="/Company/news?id=<?php echo $v['id'];?>"><img src="<?php echo $v['img_url'];?>" width="180" height="120" /></a></span>
                                <div class="cxy_rcon">
                                    <span class="titlecon"><?php echo  mb_substr($v['summary'],0,120);?>...</span>
                                    <span class="time">
                                        <em><?php echo date("Y-m-d ",$v['create_time']);?></em>
                                        <a href="/Company/news?id=<?php echo $v['id'];?>" target="_blank"><i></i>更多</a>
                                    </span>
                                </div>
                            </div>
                           <?php }?>       
                        </div>
                    </div>                	
                </div>
		<div class="sxyjy_listright">
                	<span class="title"><a href="/Company/index" ><?php echo $btitle;?></a></span>
			 <?php echo $this->element('rightlist');?>	
                </div>
            </div>  
          
        </div>
        <div class="sxyjy_footer">
        	<?php echo $this->element('frontpage');?>