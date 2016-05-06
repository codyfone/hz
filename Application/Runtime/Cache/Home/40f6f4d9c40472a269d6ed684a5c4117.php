<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" >
    <meta keywords="<?= C('SEO_KEYWORDS'); ?>">
    <meta description="<?= C('SEO_DESCRIPTION'); ?>">
    <title>会员注册-<?= C('SEO_TITLE'); ?></title>
    <link href="/Public/css/CSS.css" rel="stylesheet" type="text/css">
    <link href="/Public/css/login.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="/Public/js/jquery.min.js"></script>
    <script type="text/javascript" src="/Public/js/formValidator.min.js"></script>
    <script type="text/javascript" src="/Public/js/formValidatorRegex.js"></script>
    <script>
      $(function () {
        $.formValidator.initConfig({formID: "myForm", theme: 'ArrowSolidBox', mode: 'AutoTip', onError: function (msg) {
            alert(msg)
          }, inIframe: true});

        $("#username").formValidator({onShow: "请输入用户名,英文字母开头", onFocus: "用户名至少4个字符,最多30个字符", onCorrect: "该用户名可以注册"}).inputValidator({min: 6, max: 10, onError: "你输入的用户名非法,请确认"}).regexValidator({regExp: "username", dataType: "enum", onError: "用户名格式不正确"})
                .ajaxValidator({
                  dataType: "json",
                  async: true,
                  url: "<?= U('Member/checkDenyMember') ?>",
                  success: function (data) {
                    if (data == "1")
                      return true;
                    return "禁止注册或用户已存在";
                  },
                  buttons: $("#button"),
                  onError: "禁止注册或用户已存在",
                  onWait: "请稍候..."
                });
		$("#password").formValidator({onShow:"请输入密码",onFocus:"至少4个长度",onCorrect:"密码合法"}).inputValidator({min:4,empty:{leftEmpty:false,rightEmpty:false,emptyError:"密码两边不能有空符号"},onError:"密码不能为空,请确认"});
		$("#repassword").formValidator({onShow:"输再次输入密码",onFocus:"至少4个长度",onCorrect:"密码一致"}).inputValidator({min:4,empty:{leftEmpty:false,rightEmpty:false,emptyError:"重复密码两边不能有空符号"},onError:"重复密码不能为空,请确认"}).compareValidator({desID:"password",operateor:"=",onError:"2次密码不一致,请确认"});

        $("#email").formValidator({onShow: "请输入邮箱", onFocus: "邮箱格式错误", onCorrect: "邮箱格式正确"}).inputValidator({min: 7, max: 80, onError: "邮箱应该为7-32位之间"}).regexValidator({regExp: "email", dataType: "enum", onError: "邮箱格式错误"}).ajaxValidator({
          type: "get",
          url: "<?= U('Member/checkDenyEmail') ?>",
          dataType: "html",
          async: 'false',
          success: function (data) {
            console.log(data);
            return data == "1"
          },
          buttons: $("#dosubmit"),
          onError: "禁止注册或邮箱已存在",
          onWait: "请稍候..."
        });
<?php if ($modelid == 1 || $modelid == 3) { ?>
  //        $("#nickname").formValidator({onShow: "请输入名称", onFocus: "名称应该为2-20位之间"}).inputValidator({min: 2, max: 80, onError: "名称应该为2-80位之间"}).regexValidator({regExp: "ps_nickname", dataType: "enum", onError: "名称称格式错误"}).ajaxValidator({
  //          type: "get",
  //          url: "<?= U('member/checkDenyNickname') ?>",
  //          dataType: "html",
  //          async: 'false',
  //          success: function (data) {
  //            console.log(data);
  //            return data == "1"
  //          },
  //          buttons: $("#dosubmit"),
  //          onError: "名称已经注册",
  //          onWait: "请稍候..."
  //        });
<?php } ?>
        $("#mobile").formValidator({onShow: "请输入手机号", onFocus: "手机号输入错误", onCorrect: "手机号输入正确"}).inputValidator({min: 11, max: 11, onError: "手机号应该为11位数字"}).regexValidator({regExp: "mobile", dataType: "enum", onError: "手机号无效"}).ajaxValidator({
          type: "get",
          url: "<?= U('Member/checkDenyMobile') ?>",
          dataType: "html",
          async: 'false',
          success: function (data) {
            console.log(data);
            return data == "1"
          },
          buttons: $("#dosubmit"),
          onError: "禁止注册或手机号已被注册",
          onWait: "请稍候..."
        });
        $("#mobile_verify").formValidator({onShow: "请输入手机收到的验证码", onFocus: "请输入手机收到的验证码"}).inputValidator({min: 1, onError: "请输入手机收到的验证码"}).ajaxValidator({
          type: "get",
          url: "<?= U('sms/id_code') ?>",
          dataType: "html",
          async: "false",
          success: function (data) {
            console.log(data);
            return data == "1"
          },
          buttons: $("#dosubmit"),
          onError: "验证码错误",
          onWait: "请稍候..."
        });
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


  <div class="register_main">
    <div class="container_1200">
      <div class="fill_50">
      </div>
      <div class="left_ad_container">
        <img src="/Public/images/login_ad_img.jpg" alt="">
      </div>
      <div class="right_form_container">
        <div class="register_left fl">
          <div class="register_form">
            <h2 class="login-h2">会员注册</h2>

            <form method="post" action="/index.php/Home/Member/register.html" id="myform">
              <div class="register_telephone register_tab">
                <div class="form-group regtype">
                  <input type="hidden" modelid="<?php echo ($modelid); ?>">
                  <a <?php if ($modelid == 1) echo 'class="current"' ?> href="<?php echo U('member/register',['type'=>1]);?>">展商</a>
                  <a <?php if ($modelid == 2) echo 'class="current"' ?>href="<?php echo U('member/register',['type'=>2]);?>">设计师</a>
                  <a <?php if ($modelid == 3) echo 'class="current"' ?>href="<?php echo U('member/register',['type'=>3]);?>">工厂</a>
                </div>
                <?php if ($modelid == 1 || $modelid == 3) { ?>
                  <div class="form-group"><input class="input_public" id="nickname" type="text" name="nickname" value="" placeholder="请输入公司名称"></div>
                <?php } ?>
                <div class="form-group"><input class="input_public" id="username" type="text" name="username" value="" placeholder="请输入用户名"></div>
                <?php if (C('USER_MOBILE_REGISTER')) { ?>
                  <div class="form-group email_reg">
                    <input class="input_public" type="text" id="mobile" name="mobile" value="" placeholder="请输入手机号">
                    <div id="mobile_send_div" style="display:none">验证码已发送到<span id="mobile_send"></span>&nbsp;&nbsp;<span id="edit_mobile" style="display:none"><a href="javascript:void();" onclick="edit_mobile()">修改号码</a></span>
                    </div>
                  </div>
                  <div class="form-group register_message">
                    <input class="input_public" name="mobile_verify" id="mobile_verify"type="text" placeholder="短信验证码"/><button onclick="get_verify()" type="button" class="hqyz" id="GetVerify">获取短信验证码</button>
                    <div style="position: absolute; left: 305px; top: 0; height: 20px; width: 280px; margin: 0px; padding: 0px; background: transparent;" id="mobile_verifyTip"></div>
                  </div>
                  <script>
                    var times = 120;
                    var isinerval;
                    function get_verify() {
  <?php if (C('CODE_ON')) { ?>
                        var session_code = $('#code').val();
                        if (session_code == '') {
                          alert('请输入验证码');
                          $('#code').focus();
                          return false;
                        }
                        var mobile = $("#mobile").val();
                        var partten = /^1[3-9]\d{9}$/;
                        if (!partten.test(mobile)) {
                          alert("请输入正确的手机号码");
                          $('#mobile').focus();
                          return false;
                        }

                        $.get("<?= U('Sms/verifycode') ?>", {mobile: mobile, session_code: session_code, random: Math.random()}, function (data) {
                          console.log(data);
                          if (data == "0") {
                            $("#mobile_send").html(mobile);
                            $("#mobile_div").css("display", "none");
                            $("#mobile_send_div").css("display", "");
                            times = 120;
                            $("#GetVerify").attr("disabled", true);
                            isinerval = setInterval("CountDown()", 1000);
                          } else if (data == "-1") {
                            alert("你今天获取验证码次数已达到上限");
                          }
                          else if (data == "-100") {
                            $('#code').val('');
                            alert("验证码已失效，请点击图片验证码获取新的验证码！");
                            $('#code').focus();
                          } else if (data == "-101") {
                            alert("验证码错误！");
                            $('#code').focus();
                          } else {
                            alert("短信发送失败");
                          }
                        });
  <?php } else { ?>
                        var mobile = $("#mobile").val();
                        var partten = /^1[3-9]\d{9}$/;
                        if (!partten.test(mobile)) {
                          alert("请输入正确的手机号码");
                          $('#mobile').focus();
                          return false;
                        }

                        $.get("<?= U('Sms/verifycode') ?>", {mobile: mobile, random: Math.random()}, function (data) {
                          console.log(data);
                          if (data == "0") {
                            $("#mobile_send").html(mobile);
                            $("#mobile").css("display", "none");
                            $("#mobile_send_div").css("display", "");
                            times = 120;

                            $("#GetVerify").attr("disabled", true);
                            isinerval = setInterval("CountDown()", 1000);
                          } else if (data == "-1") {
                            alert("你今天获取验证码次数已达到上限");
                          } else {
                            alert("短信发送失败");
                          }
                        });
  <?php } ?>
                    }
                    function CountDown() {
                      if (times < 1) {
                        $("#GetVerify").removeClass('disabled').html("获取短信验证码").attr("disabled", false);
                        $("#edit_mobile").show();
                        clearInterval(isinerval);
                        return;
                      }
                      $("#GetVerify").addClass('disabled').html(times + "秒后重新获取");
                      times--;
                    }
                    function edit_mobile() {
                      $("#mobile").show();
                      $("#mobile_send_div").css("display", "none");
                    }
                  </script>


                <?php } ?>
                <div class="form-group"><input class="input_public" type="text" id="email" name="email" value="" placeholder="请输入邮箱"></div>
                <div class="form-group"><input class="input_public" type="password" id="password" name="password" placeholder="请输入密码"></div>
                <div class="form-group"><input class="input_public" type="password" name="repassword" id="repassword" placeholder="请再次输入密码"></div>

                <div class="form-group register_tijiao">
                  <input class="form-btn" name="dosubmit" id="dosubmit" type="submit" value="提交">
                </div>
              </div>
            </form>

          </div>
        </div>
      </div>
      <div class="clear"></div>
    </div>
  </div>



  <script type="text/javascript">
    $(document)
            .ajaxStart(function () {
              $("button:submit").addClass("log-in").attr("disabled", true);
            })
            .ajaxStop(function () {
              $("button:submit").removeClass("log-in").attr("disabled", false);
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