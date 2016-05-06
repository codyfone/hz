<?php if (!defined('THINK_PATH')) exit();?><script language="javascript">
$(function(){
	var th = $(".top").height();
	th = 111-th;
	var wh = $(window).height()-th;
	
	$("#Pav").datagrid({
		//title:'展馆列表',	
		height:wh,
		idField:'id',
		autoRowHeight:false,
		singleSelect:true,
		striped:true,
		rownumbers:true,
		method:'get',
		url:'/index.php/Admin/Pavilion/index/json/1',
		fitColumns:true,
		nowrap:Number('<?php echo (C("DATA_NOWRAP")); ?>'),
		onBeforeLoad: function () {  
			
		},
		onDblClickRow:function(e,rowIndex,rowData){
			var se = $(this).datagrid('getSelected');
			var idd = se['id'];
			$("#addPav").dialog({
				title:'编辑展馆',
				resizable:true,
				width:850,
				height:406,
				href:'/index.php/Admin/Pavilion/add/act/edit/id/'+idd,
				onOpen:function(){
					cancel['Pav'] = $(this);
				},
				onClose:function(){
					//$(this).dialog('destroy');
					//$("#Pav").datagrid('reload');
					cancel['Pav'] = null;
				}
			});
		},
		toolbar:[{
		iconCls: 'icon-add',
			text : '新增',
			handler: function(){
				$("#addPav").dialog({
					title:'新增展馆',
					resizable:true,
					width:850,
					height:406,
					href:'/index.php/Admin/Pavilion/add/act/add',
					onOpen:function(){
						cancel['Pav'] = $(this);
					},
					onClose:function(){
						//$(this).dialog('destroy');
						//$("#Pav").datagrid('reload');
						cancel['Pav'] = null;
					}
				});
			}
		},'-',{
			iconCls: 'icon-edit',
			text : '编辑',
			handler: function(){
				var se = $("#Pav").datagrid('getSelected');
				var idd = se['id'];
				$("#addPav").dialog({
					title:'编辑展馆',
					resizable:true,
					width:850,
					  height:406,
					href:'/index.php/Admin/Pavilion/add/act/edit/id/'+idd,
					onOpen:function(){
						cancel['Pav'] = $(this);
					},
					onClose:function(){
						//$(this).dialog('destroy');
						//$("#Pav").datagrid('reload');
						cancel['Pav'] = null;
					}
				});
			}
		},'-',{
			iconCls: 'icon-cancel',
			text : '删除',
			handler: function(){
				var se = $("#Pav").datagrid('getSelected');
				var idd = se['id'];
				$.messager.confirm('提示','确定刪除吗！',function(r){
					if(r==true){
						$.messager.progress();
						$.get('/index.php/Admin/Pavilion/del/id/'+idd, function(data){
							$.messager.progress('close');
                            console.log(data);
							if(data==1){
								$.messager.alert('提示','删除数据成功！','info',function(){
									$("#Pav").datagrid('reload');
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
			iconCls: 'icon-reload',
			text : '重载',
			handler: function(){
				$("#Pav").datagrid('reload');
			}
		}
		],
		columns:[[
            {field:'id',title:'ID',checkbox:true},
			{field:'name',title:'展馆名称',width:200},
			{field:'city',title:'城市',width:80},   
			{field:'addr',title:'地址',width:80},
			{field:'telephone',title:'联系电话',width:150},
			{field:'addtime',title:'添加时间',width:70}
		]]
	});
});
</script>
<div class="con" id="PavCon" onselectstart="return false;" style="-moz-user-select:none;">
	<table id="Pav"></table>
</div>
<div id="addPav"></div>