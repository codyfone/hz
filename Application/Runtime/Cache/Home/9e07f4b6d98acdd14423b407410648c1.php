<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" >
    <meta keywords="<?= C('SEO_KEYWORDS'); ?>">
    <meta description="<?= C('SEO_DESCRIPTION'); ?>">
    <title><?= C('SEO_TITLE'); ?></title>
    <link href="/Public/css/CSS.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="/Public/js/jquery.min.js"></script>
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
  <div class="hz_sj_js">
	<dl>
    	<dt>行业:</dt>
        <dd class="current"><a href="">不限</a></dd>
        <dd><a href="">新锐设计</a></dd>
        <dd><a href="">知名设计</a></dd>
        <dd><a href="">精英设计</a></dd>
    </dl>
    <dl>
    	<dt>规格:</dt>
        <dd class="current"><a href="">不限</a></dd>
        <dd><a href="">一面开口</a></dd>
        <dd><a href="">两面开口</a></dd>
        <dd><a href="">三面开口</a></dd>
        <dd><a href="">四面开口</a></dd>
    </dl>
    <dl>
    	<dt>结构:</dt>
        <dd class="current"><a href="">不限</a></dd>
        <dd><a href="">木质结构</a></dd>
        <dd><a href="">型材结构</a></dd>
        <dd><a href="">衍生结构</a></dd>
    </dl>
    <dl>
    	<dt>风格:</dt>
        <dd class="current"><a href="">不限</a></dd>
        <dd><a href="">现代</a></dd>
        <dd><a href="">前卫</a></dd>
        <dd><a href="">精致</a></dd>
        <dd><a href="">欧式</a></dd>
        <dd><a href="">田园</a></dd>
    </dl>
    <dl class="hz_sj_js1 hz_sj_te5">
    	<dt>面积:</dt>
        <dd class="current"><a href="">不限</a></dd>
        <dd><a href="">500</a></dd>
        <dd><a href="">400</a></dd>
        <dd><a href="">300</a></dd>
        <dd><a href="">200</a></dd>
    </dl>
</div>
<div class="zh_chao">
	<div class="zh_chao_s">
    	<p>工厂效果图</p>
        <a href="">MORE></a>
    </div>
    <div class="zh_chao_x">
    	<div class="zh_chao_xl">
        	<img src="/Public/images/chao_02.jpg">
            <div class="zh_chao_xlx">
            	<a href="">展厅设计效果图</a>
                <p>参考报价<span>5623元</span></p>
            </div>
            <div class="zh_chao_xq"><a href="">查看详情</a></div>
        </div>
        <div class="zh_chao_xr">
        	<div class="zh_chao_xrl">
            	<img src="/Public/images/chao_03.jpg">
                 <div class="zh_chao_xlx">
            	<a href="">展厅设计效果图</a>
                <p>参考报价<span>5623元</span></p>
            </div>
            <div class="zh_chao_xq"><a href="">查看详情</a></div>
            </div>
            <div class="zh_chao_xrl zh_chao_te">
            	<img src="/Public/images/chao_03.jpg">
                 <div class="zh_chao_xlx">
            	<a href="">展厅设计效果图</a>
                <p>参考报价<span>5623元</span></p>
            </div>
            <div class="zh_chao_xq"><a href="">查看详情</a></div>
            </div>
             <div class="zh_chao_xrl">
            	<img src="/Public/images/chao_03.jpg">
                 <div class="zh_chao_xlx">
            	<a href="">展厅设计效果图</a>
                <p>参考报价<span>5623元</span></p>
            </div>
            <div class="zh_chao_xq"><a href="">查看详情</a></div>
            </div>
             <div class="zh_chao_xrl zh_chao_te">
            	<img src="/Public/images/chao_03.jpg">
                 <div class="zh_chao_xlx">
            	<a href="">展厅设计效果图</a>
                <p>参考报价<span>5623元</span></p>
            </div>
            <div class="zh_chao_xq"><a href="">查看详情</a></div>
            </div>
        </div>
    </div>
</div>
<div class="clear"></div>
<div class="zh_chao_sj">
	<div class="zh_chao_sj_s">
    	<p>设计师效果图</p>
        <a href="">MORE></a>
    </div>
    <div class="zh_chao_xrl">
            	<img src="/Public/images/chao_03.jpg">
                 <div class="zh_chao_xlx">
            	<a href="">展厅设计效果图</a>
                <p>参考报价<span>5623元</span></p>
            </div>
            <div class="zh_chao_xq"><a href="">查看详情</a></div>
            </div>
            <div class="zh_chao_xrl">
            	<img src="/Public/images/chao_03.jpg">
                 <div class="zh_chao_xlx">
            	<a href="">展厅设计效果图</a>
                <p>参考报价<span>5623元</span></p>
            </div>
            <div class="zh_chao_xq"><a href="">查看详情</a></div>
            </div>
            <div class="zh_chao_xrl zh_chao_te">
            	<img src="/Public/images/chao_03.jpg">
                 <div class="zh_chao_xlx">
            	<a href="">展厅设计效果图</a>
                <p>参考报价<span>5623元</span></p>
            </div>
            <div class="zh_chao_xq"><a href="">查看详情</a></div>
            </div>
            <div class="zh_chao_xrl">
            	<img src="/Public/images/chao_03.jpg">
                 <div class="zh_chao_xlx">
            	<a href="">展厅设计效果图</a>
                <p>参考报价<span>5623元</span></p>
            </div>
            <div class="zh_chao_xq"><a href="">查看详情</a></div>
            </div>
            <div class="zh_chao_xrl">
            	<img src="/Public/images/chao_03.jpg">
                 <div class="zh_chao_xlx">
            	<a href="">展厅设计效果图</a>
                <p>参考报价<span>5623元</span></p>
            </div>
            <div class="zh_chao_xq"><a href="">查看详情</a></div>
            </div>
            <div class="zh_chao_xrl zh_chao_te">
            	<img src="/Public/images/chao_03.jpg">
                 <div class="zh_chao_xlx">
            	<a href="">展厅设计效果图</a>
                <p>参考报价<span>5623元</span></p>
            </div>
            <div class="zh_chao_xq"><a href="">查看详情</a></div>
            </div>
</div>
<div class="clear"></div>
<div class="zh_chao_gg">
	<img src="/Public/images/chao_04.jpg">
</div>
<div class="zh_chao_ys">
	<img src="/Public/images/chao_05.jpg">
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