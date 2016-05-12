<?php

namespace Admin\Controller;

use Think\Controller;

class ExhibitionController extends Controller {

  /**
   * 公司列表
   * @param $json    为NULL输出模板。为1时输出列表数据到前端，格式为Json
   * @examlpe 
   */
  public function index($json = NULL) {
    $Public = A('Index', 'Helper');
    $Public->check('Exhibition', array('r'));

    //main
    if (!is_int((int) $json)) {
      $json = NULL;
    }
    if ($json == 1) {
      $exhibition = D('Exhibition');
      $info = $exhibition->relation('pavilion')->order('id asc')->select();
      echo json_encode($info);
      unset($info, $exhibition);
    } else {
      $this->display();
      unset($Public);
    }
  }

  /**
   * 新增与更新数据
   * @param $act add为新增、edit为编辑
   * @param $go  为1时，获取post
   * @param $id  传人数据id
   * @examlpe 
   */
  public function add($act = NULL, $go = false, $id = NULL) {
    //main
    $exhibition = M('Exhibition');
    if ($go == false) {
      $this->assign('uniqid', uniqid());
      if ($act == 'add') {
        $this->assign('act', 'add');
        $this->display();
      } else {
        if (!is_int((int) $id)) {
          $id = NULL;
          $this->show('无法获取ID');
        } else {
          $map['id'] = array('eq', $id);
          $info = $exhibition->where($map)->find();
          $this->assign('id', $id);
          $this->assign('act', 'edit');
          $this->assign('info', $info);
          $this->display();
          unset($info);
        }
      }
    } else {
      $data = $exhibition->create();
      $data['conent'] = I('post.content', '', false);
      $data['images'] = I('post.images', '', false);
      if ($act == 'add') {
        $Public = A('Index', 'Helper');
        $role = $Public->check('Exhibition', array('c'));
        if ($role < 0) {
          echo $role;
          exit;
        }

        $add = $exhibition->add($data);
        echo $add > 0 ? 1 : 0;
        unset($data);
      } elseif ($act == 'edit') {
        $Public = A('Index', 'Helper');
        $role = $Public->check('Exhibition', array('u'));
        if ($role < 0) {
          echo $role;
          exit;
        }

        if (!is_int((int) $id)) {
          echo 0;
        } else {
          $map['id'] = array('eq', $id);
          $edit = $exhibition->where($map)->save($data);
          unset($map);
          echo $edit !== false ? 1 : 0;
          unset($data);
        }
      }
    }
    unset($exhibition);
  }

  /**
   * 删除数据
   * @param $id 数据ID
   * @examlpe 
   */
  public function del($id) {
    $Public = A('Index', 'Helper');
    $role = $Public->check('Exhibition', array('d'));
    if ($role < 0) {
      echo $role;
      exit;
    }

    //main
    if (!is_int((int) $id)) {
      echo 0;
    } else {
      $exhibition = M('Exhibition');
      $map['id'] = array('eq', $id);
      $del = $exhibition->where($map)->delete();
      unset($map);
      echo $del ? 1 : 0;
      unset($exhibition, $Public);
    }
  }

}
