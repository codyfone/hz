/**
 * 大华伟业 lueying easyui ueditor 插件;
 */

(function ($) {
  function mysort(index, type, grid) {
    var d = type == 'up' ? -1 : 1;
    if ((d == -1 && index != 0) || (d == 1 && index != grid.datagrid('getRows').length - 1)) {
      var oFrom = grid.datagrid('getData').rows[index];
      grid.datagrid('getData').rows[index] = grid.datagrid('getData').rows[index + d];
      grid.datagrid('getData').rows[index + d] = oFrom;
      grid.datagrid('refreshRow', index);
      grid.datagrid('refreshRow', index + d);
      grid.datagrid('selectRow', index + d);
    }
  }
  function getDataStr(grid) {
    return JSON.stringify(grid.datagrid('getData').rows);
  }

  function create(target) {
    var editType = $.data(target, 'ueditor').options.editType || 'editor';
    var id = $(target).attr('id')
    if (editType == 'upImg' || editType == 'upMutiImgs' || editType == 'upFile' || editType == 'upMutiFiles') {

      $('<script id="' + id + '-editor" type="text/plain"></script>').insertAfter($(target));

      var opts = $.extend($.data(target, 'ueditor').options.config, {isShow: false, initialFrameHeight: '0', initialFrameWidth: '0'});
      var editor = UE.getEditor(id + '-editor', opts);
      editor.ready(function () {
        if (editType == 'upImg') {
          editor.addListener("beforeinsertimage", function (t, arg) {
            //console.log(arg);
            $(target).val(arg[0].src);
          });
          $('<button class="btn">上传图片</button>').insertAfter($(target))
                  .click(function () {
                    editor.getDialog("insertimage").open();
                  });
        } else if (editType == 'upMutiImgs') {
          // alert('adfasd');
          var _data = eval($(target).val()) || [];
          var $datagrid = $("<div id='" + id + "-grid'></div>");

          $datagrid.insertAfter($(target)).datagrid({
            width: 350,
            autoRowHeight: true,
            singleSelect: true,
            striped: true,
            rownumbers: true,
            data: _data,
            fitColumns: false,
            nowrap: 1,
            selectOnCheck: false,
            checkOnSelect: true,
            onEndEdit: function () {
              $(target).val(getDataStr($datagrid));
            },
            toolbar: [{
                iconCls: 'icon-add',
                text: '新增',
                handler: function () {
                  editor.getDialog("insertimage").open();
                }
              }, '-',
              {
                text: '上移', iconCls: 'icon-up', handler: function () {
                      var row = $datagrid.datagrid('getSelected');
                      var index = $datagrid.datagrid('getRowIndex', row);
                      mysort(index, 'up', $datagrid);
                  $(target).val(getDataStr($datagrid));
                }
              }, '-', {
                text: '下移', iconCls: 'icon-down', handler: function () {
                      var row = $datagrid.datagrid('getSelected');
                      var index = $datagrid.datagrid('getRowIndex', row);
                      mysort(index, 'down', $datagrid);
                  $(target).val(getDataStr($datagrid));
                }
              }, '-', {
                iconCls: 'icon-cancel',
                text: '删除',
                handler: function () {
                  var row = $datagrid.datagrid('getSelected');
                  var index = $datagrid.datagrid('getRowIndex', row);
                  $datagrid.datagrid('deleteRow', index);
                  $(target).val(getDataStr($datagrid));
                }
              }],
            columns: [[
                {field: 'src', title: '预览', width: 40, formatter: function (val, row) {
                    return '<a data-options="iconCls:\'icon-picture\'" href="' + val + '" target="_blank"><span class="l-btn-left" style="width:16px;height:16px;"><span class="l-btn-icon icon-picture">&nbsp;</span></span></a>';
                  }},
                {field: 'alt', title: '名称', width: 260, editor: 'text'}
              ]]
          }).datagrid('enableCellEditing').datagrid('gotoCell', {
            index: 0,
            field: 'alt'
          });
          editor.addListener("beforeinsertimage", function (t, arg) {
            for (var i in arg) {
              $datagrid.datagrid('appendRow', {src: arg[i].src, alt: arg[i].alt});
            }
            $(target).val(getDataStr($datagrid));
          });
        } else if (editType == 'upMutiFiles') {
          var _data = eval($(target).val()) || [];
          var $datagrid = $("<div id='" + id + "-grid'></div>");

          $datagrid.insertAfter($(target)).datagrid({
            width: 350,
            autoRowHeight: true,
            singleSelect: true,
            striped: true,
            rownumbers: true,
            data: _data,
            fitColumns: false,
            nowrap: 1,
            selectOnCheck: false,
            checkOnSelect: true,
            onEndEdit: function () {
              $(target).val(getDataStr($datagrid));
            },
            toolbar: [{
                iconCls: 'icon-add',
                text: '新增',
                handler: function () {
                  editor.getDialog("attachment").open();
                }
              }, '-',
              {
                text: '上移', iconCls: 'icon-up', handler: function () {
                      var row = $datagrid.datagrid('getSelected');
                      var index = $datagrid.datagrid('getRowIndex', row);
                      mysort(index, 'up', $datagrid);
                  $(target).val(getDataStr($datagrid));
                }
              }, '-', {
                text: '下移', iconCls: 'icon-down', handler: function () {
                      var row = $datagrid.datagrid('getSelected');
                      var index = $datagrid.datagrid('getRowIndex', row);
                      mysort(index, 'down', $datagrid);
                  $(target).val(getDataStr($datagrid));
                }
              }, '-', {
                iconCls: 'icon-cancel',
                text: '删除',
                handler: function () {
                  var row = $datagrid.datagrid('getSelected');
                  var index = $datagrid.datagrid('getRowIndex', row);
                  $datagrid.datagrid('deleteRow', index);
                  $(target).val(getDataStr($datagrid));
                }
              }],
            columns: [[
                {field: 'url', title: '类型', width: 40, formatter: function (val, row) {
                    return val.substr(val.lastIndexOf('.') + 1).toLowerCase();
                  }},
                {field: 'txt', title: '名称', width: 260, editor: 'text'}
              ]]
          }).datagrid('enableCellEditing').datagrid('gotoCell', {
            index: 0,
            field: 'txt'
          });

          editor.addListener("beforeInsertFile", function (t, arg) {
            for (var i in arg) {
              $datagrid.datagrid('appendRow', {url: arg[i].url, txt: arg[i].title});
            }
            $(target).val(getDataStr($datagrid));
          });
        } else {
          editor.addListener("beforeInsertFile", function (t, arg) {
            $(target).val($(arg)[0].url);
          });
          $('<button class="btn">上传文件</button>').insertAfter($(target))
                  .click(function () {
                    editor.getDialog("attachment").open();
                  });
        }
      });
    } else {
      var opts = $.data(target, 'ueditor').options.config;
      var editor = UE.getEditor($(target).attr('id'), opts);
    }
    $.data(target, 'ueditor').options.editor = editor;
  }

  $.fn.ueditor = function (options, param) {
    if (typeof options == 'string') {
      var method = $.fn.ueditor.methods[options];
      if (method) {
        return method(this, param);
      }
    }
    options = options || {};
    return this.each(function () {
      var state = $.data(this, 'ueditor');
      if (state) {
        $.extend(state.options, options);
      } else {
        state = $.data(this, 'ueditor', {
          options: $.extend({}, $.fn.ueditor.defaults, $.fn.ueditor.parseOptions(this), options)
        });
      }
      create(this);
    });
  }

  $.fn.ueditor.parseOptions = function (target) {
    return $.extend({}, $.parser.parseOptions(target, []));
  };

  $.fn.ueditor.methods = {
    editor: function (jq) {
      return $.data(jq[0], 'ueditor').options.editor;
    }
  };

  $.fn.ueditor.defaults = {config: {serverUrl: '/index.php/Admin/ueditor/upload'}};
  $.parser.plugins.push("ueditor");
})(jQuery);
