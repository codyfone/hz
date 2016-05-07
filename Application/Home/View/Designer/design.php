<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" >
    <title>添加方案-<?= C('SEO_TITLE'); ?></title>
    <link href="__PUBLIC__/css/CSS.css" rel="stylesheet" type="text/css">
    <link href="__PUBLIC__/css/user.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet"  href="__ITEM__/__JS__/datepicker/skin/default/datepicker.css">
    <style>input.input_public{height:24px;line-height: 24px;}</style>
    <script type="text/javascript" src="__ITEM__/__JS__/datepicker/WdatePicker.js"></script>
    <script type="text/javascript" src="__PUBLIC__/js/jquery.min.js"></script>
    <script type="text/javascript" src="__PUBLIC__/js/formValidator.min.js"></script>
    <script type="text/javascript" src="__PUBLIC__/js/formValidatorRegex.js"></script>
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
          <h3>方案编辑</h3>
        </div>
        <div class="m_body">
          <?php if ($act == 'edit') { ?>
            <p style="margin-bottom:10px;"><input type="button" class="dosubmit" value="我要修改" id="edit-form"></p>
            <script>
              $(function () {
                $("#edit-form").click(function () {
                  $("#form-info").hide();
                  $("#form-box").show();
                  return false;
                });
              })
            </script>
            <div id="form-info">

              <include file="member:_projectInfo" />
            </div>
          <?php } ?>
          <div id="form-box"<?php if ($act == 'edit') echo ' style="display:none"'; ?>>
            <form id="form1" method="post" action="__SELF__">
              <input type="hidden" name="act" value="{$act}">
              <input type="hidden" name="id" value="{$info['id']}">
              <table width="820" border="1" cellspacing="0" cellpadding="2">
                <tr>
                  <th width="120" valign="middle" align="center">
                    方案标题
                  </th>
                  <td colspan="3">
                    <input class="input_public" type="text" name="exhibition" id="exhibition{$uniqid}" value="{$info['exhibition']}" style="width:99%">
                  </td>
                </tr>

                <tr>
                  <th height="26" align="center">预计完成日期</th>
                  <td colspan="1">
                    <input class="input_public datepicker-text" type="text" name="enddate" id="enddate" size="10" value="<?= $info['baseinfo']['enddate'] ?>" onfocus="WdatePicker()">
                  </td>
                  <th align="center" width="120">方案状态</th>
                  <td>
                    <select name="status">
                      <?php foreach ($design_status as $k => $v) { ?>
                        <option value="<?= $k ?>"><?= $v ?></option>
                      <?php } ?>
                    </select>
                  </td>
                </tr>
                <tr>
                  <th align="center" height="110">方案描述</th>
                  <td colspan="5"><textarea name="content" id="contentID{$uniqid}" style="width:99%; height:100px;float:left;"><?= $info['baseinfo']['content'] ?></textarea></td>
                </tr>
              </table>
              <p style="width:830px;margin-top:20px;text-align:center;">
                <input class="dosubmit" type="submit" value="提交">
              </p>
            </form>
          </div>
          <?php if ($act = 'edit') { ?>
          <?php } ?>
        </div>
      </div>
      <div class="clear"></div>
    </div>

  </div>

  <include file="index:_foot" />
</body>
</html>
