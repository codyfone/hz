<?php if (!defined('THINK_PATH')) exit();?><script language="javascript">
var ptit;
$(function(){
	var th = $(".top").height();
	th = 111-th;
	var wh = $(window).height()-th;
	var cw = $("#Inquiry<?php echo ($uniqid); ?>Con").width();
	var ch = $("body").height();
	var pr = '<?php echo $page_row ?>';
	var pn = false;
	var whs = (wh-39);
	if(pr>0){
		pn = true;
	}
	$("#Inquiry<?php echo ($uniqid); ?>").datagrid({
		//title:'项目列表',	
		height:whs,
		autoRowHeight:true,
		singleSelect:true,
		striped:true,
		rownumbers:true,
		pagination:pn,
		pageSize:pr,
		pageList:[30,50,80,100,1000],
		method:'get',
		sortName:'t1_new_pass',
		sortOrder:'asc',
		url:'/index.php/Admin/Inquiry/inquirylist/type/<?php echo ($type); ?>/json/1',
		fitColumns:false,
		nowrap:Number('<?php echo (C("DATA_NOWRAP")); ?>'),
		selectOnCheck:false,
		checkOnSelect:true,
		onBeforeLoad: function () {  
			 if($("#InquiryCon<?php echo ($uniqid); ?> .datagrid-toolbar table tr #sersSearchInquiry<?php echo ($uniqid); ?>").length==0){
				 var grid = $("#InquiryCon<?php echo ($uniqid); ?> .datagrid-toolbar table tr");  
				 var date = '<td>'+$("#selectInputInquiry<?php echo ($uniqid); ?>").html()+'</td>';    
				 grid.append(date); 
				 $("#sersSearchInquiry<?php echo ($uniqid); ?>").combobox({
					 editable:false,
					 onSelect:function(q){
						$.post('/index.php/Admin/Inquiry/change/act/pass', {val:q.value}, function(data){
							$("#Inquiry<?php echo ($uniqid); ?>").datagrid('reload');
							//alert(data);
						});
					}
				 });
				 
				 $('#InquirySearch<?php echo ($uniqid); ?>').searchbox({
					searcher:function(value,name){
						$.post('/index.php/Admin/Inquiry/change/act/'+name+'/mode/like', {val:value}, function(data){
							$("#Inquiry<?php echo ($uniqid); ?>").datagrid('reload');
						});
					},   
					menu:'#InquirySearchSon<?php echo ($uniqid); ?>',   
					prompt:'请输入关键字'  
				 }); 
			 }
		},
		/*
		onHeaderContextMenu:function(e,f){
			if(f!='contents'){
				$("#searchInquiry").dialog({
					title:'快速搜索',
					resizable:true,
					width:430,
					height:80,
					href:'/index.php/Admin/Inquiry/search/field/'+f
				});
			}
			
			e.preventDefault();
		},
		*/
		onDblClickRow:function(e,rowIndex,rowData){
			//var se = $("#Inquiry<?php echo ($uniqid); ?>").datagrid('getSelected')
			var se = $("#Inquiry<?php echo ($uniqid); ?>").datagrid('getChecked');
			var se_len = se.length;
			var idd = se[0]['id'];
			var idn = se[0]['t1_company'];
			//alert(idd);
			var ishas = $("#rightTabs").tabs('exists',ptit);
			if(!ishas){
				$("#rightTabs").tabs('add',{
					id : -4,
					title : '项目-'+idn,
					href : '/index.php/Admin/Inquiry/detail/id/'+idd,
					closable : true,
				});
				ptit = '项目-'+idn;
			}else{
				if('项目-'+idn!=ptit){
					var tab = $("#rightTabs").tabs('getTab',ptit);
					$("#rightTabs").tabs('update',{
						tab:tab,
						options:{
							title : '项目-'+idn,
							href : '/index.php/Admin/Inquiry/detail/id/'+idd,
							closable : true,
						} 
					});
					ptit = '项目-'+idn;
					$("#rightTabs").tabs('select',ptit);
				}else{
					$("#rightTabs").tabs('select',ptit);
				}
			}
		},
		onUncheck:function(i,d){
			$("#Inquiry<?php echo ($uniqid); ?>").datagrid('unselectRow',i);
		},
		toolbar:[{
		iconCls: 'icon-add',
			text : '新增',
			handler: function(){
				$("#addInquiry<?php echo ($uniqid); ?>").dialog({
					title:'新增项目',
					resizable:true,
					width:850,
					height:480,
					href:'/index.php/Admin/Inquiry/add/act/add',
					onOpen:function(){
						cancel['Inquiry'] = $(this);
						cancel['InquiryName'] = $("#Inquiry<?php echo ($uniqid); ?>");
					},
					onClose:function(){
						//$(this).dialog('destroy');
						//$("#Inquiry<?php echo ($uniqid); ?>").datagrid('reload');
						cancel['Inquiry'] = null;
						cancel['InquiryName'] = null;
					}
				});
			}
		},'-',{
			iconCls: 'icon-edit',
			text : '编辑',
			handler: function(){
				//var se = $("#Inquiry<?php echo ($uniqid); ?>").datagrid('getSelected');
				var se = $("#Inquiry<?php echo ($uniqid); ?>").datagrid('getChecked');
				var se_len = se.length;
				var idd = se[0]['id'];
				if(se_len==1){
					$("#addInquiry<?php echo ($uniqid); ?>").dialog({
						title:'编辑项目',
						resizable:true,
						width:850,
						height:480,
						href:'/index.php/Admin/Inquiry/add/act/edit/id/'+idd,
						onOpen:function(){
							cancel['Inquiry'] = $(this);
							cancel['InquiryName'] = $("#Inquiry<?php echo ($uniqid); ?>");
						},
						onClose:function(){
						//	$(this).dialog('destroy');
							//$("#Inquiry<?php echo ($uniqid); ?>").datagrid('reload');
							cancel['Inquiry'] = null;
							cancel['InquiryName'] = null;
						}
					});
				}else if(se_len>1){
					$.messager.alert('提示','不能同时编辑两个数据！','warning');
				}
			}
		},'-',{
			iconCls: 'icon-cancel',
			text : '删除',
			handler: function(){
				var se = $("#Inquiry<?php echo ($uniqid); ?>").datagrid('getChecked');
				var s = "";  
				for (var property in se) {  
					s = s + se[property]['id']+',' ;  
				}
				if(s){
					$.messager.confirm('提示','确定删除该项目吗！',function(r){
						if(r==true){
							$.messager.progress();
							$.post('/index.php/Admin/Inquiry/del', {id:s}, function(data){
								$.messager.progress('close');
								if(data==1){
									$.messager.alert('提示','删除项目成功！','info',function(){
										$("#Inquiry<?php echo ($uniqid); ?>").datagrid('reload');
									});
								}else if(data==0){
									$.messager.alert('提示','删除项目失败！','warning');
								}else{
									$.messager.alert('提示','您没有刪除的权限！','warning');
								}
							});
						}
					}); 	
				}
			}
		},'-',{
			iconCls: 'icon-search',
			text : '高級搜索',
			handler: function(){
				$("#searchInquiry<?php echo ($uniqid); ?>").dialog({
					title:'高級搜索',
					resizable:true,
					width:500,
					height:220,
					href:'/index.php/Admin/Inquiry/advsearch',
					onOpen:function(){
						cancel['InquiryNames'] = $("#Inquiry<?php echo ($uniqid); ?>");
					},
					onClose:function(){
						cancel['InquiryNames'] = null;
					}
				});
			}
		},'-',{
			iconCls: 'icon-reload',
			text : '重载',
			handler: function(){
				$.get('/index.php/Admin/Inquiry/clear', function(data){
					$("#Inquiry<?php echo ($uniqid); ?>Search<?php echo ($uniqid); ?>").searchbox('setValue','');
					$("#sersSearchInquiry<?php echo ($uniqid); ?>").combobox('setValue','');
					$("#sersSearchClient<?php echo ($uniqid); ?>").combobox('setValue','');
					$("#Inquiry<?php echo ($uniqid); ?>").datagrid('reload');
				});
			}
		}],
		frozenColumns:[[
			{field:'id',checkbox:true,rowspan:2},
			{field:'t1_old_code',title:'项目代码',width:70,sortable:true,rowspan:2},
			{field:'t1_exhibition',title:'展会名称',width:300,sortable:true,rowspan:2}
		]],
		columns:[[ 
			{field:'t2_old_enddate',title:'计划完成日',width:90,sortable:true,rowspan:2},
			{field:'t1_linkman',title:'负责人',width:65,sortable:true,rowspan:2},
            {field:'t1_telephone',title:'联系电话',width:80,sortable:true,rowspan:2},
            {field:'t1_email',title:'邮箱',width:80,sortable:true,rowspan:2},
			{field:'t1_old_uptime',title:'更新时间',width:155,sortable:true,rowspan:2},
			{field:'t1_new_pass',title:'项目进度',width:100,sortable:true,rowspan:2},
			{field:'t1_old_comple',title:'方案完成率',width:60,sortable:true,rowspan:2},
			{title:'<?php echo $month[13]; ?>',width:576,colspan:12,align:'center',resizable:false}
		],[
			{field:'m1',title:'<?php echo $month[1]; ?>',width:48,align:'center',resizable:false},
			{field:'m2',title:'<?php echo $month[2]; ?>',width:48,align:'center',resizable:false},
			{field:'m3',title:'<?php echo $month[3]; ?>',width:48,align:'center',resizable:false},
			{field:'m4',title:'<?php echo $month[4]; ?>',width:48,align:'center',resizable:false},
			{field:'m5',title:'<?php echo $month[5]; ?>',width:48,align:'center',resizable:false},
			{field:'m6',title:'<?php echo $month[6]; ?>',width:48,align:'center',resizable:false},
			{field:'m7',title:'<?php echo $month[7]; ?>',width:48,align:'center',resizable:false},
			{field:'m8',title:'<?php echo $month[8]; ?>',width:48,align:'center',resizable:false},
			{field:'m9',title:'<?php echo $month[9]; ?>',width:48,align:'center',resizable:false},
			{field:'m10',title:'<?php echo $month[10]; ?>',width:48,align:'center',resizable:false},
			{field:'m11',title:'<?php echo $month[11]; ?>',width:48,align:'center',resizable:false},
			{field:'m12',title:'<?php echo $month[12]; ?>',width:48,align:'center',resizable:false},
		]]
	});
	
	 var dataview = '<?php echo C("DATAGRID_VIEW") ?>';
	 if(dataview!='0'){
		var pager = $('#Inquiry<?php echo ($uniqid); ?>').datagrid('getPager');
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
			if(t=='项目列表'){
				$.get('/index.php/Admin/Inquiry/clear', function(data){});
			}
			$.ajaxSetup({  
				async : true  
			});
		}
	});
	
	$("#rightTabs").tabs('select','项目列表');
});

