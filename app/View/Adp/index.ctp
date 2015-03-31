
<div class="Item hr">
	<div class="current">管理员列表</div>	
</div>
<table width="100%" border="0" cellspacing="0" cellpadding="0"
	class="tab">
	<thead>
		<tr>
			<td><input type="checkbox" id="checkedall"/>全选</td>
			<td>ID</td>
			<td>广告位置</td>
			<td>点击量</td>
			<td>更新时间</td>
			<td width="150">操作</td>
		</tr>
	</thead>
                        <?php foreach ($list as $key=>$item):?>
                        		 <tr align="center"
		aid="<?php echo $item['id']?>">
		<td><input type="checkbox" name="items" value="<?php echo $item['id']?>"/></td>
		<td><?php echo $item['id']?></td>
		<td><?php echo $item['name']?></td>
		<td><?php echo $item['hits']?></td>
		<td><?php echo $item['updtime']?></td>
		<td>[ <a href="/Adp/add?id=<?php echo  $item['id'];?>">编辑</a> ] [ <a
			link="/Adp/del?id=<?php echo $item['id']?>" href="javascript:void(0)"
			name="<?php echo $item['name']?>" class="del">删除 </a> ]
		</td>
                        <?php endforeach;?>
                        
	
	
	<tr>
	<td colspan="3" align="left">
		              <button class="btn" onclick="clear();" >清空点击量</button> 
		               <button class="btn" onclick="delAll();" >批量删除</button>   	 		
		                 	 </td>
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
                        	//commonAjaxSubmit(delLink);
                        	//handledata("post",delLink,'','',functionname);
                            //delByLink(delLink,$this);
                           // top.window.location.href=delLink;
                           //commonAjaxSubmit();
        		           // return false;
                        	diyAjax(delLink);
                        	
                        }
                    });
                    return false;
                });
                ///全选 反选功能
                $('#checkedall').click(function(){
                $('[name=items]:checkbox').attr("checked", this.checked);
                }) 
                
               /*  
                $("#btn5").click(function(){     
                    var str="";     
                    $("[name='checkbox'][checked]").each(function(){     
                     str+=$(this).val()+""r"n";     
                   //alert($(this).val());     
                    })     
                   alert(str);     
                    })  */  


                
            });
			function getSelectVal()
			{
				 var ids=new array();     
                 $("[name='items'][checked]").each(function(){     
                	ids.push($(this).val()); 
                 })     
                alert(ids.join(","));
                 return ids;
			}
			function clear()
			{
				alert(111);;
				//var ids = getSelectVal();
				
			}
			function delAll()
			{
				
			}

            
</script>