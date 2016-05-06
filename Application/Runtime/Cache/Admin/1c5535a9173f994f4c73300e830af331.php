<?php if (!defined('THINK_PATH')) exit();?><script language="javascript">
$(function(){
	$("#addFormPav<?php echo ($uniqid); ?>").form('load',{
		'name':'<?php echo $info["name"] ?>',
		'telephone':'<?php echo $info["telephone"] ?>',
        'addr':'<?php echo $info["addr"] ?>',
        'cityid':'<?php echo $info["cityid"] ?>',
        'website':'<?php echo $info["website"] ?>'
	});
        // 省级 
     $('#province').combobox({
            valueField:'id',
            textField:'name',
            url:'/index.php/Admin/citys/list_json',
            panelHeight:200,
            required:true,
            editable:false,
            value:'<?= $info['province_id']?$info['province_id']:'--请选择--' ?>',
            onChange:function(pid){
                $('#city').combobox({
                valueField:'id',
                textField:'name',
                url:'/index.php/Admin/citys/list_json/id/'+pid,
                panelHeight:200,
                required:true,
                editable:false,
                value:'--请选择--',
                onChange:function(cid){
                   $("#cityid").val(cid);
                }
            });
             $("#cityid").val(pid);
            }
         });
    //县市区
    $('#city').combobox({
            valueField:'id',
            textField:'name',
            <?php if($info['province_id']){ ?>url:'/index.php/Admin/citys/list_json/id/'+'<?= $info['province_id'] ?>',<?php } ?>
            panelHeight:200,
            required:true,
            editable:false,
            value:'<?= $info['cityid']?$info['cityid']:'--请选择--' ?>',
            onChange:function(cid){
               $("#cityid").val(cid);
            }
        });
});

var idd = '';
function onSubmitPav(idd){
	$.messager.progress();
	$("#addFormPav"+idd).form('submit',{
		url:'/index.php/Admin/Pavilion/add/act/add/go/1',
		success:function(data){
			$.messager.progress('close');
            console.log(data);
			if(data==1){
				$.messager.alert('提示','新增数据成功！','info',function(){
					var sa = '<?php echo (C("SUBMIT_ACTION")); ?>';
					$("#Pav").datagrid('reload');
					if(sa==1){
						cancel['Pav'].dialog('close');
						cancel['Pav'] = null;
					}
				});
			}else if(data==0){
				$.messager.alert('提示','新增数据失败！','warning');
			}else{
				$.messager.alert('提示','您没有新增权限！','warning',function(){
					var sa = '<?php echo (C("SUBMIT_ACTION")); ?>';
					if(sa==1){
						cancel['Pav'].dialog('close');
						cancel['Pav'] = null;
					}
				});
			}
		}
	});
}

function onUploadPav(idd){
	$.messager.progress();
	var ids = $("#ids"+idd).val();
	$("#addFormPav"+idd).form('submit',{
		url:'/index.php/Admin/Pavilion/add/act/edit/go/1/id/'+ids,
		success:function(data){
			$.messager.progress('close');
            console.log(data);
			if(data==1){
				$.messager.alert('提示','更新数据成功！','info',function(){
					var sa = '<?php echo (C("SUBMIT_ACTION")); ?>';
					$("#Pav").datagrid('reload');
					if(sa==1){
						cancel['Pav'].dialog('close');
						cancel['Pav'] = null;
					}
				});
				$("#add").dialog('refresh');
			}else if(data==0){
				$.messager.alert('提示','更新数据失败！','warning');
			}else{
				$.messager.alert('提示','您没有修改权限！','warning',function(){
					var sa = '<?php echo (C("SUBMIT_ACTION")); ?>';
					if(sa==1){
						cancel['Pav'].dialog('close');
						cancel['Pav'] = null;
					}
				});
			}
		}
	});
}

function onResetPav(idd){
	cancel['Pav'].dialog('close');
	cancel['Pav'] = null;
}
</script>
<div class="con-tb">

<form id="addFormPav<?php echo ($uniqid); ?>" method="post">
 <table class="infobox" width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="14%"><label for="name">展馆名称</label></td>
    <td width="36%"><input name="name" class="easyui-validatebox" data-options="required:true" style="width: 99%"><input id="ids<?php echo ($uniqid); ?>" type="hidden" value="<?php echo ($id); ?>"></td>
    <td width="14%"><label for="telephone">联系电话</label></td>
    <td width="36%"><input name="telephone" class="easyui-validatebox" data-options="required:true,validType:'Tel'" size="28"  /></td>
  </tr>
  <tr>
    <td width="14%"><label for="cityid">地区</label></td>
    <td width="36%">
      <input type="hidden" name="cityid" value="<?php echo ($info['cityid']); ?>">
      <select id="province" style="width: 128px" class="easyui-validatebox"></select>
      <select id="city" style="width: 128px" class="easyui-validatebox"></select></td>
    <td><label for="name">地址</label></td>
    <td><input name="addr" class="easyui-validatebox" data-options="required:true" style="width: 99%"></td>
  </tr>
  <tr>
    <td width="14%"><label for="website">网址</label></td>
    <td width="36%"><input name="website" class="easyui-validatebox" data-options="required:false" style="width: 99%" placeholder="示例:http://www.baidu.com/"></td>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td width="14%"><label for="images">图片展示</label></td>
    <td colspan="3">
      <textarea class="easyui-ueditor" name="images" id="images" data-options="editType:'upMutiImgs'" style="display: none;"><?php echo ($info['images']); ?></textarea>
    </td>
  </tr>
  <tr>
    <td width="14%"><label for="dimensions">规模</label></td>
    <td colspan="3"><textarea name="dimensions" id="dimensions" data-options="required:false" style="height:100px;width: 99%"><?php echo ($info['demansions']); ?></textarea></td>
  </tr>
  <tr>
    <td width="14%"><label for="dimensions">介绍</label></td>
    <td colspan="3"><textarea class="easyui-kindeditor" name="content" id="content" style="height:300px;width: 99%"><?php echo ($info['content']); ?></textarea></td>
  </tr>
  <tr>
    <td height="38" colspan="4" align="center"><?php if($act=='add'): ?><a href="javascript:void(0);" onclick="javascript:onSubmitPav('<?php echo ($uniqid); ?>')" id="su" class="easyui-linkbutton" data-options="iconCls:'icon-save'">保存</a><?php else: ?><a href="javascript:void(0);" onclick="javascript:return onUploadPav('<?php echo ($uniqid); ?>')" id="sue" class="easyui-linkbutton" data-options="iconCls:'icon-save'">保存</a><?php endif; ?> &nbsp; <a href="javascript:void(0);" onclick="javascript:onResetPav('<?php echo ($uniqid); ?>')" id="re" class="easyui-linkbutton" data-options="iconCls:'icon-cancel'">关闭</a></td>
  </tr>
 </table>
</form>
</div>