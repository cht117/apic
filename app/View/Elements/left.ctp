<div id="control" class="" style="height: 350px;"></div>
   <div class="subMenuList">
      <div class="itemTitle"> <?php if($this->params['controller']=='Backstage'):?>常用操作<?php else :?>子菜单<?php endif;?></div>
        <ul>
					<?php foreach ($MainMeun as $key=>$menu):?>
							<?php if($key==$this->params['controller']):?>
										<?php foreach($menu['cmenu'] as $k=>$cmenu):?>
												<li>
													<a href="<?php echo $this->base?>/<?php echo $cmenu['b']['controller']?>/<?php echo $cmenu['b']['action_name']?>" title=""><?php echo $cmenu['b']['func_desc']?></a>
												</li>
										<?php endforeach;?>
							<?php endif;?>
					<?php endforeach;?>	 
        </ul>
    </div>
