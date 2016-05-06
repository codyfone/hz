<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" >
    <meta keywords="<?= C('SEO_KEYWORDS'); ?>">
    <meta description="<?= C('SEO_DESCRIPTION'); ?>">
    <title>基本信息修改-<?= C('SEO_TITLE'); ?></title>
    <link href="__PUBLIC__/css/CSS.css" rel="stylesheet" type="text/css">
    <link href="__PUBLIC__/css/user.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="__PUBLIC__/js/jquery.min.js"></script>
    <script type="text/javascript" src="__PUBLIC__/js/formValidator.min.js"></script>
    <script type="text/javascript" src="__PUBLIC__/js/formValidatorRegex.js"></script>
 <script type="text/javascript" src="__ITEM__/__JS__/ueditor/ueditor.config.js"></script>
 <script type="text/javascript" src="__ITEM__/__JS__/ueditor/ueditor.all.js"></script>
 <script type="text/javascript" src="__ITEM__/__JS__/ueditor/lang/zh-cn/zh-cn.js"></script>
    <script>
      $(function () {
        $.formValidator.initConfig({formID: "form1", theme: 'ArrowSolidBox', mode: 'AutoTip', onError: function (msg) {
            alert(msg)
          }, inIframe: true});

      });

    </script>
  </head>

  <body>
  <include file="index:_head" />

  <div id="neiye_main" class="clearfix">
    <div class="member_main">
      <div class="member_left fl">
        <div class="member_left_title"><span>个人主页</span></div>
        <include file="_menu" />
      </div>
      <div class="member_right fr">
        <div class="m_head">
          <h3>基本信息</h3>
        </div>
        <div class="m_body">
          <form id="form1" method="post" action="">
            <table class="m_table_no_border">
              <tbody>
                <tr><th align="left">公司名称：</th><td>{$info['name']}</td></tr>
                <tr><th align="left">公司简介：</th>
                  <td align="left">
                    <textarea name="content" id="content" style="width:700px;height:300px;">{$info['content']}</textarea>
                  </td></tr>  
                <tr><th></th><td align="left"><input value="提交" class="dosubmit" type="submit"></td></tr>
              </tbody></table>
          </form>  
        </div>
      </div>
      <div class="clear"></div>
    </div>

  </div>
<script type="text/javascript">
/*<![CDATA[*/
  var ue = UE.getEditor('content',{
        serverUrl: '<?= U('Ueditor/upload')?>'
        ,toolbars:[['FullScreen', 'Source','|','undo','redo','|','bold','italic','underline','strikethrough','|','superscript','subscript','|','forecolor','backcolor','|','removeformat','|','insertorderedlist','insertunorderedlist','|','selectall','cleardoc','paragraph','|','fontfamily','fontsize','|','justifyleft','justifycenter','justifyright','justifyjustify','|','link','unlink','|','emotion','image','video','|','map','|','horizontal','print','preview','drafts','formula']],
            //focus时自动清空初始化时的内容
            autoClearinitialContent:false,
            //关闭字数统计
            wordCount:false,
            //关闭elementPath
            elementPathEnabled:false    ,initialFrameHeight:'300'
    ,initialFrameWidth:'100%'
    });

/*]]>*/
</script>
  <include file="index:_foot" />
</body>
</html>
