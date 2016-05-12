<?php

namespace Home\Controller;

use User\Api\UserApi;

/**
 * 用户控制器
 * 包括用户中心，用户登录及注册
 */
class MemberController extends HomeController {
  /* 用户中心首页 */

  public function index() {
    $member_auth = session('user_auth');
    if ($member_auth['modelid'] == 1) {
      $this->redirect('Exhibitor/index');
    } else if ($member_auth['modelid'] == 2) {
      $this->redirect('Designer/index');
    } else if ($member_auth['modelid'] == 3) {
      $this->redirect('Factory/index');
    } else {
      D('Member')->logout();
      $this->error('登录错误,请重新登录！', U('Member/login'));
    }
  }

  /* 注册页面 */

  public function register($type = 1, $username = '', $password = '', $repassword = '', $email = '', $verify = '', $nickname = '', $mobile = '') {
    if (!C('USER_ALLOW_REGISTER')) {
      $this->error('注册已关闭');
    }
    if (IS_POST) { //注册用户
      /* 检测验证码 */
//      if (!check_verify($verify)) {
//        $this->error('验证码输入错误！');
//      }

      /* 检测密码 */
      if ($password != $repassword) {
        $this->error('密码和重复密码不一致！');
      }

      /* 调用注册接口注册用户 */
      $User = new UserApi;
      $uid = $User->register($username, $password, $email, $mobile);
      //$uid = 1;
      if (0 < $uid) { //注册成功
        //TODO: 发送验证邮件
         $data['nickname'] = $nickname ? $nickname : $username;
         $data2 = ['userid'=>$uid,'name'=>$data['nickname']];
        if ($type == 2) {
          $data = ['modelid' => 2, 'groupid' => 6];
          M('Member_designer')->add($data2);
        } else if ($type == 3) {
          $data = ['modelid' => 3, 'groupid' => 12];
          M('Member_factory')->add($data2);
        } else {
          $data = ['modelid' => 1, 'groupid' => 11];
          M('Member_exhibitor')->add($data2);
        }
        // $data['status'] = 
        M('Member')->where('id=' . $uid)->save($data);
        $this->success('注册成功！', U('login'));
      } else { //注册失败，显示错误信息
        $this->error($this->showRegError($uid));
      }
    } else { //显示注册表单
      $this->assign('modelid', $type);
      $this->display();
    }
  }

  /*
   * 用户名重复检测
   */

  public function checkDenyMember($username) {
    if (!preg_match("/^[a-zA-Z_]\\w+$/i", $username)) {
      exit('0');
    }
    $count = M('Member')->where('username="' . $username . '"')->count();
    if ($count > 0)
      exit('0');
    exit('1');
  }

  /*
   * 邮箱重复检测
   */

  public function checkDenyEmail($email) {
    if (!preg_match("/^\\w+((-\\w+)|(\\.\\w+))*\\@[A-Za-z0-9]+((\\.|-)[A-Za-z0-9]+)*\\.[A-Za-z0-9]+$/i", $email)) {
      exit('0');
    }
    if ($id = is_login()) {
      $count = M('Member')->where('email="' . $email . '" AND id!=' . $id)->count();
    } else {
      $count = M('Member')->where('email="' . $email . '"')->count();
    }
    if ($count > 0)
      exit('0');
    exit('1');
  }

  /*
   * 手机号重复检测
   */

  public function checkDenyMobile($mobile) {
    if (!preg_match("/^13[0-9]{9}|15[012356789][0-9]{8}|18[0256789][0-9]{8}|147[0-9]{8}$/i", $mobile)) {
      exit('0');
    }
    if ($id = is_login()) {
      $count = M('Member')->where('mobile="' . $mobile . '" AND id!=' . $id)->count();
    } else {
      $count = M('Member')->where('mobile="' . $mobile . '"')->count();
    }
    if ($count > 0)
      exit('0');
    exit('1');
  }

  /*
   * 名称重复检测
   */

