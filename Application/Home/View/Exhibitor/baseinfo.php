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

        $("#nickname").formValidator({onShow: "请输入昵称", onFocus: "昵称应该为2-20位之间"}).inputValidator({min: 2, max: 20, onError: "昵称应该为2-20位之间"}).regexValidator({regExp: "ps_nickname", dataType: "enum", onError: "昵称格式错误"}).ajaxValidator({
          type: "get",
          url: "<?= U('Member/checkDenyNickname') ?>",
          data: "",
          dataType: "html",
          async: false,
          success: function (data) {
            return data == "1";
          },
          buttons: $("#dosubmit"),
          onError: "名称已经注册",
          onWait: "请稍候..."
        });
        $("#mobile").formValidator({onShow: "请输入手机号", onFocus: "手机号输入错误", onCorrect: "手机号输入正确"}).inputValidator({min: 11, max: 11, onError: "手机号应该为11位数字"}).regexValidator({regExp: "mobile", dataType: "enum", onError: "手机号无效"}).ajaxValidator({
          type: "get",
          url: "<?= U('Member/checkDenyMobile') ?>",
          data: "",
          dataType: "html",
          async: false,
          success: function (data) {
            return data == "1";
          },
          buttons: $("#dosubmit"),
          onError: "禁止注册或手机号已被注册",
          onwait: "请稍候..."
        });
        $("#alipay").formValidator({onShow: "默认提现的支付宝账号", onFocus: "默认提现的支付宝账号"});
      });
      //三级联动地区
      $(function () {
        var $ld5 = $(".pc-select-areaid");
        $ld5.ld({ajaxOptions: {"url": "<?= U('citys/list_json') ?>"}, defaultParentId: 0, style: {"width": 120}})
        var ld5_api = $ld5.ld("api");
        ld5_api.selected({$area});
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
            <a class="current" href="#">基本信息</a>
            <a href="{:U('Exhibitor/editPasswd')}">修改密码</a>
            <a href="{:U('Exhibitor/avatar')}">修改头像</a>
          </div></div>
        <div class="m_body">
          <form id="form1" method="post" action="">
            <table class="m_table_no_border">
              <tbody>
                <tr><th align="left">用户名：</th><td><b class="yellow" align="left">{$info['username']}</b></td></tr>
                <tr><th align="left">公司名称：</th><td align="left">{$info['nickname']}</td></tr>

                <tr>
                  <th align="left"><i class="red">*</i> 邮箱：</th>
                  <td align="left">249053884@qq.com 
                    <span style="margin-left:20px;">
                      <b class="red">未验证</b>&nbsp;&nbsp;&nbsp;<a href="#" class="btn-yellow">立即验证</a>
                    </span>
                  </td>
                </tr>
                <tr><th align="left">手机：</th><td align="left">
                    <input name="mobile" id="mobile" value="{$info['mobile']}" class="input_public" type="text" placeholder="请输入手机号">            
                  </td>
                </tr>

                <tr><th align="left">支付宝：</th><td align="left"><input name="alipay" id='alipay' class="input_public" value="{$info['alipay']}" type="text"></td></tr>
                <tr><th align="left">地区：</th>
                  <td align="left">
                    <input type="hidden" name="areaid"  id="areaid" value="{info['areaid']}"><select class="input_public pc-select-areaid" name="areaid-1" id="areaid-1" width="100"><option value="">请选择菜单</option></select> <select class="input_public pc-select-areaid" name="areaid-2" id="areaid-2" width="100" style="display:none"><option value="">请选择菜单</option></select> <select class="input_public pc-select-areaid" name="areaid-3" id="areaid-3" width="100" style="display:none"><option value="">请选择菜单</option></select>


                  </td></tr>  
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
