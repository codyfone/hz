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
    <div class="company_info_container zhanguan_info_container zhanhui_info_container">
            <div class="pic">
                    <div class="hd">
                            <ul>
                            <?php foreach ($images as $key => $value) { ?>
                                <li></li>
                             <?php   } ?>
                            </ul>
                    </div>
                    <div class="bd">
                            <ul>
                            <?php foreach ($images as $key => $value) { ?>
                                <li><a href="" target="_blank"><img src="{$value['src']}" /></a></li>
                             <?php   } ?>
                            </ul>
                    </div>
            </div>
            <script>
                jQuery(".pic").slide({mainCell:".bd ul",autoPlay:true});
                $('.company_info_container .pic .hd ul').css('margin-left',($('.company_info_container .pic .hd').width()-$('.company_info_container .pic .hd ul').width())/2);

            </script>
            <div class="company_info">
                    <p class="company_name">{$info['name']}</p>
                    <p><span>举办时间：</span><em>{$info['startdate']}&nbsp;至&nbsp;{$info['enddate']}</em></p>
                    <p><span>举办地址：</span><em>{$info['addr']}</em></p>
                    <p><span>举办展馆：</span><a href="{:U('Zhanguan/view',array('id'=>$info['pavilion_id']))}"><em style="color:#337ab7">{$info['pavilion_name']}</em></a></p>
                    <p><span>行业分类：</span><em>{$info['industry']}</em></p>
                    <p><span>会展面积：</span><em>{$info['space']}</em></p>
                    <p><span>主办机构：</span><em>{$info['sponsor']}</em></p>
                    <p><span>承办机构：</span><em>{$info['organizer']}</em></p>

            </div>
 
    </div>
    <div class="fill_10 clear"></div>
    <div class="fill_5 clear"></div>
    <div class="company_desc">
            <div class="company_desc_title"><h3><span style="color:#e70010;">&nbsp;&nbsp;展会介绍</span>&nbsp;<span></span></h3></div>
            <div class="content">
                {$info['content']}


            </div>
    </div>

    </div>
  <div class="fill_50 clear"></div>
  <include file="Index:_foot" />
</body>
</html>

