<?php

namespace Admin\Controller;

use Think\Controller;

class IndexController extends Controller {

  /**
   * 项目主入口
   * @examlpe 
   */
  public function index() {
    $Public = A('Index', 'Helper');
    $Public->check('Index', array('r'));

    $Log = A('Log', 'Helper');

    $Log->moveLog();
    //echo '123';exit;
    session(NULL);

    //main
    $uid = $_SESSION['login']['se_id'];
    $gid = $_SESSION['login']['se_groupID'];
    $cid = $_SESSION['login']['se_comyID'];
    $pid = $_SESSION['login']['se_partID'];
    //print_r($_SESSION);exit;
    $type = $Public->GS('User_company_table', $cid, 'type');
    // echo '123';exit;
    $this->assign('type', $type);
    $this->assign('uid', $uid);
    $this->assign('gid', $gid);
    $this->assign('cid', $cid);
    $this->assign('pid', $pid);

    $menu = M('Menu');
    $info = $menu->cache(true)->where('_parentId=0 and status=1')->order('sort,id')->select();
//    print_r($info);exit;
    $group_access = $Public->GS('User_group_table', $gid);

    $logo = APP_PATH . 'Skin/' . MODULE_NAME;
    $this->assign('group_access', $group_access);
    $this->assign('uniqid', uniqid());
    $this->assign('info', $info);

    $this->display();

    unset($info, $menu, $Public);
  }

  /**
   * 获取未读信息数
   * @examlpe 
   */
  public function getsms() {
    $sms_receive = M('Sms_receive_table');
    $uid = $_SESSION['login']['se_id'];
    $count = $sms_receive->where('user_id=' . $uid . ' and `status`=0')->count();
    echo $count;
  }

  /**
   * 显示信息
   * @examlpe 
   */
  public function showsms($act = 0, $json = NULL) {
    $sms_receive = M('Sms_receive_table');
    $uid = $_SESSION['login']['se_id'];
    if ($act == 0) {
      $count = $sms_receive->where('user_id=' . $uid . ' and status=0')->count();
      echo $count;
    } elseif ($act == 1) {
      if ($json == 1) {
        $sms = D('Sms_table');
        $receive = $sms_receive->field('GROUP_CONCAT(sms_id ORDER BY sms_id) as sms_id')->where('`user_id`=' . $uid)->find();
        $info = $sms->relation('user')->where('`id` in (' . $receive['sms_id'] . ')')->select();
        $item = array();
        foreach ($info as $t) {
          if ($t['status'] == 0) {
            $t['title'] = '<strong>' . $t['title'] . '</strong>';
          }
          $item[] = $t;
        }
        echo $info = json_encode($item);
      } else {
        $this->display();
      }
    }
  }

  /**
   * 操作信息表
   * @examlpe 
   */
  public function smsact($act) {
    $sms = M('Sms_table');
    $sms_receive = M('Sms_receive_table');
    $sms_base = M('Sms_baseinfo_table');
    $uid = $_SESSION['login']['se_id'];
    $sql = '(' . $sms_receive->field('sms_id as id')->where('`user_id`=' . $uid)->select(false) . ')';
    if ($act == 'readed') {
      $data = array(
        'status' => 1
      );
      $edit = $sms->where('`id` in(' . $sql . ')')->save($data);
      $edit2 = $sms_receive->where('`user_id`=' . $uid)->save($data);
      if ($edit !== false && $edit2 !== false) {
        echo 1;
      } else {
        echo 0;
      }
    } elseif ($act == 'clear') {
      $del = $sms->where('id in(' . $sql . ')')->delete();
      if ($del) {
        $del2 = $sms_base->where('`sms_id` in(' . $sql . ')')->delete();
        $del3 = $sms_receive->where('`user_id`=' . $uid)->delete();
        echo 1;
      } else {
        echo 0;
      }
    }
  }

  /**
   * 信息详情
   * @examlpe 
   */
  public function smsdetail($id) {
    $id = intval($id);
    $sms = D('Sms_table');
    $sms_receive = M('Sms_receive_table');
    $map['id'] = array('eq', $id);
    $data = array(
      'status' => 1
    );
    $sms->where($map)->save($data);
    $sms_receive->where('`sms_id`=' . $id)->save($data);
    $info = $sms->relation(true)->where($map)->find();
    unset($map);
    $this->assign('uniqid', uniqid());
    $this->assign('info', $info);
    $this->display();
  }

