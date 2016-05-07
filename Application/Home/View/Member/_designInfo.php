<table width="820" border="1" cellspacing="0" cellpadding="2">
  <tr>
    <th width="100" valign="middle" align="center">
      方案标题
    </th>
    <td colspan="3">
      <?= $info['title'] ?>
    </td>
  </tr>

  <tr>
    <th height="26" align="center">预计完成日期</th>
    <td>
      <?= $info['baseinfo']['enddate'] ?>
    </td>
    <th align="center" width="100">方案状态</th>
    <td>
      <?= $info['baseinfo']['status'] ?>
    </td>
  </tr>
  <tr>
    <th align="center" height="100">方案描述</th>
    <td colspan="3"><?= $info['baseinfo']['content'] ?></td>
  </tr>
</table>