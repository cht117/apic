<div class="Item hr">
                <div class="current" style="max-width: 100px; float: left;">菜单管理</div>
                <div style="width: 100px;float: right;"><button type="button" class="btn" onclick="window.location.href='/Siteinfo/add_nav'">添加</button></div>
            </div>
            <table width="100%" border="0" cellpadding="0" cellspacing="0" class="tab">
                <thead>
                <tr align="center">
                    <td width="6%">ID</td>
                    <td width="20%">导航名称</td>
                    <td width="15%">名称</td>
                    <td width="15%">动作</td>
                    <td width="15%">排序</td>
                    <td width="15%">状态</td>
                    <td width="14%">操作</td>
                </tr>
                </thead>
                <tbody>
 					<?php foreach ($list as $key=>$item):?>
                	    <tr align="center" id="<?php echo $item['id']?>">
                		 <td align="center"><?php echo $item['id']?></td>
                		 <td align="left"style="text-indent:<?php echo $item['Count']*20?>px;"><?php echo '| --'. $item['nav_name']?></td>
                		 <td><?php echo $item['module']?></td>
                		 <td><?php echo $item['action']?></td>
                		 <td><?php echo $item['sort']?></td>
                		 <td><a href="javascript:void(0);" onclick="changeStatus(<?php echo $item['id']?>,<?php echo $item['status']?>,this)"><?php echo $item['newstatus']?></a></td>
                         <td>[ <a href="/Siteinfo/add_nav?naid=<?php echo $item['id']?>">编辑 </a> ] [ <a link="/Siteinfo/del?naid=<?php echo $item['id']?>&types=index" href="javascript:void(0)" name="<?php echo $item['nav_name']?>" class="del">删除 </a> ]</td>
                		 </tr>
               		<?php endforeach;?>
                </tbody>
            </table>
            <script>
            $(function(){
                $(".del").click(function(){
                    var delLink=$(this).attr("link");
                    $this = $(this);
                    popup.confirm('你真的打算删除【<b>'+$(this).attr("name")+'</b>】吗?','温馨提示',function(action){
                        if(action == 'ok'){
                            delByLink(delLink,$this);
                            top.window.location.href=delLink;
                            commonAjaxSubmit();
        		            return false;
                        }
                    });
                    return false;
                });
            });
            
            </script>