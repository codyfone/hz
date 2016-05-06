<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
 <meta charset="UTF-8">
 <title>汇展之家管理系统 - <?= C('CFG_NAME') ?></title>
 <script type="text/javascript" src="/Skin/Public/Easyui/jquery.min.js"></script>
 <script type="text/javascript" src="/Skin/Public/Js/jquery.cookie.js"></script>
 <script language="javascript">
 var isskin = $.cookie('easyui')?$.cookie('easyui'):'default';
 document.write('<link id="easySty" rel="stylesheet" type="text/css" href="/Skin/Public/Easyui/themes/'+isskin+'/easyui.css">');
 document.write('<link type="text/css" rel="stylesheet" href="/Skin/Admin/Css/index.css">');
 document.write('<link id="adminSty" type="text/css" rel="stylesheet" href="/Skin/Admin/Css/'+isskin+'/style.css">');
 </script>
 
 <link rel="stylesheet" type="text/css" href="/Skin/Public/Easyui/themes/icon.css">
 <link rel="stylesheet" href="/Skin/Public/Js/kindeditor/themes/default/default.css">
 <link rel="stylesheet"  href="/Skin/Public/Js/datepicker/skin/default/datepicker.css">
   
 <script type="text/javascript" src="/Skin/Public/Js/datepicker/WdatePicker.js"></script>
 <script type="text/javascript" src="/Skin/Public/Js/datepicker/lang/zh-cn.js"></script>
 <script charset="utf-8" src="/Skin/Public/Js/kindeditor/kindeditor-min.js"></script>

 <script charset="utf-8" src="/Skin/Public/Js/ueditor/ueditor.config.js"></script>
 <script charset="utf-8" src="/Skin/Public/Js/ueditor/ueditor.all.js"></script>
 <script type="text/javascript" src="/Skin/Public/Js/ueditor/lang/zh-cn/zh-cn.js"></script>

 <script charset="utf-8" src="/Skin/Public/Js/kindeditor/lang/zh_CN.js"></script>
 <script type="text/javascript" src="/Skin/Public/Easyui/jquery.easyui.min.js"></script>
 <script type="text/javascript" src="/Skin/Public/Easyui/locale/easyui-lang-zh_CN.js"></script> 
 <script type="text/javascript" src="/Skin/Public/Easyui/plugins/jquery.kindeditor.js"></script>
 <script type="text/javascript" src="/Skin/Public/Easyui/plugins/jquery.datepicker.js"></script>
 <script type="text/javascript" src="/Skin/Public/Easyui/view/datagrid-scrollview.js"></script>
 <script type="text/javascript" src="/Skin/Public/Easyui/view/datagrid-bufferview.js"></script>
 <script type="text/javascript" src="/Skin/Public/Easyui/datagrid-cellediting.js"></script>
 <script type="text/javascript" src="/Skin/Public/Easyui/plugins/jquery.ueditor.js"></script>
 <script type="text/javascript" src="/Skin/Public/Js/objFunc.js"></script> 
 <script type="text/javascript" src="/Skin/Public/Js/getPinYin.js"></script> 
 <script type="text/javascript" src="/Skin/Public/Js/objClass.js"></script>
 <script type="text/javascript" src="/Skin/Public/Js/acrossClass.js"></script> 
 <script charset="utf-8" src="/Skin/Public/Js/kindeditor/plugins/image/image.js"></script>
 <script charset="utf-8" src="/Skin/Public/Js/color.all.min.js"></script>
 <script charset="utf-8" src="/Skin/Public/Js/jqColor.js"></script>
 <script language="javascript">
 var cancel = new Array();
 
 $.extend($.fn.datagrid.methods, {  
	setColumnTitle: function(jq, option){  
		if(option.field){
			return jq.each(function(){  
				var $panel = $(this).datagrid("getPanel");
				var $field = $('td[field='+option.field+']',$panel);
				if($field.length){
					var $span = $("span",$field).eq(0);
					$span.html(option.text);
				}
			});
		}
		return jq;		
	}  
 });
 //扩展easyui表单的验证
