<?php if (!defined('THINK_PATH')) exit();?><script language="javascript">
var role = '<?php echo ($role); ?>';
var act = '<?php echo ($act); ?>';
if(role==-2){
	$.messager.alert('提示','您没有新增权限！','warning');
	cancel['Project'].dialog('close');
	cancel['Project'] = null;
}else if(role==-3){
	$.messager.alert('提示','您没有编辑权限！','warning');
	cancel['Project'].dialog('close');
	cancel['Project'] = null;
}
$(function(){
	$("#addFormProject<?php echo ($uniqid); ?>").form('load',{
		'exhibition':'<?php echo $info["title"] ?>',
        'linkman':'<?php echo $info["linkman"] ?>',
        'telephone':'<?php echo $info["telephone"] ?>',
        'email':'<?php echo $info["email"] ?>',
        'floor_area':'<?php echo $info["floor_area"] ?>',
        'website':'<?php echo $info["website"] ?>',
		'enddate':'<?php echo $info["enddate"] ?>',
		'views':'<?php echo $info["views"] ?>',
		'userid':'<?php echo $info["userid"] ?>',
        'exhibition_id':'<?php echo $info["exhibition_id"] ?>',
		'code':'<?php echo $info["code"] ?>'
	});
	$("#views<?php echo ($uniqid); ?>").combobox({
		url:'/Application/Runtime/Data/Json/Linkage/chakanquanxian_data.json',
		editable:false,
		method:'get',
		required:true,
		valueField:'id',
		textField:'text',
		onLoadSuccess:function(){
			if(act=='add'){
				$("#views<?php echo ($uniqid); ?>").combobox('setValue',16);
			}
		}
	});
	$("#client_id<?php echo ($uniqid); ?>").combobox({
		url:'/Application/Runtime/Data/Json/Client_data.json',
		editable:true,
		method:'get',
		required:false,
		valueField:'id',
		textField:'text'
	});
	$("#status<?php echo ($uniqid); ?>").combobox({
		url:'/Application/Runtime/Data/Json/Linkage/xiangmuzhuangtai_notit_data.json',
		editable:false,
		method:'get',
		required:false,
		valueField:'id',
		textField:'text'
	});
	$("#pm_id<?php echo ($uniqid); ?>").combotree({
		required:true,
		url:'/Application/Runtime/Data/Json/User_tree_data.json',
		editable:true,
		method:'get',
		required:true,
		valueField:'id',
		textField:'text',
		keyHandler: {
			query : function(q) {
				queryComboTree(q, "pm_id<?php echo ($uniqid); ?>", 0);
			}
		},
		onBeforeSelect:function(node){
			if(isset(node.children)){
				$("#pm_id<?php echo ($uniqid); ?>").tree("unselect");
			}
		}
	});
    $(".jscolor").colorPicker();
});

var idd = '';
function onSubmitProject(idd){
	$.messager.progress();
	$("#addFormProject"+idd).form('submit',{
		url:'/index.php/Admin/Inquiry/add/act/add/go/1',
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
					cancel['ProjectName'].datagrid('reload');
					if(sa==1){
						cancel['Project'].dialog('close');
						cancel['Project'] = null;
					}
				});
			}else if(data==0){
				$.messager.alert('提示','新增数据失败！','warning');
			}else{
				$.messager.alert('提示','您没有新增权限！','warning',function(){
					var sa = '<?php echo (C("SUBMIT_ACTION")); ?>';
					if(sa==1){
						cancel['Project'].dialog('close');
						cancel['Project'] = null;
					}
				});
			}
		}
	});
}

function onUploadProject(idd){
	$.messager.progress();
	var ids = $("#ids"+idd).val();
	$("#addFormProject"+idd).form('submit',{
		url:'/index.php/Admin/Inquiry/add/act/edit/go/1/id/'+ids,
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
					cancel['ProjectName'].datagrid('reload');
					$("#proDetailCon").panel('refresh');
					if(sa==1){
						cancel['Project'].dialog('close');
						cancel['Project'] = null;
					}
				});
				$("#add").dialog('refresh');
			}else if(data==0){
				$.messager.alert('提示','更新数据失败！','warning');
			}else{
				$.messager.alert('提示','您没有更新权限！','warning',function(){
					var sa = '<?php echo (C("SUBMIT_ACTION")); ?>';
					if(sa==1){
						cancel['Project'].dialog('close');
						cancel['Project'] = null;
					}
				});
			}
		}
	});
}

