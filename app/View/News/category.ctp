<div class="Item hr">
                        <div class="current">资讯分类管理</div>
                    </div>
                    <form action="" method="post" id="quickForm" target="addInfowin">
                    <iframe name="addInfowin" style="display:none;"></iframe>
                        <b>添加分类：</b>
                        <input type="hidden" name="act" value="add" /> 
                        <input type="hidden" name="data[pid]" value="0" /> 
                        <input placeholder="你要添加的分类名称" id="newName" class="input" type="text" name="data[name]" value="" /> &nbsp;
                        <button class="btn quickSubmit">确定添加</button>
                   	 </form>
                    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="tab">
                <thead>
                <tr align="center">
                    <td width="6%">ID</td>
                    <td width="20%">分类名称</td>
                </tr>
                </thead>
                <tbody>
 					<?php foreach ($list as $key=>$item):?>
                	    <tr align="center" id="<?php echo $item['cid']?>">
                		 <td align="center"><?php echo $item['cid']?></td>
                		 <td align="left"><?php echo $item['name']?></td>
                         <!--  <td>[ <a href="/Siteinfo/add_nav?cid=<?php echo $item['cid']?>">编辑 </a> ] [ <a link="/Siteinfo/del?cid=<?php echo $item['cid']?>" href="javascript:void(0)" name="<?php echo $item['name']?>" class="del">删除 </a> ]</td>-->
                		 </tr>
                	<?php foreach ($item['cinfo'] as $key=>$val):?>
                		 <tr align="center" id="<?php echo $val['cid']?>">
                		 <td align="center"><?php echo $val['cid']?></td>
                		 <td align="left"><?php echo '&nbsp;&nbsp;&nbsp;├ '.$val['name']?></td>
                         <!--  <td>[ <a href="/Siteinfo/add_nav?cid=<?php echo $val['cid']?>">编辑 </a> ] [ <a link="/Siteinfo/del?cid=<?php echo $val['cid']?>/&types=index" href="javascript:void(0)" name="<?php echo $val['name']?>" class="del">删除 </a> ]</td>-->
                		 </tr>
                	<?php endforeach;?>
               		<?php endforeach;?>
		                 <tr>
		                 	 <td colspan="7" align="right">分页样式目前没有分页样式</td>
		                </tr>
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
