<?php if (!defined('THINK_PATH')) exit();?><script language="javascript">
$(function(){
	var th = $(".top").height();
	th = 111-th
	var wh = $(window).height()-th;
	var pr = '<?php echo $page_row ?>';
	var pn = false;
	if(pr>0){
		pn = true;
	}
	$("#Users").datagrid({
		//title:'用户列表',
		idField:'id',
		height:wh,
		treeField:'text',
		autoRowHeight:false,
		singleSelect:true,
		striped:true,
		rownumbers:true,
		pagination:pn,
		pageSize:pr,
		pageList:[30,50,80,100,100000000000],
		method:'get',
		sortName:'username',
		sortOrder:'asc',
		url:'/index.php/Admin/Designer/index/json/1',
		fitColumns:true,
		nowrap:Number('<?php echo (C("DATA_NOWRAP")); ?>'),
		selectOnCheck:false,
		checkOnSelect:true,
		onBeforeLoad: function () {  
			 if($("#UserCon .datagrid-toolbar table tr #sersSearchBox").length==0){
				 var grid = $("#UserCon .datagrid-toolbar table tr");  
				 var date = '<td>'+$("#selectInputUser").html()+'</td>';    
				 grid.append(date); 
				 $("#sersSearchBox").combotree({
					url:'/Application/Runtime/Data/Json/User_tree_data.json',
					editable:true,
					method:'get',
					valueField:'id',
					textField:'text',
					/*filter: function(q,r){
						var opts = $(this).combobox('options');
						var v = r[opts.textField];
						var vu = v.toUpperCase();
						var vp = String(getPinYin(v));
						var qp = q.toUpperCase();
						if(vp.indexOf(qp)>=0 || vu.indexOf(qp) >= 0){
							return r[opts.textField];
						}
					},*/
					keyHandler: {
						query : function(q) {
							queryComboTree(q, "sersSearchBox", 0);
						}
					},
					onClick:function(q){
						$.post('/index.php/Admin/Designer/change/act/id', {val:q.id}, function(data){
							$("#Users").datagrid('reload');
						});
					}
				 });
			 }
		},
		/*
		onHeaderContextMenu:function(e,f){
			if(f!='id'){
				$("#searchUsers").dialog({
					title:'快速搜索',
					resizable:true,
					width:430,
					height:80,
					href:'/index.php?g=<?php echo MODULE_NAME; ?>&m=<?php echo MODULE_NAME; ?>&a=search&field='+f
				});
			}
			e.preventDefault();
		},
		*/
		onDblClickRow:function(e,rowIndex,rowData){
			//var se = $("#Project").datagrid('getSelected');
    
			var se = $("#Users").datagrid('getChecked');
			var se_len = se.length;
			var idd = se[0]['id'];
			if(se_len==1){
				$("#addUsers").dialog({
					title:'编辑用户',
					resizable:true,
					width:520,
					height:255,
					href:'/index.php/Admin/Designer/add/act/edit/id/'+idd,
					onOpen:function(){
						cancel['User'] = $(this);
					},
					onClose:function(){
						//$("#Users").datagrid('reload');
						cancel['User'] = null;
					}
				});
			}
			
		},
		onUncheck:function(i,d){
			$("#Users").datagrid('unselectRow',i);
		},
		toolbar:[{
		iconCls: 'icon-add',
			text : '新增',
			handler: function(){
				$("#addUsers").dialog({
					title:'新增用户',
					resizable:true,
					width:520,
					height:255,
					href:'/index.php/Admin/Designer/add/act/add',
					onOpen:function(){
						cancel['User'] = $(this);
					},
					onClose:function(){
						//$("#Users").datagrid('reload');
						cancel['User'] = null;
					}
				});
			}
		},'-',{
			iconCls: 'icon-edit',
			text : '编辑',
			handler: function(){
				//var se = $("#Project").datagrid('getSelected');
				var se = $("#Users").datagrid('getChecked');
				var se_len = se.length;
				var idd = se[0]['id'];
				if(se_len==1 && idd!=1){
					$("#addUsers").dialog({
						title:'编辑用户',
						resizable:true,
						width:520,
						height:255,
						href:'/index.php/Admin/Designer/add/act/edit/id/'+idd,
						onOpen:function(){
							cancel['User'] = $(this);
						},
						onClose:function(){
							//$("#Users").datagrid('reload');
							cancel['User'] = null;
						}
					});
				}else if(se_len>1){
					$.messager.alert('提示','不能同时编辑两行数据！','warning');
				}
			}
		},'-',{
			iconCls: 'icon-cancel',
			text : '删除',
			handler: function(){
				var se = $("#Users").datagrid('getChecked');
				var s = "";  
				for (var property in se) {  
					s = s + se[property]['id']+',' ;  
				}
				if(s){
					$.messager.confirm('提示','确定删除吗！',function(r){
						if(r==true){
							$.messager.progress();
							$.post('/index.php/Admin/Designer/del',{id:s}, function(data){
								$.messager.progress('close');
								if(data==1){
									$.messager.alert('提示','删除数据成功！','info',function(){
										$("#Users").datagrid('reload');
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
			iconCls: 'icon-search',
			text : '高级搜索',
			handler: function(){
				$("#searchUsers").dialog({
					title:'高级搜索',
					resizable:true,
					width:500,
					height:220,
					href:'/index.php/Admin/Designer/advsearch'
				});
			}
		},'-',{
			iconCls: 'icon-reload',
			text : '重载',
			handler: function(){
				$.get('/index.php/Admin/Designer/clear', function(data){
					$("#sersSearchBox").combotree('setValue','');
					$("#Users").datagrid('reload');
				});
			}
		}],
		frozenColumns:[[
			{checkbox:true}, 
			{field:'id',title:'ID号',width:45,sortable:true},
			{field:'username',title:'账号',width:110,sortable:true},
            {field:'nickname',title:'名称',width:200,sortable:true},
            {field:'mobile',title:'手机号',width:100},
		]],
		columns:[[  
			{field:'group_name',title:'会员组',width:100,sortable:true}, 
			{field:'email',title:'邮箱',width:200},
            {field:'amount',title:'可用资金',width:100},
            {field:'frozen',title:'冻结资金',width:100},
            {field:'point',title:'积分',width:100},
			{field:'loginnum',title:'登录次数',width:80,sortable:true},
			{field:'lastdate',title:'最后登录时间',width:170,sortable:true},
            {field:'islock',title:'锁定',width:60,sortable:true},
			{field:'status',title:'状态',width:60,sortable:true}
		]]
	});
	
	 var dataview = '<?php echo C("DATAGRID_VIEW") ?>';
	 if(dataview!='0'){
		var pager = $('#Users').datagrid('getPager');
		pager.pagination({
			layout: 'list,sep,first,prev,sep,manual,sep,next,last,sep,refresh',
			displayMsg: '共{total}记录'
		});
	 }
	
	$("#rightTabs").tabs({
		onClose:function(t,i){
			$.ajaxSetup({  
				async : false  
			});
			if(t=='用户管理'){
				$.get('/index.php/Admin/Designer/clear', function(data){});
			}	
			$.ajaxSetup({  
				async : true  
			});
		}
	});
	
	$("#rightTabs").tabs('select','用户管理');
});
function toSe(value,name){   
	alert(value+":"+name)   
}
</script>
<div class="con" id="UserCon" onselectstart="return false;" style="-moz-user-select:none;">
 <?php if(C('DATAGRID_VIEW')!='0'): ?><table id="Users" data-options="view:<?php echo C("DATAGRID_VIEW") ?>"></table>
 <?php else: ?>
 <table id="Users"></table><?php endif; ?>
</div>
<div id="searchUsers"></div>
<div id="addUsers"></div>
<div id="selectInputUser" style="display:none">
 <span class="datagrid-btn-separator-nofloat"  style="margin-right:2px;"></span>
 <input id="sersSearchBox" style="width:128px;" />
</div>