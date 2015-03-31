<div class="Item hr">
                    <div class="current">添加编辑菜单</div>
                </div>
                <form action="/Siteinfo/add_nav" method="post">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table1">
                        <tr>
                            <th width="120">菜单名称：</th>
                            <td><input name="nav_name" type="text" class="input" size="40" value="<?php echo isset($info['nav_name'])?$info['nav_name']:''?>" /> </td>
                        </tr>
                        <tr>
                            <td><td><input type="hidden" name="act" value="<?php if(!empty($data['naid'])):?>edit<?php else:?>add<?php endif;?>" /></td></td>
                        </tr>
                        <tr id="hidetr">
                            <th width="120">父类菜单：</th>
                            <td>
                                <select name="parent_id" id="guide"  style="width: 140px;">
                                    <option value="0">--请选择--</option>
                                    <?php foreach ($pinfo as $key=>$item):?>
                                    		<option value="<?php echo $item['id']?>" <?php if($info['parent_id']==$item['id']){echo 'selected="selected"'; }?>style="text-indent:<?php echo $item['Count']*20?>px;"><?php echo '| --'.$item['nav_name']?></option>
                                    <?php endforeach;?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th width="120">module：</th>
                            <td><input name="module" type="text" class="input" size="40" value="<?php echo isset($info['module'])?$info['module']:'';?>" <?php if($branchs!=2):?>disabled="disabled"/><?php endif;?> </td>
                        </tr>
                        <tr>
                            <th width="120">action：</th>
                            <td><input name="action" type="text" class="input" size="40" value="<?php echo isset($info['action'])?$info['action']:'';?>"  <?php if($branchs!=2):?>disabled="disabled"/><?php endif;?></td>
                        </tr>
                        <tr>
                            <th>打开方式：</th>
                            <td><select name="target" style="min-width: 80px;">
                                <option value="0" <?php if($info['target']==0):?>selected="selected"<?php endif;?>>当前窗口</option>
                                <option value="1" <?php if($info['target']==1):?>selected="selected"<?php endif;?>>新窗口</option>
                            </select></td>
                        </tr>
                        <tr>
                            <th>显示排序：</th>
                            <td><input class="input" name="sort" type="text" size="20" value="<?php echo isset($info['sort'])?$info['sort']:''?>" />此功能暂未开发，第二版开发</td>
                        </tr>
                        <tr>
                            <th>外部链接：</th>
                            <td><input class="input" name="link" type="text" size="40" value="<?php echo isset($info['link'])?$info['link']:''?>" /> 若使用内部链接此处留空！请加上http://</td>
                        </tr>
                    </table>
                    <input type="hidden" name="id" value="<?php echo isset($info['id'])?$info['id']:''?>"/>
                </form>
                <div class="commonBtnArea" >
                    <button class="btn submit">提交</button>
                </div>
                <script type="text/javascript">
					    $(function(){
					        $(".submit").click(function(){
					            commonAjaxSubmit();
					        });
					    });
			</script>