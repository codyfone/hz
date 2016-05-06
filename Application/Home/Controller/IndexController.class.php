<?php

namespace Home\Controller;

use User\Api\UserApi;

/**
 * 用户控制器
 * 包括用户中心，用户登录及注册
 */
class IndexController extends HomeController {

  public function index() {
    $this->assign('newProjects', $newProjects);
    $this->assign('newZhongbiao', $newZhongbiao);

    $this->display();
  }

  public function youshi() {
    $this->display();
  }

}