  public function checkDenyNickname($nickname) {
    if (is_badword($nickname) || !preg_match("/^[a-zA-Z0-9_\x7f-\xff]+$/", $nickname)) {
      exit('0');
    }
    if ($id = is_login()) {
      $count = M('Member')->where('nickname="' . $nickname . '" AND id!=' . $id)->count();
    } else {
      $count = M('Member')->where('nickname="' . $nickname . '"')->count();
    }
    if ($count > 0)
      exit('0');
    exit('1');
  }

  /* 登录页面 */

  public function login($username = '', $password = '', $code = '') {

    if (IS_POST) { //登录验证 
      if ($username == '') {
        $this->error('用户名不能为空！');
      }
      if ($password == '') {
        $this->error('密码不能为空！');
      }
//      if ($code == '' && C('CODE_ON') == 1) {
//        $this->error('验证码不能为空！');
//      }
//      /* 检测验证码 */
//      $verify = new \Think\Verify();
//
//      if (!$verify->check($code, 1)) {
//        $this->error('验证码输入错误！');
//      }

      /* 调用UC登录接口登录 */
      $user = new UserApi;
      $uid = $user->login($username, $password);
      if (0 < $uid) { // 登录成功
        $member_auth = session('user_auth');
        if ($member_auth['modelid'] == 1) {
          $this->success('登录成功！', U('Exhibitor/index'));
        } else if ($member_auth['modelid'] == 2) {
          $this->success('登录成功！', U('Designer/index'));
        } else if ($member_auth['modelid'] == 3) {
          $this->success('登录成功！', U('Factory/index'));
        } else {
          D('Member')->logout();
          $this->error('登录错误,请重新登录！', U('Member/login'));
        }
      } else { //登录失败
        switch ($uid) {
          case -1: $error = '用户不存在或被禁用！';
            break; //系统级别禁用
          case -2: $error = '密码错误！';
            break;
          default: $error = '未知错误！';
            break; // 0-接口参数错误（调试阶段使用）
        }
        $this->error($error);
      }
    } else { //显示登录表单
      $this->display();
    }
  }

  /* 退出登录 */

  public function logout() {
    if (is_login()) {
      D('Member')->logout();
      $this->success('退出成功！', U('Member/login'));
    } else {
      $this->redirect('Member/login');
    }
  }

  /* 验证码，用于登录和注册 */

  public function verify() {
    $verify = new \Think\Verify();
    $verify->entry(1);
  }

  /**
   * 获取用户注册错误信息
   * @param  integer $code 错误编码
   * @return string        错误信息
   */
  private function showRegError($code = 0) {
    switch ($code) {
      case -1: $error = '用户名长度必须在16个字符以内！';
        break;
      case -2: $error = '用户名被禁止注册！';
        break;
      case -3: $error = '用户名被占用！';
        break;
      case -4: $error = '密码长度必须在6-30个字符之间！';
        break;
      case -5: $error = '邮箱格式不正确！';
        break;
      case -6: $error = '邮箱长度必须在1-32个字符之间！';
        break;
      case -7: $error = '邮箱被禁止注册！';
        break;
      case -8: $error = '邮箱被占用！';
        break;
      case -9: $error = '手机格式不正确！';
        break;
      case -10: $error = '手机被禁止注册！';
        break;
      case -11: $error = '手机号被占用！';
        break;
      default: $error = '未知错误';
    }
    return $error;
  }

  /**
   * 修改密码提交
   * @author huajie <banhuajie@163.com>
   */
  public function profile() {
    if (!is_login()) {
      $this->error('您还没有登陆', U('Member/login'));
    }
    if (IS_POST) {
      //获取参数
      $uid = is_login();
      $password = I('post.old');
      $repassword = I('post.repassword');
      $data['password'] = I('post.password');
      empty($password) && $this->error('请输入原密码');
      empty($data['password']) && $this->error('请输入新密码');
      empty($repassword) && $this->error('请输入确认密码');

      if ($data['password'] !== $repassword) {
        $this->error('您输入的新密码与确认密码不一致');
      }

      $Api = new UserApi();
      $res = $Api->updateInfo($uid, $password, $data);
      if ($res['status']) {
        $this->success('修改密码成功！');
      } else {
        $this->error($res['info']);
      }
    } else {
      $this->display();
    }
  }

}
