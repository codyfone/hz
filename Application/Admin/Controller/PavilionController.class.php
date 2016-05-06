<?php

namespace Admin\Controller;

use Think\Controller;

class PavilionController extends Controller {

  /**
   * 展馆列表
   * @param $json    为NULL输出模板。为1时输出列表数据到前端，格式为Json
   * @examlpe 
   */
  public function index($json = NULL) {
    $Public = A('Index', 'Helper');
    $Public->check('Pavilion', array('r'));

    //main
    if (!is_int((int) $json)) {
      $json = NULL;
    }
    if ($json == 1) {
      $pavilion = M('Pavilion');
      $citys_table = C('DB_PREFIX') . 'citys';
      $info = $pavilion->field('t1.id, t1.name, t1.telephone, t1.cityid, t1.addr, t1.website,t1.addtime, t2.name as city')->join(' as t1 left join ' . $citys_table . ' as t2 on t1.cityid=t2.linkageid')->order('id asc')->select();
      echo json_encode($info);
      unset($info, $pavilion);
    } else {
      $this->display();
      unset($Public);
    }
  }

  public function list_json($json = NULL) {
    $Public = A('Index', 'Helper');
    $Public->check('Pavilion', array('r'));

    $info = M('Pavilion')->field('id, name as text')->order('id asc')->select();
    echo json_encode($info);
    unset($info);
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
    $pavilion = M('Pavilion');
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
          $citys_table = C('DB_PREFIX') . 'citys';
          $info = $pavilion->field('t1.*, t2._parentId as province_id')->join('AS t1 LEFT JOIN ' . $citys_table . ' AS t2 ON t2.linkageid=t1.cityid')->where($map)->find();
          $this->assign('id', $id);
          $this->assign('act', 'edit');
          $this->assign('info', $info);
          $this->display();
          unset($info);
        }
      }
    } else {

      $data = $pavilion->create();
      $data['dimensions'] = I('post.dimensions', '', false);
      $data['content'] = I('post.content', '', false);
      $data['images'] = I('post.images', '', false);
      if ($act == 'add') {
        $Public = A('Index', 'Helper');
        $role = $Public->check('Pavilion', array('c'));
        if ($role < 0) {
          echo $role;
          exit;
        }
        $data['uptime'] = $data['addtime'] = date('Y-m-d H:i:s');
        $add = $pavilion->add($data);
        echo $add > 0 ? 1 : 0;
        unset($data);
      } elseif ($act == 'edit') {
        $Public = A('Index', 'Helper');
        $role = $Public->check('Pavilion', array('u'));
        if ($role < 0) {
          echo $role;
          exit;
        }

        if (!is_int((int) $id)) {
          echo 0;
        } else {
          $map['id'] = array('eq', $id);
          $data['uptime'] = date('Y-m-d H:i:s');
          $edit = $pavilion->where($map)->save($data);
          unset($map);
          echo $edit !== false ? 1 : 0;
          unset($data);
        }
      }
    }
    unset($pavilion);
  }

  /**
   * 删除数据
   * @param $id 数据ID
   * @examlpe 
   */
  public function del($id) {
    $Public = A('Index', 'Helper');
    $role = $Public->check('Pavilion', array('d'));
    if ($role < 0) {
      echo $role;
      exit;
    }

    //main
    if (!is_int((int) $id)) {
      echo 0;
    } else {
      $pavilion = M('Pavilion');
      $map['id'] = array('eq', $id);
      $del = $pavilion->where($map)->delete();
      unset($map);
      echo $del ? 1 : 0;
      unset($pavilion, $Public);
    }
  }

}
