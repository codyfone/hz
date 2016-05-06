<?php

namespace Admin\Helper;

use Think\Controller;

//项目日志操作
class FilesHelper extends Controller {

  //插入操作文档
  /*
    return 		Void
    $pro_id		项目ID
    $mode		默認為創建，傳入字符串，add：創建=>1，deit，del：刪除=>2
   */
  public function actFiles($pro_id = 0, $mode = 1) {
    $files = M('Files_table');
    $files_baseinfo = M('Files_baseinfo_table');
    $files_path = M('Files_path_table');
    switch ($mode) {
      case 2:
        $sql = '('.$files->field('id')->where('`pro_id`=' . $pro_id)->select(false).')';
        $del1 = $files_baseinfo->where('`files_id` in (' . $sql . ')')->delete();
        $del2 = $files_path->where('`files_id` in (' . $sql . ')')->delete();
        $del3 = $files->where('`pro_id`=' . $pro_id)->delete();
        break;
    }
  }

}
