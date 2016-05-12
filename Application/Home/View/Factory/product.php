<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" >
    <title>添加案例-<?= C('SEO_TITLE'); ?></title>
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
          <h3>案例详情</h3>
        </div>
        <div class="m_body">
          <form id="form1" method="post" action="">
            <table class="m_table_no_border">
              <tbody>
                <tr><th align="left">案例名称：</th><td><input class="input_public" name="title" type="text" value="<?= $info['title'] ?>" size="50" ></td></tr>
                <tr><th align="left">行业分类：</th>
                  <td>
                    <select name="industry_id" id="industry_id{$uniqid}" class="input_public" style="width:150px;">
                      <option class="">-- 请选择类别 --</option>
                      <?php foreach ($industrys as $v) { ?>
                        <option value="<?php echo $v['id']; ?>"<?php if($v['id'] == $info['industry_id']) echo ' selected'; ?>><?php echo $v['text']; ?></option>
                      <?php } ?>
                    </select></td>
                </tr>
                <tr>
                  <th align="left">规格：</th>
                  <td>
                    <select name="open_num" id="open_num{$uinqid}" class="input_public" style="width:100px;">
                      <?php $value = $info['open_num']; ?>
                      <option value=''>请选择</option>
                      <option value="1"<?php if ($value == 1) echo ' selected'; ?>>1面开口</option>  
                      <option value="2"<?php if ($value == 2) echo ' selected'; ?>>2面开口</option> 
                      <option value="3"<?php if ($value == 3) echo ' selected'; ?>>3面开口</option>  
                      <option value="4"<?php if ($value == 4) echo ' selected'; ?>>4面开口</option>
                    </select>
                  </td>
                </tr>
                <tr>
                  <th align="left">展台结构：</th>
                  <td>
                    <select name="stucture" id="stucture{$uinqid}" class="input_public" style="width:100px;">
                      <?php $value = $info['structure']; ?>
                      <option value=''>请选择</option>
                      <option value="1"<?php if ($value == 1) echo ' selected'; ?>>木质结构</option>  
                      <option value="2"<?php if ($value == 2) echo ' selected'; ?>>衍架结构</option> 
                      <option value="3"<?php if ($value == 3) echo ' selected'; ?>>型材结构</option>  
                      <option value="4"<?php if ($value == 4) echo ' selected'; ?>>双层结构</option>
                    </select>
                  </td>
                </tr>
                <tr><th align="left">面积：</th><td><input class="input_public" type="text" name="floor_area" value="<?= $info['floor_area'] ?>" size="5" > m<sup>2</sup></td></tr>
                <tr><th align="left">价格：</th><td><input class="input_public" type="text" name="price" value="<?= $info['price'] ?>" size="5" > 元</td></tr>
                <tr><th align="left" valign="top">图集展示：</th>
                  <td align="left">
                    <input name="drawing" id="drawing" type="hidden" value="{$info['drawing']}" />                    
                    <div class="span16">
                      <button type="button" class="upimage_btn" id="upimages" href="#" target="_blank"><i class="icons24 icons24-editing"></i><span>添加图片</span></button>
                      <div class="fileListbox">
                        <ul id="fileListWarp"></ul>
                      </div>
                    </div>
                  </td>
                </tr>
                <tr><th align="left">是否商品：</th><td><select class="input_public" name="status" id="status{$uinqid}">
                      <?php $value = $info['status']; ?>
                      <option value='0'>下线</option>
                      <option value="1"<?php if ($value == 1) echo ' selected'; ?>>普通案例</option>  
                      <option value="2"<?php if ($value == 2) echo ' selected'; ?>>商品</option> 
                    </select></td></tr>
                <tr><th></th><td align="left"><input value="提交" class="dosubmit" type="submit"></td></tr>
              </tbody></table>
          </form>  
        </div>
      </div>
      <div class="clear"></div>
    </div>

  </div>

  <include file="index:_foot" />
  <script type="text/plain" id="imageseditor"></script>
  <script type="text/javascript">
    var aImgList = [{$info['drawing']}];
    var iImgNum = aImgList.length;
    var aImgs = [];
    $(function () {
      var oHtml = "";
      for (var i = 0; i < iImgNum; i++) {
        oHtml += "<li id=\"img_" + i + "\"><img src=\"" + aImgList[i].src + "\" height=\"113\"><span class=\"removeimg\"></span><input class=\"text imgtxt\" type=\"text\" value=\"" + aImgList[i].txt + "\" /></li>";
        aImgs[i] = "{'src':'" + aImgList[i].src + "','txt':'" + aImgList[i].alt + "'}";

      }
      $(oHtml).appendTo("#fileListWarp");

      for (var i = 0; i < iImgNum; i++) {
        $("#img_" + i + " .removeimg").click(function () {
          var _pid = $(this).parent().remove().attr('id').substr(4);
          aImgs[_pid] = "";
          updateImgs();
        });
      }
    });
    //弹出图片上传的对话框
    function upImage(editor) {
      var myImage = editor.getDialog("insertimage");
      myImage.open();
    }
    //弹出文件上传的对话框
    function upFiles(editor) {
      var myFiles = editor.getDialog("attachment");
      myFiles.open();
    }
    function pushImgs(arr) {
      var oHtml = "";
      var _startIndex = iImgNum;
      for (var i = 0; i < arr.length; i++) {
        oHtml += "<li id=\"img_" + iImgNum + "\"><img src=\"" + arr[i].src + "\" height=\"113\"><span class=\"removeimg\"></span><input class=\"text imgtxt\" type=\"text\" value=\"" + arr[i].alt + "\"></li>";
        aImgs[iImgNum] = "{'src':'" + arr[i].src + "','txt':'" + arr[i].alt + "'}";
        iImgNum++;
      }
      $(oHtml).appendTo("#fileListWarp");
      updateImgs();
      for (var i = _startIndex; i < iImgNum; i++) {
        $("#img_" + i + " .removeimg").click(function () {
          var _pid = $(this).parent().remove().attr('id').substr(4);
          aImgs[_pid] = "";
          updateImgs();
        });
      }
    }

    function updateImgs() {
      var sValue = "";
      for (var i = 0; i < aImgs.length; i++) {
        if (aImgs[i] != "") {
          if (sValue == "") {
            sValue = aImgs[i];
          } else {
            sValue += ',' + aImgs[i]
          }
        }
      }
      $("#drawing").val(sValue);
      // alert($("#Product_images").val());
    }
  </script>

  <script type="text/javascript">
    /*<![CDATA[*/
    var upimgs = UE.getEditor('imageseditor', {
      serverUrl: '<?= U('Ueditor/upload') ?>'
      , isShow: false, initialFrameHeight: '0'
      , initialFrameWidth: '0'
    });
    upimgs.ready(function () {
      //弹出图片上传的对话框
      function upImage(editor) {
        var myImage = editor.getDialog("insertimage");
        myImage.open();
      }

      function pushImgs(arr) {
        var oHtml = "";
        var _startIndex = iImgNum;
        for (var i = 0; i < arr.length; i++) {
          oHtml += "<li id=\"img_" + iImgNum + "\"><img src=\"" + arr[i].src + "\" height=\"113\"><span class=\"removeimg\"></span><input class=\"text imgtxt\" type=\"text\" value=\"" + arr[i].alt + "\"></li>";
          aImgs[iImgNum] = "{'src':'" + arr[i].src + "','txt':'" + arr[i].alt + "'}";
          iImgNum++;
        }
        $(oHtml).appendTo("#fileListWarp");
        updateImgs();
        for (var i = _startIndex; i < iImgNum; i++) {
          $("#img_" + i + " .removeimg").click(function () {
            var _pid = $(this).parent().remove().attr('id').substr(4);
            aImgs[_pid] = "";
            updateImgs();
          });
        }
      }

      upimgs.addListener("beforeInsertImage", function (t, arg) {
        pushImgs(arg);
      });

      $("#upimages").click(function () {
        upImage(upimgs);
      });
    });

    /*]]>*/
  </script>
</body>
</html>
