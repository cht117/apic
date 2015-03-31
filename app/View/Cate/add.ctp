<div class="Item hr">
                        <div class="current">添加/修改</div>
                    </div>
                    <form action="" method="post">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table1">
                            <tr>
                                <th width="120">分类名称：</th>
                                <td><input name="name"  id="name"  type="text" class="input" size="40" value="<?php echo $info['name']?>" /><font  color="red">*</font></td>
                            </tr>
                            <tr>
                                <th width="120">排序：</th>
                                <td><input name="sort" id="sort"  type="text" class="input" size="40" value="<?php echo $info['sort']?$info['sort']:0?>" /></td>
                            </tr>                            
                        </table>
                    </form>
                    <div class="commonBtnArea" >
                        <button class="btn submit">提交</button>
                    </div>
                    
<script type="text/javascript">
	    $(function(){
	        $(".submit").click(function(){
		        var name = $("#name").val();
		        if(name==null || name=='')
		        {
			        alert('分类名称不能为空');
			        return false;
		        }
		        var sort = $("#sort").val();
		        var re = /^[0-9]+.?[0-9]*$/; 
		        if (!re.test(sort))
		        {
		            alert("排序应为数字");
		            $("#sort").val('');
		            return false;
		         }
	            commonAjaxSubmit();
	        });
	    });
</script>