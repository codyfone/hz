<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" >
    <title>添加方案-<?= C('SEO_TITLE'); ?></title>
    <link href="__PUBLIC__/css/CSS.css" rel="stylesheet" type="text/css">
    <link href="__PUBLIC__/css/user.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet"  href="__ITEM__/__JS__/datepicker/skin/default/datepicker.css">
    <link rel="stylesheet" href="__PUBLIC__/js/fancybox/jquery.fancybox.css"> 
    <style>#form-box input.input_public{height:24px;line-height: 24px;}</style>
    <script type="text/javascript" src="__ITEM__/__JS__/datepicker/WdatePicker.js"></script>
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
      function delFile(pid, id) {
        if (confirm("确定要删除附件?")) {
          $.post('<?= U('Designer/file') ?>', {act: 'del', files_id: id}, function (data) {
            console.log(data);
            if(data==1){
              $('#file_'+id).remove();
            }else{
              alert('删除失败');
            }
          });
        }
      }
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
          <div class="m_tab">
            <a href="<?= U('Designer/project', ['id' => $info['pro_id']]) ?>">项目详情</a>
            <?php if ($info['id']) { ?>
              <a class="current" href="<?= U('Designer/design', ['act' => 'edit', 'id' => $info['id']]) ?>">我的方案</a>
            <?php } else { ?>
              <a class="current" href="<?= U('Designer/design', ['act' => 'add', 'pid' => $info['pro_id']]) ?>">我要投稿</a>
            <?php } ?>
          </div>
        </div>
        <div class="m_body">
          <?php if ($act == 'edit') { ?>
            <script>
              $(function () {
                $("#edit-form").click(function () {
                  $("#form-info").hide();
                  $("#form-box").show();
                  return false;
                });
              });</script>
            <p style="margin-bottom:10px;">
              <input type="button" class="dosubmit" value="我要修改" id="edit-form">
            </p>
            <div id="form-info">

              <include file="member:_designInfo" />
            </div>
          <?php } ?>
          <div id="form-box"<?php if ($act == 'edit') echo ' style="display:none"'; ?>>
            <form id="form1" method="post" action="__SELF__">
              <input type="hidden" name="act" value="{$act}">
              <input type="hidden" name="id" value="{$info['id']}">
              <input name="pro_id" type="hidden" value="{$info.pro_id}">
              <table width="820" border="1" cellspacing="0" cellpadding="2">
                <tr>
                  <th width="110" valign="middle" align="center">
                    方案标题
                  </th>
                  <td colspan="3">
                    <input class="input_public" type="text" name="title" id="title{$uniqid}" value="{$info['title']}" style="width:99%">
                  </td>
                </tr>

                <tr>
                  <th height="26" align="center">预计完成日期</th>
                  <td>
                    <input class="input_public datepicker-text" type="text" name="enddate" id="enddate" size="10" value="<?= $info['baseinfo']['enddate'] ?>" onfocus="WdatePicker()">
                  </td>
                  <th align="center" width="110">方案状态</th>
                  <td>
                    <select name="status">
                      <?php foreach ($design_status as $k => $v) { ?>
                        <option value="<?= $k ?>"><?= $v ?></option>
                      <?php } ?>
                    </select>
                  </td>
                </tr>
                <tr>
                  <th align="center">方案描述</th>
                  <td colspan="3"><textarea name="content" id="content{$uniqid}" style="width:99%; height:100px;float:left;"><?= $info['baseinfo']['content'] ?></textarea></td>
                </tr>
              </table>
              <p style="width:830px;margin-top:20px;text-align:center;">
                <input class="dosubmit" type="submit" value="提交">
              </p>
            </form>
          </div>
          <?php if ($act == 'edit') { ?>

            <div class="mt20" id="filelist-box">
              <div class="m_head"><h3>方案附件</h3></div>
              <table class="m_table" style="width:820px;" id="file-list">
                <thead><tr><th width="40">序号</th><th>文件名</th><th>附件</th><th width="150">更新时间</th><th width="100">操作</th></tr></thead>
                <tbody>
                    <?php foreach ($filesList as $k => $v) { ?>
                  <tr id="file_<?= $v['id'] ?>">
                      <td align="center"><?php echo $k + 1; ?></td><td align="left"><a href="<?= U('Designer/file', ['act' => 'edit', 'id' => $v['id']]) ?>"><?= $v['title'] ?></a></td><td align="left"><?= $v['path'] ?></td><td align="center"><?= $v['addtime'] ?></td><td align="center">修改</a>&nbsp;&nbsp;<a href="javascript:void(0)" onclick="delFile(<?= $v['des_id'] ?>,<?= $v['id'] ?>)" class="red">删除</a></td>
                  </tr>
                    <?php } ?>
                </tbody>
              </table>
            </div>
            <div class="mt20" id="fileadd-box">
              <div class="m_head"><h3>附件添加</h3></div>
              <div class="m_body" style="width:820px;">
                <form id="file-form" method="post" action="<?= U('Designer/file') ?>">
                  <input type="hidden" name="act" value="add">
                  <input type="hidden" name="des_id" value="{$info['id']}">
                  <table class="m_table_no_border" width="100%" border="0" cellspacing="0" cellpadding="2">
                    <tr>
                      <th width="70" valign="middle" align="left">
                        文件名:
                      </th>
                      <td>
                        <input class="input_public" type="text" name="title" id="title{$uniqid}" value="" size="50">
                      </td>
                    </tr>
                    <tr>
                      <th height="26" align="left">附件:</th>
                      <td>
                        <input name="path" type="file">
                      </td>
                    </tr>
                    <tr>
                      <th align="left">内容:</th>
                      <td><textarea name="content" id="content" style="width:700px;height:300px;"></textarea></td>
                    </tr>
                  </table>
                  <p style="width:820px;margin-top:20px;text-align:center;">
                    <input class="dosubmit" type="submit" value="提交">
                  </p>
                </form>
              </div>
            </div>
          <?php } ?>
        </div>
      </div>
      <div class="clear"></div>
    </div>

  </div>
  <script type="text/javascript">
    /*<![CDATA[*/
    var ue = UE.getEditor('content', {
      serverUrl: '<?= U('Ueditor/upload') ?>'
      , toolbars: [['FullScreen', 'Source', '|', 'undo', 'redo', '|', 'bold', 'italic', 'underline', 'strikethrough', '|', 'superscript', 'subscript', '|', 'forecolor', 'backcolor', '|', 'removeformat', '|', 'insertorderedlist', 'insertunorderedlist', '|', 'selectall', 'cleardoc', 'paragraph', '|', 'fontfamily', 'fontsize', '|', 'justifyleft', 'justifycenter', 'justifyright', 'justifyjustify', '|', 'link', 'unlink', '|', 'emotion', 'image', 'video', '|', 'map', '|', 'horizontal', 'print', 'preview', 'drafts', 'formula']],
      //focus时自动清空初始化时的内容
      autoClearinitialContent: false,
      //关闭字数统计
      wordCount: false,
      //关闭elementPath
      elementPathEnabled: false, initialFrameHeight: '250'
      , initialFrameWidth: '100%'
    });
    /*]]>*/
  </script>
  <include file="index:_foot" />
</body>
</html>
