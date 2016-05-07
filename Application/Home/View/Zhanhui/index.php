<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" >
    <meta keywords="<?= C('SEO_KEYWORDS'); ?>">
    <meta description="<?= C('SEO_DESCRIPTION'); ?>">
    <title>展馆信息-<?= C('SEO_TITLE'); ?></title>
    <link href="__PUBLIC__/css/CSS.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="__PUBLIC__/js/jquery.min.js"></script>
  </head>

  <body>
  <include file="index:_head" />
  <div class="hz_sj_js">
    <dl>
      <dt>地区:</dt>
      <dd class="current"><a href="">不限</a></dd>
      <?php foreach($areas as $area){ ?>
      <dd><a href="<?= U('Zhanguan/index',array('areaid'=>$area['id'])) ?>"><?= $area['name'] ?></a></dd>
      <?php } ?>
    </div>
  </div>
  <div class="zh_hy_box">
    <div class="zh_hy_l">
      <div class="zh_hy_s">
        <p>展馆列表</p>
      </div>
      <div class="zh_hy_ll">
        <img src="__PUBLIC__/images/3232.jpg">
        <div class="zh_hy_lr">
          <div class="zh_hy_lr_a">
            <a href="">2016第八届中国（上海）无损检测应用设备展览会暨发展论坛</a>
          </div>
          <p>举办时间：2016-3-23-6-23</p>
          <p class="zh_hy_te">地址：郑州市中原区互助路</p>
          <p class="zh_hy_te1">举办展馆： 上海新国际博览中心(SNIEC)</p>
          <p class="zh_hy_te2"><span>5622</span>人查看了该展会</p>
          <div class="zh_hy_05"><a href="">查看详情</a></div>
        </div>
      </div>
      <div class="zh_hy_ll">
        <img src="__PUBLIC__/images/3232.jpg">
        <div class="zh_hy_lr">
          <div class="zh_hy_lr_a">
            <a href="">2016第八届中国（上海）无损检测应用设备展览会暨发展论坛</a>
          </div>
          <p>举办时间：2016-3-23-6-23</p>
          <p class="zh_hy_te">地址：郑州市中原区互助路</p>
          <p class="zh_hy_te1">举办展馆： 上海新国际博览中心(SNIEC)</p>
          <p class="zh_hy_te2"><span>5622</span>人查看了该展会</p>
          <div class="zh_hy_05"><a href="">查看详情</a></div>
        </div>
      </div>
      <div class="zh_hy_ll">
        <img src="__PUBLIC__/images/3232.jpg">
        <div class="zh_hy_lr">
          <div class="zh_hy_lr_a">
            <a href="">2016第八届中国（上海）无损检测应用设备展览会暨发展论坛</a>
          </div>
          <p>举办时间：2016-3-23-6-23</p>
          <p class="zh_hy_te">地址：郑州市中原区互助路</p>
          <p class="zh_hy_te1">举办展馆： 上海新国际博览中心(SNIEC)</p>
          <p class="zh_hy_te2"><span>5622</span>人查看了该展会</p>
          <div class="zh_hy_05"><a href="">查看详情</a></div>
        </div>
      </div>
      <div class="zh_hy_ll">
        <img src="__PUBLIC__/images/3232.jpg">
        <div class="zh_hy_lr">
          <div class="zh_hy_lr_a">
            <a href="">2016第八届中国（上海）无损检测应用设备展览会暨发展论坛</a>
          </div>
          <p>举办时间：2016-3-23-6-23</p>
          <p class="zh_hy_te">地址：郑州市中原区互助路</p>
          <p class="zh_hy_te1">举办展馆： 上海新国际博览中心(SNIEC)</p>
          <p class="zh_hy_te2"><span>5622</span>人查看了该展会</p>
          <div class="zh_hy_05"><a href="">查看详情</a></div>
        </div>
      </div>
      <div class="zh_hy_ll">
        <img src="__PUBLIC__/images/3232.jpg">
        <div class="zh_hy_lr">
          <div class="zh_hy_lr_a">
            <a href="">2016第八届中国（上海）无损检测应用设备展览会暨发展论坛</a>
          </div>
          <p>举办时间：2016-3-23-6-23</p>
          <p class="zh_hy_te">地址：郑州市中原区互助路</p>
          <p class="zh_hy_te1">举办展馆： 上海新国际博览中心(SNIEC)</p>
          <p class="zh_hy_te2"><span>5622</span>人查看了该展会</p>
          <div class="zh_hy_05"><a href="">查看详情</a></div>
        </div>
      </div>
      <div class="zh_yema">
        <a class="zh_yema_te" href="">1</a>
        <a href="">2</a>
        <a href="">3</a>
        <a href="">下一页</a>
      </div>
    </div>
    <div class="zh_hy_r">
      <div class="zh_hy_s">
        <p>展馆排行榜</p>
      </div>
      <div class="zh_hy_ph">
        <img src="__PUBLIC__/images/666.jpg">
        <a href="">大华伟业有限公司花样展会</a>
        <img src="__PUBLIC__/images/666.jpg">
        <a href="">大华伟业有限公司花样展会</a>
        <img src="__PUBLIC__/images/666.jpg">
        <a href="">大华伟业有限公司花样展会</a>
        <img src="__PUBLIC__/images/666.jpg">
        <a href="">大华伟业有限公司花样扎哈展会</a>
      </div>
    </div>
  </div>

  <include file="index:_foot" />
</body>
</html>
