<script>
  $(function () {
    function fontColor(scolor) {
      var r = 0;
      for (var i = 1; i < 7; i += 2) {
        r += parseInt("0x" + scolor.slice(i, i + 2));
      }
      return r / 3 < 128 ? '#fff' : '#000';
    }

    var main_color = <?php
if ($info['baseinfo']['main_color']) {
  $main_color = explode(',', $info['baseinfo']['main_color']);
  echo json_encode($main_color);
} else {
  echo '[]';
}
?>;
    for (i in main_color) {
      $('<a href="javascript:void(0);" style="background-color:' + main_color[i] + ';color:' + fontColor(main_color[i]) + '"><span>' + main_color[i] + '</span></a>').appendTo($("#main_color-show-v"));
    }
    var vice_color = <?php
if ($info['baseinfo']['vice_color']) {
  $vice_color = explode(',', $info['baseinfo']['vice_color']);
  echo json_encode($vice_color);
} else {
  echo '[]';
}
?>;
    for (i in vice_color) {
      $('<a href="javascript:void(0);" style="background-color:' + vice_color[i] + ';color:' + fontColor(vice_color[i]) + '"><span>' + vice_color[i] + '</span></a>').appendTo($("#vice_color-show-v"));
    }
    var taboo_color = <?php
if ($info['baseinfo']['taboo_color']) {
  $taboo_color = explode(',', $info['baseinfo']['taboo_color']);
  echo json_encode($taboo_color);
} else {
  echo '[]';
}
?>;
    for (i in taboo_color) {
      $('<a href="javascript:void(0);" style="background-color:' + taboo_color[i] + ';color:' + fontColor(taboo_color[i]) + '"><span>' + taboo_color[i] + '</span></a>').appendTo($("#taboo_color-show-v"));
    }
  });
