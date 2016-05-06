<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" >
    <meta keywords="<?= C('SEO_KEYWORDS'); ?>">
    <meta description="<?= C('SEO_DESCRIPTION'); ?>">
    <title>会员中心-<?= C('SEO_TITLE'); ?></title>
    <link href="__PUBLIC__/css/CSS.css" rel="stylesheet" type="text/css">
    <link href="__PUBLIC__/css/user.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="__PUBLIC__/js/jquery.min.js"></script>
  </head>

  <body>
  <include file="index:_head" />
  <!--首页导航 end-->
  <div id="member_top">
    <div class="member_top">
      <div class="m_touxiang fl"><img src="{$info['avatar']}"></div>
      <div class="m_info fl">
        <div class="p1">下午好，{$info['nickname']}</div>
        <div class="p2">手机：{$info['mobile']}<?php if($info['email']){ ?> &nbsp;&nbsp;&nbsp;&nbsp;邮箱：{$info['email']}<?php } ?></div>
      </div>
      <ul class="m_list fl">
        <li>
          <div class="p1">您的账户</div>
          <div class="p2">￥{$info['amount']}</div>
        </li>
        <li>
          <div class="p1">您的红包</div>
          <div class="p2">共3个 价值1500元</div>
        </li>
        <li>
          <div class="p1">您的积分</div>
          <div class="p2">{$info['point']}个积分</div>
        </li>
        <li>
          <div class="p1">您的等级</div>
          <div class="p2">{$info['groupname']}</div>
        </li>
      </ul>
    </div>
  </div>


  <div id="neiye_main" class="clearfix">
    <div class="member_main">
      <div class="member_left fl">
        <div class="member_left_title"><span>个人主页</span></div>
        <include file="_menu" />

      </div>
      <div class="member_right fr">
        <div class="member_right_top">
          <ul>
            <li class="m_daifukuan"><a href=""><span>正在交易( 3 )</span></a></li>
            <li class="m_daishouhuo"><a href=""><span>需求中心( 3 )</span></a></li>
            <li class="m_daifahuo"><a href=""><span>我的主页</span></a></li>
            <li class="m_daipingjia"><a href=""><span>我的评价( 3 )</span></a></li>
          </ul>
        </div>
        <div class="m_zjdd mt30">
          <div class="m_head"><h3>近期订单</h3><a class="m_more" href="">查看所有订单</a></div>
          <table class="m_table m_zjdd_table" >
            <tr><th>订单号</th><th>状态</th><th>总金额</th><th>下单时间</th><th>操作</th></tr>
            <tr><td class="red">888888888888</td><td>已付款</td><td class="red">￥800.00</td><td>2015-02-10 12:00:00</td><td ><a href="">查看详情</a></td></tr>
            <tr><td class="red">888888888888</td><td>已付款</td><td class="red">￥800.00</td><td>2015-02-10 12:00:00</td><td ><a href="">查看详情</a></td></tr>
            <tr><td class="red">888888888888</td><td>已付款</td><td class="red">￥800.00</td><td>2015-02-10 12:00:00</td><td ><a href="">查看详情</a></td></tr>
            <tr><td class="red">888888888888</td><td>已付款</td><td class="red">￥800.00</td><td>2015-02-10 12:00:00</td><td ><a href="">查看详情</a></td></tr>
          </table>
        </div>

        <div class="m_qqsc mt30">
          <div class="m_head"><h3>帮助</h3></div>
          <ul class="m_body helplist">
            <li><a href="">售后服务保证</a></li>
            <li><a href="">售后服务保证</a></li>
            <li><a href="">售后服务保证</a></li>
            <li><a href="">售后服务保证</a></li>
            <li><a href="">售后服务保证</a></li>
            <li><a href="">售后服务保证</a></li>
            <li><a href="">售后服务保证</a></li>
            <li><a href="">售后服务保证</a></li>
            <li><a href="">售后服务保证</a></li>
            <li><a href="">售后服务保证</a></li>
          </ul>
        </div>
      </div>
      <div class="clear"></div>
    </div>

  </div>

  <include file="index:_foot" />
</body>
</html>
