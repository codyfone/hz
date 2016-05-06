<?php if (!defined('THINK_PATH')) exit();?><script language="javascript">
var ptit;
$(function(){
	var th = $(".top").height();
	th = 111-th
	var wh = $(window).height()-th;
	var cw = $(window).width()-177;
	whs = (wh-289);
	var pr = '<?php echo $page_row ?>';
	var pn = false;
	if(pr>0){
		pn = true;
	}
	$("#designIndexList<?php echo ($uniqid); ?>").datagrid({	
		height:whs,
		autoRowHeight:true,
		singleSelect:true,
		striped:true,
		pagination:pn,
		rownumbers:true,
		pagination:true,
		pageSize:30,
		pageList:[30,50,80,100,1000],
		method:'get',
		sortName:'t1_old_uptime',
		sortOrder:'desc',
		url:'/index.php/Admin/Design/designlist/type/<?php echo ($type); ?>/json/1',
		fitColumns:false,
		nowrap:Number('<?php echo (C("DATA_NOWRAP")); ?>'),
		selectOnCheck:false,
		checkOnSelect:true,
		onLoadSuccess: function () {
			 if($("#designIndexListCon<?php echo ($uniqid); ?> .datagrid-toolbar table tr #sersSearchDesign<?php echo ($uniqid); ?>").length==0){
				 var grid = $("#designIndexListCon<?php echo ($uniqid); ?> .datagrid-toolbar table tr");  
				 var date = '<td>'+$("#selectInputDesign<?php echo ($uniqid); ?>").html()+'</td>';    
				 grid.prepend(date); 
				 $("#sersSearchDesign<?php echo ($uniqid); ?>").combobox({
					url:'/index.php/Admin/Design/getProject',
					editable:true,
					method:'get',
					valueField:'id',
					textField:'text',
					filter: function(q,r){
						var opts = $(this).combobox('options');
						var v = r[opts.textField];
						var vu = v.toUpperCase();
						var vp = String(getPinYin(v));
						var qp = q.toUpperCase();
						if(vp.indexOf(qp)>=0 || vu.indexOf(qp) >= 0){
							return r[opts.textField];
						}
					}
				 }); 
				 //alert(se['year']);
				 $("#searchYear<?php echo ($uniqid); ?>").val(se['year']?se['year']:'<?php echo ($nowyear); ?>');
				 $("#searchMonth<?php echo ($uniqid); ?>").val(se['month']?se['month']:'<?php echo ($nowmonth); ?>');
				 $("#searchType<?php echo ($uniqid); ?>").val(se['type']);
				 $("#searchStatus<?php echo ($uniqid); ?>").val(se['status']);
				 $("#sersSearchDesign<?php echo ($uniqid); ?>").combobox('setValue',se['pro_id']);
			 }
		},
		onDblClickRow:function(e,rowIndex,rowData){
			//var se = $("#Project").datagrid('getSelected')
			var se = $("#designIndexList<?php echo ($uniqid); ?>").datagrid('getChecked');
			var se_len = se.length;
			var id = se[0]['id'];
			var idd = se[0]['t1_old_pro_id'];
			var idn = se[0]['t1_old_proname'];
			//alert(idd);
			var ishas = $("#rightTabs").tabs('exists',ptit);
			if(!ishas){
				$("#rightTabs").tabs('add',{
					id : -4,
					title : '项目-'+idn,
					href : '/index.php/Admin/project/detail/id/'+idd+'/tid/'+id,
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
							href : '/index.php/Admin/project/detail/id/'+idd+'/tid/'+id,
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
			$("#designIndexList<?php echo ($uniqid); ?>").datagrid('unselectRow',i);
		},
		toolbar:[{
			iconCls: 'icon-reload',
			text : '重载',
			handler: function(){
				$.get('/index.php/Admin/Design/clear', function(data){
					$("#searchYear<?php echo ($uniqid); ?>").val('<?php echo ($nowyear); ?>');
				 	$("#searchMonth<?php echo ($uniqid); ?>").val('<?php echo ($nowmonth); ?>');
					$("#searchType<?php echo ($uniqid); ?>").val(0);
					$("#searchStatus<?php echo ($uniqid); ?>").val(0);
					$("#sersSearchDesign<?php echo ($uniqid); ?>").combobox('setValue',0);
					$("#designIndexList<?php echo ($uniqid); ?>").datagrid('reload');
				});
			}
		},'-',{
			iconCls: 'icon-excel',
			text : '导出EXCEL',
			handler: function(){				
				window.location = "/index.php/Admin/Design/designlist/type/<?php echo ($type); ?>/json/1/method/excel";
			}
		}],
		frozenColumns:[[
			{field:'t1_old_title',title:'方案名称',width:250,sortable:true,rowspan:2},
		]],
		columns:[[ 
			{field:'t2_old_username',title:'来自',width:65,sortable:true,rowspan:2},
			{field:'t1_new_status',title:'方案状态',width:110,sortable:true,rowspan:2},
			{field:'t1_old_startdate',title:'计划开始',width:100,sortable:true,rowspan:2},
			{field:'t1_old_enddate',title:'计划完成',width:100,sortable:true,rowspan:2},
			{field:'t1_old_pass',title:'方案进度',width:110,sortable:true,rowspan:2},
			{field:'t1_old_proname',title:'所属项目',width:230,rowspan:2},
			{field:'t1_old_uptime',title:'更新时间',width:155,sortable:true,rowspan:2},
			{title:'<?php echo $week[8]; ?>',width:700,colspan:7,align:'center',resizable:false}
		],[
			{field:'w1',title:'<?php echo $week[1]; ?>',width:100,align:'center',resizable:false},
			{field:'w2',title:'<?php echo $week[2]; ?>',width:100,align:'center',resizable:false},
			{field:'w3',title:'<?php echo $week[3]; ?>',width:100,align:'center',resizable:false},
			{field:'w4',title:'<?php echo $week[4]; ?>',width:100,align:'center',resizable:false},
			{field:'w5',title:'<?php echo $week[5]; ?>',width:100,align:'center',resizable:false},
			{field:'w6',title:'<?php echo $week[6]; ?>',width:100,align:'center',resizable:false},
			{field:'w7',title:'<?php echo $week[7]; ?>',width:100,align:'center',resizable:false}
		]]
	});
	
	$("#rightTabs").tabs({
		onClose:function(t,i){
			$.ajaxSetup({  
				async : false  
			});
			if(t=='方案列表'){
				$.get('/index.php/Admin/Design/clear', function(data){});
			}
			$.ajaxSetup({  
				async : true  
			});
		}
	});
	
	$("#rightTabs").tabs('select','方案列表');
	
	$("#workToLasts").click(function(){
		$.get('/index.php/Admin/Design/chgweek/act/1', function(data){
			$("#designIndexList<?php echo ($uniqid); ?>").datagrid('reload');
			$.getJSON('/index.php/Admin/Design/designlist/type/<?php echo ($type); ?>/json/1/method/week',function(data){
				$("#designIndexList<?php echo ($uniqid); ?>").datagrid("setColumnTitle",{field:'w1',text:data[1]});
				$("#designIndexList<?php echo ($uniqid); ?>").datagrid("setColumnTitle",{field:'w2',text:data[2]});
				$("#designIndexList<?php echo ($uniqid); ?>").datagrid("setColumnTitle",{field:'w3',text:data[3]});
				$("#designIndexList<?php echo ($uniqid); ?>").datagrid("setColumnTitle",{field:'w4',text:data[4]});
				$("#designIndexList<?php echo ($uniqid); ?>").datagrid("setColumnTitle",{field:'w5',text:data[5]});
				$("#designIndexList<?php echo ($uniqid); ?>").datagrid("setColumnTitle",{field:'w6',text:data[6]});
				$("#designIndexList<?php echo ($uniqid); ?>").datagrid("setColumnTitle",{field:'w7',text:data[7]});
				$("#midWeeks").html(data[9]);
			});
		});
	});
	
	$("#workToNexts").click(function(){
		$.get('/index.php/Admin/Design/chgweek/act/2', function(data){
			$("#designIndexList<?php echo ($uniqid); ?>").datagrid('reload');
			$.getJSON('/index.php/Admin/Design/designlist/type/<?php echo ($type); ?>/json/1/method/week',function(data){
				$("#designIndexList<?php echo ($uniqid); ?>").datagrid("setColumnTitle",{field:'w1',text:data[1]});
				$("#designIndexList<?php echo ($uniqid); ?>").datagrid("setColumnTitle",{field:'w2',text:data[2]});
				$("#designIndexList<?php echo ($uniqid); ?>").datagrid("setColumnTitle",{field:'w3',text:data[3]});
				$("#designIndexList<?php echo ($uniqid); ?>").datagrid("setColumnTitle",{field:'w4',text:data[4]});
				$("#designIndexList<?php echo ($uniqid); ?>").datagrid("setColumnTitle",{field:'w5',text:data[5]});
				$("#designIndexList<?php echo ($uniqid); ?>").datagrid("setColumnTitle",{field:'w6',text:data[6]});
				$("#designIndexList<?php echo ($uniqid); ?>").datagrid("setColumnTitle",{field:'w7',text:data[7]});
				$("#midWeeks").html(data[9]);
			});
		});
	});
});

function getAddWork(dates,tid,pidd){
	var isform = $(".add-worklog").length;
	if(!isform){
		$("<div/>").dialog({
			title:'新增工作日志',
			resizable:true,
			width:720,
			height:406,
			href:'/index.php/Admin/project/worklog/act/add/id/'+pidd+'/tid/'+tid+'/dates/'+dates,
			onOpen:function(){
				cancel['Worklog'] = $(this);
			},
			onClose:function(){
				$("#designIndexList<?php echo ($uniqid); ?>").datagrid('reload');
				cancel['Worklog'].dialog('destroy');
				cancel['Worklog'] = null;
			}
		});
	}
}

function getDetailWork(id){
	var isform = $(".add-worklog").length;
	if(!isform){
		$("<div/>").dialog({
			title:'工作日志详情',
			resizable:true,
			width:720,
			height:406,
			href:'/index.php/Admin/project/worklog/act/detail/id/'+id,
			onOpen:function(){
				cancel['Worklog'] = $(this);
			},
			onClose:function(){
				$("#designIndexList<?php echo ($uniqid); ?>").datagrid('reload');
				cancel['Worklog'].dialog('destroy');
				cancel['Worklog'] = null;
			}
		});
	}
}

function toDesignSearch(idd){
	$.messager.progress();
	var datas = $("#searchForm"+idd).serializeArray();
	se['year'] = datas[0]['value'];
	se['month'] = datas[1]['value'];
	se['type'] = datas[2]['value'];
	se['status'] = datas[3]['value'];
	se['pro_id'] = datas[6]['value'];
	$.post('/index.php/Admin/Design/search',datas,function(data){
		$("#designIndexList<?php echo ($uniqid); ?>").datagrid('reload');
	});
	$.messager.progress('close');
}
</script>
<div class="con" id="designIndexListCon<?php echo ($uniqid); ?>" onselectstart="return false;" style="-moz-user-select:none;">
<form id="searchForm<?php echo ($uniqid); ?>">
 <table id="designIndexList<?php echo ($uniqid); ?>"></table>
</form>
</div>
<div id="selectInputDesign<?php echo ($uniqid); ?>" style="display:none">
 <span style="margin-right:3px;"></span>
 <select id="searchYear<?php echo ($uniqid); ?>" name="year">
  <option value="0" <?php echo ($selected); ?>>不限年份</option>
  <?php if(is_array($year)): foreach($year as $key=>$t): ?><option value="<?php echo ($t); ?>"><?php echo ($t); ?>年</option><?php endforeach; endif; ?>
 </select>
 <span style="">/</span>
 
 <select id="searchMonth<?php echo ($uniqid); ?>" name="month">
  <option value="0" <?php echo ($selected); ?>>不限月份</option>
  <option value="01" <?php echo ($selected); ?>>01月</option>
  <option value="02" <?php echo ($selected); ?>>02月</option>
  <option value="03" <?php echo ($selected); ?>>03月</option>
  <option value="04" <?php echo ($selected); ?>>04月</option>
  <option value="05" <?php echo ($selected); ?>>05月</option>
  <option value="06" <?php echo ($selected); ?>>06月</option>
  <option value="07" <?php echo ($selected); ?>>07月</option>
  <option value="08" <?php echo ($selected); ?>>08月</option>
  <option value="09" <?php echo ($selected); ?>>09月</option>
  <option value="10" <?php echo ($selected); ?>>10月</option>
  <option value="11" <?php echo ($selected); ?>>11月</option>
  <option value="12" <?php echo ($selected); ?>>12月</option>
 </select>
 
 
 <select id="searchStatus<?php echo ($uniqid); ?>" name="status">
  <option value="0" <?php echo ($selected); ?>>方案状态</option>
  <?php if(is_array($status)): foreach($status as $key=>$t): ?><option value="<?php echo ($t["id"]); ?>"><?php echo ($t["text"]); ?></option><?php endforeach; endif; ?>
 </select>

 <input id="sersSearchDesign<?php echo ($uniqid); ?>" style="width:190px;" name="pro_id" />
 
 <a href="javascript:void(0);" onclick="javascript:toDesignSearch('<?php echo ($uniqid); ?>')" class="searchBtn"></a>
 
 <span class="datagrid-btn-separator-nofloat" style="margin-right:2px;"></span>
</div>