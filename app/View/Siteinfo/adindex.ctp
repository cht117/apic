<div class="Item hr">
                <div class="current" style="max-width: 100px; float: left;">管理列表</div>
                <div style="width: 100px;float: right;"><button type="button" class="btn" onclick="window.location.href='/Siteinfo/addad/'">添加</button></div>
            </div>
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tab">
                <thead>
                <tr>
                    <td width="5%">ID号</td>
                    <td width="18%">友情链接标题</td>
                    <td width="15%">链接地址</td>
                    <td width="15%">添加人</td>
                    <td width="21%">图片</td>
                    <td width="10%">状态</td>
                    <td width="16%">操作</td>
                </tr>
                </thead>
               	<?php foreach ($list as $key=>$item):?>
                	    <tr align="center" id="<?php echo $item['id']?>">
                		 <td align="center"><?php echo $item['id']?></td>
                		 <td align="left"><?php echo $item['ad_name']?></td>
                		 <td><?php echo $item['ad_link']?></td>
                		 <td><?php echo $item['uname']?></td>
                		 <td><img src="<?php echo isset($item['ad_img'])?$item['ad_img']:'/img/Admin/sv_img_dft1.gif'?>" width="200" height="50"></td>
                		 <td><a href="javascript:void(0);" onclick="changeStatus(<?php echo $item['id']?>,<?php echo $item['status']?>,this)"><?php echo $item['newstatus']?></a></td>
                         <td>[ <a href="/Siteinfo/addad?aid=<?php echo $item['id']?>">编辑 </a> ] [ <a link="/Siteinfo/del?naid=<?php echo $item['id']?>&types=adindex" href="javascript:void(0)" name="<?php echo $item['ad_name']?>" class="del">删除 </a> ]</td>
                		 </tr>
               <?php endforeach;?>
                <tr>
		               <td colspan="7" align="right">
		                 	<?php echo $this->element('afterpage');?>
		               </td>
		        </tr>
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