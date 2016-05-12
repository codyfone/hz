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
    <div class="company_info_container">
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
                    <p class="company_name">【{$info['name']}】</p>
                    <p><span>成立时间：</span><em>{$info['set_time']}</em></p>
                    <p><span>主营项目：</span><em>{$info['main_project']}</em></p>
                    <p><span>所在地区：</span><em>{$info['service_area']}</em></p>
<!--                    <p><span>成功案例：</span><em>53个</em></p>-->
                    <div class="talk_online">
                        <a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin={$info['kefu_qq']}&site=qq&menu=yes"><img src="__PUBLIC__/images/company_talk1.jpg" alt=""></a>
                        <a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin={$info['kefu_qq']}&site=qq&menu=yes"><img src="__PUBLIC__/images/company_talk2.jpg" alt=""></a>
                    </div>
            </div>
            <div class="company_info_right">
                    <div class="company_info_right_title"><h3>企业信息</h3></div>
                    <p>企业名称：{$info['name']}</p>
                    <p>注册资金：{$info['zhuce_money']}万</p>
                    <p>注册地址：{$info['zhuce_address']}</p>
                    <p>企业资质认证：<img src="__PUBLIC__/images/zizhi1.jpg" alt="">&nbsp;&nbsp;<img src="__PUBLIC__/images/zizhi2.jpg" alt=""></p>
                    <div class="complaint">
                            <a href="">投诉举报</a><a href="">备案查询</a>
                    </div>
                    <p>请输入您的手机号我们会及时回访：</p>
                    <form action="">
                            <input class="text" type="text" name="" id="">
                            <input class="submit" type="submit" value="免费留言">
                    </form>
            </div>
    </div>
    <div class="fill_10 clear"></div>
    <div class="fill_5 clear"></div>
    <div class="company_desc">
            <div class="company_desc_title"><h3><span style="color:#e70010;">{$info['name']}</span>&nbsp;<span>介绍</span></h3></div>
            <div class="content">
                {$info['content']}


            </div>
    </div>
    <div class="fill_10 clear"></div>
    <div class="fill_5 clear"></div>
    <div class="company_desc">
            <div class="company_desc_title"><h3><span style="color:#e70010;">搭建</span>&nbsp;<span>案例</span></h3></div>
            <div class="content">
                <ul class="factory_case_container">
                    <?php foreach ($case as $key => $value) {  
                        $pic = json_decode('['.str_replace("'", '"', $value['drawing']).']',true)[0]['src'];

                    ?>
                       <a href="{:U('Product/view',array('id'=>$value['id']))}"><li><img src="{$pic}" alt="{$value['title']}"><p>{$value['title']}</p></li></a>
                    <?php } ?>
                <div class="clear"></div>
                </ul>

            <div class="clear"></div>
            </div>
    </div>


    </div>
  <div class="fill_50 clear"></div>
  <include file="Index:_foot" />
</body>
</html>

