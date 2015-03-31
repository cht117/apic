<div class="Item hr">
       <div class="current">网站注册会员管理</div>
       </div>
         <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tab">
              <thead>
                    <tr>
                            <td>UID</td>
                            <td>登录邮箱</td>
                            <td>昵称</td>
                            <td>手机号码</td>
                            <td>性别</td>
                            <td>状态</td>
                            <td width="150">操作</td>
                        </tr>
                </thead>
                <?php foreach ($list as $key=>$item):?>
                		 <tr align="center" id="<?php echo $item['id']?>">
                		 	<td align="center"><?php echo $item['uid']?></td>
                		 	<td><?php echo $item['email']?></td>
                		 	<td><?php echo $item['nickname']?></td>
                		 	<td><?php echo $item['mobile']?></td>
                		 	<td><?php if($item['sex']==1):?>男<?php else:?>女<?php endif;?></td>
                		 	<td><?php echo $item['status']?></td> 
                		 	<td><a href="/Member/edit?uid=<?php echo $item['uid']?>">[编辑]</a> [ <a link="/Member/del?uid=<?php echo $item['uid']?>" href="javascript:void(0)" name="<?php echo $item['email']?>" class="del">删除 </a> ]</td>
                		 </tr>
                <?php endforeach;?>
                  <tr>
		                <td colspan="7" align="right">
		                 	 <?php echo $this->element('afterpage');?>
		                </td>
		          </tr>
          </table>
         <script type="text/javascript">
            $(function(){
                $(".del").click(function(){
                    var delLink=$(this).attr("link");
                    popup.confirm('你真的打算删除【<b>'+$(this).attr("name")+'</b>】吗?','温馨提示',function(action){
                        if(action == 'ok'){
                            top.window.location.href=delLink;
                            commonAjaxSubmit();
        		            return false;
                        }
                    });
                });
            });
        </script>