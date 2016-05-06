<?php if (!defined('THINK_PATH')) exit();?>
<script language="javascript">
var act = '<?php echo ($act); ?>';
$(function(){
	$("#addFormUser<?php echo ($uniqid); ?>").form('load',{
		'username':'<?php echo $info["username"] ?>',
		'email':'<?php echo $info["email"] ?>',
		'mobile':'<?php echo $info["mobile"] ?>',
        'nickname':'<?php echo $info["nickname"] ?>',
        'status':'<?php echo $info["status"] ?>'
	});
});

var idd ='';
function onSubmitUser(idd){
	$.messager.progress();
	$("#addFormUser"+idd).form('submit',{
		url:'/index.php/Admin/Exhibitor/add/act/add/go/1',
		onSubmit: function(){
			var isValid = $(this).form('validate');
			if (!isValid){
				$.messager.progress('close');
			}
			return isValid;
		},
		success:function(data){
			$.messager.progress('close');
			if(data==1){
				$.messager.alert('提示','新增数据成功！','info',function(){
					var sa = '<?php echo (C("SUBMIT_ACTION")); ?>';
					$("#Users").datagrid('reload');
					if(sa==1){
						cancel['User'].dialog('close');
						cancel['User'] = null;
					}
				});
			}else if(data < 0){
				$.messager.alert('提示','您没有新增权限！','warning',function(){
					var sa = '<?php echo (C("SUBMIT_ACTION")); ?>';
					if(sa==1){
						cancel['User'].dialog('close');
						cancel['User'] = null;
					}
				});
			}else if(data==2){
				$.messager.alert('提示','无法发送邮件，请检查邮箱设置！','warning');
			}else if(data==3){
                $.messager.alert('提示','用户名已被注册！','warning');
            }else if(data==4){
                $.messager.alert('提示','邮箱已经被注册！','warning');
            }else if(data==5){
                $.messager.alert('提示','手机号已经被注册！','warning');
            }else{
				$.messager.alert('提示','新增数据失败！','warning');
			}
		}
	});
}

function onUploadUser(idd){
	$.messager.progress();
	var ids = $("#ids"+idd).val();
	$("#addFormUser"+idd).form('submit',{
		url:'/index.php/Admin/Exhibitor/add/act/edit/go/1/id/'+ids,
		onSubmit: function(){
			var isValid = $(this).form('validate');
			if (!isValid){
				$.messager.progress('close');
			}
			return isValid;
		},
		success:function(data){
			$.messager.progress('close');
            console.log(data);
			if(data==1){
				$.messager.alert('提示','更新数据成功！','info',function(){
					var sa = '<?php echo (C("SUBMIT_ACTION")); ?>';
					$("#Users").datagrid('reload');
					if(sa==1){
						cancel['User'].dialog('close');
						cancel['User'] = null;
					}
				});
			}else if (data<0){
				$.messager.alert('提示','您没有修改权限！','warning',function(){
					var sa = '<?php echo (C("SUBMIT_ACTION")); ?>';
					if(sa==1){
						cancel['User'].dialog('close');
						cancel['User'] = null;
					}
				});
			}else if(data==2){
				$.messager.alert('提示','无法发送邮件，请检查邮箱设置！','warning');
			}else if(data==3){
                $.messager.alert('提示','用户名已被注册！','warning');
            }else if(data==4){
                $.messager.alert('提示','邮箱已被注册！','warning');
            }else if(data==5){
                $.messager.alert('提示','手机号已被注册！','warning');
            }else{
				$.messager.alert('提示','更新数据失败！','warning');
			}
		}
	});
}

function onRepwd(idd){
	$.messager.progress();
	var ids = $("#ids"+idd).val();
	$("#addFormUser"+idd).form('submit',{
		url:'/index.php/Admin/Exhibitor/rspwd/id/'+ids,
		onSubmit: function(){
			var isValid = $(this).form('validate');
			if (!isValid){
				$.messager.progress('close');
			}
			return isValid;
		},
		success:function(data){
			$.messager.progress('close');
			if(data==1){
				$.messager.alert('提示','重置密码成功！','info',function(){
					var sa = '<?php echo (C("SUBMIT_ACTION")); ?>';
					if(sa==1){
						cancel['User'].dialog('close');
						cancel['User'] = null;
					}
				});
			}else if(data==0){
				$.messager.alert('提示','重置密码失败！','warning');
			}else if(data==2){
				$.messager.alert('提示','无法发送邮件，请检查邮箱设置！','warning');
			}else{
				
				$.messager.alert('提示','你没有重置密码的权限！','warning',function(){
					var sa = '<?php echo (C("SUBMIT_ACTION")); ?>';
					if(sa==1){
						cancel['User'].dialog('close');
						cancel['User'] = null;
					}
				});
			}
		}
	});
}

function onResetUser(idd){
	cancel['User'].dialog('close');
	cancel['User'] = null;
}
</script>
<div class="con-tb">
<form id="addFormUser<?php echo ($uniqid); ?>" method="post">
 <table class="infobox" width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="23%"><label for="username">用户名</label></td>
    <td width="77%">
    <input name="username" class="easyui-validatebox" size="22" data-options="required:true" /><input id="ids<?php echo ($uniqid); ?>" type="hidden" value="<?php echo ($id); ?>" /></td>
  </tr>
  <tr>
    <td width="23%"><label for="password">密码</label></td>
    <td width="77%"> <input name="password" type="password" class="easyui-validatebox" size="22" /><?php if($act=='add'): ?>(留空时自动生成)<?php endif; ?></td>
  </tr>
  <tr>
    <td width="23%"><label for="nickname">公司名称</label></td>
    <td width="77%"> <input name="nickname" type="text" class="easyui-validatebox" size="42" data-options="required:true" /></td>
  </tr>
  <tr>
    <td width="23%"><label for="mobile">手机号</label></td>
    <td width="77%"><input name="mobile" type="text" class="easyui-validatebox" value="" size="22" data-options="required:true,validType:'Mobile'" /></td>
  </tr>
  <tr>
    <td width="23%"><label for="email">邮箱</label></td>
    <td width="77%"><input name="email" type="text" class="easyui-validatebox" value="" size="22" data-options="required:true,validType:'email'" /></td>
  </tr>
  <tr>
    <td width="23%"><label for="status">状态</label></td>
    <td width="77%">
    <select class="easyui-combobox" name="status" data-options="editable:false">  
        <option value="1">开启</option>  
        <option  value="0">关闭</option>
    </select>
   </td>
  </tr>
  <tr>
    <td height="38" colspan="2" align="center"><?php if($act=='add'): ?><a href="javascript:void(0);" onclick="javascript:onSubmitUser('<?php echo ($uniqid); ?>')" id="su" class="easyui-linkbutton" data-options="iconCls:'icon-save'">保存</a><?php else: ?><a href="javascript:void(0);" onclick="javascript:return onUploadUser('<?php echo ($uniqid); ?>')" id="sue" class="easyui-linkbutton" data-options="iconCls:'icon-save'">保存</a><?php endif; ?> &nbsp; <a href="javascript:void(0);" onclick="javascript:onResetUser('<?php echo ($uniqid); ?>')" id="re" class="easyui-linkbutton" data-options="iconCls:'icon-cancel'">关闭</a> &nbsp; <?php if($act=='edit'): ?><a href="javascript:void(0);" onclick="javascript:return onRepwd('<?php echo ($uniqid); ?>')" id="sur" class="easyui-linkbutton" data-options="iconCls:'icon-save'">重置密码</a><?php endif; ?></td>
  </tr>
 </table>
</form>
</div>