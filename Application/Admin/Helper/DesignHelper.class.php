<?php

namespace Admin\Helper;

use Think\Controller;

//转换任務栏树形列表所需数据格式
class DesignHelper extends Controller {

  private $arr_pa;
  private $new_info;

  public function rowDesign($id) {
    $Public = A('Index', 'Helper');
    $obj = M('Design');
    $design = C('DB_PREFIX') . 'design';
    $linkage = C('DB_PREFIX') . 'linkage';
    $result = M();
    $proobj = M('Project');
    $top = $proobj->field('id,exhibition as text')->where('id=' . $id)->find();
    $sele = $result->table($design . ' as t1')->field('t1.id as id, t1.title as text')->where('t1.pro_id=' . $id)->select();
    $this->arr_pa = array();
    $this->new_info = array();
    $num = count($sele);
    foreach ($sele as $t) {
      $t['_parentId'] = 0;
      $t['text'] = $num-- . '<span class="up-font-over">[设计]</span>' . $t['text'];
      $this->new_info[$t['id']] = $t;
    }

    //dump($this->arr_pa);exit;
    while (true) {
      if (count($this->arr_pa) > 0) {
        $this->_getLoop($id);
      } else {
        break;
      }
    }
    $info = array_reverse($this->new_info);
    $infos[$id] = $top;
    $infos[$id]['children'] = $info;
    $info = array_reverse($infos);
    //dump($info);exit;
    //$info = array_sort($info,'sort');
    return $info;
  }

  private function _getLoop($id) {
    foreach ($this->new_info as $key => $val) {
      if ($val['_parentId'] != 0) {
        $idd = array_search($key, $this->arr_pa);
        if (!$idd) {
          $this->new_info[$val['_parentId']]['children'][] = $val;
          unset($this->new_info[$key], $this->arr_pa[$key]);
        }
      }
    }
  }

}
