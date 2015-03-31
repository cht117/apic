<div class="Item hr">
                        <div class="current">权限分配</div>
                    </div>
                    <p>你正在为用户：<b><?php echo $rolename['role_name']?></b> 分配权限 。项目和版块有全选和取消全选功能</p>
                    <form action="<?php echo $this->base?>/Access/changerole"  method="post" accept-charset="utf-8" target="editform">
                    <iframe name="editform" style="display:none"></iframe>
                        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tab">
                         <?php foreach ($roleFuncs as $key=>$v):?>
                        	 <tr>
                                   <td style="font-size: 14px;"><label><b>[项目]</b> 后台管理</label></td>
                                   <td ><input type="hidden" name="rights[<?php echo $v[Configure::read('prefix').'roles']['id'];?>]" value="<?php echo $v[Configure::read('prefix').'roles']['id'];?>" /></td>
                              </tr>
	                			 <?php foreach($v['func'] as $fv):?>
	                			 		<tr  class="show_func_<?php echo $v[Configure::read('prefix').'roles']['id'];?>">
                                        		<td style="padding-left: 30px; font-size: 14px;">
                                        		<label>
                                        		<input class="finputs" name="rights[<?php echo $v[Configure::read('prefix').'roles']['id'];?>][<?php echo $fv[Configure::read('prefix').'funcs']['id'];?>]" type="checkbox"  <?php echo $fv[Configure::read('prefix').'funcs']['has_right']?'checked':'';?> id="right_<?php echo $v[Configure::read('prefix').'roles']['id'];?>_<?php echo $fv[Configure::read('prefix').'funcs']['id'];?>" onclick="right_check_all(this.id)">
                                        		<b>[模块]</b>
                                        		<?php echo $fv[Configure::read('prefix').'funcs']['func_desc'];?>
                                        		</label></td>
                                   		 </tr>
                                   		  <tr>
                                        <td style="padding-left: 50px;">
                                        	<?php foreach($fv['cinfo'] as $fvc):?> 
                                        		<label><input type="checkbox"  name="rights[<?php echo $v[Configure::read('prefix').'roles']['id'];?>][<?php echo $fv[Configure::read('prefix').'funcs']['id'];?>][<?php echo $fvc[Configure::read('prefix').'funcs']['id'];?>]" class="oinput" <?php echo $fvc[Configure::read('prefix').'funcs']['has_right']?'checked':'';?> id="right_<?php echo $v[Configure::read('prefix').'roles']['id'];?>_<?php echo $fv[Configure::read('prefix').'funcs']['id'];?>_<?php echo $fvc[Configure::read('prefix').'funcs']['id'];?>" oid="<?php echo $fvc[Configure::read('prefix').'funcs']['id'];?>"><?php echo $fvc[Configure::read('prefix').'funcs']['func_desc'];?></label> &nbsp;&nbsp;&nbsp;
                                            <?php endforeach;?>
                                        </td>
                                    </tr>
	                			 <?php endforeach;?>
                			 <?php endforeach;?>
                        </table>
                    <div class="commonBtnArea" >
                        <button class="btn submit">提交</button>
                    </div>
                     </form>
  				<script type="text/javascript" src="http://zjs.zhongsou.com/d3m/jquery-1.8.2.min.js"></script>