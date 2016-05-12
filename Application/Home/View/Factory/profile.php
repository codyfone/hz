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
 <link rel="stylesheet"  href="__ITEM__/__JS__/datepicker/skin/default/datepicker.css">
    <script type="text/javascript" src="__ITEM__/__JS__/datepicker/WdatePicker.js"></script>
    <script type="text/javascript" src="__PUBLIC__/js/jquery.ld.js"></script>

    <script>
      $(function () {
        $.formValidator.initConfig({formID: "form1", theme: 'ArrowSolidBox', mode: 'AutoTip', onError: function (msg) {
            alert(msg)
          }, inIframe: true});
        

      });
      //三级联动地区
        $(function () {
          var $ld5 = $(".pc-select-areaid");
          $ld5.ld({ajaxOptions: {"url": "<?= U('citys/list_json') ?>"}, defaultParentId: 0, style: {"width": 120}})
          var ld5_api = $ld5.ld("api");
          ld5_api.selected(<?php echo $area; ?>);
          $ld5.bind("change", onchange);
          function onchange(e) {
            var $target = $(e.target);
            var index = $ld5.index($target);
            $("#areaid-4").remove();
            $("#areaid").val($ld5.eq(index).show().val());
            index++;
          }
        })
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
          <h3>资料设置</h3>
        </div>
        <div class="m_body">
          <form id="form1" method="post" action="">
            <table class="m_table_no_border">
              <tbody>
                <tr><th align="left">企业名称：</th><td>{$info['name']}</td></tr>
                <tr><th align="left">注册资金：</th><td align="left">
                    <input name="zhuce_money" id="idea" value="{$info['zhuce_money']}" class="input_public" type="text" size="10">万
                  </td>
                </tr>
                <tr><th align="left">地区：</th>
                  <td align="left">
                    <input type="hidden" name="areaid"  id="areaid" value="{$info['areaid']}">
                    <select class="input_public pc-select-areaid" name="areaid-1" id="areaid-1" width="100">
                        <option value="">请选择菜单</option>
                    </select> 
                    <select class="input_public pc-select-areaid" name="areaid-2" id="areaid-2" width="100" style="display:none">
                        <option value="">请选择菜单</option>
                    </select> 
                    <select class="input_public pc-select-areaid" name="areaid-3" id="areaid-3" width="100" style="display:none">
                        <option value="">请选择菜单</option>
                    </select>


                  </td></tr> 
                <tr><th align="left">注册地址：</th><td align="left"><input name="zhuce_address" id='zhuce_address' class="input_public" value="{$info['zhuce_address']}" type="text" size="90"></td></tr>
                <tr><th align="left">注册时间：</th><td><input name="set_time" id="set_time" value="{$info['set_time']}" class="input_public" type="text" size="20" onfocus="WdatePicker()"></td></tr>
                <tr><th align="left">主营项目：</th><td><input name="main_project" id="main_project" value="{$info['main_project']}" class="input_public" type="text" size="50"></td></tr>
                
               <!--  <tr><th align="left">服务地区：</th><td><input name="service_area" id="service_area" value="{$info['service_area']}" class="input_public" type="text" size="50"></td></tr> -->

                <tr><th align="left">客服QQ：</th><td><input name="kefu_qq" id="kefu_qq" value="{$info['kefu_qq']}" class="input_public" type="text" size="50"></td></tr>
                <tr><th align="left">客服电话：</th><td><input name="kefu_tel" id="kefu_tel" value="{$info['kefu_tel']}" class="input_public" type="text" size="50"></td></tr>
                <tr><th align="left">企业图集：</th>
                    <td>
                        <input name="company_images" id="company_images" type="hidden" value="{$info['company_images']}" />                    
                        <div class="span16">
                            <button type="button" class="upimage_btn" id="upimages" href="#" target="_blank"><i class="icons24 icons24-editing"></i><span>添加图片</span></button>
                            <div class="fileListbox">
                                <ul id="fileListWarp"></ul>
                            </div>
                        </div>
                    </td>
                    <script type="text/plain" id="imageseditor"></script>
                    <script type="text/javascript">
                      var aImgList = [{$info['company_images']}];
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
                          $("#company_images").val(sValue);
                          // alert($("#Product_images").val());
                      }
                    </script>

                    <script type="text/javascript">
                    /*<![CDATA[*/
                    var upimgs = UE.getEditor('imageseditor',{
                        serverUrl: '<?= U('Ueditor/upload')?>'
                        ,isShow:false    ,initialFrameHeight:'0'
                    ,initialFrameWidth:'0'
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
                </tr>
                
                <tr><th align="left">详细介绍：</th>
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