function onResetProject(idd){
	cancel['Project'].dialog('close');
	cancel['ProjectName'] = null;
	cancel['Project'] = null;
}
</script>
<div class="con-tb">
<form class="projecr-form" id="addFormProject<?php echo ($uniqid); ?>" method="post">
 <table class="infobox" width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="13%"><label for="exhibition">展会名称</label><input id="ids<?php echo ($uniqid); ?>" type="hidden" value="<?php echo ($id); ?>" /></td>
    <td><input name="exhibition" type="text" class="easyui-validatebox" value="" style="width:99%;" data-options="required:true,validType:'ptext'" /></td>
    <td><label for="status">项目状态</label></td>
    <td><input name="status" id="status<?php echo ($uniqid); ?>" class="relo" size="10" /> <span>(选择后，将强制改变项目进度)</span></td>
    </tr>
  <tr>
    <td width="13%"><label for="linkman">联系人</label></td>
    <td width="37%"><input name="linkman" id="linkman<?php echo ($uniqid); ?>" data-options="required:true" size="28" /> </td>
    <td width="13%"><label for="telephone">电话</label></td>
    <td width="37%"><input name="telephone" id="telephone<?php echo ($uniqid); ?>" data-options="required:true,validType:'Tel'" size="28" /></td>
  </tr>
  <tr>
    <td width="13%"><label for="email">电子邮箱</label></td>
    <td width="37%"><input name="email" id="email<?php echo ($uniqid); ?>" data-options="required:true,validType:'email'" size="28" /> </td>
  </tr>
  <tr>
    <td width="13%"><label>平面图</label></td>
    <td colspan="3">
      展位号 <input type="text" name="exhibition_no" id="exhibition_no<?php echo ($uniqid); ?>" size="5"> &nbsp;
     展位面积 <input type="text" name="floor_area" id="floor_area<?php echo ($uniqid); ?>" size="5"> &nbsp;
     规格/几面开口 <select class="easyui-combobox" name="open_num" editable="false">  
       <option value='0'>请选择</option>
       <option value="1">1面开口</option>  
       <option value="2">2面开口</option> 
       <option value="3">3面开口</option>  
       <option value="4">4面开口</option>
     </select>
    </td>
  </tr>
  <tr>
    <td width="13%"><label for="code">项目代码</label></td>
    <td width="37%"><input name="code" id="code<?php echo ($uniqid); ?>" class="easyui-validatebox" size="12" data-options="validType:'ptext'" /> (留空时，自动生成) </td>
    <td width="13%"><label for="client_id">所属客户</label></td>
    <td width="37%"><input name="client_id" id="client_id<?php echo ($uniqid); ?>" size="28" class="relo" /></td>
  </tr>
  <tr>
    <td width="13%"><label for="content">备注</label></td>
    <td colspan="3">
    <textarea name="content" id="contentID<?php echo ($uniqid); ?>"  rows="18" style="width:99%; height:100px" data-options="uploadJson:'/index.php/Admin/Upload/save/act/project'"><?php echo ($info["baseinfo"]["content"]); ?></textarea>
    </td>
  </tr>
  <tr>
    <td height="38" colspan="4" align="center"><?php if($act=='add'): ?><a href="javascript:void(0);" onclick="javascript:onSubmitProject('<?php echo ($uniqid); ?>')" id="su" class="easyui-linkbutton" data-options="iconCls:'icon-save'">保存</a><?php else: ?><a href="javascript:void(0);" onclick="javascript:return onUploadProject('<?php echo ($uniqid); ?>')" id="sue" class="easyui-linkbutton" data-options="iconCls:'icon-save'">保存</a><?php endif; ?> &nbsp; <a href="javascript:void(0);" onclick="javascript:onResetProject('<?php echo ($uniqid); ?>')" id="re" class="easyui-linkbutton" data-options="iconCls:'icon-cancel'">关闭</a></td>
  </tr>
 </table>
</form>
</div>