<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" >
    <meta keywords="<?= C('SEO_KEYWORDS'); ?>">
    <meta description="<?= C('SEO_DESCRIPTION'); ?>">
    <title>项目详情-<?= C('SEO_TITLE'); ?></title>
    <link href="/Public/css/CSS.css" rel="stylesheet" type="text/css">
    <link href="/Public/css/user.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="/Public/js/jquery.min.js"></script>
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
    <li><a href="<?php echo U('designer/design');?>">我的方案</a></li>
     <li><a href="<?php echo U('designer/project');?>">最新订单</a></li>
  </ul>
</div>
<div class="member_list">
  <div class="member_list_title"><span>案例管理</span></div>
  <ul>
    <li><a href="">我的案例</a></li>
    <li><a href="">展装商城</a></li>
  </ul>
</div>
<div class="member_list">
  <div class="member_list_title"><span>账户中心</span></div>
  <ul>
    <li><a href="<?php echo U('designer/baseinfo');?>">基本信息</a></li>
    <li><a href="<?php echo U('designer/profile');?>">资料设置</a></li>
    <li><a href="<?php echo U('designer/finnance');?>">财务管理</a></li>
  </ul>
</div>
      </div>
      <div class="member_right fr">
        <div class="m_head">
          <h3>项目详情</h3>
        </div>
        <div class="m_body">
          <h1 style="margin-bottom: 10px;font-size:26px;"><?= $info['company'] ?></h1>
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