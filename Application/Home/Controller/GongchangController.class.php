<?php

namespace Home\Controller;

/**
 * 展馆展示
 */
class GongchangController extends \Think\Controller {

  public function index() {
    $areas = M('Citys')->field('linkageid as id,name')->where('_parentId=0')->select();
    $map = [];
    $areaid = I('get.areaid');
    if ($areaid != '') {
      $arrchildid = M('Citys')->where('linkageid=' . $areaid)->getField('arrchildid');
      if($arrchildid)
      $map['cityid'] = array('in', $arrchildid);
    }

    $pavilion_table = C('DB_PREFIX') . 'pavilion';
    $citys_table = C('DB_PREFIX') . 'citys';
    $result = M();
    if (count($map)) {
      $zhanguans = $result->table($pavilion_table . ' as t1')->field('t1.id,t1.name,t1.thumb,t1.cityid,concat(t3.name,t2.name,t1.addr) as addr')->join('left join ' . $citys_table . ' as t2 on t1.cityid=t2.linkageid')->join('left join ' . $citys_table . ' as t3 on t2._parentId=t3.linkageid')->where($map)->select();
    }else{
      $zhanguans = $result->table($pavilion_table . ' as t1')->field('t1.id,t1.name,t1.thumb,t1.cityid,concat(t3.name,t2.name,t1.addr) as addr')->join('left join ' . $citys_table . ' as t2 on t1.cityid=t2.linkageid')->join('left join ' . $citys_table . ' as t3 on t2._parentId=t3.linkageid')->select();
    }
    $this->assign('zhanguans', $zhanguans);
    $this->assign('areas', $areas);
    $this->display();
  }

}