function proLastMonth(){
	$(function(){
		$.get('/index.php/Admin/Inquiry/chgmonth/act/1', function(data){
			$("#Inquiry<?php echo ($uniqid); ?>").datagrid('reload');
			$.getJSON('/index.php/Admin/Inquiry/inquirylist/type/<?php echo ($type); ?>/json/1/method/month',function(data){
				$("#Inquiry<?php echo ($uniqid); ?>").datagrid("setColumnTitle",{field:'m1',text:data[1]});
				$("#Inquiry<?php echo ($uniqid); ?>").datagrid("setColumnTitle",{field:'m2',text:data[2]});
				$("#Inquiry<?php echo ($uniqid); ?>").datagrid("setColumnTitle",{field:'m3',text:data[3]});
				$("#Inquiry<?php echo ($uniqid); ?>").datagrid("setColumnTitle",{field:'m4',text:data[4]});
				$("#Inquiry<?php echo ($uniqid); ?>").datagrid("setColumnTitle",{field:'m5',text:data[5]});
				$("#Inquiry<?php echo ($uniqid); ?>").datagrid("setColumnTitle",{field:'m6',text:data[6]});
				$("#Inquiry<?php echo ($uniqid); ?>").datagrid("setColumnTitle",{field:'m7',text:data[7]});
				$("#Inquiry<?php echo ($uniqid); ?>").datagrid("setColumnTitle",{field:'m8',text:data[8]});
				$("#Inquiry<?php echo ($uniqid); ?>").datagrid("setColumnTitle",{field:'m9',text:data[9]});
				$("#Inquiry<?php echo ($uniqid); ?>").datagrid("setColumnTitle",{field:'m10',text:data[10]});
				$("#Inquiry<?php echo ($uniqid); ?>").datagrid("setColumnTitle",{field:'m11',text:data[11]});
				$("#Inquiry<?php echo ($uniqid); ?>").datagrid("setColumnTitle",{field:'m12',text:data[12]});
				$("#midMonth").html(data[14]);
			});
		});
	});
}
	
