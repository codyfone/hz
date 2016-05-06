<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" >
    <meta keywords="<?= C('SEO_KEYWORDS'); ?>">
    <meta description="<?= C('SEO_DESCRIPTION'); ?>">
    <title>发票设置-<?= C('SEO_TITLE'); ?></title>
    <link href="__PUBLIC__/css/CSS.css" rel="stylesheet" type="text/css">
    <link href="__PUBLIC__/css/user.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="__PUBLIC__/js/jquery.min.js"></script>
    <script type="text/javascript" src="__PUBLIC__/js/formValidator.min.js"></script>
    <script type="text/javascript" src="__PUBLIC__/js/formValidatorRegex.js"></script>
    <script type="text/javascript" src="__ITEM__/__JS__/ueditor/ueditor.config.js"></script>
    <script type="text/javascript" src="__ITEM__/__JS__/ueditor/ueditor.all.js"></script>
    <script type="text/javascript" src="__ITEM__/__JS__/ueditor/lang/zh-cn/zh-cn.js"></script>
    <script>
      $(function () {
        $.formValidator.initConfig({formID: "form1", theme: 'ArrowSolidBox', mode: 'AutoTip', onError: function (msg) {
            alert(msg)
          }, inIframe: true});

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
        <div class="m_head">
          <h3>发票信息</h3>
        </div>
        <div class="m_body">
          <form id="form1" method="post" action="">
            <table class="m_table_no_border">
              <tbody>
                <tr><th align="left">发票抬头：</th><td><b class="yellow">{$info['company']}</b></td></tr>
                <tr><th align="left">发票类型：</th><td align="left"><label><input type="radio" name="itype" value="1">增值税普通发票</label>&nbsp;&nbsp;&nbsp;&nbsp;<label><input type="radio" name="itype" value="0">增值税专用发票</label></td></tr>
                <tr><th align="left">税务登记证号：</th><td align="left"><input name="taxcer_no" id='taxcer_no' class="input_public" value="{$info['taxcer_no']}" type="text" size="50"></td></tr>
                <tr><th align="left">基本开户银行名称：</th><td align="left"><input name="bank" id='bank' class="input_public" value="{$info['bank']}" type="text" size="50"></td></tr>
                <tr><th align="left">基本开户账号：</th><td align="left"><input name="account_no" id='account_no' class="input_public" value="{$info['account_no']}" type="text" size="50"></td></tr>
                <tr><th align="left">注册场所地址：</th><td align="left"><input name="register_addr" id='register_addr' class="input_public" value="{$info['register_addr']}" type="text" size="50"></td></tr>
                <tr><th align="left">注册固定电话：</th><td align="left"><input name="telephone" id='telephone' class="input_public" value="{$info['telephone']}" type="text" size="50"></td></tr>
                <tr><th align="left">营业执照复印件：</th><td align="left"><input name="licence_copy" id='licence_copy' class="input_public" value="{$info['licence_copy']}" type="text" size="50"></td></tr>
                <tr><th align="left">税务登记复印件：</th><td align="left"><input name="taxcer_copy" id='taxcer_copy' class="input_public" value="{$info['taxcer_copy']}" type="text" size="50"></td></tr>
                <tr><th align="left">一般纳税人资格认证复印件：</th><td align="left"><input name="taxpayer_copy" id='taxpayer_copy' class="input_public" value="{$info['taxpayer_copy']}" type="text" size="50"></td></tr>

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
