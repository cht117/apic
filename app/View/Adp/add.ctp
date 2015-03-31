<div class="Item hr">
                        <div class="current">广告位添加/修改</div>
                    </div>
                    <form action="" method="post">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table1">
                            <tr>
                                <th width="120">位置名称：</th>
                                <td><input name="name"  id="name"  type="text" class="input" size="40" value="<?php echo $info['name']?>" /><font  color="red">*</font></td>
                            </tr>
                            <tr>
                                <th width="120">点击量：</th>
                                <td><input name="hits" id="hits"  type="text" class="input" size="40" value="<?php echo $info['hits']?$info['hits']:0?>" /></td>
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
			        alert('广告位置不能为空');
			        return false;
		        }
		        var hits = $("#hits").val();
		        var re = /^[0-9]+.?[0-9]*$/; 
		        if (!re.test(hits))
		        {
		            alert("点击量应为数字");
		            $("#hits").val('');
		            return false;
		         }
	            commonAjaxSubmit();
	        });
	    });
</script>