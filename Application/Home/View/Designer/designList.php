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
          <h3>我的方案</h3>
        </div>
        <table class="m_table" style="width:100%">
          <thead><tr><th>订单号</th><th>方案名称</th><th>计划完成</th><th>方案进度</th><th>操作</th></tr></thead>
          <tbody>
            <?php foreach ($new_info['rows'] as $v) { ?>
              <tr><td class="red" align="center"><?= $v['code'] ?></td><td><?= $v['t1_title'] ?></td><td align="center"><?= $v['t1_enddate']; ?></td><td class="red"><?= $v['t1_old_pass']; ?></td><td style="text-align:center;"><a href="<?= U('Designer/design', ['act' => 'edit', 'pro_id' => $v['pro_id'], 'id' => $v['id']]) ?>">查看详情</a></td></tr>
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
