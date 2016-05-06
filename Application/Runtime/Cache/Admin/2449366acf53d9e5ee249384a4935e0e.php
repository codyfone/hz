<?php if (!defined('THINK_PATH')) exit();?><script language="javascript">
$(function(){
	var th = $(".top").height();
	th = 111-th;
	var wh = $(window).height()-th;
	$("#ProjectDetail").width();
    $("#leftDesign").height(wh);
	$(".panelson").height(wh);
	
});

function onClickDesign(node){
    console.log(node);
	var idpa = isset(node._parentId);
	var id = node.id;
	if(idpa){
		$("#proDetailCon").panel('refresh','/index.php/Admin/Project/content/id/<?php echo ($id); ?>/tid/'+id);
	}else{
		$("#proDetailCon").panel('refresh','/index.php/Admin/Project/content/id/'+id);
	}
}

function onCheckTree(){
	var tid = '<?php echo ($tid); ?>';
	if(tid){
		var node = $('#designTree').tree('find',tid);
		$('#designTree').tree('check', node.target);
	}
}
</script>
 <div class="easyui-layout" data-options="fit:true">   
    <div data-options="region:'west',border:false" style="width:248px">
     <div id="leftDesign" class="easyui-accordion" style="width:238px;">
	  <div title="项目方案与报价" data-options="selected:true">   
       <ul id="designTree" class="easyui-tree left-tree" data-options="url:'/index.php/Admin/Project/getDesign/pid/<?php echo ($id); ?>',editable:false,lines:true,method:'get',onClick:function(node){onClickDesign(node);},onLoadSuccess:function(node){onCheckTree();}"></ul>
      </div> 
      </div>
    </div>   
   <div data-options="region:'center',border:false">
     <div class="design-right">
      <?php if($tid): ?><div id="proDetailCon" class="easyui-panel panelson" data-options="href:'/index.php/Admin/Project/content/id/<?php echo ($id); ?>/tid/<?php echo ($tid); ?>',border:false"> </div>
      <?php else: ?>
       <div id="proDetailCon" class="easyui-panel panelson" data-options="href:'/index.php/Admin/Project/content/id/<?php echo ($id); ?>',border:false"> </div><?php endif; ?> 
     </div>
   </div>   
 </div>