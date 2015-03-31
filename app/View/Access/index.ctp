  <div class="Item hr">
                        <div class="current">管理员列表</div>
       </div>
              <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tab">
                        <thead>
                            <tr>
                                <td>AID</td>
                                <td>角色名称</td>
                                <td>状态</td>
                                <td>备注</td>
                                <td>开通时间</td>
                                <td width="150">操作</td>
                            </tr>
                        </thead>
                        <?php foreach ($list as $key=>$item):?>
                        		 <tr align="center" aid="<?php echo $item['id']?>">
                        		 	   <td><?php echo $item['id']?></td>
                        		 	   <td><?php echo $item['role_name']?></td>
                        		 	   <td><?php echo $item['newstatus']?></td>
                        		 	   <td><?php echo $item['remark']?></td>
                        		 	   <td><?php echo date('Y-m-d H:i:s',$item['create_time'])?></td>
                        		 	   <td>[ <a href="#">编辑</a> ] [ <a href="/Access/changerole?ids= <?php echo  $item['id'];?>" class="edit">权限分配</a> ]</td>
                        <?php endforeach;?>
                        <tr>
		                 	 <td colspan="7" align="right">
		                 	 		<?php echo $this->element('afterpage');?>
		                 	 </td>
		                  </tr>
         		</table>
