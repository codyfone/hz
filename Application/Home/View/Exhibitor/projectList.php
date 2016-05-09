<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" >
    <meta keywords="<?= C('SEO_KEYWORDS'); ?>">
    <meta description="<?= C('SEO_DESCRIPTION'); ?>">
    <title>基本信息修改-<?= C('SEO_TITLE'); ?></title>
    <link href="__PUBLIC__/css/CSS.css" rel="stylesheet" type="text/css">
    <link href="__PUBLIC__/css/user.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="__PUBLIC__/js/jquery.min.js"></script>
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
          <h3>订单信息</h3>
        </div>
        <table class="m_table" style="width:100%">
          <thead><tr><th width="70">订单号</th><th>展会</th><th width="70">展位面积</th><th width="85">截稿日期</th><th width="70">订单状态</th><th width="160">稿件统计</th><th width="60"></th></tr></thead>
          <tbody>
            <?php foreach ($new_info['rows'] as $v) { ?>
            <tr><td class="red" align="center">{$v['t1_code']}</td><td><?php if ($v['t1_exhibitin_id'] != 0) { ?><a href="{:U('Zhanhui/view',['id'=>$v['t1_exhibitin_id']])}" tareget="_blank">{$v['t1_exhibition']}</a><?php } else { ?>{$v['t1_exhibition']}<?php } ?></td><td>{$v['t1_floor_area']}m2</td><td>{$v['t2_enddate']}</td><td><?= $v['t1_old_check'] == 0 ? '<span class="red">待审核</span>':$v['t1_new_pass']; ?></td><td>意向:<span class="red"><?= $v['design_count']; ?></span>， 完成：<span class="red"><?= $v['design_comple']; ?></span></td><td><a href="{:U('Exhibitor/project',['act'=>'edit','id'=>$v['id']])}">详情</a></td></tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
      <div class="clear"></div>
    </div>

  </div>

  <include file="index:_foot" />
</body>
</html>
