<?php

namespace Admin\Helper;

use Think\Controller;

//配置文件生成类
class WriteHelper extends Controller {

  //写入文件
  public function write($path, $data, $mode) {
    
    $paths = new \Org\Net\FileSystem();
    $paths->root = ITEM;
    $paths->charset = C('CFG_CHARSET');

    //main
    if ($mode == 'conf') {
      if (!is_writeable(APP_PATH . 'Common/Conf')) {
        return -1;
      }
      $fp = fopen($path, 'wb');
      flock($fp, 3);
      fwrite($fp, "<" . "?php\r\n");
      fwrite($fp, "return array(\r\n");
      //dump($data);
      foreach ($data as $fval) {
        $fval['vals'] = htmlspecialchars_decode($fval['vals']);
        if ($fval['types'] == 'int' || $fval['types'] == 'bool') {
          if ($fval['vals'] == "") {
            $fval['vals'] = 0;
          }
          fwrite($fp, "\t'" . $fval['keyword'] . "' => " . addslashes($fval['vals']) . ",\r\n");
        } elseif ($fval['types'] == 'select' || $fval['types'] == 'more') {
          list($key, $val) = explode('>>', $fval['vals']);
          if ($key == 'none') {
            fwrite($fp, "\t'" . $fval['keyword'] . "' => '',\r\n");
          } else {
            fwrite($fp, "\t'" . $fval['keyword'] . "' => '" . addslashes($key) . "',\r\n");
          }
        } else {
          fwrite($fp, "\t'" . $fval['keyword'] . "' => '" . addslashes($fval['vals']) . "',\r\n");
        }
      }
      fwrite($fp, ");");
      fclose($fp);
      return 1;
    } elseif ($mode && $mode != 'conf') {
      if (!file_exists($path)) {
        $paths->putDir($path);
      }
      if (!is_writeable($path)) {
        return -1;
      }
      $put = $paths->putFile($path . '/' . $mode . '.json', $data);
      return $put;
    } else {
      $this->error('未知操作模式，请检查！');
    }
  }

}
