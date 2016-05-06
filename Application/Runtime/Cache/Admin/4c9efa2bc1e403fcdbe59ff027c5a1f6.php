<?php if (!defined('THINK_PATH')) exit();?><script language="javascript">
  $(function () {
    var th = $(".top").height();
    th = 111 - th;
    var wh = $(window).height() - th;
    $("#Industry").treegrid({
      //title:'行业列表',	
      idField: 'id',
      height: wh,
      treeField: 'text',
      autoRowHeight: false,
      singleSelect: true,
      striped: true,
      rownumbers: true,
      method: 'get',
      url: '/index.php/Admin/Industry/index/json/1',
      fitColumns: true,
      nowrap: Number('<?php echo (C("DATA_NOWRAP")); ?>'),
      onBeforeLoad: function () {},
      onDblClickRow: function (e, rowIndex, rowData) {
        var se = $(this).treegrid('getSelected');
        var idd = se['id'];
        $("#addIndustry").dialog({
          title: '编辑行业',
          resizable: true,
          width: 550,
          height: 305,
          href: '/index.php/Admin/Industry/add/act/edit/id/' + idd,
          onOpen: function () {
            cancel['Industry'] = $(this);
          },
          onClose: function () {
            //$(this).dialog('destroy');
            //$("#Industry").treegrid('reload');
            cancel['Industry'] = null;
          }
        });
      },
      toolbar: [{
          iconCls: 'icon-add',
          text: '新增',
          handler: function () {
            $("#addIndustry").dialog({
              title: '新增行业',
              resizable: true,
              width: 550,
              height: 305,
              href: '/index.php/Admin/Industry/add/act/add',
              onOpen: function () {
                cancel['Industry'] = $(this);
              },
              onClose: function () {
                //$(this).dialog('destroy');
                //$("#Industry").treegrid('reload');
                cancel['Industry'] = null;
              }
            });
          }
        }, '-', {
          iconCls: 'icon-edit',
          text: '编辑',
          handler: function () {
            var se = $("#Industry").treegrid('getSelected');
            var idd = se['id'];
            $("#addIndustry").dialog({
              title: '编辑行业',
              resizable: true,
              width: 550,
              height: 305,
              href: '/index.php/Admin/Industry/add/act/edit/id/' + idd,
              onOpen: function () {
                cancel['Industry'] = $(this);
              },
              onClose: function () {
                //$(this).dialog('destroy');
                //$("#Industry").treegrid('reload');
                cancel['Industry'] = null;
              }
            });
          }
        }, '-', {
          iconCls: 'icon-cancel',
          text: '删除',
          handler: function () {
            var se = $("#Industry").treegrid('getSelected');
            var idd = se['id'];
            $.messager.confirm('提示', '确定删除吗！', function (r) {
              if (r == true) {
                $.messager.progress();
                $.get('/index.php/Admin/Industry/del/id/' + idd, function (data) {
                  $.messager.progress('close');
                  if (data == 1) {
                    $.messager.alert('提示', '删除数据成功！', 'info', function () {
                      $("#Industry").treegrid('reload');
                    });
                  } else if (data == 0) {
                    $.messager.alert('提示', '删除数据失败！', 'warning');
                  } else {
                    $.messager.alert('提示', '您没有删除权限！', 'warning');
                  }
                });
              }
            });
          }
        }, '-', {
          iconCls: 'icon-json',
          text: '更新缓存',
          handler: function () {
            $.get('/index.php/Admin/Industry/json', function (data) {
              if (data == 1) {
                $.messager.alert('提示', '更新缓存成功！', 'info');
              } else {
                $.messager.alert('提示', '更新缓存失败！', 'warning');
              }
            });
          }
        }, '-', {
          iconCls: 'icon-reload',
          text: '重载',
          handler: function () {
            $.get('/index.php/Admin/Industry/clear', function (data) {
            //  $("#seleCPIndustry").combobox('setValue', '');
              $("#Industry").treegrid('reload');
            });
          }
        }],
      columns: [[
          {field: 'id', title: '行业ID', width: 50},
          {field: 'text', title: '行业名称', width: 500},
          {field: 'status', title: '状态', width: 70}
        ]]
    });

    $("#rightTabs").tabs({
      onClose: function (t, i) {
        $.ajaxSetup({
          async: false
        });
        if (t == '行业管理') {
          $.get('/index.php/Admin/Industry/clear', function (data) {
          });
        }
        $.ajaxSetup({
          async: true
        });
      }
    });

    $("#rightTabs").tabs('select', '行业管理');
  });
</script>
<div id="IndustryCon" class="con" onselectstart="return false;" style="-moz-user-select:none;">
  <table id="Industry"></table>
</div>
<div id="addIndustry"></div>