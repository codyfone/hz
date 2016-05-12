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
<div class="zh_xq_body">
	<div class="zh_xq_zhong">
    	<div class="zh_xq_zs">
        	<p>{$info['title']}</p>
        </div>
    <div class="zh_xq_zx">
            <div class="zh_xq_xzll">
                <div class="title">{$info['title']}</div>
                <div class="content">{$info['content']}</div>
            </div>
            <div class="zh_xq_zxr">
            	<div class="zh_xq_zxrb">
                	<div class="zh_xq_zb1">
                    	<p>联系客服帮您发布需求</p>
                    </div>
                    <p class="zh_xq_p1">客服电话</p>
                    <span class="zh_xq_p2">400-1234-567</span>
                    <p class="zh_xq_p3">周一至周日9:00——23:00</p>
                    <a href="">联系在线客服</a>
                    <p class="zh_xq_p3">周一至周五9:00——18:00</p>
                    <div class="zh_xq_ewm"><img src="__PUBLIC__/images/xq_ewm.jpg"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="clear"></div>
</div>
  <include file="index:_foot" />
  </body>
  </html>
