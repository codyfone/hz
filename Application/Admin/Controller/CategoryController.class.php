<?php

namespace Admin\Controller;

use Think\Controller;

class CategoryController extends Controller {
  public function index($json = NULL) {
    $Public = A('Index', 'Helper');
    $Public->check('Category', array('r'));

    //main
    if (!is_int((int) $json)) {
      $json = NULL;
    }
    if ($json == 1) {
      $category = M('Category');
      $info = $category->order('id asc')->where('id!=1')->select();
      foreach($info as $k=>$v){
          if($v['_parentId'] == 1){
              unset($info[$k]['_parentId']);
          }
      }
      echo '{"rows":' . json_encode($info) . '}';
      unset($info, $category);
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
    $category = M('Category');
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
          $info = $category->where($map)->find();
          $this->assign('id', $id);
          $this->assign('act', 'edit');
          $this->assign('info', $info);
          $this->display();
          unset($info);
        }
      }
    } else {
      $data = $category->create();
      $data['conent'] = I('post.content', '', false);
      if ($act == 'add') {
        $Public = A('Index', 'Helper');
        $role = $Public->check('Category', array('c'));
        if ($role < 0) {
          echo $role;
          exit;
        }

        $add = $category->add($data);
        echo $add > 0 ? 1 : 0;
        unset($data);
      } elseif ($act == 'edit') {
        $Public = A('Index', 'Helper');
        $role = $Public->check('Category', array('u'));
        if ($role < 0) {
          echo $role;
          exit;
        }

        if (!is_int((int) $id)) {
          echo 0;
        } else {
          $map['id'] = array('eq', $id);
          $edit = $category->where($map)->save($data);
          unset($map);
          echo $edit !== false ? 1 : 0;
          unset($data);
        }
      }
    }
    unset($category);
  }


  /**
   * 删除数据
   * @param $id 数据ID
   * @examlpe 
   */
  public function del($id) {
    $Public = A('Index', 'Helper');
    $role = $Public->check('Category', array('d'));
    if ($role < 0) {
      echo $role;
      exit;
    }

    //main
    if (!is_int((int) $id)) {
      echo 0;
    } else {
      $category = M('Category');
      $map['id'] = array('eq', $id);
      $del = $category->where($map)->delete();
      unset($map);
      echo $del ? 1 : 0;
      unset($category, $Public);
    }
  }

  
    public function list_json($json = NULL) {
    $Public = A('Index', 'Helper');
    $Public->check('Category', array('r'));

    $info = M('Category')->field('id, title as text,_parentId')->order('id asc')->select();
    echo json_encode($info);
    unset($info);
  }
}