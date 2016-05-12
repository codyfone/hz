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
          <thead><tr><th>订单号</th><th>方案名称</th><th>来自</th><th>方案状态</th><th>计划开始</th><th>计划完成</th><th>方案进度</th></tr></thead>
          <tbody>
            
            <tr><td class="red">888888888888</td><td>已付款</td><td class="red">￥800.00</td><td>2015-02-10 12:00:00</td><td ><a href="">查看详情</a></td></tr>
          </tbody>
        </table>
      </div>
      <div class="clear"></div>
    </div>

  </div>

  <include file="index:_foot" />
</body>
</html>