$.extend($.fn.validatebox.defaults.rules, {  
    //验证汉字  
    CHS: {  
        validator: function (value) {
            return /^[\u0391-\uFFE5]+$/.test(value);
        },  
        message: '请输入汉字'  
    },  
    //移动手机号码验证  
    Mobile: {
        validator: function (value) {  
            var reg = /^1[3-9]\d{9}$/;
            return reg.test(value);  
        },  
        message: '请正确输入手机号.'  
    },
    //电话验证
    Tel:{
        validator: function (value) {  
            var reg = /^[0-9-]{6,13}$/;
            return reg.test(value);  
        },  
        message: '请正确输入电话号码.'  
    },
    //国内邮编验证  
    ZipCode: {  
        validator: function (value) {  
            var reg = /^[0-9]\d{5}$/;  
            return reg.test(value);  
        },  
        message: '请如入6位整数邮编.'  
    },  
  //数字  
    Number: {  
        validator: function (value) {  
            var reg =/^[0-9]*$/;  
            return reg.test(value);  
        },  
        message: '请输入正整数.'  
    },  
})  
 function toRepwd(){
//	 $(function(){
		var idd = <?= $_SESSION['login']['se_id'] ?>;
		$("#repwd").dialog({
			title:'修改密码',
			resizable:true,
			width:400,
			height:230,
			href:'/index.php/Admin/User/repwd/id/'+idd,
			onOpen:function(){
				cancel['Repwd'] = $(this);
			},
		});	 
	// });
 }
 
 function toShowSms(){
//	 $(function(){
		$("#setpwd").dialog({
			title:'我的信息',
			resizable:true,
			width:580,
			height:353,
			href:'/index.php/Admin/Index/showsms/act/1',
			onOpen:function(){
				cancel['Sendsms'] = $(this);
			},
			onClose:function(){
				cancel['SmsDetail'].dialog('destroy');
				cancel['SmsDetail'].dialog('close');
				cancel['SmsDetail'] = null;
				cancel['Sendmail'] = null;
			}
		});	 
//	 });
 }
 
 function toSetpwd(){
//	 $(function(){
		var idd = <?= $_SESSION['login']['se_id'] ?>;
		$("#setpwd").dialog({
			title:'邮箱设置',
			resizable:true,
			width:450,
			height:255,
			href:'/index.php/Admin/User/setpwd/id/'+idd,
			onOpen:function(){
				cancel['Setpwd'] = $(this);
			},
		});	 
//	 });
 }
 
 function toSendMail(){
	var idd = <?= $_SESSION['login']['se_id'] ?>;
	$("<div />").dialog({
		title:'发邮件',
		resizable:true,
		width:900,
		height:435,
		href:'/index.php/Admin/Mail/index/mode/1/id/'+idd,
		onOpen:function(){
			cancel['Sendmail'] = $(this);
		},
		onClose:function(){
			cancel['Sendmail'].dialog('destroy');
			cancel['Sendmail'] = null;
		}
	});
 }
 
 function toClearCache(){
//	 $(function(){
		$.get('/index.php/Admin/Index/cache', function(data){
			$.messager.alert('提示','所有缓存已被清除！','info');
		}); 
		
//	 });
 }
 
 
 
 $(function(){
	$.ajaxSetup({  
		async : false  
	});
	
	var browser_cache = Boolean(Number('<?php echo (C("BROWSER_CACHE")); ?>'));
	jQuery.ajaxSetup ({cache:browser_cache});
	
	$(window).bind('load',function(){
		$.get('/index.php/Admin/Index/clear', function(data){});
	});
	
	$.ajaxSetup({  
		async : true  
	});
 });
 </script>
</head>
<body class="easyui-layout">
 <div class="top" id="topBg" data-options="region:'north',border:false">
  <script language="javascript">
