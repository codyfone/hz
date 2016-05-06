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
          <div class="m_tab">
          <a href="{:U('exhibitor/baseinfo')}">基本信息</a>
          <a href="{:U('exhibitor/editPasswd')}">修改密码</a>
          <a class="current" href="#">修改头像</a>
          </div>
        </div>
        <div class="m_body">

          <script language="javascript" type="text/javascript" src="__PUBLIC__/js/swfobject.js"></script>
          <script type="text/javascript">
            var flashvars = {
              'upurl': "<?= U('Member/uploadavatar')?>"
            };
            var params = {
              'align': 'middle',
              'play': 'true',
              'loop': 'false',
              'scale': 'showall',
              'wmode': 'window',
              'devicefont': 'true',
              'id': 'Main',
              'bgcolor': '#ffffff',
              'name': 'Main',
              'allowscriptaccess': 'always'
            };
            var attributes = {
            };
            swfobject.embedSWF("__PUBLIC__/images/main.swf", "myContent", "490", "434", "9.0.0", "{__PUBLIC__/images/expressInstall.swf", flashvars, params, attributes);

            function return_avatar(data) {
              if (data == 1) {
                window.location.reload();
              } else {
                alert('failure');
              }
            }
          </script>
        <div class="avatar-auto">
          <div id="myContent"> 
            <p>Alternative content</p> 
          </div>
        </div>
          <ul class="col-avatar" id="avatarlist">
            <?php foreach ($avatars as $k => $v) { ?>
              <li>
                <img src="{$v}" height="{$k}" width="{$k}" onerror="this.src='__PUBLIC__/images/member/nophoto.jpg'"><br />
                {$k} x {$k} 像素
              </li>
            <?php } ?>
          </ul>
        </div>
      <div class="clear"></div>
      </div>
      <div class="clear"></div>
    </div>

  </div>

  <include file="index:_foot" />
</body>
</html>
