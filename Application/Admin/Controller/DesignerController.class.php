<?php

namespace Admin\Controller;

use Think\Controller;

class DesignerController extends Controller {

  const MOUDELID = 2;

  /**
   * 用户列表
   * @param $json    为NULL输出模板。为1时输出列表数据到前端，格式为Json
   * @param $method  为1时，单独输出记录数
   * @examlpe 
   */
  public function index($json = NULL, $method = NULL) {
    $Public = A('Index', 'Helper');  //加载IndexPublic类
    $Public->check('Designer', array('r')); //用户检查
    //main
    if (!is_int((int) $json)) {
      $json = NULL;
    }
    $view = C('DATAGRID_VIEW');  //获取试图状态
    $page_row = C('PAGE_ROW');  //获取默认显示条数
    if ($json == 1) {
      $get_sort = I('get.sort');
      $get_order = I('get.order');
      $sort = $get_sort ? strval($get_sort) : 'id'; //，默认排序字段
      $sort = str_replace('_new_', '_old_', $sort);
      $order = $get_order ? strval($get_order) : 'asc';  //默认排序
      $result = M();
      $user_table = C('DB_PREFIX') . 'member';
      $group_table = C('DB_PREFIX') . 'member_group';

      $get_page = I('get.page');
      $get_rows = I('get.rows');
      $page = $get_page ? intval($get_page) : 1;
      $rows = $get_rows ? intval($get_rows) : $page_row;
      $now_page = $page - 1;
      $offset = $now_page * $rows;

      if (strstr($sort, 'loginnum') || strstr($sort, 'id')) {
        $new_order = $sort . ' ' . $order;
      } else {
        $new_order = 'convert(' . $sort . ' using gbk) ' . $order;
      }

      $arr_flelds = array(
        'id' => 't1.id as id',
        'name' => 't1.username as username',
        'modelid2' => 't1.modelid as t1_new_modelid',
        'nickname' => 't1.nickname as nickname',
        'email' => 't1.email as email',
        'mobile' => 't1.mobile as mobile',
        'loginnum' => 't1.loginnum as loginnum',
        'amount' => 't1.amount as amount',
        'frozen' => 't1.frozen as frozen',
        'point' => 't1.point as point',
        'lastdate' => 't1.lastdate as lastdate',
        'status' => 't1.status as t1_old_status',
        'status2' => 'IF(t1.status=1,\'认证\',\'\') as t1_new_status',
        'islock' => 't1.islock as t1_old_islock',
        'islock2' => 'IF(t1.islock=1,\'锁定\',\'\') as t1_new_islock',
        'group_id' => 't2.id as groupid',
        'group' => 't2.name as groupname',
      );


      $fields = implode(',', $arr_flelds);
      if (!$view) {//不开启视图
        $info = $result->table($user_table . ' as t1')->field('SQL_CALC_FOUND_ROWS ' . $fields)->join('LEFT JOIN ' . $group_table . ' as t2 on t2.id = t1.groupid')->where('t1.modelid=' . self::MOUDELID)->order($new_order)->limit($offset, $rows)->select();
        $count = $result->query('SELECT FOUND_ROWS() as total');
        $count = $count[0]['total'];
      } else {//开启视图
        $info = $result->table($user_table . ' as t1')->field($fields)->join('LEFT JOIN ' . $group_table . ' as t2 on t2.id = t`.groupid')->where('t1.modelid=' . self::MOUDELID)->order($new_order)->select();
        $count = count($info);
      }
      //dump($info);exit;
      $new_info = array();
      $items = array();
      $new_info['total'] = $count;
      if ($method == 'total') {
        echo json_encode($new_info);
        exit;
      }
      foreach ($info as $t) {
        if ($t['lastdate'] == 0) {
          $t['lastdate'] = '0000-00-00 00:00:00';
        } else {
          $t['lastdate'] = date("Y-m-d H:i:s", $t['lastdate']);
        }
        if ($t['islock'] == 1) {
          $t['islock'] = '锁定';
        } else {
          $t['islock'] = '';
        }
        if ($t['status'] == 1) {
          $t['status'] = '开启';
        } else {
          $t['status'] = '关闭';
        }

        $items[] = $t;
      }

      //$items = array_sort($items,$sort,$mode='nokeep',$type=$order);

      $new_info['rows'] = $items;
      //dump($new_info);
      echo json_encode($new_info);

      unset($new_info, $info, $comy, $order, $sort, $count, $items);
    } else {
      $this->assign('page_row', $page_row);
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
    $user = D('Member');
    if ($go == false) {
      $this->assign('uniqid', uniqid());
      if ($act == 'add') {
        $this->assign('act', 'add');
        $this->display();
      } else {
        $userid = $_SESSION['login']['se_id'];
        $userid = intval($userid);
        if (!is_int((int) $id)) {
          $id = NULL;
          $this->show('无法获取ID');
        } else {
          $map['id'] = array('eq', $id);
          $info = $user->relation('designer')->where($map)->find();
          unset($map);
          //dump($info);
          $this->assign('userid', $userid);
          $this->assign('id', $id);
          $this->assign('act', 'edit');
          $this->assign('info', $info);
          $this->display();
          unset($info);
        }
      }
    } else {
      $data = $user->create();
      if ($data['nickname'] == '') {
        $data['nickname'] = $data['username'];
      }
      $data['designer'] = array(
        'userid' => $id,
        'name' => I('nickname'),
      );
      //dump($data);exit;
      if ($act == 'add') {
        $Public = A('Index', 'Helper');
        $role = $Public->check('Designer', array('c'));
        if ($role < 0) {
          echo $role;
          exit;
        }
        //判断是否被注册
        $_count = M('Member')->where('username="' . $data['username'] . '"')->count();
        if ($_count > 0) {
          exit('3');
        }
        $_count = M('Member')->where('email="' . $data['email'] . '"')->count();
        if ($_count > 0) {
          exit('4');
        }
        $_count = M('Member')->where('mobile="' . $data['mobile'] . '"')->count();
        if ($_count > 0) {
          exit('5');
        }

        $data['modelid'] = self::MOUDELID;
        $data['encrypt'] = randnum(6, 0);
        if ($data['password']) {
          $oldpwd = $data['password'];
        } else {
          $rand_pwd = randnum(6);
          $oldpwd = $rand_pwd;
        }
        $data['password'] = md5(sha1($oldpwd) . $data['encrypt']);

        if (strstr($data['user_main']['part_id'], '100')) {
          $data['user_main']['company_id'] = substr($data['user_main']['part_id'], 2, strlen($data['user_main']['part_id']));
          $data['user_main']['part_id'] = 0;
        }

        if (C('USER_TO_MAIL')) {
          $Mailer = A('Mail', 'Helper');
          $to = $data['email'];
          $title = '账号注册通知';
          $name = $data['username'];
          $notes = $data['username'];
          $mail_cfg = $Public->MC('sys');
          $host = C('CFG_HOST');
          $contents = '<p><span style="color: rgb(51, 51, 51); font-family: verdana, Tahoma, Arial, 宋体, sans-serif; font-size: 14px; ">您好：</span></p><p><span style="color: rgb(51, 51, 51); font-family: verdana, Tahoma, Arial, 宋体, sans-serif; font-size: 14px; ">汇展之家管理員已为你添加了一个新的会员账号</span></p><p><span style="color: rgb(51, 51, 51); font-family: verdana, Tahoma, Arial, 宋体, sans-serif; font-size: 14px; ">账号：' . $name . ' &nbsp; &nbsp; &nbsp; &nbsp;密码：' . $oldpwd . '</span></p><p><span style="color: rgb(51, 51, 51); font-family: verdana, Tahoma, Arial, 宋体, sans-serif; font-size: 14px; ">登录地址：</span><a target="_blank" href="' . $host . '">' . $host . '</a></p><p><span style="color: rgb(51, 51, 51); font-family: verdana, Tahoma, Arial, 宋体, sans-serif; font-size: 14px; ">此邮件由系統自动发送，请不要回复，如有问题，请联系汇展之家管理员！</span></p>';
          $send = $Mailer->set($title, $contents, $mail_cfg);
          $Mailer->mailObj->AddAddress($to, $notes);
          $send = $Mailer->mailObj->send();
          $Mailer->mailObj->ClearAddresses();
          if ($send == 1) {
            $mail = 1;
          } else {
            $mail = $Mailer->mailObj->ErrorInfo;
          }
          $Mailer->mailObj->ClearAddresses();
        } else {
          $mail = 1;
        }
        if ($mail == 1) {
          $add = $user->relation(true)->add($data);
          echo $add > 0 ? 1 : 0;
        } else {
          echo 2;
        }
        unset($data, $Public);
      } elseif ($act == 'edit') {
        $Public = A('Index', 'Helper');
        $role = $Public->check('Designer', array('u'));
        if ($role < 0) {
          echo $role;
          exit;
        }

        if (!is_int((int) $id)) {
          echo 0;
        } else {
          //判断是否被注册
          $_count = M('Member')->where('username="' . $data['username'] . '" AND id!=' . intval($id))->count();
          if ($_count > 0) {
            exit('3');
          }
          $_count = M('Member')->where('email="' . $data['email'] . '" AND id!=' . intval($id))->count();
          if ($_count > 0) {
            exit('4');
          }
          $_count = M('Member')->where('mobile="' . $data['mobile'] . '" AND id!=' . intval($id))->count();
          if ($_count > 0) {
            exit('5');
          }

          if ($data['password']) {
            $data['encrypt'] = randnum(6, 0);
            $data['password'] = md5(sha1($data['password']) . $data['encrypt']);
          } else {
            unset($data['password']);
            unset($data['encrypt']);
          }

          $map['id'] = array('eq', $id);
          $edit = $user->relation(true)->where($map)->save($data);
          unset($map);
          echo $edit !== false ? 1 : 0;
          unset($data, $Public);
        }
      }
    }
    unset($user);
  }

  /**
   * 新增与更新发票数据
   * @param $act add为新增、edit为编辑
   * @param $go  为1时，获取post
   * @param $id  传人数据id
   * @examlpe 
   */
  public function invoice($act = NULL, $go = false, $id = NULL) {
    //main

    if ($go == false) {
      $this->assign('uniqid', uniqid());
      if ($act == 'edit') {
        $userid = $_SESSION['login']['se_id'];
        $userid = intval($userid);
        if (!is_int((int) $id)) {
          $id = NULL;
          $this->show('无法获取ID');
        } else {
          $map['id'] = array('eq', $id);
          $memberinfo = D('Member')->relation('invoice')->where($map)->find();
          if (!$memberinfo['invoice']) {
            $this->assign('act', 'add');
          } else {
            $this->assign('act', 'edit');
          }
          unset($map);
          $info = $memberinfo['invoice'];
          $info['company'] = $memberinfo['nickname'];
          $info['userid'] = intval($id);
          unset($memberinfo);
//          dump($info);
          $this->assign('userid', $userid);
          $this->assign('id', $id);

          $this->assign('info', $info);
          $this->display();
          unset($info);
        }
      }
    } else {
      if (!is_int((int) $id)) {
        exit('0');
      }
      $invoice = M('member_invoice');
      $data = $invoice->create();
      //dump($data);exit;
      $up = new \Org\Net\UploadFile();
      $up->allowTypes = array('image/pjpeg', 'image/jpeg', 'image/x-png', 'image/png', 'image/gif', 'image/bmp');
      $upload = C('TMPL_PARSE_STRING.__UPLOAD__');
      $up->savePath = BASE_PATH . '/' . $upload . '/users/' . $id . '/';
      $up->charset = 'UTF-8';
      $up->autoSub = true;
      $uploadpath = '/' . $upload . '/users/' . $id . '/';
      ;
      if ($act == 'add') {
        $Public = A('Index', 'Helper');
        $role = $Public->check('Designer', array('c'));
        if ($role < 0) {
          echo $role;
          exit;
        }
        $data['userid'] = $id;
        if ($up->upload()) {
          $info = $up->getUploadFileInfo();
          foreach ($info as $v) {
            $data[str_replace('new_', '', $v['key'])] = $uploadpath . $v['savename'];
          }
          unset($up);
        } else {
          if ($up->getErrorNo() != 0) {
            exit('0');
          }
        }

        $add = $invoice->add($data);
        if ($add > 0) {
          echo 1;
        } else {
          echo 0;
        }
        unset($data, $Public);
      } elseif ($act == 'edit') {
        $Public = A('Index', 'Helper');
        $role = $Public->check('Designer', array('u'));
        if ($role < 0) {
          echo $role;
          exit;
        }


        if ($up->upload()) {
          $info = $up->getUploadFileInfo();
          foreach ($info as $v) {
            $data[str_replace('new_', '', $v['key'])] = $uploadpath . $v['savename'];
          }
          unset($up);
        } else {
          if ($up->getErrorNo() != 0) {
            exit('0');
          }
        }

        $map['userid'] = array('eq', $id);
        $edit = $invoice->where($map)->save($data);
        unset($map);
        if ($edit !== false) {
          echo 1;
        } else {
          echo 0;
        }
        unset($data, $Public);
      }
    }
    unset($invoice);
  }

  /**
   * 删除数据
   * @examlpe 
   */
  public function del() {
    $Public = A('Index', 'Helper');
    $role = $Public->check('Designer', array('d'));
    if ($role < 0) {
      echo $role;
      exit;
    }

    //main
    $str_id = I('id');
    $str_id = strval($str_id);
    $str_id = substr($str_id, 0, -1);
    $arr_id = explode(',', $str_id);
    $user = M('Member');
    $pass = 0;
    $fail = 0;
    foreach ($arr_id as $id) {
      $map['id'] = array('eq', $id);
      $del = $user->where($map)->delete();
      if ($del) {
        $pass++;
      } else {
        $fail++;
      }
    }
    unset($map, $str_id, $arr_id);
    echo $pass == 0 ? 0 : 1;
    $pass = 0;
    $fail = 0;
    unset($user, $Public);
  }

  /**
   * 高级搜索
   * @param $act   为1时，获取post
   * @examlpe 
   */
  public function advsearch($act = NULL) {
    $App = A('App', 'Helper');

    //main
    $field = strval($field);
    if ($act == 1) {
      $field = I('field');
      $mod = I('mod');
      $keyword = I('keys');
      $type = I('type');
      array_pop($field);
      array_pop($mod);
      array_pop($keyword);
      array_pop($type);

      $del = array_pop($type);

      $arr = array();
      $num = 0;
      $map['id'] = 'id>0';
      foreach ($field as $key => $val) {
        if ($mod[$key] == 'like' || $mod[$key] == 'notlike') {
          $keyword[$key] = '%' . $keyword[$key] . '%';
        }
        $tt = trim($type[$key]);
        $n = $key + 1;
        $l = $key - 1;
        $nt = trim($type[$n]);
        $lt = trim($type[$l]);
        $lf = $field[$l];
        $step = 1;

        if ($val == $lf) {
          $str = $val . $step;
          $step++;
        } else {
          $str = $val;
        }

        if ($tt == 'OR') {
          if ($keyword[$key]) {
            $mod[$key] = htmlspecialchars_decode($mod[$key]);
            $arr[$num]['k'][] = $val;
            $arr[$num]['v'][] = $val . " " . $mod[$key] . " '" . $keyword[$key] . "'";
          }
          if ($nt == 'AND') {
            $mod[$n] = htmlspecialchars_decode($mod[$n]);
            if ($mod[$n] == 'like' || $mod[$n] == 'notlike') {
              $keyword[$n] = '%' . $keyword[$n] . '%';
            }
            if ($keyword[$n]) {
              $arr[$num]['k'][] = $val;
              $arr[$num]['v'][] = $val . " " . $mod[$n] . " '" . $keyword[$n] . "'";
            }
            $num++;
          }
        } else {
          if ($lt != 'OR' && $tt == 'AND') {
            $mod[$key] = htmlspecialchars_decode($mod[$key]);
            if ($keyword[$key]) {
              $map[$str] = ' and ' . $val . " " . $mod[$key] . " '" . $keyword[$key] . "'";
            }
          }
        }

        if (!isset($type[$key]) && $lt == 'OR') {
          $mod[$key] = htmlspecialchars_decode($mod[$key]);
          if ($keyword[$key]) {
            $arr[$num]['k'][] = $val;
            $arr[$num]['v'][] = $val . " " . $mod[$key] . " '" . $keyword[$key] . "'";
          }
        } else {
          if (!isset($type[$key]) && $lt != 'OR') {
            $mod[$key] = htmlspecialchars_decode($mod[$key]);
            if ($keyword[$key]) {
              $map[$str] = ' and ' . $val . " " . $mod[$key] . " '" . $keyword[$key] . "'";
            }
          }
        }
      }
      $num = 0;
      unset($key, $val, $ntable, $table, $field, $mod, $type, $keyword);

      foreach ($arr as $key => $val) {
        $str = $val['k'][0];
        for ($i = 0; $i < count($val['v']); $i++) {
          if ($i == 0) {
            $map[$str] .= ' and (' . $val['v'][$i];
          } elseif ($i == count($val['v']) - 1) {
            $map[$str] .= ' or ' . $val['v'][$i] . ')';
          } else {
            $map[$str] .= ' or ' . $val['v'][$i];
          }
        }
      }
      unset($arr);

      cookie('user', NULL);
      cookie('auser', serialize($map));
      echo 1;
      unset($map);
    } else {
      $this->assign('uniqid', uniqid());
      $this->assign('field', $field);
      $this->display();
    }
  }

  /**
   * 清空所以搜索产生的cookies
   * @examlpe 
   */
  public function clear() {
    cookie('user', NULL);
    cookie('auser', NULL);
  }

  /**
   * 工具栏搜索控制
   * @param $act  传入的字段名
   * @examlpe 
   */
  public function change($act) {
    $val = I('val');

    if (strstr($val, 'top_')) {
      $val = str_replace('top_', '', $val);
      $map['id'] = "id>0";
      $map['group_id'] = ' and group_id=' . $val;
    } else {
      $map['id'] = 'id=' . $val;
    }
    cookie('user', serialize($map));
  }

  public function members_json() {
    $groups = M('Member_group')->field('id,name as text')->where('status=1 AND modelid=' . self::MOUDELID)->select();
    //$members = M('Member')->field('id,nickname as text,modelid as _parentId')->where('status >0 AND modelid='.self::MOUDELID )->select();
    foreach ($groups as $k => $v) {
      $groups[$k]['children'] = M('Member')->field('id,nickname as text')->where('status >0 AND groupid=' . $v['id'])->select();
    }
    echo json_encode($groups, true);
  }

}
