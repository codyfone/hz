<?php

namespace Common\Model;

use Think\Model\RelationModel;
use User\Api\UserApi;

class MemberModel extends RelationModel {
  /*
    protected $_map = array(
    'username'=>'user',
    'password'=>'pwd',
    );
   */

  protected $_link = array(
    'designer' => array(
      'mapping_type' => self::HAS_ONE,
      'class_name' => 'member_designer',
      'foreign_key' => 'userid',
    ),
    'exhibitor' => array(
      'mapping_type' => self::HAS_ONE,
      'class_name' => 'member_exhibitor',
      'foreign_key' => 'userid',
    ),
    'factory' => array(
      'mapping_type' => self::HAS_ONE,
      'class_name' => 'member_factory',
      'foreign_key' => 'userid',
    ),
    'group' => array(
      'mapping_type' => self::BELONGS_TO,
      'mapping_name' => 'member_group',
      'class_name' => 'member_group',
      'foreign_key' => 'groupid',
      'as_fields' => 'name:groupname',
    ),
    'invoice' => array(
      'mapping_type' => self::HAS_ONE,
      'class_name' => 'member_invoice',
      'foreign_key' => 'userid',
    ),
  );

  /* 用户模型自动完成 */
  protected $_auto = array(
    array('loginnum', 0, self::MODEL_INSERT),
    array('regip', 'get_client_ip', self::MODEL_INSERT, 'function', 1),
    array('regdate', NOW_TIME, self::MODEL_INSERT),
    array('lastip', 'get_client_ip', self::MODEL_INSERT, 'function', 1),
    array('lastdate', 0, self::MODEL_INSERT),
    array('status', 1, self::MODEL_INSERT),
  );

  /**
   * 登录指定用户
   * @param  integer $uid 用户ID
   * @return boolean      ture-登录成功，false-登录失败
   */
  public function login($uid) {
    /* 检测是否在当前应用注册 */
    $user = $this->field(true)->find($uid);
    if (!$user) { //未注册
      /* 在当前应用中注册用户 */
      $Api = new UserApi();
      $info = $Api->info($uid);
      $user = $this->create(array('nickname' => $info[1], 'status' => 1));
      $user['uid'] = $uid;
      if (!$this->add($user)) {
        $this->error = '前台用户信息注册失败，请重试！';
        return false;
      }
    } elseif (1 != $user['status']) {
      $this->error = '用户未激活或已禁用！'; //应用级别禁用
      return false;
    }

    /* 登录用户 */
    $this->autoLogin($user);

    //记录行为
    action_log('user_login', 'member', $uid, $uid);

    return true;
  }

  /**
   * 注销当前用户
   * @return void
   */
  public function logout() {
    session('user_auth', null);
    session('user_auth_sign', null);
  }

  /**
   * 自动登录用户
   * @param  integer $user 用户信息数组
   */
  private function autoLogin($user) {
    /* 更新登录信息 */
    $data = array(
      'uid' => $user['uid'],
      'loginnum' => array('exp', '`login`+1'),
      'lastdate' => NOW_TIME,
      'lastip' => get_client_ip(1),
    );
    $this->save($data);

    /* 记录登录SESSION和COOKIES */
    $auth = array(
      'uid' => $user['uid'],
      'username' => get_username($user['uid']),
      'last_login_time' => $user['last_login_time'],
    );

    session('user_auth', $auth);
    session('user_auth_sign', data_auth_sign($auth));
  }

}
