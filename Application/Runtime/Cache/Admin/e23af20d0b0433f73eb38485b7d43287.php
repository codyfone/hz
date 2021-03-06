<?php if (!defined('THINK_PATH')) exit();?><script language="javascript">
$(function(){
	var th = $(".top").height();
	th = 111-th;
	var wh = $(window).height()-th;
	
	$("#Group").datagrid({
		//title:'角色列表',	
		height:wh,
		autoRowHeight:false,
		singleSelect:true,
		striped:true,
		rownumbers:true,
		method:'get',
		url:'/index.php/Admin/Group/index/json/1',
		fitColumns:true,
		nowrap:Number('<?php echo (C("DATA_NOWRAP")); ?>'),
		onBeforeLoad: function () {  
			
		},
		onDblClickRow:function(e,rowIndex,rowData){
			var se = $(this).datagrid('getSelected');
			var idd = se['id'];
			var gidd = "<?php echo $_SESSION['se_groupID'] ?>";
			if(idd>1 && idd!=gidd){
				$("#addGroup").dialog({
					title:'编辑角色',
					resizable:true,
					width:450,
					height:210,
					href:'/index.php/Admin/Group/add/act/edit/id/'+idd,
					onOpen:function(){
						cancel['Group'] = $(this);
					},
					onClose:function(){
						//$(this).dialog('destroy');
						//$("#Group").datagrid('reload');
						cancel['Group'] = null;
					}
				});
			}
		},
		toolbar:[{
		iconCls: 'icon-add',
			text : '新增',
			handler: function(){
				$("#addGroup").dialog({
					title:'新增角色',
					resizable:true,
					width:450,
					height:210,
						href:'/index.php/Admin/Group/add/act/add',
					onOpen:function(){
						cancel['Group'] = $(this);
					},
					onClose:function(){
						//$(this).dialog('destroy');
						//$("#Group").datagrid('reload');
						cancel['Group'] = null;
					}
				});
			}
		},'-',{
			iconCls: 'icon-edit',
			text : '编辑',
			handler: function(){
				var se = $("#Group").datagrid('getSelected');
				var idd = se['id'];
				var gidd = "<?php echo $_SESSION['se_groupID'] ?>";
				if(idd>1 && idd!=gidd){
					$("#addGroup").dialog({
						title:'编辑角色',
						resizable:true,
						width:450,
						height:210,
						href:'/index.php/Admin/Group/add/act/edit/id/'+idd,
						onOpen:function(){
							cancel['Group'] = $(this);
						},
						onClose:function(){
							//$(this).dialog('destroy');
							//$("#Group").datagrid('reload');
							cancel['Group'] = null;
						}
					});
				}
			}
		},'-',{
			iconCls: 'icon-cancel',
			text : '删除',
			handler: function(){
				var se = $("#Group").datagrid('getSelected');
				var idd = se['id'];
				if(idd>1){
					$.messager.confirm('提示','確定刪除吗！',function(r){
						if(r==true){
							$.messager.progress();
							$.get('/index.php/Admin/Group/del/id/'+idd, function(data){
								$.messager.progress('close');
								if(data==1){
									$.messager.alert('提示','删除数据成功！','info',function(){
										$("#Group").datagrid('reload');
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
			}
		},'-',{
			iconCls: 'icon-json',
			text : '更新緩存',
			handler: function(){
				$.get('/index.php/Admin/Group/json', function(data){
					if(data==1){
						$.messager.alert('提示','更新緩存成功！','info');
					}else{
						$.messager.alert('提示','更新緩存失败！','warning');
					}
				});
			}
		},'-',{
			iconCls: 'icon-reload',
			text : '重载',
			handler: function(){
				$("#Group").datagrid('reload');
			}
		}
		],
		columns:[[   
			{field:'name',title:'角色名称',width:250}, 
			{field:'access',title:'权限值',width:120},   
			{field:'status',title:'状态',width:90},
			{field:'comment',title:'备注',width:650}
		]]
	});
});
</script>
<div class="con" id="GroupCon" onselectstart="return false;" style="-moz-user-select:none;">
	<table id="Group"></table>
</div>
<div id="addGroup"></div>