	 <style>
            div.spot {
                float: left;
                margin: 0 20px 0 0;
                width: 220px;
                min-height: 160px;
                border: 2px dashed #ddd;
            }
            .droparea {
                position: relative;
                text-align: center;
            }
            .droparea .instructions {
                opacity: 0.8;
                background-color: #cccccc;
                height: 25px;
                z-index: 10;
                zoom: 1;
                background-position: initial initial;
                background-repeat: initial initial;
                cursor: pointer;
            }
            .droparea div, .droparea input {
                position: absolute;
                top: 0;
                width: 100%;
                height: 100%;
            }
            .droparea input {
                cursor: pointer;
                opacity: 0;
            }
            .droparea div, .droparea input {
                position: absolute;
                top: 0;
                width: 100%;
                height: 100%;
            }
            #uparea1,#uparea2,#uparea3{
                height: 170px;
                cursor: pointer;
            }
        </style>
			<div class="Item hr">
                        <div class="current">添加编辑内容</div>
                    </div>
                    <form>
                        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table1">
                        	<tr>
                        		 <td><input type="hidden" name="act" value="<?php if(!empty($data['coid'])):?>edit<?php else:?>add<?php endif;?>" /></td>
                        	</tr>
                            <tr>
                                <th width="100">内容标题：</th>
                                <td><input id="title" type="text" class="input" size="60" name="info[title]" value="<?php echo isset($info['title'])?$info['title']:''?>"/> <a href="javascript:void(0)" id="checkNewsTitle">检测是否重复</a></td>
                            </tr>

                            <tr>
                                <th width="100">内容发布状态：</th>
                               <td><label><input type="radio" name="info[status]" value="0" <?php if($info[status]==2):?>checked="checked"<?php endif;?>> 文章审核状态</label> &nbsp; <label><input type="radio" name="info[status]" value="1" <?php if($info[status]==1):?>checked="checked"<?php endif;?>/> 文章已发布状态</label> </td>
                            </tr>
                            <tr>
                                <th>内容所属分类：</th>
                                <td>
                                    <select name="info[cid]">
                                    	<?php foreach ($list as $key=>$item):?>
                                    			<option value="<?php echo $item['cid']?>" <?php if($info['cid']==$item['cid']){echo 'selected="selected"'; }?>><?php echo $item['name']?></option>
                                    	<?php foreach ($item['cinfo'] as $ck=>$val):?>
                                    			<option value="<?php echo $val['cid']?>" <?php if($info['cid']==$val['cid']){echo 'selected="selected"'; }?>><?php echo '&nbsp;&nbsp;&nbsp;├ '.$val['name']?></option>
                                    	<?php endforeach;?>
                                    	<?php endforeach;?>
                                    </select></td>
                            </tr>
                             <tr id="hidetr">
                            <th width="120">所属栏目：</th>
                            <td>
                                <select name="info[rid]" id="guide">
                                    <option value="0">--请选择--</option>
                                    <?php foreach ($proinfo as $key=>$item):?>
                                    		<option value="<?php echo $item['id']?>" <?php if($info['rid']==$item['id']){echo 'selected="selected"'; }?>style="text-indent:<?php echo $item['Count']*20?>px;"><?php echo '| --'.$item['nav_name']?></option>
                                    <?php endforeach;?>
                                </select>
                            </td>
                       		</tr>
                            <tr>
                                <th>内容图片：</th>
                                <td>
                                    <div class="droparea spot" id="image1" style="background-image: url('<?php echo isset($info['image_url'])?$info['image_url']:''?>');background-size: 220px 160px;" ><div class="instructions" onclick="del_image('1')">删除</div><div id="uparea1"></div><input type="hidden" name="image_url" id="image_1" value="<?php echo isset($info['image_url'])?$info['image_url']:''?>" /></div>
                                </td>
                            </tr>

                            <tr>
                                <th>内容关键词：</th>
                                <td><input type="text" class="input" size="60" name="info[keywords]" value="<?php echo isset($info['keywords'])?$info['keywords']:''?>"/> 多关键词间用半角逗号（,）分开，可用于做文章关联阅读条件</td>
                            </tr>
                            <tr>
                                <th>内容描述：</th>
                                <td><textarea class="input" style="height: 60px; width: 600px;" name="info[description]"><?php echo isset($info['description'])?$info['description']:''?></textarea> 用于SEO的description</td>
                            </tr>
                            <tr>
                                <th>内容摘要：</th>
                                <td><textarea class="input" style="height: 60px; width: 600px;" name="info[summary]"><?php echo isset($info['summary'])?$info['summary']:''?></textarea> 如果不填写则系统自动截取文章前200个字符</td>
                            </tr>
                            <tr>
                                <th>内容内容：</th>
                                <td><textarea id="content" class="" style="height: 300px; width: 80%;" name="info[content]"><?php echo isset($info['content'])?$info['content']:''?></textarea></td>
                            </tr>
                        </table>
                    </form>
                    <div class="commonBtnArea" >
                        <button class="btn submit">提交</button>
                    </div>
                    <script src="/js/kindeditor/kindeditor.js"></script>
                    <script type="text/javascript">
		            function del_image(num){
		                $('#image'+num).css('background-image','');
		                $('#image_'+num).val('');
		            }
		            $(function(){
		                var  content ;
		                KindEditor.ready(function(K) {
		                    content = K.create('#content',{
		                        allowFileManager : true,
		                        uploadJson:'/News/Upload/'
		                    });
		                });
               	 KindEditor.ready(function(K) {
                    K.create();
                    var editor = K.editor({
                        allowFileManager : true,
                        uploadJson:'/News/Upload/'
                        //sdl:false
                    });
                    K('#uparea1').click(function() {
                        editor.loadPlugin('image', function() {
                            editor.plugin.imageDialog({
                                imageUrl : K('#image_1').val(),
                                clickFn : function(url, title, width, height, border, align) {
                                    $('#image1').css('background-image','url('+url+')').css('background-size','220px 160px');
                                    K('#image_1').val(url);
                                   // K('#getImgUrl').val(url);
                                    editor.hideDialog();
                                }
                            });
                        });
                    });
                });
                $("#checkNewsTitle").click(function(){
                    if($('#title').val()==''){
                        popup.error('标题不能为空！');
                        return false;
                    }
                    $.getJSON("/Content/checkContentTitle", { title:$("#title").val(),id:"<?php echo isset($info['id'])?$info['id']:'';?>"}, function(json){
                        $("#checkNewsTitle").css("color",json.status==1?"#0f0":"#f00").html(json.info);
                    });
                });
                $(".submit").click(function(){
                    if($('#title').val()==''){
                        popup.error('标题不能为空！');
                        return false;
                    }
                    content.sync();
                    commonAjaxSubmit();
                    return false;
                });
            });
        </script>