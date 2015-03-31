<div class="Item hr">
                        <div class="current">添加功能</div>
                    </div>
                    <form action="" method="post">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table1">
                            <tr>
                                <th width="120">功能名称：</th>
                                <td><input name="func_desc" type="text" class="input" size="40" value="<?php echo  $Func_info[0]['func_desc']?>" /><font  color="red">*</font></td>
                            </tr>
                            <tr>
                                <th width="120">控制器：</th>
                                <td><input name="controller" type="text" class="input" size="40" value="<?php echo  $Func_info[0]['controller']?>" /><font  color="red">*</font></td>
                            </tr>
                            <tr>
                                <th width="120">动作：</th>
                                <td><input name="action_name" type="text" class="input" size="40" value="<?php echo  $Func_info[0]['action_name']?>" /><font  color="red">*</font></td>
                            </tr>
                            <tr>
                                <th>上级功能：</th>
                                <td>
                                <select name="pmenu" style="width: 80px;">
                                	<option value="0" <?php echo  $Func_info[0]['pid']==0?'selected':''?>>请选择</option>
                                	<?php foreach($func_lists as $v):?>
			      						 <option value="<?php echo  $v[Configure::read('prefix').'funcs']['id']?>" <?php echo $v[Configure::read('prefix').'funcs']['id'] == $Func_info[0]['pid']?'selected':''?>><?php echo  $v[Configure::read('prefix').'funcs']['func_desc']?></option>
									<?php endforeach;?>          
                                </select></td>
                            </tr>
                            <tr>
                            	<td><input type="hidden" value="1" name="is_menu"></td>
                            </tr>
                        </table>
                    </form>
                    <div class="commonBtnArea" >
                        <button class="btn submit">提交</button>
                    </div>
                    
<script type="text/javascript">
	    $(function(){
	        $(".submit").click(function(){
	            commonAjaxSubmit();
	        });
	    });
</script>