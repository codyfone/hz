<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" >
    <meta keywords="<?= C('SEO_KEYWORDS'); ?>">
    <meta description="<?= C('SEO_DESCRIPTION'); ?>">
    <title>会员登录-<?= C('SEO_TITLE'); ?></title>
    <link href="/Public/css/CSS.css" rel="stylesheet" type="text/css">
    <link href="/Public/css/login.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="/Public/js/jquery.min.js"></script>
    <script type="text/javascript" src="/Public/js/formValidator.min.js"></script>
    <script type="text/javascript" src="/Public/js/formValidatorRegex.js"></script>
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

  <div class="register_main">
    <div class="container_1200">
      <div class="fill_50"></div>
      <div class="left_ad_container">
        <img src="/Public/images/login_ad_img.jpg" alt="">
      </div>
      <div class="right_form_container">

        <div class="login_left fl">
          <div class="login_form">
            <h2 style="color:#e92424;font-size:26px;font-weight: bold;margin-bottom: 20px;">会员登录</h2>
            <form method="post" action="" id="myform" name="myform">
              <div class="login_user"><input class="input-txt" type="text" id="username" name="username" size="22" placeholder="请输入用户名"></div>
              <div class="login_password"><input class="input-txt" type="password" id="password" name="password" size="22" placeholder="请输入密码"></div>
              <div class="login_code"><input class="input-txt" type="text" id="code" name="code" size="8" placeholder="验证码"> <span class="verifycode"><img id="code_img" onclick="this.src = this.src + & quot; & amp; & quot; + Math.random()" src="http://www.jiaguzaixian.com/api.php?op=checkcode&amp;code_len=5&amp;font_size=14&amp;width=120&amp;height=26&amp;font_color=&amp;background="></span></div>
              <!--div class="remember_me"><span class="fl"><input type="checkbox" name="cookietime" value="2592000" id="cookietime">记住用户名</span><a href="<?php echo U('member/get_password');?>">密码找回</a></div-->
              <div class="login_tijiao"><input type="submit" name="dosubmit" id="dosubmit" value="登录"></div>
            </form>

          </div>
        </div>

      </div>
      <div class="clear"></div>
    </div>
  </div>


  <!-- 版权开始 -->
  <p class="copy">Copyright &copy;2015-2015 hz.com All Rights Reserved 汇展之家有限公司 版权所有</p>
  <p class="copy">公司地址:郑州市建业路与建业路交叉口向北500米路西爱尚10楼&nbsp;&nbsp;豫ICP备14023658号</p>
  <!-- 版权结束 -->


  <script type="text/javascript">

    $(document)
            .ajaxStart(function () {
              $("button:submit").addClass("log-in").attr("disabled", true);
            })
            .ajaxStop(function () {
              $("button:submit").removeClass("log-in").attr("disabled", false);
            });


    $("form").submit(function () {
      var self = $(this);
      $.post(self.attr("action"), self.serialize(), success, "json");
      return false;

      function success(data) {
        console.log(data);
        if (data.status) {
          window.location.href = data.url;
        } else {
          self.find(".Validform_checktip").text(data.info);
          //刷新验证码
          $(".reloadverify").click();
        }
      }
    });

    $(function () {
      var verifyimg = $(".verifyimg").attr("src");
      $(".reloadverify").click(function () {
        if (verifyimg.indexOf('?') > 0) {
          $(".verifyimg").attr("src", verifyimg + '&random=' + Math.random());
        } else {
          $(".verifyimg").attr("src", verifyimg.replace(/\?.*$/, '') + '?' + Math.random());
        }
      });
    });
  </script>

</body>
</html>