<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" >
    <meta keywords="<?= C('SEO_KEYWORDS'); ?>">
    <meta description="<?= C('SEO_DESCRIPTION'); ?>">
    <title>发票设置-<?= C('SEO_TITLE'); ?></title>
    <link href="/Public/css/CSS.css" rel="stylesheet" type="text/css">
    <link href="/Public/css/user.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="/Public/js/jquery.min.js"></script>
    <script type="text/javascript" src="/Public/js/formValidator.min.js"></script>
    <script type="text/javascript" src="/Public/js/formValidatorRegex.js"></script>
    <script type="text/javascript" src="/Skin/Public/Js/ueditor/ueditor.config.js"></script>
    <script type="text/javascript" src="/Skin/Public/Js/ueditor/ueditor.all.js"></script>
    <script type="text/javascript" src="/Skin/Public/Js/ueditor/lang/zh-cn/zh-cn.js"></script>
    <script>
      $(function () {
        $.formValidator.initConfig({formID: "form1", theme: 'ArrowSolidBox', mode: 'AutoTip', onError: function (msg) {
            alert(msg)
          }, inIframe: true});

      });

    </script>
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
          <h3>发票信息</h3>
        </div>
        <div class="m_body">
          <form id="form1" method="post" action="">
            <table class="m_table_no_border">
              <tbody>
                <tr><th align="left">发票抬头：</th><td><b class="yellow"><?php echo ($info['company']); ?></b></td></tr>
                <tr><th align="left">发票类型：</th><td align="left"><label><input type="radio" name="itype" value="1">增值税普通发票</label>&nbsp;&nbsp;&nbsp;&nbsp;<label><input type="radio" name="itype" value="0">增值税专用发票</label></td></tr>
                <tr><th align="left">税务登记证号：</th><td align="left"><input name="taxcer_no" id='taxcer_no' class="input_public" value="<?php echo ($info['taxcer_no']); ?>" type="text" size="50"></td></tr>
                <tr><th align="left">基本开户银行名称：</th><td align="left"><input name="bank" id='bank' class="input_public" value="<?php echo ($info['bank']); ?>" type="text" size="50"></td></tr>
                <tr><th align="left">基本开户账号：</th><td align="left"><input name="account_no" id='account_no' class="input_public" value="<?php echo ($info['account_no']); ?>" type="text" size="50"></td></tr>
                <tr><th align="left">注册场所地址：</th><td align="left"><input name="register_addr" id='register_addr' class="input_public" value="<?php echo ($info['register_addr']); ?>" type="text" size="50"></td></tr>
                <tr><th align="left">注册固定电话：</th><td align="left"><input name="telephone" id='telephone' class="input_public" value="<?php echo ($info['telephone']); ?>" type="text" size="50"></td></tr>
                <tr><th align="left">营业执照复印件：</th><td align="left"><input name="licence_copy" id='licence_copy' class="input_public" value="<?php echo ($info['licence_copy']); ?>" type="text" size="50"></td></tr>
                <tr><th align="left">税务登记复印件：</th><td align="left"><input name="taxcer_copy" id='taxcer_copy' class="input_public" value="<?php echo ($info['taxcer_copy']); ?>" type="text" size="50"></td></tr>
                <tr><th align="left">一般纳税人资格认证复印件：</th><td align="left"><input name="taxpayer_copy" id='taxpayer_copy' class="input_public" value="<?php echo ($info['taxpayer_copy']); ?>" type="text" size="50"></td></tr>

                <tr><th></th><td align="left"><input value="提交" class="dosubmit" type="submit"></td></tr>
              </tbody></table>
          </form>  
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