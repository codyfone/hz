<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" >
    <meta keywords="<?= C('SEO_KEYWORDS'); ?>">
    <meta description="<?= C('SEO_DESCRIPTION'); ?>">
    <title><?= C('SEO_TITLE'); ?></title>
    <link href="__PUBLIC__/css/CSS.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="__PUBLIC__/js/jquery.min.js"></script>    
    <script type="text/javascript" src="__PUBLIC__/js/jquery.SuperSlide.2.1.1.source.js"></script>

  </head>

  <body>
  <include file="Index:_head" />
  <div class="fill_20 clear"></div>
    <div class="container_1200">
      <div class="case_page_left">
        <?php foreach ($images as $key => $value) { ?>
          <img src="{$value['src']}">
        <?php } ?>
       <div class="clear"></div>
      </div>
      <div class="case_page_right">
        <div class="container">
          <h2>{$case['title']}</h2>
          <div class='fill_10'></div>
          <p>发布时间：{$case['addtime']}</p>
          <p>浏览量：{$case['hits']+1}</p>
        </div>
      </div>

    </div>
  <div class="fill_50 clear"></div>
  <include file="Index:_foot" />
</body>
</html>
<script type="text/javascript">
  $(document).scroll(function(){
    var sc_top = $(document).scrollTop();
    if($(document).scrollTop()>=160){
      $('.case_page_right').css({'position':'relative','top':sc_top-160,'right':'0px'});
    }else{
      $('.case_page_right').css({'position':'relative','top':0,'right':'0px'});
    }
  });
</script>

