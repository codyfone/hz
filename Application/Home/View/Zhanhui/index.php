<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" >
    <meta keywords="<?= C('SEO_KEYWORDS'); ?>">
    <meta description="<?= C('SEO_DESCRIPTION'); ?>">
    <title>展会信息-<?= C('SEO_TITLE'); ?></title>
    <link href="__PUBLIC__/css/CSS.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="__PUBLIC__/js/jquery.min.js"></script>
  </head>

  <body>
  <include file="index:_head" />
  <div class="hz_sj_js">
    <dl>
      <dt>地区:</dt>
      <dd <?php if(!I('get.areaid')){echo 'class="current"' ;} ?>><a href="<?= U('zhanhui/index') ?>">不限</a></dd>
      <?php foreach($areas as $area){ ?>
      <dd  <?php if(I('get.areaid')==$area['id']){echo 'class="current"' ;} ?> ><a href="<?= U('zhanhui/index',array('areaid'=>$area['id'])) ?>"><?= $area['name'] ?></a></dd>
      <?php } ?>
    </div>
  </div>
  <div class="zh_hy_box">
    <div class="zh_hy_l">
      <div class="zh_hy_s">
        <p>展会列表</p>
      </div>
      <?php foreach ( $zhanhuis as $k => $v) { ?>
      <div class="zh_hy_ll">
        <img src="{$v['thumb']}">
        <div class="zh_hy_lr">
          <div class="zh_hy_lr_a">
              <a href="{:U('Zhanhui/view',array('id'=>$v['id']))}">{$v['name']}</a>
          </div>
          <p>展馆地址：{$v['addr']}</p>
          <p class="zh_hy_te">举办时间：{$v['startdate']}&nbsp;至&nbsp;{$v['enddate']}</p>
          <p class="zh_hy_te1">举办展馆：{$v['pavilion_name']}</p>
          <p class="zh_hy_te2"><span>{$v['hits']}</span>人查看了该展会</p>
          <div class="zh_hy_05"><a href="{:U('Zhanhui/view',array('id'=>$v['id']))}">查看详情</a></div>
        </div>
      </div>   
      <?php } ?>
      <div class="zh_yema">
       {$page}
      </div>
    </div>
    <div class="zh_hy_r">
      <div class="zh_hy_s">
        <p>展会排行榜</p>
      </div>
      <div class="zh_hy_ph">
        <?php foreach ( $re_zhanhuis as $k => $v) { ?>
            <img src="{$v['thumb']}">
            <a href="{:U('Zhanguan/view',array('id'=>$v['id']))}">{$v['name']}</a>
        <?php } ?>  
      </div>
    </div>
  </div>

  <include file="index:_foot" />
</body>
</html>
