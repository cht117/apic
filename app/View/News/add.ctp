<div class="Item hr">
                        <div class="current">添加编辑内容</div>
                    </div>
                    <form>
                        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table1">
                            <tr>
                        		 <td><input type="hidden" name="act" value="<?php if(!empty($data['nid'])):?>edit<?php else:?>add<?php endif;?>" /></td>
                        	</tr>
                            <tr>
                                <th width="100">活动主题：</th>
                                <td><input id="title" type="text" class="input" size="60" name="info[title]" value="<?php echo isset($info['title'])?$info['title']:''?>"/> <a href="javascript:void(0)" id="checkNewsTitle">检测是否重复</a></td>
                            </tr>

                            <tr>
                                <th width="100">活动发布状态：</th>
                                <td><label><input type="radio" name="info[status]" value="0" <?php if($info['status']==2):?>checked="checked"<?php endif;?>> 活动审核状态</label> &nbsp; <label><input type="radio" name="info[status]" value="1" <?php if($info['status']==1):?>checked="checked"<?php endif;?>/> 活动已发布状态</label> </td>
                            </tr>
                            <tr>
                                <th>活动头图管理：</th>
                                <td><input type="hidden" id="url1" class="input" size="40" name="image_id" value="<?php echo isset($info['img_url'])?$info['img_url']:''?>"/><img src="" width="200" height="150" id="selfimg"/>
                                    <input type="button" class="btn " id="image1" value="选择图片" /></td>
                            </tr>
                            <tr>
                                <th>活动meta关键词：</th>
                                <td><input type="text" class="input" size="60" name="info[keywords]" value="<?php echo isset($info['keywords'])?$info['keywords']:''?>"/> 多关键词间用半角逗号（,）分开用于SEO的keyword</td>
                            </tr>
                            <tr>
                                <th>活动meta描述：</th>
                                <td><textarea class="input" style="height: 60px; width: 600px;" name="info[description]"><?php echo isset($info['description'])?$info['description']:''?></textarea> 用于SEO的description</td>
                            </tr>
                            <tr>
                                <th>活动公告：</th>
                                <td><textarea class="input" style="height: 60px; width: 600px;" name="info[summary]"><?php echo isset($info['summary'])?$info['summary']:''?></textarea></td>
                            </tr>
                            <tr>
                                <th>活动抽奖内容：</th>
                                <td><textarea id="content" class="input" style="height: 300px; width: 100%;" name="info[content]"><?php echo isset($info['content'])?$info['content']:''?></textarea></td>
                            </tr>
                             <tr>
                                <th>抽奖成功提示语：</th>
                                <td><textarea class="input" style="height: 60px; width: 600px;" name="info[sucess]"><?php echo isset($info['sucess'])?$info['sucess']:''?></textarea></td>
                            </tr>
                             <tr>
                                <th>抽奖失败提示语：</th>
                                <td><textarea class="input" style="height: 60px; width: 600px;" name="info[error]"><?php echo isset($info['error'])?$info['error']:''?></textarea></td>
                            </tr>
                        </table>
                    </form>
                    <div class="commonBtnArea" >
                        <button class="btn submit">提交</button>
                    </div>
                    <script src="/js/kindeditor/kindeditor.js"></script>
                    <script type="text/javascript">
				         $(function(){var  content ;
				                KindEditor.ready(function(K) {
				                    content = K.create('#content',{
				                        allowFileManager : true,
				                        uploadJson:'/News/Upload/'
				                    });
				                });
				                $("#checkNewsTitle").click(function(){
				                    $.getJSON("/News/checkNewsTitle", { title:$("#title").val(),id:"<?php echo $list['id']?>"}, function(json){
				                        $("#checkNewsTitle").css("color",json.status==1?"#0f0":"#f00").html(json.info);
				                    });
				                });
				                $(".submit").click(function(){
				                    content.sync();
				                    commonAjaxSubmit();
				                    return false;
				                });
				            });
        		</script>
        		<script>
		            KindEditor.ready(function(K) {
		                var editor = K.editor({
		                    allowFileManager : true,
		                    uploadJson:'/News/Upload/'
		                });
		                K('#image1').click(function() {
		                    editor.loadPlugin('image', function() {
		                        editor.plugin.imageDialog({
		                            imageUrl : K('#url1').val(),
		                            clickFn : function(url, title, width, height, border, align) {
		                                K('#url1').val(url);
		                                K('#selfimg').attr('src',url);
		                                editor.hideDialog();
		                            }
		                        });
		                    });
		                });
		            });
        </script>