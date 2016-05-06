<?php

namespace Admin\Controller;

use Think\Controller;

class MemberGroupController extends Controller {

  /**
   * 组别列表
   * @param $json    为NULL输出模板。为1时输出列表数据到前端，格式为Json
   * @examlpe 
   */
  public function index($json = NULL) {
    $Public = A('Index', 'Helper');
    $Public->check('MemberGroup', array('r'));

    //main
    if (!is_int((int) $json)) {
      $json = NULL;
    }
    if ($json == 1) {
      $group = M('Member_group');
      $info = $group->order('sort desc')->select();
      $new_info = array();
      foreach ($info as $t) {
        switch ($t['modelid']) {
          case 0:$t['modelid'] = '系统';
            break;
          case 1:$t['modelid'] = '展商';
            break;
          case 2:$t['modelid'] = '设计师';
            break;
          case 3:$t['modelid'] = '工厂';
        }
        if ($t['status'] == 1) {
          $t['status'] = '开启';
        } else {
          $t['status'] = '关闭';
        }
        $new_info[] = $t;
      }
      echo json_encode($new_info);
      unset($group, $info, $new_info);
    } else {
      $this->display();
    }
    unset($Public);
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
    $group = M('Member_group');
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
          $info = $group->where($map)->find();
          $this->assign('id', $id);
          $this->assign('act', 'edit');
          $this->assign('info', $info);
          $this->display();
          unset($info);
        }
      }
    } else {
      $data = $group->create();
      if ($act == 'add') {
        $Public = A('Index', 'Helper');
        $role = $Public->check('MemberGroup', array('c'));
        if ($role < 0) {
          echo $role;
          exit;
        }

        $add = $group->add($data);
        if ($add > 0) {
          $this->json(NULL);
          echo 1;
        } else {
          echo 0;
        }
      } elseif ($act == 'edit') {
        $Public = A('Index', 'Helper');
        $role = $Public->check('MemberGroup', array('u'));
        if ($role < 0) {
          echo $role;
          exit;
        }

        if (!is_int((int) $id)) {
          echo 0;
        } else {
          $map['id'] = array('eq', $id);
          $edit = $group->where($map)->save($data);
          unset($map);
          if ($edit !== false) {
            $this->json(NULL);
            echo 1;
          } else {
            echo 0;
          }
        }
      }
      unset($data, $Public);
    }
    unset($group);
  }

  /**
   * 删除数据
   * @param $id 数据ID
   * @examlpe 
   */
  public function del($id) {
    $Public = A('Index', 'Helper');
    $role = $Public->check('MemberGroup', array('d'));
    if ($role < 0) {
      echo $role;
      exit;
    }

    //main
    if (!is_int((int) $id)) {
      echo 0;
    } else {
      $group = M('Member_group');
      $map['id'] = array('eq', $id);
      $del = $group->where($map)->delete();
      unset($map);
      if ($del) {
        $this->json(NULL);
        echo 1;
      } else {
        echo 0;
      }
      unset($group);
    }
    unset($Public);
  }

  /**
   * 生成json文件
   * @param $back  为1时，返回数据
   * @examlpe 
   */
  public function json($back = 1, $modelid = null) {
    $Loop = A('Loop', 'Helper');
    $Loop->table = 'Member_group';
    $Loop->field = 'id,name as text';
    // $Loop->order = 'access';
    if ($modelid === null) {
      $Loop->where = '`status`=1';
    } else {
      $Loop->where = '`status`=1 AND `modelid`=' . intval($modelid);
    }
    $Loop->mode = 'noson';
    $Loop->isparnet = false;
    //main
    $sys = new \Org\Net\FileSystem();
    $temp_path = RUNTIME_PATH . '/Temp/';
    if (file_exists($temp_path)) {
      $dt = $sys->delFile($temp_path);
    }

    $info = $Loop->rowLevel();
    $json_data = json_encode($info);

    if ($modelid === null) {
      $Write = A('Write', 'Helper');
      $path = RUNTIME_PATH . 'Data/Json';
      $put_json = $Write->write($path, $json_data, 'MemberGroup_data');
      if ($back == 1) {
        echo $put_json ? 1 : 0;
      }
      unset($info, $json_data, $path, $Loop, $Write, $sys);
    } else {
      $info = $Loop->rowLevel();
      //     print_r($modelid);
      echo json_encode($info);
      exit;
    }
  }

}
