<div class="Item hr">
       <div class="current">系统信息</div>
</div>
 <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tab">
 		 <?php foreach ($server_info as $key=>$item):?>
 		 			<?php if($key%2==1):?><?php echo "<tr>"?><?php endif;?>
 		 			  <td width="120" align="right"><?php echo $item['param'];?>：</td>
 		 			   <td><?php echo  $item['values'];?></td>
 		 			 <?php if($key%2==0):?><?php echo "</tr>"?><?php endif;?>
 		 <?php endforeach;?>
  </table>