function proNextMonth(){
	$(function(){
		$.get('/index.php/Admin/Inquiry/chgmonth/act/2', function(data){
			$("#Inquiry<?php echo ($uniqid); ?>").datagrid('reload');
			$.getJSON('/index.php/Admin/Inquiry/inquirylist/type/<?php echo ($type); ?>/json/1/method/month',function(data){
				$("#Inquiry<?php echo ($uniqid); ?>").datagrid("setColumnTitle",{field:'m1',text:data[1]});
				$("#Inquiry<?php echo ($uniqid); ?>").datagrid("setColumnTitle",{field:'m2',text:data[2]});
				$("#Inquiry<?php echo ($uniqid); ?>").datagrid("setColumnTitle",{field:'m3',text:data[3]});
				$("#Inquiry<?php echo ($uniqid); ?>").datagrid("setColumnTitle",{field:'m4',text:data[4]});
				$("#Inquiry<?php echo ($uniqid); ?>").datagrid("setColumnTitle",{field:'m5',text:data[5]});
				$("#Inquiry<?php echo ($uniqid); ?>").datagrid("setColumnTitle",{field:'m6',text:data[6]});
				$("#Inquiry<?php echo ($uniqid); ?>").datagrid("setColumnTitle",{field:'m7',text:data[7]});
				$("#Inquiry<?php echo ($uniqid); ?>").datagrid("setColumnTitle",{field:'m8',text:data[8]});
				$("#Inquiry<?php echo ($uniqid); ?>").datagrid("setColumnTitle",{field:'m9',text:data[9]});
				$("#Inquiry<?php echo ($uniqid); ?>").datagrid("setColumnTitle",{field:'m10',text:data[10]});
				$("#Inquiry<?php echo ($uniqid); ?>").datagrid("setColumnTitle",{field:'m11',text:data[11]});
				$("#Inquiry<?php echo ($uniqid); ?>").datagrid("setColumnTitle",{field:'m12',text:data[12]});
				$("#midMonth").html(data[14]);
			});
		});
	});
}
</script>
<div class="con" id="InquiryCon<?php echo ($uniqid); ?>" onselectstart="return false;" style="-moz-user-select:none;">
 <?php if(C('DATAGRID_VIEW')!='0'): ?><table id="Inquiry<?php echo ($uniqid); ?>" data-options="view:<?php echo C("DATAGRID_VIEW") ?>"></table>
 <?php else: ?>
 <table id="Inquiry<?php echo ($uniqid); ?>"></table><?php endif; ?>
</div>
<div id="searchInquiry<?php echo ($uniqid); ?>"></div>
<div id="addInquiry<?php echo ($uniqid); ?>"></div>
<div id="selectInputInquiry<?php echo ($uniqid); ?>" style="display:none">
 <span class="datagrid-btn-separator-nofloat" style="margin-right:2px;"></span>
 <select id="sersSearchInquiry<?php echo ($uniqid); ?>" style="margin-left:3px" >
  <option value="0">&nbsp;</option>
  <option value="2">待进行</option>
  <option value="4">进行中</option>
  <option value="3">延误</option>
  <option value="1">已完成</option>
 </select>
 <span class="datagrid-btn-separator-nofloat"  style="margin-right:2px;"></span> 
 <input id="InquirySearch<?php echo ($uniqid); ?>" AUTOCOMPLETE="off"></input>  
 <div id="InquirySearchSon<?php echo ($uniqid); ?>" style="width:80px;">  
    <div data-options="name:'t1_exhibition'">展会名称</div>
    <div data-options="name:'t1_old_code'">项目代码</div>
    <div data-options="name:'t1_new_pass'">项目进度</div>
    <div data-options="name:'t3_old_linkman'">负责人</div>  
 </div>
</div>