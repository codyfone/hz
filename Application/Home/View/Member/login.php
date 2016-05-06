<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" >
    <meta keywords="<?= C('SEO_KEYWORDS'); ?>">
    <meta description="<?= C('SEO_DESCRIPTION'); ?>">
    <title>会员登录-<?= C('SEO_TITLE'); ?></title>
    <link href="__PUBLIC__/css/CSS.css" rel="stylesheet" type="text/css">
    <link href="__PUBLIC__/css/login.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="__PUBLIC__/js/jquery.min.js"></script>
    <script type="text/javascript" src="__PUBLIC__/js/formValidator.min.js"></script>
    <script type="text/javascript" src="__PUBLIC__/js/formValidatorRegex.js"></script>
  </head>

  <body>
  <include file="index:_head" />

  <div class="register_main">
    <div class="container_1200">
      <div class="fill_50"></div>
      <div class="left_ad_container">
        <img src="__PUBLIC__/images/login_ad_img.jpg" alt="">
      </div>
      <div class="right_form_container">

        <div class="login_left fl">
          <div class="login_form">
            <h2 style="color:#e92424;font-size:26px;font-weight: bold;margin-bottom: 20px;">会员登录</h2>
            <form method="post" action="" id="myform" name="myform">
              <div class="login_user"><input class="input-txt" type="text" id="username" name="username" size="22" placeholder="请输入用户名"></div>
              <div class="login_password"><input class="input-txt" type="password" id="password" name="password" size="22" placeholder="请输入密码"></div>
              <div class="login_code"><input class="input-txt" type="text" id="code" name="code" size="8" placeholder="验证码"> <span class="verifycode"><img id="code_img" onclick="this.src = this.src + & quot; & amp; & quot; + Math.random()" src="http://www.jiaguzaixian.com/api.php?op=checkcode&amp;code_len=5&amp;font_size=14&amp;width=120&amp;height=26&amp;font_color=&amp;background="></span></div>
              <!--div class="remember_me"><span class="fl"><input type="checkbox" name="cookietime" value="2592000" id="cookietime">记住用户名</span><a href="{:U('member/get_password')}">密码找回</a></div-->
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