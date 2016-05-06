<?php if (!defined('THINK_PATH')) exit();?><script language="javascript">
$(function(){
	$("#addFormGroup<?php echo ($uniqid); ?>").form('load',{
		'name':'<?php echo $info["name"] ?>',
		'access':'<?php echo $info["access"] ?>',
		'status':'<?php echo $info["status"] ?>'
	});
});

var idd = '';
function onSubmitGroup(idd){
	$.messager.progress();
	$("#addFormGroup<?php echo ($uniqid); ?>").form('submit',{
		url:'/index.php/Admin/MemberGroup/add/act/add/go/1',
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
					$("#Group").datagrid('reload');
					if(sa==1){
						cancel['Group'].dialog('close');
						cancel['Group'] = null;
					}
				});
			}else if(data==0){
				$.messager.alert('提示','新增数据失败！','warning');
			}else{
				$.messager.alert('提示','您没有新增权限！','warning',function(){
					var sa = '<?php echo (C("SUBMIT_ACTION")); ?>';
					if(sa==1){
						cancel['Group'].dialog('close');
						cancel['Group'] = null;
					}
				});
			}
		}
	});
}

function onUploadGroup(idd){
	$.messager.progress();
	var ids = $("#ids"+idd).val();
	$("#addFormGroup<?php echo ($uniqid); ?>").form('submit',{
		url:'/index.php/Admin/MemberGroup/add/act/edit/go/1/id/'+ids,
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
				$.messager.alert('提示','更新数据成功！','info',function(){
					var sa = '<?php echo (C("SUBMIT_ACTION")); ?>';
					$("#Group").datagrid('reload');
					if(sa==1){
						cancel['Group'].dialog('close');
						cancel['Group'] = null;
					}
				});
			}else if(data==0){
				$.messager.alert('提示','更新数据失败！','warning');
			}else{
				$.messager.alert('提示','您没有修改权限！','warning',function(){
					var sa = '<?php echo (C("SUBMIT_ACTION")); ?>';
					if(sa==1){
						cancel['Group'].dialog('close');
						cancel['Group'] = null;
					}
				});
			}
		}
	});
}

function onResetGroup(idd){
	cancel['Group'].dialog('close');
	cancel['Group'] = null;
}
</script>
<div class="con-tb">
<form id="addFormGroup<?php echo ($uniqid); ?>" method="post">
 <table class="infobox" width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="23%"><label for="name">会员组</label></td>
    <td width="77%">
    <input name="name" class="easyui-validatebox"  size="22" data-options="required:true" /><input id="ids<?php echo ($uniqid); ?>" type="hidden" value="<?php echo ($id); ?>" /></td>
  </tr>
  <tr>
    <td width="23%"><label for="name">会员类型</label></td>
    <td width="77%">
        <select class="easyui-combobox" name="modelid">  
        <option value="1">展商</option>
        <option  value="2">设计师</option>
        <option  value="3">工厂</option>
    </select>
    
    </td>
  </tr>
  
  <tr>
    <td width="23%"><label for="status">状态</label></td>
    <td width="77%">
    <select class="easyui-combobox" name="status">  
        <option value="1">开启</option>  
        <option  value="0">关闭</option>  
    </select>
   </td>
  </tr>
  <tr>
    <td width="23%"><label for="comment">备注</label></td>
    <td width="77%"><textarea name="comment" cols="38" rows="2" class="easyui-validatebox report-text"><?php echo $info["comment"] ?></textarea></td>
  </tr>
  <tr>
    <td height="38" colspan="2" align="center"><?php if($act=='add'): ?><a href="javascript:void(0);" onclick="javascript:onSubmitGroup('<?php echo ($uniqid); ?>')" id="su" class="easyui-linkbutton" data-options="iconCls:'icon-save'">保存</a><?php else: ?><a href="javascript:void(0);" onclick="javascript:return onUploadGroup('<?php echo ($uniqid); ?>')" id="sue" class="easyui-linkbutton" data-options="iconCls:'icon-save'">保存</a><?php endif; ?> &nbsp; <a href="javascript:void(0);" onclick="javascript:onResetGroup('<?php echo ($uniqid); ?>')" id="re" class="easyui-linkbutton" data-options="iconCls:'icon-cancel'">关闭</a></td>
  </tr>
 </table>
</form>
</div>