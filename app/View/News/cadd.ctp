<div class="Item hr">
                        <div class="current">分类修改</div>
                    </div>
                    <form action="" method="post">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table1">
                            <tr>
                                <th width="120">分类名称：</th>
                                <td><input name="name"  id="name"  type="text" class="input" size="40" value="<?php echo $info['name']?>" /><font  color="red">*</font></td>
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
		        commonAjaxSubmit();
	        });
	    });
</script>