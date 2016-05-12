<?php

namespace Admin\Controller;

use Think\Controller;

class ArticleController extends Controller {
  public function index($json = NULL) {
    $Public = A('Index', 'Helper');
    $Public->check('Article', array('r'));

    //main
    if (!is_int((int) $json)) {
      $json = NULL;
    }
    if ($json == 1) {
      $article = M('Article');
      $info = $article->order('id asc')->select();
      echo '{"rows":' . json_encode($info) . '}';
      unset($info, $article);
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
    $article = M('Article');
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
          $info = $article->where($map)->find();
          $this->assign('id', $id);
          $this->assign('act', 'edit');
          $this->assign('info', $info);
          $this->display();
          unset($info);
        }
      }
    } else {
      $data = $article->create();
      $data['conent'] = $_POST['content'];
      if ($act == 'add') {
        $Public = A('Index', 'Helper');
        $role = $Public->check('Article', array('c'));
        if ($role < 0) {
          echo $role;
          exit;
        }

        $add = $article->add($data);
        echo $add > 0 ? 1 : 0;
        unset($data);
      } elseif ($act == 'edit') {
        $Public = A('Index', 'Helper');
        $role = $Public->check('Article', array('u'));
        if ($role < 0) {
          echo $role;
          exit;
        }

        if (!is_int((int) $id)) {
          echo 0;
        } else {
          $map['id'] = array('eq', $id);
          $data['conent'] = $_POST['content'];
          $edit = $article->where($map)->save($data);
          unset($map);
          echo $edit !== false ? 1 : 0;
          unset($data);
        }
      }
    }
    unset($article);
  }


  /**
   * 删除数据
   * @param $id 数据ID
   * @examlpe 
   */
  public function del($id) {
    $Public = A('Index', 'Helper');
    $role = $Public->check('Article', array('d'));
    if ($role < 0) {
      echo $role;
      exit;
    }

    //main
    if (!is_int((int) $id)) {
      echo 0;
    } else {
      $article = M('Article');
      $map['id'] = array('eq', $id);
      $del = $article->where($map)->delete();
      unset($map);
      echo $del ? 1 : 0;
      unset($article, $Public);
    }
  }

  
    public function list_json($json = NULL) {
    $Public = A('Index', 'Helper');
    $Public->check('Category', array('r'));

    $info = M('Category')->field('id, title as text,_parentId')->order('id asc')->where('id!=1')->select();
    echo json_encode($info);
    unset($info);
  }
}