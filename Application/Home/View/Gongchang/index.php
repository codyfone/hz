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
      <dd class="current"><a href="">不限</a></dd>
      <?php foreach ($areas as $area) { ?>
        <dd><a href="<?= U('zhanguan/index', array('areaid' => $area['id'])) ?>"><?= $area['name'] ?></a></dd>
      <?php } ?>
    </dl>
    <dl>
      <dt>等级:</dt>
      <dd class="current"><a href="">不限</a></dd>
      <?php foreach ($areas as $area) { ?>
        <dd><a href="<?= U('zhanguan/index', array('areaid' => $area['id'])) ?>"><?= $area['name'] ?></a></dd>
      <?php } ?>
    </dl>
  </div>
  <div class="zh_sj_jian">
    <div class="zh_sj_jl">
      <p>为您找到了<span>5362</span>个厂商</p>
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
        <a href=""><img src="__PUBLIC__/imagessj_03.png"></a>
      </div>
    </div>
  </div>
  <div class="clear"></div>
  <div class="zh_csbox">
    <div class="zh_cs_l">
      <div class="zh_cs_lt"><img src="__PUBLIC__/imagescs_01.jpg"></div>
      <div class="zh_cs_lw">
        <p>大华伟业展会设计</p>
        <div class="zh_cs_bg">
          <div class="zh_cs_bgs">
            <span>等级</span>
            <span>案例</span>
            <span>评论</span>
            <span class="zh_cs_te9">城市</span>
          </div>
          <div class="zh_cs_bgs zh_cs_bg_te1">
            <span>五星</span>
            <span>20个</span>
            <span>5个</span>
            <span class="zh_cs_te9">郑州</span>
          </div>
        </div>
        <div class="zh_cs_bz"><img src="__PUBLIC__/imagescs_03.png"></div>
      </div>
      <div class="zh_cs_pf">
        <p>口碑值:<span>86</span></p>
        <a>好评率：100%</a>
      </div>
    </div>
    <div class="zh_cs_yy">
      <img src="__PUBLIC__/imagescs_05.png">
      <a href="">立即预定</a>
    </div> 
  </div>
  <div class="zh_csbox">
    <div class="zh_cs_l">
      <div class="zh_cs_lt"><img src="__PUBLIC__/imagescs_01.jpg"></div>
      <div class="zh_cs_lw">
        <p>大华伟业展会设计</p>
        <div class="zh_cs_bg">
          <div class="zh_cs_bgs">
            <span>等级</span>
            <span>案例</span>
            <span>评论</span>
            <span class="zh_cs_te9">城市</span>
          </div>
          <div class="zh_cs_bgs zh_cs_bg_te1">
            <span>五星</span>
            <span>20个</span>
            <span>5个</span>
            <span class="zh_cs_te9">郑州</span>
          </div>
        </div>
        <div class="zh_cs_bz"><img src="__PUBLIC__/imagescs_03.png"></div>
      </div>
      <div class="zh_cs_pf">
        <p>口碑值:<span>86</span></p>
        <a>好评率：100%</a>
      </div>
    </div>
    <div class="zh_cs_yy">
      <img src="__PUBLIC__/imagescs_05.png">
      <a href="">立即预定</a>
    </div> 
  </div>
  <div class="zh_csbox">
    <div class="zh_cs_l">
      <div class="zh_cs_lt"><img src="__PUBLIC__/imagescs_01.jpg"></div>
      <div class="zh_cs_lw">
        <p>大华伟业展会设计</p>
        <div class="zh_cs_bg">
          <div class="zh_cs_bgs">
            <span>等级</span>
            <span>案例</span>
            <span>评论</span>
            <span class="zh_cs_te9">城市</span>
          </div>
          <div class="zh_cs_bgs zh_cs_bg_te1">
            <span>五星</span>
            <span>20个</span>
            <span>5个</span>
            <span class="zh_cs_te9">郑州</span>
          </div>
        </div>
        <div class="zh_cs_bz"><img src="__PUBLIC__/imagescs_03.png"></div>
      </div>
      <div class="zh_cs_pf">
        <p>口碑值:<span>86</span></p>
        <a>好评率：100%</a>
      </div>
    </div>
    <div class="zh_cs_yy">
      <img src="__PUBLIC__/imagescs_05.png">
      <a href="">立即预定</a>
    </div> 
  </div>
  <div class="zh_csbox">
    <div class="zh_cs_l">
      <div class="zh_cs_lt"><img src="__PUBLIC__/imagescs_01.jpg"></div>
      <div class="zh_cs_lw">
        <p>大华伟业展会设计</p>
        <div class="zh_cs_bg">
          <div class="zh_cs_bgs">
            <span>等级</span>
            <span>案例</span>
            <span>评论</span>
            <span class="zh_cs_te9">城市</span>
          </div>
          <div class="zh_cs_bgs zh_cs_bg_te1">
            <span>五星</span>
            <span>20个</span>
            <span>5个</span>
            <span class="zh_cs_te9">郑州</span>
          </div>
        </div>
        <div class="zh_cs_bz"><img src="__PUBLIC__/imagescs_03.png"></div>
      </div>
      <div class="zh_cs_pf">
        <p>口碑值:<span>86</span></p>
        <a>好评率：100%</a>
      </div>
    </div>
    <div class="zh_cs_yy">
      <img src="__PUBLIC__/imagescs_05.png">
      <a href="">立即预定</a>
    </div> 
  </div>
  <div class="zh_yema">
    <a class="zh_yema_te" href="">1</a>
    <a href="">2</a>
    <a href="">3</a>
    <a href="">下一页</a>
  </div>
  <include file="Index:_foot" />
</body>
</html>
