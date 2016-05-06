<?php if (!defined('THINK_PATH')) exit();?><script language="javascript">
var role = '<?php echo ($role); ?>';
if(role==-2){
	$.messager.alert('提示','您没有新增权限！','warning');
	cancel['FileAdd'].dialog('destroy');
	cancel['FileAdd'].dialog('close');
	cancel['FileAdd'] = null;
}else if(role==-3){
	$.messager.alert('提示','您没有编辑权限！','warning');
	cancel['FileAdd'].dialog('destroy');
	cancel['FileAdd'].dialog('close');
	cancel['FileAdd'] = null;
}
function onSubmitFile(idd){
	var dc = $("#description"+idd).val();
	var ids = $("#ids"+idd).val();
	//alert(ids);
	if(dc){
		$.messager.progress();
		$("#addFormFile"+idd).form('submit',{
			url:'/index.php/Admin/Project/file/act/add/go/1/id/'+ids,
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
						$("#filesList").datagrid('reload');
						$("#filesIndexList"+cancel['FilesUniqid']).datagrid('reload');
						if(sa==1){
							cancel['FilesUniqid'] = null;
							cancel['FileAdd'].dialog('destroy');
							cancel['FileAdd'].dialog('close');
							cancel['FileAdd'] = null;
						}
					});
				}else if(data==0){
					$.messager.alert('提示','新增数据失败！','warning');
				}else if(data==-2){
					$.messager.alert('提示','您没有新增权限！',function(){
						var sa = '<?php echo (C("SUBMIT_ACTION")); ?>';
						if(sa==1){
							cancel['FilesUniqid'] = null;
							cancel['FileAdd'].dialog('destroy');
							cancel['FileAdd'].dialog('close');
							cancel['FileAdd'] = null;
						}
					});
				}else{
					//alert(data);
					$.messager.alert('提示',data,'warning',function(){
						var sa = '<?php echo (C("SUBMIT_ACTION")); ?>';
						if(sa==1){
							cancel['FilesUniqid'] = null;
							cancel['FileAdd'].dialog('destroy');
							cancel['FileAdd'].dialog('close');
							cancel['FileAdd'] = null;
						}
					});
				}
			}
		});
	}
}

function onUploadFile(idd){
	$.messager.progress();
	$("#addFormFile"+idd).form('submit',{
		url:'/index.php/Admin/Project/file/act/edit/go/1',
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
					$("#filesList").datagrid('reload');
					$("#filesIndexList"+cancel['FilesUniqid']).datagrid('reload');
					if(sa==1){
						cancel['FilesUniqid'] = null;
						cancel['FileAdd'].dialog('destroy');
						cancel['FileAdd'].dialog('close');
						cancel['FileAdd'] = null;
					}
				});
			}else if(data==-3){
					$.messager.alert('提示','您没有更新权限！',function(){
						var sa = '<?php echo (C("SUBMIT_ACTION")); ?>';
						if(sa==1){
							cancel['FilesUniqid'] = null;
							cancel['FileAdd'].dialog('destroy');
							cancel['FileAdd'].dialog('close');
							cancel['FileAdd'] = null;
						}
					});
			}else if(data==0){
				$.messager.alert('提示','更新数据失败！','warning');
			}else{
				//alert(data);
				$.messager.alert('提示',data,'warning',function(){
					var sa = '<?php echo (C("SUBMIT_ACTION")); ?>';
					if(sa==1){
						cancel['FilesUniqid'] = null;
						cancel['FileAdd'].dialog('destroy');
						cancel['FileAdd'].dialog('close');
						cancel['FileAdd'] = null;
					}
				});
			}
		}
	});
}

function onResetFile(idd){
	cancel['FilesUniqid'] = null;
	cancel['FileAdd'].dialog('destroy');
	cancel['FileAdd'].dialog('close');
	cancel['FileAdd'] = null;
}
</script>

<div class="con-tb">
<form method="post" enctype="multipart/form-data" class="add-file" id="addFormFile<?php echo ($uniqid); ?>">
 <table width="100%" class="infobox linebox reportbox" border="0" cellspacing="0" cellpadding="0" style="border-collapse: collapse;">
 	  <tr>
        <td width="16%" class="rebg"><label>文件名</label><input id="ids<?php echo ($uniqid); ?>" type="hidden" value="<?php echo ($id); ?>" /><input name="files_id" type="hidden" value="<?php echo ($info["id"]); ?>" /></td>
        <td width="84%"><input name="title" type="text" class="easyui-validatebox" style="width:99%;" value="<?php echo ($info["title"]); ?>" /></td>
      </tr>
      <tr>
        <td width="16%" class="rebg"><label>附件</label></td>
        <td width="84%">
         <input name="path" type="file" />
         <?php if($info['path']): ?><br/><?php echo ($info["path"]); endif; ?>
        </td>
      </tr>
      <tr>
        <td width="10%" class="rebg"><label>內容</label></td>
        <td><textarea name="description" id="description<?php echo ($uniqid); ?>"  rows="18" class="easyui-kindeditor" style="width:99%; height:283px" data-options="uploadJson:'/index.php/Admin/Upload/save/'"><?php echo ($info["description"]); ?></textarea></td>
      </tr>
     <tr>
        <td height="38" colspan="2" align="center">
        <?php if($act=='add'): ?><a href="javascript:void(0);" onclick="javascript:onSubmitFile('<?php echo ($uniqid); ?>')" class="easyui-linkbutton" data-options="iconCls:'icon-save'">保存</a><?php else: ?><a href="javascript:void(0);" onclick="javascript:return onUploadFile('<?php echo ($uniqid); ?>')" class="easyui-linkbutton" data-options="iconCls:'icon-save'">保存</a><?php endif; ?> &nbsp; <a href="javascript:void(0);" onclick="javascript:onResetFile('<?php echo ($uniqid); ?>')" class="easyui-linkbutton" data-options="iconCls:'icon-cancel'">关闭</a>
        </td>
     </tr>   
  </table>
</form>
</div>