</script>
<table width="820" border="1" cellspacing="0" cellpadding="2">
  <tr>
    <th width="45" rowspan="3" valign="middle" align="center">
      项<br><br>目
    </th>
    <td width="79" height="26" align="center">展会名称：</td>
    <td colspan="4">
      {$info['exhibition']}
    </td>
  </tr>
  <tr>
    <td rowspan="2" align="center">负责人<br>联系方式</td>
    <td width="76" align="center" height="26">联系人</td>
    <td>
      {$info['linkman']}
    </td>
    <td width="76" align="center">E-mail</td>
    <td>
      {$info['email']}
    </td>
  </tr>
  <tr>
    <td align="center" height="26">电话</td>
    <td>
      {$info['telephone']}
    </td>
    <td align="center">网址</td>
    <td>
      <?php if ($info['website']) { ?><a href="{$info.website}" target="_blank">{$info.website}</a><?php } ?>
    </td>
  </tr>
  <tr>
    <th rowspan="15" align="center" valign="center">设<br><br>计<br><br>要<br><br>求</th>
    <td rowspan="4" align="center">设计风格</td>
    <td align="center" height="26"><label>主色调</label></td>
    <td colspan="3" align="center">
      <div class="plus-tag" id="main_color-show-v"></div>
    </td>
  </tr>
  <tr>
    <td align="center" height="26">辅助色调</td>
    <td colspan="3">
      <div class="plus-tag" id="vice_color-show-v"></div>
    </td>
  </tr>
  <tr>
    <td align="center" height="26">忌用色调</td>
    <td colspan="3">
      <div class="plus-tag" id="taboo_color-show-v"></div>
    </td>
  </tr>
  <tr>
    <td height="26" colspan="4">
      <?php
      $arr = ['0' => '现代', '1' => '高雅', '2' => '实用', '3' => '简洁', '4' => '怀旧', '5' => '科技', '6' => '欧式'];
      $arr2 = explode(',', $info['baseinfo']['manner']);
      $res = [];
      foreach ($arr2 as $v) {
        $res[] = $arr[$v];
      }
      echo implode('，  ', $res);
      ?>
    </td>
  </tr>
  <tr>
    <td height="26" align="center">功能区域</td>
    <td colspan="4">
      洽谈桌椅 <span class="red"><?= $info['baseinfo']['desk_num'] ?></span> 套；
      半封闭洽谈室 <span class="red"><?= $info['baseinfo']['room_num'] ?></span> 个（从外面看不到里面）；
      储藏室 <span class="red"><?= $info['baseinfo']['store_num'] ?></span> 个
    </td>
  </tr>
  <tr>
    <td height="26" align="center">演示设备</td>
    <td colspan="4">
      <?php
      $arr = ['0' => '音响设备', '1' => '等离子', '2' => '电视墙', '3' => '电脑', '4' => '插U盘电视',];
      $arr2 = explode(',', $info['baseinfo']['equipments']);
      $res = [];
      foreach ($arr2 as $v) {
        $res[] = $arr[$v];
      }
      if ($info['baseinfo']['equipments_other'])
        $res[] = $info['baseinfo']['equipments_other'];
      echo implode('， ', $res);
      ?>

    </td>
  </tr>
  <tr>
    <td height="26" align="center">展台灯光</td>
    <td colspan="4">
      <?php
      echo $info['baseinfo']['light'];
      if ($info['baseinfo']['light_other']) {
        echo ', ' . $info['baseinfo']['light_other'];
      }
      ?>
    </td>
  </tr>
  <tr>
    <td height="26" align="center">空间要求</td>
    <td colspan="4">
      整个展台是 <span class="red"><?= $info['baseinfo']['floor_num'] ?></span> 层， <span class="red"><?= $info['baseinfo']['space_style'] ?></span>
    </td>
  </tr>
  <tr>
    <td height="26" align="center">展台结构</td>
    <td>主要材料</td>
    <td>
      <?php
      $arr = ['0' => '木质', '1' => '金属',];
      echo $arr[$info['baseinfo']['meteria']];
      ?>
    </td>
    <td height="26"><div align="center">线条要求：</div></td>
    <td colspan="2">
      <?php
      $arr = ['0' => '弧线形', '1' => '直线形', '2' => '圆形', '3' => '综合形',];
      echo $arr[$info['baseinfo']['line_style']];
      ?>
      <?php if ($info['baseinfo']['line_other']) { ?>
        &nbsp;
        其他 <span class="red">{$info['baseinfo']['line_other']}</span>
      <?php } ?>
    </td>
  </tr>
  <tr>
    <td height="26" align="center">展位划分</td>
    <td colspan="4">
      <?php
      $arr = ['0' => '接待区', '1' => '洽谈区', '2' => '产品展示区', '3' => '休息区', '4' => '储藏区', '5' => '形象展示区', '6' => '多媒体演示区'];
      $arr2 = explode(',', $info['baseinfo']['partition']);
      $res = [];
      foreach ($arr2 as $v) {
        $res[] = $arr[$v];
      }
      echo implode('，  ', $res);
      ?>
    </td>
  </tr>
  <tr>
    <td height="26" align="center">地面处理</td>
    <td colspan="4">
      <?php
      $arr = ['0' => '地毯', '1' => '瓷砖', '2' => '木地板', '3' => '地台', '4' => '发光地台',];
      $arr2 = explode(',', $info['baseinfo']['floor']);
      $res = [];
      foreach ($arr2 as $v) {
        $res[] = $arr[$v];
      }
      if ($info['baseinfo']['floor_other'])
        $res[] = $info['baseinfo']['floor_other'];
      echo implode('， ', $res);
      ?>
    </td>
  </tr>
  <tr>
    <td height="26" align="center">平面图</td>
    <td colspan="4">
      展位号 <span class="red">{$info['exhibition_no']}</span> &nbsp;
      展位面积 <span class="red">{$info['floor_area']}</span> m<sup>2</sup> &nbsp;
      规格/几面开口  <span class="red"><?php
        $arr = ['0' => '1面开口', '1' => '2面开口', '2' => '3面开口', '3' => '4面开口',];
        echo $arr[$info['baseinfo']['line_style']];
        ?>
      </span>
    </td>
  </tr>
  <tr>
    <td height="26" align="center">展品清单</td>
    <td colspan="4">
      {$info.baseinfo.detail}
    </td>
  </tr>
  <tr>
    <td height="26" align="center">展示方式</td>
    <td colspan="4">
      <?php
      $arr = ['0' => '悬挂', '1' => '展示柜', '2' => '展示架', '3' => '挑高式(高于地面)',];
      $arr2 = explode(',', $info['baseinfo']['display']);
      $res = [];
      foreach ($arr2 as $v) {
        $res[] = $arr[$v];
      }
      if ($info['baseinfo']['display_other'])
        $res[] = $info['baseinfo']['display_other'];
      echo implode('， ', $res);
      ?>
    </td>
  </tr>
  <tr>
    <td height="26" align="center">预算</td>
    <td colspan="2">
      <?php echo $info['baseinfo']['budget']; ?>
    </td>
    <td align="center">截稿日期</td>
    <td colspan="1">
      <?php echo $info['baseinfo']['enddate']; ?>
    </td>
  </tr>
  <tr>
    <th align="center" height="110">备<br><br>注</th>
    <td colspan="5">{$info.baseinfo.content}</td>
  </tr>
</table>