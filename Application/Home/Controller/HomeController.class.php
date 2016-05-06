<?php

namespace Home\Controller;

use Think\Controller;

/**
 * 前台公共控制器
 * 为防止多分组Controller名称冲突，公共Controller名称统一使用分组名称
 */
class HomeController extends Controller {
  /* 空操作，用于输出404页面 */

  public function _empty() {
    $this->redirect('Index/index');
  }

  protected function _initialize() {
    if (!C('CFG_ON')) {
      $this->error('站点已经关闭，请稍后访问~');
    }
  }

  /* 用户登录检测 */

  protected function login() {
    /* 用户登录检测 */
    is_login() || $this->error('您还没有登录，请先登录！', U('User/login'));
  }

}
