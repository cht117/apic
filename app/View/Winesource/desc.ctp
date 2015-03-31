     <?php echo $this->element('banner');?>
          <div class="sxyjy_mbx">
                    <span><a href="/Index/index">首页</a> ><a href="/Winesource/index"><?php echo $btitle ;?></a>  > <i><a href="<?php echo '/'.$module.'/'.$action;?>"><?php echo $stitle;?></a></i>> <i><?php echo $news['title'];?></i></span>
                </div>
                <div class="sxyjy_leftcon">
                    <div class="sxyjy_listleft">
                        <div class="cxy_title">
                            <span class="title"><?php echo $news['title'];?></span>
                            <span class="time"><i><?php echo date("Y-m-d ",$news['create_time']);?></i></span>
                        </div>
                        <div class="cxy_xqdesc">
                            <?php echo $news['content'];?>
                        </div>
                    </div>                	
                </div>
               <div class="sxyjy_listright">
                	<span class="title"><a href="#" >參酒之缘</a></span>
                    <?php echo $this->element('rightlist');?>
                </div>
            </div>            
        </div>
        <div class="sxyjy_footer">
        	<div class="sxyjy_kb">&nbsp;</div>