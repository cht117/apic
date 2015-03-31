  <?php echo $this->element('banner');?>
   <div class="sxyjy_mbx">
                    <span><a href="/Index/index">首页</a> ><a href="/Company/index"><?php echo $btitle ;?></a><?php if($stitle):?>  > <i><?php echo $stitle;?></i><?php endif;?></span>
                </div>
<div class="sxyjy_leftcon">
                    <div class="sxyjy_listleft">
                        <div class="cxy_title">
                            <span class="title"><?php echo $news['title'];?></span>
                            <span class="time"><i><?php echo date("Y-m-d",$news['create_time']);?></i></span>
                        </div>
                        <div class="cxy_xqdesc">
                            <?php echo $news['content'];?>
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
        	<div class="sxyjy_kb">&nbsp;</div>