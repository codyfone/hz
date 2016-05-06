<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" >
    <meta keywords="<?= C('SEO_KEYWORDS'); ?>">
    <meta description="<?= C('SEO_DESCRIPTION'); ?>">
    <title>会员中心-<?= C('SEO_TITLE'); ?></title>
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
  <!--首页导航 end-->
  <div id="member_top">
    <div class="member_top">
      <div class="m_touxiang fl"><img src="<?php echo ($info['avatar']); ?>"></div>
      <div class="m_info fl">
        <div class="p1">下午好，<?php echo ($info['nickname']); ?></div>
        <div class="p2">手机：<?php echo ($info['mobile']); if($info['email']){ ?> &nbsp;&nbsp;&nbsp;&nbsp;邮箱：<?php echo ($info['email']); } ?></div>
      </div>
      <ul class="m_list fl">
        <li>
          <div class="p1">您的账户</div>
          <div class="p2">￥<?php echo ($info['amount']); ?></div>
        </li>
        <li>
          <div class="p1">您的红包</div>
          <div class="p2">共3个 价值1500元</div>
        </li>
        <li>
          <div class="p1">您的积分</div>
          <div class="p2"><?php echo ($info['point']); ?>个积分</div>
        </li>
        <li>
          <div class="p1">您的等级</div>
          <div class="p2"><?php echo ($info['groupname']); ?></div>
        </li>
      </ul>
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