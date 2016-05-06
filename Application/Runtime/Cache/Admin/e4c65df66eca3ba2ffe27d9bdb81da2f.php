<?php if (!defined('THINK_PATH')) exit();?><style>
  /* plus-tag */
.plus-tag{float:left;padding:0;display: inline-block;margin-top:5px;    line-height: 22px;vartical-align:middle;}
.plus-tag a {
    float:left;
    display: block;
    height: 22px;
    color: #333333;
    overflow: hidden;
    margin: 0 10px 0 0;
    padding: 0 5px;
    white-space: nowrap;
}
.plus-tag a span{float:left;display: block;}
.plus-tag a em {background: url(/Skin/Public/Img/closetag.png) no-repeat;}
.plus-tag a em{display:block;margin:5px 0 0 8px;width:13px;height:13px;overflow:hidden;background-position:0 -36px;cursor:pointer;}

.plus-tag a:hover em{background-position:-3px 0;}
.plus-tag a:hover em{color:#fff;}

</style>
<script language="javascript">
var role = '<?php echo ($role); ?>';
var act = '<?php echo ($act); ?>';
if(role==-2){
	$.messager.alert('提示','您没有新增权限！','warning');
	cancel['Project'].dialog('close');
	cancel['Project'] = null;
}else if(role==-3){
	$.messager.alert('提示','您没有编辑权限！','warning');
	cancel['Project'].dialog('close');
	cancel['Project'] = null;
}
$(function(){
	$("#addFormProject<?php echo ($uniqid); ?>").form('load',{
		'company':'<?= $info["company"] ?>',
		'exhibition':'<?= $info["exhibition"] ?>',
        'linkman':'<?= $info["linkman"] ?>',
        'telephone':'<?= $info["telephone"] ?>',
        'email':'<?= $info["email"] ?>',
        'floor_area':'<?= $info["floor_area"] ?>',
        'website':'<?= $info["website"] ?>',
        'main_color':'<?= $info["baseinfo"]["main_color"] ?>',
        'vice_color':'<?= $info["baseinfo"]["vice_color"] ?>',
        'taboo_color':'<?= $info["baseinfo"]["taboo_color"] ?>',
        'manner':'<?= $info["baseinfo"]["manner"] ?>',
        'desk_num':'<?= $info["baseinfo"]["desk_num"] ?>',
        'room_num':'<?= $info["baseinfo"]["room_num"] ?>',
        'store_num':'<?= $info["baseinfo"]["store_num"] ?>',
        'equipments':'<?= $info["baseinfo"]["equipments"] ?>',
        'light':'<?= $info["baseinfo"]["light"] ?>',
        'light_other':'<?= $info["baseinfo"]["light_other"] ?>',
        'space_style':'<?= $info["baseinfo"]["space_style"] ?>',
        'meteria':'<?= $info["baseinfo"]["meteria"] ?>',
        'float_num':'<?= $info["baseinfo"]["float_num"] ?>',
        'line_style':'<?= $info["baseinfo"]["line_style"] ?>',
        'partition':'<?= $info["baseinfo"]["partition"] ?>',
        'floor':'<?= $info["baseinfo"]["floor"] ?>',
        'floor_other':'<?= $info["baseinfo"]["floor_other"] ?>',
        'open_num':'<?= $info["baseinfo"]["open_num"] ?>',
		'enddate':'<?= $info["baseinfo"]["enddate"] ?>',
		'views':'<?= $info["views"] ?>',
		'userid':'<?= $info["userid"] ?>',
        'exhibition_id':'<?= $info["exhibition_id"] ?>',
		'code':'<?= $info["code"] ?>'
	});
//	$("#client_id<?php echo ($uniqid); ?>").combobox({
//		url:'/Application/Runtime/Data/Json/Client_data.json',
//		editable:true,
//		method:'get',
//		required:false,
//		valueField:'id',
//		textField:'text'
//	});
	$("#status<?php echo ($uniqid); ?>").combobox({
		url:'/Application/Runtime/Data/Json/Linkage/xiangmuzhuangtai_notit_data.json',
		editable:false,
		method:'get',
		required:false,
		valueField:'id',
		textField:'text'
	});
    function fontColor(scolor){
        var r = 0;
		for(var i=1; i<7; i+=2){
			r += parseInt("0x" + scolor.slice(i,i+2));	
		}
        return r/3 < 128 ?'#fff':'#000'; 
    }
    
    
    <?php if($info["baseinfo"]['main_color'] !=''){ ?>
      var main_color = ["<?= str_replace(',','","',$info["baseinfo"]['main_color']) ?>"];
        for(i in main_color){
          var _color = main_color[i];
          var $ele = $('<a href="javascript:void(0);" style="background-color:'+_color+';color:'+fontColor(_color)+'"><span>'+_color+'</span><em></em></a>');
      $ele.appendTo($("#main_color-show"));
          $ele.find("em").click(function(){
            $ele.remove();
            for(i in main_color){
              if(main_color[i] == $ele.find('span:eq(0)').html()){
                main_color.splice(i, 1);
              }
            }
        });
      }
    <?php }else{ ?>
      var main_color = [];
    <?php } ?>
    
    $("#main_color-btn").click(function(){
        if(main_color.length < 5){
          var _color = $("#main_color-factory").val();
          if(_color != '' && $.inArray(_color, main_color) == -1){
            main_color.push(_color);
            var $ele = $('<a href="javascript:void(0);" style="background-color:'+_color+';color:'+fontColor(_color)+'"><span>'+_color+'</span><em></em></a>');
            $ele.appendTo($("#main_color-show"));
            $("#main_color").val(main_color.join(','));
            
            $ele.find("em").click(function(){
              $ele.remove();
              for(i in main_color){
                if(main_color[i] == $ele.find('span:eq(0)').html()){
                  main_color.splice(i, 1);
                }
              }
              $("#main_color").val(main_color.join(','));
            })
          }
        }
    });

    <?php if($info["baseinfo"]['vice_color'] !=''){ ?>
      var vice_color = ["<?= str_replace(',','","',$info["baseinfo"]['vice_color']) ?>"];
        for(i in vice_color){
          var _color = vice_color[i];
          var $ele2 = $('<a href="javascript:void(0);" style="background-color:'+_color+';color:'+fontColor(_color)+'"><span>'+_color+'</span><em></em></a>');
          $ele2.appendTo($("#vice_color-show"));
          $ele2.find("em").click(function(){
            $ele2.remove();
            for(i in vice_color){
              if(vice_color[i] == $ele2.find('span:eq(0)').html()){
                vice_color.splice(i, 1);
              }
            }
        });
      }
    <?php }else{ ?>
      var vice_color = [];
    <?php } ?>
    
    $("#vice_color-btn").click(function(){
        if(vice_color.length < 5){
          var _color = $("#vice_color-factory").val();
          if(_color != '' && $.inArray(_color, vice_color) == -1){
            vice_color.push(_color);
            var $ele = $('<a href="javascript:void(0);" style="background-color:'+_color+';color:'+fontColor(_color)+'"><span>'+_color+'</span><em></em></a>');
            $ele.appendTo($("#vice_color-show"));
            $("#vice_color").val(vice_color.join(','));
            
            $ele.find("em").click(function(){
              $ele.remove();
              for(i in vice_color){
                if(vice_color[i] == $ele.find('span:eq(0)').html()){
                  vice_color.splice(i, 1);
                }
              }
              $("#vice_color").val(vice_color.join(','));
            })
          }
        }
    });
    
        <?php if($info["baseinfo"]['taboo_color'] !=''){ ?>
      var taboo_color = ["<?= str_replace(',','","',$info["baseinfo"]['taboo_color']) ?>"];
        for(i in taboo_color){
          var _color = taboo_color[i];
          var $ele3 = $('<a href="javascript:void(0);" style="background-color:'+_color+';color:'+fontColor(_color)+'"><span>'+_color+'</span><em></em></a>');
          $ele3.appendTo($("#taboo_color-show"));
          $ele3.find("em").click(function(){
            $ele3.remove();
            for(i in taboo_color){
              if(taboo_color[i] == $ele3.find('span:eq(0)').html()){
                taboo_color.splice(i, 1);
              }
            }
        });
      }
    <?php }else{ ?>
      var taboo_color = [];
    <?php } ?>
    
    $("#taboo_color-btn").click(function(){
        if(taboo_color.length < 5){
          var _color = $("#taboo_color-factory").val();
          if(_color != '' && $.inArray(_color, taboo_color) == -1){
            taboo_color.push(_color);
            var $ele = $('<a href="javascript:void(0);" style="background-color:'+_color+';color:'+fontColor(_color)+'"><span>'+_color+'</span><em></em></a>');
            $ele.appendTo($("#taboo_color-show"));
            $("#taboo_color").val(taboo_color.join(','));
            
            $ele.find("em").click(function(){
              $ele.remove();
              for(i in taboo_color){
                if(taboo_color[i] == $ele.find('span:eq(0)').html()){
                  taboo_color.splice(i, 1);
                }
              }
              $("#taboo_color").val(taboo_color.join(','));
            })
          }
        }
    });

    
    
    $(".jscolor").colorPicker();

});

var idd = '';
function onSubmitProject(idd){
	$.messager.progress();
	$("#addFormProject"+idd).form('submit',{
		url:'/index.php/Admin/Project/add/act/add/go/1',
		onSubmit: function(){
			var isValid = $(this).form('validate');
			if (!isValid){
				$.messager.progress('close');
			}
			return isValid;
		},
		success:function(data){
			$.messager.progress('close');
      //console.log(data);
			if(data==1){
				$.messager.alert('提示','新增数据成功！','info',function(){
					var sa = '<?php echo (C("SUBMIT_ACTION")); ?>';
					cancel['ProjectName'].datagrid('reload');
					if(sa==1){
						cancel['Project'].dialog('close');
						cancel['Project'] = null;
					}
				});
			}else if(data==0){
				$.messager.alert('提示','新增数据失败！','warning');
			}else{
				$.messager.alert('提示','您没有新增权限！','warning',function(){
					var sa = '<?php echo (C("SUBMIT_ACTION")); ?>';
					if(sa==1){
						cancel['Project'].dialog('close');
						cancel['Project'] = null;
					}
				});
			}
		}
	});
}

function onUploadProject(idd){
	$.messager.progress();
	var ids = $("#ids"+idd).val();
	$("#addFormProject"+idd).form('submit',{
		url:'/index.php/Admin/Project/add/act/edit/go/1/id/'+ids,
		onSubmit: function(){
			var isValid = $(this).form('validate');
			if (!isValid){
				$.messager.progress('close');
			}
			return isValid;
		},
		success:function(data){
			$.messager.progress('close');
            console.log(data);
			if(data==1){
				$.messager.alert('提示','更新数据成功！','info',function(){
					var sa = '<?php echo (C("SUBMIT_ACTION")); ?>';
					cancel['ProjectName'].datagrid('reload');
					$("#proDetailCon").panel('refresh');
					if(sa==1){
						cancel['Project'].dialog('close');
						cancel['Project'] = null;
					}
				});
				$("#add").dialog('refresh');
			}else if(data==0){
				$.messager.alert('提示','更新数据失败！','warning');
			}else{
				$.messager.alert('提示','您没有更新权限！','warning',function(){
					var sa = '<?php echo (C("SUBMIT_ACTION")); ?>';
					if(sa==1){
						cancel['Project'].dialog('close');
						cancel['Project'] = null;
					}
				});
			}
		}
	});
}

function onResetProject(idd){
	cancel['Project'].dialog('close');
	cancel['ProjectName'] = null;
	cancel['Project'] = null;
}
</script>
<div class="con-tb">
<form class="projecr-form" id="addFormProject<?php echo ($uniqid); ?>" method="post">
 <table class="infobox" width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="13%"><label for="exhibition">展会名称</label><input id="ids<?php echo ($uniqid); ?>" type="hidden" value="<?php echo ($id); ?>" /></td>
    <td><input name="exhibition" type="text" class="easyui-validatebox" value="" style="width:99%;" data-options="required:true,validType:'ptext'" /></td>
    <td><label for="status">项目状态</label></td>
    <td><input name="status" id="status<?php echo ($uniqid); ?>" class="relo" size="10" /> <span>(选择后，将强制改变项目进度)</span></td>
    </tr>
  <tr>
    <td width="13%"><label for="linkman">联系人</label></td>
    <td width="37%"><input name="linkman" id="linkman<?php echo ($uniqid); ?>" data-options="required:true" size="28" /> </td>
    <td width="13%"><label for="telephone">电话</label></td>
    <td width="37%"><input name="telephone" id="telephone<?php echo ($uniqid); ?>" data-options="required:true,validType:'Tel'" size="28" /></td>
  </tr>
  <tr>
    <td width="13%"><label for="email">电子邮箱</label></td>
    <td width="37%"><input name="email" id="email<?php echo ($uniqid); ?>" data-options="required:true,validType:'email'" size="28" /> </td>
    <td width="13%"><label for="website">网址</label></td>
    <td width="37%"><input name="website" id="telephone<?php echo ($uniqid); ?>" data-options="required:true,validType:'url'" size="28" /></td>
  </tr>
  <tr>
    <td width="13%"><label>主色调</label></td>
    <td colspan="3">
      <input type="hidden" name="main_color" id="main_color">
      <div class="plus-tag" id="main_color-show"></div>
      <input class="jscolor" id="main_color-factory" size="5" style="float:left;margin:3px 3px 0 0;">
      <a class="easyui-linkbutton" href="#" data-options="iconCls:'icon-add'" id="main_color-btn" style="float:left;margin-top:3px;">添加</a>
    </td>
  </tr>
  <tr>
    <td width="13%"><label>辅助色调</label></td>
    <td colspan="3">
      <input type="hidden" name="vice_color" id="vice_color">
      <div class="plus-tag" id="vice_color-show"></div>
      <input class="jscolor" id="vice_color-factory" size="5" style="float:left;margin:3px 3px 0 0;">
      <a class="easyui-linkbutton" href="#" data-options="iconCls:'icon-add'" id="vice_color-btn" style="float:left;margin-top:3px;">添加</a>

    </td>
  </tr>
  <tr>
    <td width="13%"><label>忌用色调</label></td>
    <td colspan="3">
      <input type="hidden" name="taboo_color" id="taboo_color">
      <div class="plus-tag" id="taboo_color-show"></div>
      <input class="jscolor" id="taboo_color-factory" size="5" style="float:left;margin:3px 3px 0 0;">
      <a class="easyui-linkbutton" href="#" data-options="iconCls:'icon-add'" id="taboo_color-btn" style="float:left;margin-top:3px;">添加</a>

    </td>
  </tr>
  <tr>
    <td width="13%"><label>设计风格</label></td>
    <td colspan="3">
      <label for="manner_0" style="font-weight: normal">现代 <input type="checkbox" name="manner" value="1"> </label>&nbsp;
      <label for="manner_1" style="font-weight: normal">高雅 <input type="checkbox" name="manner" value="2"> </label>&nbsp;
      <label for="manner_2" style="font-weight: normal">实用 <input type="checkbox" name="manner" value="3"> </label>&nbsp;
      <label for="manner_3" style="font-weight: normal">简洁 <input type="checkbox" name="manner" value="4"> </label>&nbsp;
      <label for="manner_4" style="font-weight: normal">怀旧 <input type="checkbox" name="manner" value="5"> </label>&nbsp;
      <label for="manner_5" style="font-weight: normal">科技 <input type="checkbox" name="manner" value="6"> </label>&nbsp;
      <label for="manner_6" style="font-weight: normal">欧式 <input type="checkbox" name="manner" value="7"> </label>
    </td>
      </tr>
  <tr>
    <td width="13%"><label>功能区域</label></td>
    <td colspan="3">
      洽谈桌椅 <input type="text" name="desk_num" id="desk_num<?php echo ($uniqid); ?>" size="2"> 套；
      半封闭洽谈室 <input type="text" name="room_num" id="room_num<?php echo ($uniqid); ?>" size="2"> 个（从外面看不到里面）；
      储藏室 <input type="text" name="store_num" id="store_num<?php echo ($uniqid); ?>" size="2"> 个
    </td>
  </tr>
    <tr>
    <td width="13%"><label>演示设备</label></td>
    <td colspan="3">
      <label for="partition_0" style="font-weight: normal">音响设备 <input type="checkbox" name="equipments[]" value="1"> </label>&nbsp;
      <label for="partition_1" style="font-weight: normal">等离子 <input type="checkbox" name="equipments[]" value="2"> </label>&nbsp;
      <label for="partition_2" style="font-weight: normal">电视墙 <input type="checkbox" name="equipments[]" value="3"> </label>&nbsp;
      <label for="partition_3" style="font-weight: normal">电脑  <input type="checkbox" name="equipments[]" value="4"> </label>&nbsp;
      <label for="partition_4" style="font-weight: normal">插U盘电视 <input type="checkbox" name="equipments[]" value="5"> </label>
      其他 <input type="text" name="equipments_other" id="equipments_other<?php echo ($uniqid); ?>" size="20">
    </td>
  </tr>
  <tr>
    <td width="13%"><label>展台灯光</label></td>
    <td colspan="3">
      <label for="light_0" style="font-weight: normal">冷光 <input type="radio" name="light" value="1"> </label>&nbsp;
      <label for="light_1" style="font-weight: normal">暖光 <input type="radio" name="light" value="2"> </label>&nbsp;
      <label for="light_2" style="font-weight: normal">混合 <input type="radio" name="light" value="3"> </label>&nbsp;
      其他 <input type="text" name="store_num" id="store_num<?php echo ($uniqid); ?>" size="20">
    </td>
  </tr>
  <tr>
    <td width="13%"><label>空间要求</label></td>
    <td colspan="3">
        整个展台是 <select class="easyui-combobox" name="floor_num" editable="false">  
    	<option  value="1">单层</option>  
        <option value="2">两层</option>  
    </select> 
    <select class="easyui-combobox" name="space_style" editable="false">  
    	<option  value="0">半封闭式</option>  
        <option value="1">封闭式</option>  
        <option value="2">开放式</option>
    </select>
    </td>
  </tr>
  <tr>
    <td width="13%"><label for="meteria">结构主要材料</label></td>
    <td width="37%">
      <select class="easyui-combobox" name="meteria" editable="false">  
    	<option value="0">木质</option>  
        <option value="1">金属</option>  
      </select>
    </td>
    <td width="13%"><label for="line_style">线条要求</label></td>
    <td width="37%">
      <select class="easyui-combobox" name="line_style" editable="false">  
    	<option value="0">弧线形</option>  
        <option value="1">直线形</option>
        <option value="2">圆形</option>
        <option value="3">综合形</option>
      </select>
    </td>
  </tr>
  <tr>
    <td width="13%"><label>展位划分</label></td>
    <td colspan="3">
      <label for="partition_0" style="font-weight: normal">接待区 <input type="checkbox" name="partition" value="1"> </label>&nbsp;
      <label for="partition_1" style="font-weight: normal">洽谈区 <input type="checkbox" name="partition" value="2"> </label>&nbsp;
      <label for="partition_2" style="font-weight: normal">产品展示区 <input type="checkbox" name="partition" value="3"> </label>&nbsp;
      <label for="partition_3" style="font-weight: normal">休息区  <input type="checkbox" name="partition" value="4"> </label>&nbsp;
      <label for="partition_4" style="font-weight: normal">储藏区 <input type="checkbox" name="partition" value="5"> </label>&nbsp;
      <label for="partition_5" style="font-weight: normal">形象展示区 <input type="checkbox" name="partition" value="5"> </label>&nbsp;
      <label for="partition_6" style="font-weight: normal">多媒体演示区 <input type="checkbox" name="partition" value="5"> </label>
    </td>
  </tr>
  <tr>
    <td width="13%"><label>地面处理</label></td>
    <td colspan="3">
      <label for="floor_0" style="font-weight: normal">地毯 <input type="checkbox" name="floor" value="1"> </label>&nbsp;
      <label for="floor_1" style="font-weight: normal">瓷砖 <input type="checkbox" name="floor" value="2"> </label>&nbsp;
      <label for="floor_2" style="font-weight: normal">木地板 <input type="checkbox" name="floor" value="3"> </label>&nbsp;
      <label for="floor_3" style="font-weight: normal">地台  <input type="checkbox" name="floor" value="4"> </label>&nbsp;
      <label for="floor_4" style="font-weight: normal">发光地台口 <input type="checkbox" name="floor" value="5"> </label>&nbsp;
      其他 <input type="text" name="floor_other" id="floor_other<?php echo ($uniqid); ?>" size="20">
    </td>
  </tr>
  <tr>
    <td width="13%"><label>平面图</label></td>
    <td colspan="3">
      展位号 <input type="text" name="exhibition_no" id="exhibition_no<?php echo ($uniqid); ?>" size="5"> &nbsp;
      展位面积 <input type="text" name="floor_area" id="floor_area<?php echo ($uniqid); ?>" size="5"> m<sup>2</sup> &nbsp;
     规格/几面开口  <select class="easyui-combobox" name="open_num" editable="false">  
       <option value='0'>请选择</option>
       <option value="1">1面开口</option>  
       <option value="2">2面开口</option> 
       <option value="3">3面开口</option>  
       <option value="4">4面开口</option>
     </select> 
    </td>
  </tr>
  <tr>
    <td width="13%"><label for="code">项目代码</label></td>
    <td width="37%"><input name="code" id="code<?php echo ($uniqid); ?>" class="easyui-validatebox" size="12" data-options="validType:'ptext'" /> (留空时，自动生成) </td>
    <td width="13%"><label for="client_id">所属客户</label></td>
    <td width="37%"><input name="client_id" id="client_id<?php echo ($uniqid); ?>" size="28" class="relo" /></td>
  </tr>
  <tr>
    <td width="13%"><label for="contents">备注</label></td>
    <td colspan="3">
    <textarea name="content" id="contentID<?php echo ($uniqid); ?>"  rows="18" style="width:99%; height:100px" data-options="uploadJson:'/index.php/Admin/Upload/save/act/project'"><?php echo ($info["baseinfo"]["content"]); ?></textarea>
    </td>
  </tr>
  <tr>
    <td height="38" colspan="4" align="center"><?php if($act=='add'): ?><a href="javascript:void(0);" onclick="javascript:onSubmitProject('<?php echo ($uniqid); ?>')" id="su" class="easyui-linkbutton" data-options="iconCls:'icon-save'">保存</a><?php else: ?><a href="javascript:void(0);" onclick="javascript:return onUploadProject('<?php echo ($uniqid); ?>')" id="sue" class="easyui-linkbutton" data-options="iconCls:'icon-save'">保存</a><?php endif; ?> &nbsp; <a href="javascript:void(0);" onclick="javascript:onResetProject('<?php echo ($uniqid); ?>')" id="re" class="easyui-linkbutton" data-options="iconCls:'icon-cancel'">关闭</a></td>
  </tr>
 </table>
</form>
</div>