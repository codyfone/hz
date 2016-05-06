<?php if (!defined('THINK_PATH')) exit();?><script language="javascript">
$(function(){
	var th = $(".top").height();
	th = 111-th;
	var wh = $(window).height()-th;
	
	$("#Exh").datagrid({
		//title:'展会列表',	
		height:wh,
		autoRowHeight:false,
		singleSelect:true,
		striped:true,
		rownumbers:true,
		method:'get',
		url:'/index.php/Admin/Exhibition/index/json/1',
		fitColumns:true,
		nowrap:Number('<?php echo (C("DATA_NOWRAP")); ?>'),
		onBeforeLoad: function () {  
			
		},
		onDblClickRow:function(e,rowIndex,rowData){
			var se = $(this).datagrid('getSelected');
			var idd = se['id'];
			$("#addExh").dialog({
				title:'编辑展会',
				resizable:true,
				width:805,
				height:406,
				href:'/index.php/Admin/Exhibition/add/act/edit/id/'+idd,
				onOpen:function(){
					cancel['Exh'] = $(this);
				},
				onClose:function(){
					//$(this).dialog('destroy');
					//$("#Exh").datagrid('reload');
					cancel['Exh'] = null;
				}
			});
		},
		toolbar:[{
		iconCls: 'icon-add',
			text : '新增',
			handler: function(){
				$("#addExh").dialog({
					title:'新增展会',
					resizable:true,
                    width:805,
                    height:406,
					href:'/index.php/Admin/Exhibition/add/act/add',
					onOpen:function(){
						cancel['Exh'] = $(this);
					},
					onClose:function(){
						//$(this).dialog('destroy');
						//$("#Exh").datagrid('reload');
						cancel['Exh'] = null;
					}
				});
			}
		},'-',{
			iconCls: 'icon-edit',
			text : '编辑',
			handler: function(){
				var se = $("#Exh").datagrid('getSelected');
				var idd = se['id'];
				$("#addExh").dialog({
					title:'编辑展会',
					resizable:true,
					width:805,
					  height:406,
					href:'/index.php/Admin/Exhibition/add/act/edit/id/'+idd,
					onOpen:function(){
						cancel['Exh'] = $(this);
					},
					onClose:function(){
						//$(this).dialog('destroy');
						//$("#Exh").datagrid('reload');
						cancel['Exh'] = null;
					}
				});
			}
		},'-',{
			iconCls: 'icon-cancel',
			text : '删除',
			handler: function(){
				var se = $("#Exh").datagrid('getSelected');
				var idd = se['id'];
				$.messager.confirm('提示','确定刪除吗！',function(r){
					if(r==true){
						$.messager.progress();
						$.get('/index.php/Admin/Exhibition/del/id/'+idd, function(data){
							$.messager.progress('close');
							if(data==1){
								$.messager.alert('提示','删除数据成功！','info',function(){
									$("#Exh").datagrid('reload');
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
		},{
			iconCls: 'icon-reload',
			text : '重载',
			handler: function(){
				$("#Exh").datagrid('reload');
			}
		}
		],
		columns:[[   
			{field:'name',title:'展会名称',width:200},
			{field:'startdate',title:'开始时间',width:80},   
			{field:'enddate',title:'结束时间',width:80},
			{field:'pavilion_name',title:'展馆',width:150},
			{field:'exhibitor',title:'展商数',width:150},
			{field:'addtime',title:'添加时间',width:70}
		]]
	});
});
</script>
<div class="con" id="ExhCon" onselectstart="return false;" style="-moz-user-select:none;">
	<table id="Exh"></table>
</div>
<div id="addExh"></div>