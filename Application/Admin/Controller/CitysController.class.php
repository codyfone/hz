<?php

namespace Admin\Controller;

use Think\Controller;

class CitysController extends Controller {

  public function list_json($id = 0) {
    $citys = M('Citys')->field('linkageid as id, name')->order('sort asc, linkageid asc')->where('_parentId=' . intval($id))->select();
    echo json_encode($citys);
  }

}
