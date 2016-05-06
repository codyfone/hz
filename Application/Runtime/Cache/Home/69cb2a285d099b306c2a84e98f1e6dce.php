<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" >
    <title>发布需求-<?= C('SEO_TITLE'); ?></title>
    <link href="/Public/css/CSS.css" rel="stylesheet" type="text/css">
    <link href="/Public/css/user.css" rel="stylesheet" type="text/css">
    <style>input.input_public{height:24px;line-height: 24px;}</style>
    <script type="text/javascript" src="/Public/js/jquery.min.js"></script>
    <script type="text/javascript" src="/Skin/Public/Easyui/jquery.easyui.min.js"></script>
    <script type="text/javascript" src="/Public/js/formValidator.min.js"></script>
    <script type="text/javascript" src="/Public/js/formValidatorRegex.js"></script>
    <script charset="utf-8" src="/Skin/Public/Js/color.all.min.js"></script>
    <script charset="utf-8" src="/Skin/Public/Js/jqColor.js"></script>
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
  <div class="hz_top">
  <div class="hz_topbox">
    <div class="hz_topl">
      <?php if (is_login()) { ?>
        <span>欢迎！</span><a class="a_tf" href="<?= U('Member/index') ?>"><?= session('user_auth')['nickname'] ?> </a> <a class="a_te" href="<?= U('Member/index') ?>">会员中心</a>
        <a href="<?= U('Member/logout') ?>">退出</a>
      <?php } else { ?>
        <a href="<?= U('Member/login') ?>">请登录</a>
        <a class="a_te" href="<?= U('Member/register') ?>">三秒免费注册会员</a>
      <?php } ?>
    </div>
    <div class="hz_topr">
      <div class="hz_top_k hz_top_00">
        <a href="">手机版</a>
      </div>
      <div class="hz_top_k hz_top_01">
        <a href="">帮助中心</a>
      </div>
      <div class="hz_top_k hz_top_02">
        <a href=""></a>
      </div>
      <div class="hz_top_k hz_top_03">
        <a href=""></a>
      </div>
      <div class="hz_top_k hz_top_04">
        <a href="">400-1234-567</a>
      </div>
    </div>
  </div>
</div>
<div class="hz_ser">
  <div class="hz_sec_logo">
    <img src="/Public/images/in_05.png">
  </div>
  <div class="hz_sec_r">
    <form>
      <select name="" id="">
        <option value="全部">全部</option>
        <option value="厂家">厂家</option>
        <option value="设计师">设计师</option>
      </select> 
      <input value="" placeholder="输入您想要查询的内容..." class="input02">
      <input type="submit" value="" class="input01">
    </form>
  </div>
</div>
<div class="zh_nav">
  <div class="Menu">
    <div class="all">
      <div class="m_logo">
        <img src="/Public/images/logo_m.png">
      </div>
      <ul class="clearboth">
        <li class="li1"><a href="/"><span></span><em>首页</em></a></li>
        <li class="li2 li ot"><a href="<?php echo U('Zhanzhuang/index');?>"><span></span><em>展装商城</em></a></li>
        <li class="li6 li ot"><a href="<?php echo U('Index/youshi');?>"><span></span><em>汇展优势</em></a></li>
        <li class="li7 li ot"><a href="<?php echo U('Gongchang/index');?>"><span></span><em>工厂之家</em></a></li>
        <li class="li3 li ot"><a href="<?php echo U('Sheji/index');?>"><span></span><em>设计之家</em></a></li>
        <li class="li4 li ot"><a href="<?php echo U('Zhanhui/index');?>"><span></span><em>行业展会</em></a></li>
        <li class="li5 li" style="background: none;"><a href="<?php echo U('Zhanguan/index');?>"><span></span><em>展馆信息</em></a></li>
      </ul>
    </div>
  </div>
</div>

  <div id="neiye_main" class="clearfix">
    <div class="member_main">
      <div class="member_left fl">
        <div class="member_left_title"><span>个人主页</span></div>
        <div class="member_list">
  <div class="member_list_title"><span>订单中心</span></div>
  <ul>
    <li><a href="<?php echo U('exhibitor/addProject');?>">发布需求</a></li>
    <li><a href="<?php echo U('exhibitor/project');?>">我的订单</a></li>
  </ul>
</div>
<div class="member_list">
  <div class="member_list_title"><span>账户中心</span></div>
  <ul>
    <li><a href="<?php echo U('exhibitor/baseinfo');?>">基本信息</a></li>
    <li><a href="<?php echo U('exhibitor/invoice');?>">发票设置</a></li>
    <li><a href="<?php echo U('exhibitor/finnance');?>">财务管理</a></li>
  </ul>
