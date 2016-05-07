<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" >
    <meta keywords="<?= C('SEO_KEYWORDS'); ?>">
    <meta description="<?= C('SEO_DESCRIPTION'); ?>">
    <title>项目详情-<?= C('SEO_TITLE'); ?></title>
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
            <a class="current" href="#">项目详情</a>
            <?php if ($des_id) { ?>
              <a href="<?= U('Designer/design', ['act' => 'edit', 'id' => $des_id]) ?>">我的方案</a>
            <?php } else { ?>
              <a href="<?= U('Designer/design', ['act' => 'add', 'pid' => $id]) ?>">我要投稿</a>
            <?php } ?>
          </div>
        </div>
        <div class="m_body">
          <p style="margin-bottom: 10px;font-size:24px;width:820px;"> <?php if (!$des_id) { ?><a class="btn-yellow fr" href="<?= U('Designer/design', ['act' => 'add', 'pid' => $id]) ?>">我要投稿</a><?php }?><span class="red">[设计需求]</span> <?= $info['company'] ?></p>
          <include file="member:_projectInfo" />
        </div>
      </div>
      <div class="clear"></div>
    </div>

  </div>
  <include file="index:_foot" />
</body>
</html>
