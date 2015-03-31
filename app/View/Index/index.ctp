      <div class="sxyjy_jdimg" style="z-index:1">
    	<div class="sxyjy_jdimgcon" style="position:relative;">
    	<?php foreach($ads as $k=>$v){?>
            <div <?php if($k==0):?>class="top_img scroll_on"<?php else:?>class="top_img"<?php endif;?> style="height:653px;width:100%; background:url(<?php echo $v['ad_img'];?>) no-repeat center top;position:absolute;background-size:100% 653px;<?php if($k==0):?>z-index:10;<?php else:?>z-index:0;<?php endif;?>">
              <?php if($v['link']):?>
                <a target="_blank" href="<?php echo $v['link'];?>"></a>
                <?php else:?>
                 <a href="javascript:void(0);"></a>
                 <?php endif;?>
            </div>
         <?php }?>
            <div class="sxyjy_btnlb" style="z-index:11;">
                <span>
                <?php for($i=0;$i<count($ads);$i++){?>
                    <a href="javascript:void(0);"></a>
                    <?php }?>
                </span>
            </div>
        </div>
    </div>
    <div class="sxyjy_foot">
    	<div class="sxyjy_footcon">
        	<ul>
            	<li class="left">
                	<a href="/Company" target="_blank" class="company"><img src="<?php echo $company['image_url'];?>" width="149" height="95" /></a>
                    <p>
                    	<span class="title"><i class="ia"><a style="color:#000;text-decoration: none;" href="/Company/index">公司简介</a></i><i class="ib">|</i><i class="ic"><a style="color:#061b10;text-decoration: none;" href="/Company/index"><?php echo $company['title'];?></a></i></span>
                        <span class="info">
                        	<a href="/Company/index" target="_blank" class="jjcon"><?php echo  mb_substr($company['summary'],0,80);?>...</a>
                            <a href="/Company/index" target="_blank" class="more"></a>
                        </span>
                    </p>
                </li>
                <li class="right">
                	<a href="/Company/news?id=<?php echo $news[0]['id'];?>" target="_blank" class="newzx"><img src="<?php echo $news[0]['img_url']; ?>" width="149" height="95" /></a>
                    <p>
                    	<span class="title"><i class="ia"><a style="color:#000;text-decoration: none;" href="/Company/newslist">新闻动态</a></i><i class="ib">|</i><i class="ic"><a style="color:#061b10;text-decoration: none;" href="/Company/news?id=<?php echo $news[0]['id'];?>"><?php echo $news[0]['title'];?></a></i></span>

                        <span class="info">

                            <a href="/company/newslist" target="_blank" class="jjcon"><?php echo mb_substr($news[0]['summary'],0,80);?>...</a>
                            <a href="/company/newslist" target="_blank" class="more"></a>
                        </span>
                    </p>
                </li>
            </ul>