$(function(){
	$("body").append("<div class='skin-box'>"
	+"<div class='skin-list' id='default' title='默认蓝'><div class='skin-color' style='background-color:#ddeaff; width:100%; height:100%;'></div></div>"
	+"<div class='skin-list' id='black' title='灰黑色'><div class='skin-color' style='background-color:#3d3d3d; width:100%; height:100%;'></div></div>"
	+"<div class='skin-list' id='metro-gray' title='浅灰色'><div class='skin-color' style='background-color:#c7ccd1; width:100%; height:100%;'></div></div>"
	+"<div class='skin-list' id='grinder' title='土黃色'><div class='skin-color' style='background-color:#e0decb; width:100%; height:100%;'></div></div>"
	+"<div class='skin-list' id='metro-red' title='粉红色'><div class='skin-color' style='background-color:#ebd8da; width:100%; height:100%;'></div></div>"
	+"<div class='skin-list' id='cupertino' title='宝石蓝'><div class='skin-color' style='background-color:#c4e2f7; width:100%; height:100%;'></div></div>"
	+"</div>");
	
	$("#chgSkin img").click(function(){
		var sb = $(".skin-box");
		var x = $(this).offset();
		var xl = x.left;
		var xt = x.top;
		var xw = $(".skin-box").width();
		var sw = $(".show").width();
		//alert(xw);
		sb.css({
			top:xt+15,
			left:xl-xw+22
		});
		sb.fadeToggle();
		return false;
	});
	
	$("body").click(function(){
		$(this).find(".skin-box").click(function(){
			return false;
		});
		var sb = $(".skin-box");
		sb.fadeOut();
	});
	
	$(".skin-list").click(function(){
		$.ajaxSetup({  
			async : false  
		});
	
		var skinid = $(this).attr("id");
		var skinexp = Number('<?php echo (C("SKIN_COOKIE_EXPIRES")); ?>');
		$("#adminSty").attr("href","/Skin/Admin/Css/"+skinid+"/style.css");
		$("#logoImg").attr("src","/Skin/Admin/Css/"+skinid+"/logo.png");
		$("#easySty").attr("href","/Skin/Public/Easyui/themes/"+skinid+"/easyui.css");
		$.cookie('easyui',skinid, { expires: skinexp });
		$('#layoutBody').layout('resize');
		
		$.ajaxSetup({  
			async : true  
		});
		return false;
	});
	
	$.get('/index.php/Admin/Index/getsms',function(data){
		if(data>0){
			$("#smsid").html(data);
			$("#smsid").attr("title","您有"+data+"条未读通知");
		}else{
			$("#smsid").html("0");
			$("#smsid").attr("title","您没有未读通知");
		}
	});
	
	
});

function showTab(tit,pid){
	var ishas = $("#rightTabs").tabs('exists',tit);
	if(!ishas){
		$("#rightTabs").tabs('add',{
			id : -4,
			title : tit,
			href : '/index.php/Admin/Project/detail/id/'+pid,
			closable : true,
		});
	}else{
		$("#rightTabs").tabs('select',tit);
	}
}
</script>
<div class="logo">
  <script language="javascript">
   document.write('<img id="logoImg" src="/Skin/Admin/Css/'+isskin+'/logo.png" /></div>');
  </script>
  <div class="show">
   <div class="l2"><span id="localtime" style="margin-right:18px"></span><a style="margin-right:2px;" href="#" id="chgSkin" title="切换皮肤"><img src="/Skin/Public/Img/skin.png" /></a> <span class="hi">您好：<strong><?php echo $_SESSION['login']['se_user'] ?></strong> 您有<span id="smsid" class="margin_lr bgcolor_bolck bgcolor_cs" style="cursor:pointer;" onclick="toShowSms()"></span>条通知 - <?php echo $_SESSION['login']['se_group'] ?> &nbsp;[<a href="javascript:toSendMail();">发邮件</a>] <?php if($group_access>=9999){ ?>[<a href="javascript:toClearCache();">清除缓存</a>]<?php } ?> [<a href="javascript:toRepwd();">修改密码</a>] [<a href="javascript:toSetpwd();">邮箱设置</a>] [<a target="_top" href="/index.php?s=<?php echo MODULE_NAME; ?>&m=Index&a=safe">注销</a>] [<a href="/index.php" target="_blank">网站首页</a>]</span></div>
