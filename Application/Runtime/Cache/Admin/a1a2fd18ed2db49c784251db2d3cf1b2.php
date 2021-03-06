<?php if (!defined('THINK_PATH')) exit();?><script language="javascript">
$(function(){
	$("#addFormExh<?php echo ($uniqid); ?>").form('load',{
		'name':'<?= $info["name"] ?>',
        'startdate':'<?= $info["startdate"] ?>',
        'enddate':'<?= $info["enddate"] ?>',
        'pavilion_id':'<?= $info["pavilion_id"] ?>',
        'sponsor':'<?= $info["sponsor"] ?>',
        'organizer':'<?= $info["organizer"] ?>',
        'cycle':'<?= $info["cycle"] ?>',
        'first':'<?= $info["first"] ?>',
        'industry':'<?= $info["industry"] ?>',
        'space':'<?= $info["space"] ?>',
        'exhibitor':'<?= $info["exhibitor"] ?>',
        'audience':'<?= $info["audience"] ?>',
        'range':'<?= $info["range"] ?>'
	});
});

var idd = '';
function onSubmitExh(idd){
	$.messager.progress();
	$("#addFormExh"+idd).form('submit',{
		url:'/index.php/Admin/Exhibition/add/act/add/go/1',
		success:function(data){
			$.messager.progress('close');
			if(data==1){
				$.messager.alert('提示','新增数据成功！','info',function(){
					var sa = '<?php echo (C("SUBMIT_ACTION")); ?>';
					$("#Exh").datagrid('reload');
					if(sa==1){
						cancel['Exh'].dialog('close');
						cancel['Exh'] = null;
					}
				});
			}else if(data==0){
				$.messager.alert('提示','新增数据失败！','warning');
			}else{
				$.messager.alert('提示','您没有新增权限！','warning',function(){
					var sa = '<?php echo (C("SUBMIT_ACTION")); ?>';
					if(sa==1){
						cancel['Exh'].dialog('close');
						cancel['Exh'] = null;
					}
				});
			}
		}
	});
}

function onUploadExh(idd){
	$.messager.progress();
	var ids = $("#ids"+idd).val();
	$("#addFormExh"+idd).form('submit',{
		url:'/index.php/Admin/Exhibition/add/act/edit/go/1/id/'+ids,
		success:function(data){
			$.messager.progress('close');
			if(data==1){
				$.messager.alert('提示','更新数据成功！','info',function(){
					var sa = '<?php echo (C("SUBMIT_ACTION")); ?>';
					$("#Exh").datagrid('reload');
					if(sa==1){
						cancel['Exh'].dialog('close');
						cancel['Exh'] = null;
					}
				});
				$("#add").dialog('refresh');
			}else if(data==0){
				$.messager.alert('提示','更新数据失败！','warning');
			}else{
				$.messager.alert('提示','您没有修改权限！','warning',function(){
					var sa = '<?php echo (C("SUBMIT_ACTION")); ?>';
					if(sa==1){
						cancel['Exh'].dialog('close');
						cancel['Exh'] = null;
					}
				});
			}
		}
	});
}

function onResetExh(idd){
	cancel['Exh'].dialog('close');
	cancel['Exh'] = null;
}
</script>
<div class="con-tb">
<form id="addFormExh<?php echo ($uniqid); ?>" method="post">
 <table class="infobox" width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="14%"><label for="name">展会名称</label></td>
    <td width="36%">
    <input name="name" class="easyui-validatebox" data-options="required:true" style="width:99%"><input id="ids<?php echo ($uniqid); ?>" type="hidden" value="<?php echo ($id); ?>"></td>
    <td width="14%"><label for="pavilion_id">所在展馆</label></td>
    <td width="36%"><input name="pavilion_id" class="easyui-combobox relo" id="pavilion_id<?php echo ($uniqid); ?>" size="28" data-options="url:'/index.php/Admin/pavilion/list_json',editable:false,method:'get',required:true,valueField:'id',textField:'text'" /></td>
  </tr>
  <tr>
    <td width="14%"><label for="startdate">开始日期</label></td>
    <td width="36%"><input name="startdate" type="text" class="easyui-datepicker" data-options="required:true" size="12" autocomplete="off"></td>
    <td width="14%"><label for="enddate">结束日期</label></td>
    <td width="36%"><input name="enddate" type="text" class="easyui-datepicker" data-options="required:true" size="12" autocomplete="off"></td>
  </tr>
  <tr>
    <td width="14%"><label for="sponsor">主办方</label></td>
    <td width="36%"><input name="sponsor" type="text" style="width:99%"></td>
    <td width="14%"><label for="organizer">承办方</label></td>
    <td width="36%"><input name="organizer" type="text" style="width:99%"></td>
  </tr>
  <tr>
    <td width="14%"><label for="cycle">举办周期</label>
    <td width="36%"><input name="cycle" type="text" size="20"></td>
    <td width="14%"><label for="first">第一届日期</label></td>
    <td width="36%"><input name="first" type="text" class="easyui-datepicker" size="12" autocomplete="off"></td>
  </tr>
  <tr>
    <td width="14%"><label for="industry">行业</label></td>
    <td width="36%"><input name="industry" type="text" style="width:99%"></td>
    <td width="14%"><label for="space">展览面积</label></td>
    <td width="36%"><input name="space" type="text" style="width:99%"></td>
  </tr>
  <tr>
    <td width="14%"><label for="exhibitor">展商数量</label></td>
    <td width="36%"><input name="exhibitor" type="text" style="width:99%"></td>
    <td width="14%"><label for="audience">观众数量</label></td>
    <td width="36%"><input name="audience" type="text" style="width:99%"></td>
  </tr>
  <tr>
    <td width="14%"><label for="content">展会介绍</label></td>
    <td colspan="3"><textarea name="content" class="easyui-kindeditor" style="width:99%;height:300px" data-options=""></textarea></td>
  </tr>

  <tr>
    <td height="38" colspan="4" align="center"><?php if($act=='add'): ?><a href="javascript:void(0);" onclick="javascript:onSubmitExh('<?php echo ($uniqid); ?>')" id="su" class="easyui-linkbutton" data-options="iconCls:'icon-save'">保存</a><?php else: ?><a href="javascript:void(0);" onclick="javascript:return onUploadExh('<?php echo ($uniqid); ?>')" id="sue" class="easyui-linkbutton" data-options="iconCls:'icon-save'">保存</a><?php endif; ?> &nbsp; <a href="javascript:void(0);" onclick="javascript:onResetExh('<?php echo ($uniqid); ?>')" id="re" class="easyui-linkbutton" data-options="iconCls:'icon-cancel'">关闭</a></td>
  </tr>
 </table>
</form>
</div>