</div>
      </div>
      <div class="member_right fr">
        <div class="m_head">
          <h3>订单编辑</h3>
        </div>
        <div class="m_body">
          <?php if ($act == 'edit') { ?>
            <div id="form-info">
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
              <script>
  $(function () {
    function fontColor(scolor) {
      var r = 0;
      for (var i = 1; i < 7; i += 2) {
        r += parseInt("0x" + scolor.slice(i, i + 2));
      }
      return r / 3 < 128 ? '#fff' : '#000';
    }

    var main_color = <?php
if ($info['baseinfo']['main_color']) { $main_color = explode(',', $info['baseinfo']['main_color']); echo json_encode($main_color); } else { echo '[]'; } ?>;
    for (i in main_color) {
      $('<a href="javascript:void(0);" style="background-color:' + main_color[i] + ';color:' + fontColor(main_color[i]) + '"><span>' + main_color[i] + '</span></a>').appendTo($("#main_color-show-v"));
    }
    var vice_color = <?php
if ($info['baseinfo']['vice_color']) { $vice_color = explode(',', $info['baseinfo']['vice_color']); echo json_encode($vice_color); } else { echo '[]'; } ?>;
    for (i in vice_color) {
      $('<a href="javascript:void(0);" style="background-color:' + vice_color[i] + ';color:' + fontColor(vice_color[i]) + '"><span>' + vice_color[i] + '</span></a>').appendTo($("#vice_color-show-v"));
    }
    var taboo_color = <?php
if ($info['baseinfo']['taboo_color']) { $taboo_color = explode(',', $info['baseinfo']['taboo_color']); echo json_encode($taboo_color); } else { echo '[]'; } ?>;
    for (i in taboo_color) {
      $('<a href="javascript:void(0);" style="background-color:' + taboo_color[i] + ';color:' + fontColor(taboo_color[i]) + '"><span>' + taboo_color[i] + '</span></a>').appendTo($("#taboo_color-show-v"));
    }
  });
</script>
<table width="820" border="1" cellspacing="0" cellpadding="2">
  <tr>
    <th width="45" rowspan="3" valign="middle" align="center">
      项<br><br>目
    </th>
    <td width="79" height="26" align="center">展会名称：</td>
    <td colspan="4">
      <?php echo ($info['exhibition']); ?>
    </td>
  </tr>
  <tr>
    <td rowspan="2" align="center">负责人<br>联系方式</td>
    <td width="76" align="center" height="26">联系人</td>
    <td>
      <?php echo ($info['linkman']); ?>
    </td>
    <td width="76" align="center">E-mail</td>
    <td>
      <?php echo ($info['email']); ?>
    </td>
  </tr>
  <tr>
    <td align="center" height="26">电话</td>
    <td>
      <?php echo ($info['telephone']); ?>
    </td>
    <td align="center">网址</td>
    <td>
      <?php if ($info['website']) { ?><a href="<?php echo ($info["website"]); ?>" target="_blank"><?php echo ($info["website"]); ?></a><?php } ?>
    </td>
  </tr>
  <tr>
    <th rowspan="15" align="center" valign="center">设<br><br>计<br><br>要<br><br>求</th>
    <td rowspan="4" align="center">设计风格</td>
    <td align="center" height="26"><label>主色调</label></td>
    <td colspan="3" align="center">
      <div class="plus-tag" id="main_color-show-v"></div>
    </td>
  </tr>
  <tr>
    <td align="center" height="26">辅助色调</td>
    <td colspan="3">
      <div class="plus-tag" id="vice_color-show-v"></div>
    </td>
  </tr>
  <tr>
    <td align="center" height="26">忌用色调</td>
    <td colspan="3">
      <div class="plus-tag" id="taboo_color-show-v"></div>
    </td>
  </tr>
  <tr>
    <td height="26" colspan="4">
      <?php
 $arr = ['0' => '现代', '1' => '高雅', '2' => '实用', '3' => '简洁', '4' => '怀旧', '5' => '科技', '6' => '欧式']; $arr2 = explode(',', $info['baseinfo']['manner']); $res = []; foreach ($arr2 as $v) { $res[] = $arr[$v]; } echo implode('，  ', $res); ?>
    </td>
  </tr>
  <tr>
    <td height="26" align="center">功能区域</td>
    <td colspan="4">
      洽谈桌椅 <span class="red"><?= $info['baseinfo']['desk_num'] ?></span> 套；
      半封闭洽谈室 <span class="red"><?= $info['baseinfo']['room_num'] ?></span> 个（从外面看不到里面）；
      储藏室 <span class="red"><?= $info['baseinfo']['store_num'] ?></span> 个
    </td>
  </tr>
  <tr>
    <td height="26" align="center">演示设备</td>
    <td colspan="4">
      <?php
 $arr = ['0' => '音响设备', '1' => '等离子', '2' => '电视墙', '3' => '电脑', '4' => '插U盘电视',]; $arr2 = explode(',', $info['baseinfo']['equipments']); $res = []; foreach ($arr2 as $v) { $res[] = $arr[$v]; } if ($info['baseinfo']['equipments_other']) $res[] = $info['baseinfo']['equipments_other']; echo implode('， ', $res); ?>

    </td>
  </tr>
  <tr>
    <td height="26" align="center">展台灯光</td>
    <td colspan="4">
      <?php
 echo $info['baseinfo']['light']; if ($info['baseinfo']['light_other']) { echo ', ' . $info['baseinfo']['light_other']; } ?>
    </td>
  </tr>
  <tr>
    <td height="26" align="center">空间要求</td>
    <td colspan="4">
      整个展台是 <span class="red"><?= $info['baseinfo']['floor_num'] ?></span> 层， <span class="red"><?= $info['baseinfo']['space_style'] ?></span>
    </td>
  </tr>
  <tr>
    <td height="26" align="center">展台结构</td>
    <td>主要材料</td>
    <td>
      <?php
 $arr = ['0' => '木质', '1' => '金属',]; echo $arr[$info['baseinfo']['meteria']]; ?>
    </td>
    <td height="26"><div align="center">线条要求：</div></td>
    <td colspan="2">
      <?php
 $arr = ['0' => '弧线形', '1' => '直线形', '2' => '圆形', '3' => '综合形',]; echo $arr[$info['baseinfo']['line_style']]; ?>
      <?php if ($info['baseinfo']['line_other']) { ?>
        &nbsp;
        其他 <span class="red"><?php echo ($info['baseinfo']['line_other']); ?></span>
      <?php } ?>
    </td>
  </tr>
  <tr>
    <td height="26" align="center">展位划分</td>
    <td colspan="4">
      <?php
 $arr = ['0' => '接待区', '1' => '洽谈区', '2' => '产品展示区', '3' => '休息区', '4' => '储藏区', '5' => '形象展示区', '6' => '多媒体演示区']; $arr2 = explode(',', $info['baseinfo']['partition']); $res = []; foreach ($arr2 as $v) { $res[] = $arr[$v]; } echo implode('，  ', $res); ?>
    </td>
  </tr>
  <tr>
    <td height="26" align="center">地面处理</td>
    <td colspan="4">
      <?php
 $arr = ['0' => '地毯', '1' => '瓷砖', '2' => '木地板', '3' => '地台', '4' => '发光地台',]; $arr2 = explode(',', $info['baseinfo']['floor']); $res = []; foreach ($arr2 as $v) { $res[] = $arr[$v]; } if ($info['baseinfo']['floor_other']) $res[] = $info['baseinfo']['floor_other']; echo implode('， ', $res); ?>
    </td>
  </tr>
  <tr>
    <td height="26" align="center">平面图</td>
    <td colspan="4">
      展位号 <span class="red"><?php echo ($info['exhibition_no']); ?></span> &nbsp;
      展位面积 <span class="red"><?php echo ($info['floor_area']); ?></span> m<sup>2</sup> &nbsp;
      规格/几面开口  <span class="red"><?php
 $arr = ['0' => '1面开口', '1' => '2面开口', '2' => '3面开口', '3' => '4面开口',]; echo $arr[$info['baseinfo']['line_style']]; ?>
      </span>
    </td>
  </tr>
  <tr>
    <td height="26" align="center">展品清单</td>
    <td colspan="4">
      <?php echo ($info["baseinfo"]["detail"]); ?>
    </td>
  </tr>
  <tr>
    <td height="26" align="center">展示方式</td>
    <td colspan="4">
      <?php
 $arr = ['0' => '悬挂', '1' => '展示柜', '2' => '展示架', '3' => '挑高式(高于地面)',]; $arr2 = explode(',', $info['baseinfo']['display']); $res = []; foreach ($arr2 as $v) { $res[] = $arr[$v]; } if ($info['baseinfo']['display_other']) $res[] = $info['baseinfo']['display_other']; echo implode('， ', $res); ?>
    </td>
  </tr>
  <tr>
    <td height="26" align="center">预算</td>
    <td colspan="2">
      <?php echo $info['baseinfo']['budget']; ?>
    </td>
    <td align="center">截稿日期</td>
    <td colspan="1">
      <?php echo $info['baseinfo']['enddate']; ?>
    </td>
  </tr>
  <tr>
    <th align="center" height="110">备<br><br>注</th>
    <td colspan="5"><?php echo ($info["baseinfo"]["content"]); ?></td>
  </tr>
</table>
            </div>
          <?php } ?>
          <div id="form-box"<?php if ($act == 'edit') echo ' style="display:none"'; ?>>
            <form id="form1" method="post" action="/index.php/Home/exhibitor/addProject/act/edit/id/2.html">
              <input type="hidden" name="act" value="<?php echo ($act); ?>">
              <input type="hidden" name="id" value="<?php echo ($info['id']); ?>">
              <table width="820" border="1" cellspacing="0" cellpadding="2">
                <tr>
                  <th width="45" rowspan="3" valign="middle" align="center">
                    项<br><br>目
                  </th>
                  <td width="79" height="26" align="center">展会名称：</td>
                  <td colspan="4">
                    <input class="input_public" type="text" name="exhibition" id="exhibition<?php echo ($uniqid); ?>" value="<?php echo ($info['exhibition']); ?>" style="width:99%">
                  </td>
                </tr>
                <tr>
                  <td rowspan="2" align="center">负责人<br>联系方式</td>
                  <td width="76" align="center" height="26">联系人</td>
                  <td>
                    <input class="input_public" type="text" name="linkman" id="linkman<?php echo ($uniqid); ?>" value="<?php echo ($info['linkman']); ?>" style="width:97.9%">
                  </td>
                  <td width="76" align="center">E-mail</td>
                  <td>
                    <input class="input_public" type="text" name="email" id="email<?php echo ($uniqid); ?>" value="<?php echo ($info['email']); ?>" style="width:97.9%">
                  </td>
                </tr>
                <tr>
                  <td align="center" height="26">电话</td>
                  <td>
                    <input class="input_public" type="text" name="telephone" id="telephone<?php echo ($uniqid); ?>" value="<?php echo ($info['telephone']); ?>" style="width:97.9%">
                  </td>
                  <td align="center">网址</td>
                  <td>
                    <input class="input_public" type="text" name="website" id="website<?php echo ($uniqid); ?>" value='<?php echo ($info["website"]); ?>' style="width:97.9%">
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
                    洽谈桌椅 <input class="input_public" type="text" name="desk_num" id="desk_num<?php echo ($uniqid); ?>" size="2" value="<?= $info['baseinfo']['desk_num'] ?>"> 套；
                    半封闭洽谈室 <input class="input_public" type="text" name="room_num" id="room_num<?php echo ($uniqid); ?>" size="2" value="<?= $info['baseinfo']['room_num'] ?>"> 个（从外面看不到里面）；
                    储藏室 <input class="input_public" type="text" name="store_num" id="store_num<?php echo ($uniqid); ?>" size="2" value="<?= $info['baseinfo']['store_num'] ?>"> 个
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
                    其他 <input class="input_public" type="text" name="equipments_other" id="equipments_other<?php echo ($uniqid); ?>" size="20" value="<?= $info['baseinfo']['equipments_other'] ?>">

                  </td>
                </tr>
                <tr>
                  <td height="26" align="center">展台灯光</td>
                  <td colspan="4">
                    <?php $value = $info['baseinfo']['light']; ?>
                    <label for="light_0" style="font-weight: normal">冷光 <input type="radio" name="light" value="0"<?php if ($value == '0') echo ' checked'; ?>> </label>&nbsp;
                    <label for="light_1" style="font-weight: normal">暖光 <input type="radio" name="light" value="1"<?php if ($value == '1') echo ' checked'; ?>> </label>&nbsp;
                    <label for="light_2" style="font-weight: normal">混合 <input type="radio" name="light" value="2"<?php if ($value == '2') echo ' checked'; ?>> </label>&nbsp;
                    其他 <input class="input_public" type="text" name="light_other" id="store_num<?php echo ($uniqid); ?>" size="20" value="<?= $info['baseinfo']['light_other'] ?>">

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

                    其他 <input class="input_public" type="text" name="line_other" id="line_other<?php echo ($uniqid); ?>" size="20" value="<?= $info['baseinfo']['line_other'] ?>">

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
                    其他 <input class="input_public" type="text" name="floor_other" id="floor_other<?php echo ($uniqid); ?>" size="20" value="<?= $info['baseinfo']['floor_other'] ?>">

                  </td>
                </tr>
                <tr>
                  <td height="26" align="center">平面图</td>
                  <td colspan="4">
                    展位号 <input class="input_public" type="text" name="exhibition_no" id="exhibition_no<?php echo ($uniqid); ?>" size="5" value="<?= $info['exhibition_no'] ?>"> &nbsp;
                    展位面积 <input class="input_public" type="text" name="floor_area" id="floor_area<?php echo ($uniqid); ?>" size="5" value="<?= $info['floor_area'] ?>"> m<sup>2</sup> &nbsp;
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
                    <input class="input_public" type="text" name="detail" id="detail<?php echo ($uniqid); ?>" style="width:99%" value="<?= $info['baseinfo']['detail'] ?>">
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
                    其他 <input class="input_public" type="text" name="display_other" id="display_other<?php echo ($uniqid); ?>" size="20" value="<?= $info['baseinfo']['display_other'] ?>">
                  </td>
                </tr>
                <tr>
                  <td height="26" align="center">预算</td>
                  <td colspan="2">
                    <input class="input_public" type="text" name="budget" id="budget<?php echo ($uniqid); ?>" style="width:97.9%" value="<?= $info['baseinfo']['budget'] ?>">
                  </td>
                  <td align="center">截稿日期</td>
                  <td colspan="1">
                    <input class="input_public" type="text" name="enddate" id="enddate" size="10" value="<?= $info['baseinfo']['enddate'] ?>">
                  </td>
                </tr>
                <tr>
                  <th align="center" height="110">备<br><br>注</th>
                  <td colspan="5"><textarea name="content" id="contentID<?php echo ($uniqid); ?>" style="width:99%; height:100px;float:left;"><?= $info['baseinfo']['content'] ?></textarea></td>
                </tr>
              </table>
              <p style="width:830px;margin-top:20px;text-align:center;">
                <input class="dosubmit" type="submit" value="提交">
              </p>
            </form>
          </div>
        </div>
      </div>
      <div class="clear"></div>
    </div>

  </div>

  <div class="clear"></div>
