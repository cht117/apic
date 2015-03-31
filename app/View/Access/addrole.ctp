<div class="Item hr">
                        <div class="current">添加编辑角色</div>
                    </div>
                    <form action="" method="post">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table1">
                            <tr>
                                <th width="120">角色组名称：</th>
                                <td><input name="role_name" type="text" class="input" size="40" value="" /> </td>
                            </tr>
                            <tr>
                                <th>状态：</th>
                                <td>
                                <select name="status" style="width: 80px;">
                                	<option value="1" selected>启用</option>
                                	<option value="0">禁用</option>                                
                                </select></td>
                            </tr>
                            <tr>
                                <th>父级组ID：</th>
                                <td>
                                <select name="pid" style="min-width: 80px;">
                                	<?php foreach ($roldata as $key=>$item):?>
                                			<option value="<?php echo $item['id']?>" selected><?php echo $item['role_name']?></option>
                                	<?php endforeach;?>
                                </select></td>
                            </tr>
                            <tr>
                                <th>描 述：</th>
                                <td><textarea name="remark" style="width: 400px;"></textarea></td>
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