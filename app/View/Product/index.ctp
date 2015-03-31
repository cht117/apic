  <div class="Item hr">
                        <div class="current">产品列表</div>
                    </div>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tab">
                        <thead>
                            <tr>
                                <td>产品标题</td>
                                <td>所在分类</td>
                                <td>发布时间</td>
                                <td>发布人</td>
                                <td>状态</td>
                                <td>推荐</td>
                                <td width="150">操作</td>
                            </tr>
                        </thead>
                       <?php foreach ($list as $key=>$item):?>
                		 <tr align="center" id="<?php echo $item['id']?>">
                		 	<td align="left"><?php echo $item['title']?></td>
                		 	<td><?php echo $item['cname']?></td>
                		 	<td><?php echo date('Y-m-d H:i:s',$item['create_time'])?></td>
                		 	<td><?php echo $item['uname']?></td>
                		 	<td><a href="javascript:void(0);" onclick="changeStatus(<?php echo $item['id']?>,<?php echo $item['status']?>,this)"><?php echo $item['newstatus']?></a></td>
                            <td><a href="javascript:void(0);" onclick="changeAttr(<?php echo $item['id']?>,<?php echo $item['is_recommend']?>,this)"><img src="/img/action_<?php echo $item['is_recommend']?>.png" border="0"></a></td>
                            <td>[ <a href="/Product/add?pid=<?php echo $item['id']?>">编辑 </a> ] [ <a link="/Product/del?pid=<?php echo $item['id']?>" href="javascript:void(0)" name="<?php echo $item['title']?>" class="del">删除 </a> ]</td>
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
            function changeAttr(id,type,v){ //设置推荐
            	$.ajax({
        		    type:"get",
        		    dataType:'json',
        		    url:"/Product/changeAttr",
        		    data:"pid="+id+"&types="+type+"&a="+Math.random(),
        			success:function(msg){
        				if(msg.status==1){
                            $(v).html(msg.info);
                        }
        				window.location.reload()
        			}
        	    });
            }
            function changeStatus(id,type,v){//设置状态 
            	$.ajax({
        		    type:"get",
        		    dataType:'json',
        		    url:"/Product/changestatus",
        		    data:"pid="+id+"&types="+type+"&a="+Math.random(),
        			success:function(msg){
        				if(msg.status==1){
                            $(v).html(msg.info);
                        }
        				window.location.reload()
        			}
        	    });
            }
        </script>