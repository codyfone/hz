<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" >
<meta keywords="<?= C('SEO_KEYWORDS'); ?>">
<meta description="<?= C('SEO_DESCRIPTION'); ?>">
<title><?= C('SEO_TITLE'); ?></title>
<link href="__PUBLIC__/css/CSS.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="__PUBLIC__/js/jquery.min.js"></script>
</head>
<body>
<include file="index:_head" />

<div class="fill_20 clear"></div>
<div class="container_1200">

<div class="cooperation_left">
  <div class="bar"><p>{$this_cates['title']}</p><span></span><img src="__PUBLIC__/images/bar_icon.png" alt=""></div>
  <div class="list">
    <?php foreach ($child_cates as $v) { ?>
      <a href="{:U('Article/index',array('cid'=>$v['id']))}"><span>{$v['title']}</span><em>&gt;</em></a>
    <?php } ?>

  </div>
</div>
<div class="cooperation_right">
  <div class="cooperation_right_title">
    
  </div>
  <ul class="cooperation_right_list">
  <?php foreach ($articles as $v) { ?>
    <li>
      <a href="{:U('Article/view',array('id'=>$v['id']))}"><span class='left'>{$v['title']}</span></a>
      <span class='right'>{$v['create_time']}</span>
      <div class="clear"></div>
    </li>
  <?php } ?>
    
  </ul>
</div>


</div>
<div class="fill_50 clear"></div>

<include file="index:_foot" />
</body>
</html>
