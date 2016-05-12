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
  <include file="Index:_head" />
  <div class="hz_sj_js">
     <dl>
      <dt>地区:</dt>
      <dd  <?php if(!I('get.areaid')){echo 'class="current"' ;} ?> ><a href="<?= U('Gongchang/index') ?>">不限</a></dd>
      <?php foreach($areas as $area){ ?>
      <dd   <?php if(I('get.areaid')==$area['id']){echo 'class="current"' ;} ?> ><a href="<?= U('Gongchang/index',array('areaid'=>$area['id'])) ?>"><?= $area['name'] ?></a></dd>
      <?php } ?>
    </dl>
  </div>
  <div class="zh_sj_jian">
    <div class="zh_sj_jl">
      <p>为您找到了<span>{$count}</span>个厂商</p>
    </div>
    <div class="zh_sj_jr">
      <div class="zh_sj_jrl">
        <a class="zh_sj_te2" href="">默认排序</a>
        <a href="">最新发布</a>
        <a href="">信誉</a>
        <a href="">评价</a>
        <a class="zh_sj_te3" href="">案例</a>
      </div>
      <div class="zh_sj_jrr">
        <a href=""><img src="__PUBLIC__/images/sj_03.png"></a>
      </div>
    </div>
  </div>
  <div class="clear"></div>
  <?php foreach ( $factorys as $k => $v) { ?>
  <div class="zh_csbox">
    <div class="zh_cs_l">
      <div class="zh_cs_lt"><img src="<?php echo json_decode('['.str_replace("'", '"', $v['company_images']).']',true)[0]['src'] ?>"></div>
      <div class="zh_cs_lw">
        <p>{$v['name']}</p>
        <div class="zh_cs_bg">
          <div class="zh_cs_bgs">
            <span>等级</span>
            <span>案例</span>
            <span>评论</span>
            <span class="zh_cs_te9">城市</span>
          </div>
          <div class="zh_cs_bgs zh_cs_bg_te1">
            <span>五星</span>
            <span>{$v['case_num']}个</span>
            <span>5个</span>
            <span class="zh_cs_te9">{$v['city']}</span>
          </div>
        </div>
        <div class="zh_cs_bz"><img src="__PUBLIC__/images/cs_03.png"></div>
      </div>
      <div class="zh_cs_pf">
        <p>口碑值:<span>86</span></p>
        <a>好评率：100%</a>
      </div>
    </div>
    <div class="zh_cs_yy">
      <img src="__PUBLIC__/images/cs_05.png">
      <a href="{:U('Gongchang/view',array('userid'=>$v['userid']))}">查看详情</a>
    </div> 
  </div>
  <?php } ?>  

  <div class="zh_yema">
    {$page}
  </div>
  <include file="Index:_foot" />
</body>
</html>