  /**
   * 头部区域
   * @examlpe 
   */
  public function top() {
    $this->display();
  }

  /**
   * 左侧菜单栏区域
   * @examlpe 
   */
  public function left() {
    $this->display();
  }

  /**
   * 系统登录方法
   * @examlpe 
   */
  public function login() {
    //main
    if (IS_POST) {
      $users = D('User_table');

      $user = I('username');
      $pwd = I('post.password', 'md5');
      $code = I('code');
      $fields = array(
        'username' => $user,
        'password' => md5($pwd),
        '_logic' => 'AND'
      );
      //print_r($fields);exit;
      $info = $users->relation(true)->where($fields)->find();
      //dump($info);exit;
      unset($fields);
      if ($user == '') {
        $this->error('用户名不能为空！');
      }
      if (I('post.password') == '') {
        $this->error('密码不能为空！');
      }
      if ($code == '' && C('CODE_ON') == 1) {
        $this->error('验证码不能为空！');
      }

      if (C('CODE_ON')) {
        if (md5($code) == session('verify')) {
          $check_code = 1;
        }
      } else {
        $check_code = 1;
      }

      if ($check_code) {
        if (!count($info) > 0) {
          $this->error('账号或密码不正确！');
        } else {
          session(array('path' => CONF_PATH . '/Session', 'prefix' => 'login'));
          session('se_user', $info['username']);
          session('se_id', $info['id']);
          session('se_group', $info['user_group'][0]['name']);
          session('se_groupID', $info['user_main']['group_id']);
          session('se_comyID', $info['user_main']['company_id']);
          session('se_partID', $info['user_main']['part_id']);
          //dump(session('se_user'));exit;
          $fields = array(
            'login_count' => $info['login_count'] + 1,
            'last_visit' => time(),
          );
          $up = $users->where("id=" . $info['id'])->save($fields);
          unset($fields);
          header('Location:' . ITEM . '/index.php?s=/' . MODULE_NAME);
        }
      } else {
        $this->error('验证码不正确！');
      }
    }
    if($_SESSION['login']['se_id']){
        header('Location:' . ITEM . '/index.php?s=/' . MODULE_NAME);
    }
    $this->display();
  }

  /**
   * 注销用户
   * @examlpe 
   */
  public function safe() {
    session(array('prefix' => 'login'));
    session('[destroy]');
    redirect(ITEM . '/index.php?s=/' . MODULE_NAME . '/Index/login', 0);
  }

  /**
   * 获取验证码
   * @examlpe 
   */
  public function verify() {
    $model = C('CODE_MODEL');
    $len = C('CODE_LEN');
    \Org\Util\Image::buildImageVerify($len, $model);
  }

  /**
   * 转换左侧菜单栏数据格式，并输出Json
   * @examlpe 
   */
  public function json($mid) {
    $Left = A('Left', 'Helper');
    $Left->table = 'Menu';

    //main
    if (is_int((int) $mid)) {
      $user = D('User_table');
      $uid = $_SESSION['login']['se_id'];
      $sele = $user->relation('user_group')->where('id=' . $uid)->find();

      $Left->access = $sele['user_group'][0]['access'];
      $info = $Left->rowMenu($mid, $uid);
      //dump($info);
      echo json_encode($info);
      unset($info, $sele, $user, $Left);
    }
  }

  /**
   * 清空所以搜索产生的cookies
   * @examlpe 
   */
  public function clear($act = NULL) {
    if ($act == 'view') {
      cookie('view', NULL);
    } else {
      cookie(NULL, 'map');
    }
  }

  /**
   * 清空所以缓存数，并重新生成Json
   * @examlpe 
   */
  public function cache() {

    $sys = new \Org\Net\FileSystem();

    //main
    $temp_path = RUNTIME_PATH . '/';
    if (file_exists($temp_path)) {
      $dt = $sys->delFile($temp_path);
      R(MODULE_NAME . '/User/json', array(NULL));
      R(MODULE_NAME . '/Comy/json', array(NULL));
      R(MODULE_NAME . '/Part/json', array(NULL));
      //R(MODULE_NAME . '/Client/json', array(NULL));
      R(MODULE_NAME . '/Linkage/json', array(NULL));
      R(MODULE_NAME . '/Group/json', array(NULL));
      R(MODULE_NAME . '/Menu/json', array(NULL));
      R(MODULE_NAME . '/Industry/json', array(NULL));
    }
    echo 1;
    unset($sys, $field_path, $temp_path);
  }

  public function test() {
    $this->display();
  }

}
