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
    
    <script type="text/javascript" src="__PUBLIC__/js/formValidator.min.js"></script>
    <script type="text/javascript" src="__PUBLIC__/js/formValidatorRegex.js"></script>
    <script>
      $(function () {
        $.formValidator.initConfig({formID: "form1", theme: 'ArrowSolidBox', mode: 'AutoTip', onError: function (msg) {
            alert(msg)
          }, inIframe: true});

        $("#mobile").formValidator({onShow: "请输入手机号", onFocus: "手机号输入错误", onCorrect: "手机号输入正确"}).inputValidator({min: 11, max: 11, onError: "手机号应该为11位数字"});
        
        $("#alipay").formValidator({onShow: "默认提现的支付宝账号", onFocus: "默认提现的支付宝账号"});
      });
      

    </script>
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
        <div class="m_head"><div class="m_tab">
          <a class="current" href="#">基本信息</a>
          <a href="{:U('factory/editPasswd')}">修改密码</a>
          <a href="{:U('factory/avatar')}">修改头像</a>
          </div></div>
        <div class="m_body">
          <form id="form1" method="post" action="">
            <table class="m_table_no_border">
              <tbody>
                <tr><th align="left">用户名：</th><td><b class="yellow" align="left">{$info['username']}</b></td></tr>
                <tr>
                  <th align="left"><i class="red">*</i> 邮箱：</th>
                  <td align="left">{$info['email']}
                    <span style="margin-left:20px;">
                      <b class="red">未验证</b>&nbsp;&nbsp;&nbsp;<a href="http://www.16-expo.com/member/member/verify-mail.html" class="btn-yellow">立即验证</a>
                    </span>
                  </td>
                </tr>
                <tr><th align="left">手机：</th><td align="left">
                    <input name="mobile" id="mobile" value="{$info['mobile']}" class="input_public" type="text" placeholder="请输入手机号">            
                  </td>
                </tr>

                <tr><th align="left">支付宝：</th><td align="left"><input name="alipay" id='alipay' class="input_public" value="{$info['alipay']}" type="text"></td></tr>
                 
                <tr><th></th><td align="left"><input value="提交" class="dosubmit" type="submit"></td></tr>
              </tbody></table>
          </form>  
        </div>
      </div>
      <div class="clear"></div>
    </div>

  </div>

  <include file="index:_foot" />
</body>
</html>