</div>
<script runat="server" language="javascript">
function tick(){  
    var today;  
    today = new Date();
    document.getElementById("localtime").innerHTML = showLocale(today);  
    window.setTimeout("tick()", 1000);  
}
tick();
</script>
 </div>
 <div data-options="region:'west',split:true,title:'菜单'" style="width:165px;">
  <script language="javascript">
	function onClickTree(node){
		var id = node.id;
		var tit = node.text;
		var url = node.url;
		var icon = node.iconCls;
		//alert(url);
		if(url){
			addTabs(id,tit,url,icon);
		}
	}
	
	var idd = '';
	var tit = '';
	var url = '';
	var icon = '';
	function addTabs(id,tit,url,icon){
//		$(function(){
			var mod = '<?php echo (C("CFG_OPEN_TABS")); ?>';
            console.log(url);
			//alert(mod);
			if(mod==1){
				var ishas = $("#rightTabs").tabs('exists',tit);
				if(!ishas){
					$("#rightTabs").tabs('add',{
						id : idd,
						title : tit,
						href : ''+url,
						closable : true,
						iconCls : icon
					});
				}else{
					$("#rightTabs").tabs('select',tit);
				}
			}else{
				var ishas = $("#rightTabs").tabs('exists',tit);
				if(!ishas){
					var tab = $("#rightTabs").tabs('getTab',0);
					$.get('/index.php/Admin/index/clear', function(data){});
					$("#rightTabs").tabs('update',{
						tab:tab,
						options:{
							id:-1,
							title : tit,
							href : ''+url,
							closable : false,
							iconCls : icon
						} 
					});
				}else{
					$("#rightTabs").tabs('select',tit);
				}
			}
//		});
	}
</script>
<div id="leftMenu" data-options="fit:true,border:false" class="easyui-accordion">
<?php if(is_array($info)): foreach($info as $key=>$t): if($t['mode']==1){ $access = \Admin\Helper\IndexHelper::GS('User_group_table',$gid); }elseif($t['mode']==2){ $access = \Admin\Helper\IndexHelper::GS('User_company_table',$cid); }elseif($t['mode']==3){ $access = \Admin\Helper\IndexHelper::GS('User_part_table',$pid); } ?>
 <?php if($t['type']=='='): $view = unserialize($t['view']); if(strstr($t['level'],$access) || ($group_access>=999 && $t['level']<9999) || in_array($uid,$view)){ ?>
  <div title="<?php echo ($t["text"]); ?>" data-options="iconCls:'<?php echo ($t["iconCls"]); ?>'">
   <ul class="easyui-tree left-tree" data-options="url:'/index.php/Admin/Index/json/mid/<?php echo ($t["id"]); ?>',editable:false,lines:true,method:'get',onClick:function(node){onClickTree(node);}"></ul>
  </div>
  <?php
 } ?>
 <?php else: ?>
  <?php
 $view = unserialize($t['view']); if($access>=$t['level'] || in_array($uid,$view)){ ?>
  <div title="<?php echo ($t["text"]); ?>" data-options="iconCls:'<?php echo ($t["iconCls"]); ?>'">
   <ul class="easyui-tree left-tree" data-options="url:'/index.php/Admin/Index/json/mid/<?php echo ($t["id"]); ?>',editable:false,lines:true,method:'get',onClick:function(node){onClickTree(node);}"></ul>
  </div>
  <?php
 } endif; endforeach; endif; ?>
<!--
 <div title="系统管理" data-options="iconCls:'icon-setting'">
 <ul class="easyui-tree left-tree",editable:false,lines:true">
  <li data-options="text:'菜单管理',url:'__GROUP_/Menu/index'">菜单管理</li>
 </ul>
 </div>
-->
</div>
 </div>
 <div data-options="region:'center',split:true" class="center-wd">
  <div id="rightTabs" class="easyui-tabs" data-options="fit:true,border:false">
    <div title="项目列表" data-options="closable:false,id:-1,href:'/index.php/Admin/project/index'"></div>
  </div>
 </div>
 <div id="repwd"></div>
 <div id="setpwd"></div>
</body>
</html>