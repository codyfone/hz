<?php

namespace Home\Controller;


class ArticleController extends HomeController {

  public function index() {  
  	$cid = I('get.cid');
  	$offspring_cate_arr=$this->get_id_by_cid($cid);
  	$offspring_cate_arr[]=$cid;
  	$map['cid'] = array('in', $offspring_cate_arr);
    $articles = M('Article')->where($map)->select();

    $this->assign('this_cates', M('Category')->where('id='.$cid)->find());
    $this->assign('child_cates',$this->get_child_cates($cid));
    $this->assign('articles',$articles);
    $this->display();
  }

  public function view() {
    $info = M('Article')->where('id='.I('get.id'))->find();
    $this->assign('info',$info);
    $this->display();
  }

  /*获取所有子分类id*/
  function get_id_by_cid($cid,$cid_arr=array()){
  	$cates = M('Category')->where('_parentId='.$cid)->field('id')->select();
  	foreach ($cates as $v) {
  		$cid_arr[]=$v['id'];
  		$cid_arr = array_merge($cid_arr,$this->get_id_by_cid($v['id']));
  	}
  	return $cid_arr;
  }

 /* 获得下级分类信息*/
 function get_child_cates($cid){
 	return M('Category')->where('_parentId='.$cid)->select();
 }

}

		