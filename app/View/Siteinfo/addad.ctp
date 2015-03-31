<div class="contentArea">
                <div class="Item hr">
                    <div class="current">添加编辑内容</div>
                </div>
                <form action="/Siteinfo/upload" method="post" enctype="multipart/form-data" method="post" target="addInfowin" id="form1" >
                	<iframe name="addInfowin" style="display:none;"></iframe>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table1">
                    	 <tr>
                        		 <td><input type="hidden" name="act" value="<?php if(!empty($data['aid'])):?>edit<?php else:?>add<?php endif;?>" /></td>
                        	</tr>
                        <tr>
                            <th width="120">友情链接名称：</th>
                            <td><input id="name" name="info[ad_name]" type="text" class="input" size="40" value="<?php echo isset($info['ad_name'])?$info['ad_name']:''?>" /> </td>
                        </tr>
                        
                        <tr id="hidetr">
                            <th width="120">上传图片：</th>
                            	<td><input type="file" class="input" size="60" name="imgFile" value=""/> <input type="button" value="上传" onclick="document.getElementById('form1').submit()">
                            		<input type="hidden" name="info[ad_img]" value="<?php echo isset($info['ad_img'])?$info['ad_img']:'';?>" id="ad_img">
                            </td>
                        </tr>
                         <tr>
                            <th>图片显示：</th>
                            <td><a href="javascript:void(0);" class="sv_img_add2"><img src="<?php echo isset($info['ad_img'])?$info['ad_img']:'/img/Admin/sv_img_dft1.gif'?>" border="0" height="153" width="308"></a></td>
                        </tr>
                        <tr>
                            <th>链接地址：</th>
                            <td><input class="input" name="info[ad_link]" id="link" type="text" size="50" value="<?php echo isset($info['ad_link'])?$info['ad_link']:'';?>" /> 请加上http://</td>
                        </tr>
                        
                    </table>
                    <input type="hidden" name="id" value="<?php echo isset($info['id'])?$info['id']:''?>"/>
                </form>
                <div class="commonBtnArea" >
                    <button class="btn submit">提交</button>
                </div>
            </div>
            <script type="text/javascript">
			    $(function(){
			        $(".submit").click(function(){
				        var adname = $("#name").val();
				        var link = $("#link").val();
				        if(adname==null || adname=='')
				        {
					        alert("请输入链接名称");
					        return false;
				        }
				        else if(link==null || link==''){
				        	 alert("请输入链接");
					        return false;
				        }
			            commonAjaxSubmit();
			        });
			    });
			    function uploadpic(txt){
			    	var image = $(".sv_img_add2 img");
			    	if(txt.code==1){
			    		image.attr("src",txt.img_url);
				    	$("#ad_img").val(txt.img_url);
			    	}else{
			    		alert(txt.message);return false;
				    }	
			    }
			</script>