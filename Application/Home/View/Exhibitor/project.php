<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" >
    <title>发布需求-<?= C('SEO_TITLE'); ?></title>
    <link href="__PUBLIC__/css/CSS.css" rel="stylesheet" type="text/css">
    <link href="__PUBLIC__/css/user.css" rel="stylesheet" type="text/css">
    <style>input.input_public{height:24px;line-height: 24px;}</style>
    <script type="text/javascript" src="__PUBLIC__/js/jquery.min.js"></script>
    <script type="text/javascript" src="__ITEM__/__UI__/jquery.easyui.min.js"></script>
    <script type="text/javascript" src="__PUBLIC__/js/formValidator.min.js"></script>
    <script type="text/javascript" src="__PUBLIC__/js/formValidatorRegex.js"></script>
    <script charset="utf-8" src="__ITEM__/__JS__/color.all.min.js"></script>
    <script charset="utf-8" src="__ITEM__/__JS__/jqColor.js"></script>
    <script>
      $(function () {
        $.formValidator.initConfig({formID: "form1", theme: 'ArrowSolidBox', mode: 'AutoTip', onError: function (msg) {
            alert(msg)
          }, inIframe: true});
      });
      $(function () {
        function fontColor(scolor) {
          var r = 0;
          for (var i = 1; i < 7; i += 2) {
            r += parseInt("0x" + scolor.slice(i, i + 2));
          }
          return r / 3 < 128 ? '#fff' : '#000';
        }

<?php if ($info["baseinfo"]['main_color'] != '') { ?>
          var main_color = ["<?= str_replace(',', '","', $info["baseinfo"]['main_color']) ?>"];
          for (i in main_color) {
            var _color = main_color[i];
            var $ele = $('<a href="javascript:void(0);" style="background-color:' + _color + ';color:' + fontColor(_color) + '"><span>' + _color + '</span><em></em></a>');
            $ele.appendTo($("#main_color-show"));
            $ele.find("em").click(function () {
              $ele.remove();
              $("#main_color-btn").show();
              $("#main_color-factory").show();
              for (i in main_color) {
                if (main_color[i] == $ele.find('span:eq(0)').html()) {
                  main_color.splice(i, 1);
                }
              }
            });
          }
<?php } else { ?>
          var main_color = [];
<?php } ?>

        $("#main_color-btn").click(function () {
          if (main_color.length < 5) {
            var _color = $("#main_color-factory").val();
            if (_color != '' && $.inArray(_color, main_color) == -1) {
              main_color.push(_color);
              var $ele = $('<a href="javascript:void(0);" style="background-color:' + _color + ';color:' + fontColor(_color) + '"><span>' + _color + '</span><em></em></a>');
              $ele.appendTo($("#main_color-show"));
              $("#main_color").val(main_color.join(','));
              $ele.find("em").click(function () {
                $ele.remove();
                $("#main_color-btn").show();
                $("#main_color-factory").show();
                for (i in main_color) {
                  if (main_color[i] == $ele.find('span:eq(0)').html()) {
                    main_color.splice(i, 1);
                  }
                }
                $("#main_color").val(main_color.join(','));
              })
            }
            if (main_color.length == 5) {
              $(this).hide();
              $("#main_color-factory").hide();
            }
          }
        });
<?php if ($info["baseinfo"]['vice_color'] != '') { ?>
          var vice_color = ["<?= str_replace(',', '","', $info["baseinfo"]['vice_color']) ?>"];
          for (i in vice_color) {
            var _color = vice_color[i];
            var $ele2 = $('<a href="javascript:void(0);" style="background-color:' + _color + ';color:' + fontColor(_color) + '"><span>' + _color + '</span><em></em></a>');
            $ele2.appendTo($("#vice_color-show"));
            $ele2.find("em").click(function () {
              $ele2.remove();
              $("#vice_color-btn").show();
              $("#vice_color-factory").show();
              for (i in vice_color) {
                if (vice_color[i] == $ele2.find('span:eq(0)').html()) {
                  vice_color.splice(i, 1);
                }
              }
            });
          }
<?php } else { ?>
          var vice_color = [];
<?php } ?>

        $("#vice_color-btn").click(function () {
          if (vice_color.length < 5) {
            var _color = $("#vice_color-factory").val();
            if (_color != '' && $.inArray(_color, vice_color) == -1) {
              vice_color.push(_color);
              var $ele = $('<a href="javascript:void(0);" style="background-color:' + _color + ';color:' + fontColor(_color) + '"><span>' + _color + '</span><em></em></a>');
              $ele.appendTo($("#vice_color-show"));
              $("#vice_color").val(vice_color.join(','));
              $ele.find("em").click(function () {
                $ele.remove();
                $("#vice_color-btn").show();
                $("#vice_color-factory").show();
                for (i in vice_color) {
                  if (vice_color[i] == $ele.find('span:eq(0)').html()) {
                    vice_color.splice(i, 1);
                  }
                }
                $("#vice_color").val(vice_color.join(','));
              });
              if (vice_color.length == 5) {
                $(this).hide();
                $("#vice_color-factory").hide();
              }
            }
          }
        });
<?php if ($info["baseinfo"]['taboo_color'] != '') { ?>
          var taboo_color = ["<?= str_replace(',', '","', $info["baseinfo"]['taboo_color']) ?>"];
          for (i in taboo_color) {
            var _color = taboo_color[i];
            var $ele3 = $('<a href="javascript:void(0);" style="background-color:' + _color + ';color:' + fontColor(_color) + '"><span>' + _color + '</span><em></em></a>');
            $ele3.appendTo($("#taboo_color-show"));
            $ele3.find("em").click(function () {
              $ele3.remove();
              $("#taboo_color-btn").show();
              $("#taboo_color-factory").show();
              for (i in taboo_color) {
                if (taboo_color[i] == $ele3.find('span:eq(0)').html()) {
                  taboo_color.splice(i, 1);
                }
              }
            });
          }
<?php } else { ?>
          var taboo_color = [];
<?php } ?>

        $("#taboo_color-btn").click(function () {
          if (taboo_color.length < 5) {
            var _color = $("#taboo_color-factory").val();
            if (_color != '' && $.inArray(_color, taboo_color) == -1) {
              taboo_color.push(_color);
              var $ele = $('<a href="javascript:void(0);" style="background-color:' + _color + ';color:' + fontColor(_color) + '"><span>' + _color + '</span><em></em></a>');
              $ele.appendTo($("#taboo_color-show"));
              $("#taboo_color").val(taboo_color.join(','));
              $ele.find("em").click(function () {
                $ele.remove();
                $("#taboo_color-btn").show();
                $("#taboo_color-factory").show();
                for (i in taboo_color) {
                  if (taboo_color[i] == $ele.find('span:eq(0)').html()) {
                    taboo_color.splice(i, 1);
                  }
                }
                $("#taboo_color").val(taboo_color.join(','));
              });
              if (taboo_color.length == 5) {
                $(this).hide();
                $("#taboo_color-factory").hide();
              }
            }
          }
        });
        $(".jscolor").colorPicker();
      });</script>
  </head>

  <body>
  <include file="index:_head" />

  <div id="neiye_main" class="clearfix">
    <div class="member_main">
      <div class="member_left fl">
        <div class="member_left_title"><span>个人主页</span></div>
        <include file="_menu" />
      </div>
      <div class="member_right fr">
        <div class="m_head">
          <h3>订单编辑</h3>
        </div>
        <div class="m_body">
          <?php if ($act == 'edit') { ?>
            <p style="margin-bottom:10px;"><input type="button" class="dosubmit" value="我要修改" id="edit-form"></p>
            <script>
              $(function () {
                $("#edit-form").click(function () {
                  $("#form-info").hide();
                  $("#form-box").show();
                  return false;
                });
              })
            </script>
            <div id="form-info">

              <include file="member:_projectInfo" />
            </div>
          <?php } ?>
          <div id="form-box"<?php if ($act == 'edit') echo ' style="display:none"'; ?>>
            <form id="form1" method="post" action="__SELF__">
              <input type="hidden" name="act" value="{$act}">
              <input type="hidden" name="id" value="{$info['id']}">
              <table width="820" border="1" cellspacing="0" cellpadding="2">
                <tr>
                  <th width="45" rowspan="3" valign="middle" align="center">
                    项<br><br>目
                  </th>
                  <td width="79" height="26" align="center">展会名称：</td>
                  <td colspan="4">
                    <input class="input_public" type="text" name="exhibition" id="exhibition{$uniqid}" value="{$info['exhibition']}" style="width:99%">
                  </td>
                </tr>
                <tr>
                  <td rowspan="2" align="center">负责人<br>联系方式</td>
                  <td width="76" align="center" height="26">联系人</td>
                  <td>
                    <input class="input_public" type="text" name="linkman" id="linkman{$uniqid}" value="{$info['linkman']}" style="width:97.9%">
                  </td>
                  <td width="76" align="center">E-mail</td>
                  <td>
                    <input class="input_public" type="text" name="email" id="email{$uniqid}" value="{$info['email']}" style="width:97.9%">
                  </td>
                </tr>
                <tr>
                  <td align="center" height="26">电话</td>
                  <td>
                    <input class="input_public" type="text" name="telephone" id="telephone{$uniqid}" value="{$info['telephone']}" style="width:97.9%">
                  </td>
                  <td align="center">网址</td>
                  <td>
                    <input class="input_public" type="text" name="website" id="website{$uniqid}" value='{$info.website}' style="width:97.9%">
                  </td>
                </tr>
                <tr>
                  <th rowspan="15" align="center" valign="center">设<br><br>计<br><br>要<br><br>求</th>
                  <td rowspan="4" align="center">设计风格</td>
                  <td align="center" height="26"><label>主色调</label></td>
                  <td colspan="3" align="center">
                    <input type="hidden" name="main_color" id="main_color" value="<?= $info['baseinfo']['main_color'] ?>">
                    <div class="plus-tag" id="main_color-show"></div>
                    <input class="jscolor input_public" id="main_color-factory" size="5" style="float:left;margin:0 3px 0 0;">
                    <a class="btn-yellow-sm" id="main_color-btn" style="float:left;margin-left:0">添加</a>
                  </td>
                </tr>
                <tr>
                  <td align="center" height="26">辅助色调</td>
                  <td colspan="3">
                    <input type="hidden" name="vice_color" id="vice_color" value="<?= $info['baseinfo']['vice_color'] ?>">
                    <div class="plus-tag" id="vice_color-show"></div>
                    <input class="jscolor input_public" id="vice_color-factory" size="5" style="float:left;margin:0 3px 0 0;">
                    <a class="btn-yellow-sm" id="vice_color-btn" style="float:left;margin-left:0">添加</a>

                  </td>
                </tr>
                <tr>
                  <td align="center" height="26">忌用色调</td>
                  <td colspan="3">
                    <input type="hidden" name="taboo_color" id="taboo_color" value="<?= $info['baseinfo']['taboo_color'] ?>">
                    <div class="plus-tag" id="taboo_color-show"></div>
                    <input class="jscolor input_public" id="taboo_color-factory" size="5" style="float:left;margin:0 3px 0 0;">
                    <a class="btn-yellow-sm" id="taboo_color-btn" style="float:left;margin-left:0">添加</a>

                  </td>
                </tr>
                <tr>
                  <td height="26" colspan="4">
                    <?php $arr = $info['baseinfo']['manner'] ? explode(',', $info['baseinfo']['manner']) : []; ?>
                    <label for="manner_0" style="font-weight: normal">现代 <input type="checkbox" name="manner[]" value="0"<?php if (in_array(0, $arr)) echo ' checked'; ?>> </label>&nbsp;
                    <label for="manner_1" style="font-weight: normal">高雅 <input type="checkbox" name="manner[]" value="1"<?php if (in_array(1, $arr)) echo ' checked'; ?>> </label>&nbsp;
                    <label for="manner_2" style="font-weight: normal">实用 <input type="checkbox" name="manner[]" value="2"<?php if (in_array(2, $arr)) echo ' checked'; ?>> </label>&nbsp;
                    <label for="manner_3" style="font-weight: normal">简洁 <input type="checkbox" name="manner[]" value="3"<?php if (in_array(3, $arr)) echo ' checked'; ?>> </label>&nbsp;
                    <label for="manner_4" style="font-weight: normal">怀旧 <input type="checkbox" name="manner[]" value="4"<?php if (in_array(4, $arr)) echo ' checked'; ?>> </label>&nbsp;
                    <label for="manner_5" style="font-weight: normal">科技 <input type="checkbox" name="manner[]" value="5"<?php if (in_array(5, $arr)) echo ' checked'; ?>> </label>&nbsp;
                    <label for="manner_6" style="font-weight: normal">欧式 <input type="checkbox" name="manner[]" value="6"<?php if (in_array(6, $arr)) echo ' checked'; ?>> </label>
                  </td>
                </tr>
                <tr>
                  <td height="26" align="center">功能区域</td>
                  <td colspan="4">
                    洽谈桌椅 <input class="input_public" type="text" name="desk_num" id="desk_num{$uniqid}" size="2" value="<?= $info['baseinfo']['desk_num'] ?>"> 套；
                    半封闭洽谈室 <input class="input_public" type="text" name="room_num" id="room_num{$uniqid}" size="2" value="<?= $info['baseinfo']['room_num'] ?>"> 个（从外面看不到里面）；
                    储藏室 <input class="input_public" type="text" name="store_num" id="store_num{$uniqid}" size="2" value="<?= $info['baseinfo']['store_num'] ?>"> 个
                  </td>
                </tr>
                <tr>
                  <td height="26" align="center">演示设备</td>
                  <td colspan="4">
                    <?php $arr = $info['baseinfo']['equipments'] ? explode(',', $info['baseinfo']['equipments']) : []; ?>
                    <label for="partition_0" style="font-weight: normal">音响设备 <input type="checkbox" name="equipments[]" value="0"<?php if (in_array(0, $arr)) echo ' checked'; ?>> </label>&nbsp;
                    <label for="partition_1" style="font-weight: normal">等离子  <input type="checkbox" name="equipments[]" value="1"<?php if (in_array(1, $arr)) echo ' checked'; ?>> </label>&nbsp;
                    <label for="partition_2" style="font-weight: normal">电视墙 <input type="checkbox" name="equipments[]" value="2"<?php if (in_array(2, $arr)) echo ' checked'; ?>> </label>&nbsp;
                    <label for="partition_3" style="font-weight: normal">电脑  <input type="checkbox" name="equipments[]" value="3"<?php if (in_array(3, $arr)) echo ' checked'; ?>> </label>&nbsp;
                    <label for="partition_4" style="font-weight: normal">插U盘电视 <input type="checkbox" name="equipments[]" value="4"<?php if (in_array(4, $arr)) echo ' checked'; ?>> </label>&nbsp;
                    其他 <input class="input_public" type="text" name="equipments_other" id="equipments_other{$uniqid}" size="20" value="<?= $info['baseinfo']['equipments_other'] ?>">

                  </td>
                </tr>
                <tr>
                  <td height="26" align="center">展台灯光</td>
                  <td colspan="4">
                    <?php $value = $info['baseinfo']['light']; ?>
                    <label for="light_0" style="font-weight: normal">冷光 <input type="radio" name="light" value="0"<?php if ($value == '0') echo ' checked'; ?>> </label>&nbsp;
                    <label for="light_1" style="font-weight: normal">暖光 <input type="radio" name="light" value="1"<?php if ($value == '1') echo ' checked'; ?>> </label>&nbsp;
                    <label for="light_2" style="font-weight: normal">混合 <input type="radio" name="light" value="2"<?php if ($value == '2') echo ' checked'; ?>> </label>&nbsp;
                    其他 <input class="input_public" type="text" name="light_other" id="store_num{$uniqid}" size="20" value="<?= $info['baseinfo']['light_other'] ?>">

                  </td>
                </tr>
                <tr>
                  <td height="26" align="center">空间要求</td>
                  <td colspan="4">
                    整个展台是 <select class="input_public" name="floor_num">
                      <?php $value = $info['baseinfo']['space_style']; ?>
                      <option  value="1"<?php if ($value == 1) echo ' selected'; ?>>单层</option>  
                      <option value="2"<?php if ($value == 2) echo ' selected'; ?>>两层</option>  
                    </select>
                    <select class="input_public" name="space_style">
                      <?php $value = $info['baseinfo']['space_style']; ?>
                      <option  value="0"<?php if ($value == 0) echo ' selected'; ?>>半封闭式</option>  
                      <option value="1"<?php if ($value == 1) echo ' selected'; ?>>封闭式</option>  
                      <option value="2"<?php if ($value == 2) echo ' selected'; ?>>开放式</option>
                    </select>
                  </td>
                </tr>
                <tr>
                  <td height="26" align="center">展台结构</td>
                  <td>主要材料</td>
                  <td>
                    <select class="input_public" name="meteria" id="meteria">
                      <?php $value = $info['baseinfo']['meteria']; ?>
                      <option value="0"<?php if ($value == 0) echo ' selected'; ?>>木质</option>  
                      <option value="1"<?php if ($value == 1) echo ' selected'; ?>>金属</option>  
                    </select>
                  </td>
                  <td height="26"><div align="center">线条要求：</div></td>
                  <td colspan="2">
                    <select class="input_public" name="line_style" id="line_style">
                      <?php $value = $info['baseinfo']['line_style']; ?>
                      <option value="0"<?php if ($value == 0) echo ' selected'; ?>>弧线形</option>  
                      <option value="1"<?php if ($value == 1) echo ' selected'; ?>>直线形</option>
                      <option value="2"<?php if ($value == 2) echo ' selected'; ?>>圆形</option>
                      <option value="3"<?php if ($value == 3) echo ' selected'; ?>>综合形</option>
                    </select>&nbsp;

                    其他 <input class="input_public" type="text" name="line_other" id="line_other{$uniqid}" size="20" value="<?= $info['baseinfo']['line_other'] ?>">

                  </td>
                </tr>
                <tr>
                  <td height="26" align="center">展位划分</td>
                  <td colspan="4">
                    <?php $arr = $info['baseinfo']['partition'] ? explode(',', $info['baseinfo']['partition']) : []; ?>
                    <label for="partition_0" style="font-weight: normal">接待区 <input type="checkbox" name="partition[]" value="0"<?php if (in_array(0, $arr)) echo ' checked'; ?>> </label>&nbsp;
                    <label for="partition_1" style="font-weight: normal">洽谈区 <input type="checkbox" name="partition[]" value="1"<?php if (in_array(1, $arr)) echo ' checked'; ?>> </label>&nbsp;
                    <label for="partition_2" style="font-weight: normal">产品展示区 <input type="checkbox" name="partition[]" value="2"<?php if (in_array(2, $arr)) echo ' checked'; ?>> </label>&nbsp;
                    <label for="partition_3" style="font-weight: normal">休息区 <input type="checkbox" name="partition[]" value="3"<?php if (in_array(3, $arr)) echo ' checked'; ?>> </label>&nbsp;
                    <label for="partition_4" style="font-weight: normal">储藏区 <input type="checkbox" name="partition[]" value="4"<?php if (in_array(4, $arr)) echo ' checked'; ?>> </label>&nbsp;
                    <label for="partition_5" style="font-weight: normal">形象展示区 <input type="checkbox" name="partition[]" value="5"<?php if (in_array(5, $arr)) echo ' checked'; ?>> </label>&nbsp;
                    <label for="partition_6" style="font-weight: normal">多媒体演示区 <input type="checkbox" name="partition[]" value="6"<?php if (in_array(6, $arr)) echo ' checked'; ?>> </label>
                  </td>
                </tr>
                <tr>
                  <td height="26" align="center">地面处理</td>
                  <td colspan="4">
                    <?php $arr = $info['baseinfo']['floor'] ? explode(',', $info['baseinfo']['floor']) : []; ?>
                    <label for="floor_0" style="font-weight: normal">地毯 <input type="checkbox" name="floor[]" value="0"<?php if (in_array(0, $arr)) echo ' checked'; ?>> </label>&nbsp;
                    <label for="floor_1" style="font-weight: normal">瓷砖 <input type="checkbox" name="floor[]" value="1"<?php if (in_array(1, $arr)) echo ' checked'; ?>> </label>&nbsp;
                    <label for="floor_2" style="font-weight: normal">木地板 <input type="checkbox" name="floor[]" value="2"<?php if (in_array(2, $arr)) echo ' checked'; ?>> </label>&nbsp;
                    <label for="floor_3" style="font-weight: normal">地台 <input type="checkbox" name="floor[]" value="3"<?php if (in_array(3, $arr)) echo ' checked'; ?>> </label>&nbsp;
                    <label for="floor_4" style="font-weight: normal">发光地台 <input type="checkbox" name="floor[]" value="4"<?php if (in_array(4, $arr)) echo ' checked'; ?>> </label>&nbsp;
                    其他 <input class="input_public" type="text" name="floor_other" id="floor_other{$uniqid}" size="20" value="<?= $info['baseinfo']['floor_other'] ?>">

                  </td>
                </tr>
                <tr>
                  <td height="26" align="center">平面图</td>
                  <td colspan="4">
                    展位号 <input class="input_public" type="text" name="exhibition_no" id="exhibition_no{$uniqid}" size="5" value="<?= $info['exhibition_no'] ?>"> &nbsp;
                    展位面积 <input class="input_public" type="text" name="floor_area" id="floor_area{$uniqid}" size="5" value="<?= $info['floor_area'] ?>"> m<sup>2</sup> &nbsp;
                    规格/几面开口  <select class="input_public" name="open_num">
                      <?php $value = $info['baseinfo']['open_num']; ?>
                      <option value='0'<?php if ($value == 0) echo ' selected'; ?>>请选择</option>
                      <option value="1"<?php if ($value == 1) echo ' selected'; ?>>1面开口</option>  
                      <option value="2"<?php if ($value == 2) echo ' selected'; ?>>2面开口</option> 
                      <option value="3"<?php if ($value == 3) echo ' selected'; ?>>3面开口</option>  
                      <option value="4"<?php if ($value == 4) echo ' selected'; ?>>4面开口</option>
                    </select> 
                  </td>
                </tr>
                <tr>
                  <td height="26" align="center">展品清单</td>
                  <td colspan="4">
                    <input class="input_public" type="text" name="detail" id="detail{$uniqid}" style="width:99%" value="<?= $info['baseinfo']['detail'] ?>">
                  </td>
                </tr>
                <tr>
                  <td height="26" align="center">展示方式</td>
                  <td colspan="4">
                    <?php $arr = $info['baseinfo']['display'] ? explode(',', $info['baseinfo']['display']) : []; ?>
                    <label for="display_0" style="font-weight: normal">悬挂 <input type="checkbox" name="display[]" value="0"<?php if (in_array(0, $arr)) echo ' checked'; ?>> </label>&nbsp;
                    <label for="display_1" style="font-weight: normal">展示柜 <input type="checkbox" name="display[]" value="1"<?php if (in_array(1, $arr)) echo ' checked'; ?>> </label>&nbsp;
                    <label for="display_2" style="font-weight: normal">展示架 <input type="checkbox" name="display[]" value="2"<?php if (in_array(2, $arr)) echo ' checked'; ?>> </label>&nbsp;
                    <label for="display_3" style="font-weight: normal">挑高式(高于地面) <input type="checkbox" name="display[]" value="3"<?php if (in_array(3, $arr)) echo ' checked'; ?>> </label>&nbsp;
                    其他 <input class="input_public" type="text" name="display_other" id="display_other{$uniqid}" size="20" value="<?= $info['baseinfo']['display_other'] ?>">
                  </td>
                </tr>
                <tr>
                  <td height="26" align="center">预算</td>
                  <td colspan="2">
                    <input class="input_public" type="text" name="budget" id="budget{$uniqid}" style="width:97.9%" value="<?= $info['baseinfo']['budget'] ?>">
                  </td>
                  <td align="center">截稿日期</td>
                  <td colspan="1">
                    <input class="input_public" type="text" name="enddate" id="enddate" size="10" value="<?= $info['baseinfo']['enddate'] ?>">
                  </td>
                </tr>
                <tr>
                  <th align="center" height="110">备<br><br>注</th>
                  <td colspan="5"><textarea name="content" id="contentID{$uniqid}" style="width:99%; height:100px;float:left;"><?= $info['baseinfo']['content'] ?></textarea></td>
                </tr>
              </table>
              <p style="width:830px;margin-top:20px;text-align:center;">
                <input class="dosubmit" type="submit" value="提交">
              </p>
            </form>
          </div>
          <?php if ($act = 'edit') { ?>

            <div class="mt20" id="filelist-box">
              <div class="m_head"><h3>项目附件</h3></div>
              <table class="m_table" style="width:820px;" id="file-list">
                <thead><tr><th width="40">序号</th><th>文件名</th><th>附件</th><th width="150">更新时间</th><th width="100">操作</th></tr></thead>
                <tbody>
                  <?php foreach ($filesList as $k => $v) { ?>
                    <tr id="file_<?= $v['id'] ?>">
                      <td align="center"><?php echo $k + 1; ?></td><td align="left"><a href="<?= U('Exhibitor/file', ['act' => 'edit', 'pro_id'=>$info['id'],'id' => $v['id']]) ?>"><?= $v['title'] ?></a></td><td align="left"><?= $v['path'] ?></td><td align="center"><?= $v['addtime'] ?></td><td align="center">修改</a>&nbsp;&nbsp;<a href="javascript:void(0)" onclick="delFile(<?= $v['des_id'] ?>,<?= $v['id'] ?>)" class="red">删除</a></td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
            <div class="mt20" id="fileadd-box">
              <div class="m_head"><h3>附件添加</h3></div>
              <div class="m_body" style="width:820px;">
                <form id="file-form" method="post" action="<?= U('Exhibitor/file') ?>">
                  <input type="hidden" name="act" value="add">
                  <input type="hidden" name="pro_id" value="{$info['id']}">
                  <table class="m_table_no_border" width="100%" border="0" cellspacing="0" cellpadding="2">
                    <tr>
                      <th width="70" valign="middle" align="left">
                        文件名:
                      </th>
                      <td>
                        <input class="input_public" type="text" name="title" id="title{$uniqid}" value="" size="50">
                      </td>
                    </tr>
                    <tr>
                      <th height="26" align="left">附件:</th>
                      <td>
                        <input name="path" type="file">
                      </td>
                    </tr>
                    <tr>
                      <th align="left">内容:</th>
                      <td><textarea name="content" id="content" style="width:700px;height:300px;"></textarea></td>
                    </tr>
                  </table>
                  <p style="width:820px;margin-top:20px;text-align:center;">
                    <input class="dosubmit" type="submit" value="提交">
                  </p>
                </form>
              </div>
            </div>

          <?php } ?>
        </div>
      </div>
      <div class="clear"></div>
    </div>

  </div>

  <include file="index:_foot" />
</body>
</html>
