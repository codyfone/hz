<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" >
    <meta keywords="<?= C('SEO_KEYWORDS'); ?>">
    <meta description="<?= C('SEO_DESCRIPTION'); ?>">
    <title>基本信息修改-<?= C('SEO_TITLE'); ?></title>
    <link href="/Public/css/CSS.css" rel="stylesheet" type="text/css">
    <link href="/Public/css/user.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="/Public/js/jquery.min.js"></script>
    <script type="text/javascript" src="/Public/js/jquery.ld.js"></script>
    <script type="text/javascript" src="/Public/js/formValidator.min.js"></script>
    <script type="text/javascript" src="/Public/js/formValidatorRegex.js"></script>
    <script>
      $(function () {
        $.formValidator.initConfig({formID: "form1", theme: 'ArrowSolidBox', mode: 'AutoTip', onError: function (msg) {
            alert(msg)
          }, inIframe: true});

        $("#nickname").formValidator({onShow: "请输入昵称", onFocus: "昵称应该为2-20位之间"}).inputValidator({min: 2, max: 20, onError: "昵称应该为2-20位之间"}).regexValidator({regExp: "ps_nickname", dataType: "enum", onError: "昵称格式错误"}).ajaxValidator({
          type: "get",
          url: "",
          data: "<?= U('Member/checkDenyNickname') ?>",
          dataType: "html",
          async: false,
          success: function (data) {
            return data == "1";
          },
          buttons: $("#dosubmit"),
          onError: "名称已经注册",
          onWait: "请稍候..."
        });
        $("#mobile").formValidator({onShow: "请输入手机号", onFocus: "手机号输入错误", onCorrect: "手机号输入正确"}).inputValidator({min: 11, max: 11, onError: "手机号应该为11位数字"}).regexValidator({regExp: "mobile", datatype: "enum", onError: "手机号无效"}).ajaxValidator({
          type: "get",
          url: "",
          data: "<?= U('Member/checkDenyMobile') ?>",
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
        <div class="m_head"><div class="m_tab">
          <a class="current" href="#">基本信息</a>
          <a href="<?php echo U('designer/editPasswd');?>">修改密码</a>
          <a href="<?php echo U('designer/avatar');?>">修改头像</a>
          </div></div>
        <div class="m_body">
          <form id="form1" method="post" action="">
            <table class="m_table_no_border">
              <tbody>
                <tr><th align="left">用户名：</th><td><b class="yellow" align="left">weiran</b></td></tr>
                <tr>
                  <th align="left"><i class="red">*</i> 邮箱：</th>
                  <td align="left">249053884@qq.com 
                    <span style="margin-left:20px;">
                      <b class="red">未验证</b>&nbsp;&nbsp;&nbsp;<a href="http://www.16-expo.com/member/member/verify-mail.html" class="btn-yellow">立即验证</a>
                    </span>
                  </td>
                </tr>
                <tr><th align="left">手机：</th><td align="left">
                    <input name="mobile" id="mobile" value="<?php echo ($info['mobile']); ?>" class="input_public" type="text" placeholder="请输入手机号">            
                  </td>
                </tr>

                <tr><th align="left">支付宝：</th><td align="left"><input name="alipay" id='alipay' class="input_public" value="<?php echo ($info['alipay']); ?>" type="text"></td></tr>
                <tr><th align="left">姓名：</th><td align="left"><input name="nickname" id='nickname' class="input_public" value="<?php echo ($info['nickname']); ?>" type="text"></td></tr>
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