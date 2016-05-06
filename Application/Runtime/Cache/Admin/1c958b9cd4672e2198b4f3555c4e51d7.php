<?php if (!defined('THINK_PATH')) exit();?><script language="javascript">
  var se = Array();
  $(function () {
    var th = $(".top").height();
    th = 111 - th
    var wh = $(window).height() - th;
    var cw = $(window).width() - 177;
    $("#info").panel({
      //title:'信息統計',
      doSize: true,
      height: 219,
      collapsible: true
    });
    whs = (wh - 249);
    $("#designUserTabs").height(whs);
  });

  $(function () {
    var $this = $(".renav");
    var scrollTimer;
    $this.hover(function () {
      clearInterval(scrollTimer);
    }, function () {
      scrollTimer = setInterval(function () {
        scrollNews($this);
      }, 3800);
    }).trigger("mouseout");
  });
  function scrollNews(obj) {
    var $self = obj.find("ul:first");
    var lineHeight = $self.find("li:first").height();
    $self.animate({"margin-top": -lineHeight + "px"}, 600, function () {
      $self.css({"margin-top": "0px"}).find("li:first").appendTo($self);
    });
  }

  function toShowNotice(id) {
    var has = $("#detailFormNotice").length;
    if (!has) {
      $("<div/>").dialog({
        title: '公告详情',
        resizable: true,
        width: 720,
        height: 480,
        href: '/index.php/Admin/Notice/detail/id/' + id,
        onOpen: function () {
          cancel['NoticeDetail'] = $(this);
        },
        onClose: function () {
          $(this).dialog('destroy');
          cancel['NoticeDetail'] = null;
        }
      });
    }
  }

  function onCheckVer() {
    var url = 'http://' + window.location.host;
    var x = $.getJSON("http://server.piocms.com/dwuss/index.php/Admin/project/upload?callback=?", {mode: 'EasyWork', serial: '<?php echo $serial ?>', ver: '<?php echo $ver[0] ?>', domain: url, key: 'e1a111321d2cc0c2ba779e7ccd43994d'}, function (data) {
      $.get('/index.php/Admin/Design/upver');
      return;
    });
  }
</script>
<div class="con" id="DesignIndexCon">
  <div id="info" style="margin-bottom:5px; padding:3px;">
    <table class="infobox table-border linebox" width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr style="height:25px;">
        <td>
          <span class="vol up-font-over">
            <div class="renav_tit">公告：</div>
            <div class="renav"> 
              <ul style="margin-top: 0px;"> 
                <?php if(is_array($ninfo)): foreach($ninfo as $key=>$t): ?><li><a href="javascript:toShowNotice('<?php echo ($t["id"]); ?>')"><?php echo ($t["title"]); ?>&nbsp;/&nbsp;<?php echo ($t["addtime"]); ?></a> </li><?php endforeach; endif; ?>
              </ul> 
            </div>

          </span>
        </td>
      </tr>
      <tr style="height:23px; line-height:23px;">
        <td height="28" class="rebg"><label>项目状态统计</label></td>
      </tr>
      <tr style="height:35px; line-height:35px;">
        <td>
          <span style="margin-right:25px;">项目总数量：<span class="up-font-over" style="font-weight:bold;"><?php echo $app->getTotal('Project'); ?></span></span>
          <span style="margin-right:25px;">项目已完成：<span class="up-font-over" style="font-weight:bold;"><?php echo $comple; ?></span></span>
          <span style="margin-right:25px;">项目未完成：<span class="up-font-over" style="font-weight:bold;"><?php echo $un_comple; ?></span></span>
          <span style="margin-right:25px;">项目延误数：<span class="up-font-over" style="font-weight:bold;"><?php echo $old; ?></span></span>
          <span style="margin-right:25px;">方案总数量：<span class="up-font-over" style="font-weight:bold;"><?php echo $app->getTotal('design'); ?></span></span>
          <span style="margin-right:25px;">方案已完成：<span class="up-font-over" style="font-weight:bold;"><?php echo $app->getTotal('design','`status`=51'); ?></span></span>
          <span style="margin-right:25px;">方案未完成：<span class="up-font-over" style="font-weight:bold;"><?php echo $app->getTotal('design','`status`<>51'); ?></span></span>
          <span style="margin-right:25px;">方案延误数：<span class="up-font-over" style="font-weight:bold;"><?php echo $app->getTotal('design','TO_DAYS(NOW())>TO_DAYS(`enddate`) and `status`<>51'); ?></span></span>
        </td>
      </tr>
      <tr style="height:23px; line-height:23px;" class="rebg5">
        <td>
          <?php
 foreach($design_status as $k=>$t){ ?>
          <span class="total_box">
            <div style="font-weight:bold; line-height:20px; font-size:19px; color:#5B83B9"><?php echo $app->getTotal('Design','`status`='.$t['id']); ?></div>
            <div><?php echo ($t["text"]); ?></div>
          </span>
          <?php
 } ?>
        </td>
      </tr>
      <tr style="height:23px; line-height:23px;">
        <td height="28" class="rebg"><label>我的方案统计</label></td>
      </tr>
      <tr style="height:35px; line-height:35px;">
        <td>
          <span style="margin-right:25px;">方案总数量：<span class="up-font-over" style="font-weight:bold;"><?php echo $app->getTotal('design'); ?></span></span>
          <span style="margin-right:25px;">方案已完成：<span class="up-font-over" style="font-weight:bold;"><?php echo $app->getTotal('design','`status`=51'); ?></span></span>
          <span style="margin-right:25px;">方案未完成：<span class="up-font-over" style="font-weight:bold;"><?php echo $app->getTotal('design','`status`<>51'); ?></span></span>
          <span style="margin-right:25px;">方案延误数：<span class="up-font-over" style="font-weight:bold;"><?php echo $app->getTotal('design','TO_DAYS(NOW())>TO_DAYS(`enddate`) and `status`<>51'); ?></span></span>
        </td>
      </tr>
    </table>
  </div>
  <div id="designUserTabs" class="easyui-tabs">  
    <div title="待审核的方案" data-options="href:'/index.php/Admin/Design/designlist/type/0',cache:false"></div> 
    <div title="所有方案" data-options="href:'/index.php/Admin/Design/designlist/type/99',cache:false"></div> 
  </div>
  <div align="center" style="line-height:26px; color:#A7A7A7;">Copyright © 2010-2015 程序由 <a style="line-height:26px; color:#A7A7A7;" href="http://www.101ebuy.net/" target="_blank">大华伟业</a> 设计开发 &nbsp; <span><a class="up-font-over" onclick="onCheckVer()" href="#" target="_blank">版本号：<?php echo ($ver["0"]); ?></a></span></div>
</div>