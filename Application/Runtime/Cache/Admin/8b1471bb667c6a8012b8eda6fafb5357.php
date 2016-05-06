<?php if (!defined('THINK_PATH')) exit();?><script language="javascript">
var role = '<?php echo ($role); ?>';
var act = '<?php echo ($act); ?>';
if(role==-2){
	$.messager.alert('提示','您没有新增权限！','warning');
	cancel['Design'].dialog('close');
	cancel['Design'] = null;
}else if(role==-3){
	$.messager.alert('提示','您没有编辑权限！','warning');
	cancel['Notice'].dialog('close');
	cancel['Notice'] = null;
}
$(function(){
	$("#addFormDesign<?php echo ($uniqid); ?>").form('load',{
		'title':'<?php echo $info["title"] ?>',
		'type':'<?php echo $info["type"] ?>',
		'status':'<?php echo $info["status"] ?>',
		'startdate':'<?php echo $info["startdate"] ?>',
		'enddate':'<?php echo $info["enddate"] ?>',
		'mid':'<?php echo $info["mid"] ?>',
		'plantime':'<?php echo $info["plantime"] ?>',
	});
	
	$("#status<?php echo ($uniqid); ?>").combobox({
		url:'/Application/Runtime/Data/Json/Linkage/renwuzhuangtai_data.json',
		editable:false,
		method:'get',
		required:true,
		valueField:'id',
		textField:'text',
		onLoadSuccess:function(){
			if(act=='add'){
				$("#status<?php echo ($uniqid); ?>").combobox('setValue',9);
			}
		}
	});
	$("#mid<?php echo ($uniqid); ?>").combotree({
		required:true,
		url:'/Admin/designer/members_json',
		editable:true,
		method:'get',
		required:true,
		valueField:'id',
		textField:'text',
		keyHandler: {
			query : function(q) {
				queryComboTree(q, "mid<?php echo ($uniqid); ?>", 0);
			}
		},
		onBeforeSelect:function(node){
			if(isset(node.children)){
				$("#mid<?php echo ($uniqid); ?>").tree("unselect");
			}
		}
	});
});

var idd = '';
function onSubmitDesign(idd){
	$.messager.progress();
	$("#addFormDesign"+idd).form('submit',{
		url:'/index.php/Admin/Project/design/act/add/go/1',
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
				$.messager.alert('提示','新增数据成功！','info',function(){
					var sa = '<?php echo (C("SUBMIT_ACTION")); ?>';
					$("#designTree").tree('reload');
					$("#designList").datagrid('reload');
					if(sa==1){
						cancel['Design'].dialog('destroy');
						cancel['Design'].dialog('close');
						cancel['Design'] = null;
					}
				});
			}else if(data==0){
				$.messager.alert('提示','新增数据失败！','warning');
			}else{
				$.messager.alert('提示','您没有新增权限！','warning',function(){
					var sa = '<?php echo (C("SUBMIT_ACTION")); ?>';
					if(sa==1){
						cancel['Design'].dialog('destroy');
						cancel['Design'].dialog('close');
						cancel['Design'] = null;
					}
				});
			}
		}
	});
}

function onUploadDesign(idd){
	$.messager.progress();
	$("#addFormDesign"+idd).form('submit',{
		url:'/index.php/Admin/Project/design/act/edit/go/1',
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
					$("#designTree").tree('reload');
					$("#proDetailCon").panel('refresh');
					if(sa==1){
						cancel['Design'].dialog('destroy');
						cancel['Design'].dialog('close');
						cancel['Design'] = null;
					}
				});
				$("#add").dialog('refresh');
			}else if(data==2){
				$.messager.alert('提示','该任务已审核，不能更新！','warning');
			}else if(data==0){
				$.messager.alert('提示','更新数据失败！','warning');
			}else{
				$.messager.alert('提示','您没有更新权限！','warning',function(){
					var sa = '<?php echo (C("SUBMIT_ACTION")); ?>';
					if(sa==1){
						cancel['Design'].dialog('destroy');
						cancel['Design'].dialog('close');
						cancel['Design'] = null;
					}
				});
			}
		}
	});
}

function onResetDesign(idd){
	cancel['Design'].dialog('destroy');
	cancel['Design'].dialog('close');
	cancel['Design'] = null;
}
</script>
<div class="con-tb">
<form class="add-design" id="addFormDesign<?php echo ($uniqid); ?>" method="post">
 <table class="infobox" width="100%" border="0" cellspacing="0" cellpadding="0">

  <tr>
    <td width="13%"><label for="mid">设计师</label><input name="id" type="hidden" value="<?php echo ($info["id"]); ?>" /><?php if($act=='add'): ?><input name="pro_id" type="hidden" value="<?php echo ($id); ?>" /><?php else: ?><input name="pro_id" type="hidden" value="<?php echo ($info["pro_id"]); ?>" /><?php endif; ?></td>
    <td width="20%"><input name="mid" id="mid<?php echo ($uniqid); ?>" class="relo" size="18" /></td>
    <td width="13%"><label for="enddate">计划完成日</label></td>
    <td width="20%"><input name="enddate" id="enddate<?php echo ($uniqid); ?>" class="easyui-datepicker" data-options="required:true" size="18" autocomplete="off" /></td>
    <td width="13%"><label for="status">任务状态</label></td>
    <td><input name="status" id="status<?php echo ($uniqid); ?>" class="relo" size="18" /></td>
  </tr>
  <tr>
    <td width="13%"><label for="title">方案标题</label></td>
    <td colspan="5"><input name="title" type="text" class="easyui-validatebox" value="" style="width:99%;" data-options="required:true,validType:'ptext'" /></td>
  </tr>
  <tr>
    <td width="14%"><label for="contents">方案描述</label></td>
    <td colspan="5">
    <textarea name="content" id="contentID<?php echo ($uniqid); ?>"  rows="18" style="width:99%; height:100px"><?php echo ($info["baseinfo"]["content"]); ?></textarea>
    </td>
  </tr>
  <tr></tr>
  <tr>
    <td height="38" colspan="6" align="center"><?php if($act=='add'): ?><a href="javascript:void(0);" onclick="javascript:onSubmitDesign('<?php echo ($uniqid); ?>')" id="su" class="easyui-linkbutton" data-options="iconCls:'icon-save'">保存</a><?php else: ?><a href="javascript:void(0);" onclick="javascript:return onUploadDesign('<?php echo ($uniqid); ?>')" id="sue" class="easyui-linkbutton" data-options="iconCls:'icon-save'">保存</a><?php endif; ?> &nbsp; <a href="javascript:void(0);" onclick="javascript:onResetDesign('<?php echo ($uniqid); ?>')" id="re" class="easyui-linkbutton" data-options="iconCls:'icon-cancel'">关闭</a></td>
  </tr>
 </table>
</form>
</div>