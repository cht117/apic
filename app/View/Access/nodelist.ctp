<div class="Item hr">
                        <div class="current">节点管理</div>
                         <div style="width: 100px;float: right;"><button type="button" class="btn" onclick="window.location.href='/Access/add/'">添加</button></div>
                    </div>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tab">
                        <thead>
                            <tr>
                                <td>序号</td>
                                <td>节点结构 </td>
                                <td>节点ID</td>
                                <td>名称</td>
                                <td>动作</td>
                                <td width="150">操作</td>
                            </tr>
                        </thead>
                        <?php foreach ($funcs as $key=>$item):?>
                        		   <tr align="center" id="<?php echo $item[Configure::read('prefix').'funcs']['id']?>" pid="<?php echo $item[Configure::read('prefix').'funcs']['pid']?>">
                        		   <td><?php echo $item[Configure::read('prefix').'funcs']['id']?></td>
                        		   <td align="left" class="tree" style="cursor: pointer;"><?php echo $item[Configure::read('prefix').'funcs']['func_desc']?></td>
                        		   <td><?php echo $item[Configure::read('prefix').'funcs']['id']?></td>
                        		   <td><?php echo $item[Configure::read('prefix').'funcs']['controller']?></td>
                        		   <td><?php echo $item[Configure::read('prefix').'funcs']['action_name']?></td>
                        		   <td><a href="/Access/funcedit?ids=<?php echo $item[Configure::read('prefix').'funcs']['id']?>">编辑</a></td>
                        		   </tr>
                       <?php foreach($item['cinfo'] as $kk=>$cv):?>
                       			   <tr align="center" id="<?php echo $cv[Configure::read('prefix').'funcs']['id']?>" pid="<?php echo $cv[Configure::read('prefix').'funcs']['pid']?>">
                        		   <td><?php echo $cv[Configure::read('prefix').'funcs']['id']?></td>
                        		   <td align="left" class="tree" style="cursor: pointer;"><?php echo '&nbsp;&nbsp;&nbsp;├ '.$cv[Configure::read('prefix').'funcs']['func_desc']?></td>
                        		   <td><?php echo $cv[Configure::read('prefix').'funcs']['id']?></td>
                        		   <td><?php echo $cv[Configure::read('prefix').'funcs']['controller']?></td>
                        		   <td><?php echo $cv[Configure::read('prefix').'funcs']['action_name']?></td>
                        		   <td><a href="/Access/funcedit?ids=<?php echo $cv[Configure::read('prefix').'funcs']['id']?>">编辑</a></td>
                        		   </tr>
                       <?php endforeach;?>
                        <?php endforeach;?>
                        <tr>
		                 	 <td colspan="7" align="right">
		                 	 		<?php echo $this->element('afterpage');?>
		                 	 </td>
		                  </tr>
                    </table>