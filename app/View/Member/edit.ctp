<div class="contentArea">
                <div class="Item hr">
                    <div class="current">编辑会员</div>
                </div>
                <form action="" method="post">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table1">
                        <tr>
                            <th>登录邮箱：</th>
                            <td><input name="info[email]" type="text" class="input" size="40" value="<?php echo $editdata['email'];?>"  disabled="disabled"/></td>
                        </tr>
                        <tr>
                            <th width="120">昵称：</th>
                            <td><input name="info[nickname]" type="text" class="input" size="30" value="<?php echo $editdata['nickname'];?>" /></td>
                        </tr>
                        <tr>
                            <th width="120">密码：</th>
                            <td><input name="info[pwd]" type="password" class="input" size="30" value="" />为空不修改。</td>
                        </tr>
                        <tr>
                            <th width="120">性别：</th>
                            <td><label><input type="radio" name="info[sex]" value="1" <?php if($editdata['sex']==1):?>checked<?php endif;?> >男</label>
                                <label><input type="radio" name="info[sex]" value="0" <?php if($editdata['sex']==0):?>checked<?php endif;?>>女</label></td>
                        </tr>
                        <tr>
                            <th width="120">手机号码：</th>
                            <td><input name="info[mobile]" type="text" class="input" size="30" value="<?php echo $editdata['mobile']?>" /></td> 
                        </tr>
                        <tr>
                            <th width="120">电话：</th>
                            <td><input name="info[phone]" type="text" class="input" size="30" value="<?php echo $editdata['phone']?>" /></td>
                        </tr>
                        <tr>
                            <th width="120">QQ：</th>
                            <td><input name="info[qq]" type="text" class="input" size="30" value="<?php echo $editdata['qq']?>" /></td>
                        </tr>
                        <tr>
                            <th width="120">MSN：</th>
                            <td><input name="info[msn]" type="text" class="input" size="30" value="<?php echo $editdata['msn']?>" /></td>
                        </tr>
                    </table>
                    <input type="hidden" name="uid" value="<?php echo $editdata['uid']?>"/>
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