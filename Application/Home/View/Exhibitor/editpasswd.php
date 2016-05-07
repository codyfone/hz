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
    <script type="text/javascript" src="__PUBLIC__/js/jquery.ld.js"></script>
    <script type="text/javascript" src="__PUBLIC__/js/formValidator.min.js"></script>
    <script type="text/javascript" src="__PUBLIC__/js/formValidatorRegex.js"></script>
    <script>
      $(function () {
        $.formValidator.initConfig({formID: "form1", theme: 'ArrowSolidBox', mode: 'AutoTip', onError: function (msg) {
            alert(msg)
          }, inIframe: true});
        $("#oldPassword").formValidator({onShow: "请输入原密码", onFocus: "原密码不能为空", onCorrect: "密码合法"}).inputValidator({min: 1, onError: "原密码不能为空,请确认"});
        $("#newPassword").formValidator({onShow: "请输入新密码", onFocus: "新密码不能为空", onCorrect: "密码合法"}).inputValidator({min: 1, onError: "新密码不能为空,请确认"});
        $("#rePassword").formValidator({onShow: "请输入重复密码", onFocus: "两次密码必须一致哦", onCorrect: "密码一致"}).inputValidator({min: 1, onError: "重复密码不能为空,请确认"}).compareValidator({desid: "password", operateor: "=", onError: "2次密码不一致,请确认"});

      });
      //三级联动地区
      $(function () {
        var $ld5 = $(".pc-select-areaid");
        $ld5.ld({ajaxOptions: {"url": "<?= U('Citys/list_json') ?>"}, defaultParentId: 0, style: {"width": 120}})
        var ld5_api = $ld5.ld("api");
        ld5_api.selected();
        $ld5.bind("change", onchange);
        function onchange(e) {
          var $target = $(e.target);
          var index = $ld5.index($target);
          $("#areaid-4").remove();
          $("#areaid").val($ld5.eq(index).show().val());
          index++;
        }
      })

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
          <a href="{:U('Exhibitor/baseinfo')}">基本信息</a>
          <a class="current" href="@">修改密码</a>
          <a href="{:U('Exhibitor/avatar')}">修改头像</a>
          </div></div>
        <div class="m_body">
          <form id="form1" method="post" action="__SELF">
            <table class="m_table_no_border">
              <tbody>
                <tr><th align="left">原密码：</th><td><input type="password" id="oldPassword"  class="input_public" name="old"></td></tr>
                <tr><th align="left">新密码：</th><td><input type="password" id="newPassword"  class="input_public" name="password"></td></tr>
                <tr><th align="left">确认密码：</th><td><input type="password" id="rePassword"  class="input_public" name="repassword"></td></tr>
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
