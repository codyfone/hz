<?php if (!defined('THINK_PATH')) exit();?><script language="javascript">
$(function(){
	var th = $(".top").height();
	th = 111-th;
	var wh = $(window).height()-th;
	
	$("#Part").treegrid({
		//title:'部门列表',	
		idField:'id',
		treeField:'name',
		height:wh,
		autoRowHeight:false,
		singleSelect:true,
		striped:true,
		rownumbers:true,
		method:'get',
		url:'/index.php/Admin/Part/index/json/1',
		fitColumns:true,
		nowrap:Number('<?php echo (C("DATA_NOWRAP")); ?>'),
		onBeforeLoad: function () {  
			 
		},
		onDblClickRow:function(e,rowIndex,rowData){
			var se = $(this).treegrid('getSelected');
			var idd = se['id'];
			var sts = se['status'];
			//alert(idd);
			if(sts){
				$("#addPart").dialog({
					title:'编辑部门',
					resizable:true,
					width:450,
					height:200,
					method:'get',
					href:'/index.php/Admin/Part/add/act/edit/id/'+idd,
					cache:false,
					onOpen:function(){
						cancel['Part'] = $(this);
					},
					onClose:function(){
						//$(this).dialog('destroy');
						//$("#Part").treegrid('reload');
						cancel['Part'] = null;
					}
				});
			}
		},
		toolbar:[{
		iconCls: 'icon-add',
			text : '新增',
			handler: function(){
				$("#addPart").dialog({
					title:'新增部门',
					resizable:true,
					width:450,
					height:200,
					method:'get',
					href:'/index.php/Admin/Part/add/act/add',
					cache:false,
					onOpen:function(){
						cancel['Part'] = $(this);
					},
					onClose:function(){
						//$(this).dialog('destroy');
						//$("#Part").treegrid('reload');
						cancel['Part'] = null;
					}
				});
			}
		},'-',{
			iconCls: 'icon-edit',
			text : '编辑',
			handler: function(){
				var se = $("#Part").treegrid('getSelected');
				var idd = se['id'];
				var sts = se['status'];
				//alert(idd);
				if(sts){
					$("#addPart").dialog({
						title:'编辑部门',
						resizable:true,
						width:450,
						height:200,
						method:'get',
						href:'/index.php/Admin/Part/add/act/edit/id/'+idd,
						cache:false,
						onOpen:function(){
							cancel['Part'] = $(this);
						},
						onClose:function(){
							//$(this).dialog('destroy');
							//$("#Part").treegrid('reload');
							cancel['Part'] = null;
						}
					});
				}
			}
		},'-',{
			iconCls: 'icon-cancel',
			text : '删除',
			handler: function(){
				var se = $("#Part").treegrid('getSelected');
				var idd = se['id'];
				$.messager.confirm('提示','确定删除吗！',function(r){
					if(r==true){
						$.messager.progress();
						$.get('/index.php/Admin/Part/del/id/'+idd, function(data){
							$.messager.progress('close');
							if(data==1){
								$.messager.alert('提示','删除数据成功！','info',function(){
									$("#Part").treegrid('reload');
								});
							}else if(data==0){
								$.messager.alert('提示','删除数据失败！','warning');
							}else{
								$.messager.alert('提示','您没有删除权限！','warning');
							}
						});
					}
				});	
			}
		},'-',{
			iconCls: 'icon-json',
			text : '更新缓存',
			handler: function(){
				$.get('/index.php/Admin/Part/json', function(data){
					if(data==1){
						$.messager.alert('提示','更新缓存成功！','info');
					}else{
						$.messager.alert('提示','更新缓存失败！','warning');
					}
				});
			}
		}
		,'-',{
			iconCls: 'icon-reload',
			text : '重载',
			handler: function(){
				$("#Part").treegrid('reload');
			}
		}],
		columns:[[   
			{field:'name',title:'名称',width:600},   
			{field:'status',title:'状态',width:90},
			{field:'access',title:'权限值',width:120},
			{field:'comment',title:'备注',width:320}
		]]
	});
});
</script>
<div class="con" id="PartCon" onselectstart="return false;" style="-moz-user-select:none;">
	<table id="Part"></table>
</div>
<div id="addPart"></div>