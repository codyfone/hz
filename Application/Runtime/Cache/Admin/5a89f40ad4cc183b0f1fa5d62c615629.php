<?php if (!defined('THINK_PATH')) exit();?><script language="javascript">
function onResetFileDetail(idd){
	cancel['FileDetail'].dialog('destroy');
	cancel['FileDetail'].dialog('close');
	cancel['FileDetail'] = null;
}

function onExcel(id){
	window.location = "/index.php/Admin/Files/word/id/"+id;
}

function onDown(id){
	window.location = "/index.php/Admin/Files/down/id/"+id;
}
</script>

<div class="con-tb">
<form method="post" enctype="multipart/form-data" class="add-filedetail" id="addFormFileDetail<?php echo ($uniqid); ?>">
 <table width="100%" class="infobox linebox reportbox" border="0" cellspacing="0" cellpadding="0" style="border-collapse: collapse;">
 	  <tr>
        <td width="15%" class="rebg"><label>文档名</label></td>
        <td><?php echo ($info["title"]); ?> &nbsp;&nbsp; <a class="font1_color" href="javascript:onExcel(<?php echo ($info["id"]); ?>)">导出Word</a></td>
      </tr>
      <tr>
        <td width="15%" class="rebg"><label>附件</label></td>
        <td>
          <?php if($info['path']): ?><a href="javascript:onDown(<?php echo ($info["id"]); ?>);" target="_blank" class="up-font-over"><img src="/Skin/Admin/Img/files.png" /> 下载</a>
            <?php else: ?>
            <font style="color:#999;"><img src="/Skin/Admin/Img/files.png" /> 下载</font><?php endif; ?>
        </td>
      </tr>
      <tr>
        <td width="15%" height="80" class="rebg"><label>內容</label></td>
        <td><?php echo ($info["description"]); ?></td>
      </tr>
     <tr>
        <td height="38" colspan="2" align="center">
        <a href="javascript:void(0);" onclick="javascript:onResetFileDetail('<?php echo ($uniqid); ?>')" class="easyui-linkbutton" data-options="iconCls:'icon-cancel'">关闭</a>
        </td>
     </tr>   
  </table>
</form>
</div>