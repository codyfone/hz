<?php
    $about_us = M('Article')->where('cid=6')->find();
    $service = M('Article')->where('cid=8')->select();
    //var_dump($service);
?>
<div class="clear"></div>
<div class="hz_foot">
  <div class="hz_footbox">
    <div class="hz_footl">
      <div class="hz_footls">
        <span>ABOUT US</span>
        <p>关于我们</p>
      </div>
      <div class="hz_footlx">
          <p><?php echo mb_substr($about_us['content'],0,69,'utf-8') ?></p>
        <a href="{:U('Article/view',array('id'=>$about_us['id']))}"><img src="__PUBLIC__/images/foot_03.jpg"></a>
      </div>
    </div>
    <div class="hz_footl">
      <div class="hz_footls">
        <span>OUR SERVICE</span>
        <p>我们的服务</p>
      </div>
      <div class="hz_footlx">
        <?php foreach ($service as $key => $value) { ?>
            <div class="hz_foot_a"><a href="{:U('Article/view',array('id'=>$value['id']))}">{$value['title']}</a></div>  
        <?php  } ?>
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
<script src="__PUBLIC__/js/public.js"></script>