<div class="hz_foot">
  <div class="hz_footbox">
    <div class="hz_footl">
      <div class="hz_footls">
        <span>ABOUT US</span>
        <p>关于我们</p>
      </div>
      <div class="hz_footlx">
        <p>汇展之家,传承装修的品质与最好的生活理念,开创了中国全新的装修
          先河流,汇展之家,传承装修的品质与最好的生活理念,开创了中国全
          新的装修。</p>
        <a href=""><img src="/Public/images/foot_03.jpg"></a>
      </div>
    </div>
    <div class="hz_footl">
      <div class="hz_footls">
        <span>OUR SERVICE</span>
        <p>我们的服务</p>
      </div>
      <div class="hz_footlx">
        <div class="hz_foot_a"><a href="">新手指南</a></div>
        <div class="hz_foot_a"><a href="">找设计</a></div>
        <div class="hz_foot_a"><a href="">找搭建</a></div>
        <div class="hz_foot_a"><a href="">智能报价</a></div>
        <div class="hz_foot_a"><a href="">设计师黑名单</a></div>
        <div class="hz_foot_a"><a href="">加工厂黑名单</a></div>
        <div class="hz_foot_a"><a href="">争议处理</a></div>
        <div class="hz_foot_a"><a href="">保险保障</a></div>
        <div class="hz_foot_a"><a href="">找工厂</a></div>
      </div>
    </div>
    <div class="hz_footl hz_foot_te">
      <div class="hz_footls">
        <span>CONTACT US</span>
        <p>联系我们</p>
      </div>
      <div class="hz_footlx">
        <div class="hz_foot_lx">
          <p>地址:<span>郑州市艾尚酒店10楼</span></p>
          <p class="hz_pte">电话:<span>400-1234-567</span></p>
          <p class="hz_pte1">E-mail:<span>zhanhuizhijia@126.com</span></p>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="hz_bq">
  <div class="hz_bqbox">
    <p>Copyright © 2016展会之家 豫ICP备10011451号-6  </p>
    <a href="">技术支持：大华伟业</a>
  </div>
</div>
<script src="/Public/js/public.js"></script>
</body>
</html>