<div class="contentArea">
                <div class="Item hr">
                    <div class="current">添加会员</div>
                </div>
                <form action="" method="post">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table1">
                        <tr>
                            <th>登录邮箱：</th>
                            <td><input name="info[email]" type="text" class="input" size="40" value="" /></td>
                        </tr>
                        <tr>
                            <th width="120">昵称：</th>
                            <td><input name="info[nickname]" type="text" class="input" size="30" value="" /></td>
                        </tr>
                        <tr>
                            <th width="120">密码：</th>
                            <td><input name="info[pwd]" type="password" class="input" size="30" value="" /></td>
                        </tr>
                        <tr>
                            <th width="120">性别：</th>
                            <td><label><input type="radio" name="sex" value="1" >男</label>
                                <label><input type="radio" name="sex" value="0" >女</label></td>
                        </tr>
                        <tr>
                        		<th width="120">所属角色</th>
                        		<td>
                        			<select name="info[roleids]" style="min-width: 80px;">
	                                	<?php foreach ($roldata as $key=>$item):?>
	                                			<option value="<?php echo $item['id']?>"><?php echo $item['role_name']?></option>
	                                	<?php endforeach;?>
                               	 </select>
                        		</td>
                        </tr>
                        <tr>
                            <th width="120">手机号码：</th>
                            <td><input name="info[mobile]" type="text" class="input" size="30" value="" /></td>
                        </tr>
                        <tr>
                            <th width="120">电话：</th>
                            <td><input name="info[phone]" type="text" class="input" size="30" value="" /></td>
                        </tr>
                        <tr>
                            <th width="120">QQ：</th>
                            <td><input name="info[qq]" type="text" class="input" size="30" value="" /></td>
                        </tr>
                        <tr>
                            <th width="120">MSN：</th>
                            <td><input name="info[msn]" type="text" class="input" size="30" value="" /></td>
                        </tr>
                    </table>
                     </form>
                <div class="commonBtnArea" >
                    <button class="btn submit">提交</button>
                </div>
            </div>
            <script type="text/javascript">
			    $(function(){
			        $(".submit").click(function(){
			            commonAjaxSubmit();
			            return false;
			        });
			    });
</script>