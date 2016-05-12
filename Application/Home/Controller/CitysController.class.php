<?php

namespace Home\Controller;

use Think\Controller;

class CitysController extends Controller {

  public function list_json($parent_id = 0) {
    $citys = M('Citys')->field('linkageid as region_id, name as region_name')->order('sort asc, linkageid asc')->where('_parentId=' . intval($parent_id))->select();
    echo json_encode($citys);
  }
}
