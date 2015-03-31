                    <ul>
                    <?php foreach($right as $k=>$v):?>
                    	<li>
                        	<a <?php if(trim($stitle)==trim($v['nav_name'])):?> class="jda on" <?php else:?>class="jda"<?php endif;?>href="<?php echo '/'.$v['module'].'/'.$v['action'];?>" ><?php  echo $v['nav_name'];?></a>
                        	<?php if($v['id']==20):?>
                       	<div class="sxyjy_procon">
                       	<ul>
                       	<?php foreach($sons as $k=>$v):?>
                       		<li><a <?php if(trim($stitle)==trim($v['nav_name'])):?> class="on" <?php endif;?>href="<?php echo '/'.$v['module'].'/'.$v['action'];?>" ><?php  echo $v['nav_name'];?></a></li>
                       		<?php endforeach;?>
                       	</ul>
                       		
                       		 </div>
                       	<?php endif;?>
                        </li>
                     <?php endforeach;?>  
                    </ul>