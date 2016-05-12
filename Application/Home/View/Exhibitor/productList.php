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
        <?php if ($type == 1) { ?>
          <div class="m_head">
            <h3>我的案例</h3>
          </div>

          <table class="m_table" style="width:100%">
            <thead><tr><th width="70">编号</th><th>案例名称</th><th width="70">展位面积</th><th width="85">添加时间</th><th width="60"></th></tr></thead>
            <tbody>
              <?php foreach ($new_info['rows'] as $v) { ?>
                <tr><td class="red" align="center"><?= $v['t1_code'] ?></td><td><a href="<?= U('Sheji/anli',['id'=>$v['id']])?>"><?= $v['title'] ?><span class="red">[预览]</span></a></td><td align="center">{$v['floor_area']}m2</td><td align="center" width="145">{$v['addtime']}</td><td align="center"><a href="{:U('Designer/product',['act'=>'edit','id'=>$v['id']])}">修改</a></td></tr>
              <?php } ?>
            </tbody>
          </table>
        <?php } else { ?>
          <div class="m_head">
            <h3>商品案例</h3>
          </div>
          <table class="m_table" style="width:100%">
            <thead><tr><th width="70">编号</th><th>案例名称</th><th width="70">展位面积</th><th width="120">参考价</th><th width="145">更新时间</th><th width="60"></th></tr></thead>
            <tbody>
              <?php foreach ($new_info['rows'] as $v) { ?>
                <tr><td class="red" align="center"><?= $v['t1_code'] ?></td><td><a href="<?= U('Sheji/anli',['id'=>$v['id']])?>"><?= $v['title'] ?><span class="red">[预览]</span></a></td><td align="center">{$v['floor_area']}m2</td><td align="center"><?= $v['price'] ?>元</td><td align="center">{$v['addtime']}</td><td align="center"><a href="{:U('Designer/product',['act'=>'edit','id'=>$v['id']])}">修改</a></td></tr>
              <?php } ?>
            </tbody>
          </table>
        <?php } ?>
        <div class="zh_yema">
          {$page}
        </div>
      </div>
      <div class="clear"></div>
    </div>

  </div>

  <include file="index:_foot" />
</body>
</html>
