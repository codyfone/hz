<?php

namespace Admin\Controller;

use Think\Controller;

class PaymentController extends Controller {

  public $payments;
  public $service;

  public function _initialize() {
    $this->service = A('Payment', 'Helper');
    $this->payments = $this->service->fetch_all();
  }

  /**
   * 支付方式列表
   * @param $gid  传入分类ID
   * @param $json    为NULL输出模板。为1时输出列表数据到前端，格式为Json
   * @examlpe 
   */
  public function setting($json = null) {
    $Public = A('Index', 'Helper');
    $Public->check('Payment', array('r'));
    if ($json == 1) {
      $payments = $this->payments;
      $info = [];
      foreach ($this->payments as $k => $v) {
        $info[] = [
          'pay_code' => $v['pay_code'],
          'pay_name' => $v['pay_name'],
          'pay_desc' => $v['pay_desc'],
          'enabled' => $v['enabled'],
          'new_enabled' => $v['enabled'] == 1 ? '开启' : '关闭',
          'isonline' => $v['isonline'],
          'applie' => $v['applie'],
          'version' => $v['version'],
          'is_install' => $v['is_install'] == 1 ? '安装' : '未安装',
        ];
      }
      echo json_encode($info);
      exit;
    }

    $this->display();
  }

  /**
   * 新增与更新数据
   * @param $act add为新增、edit为编辑
   * @param $go  为1时，获取post
   * @param $id  传人数据id
   * @examlpe 
   */
  public function config($go = false, $pay_code = NULL) {
    $Write = A('Write', 'Helper');

    //main
    $payment = D('Payment');
    if ($go == false) {
      $this->assign('uniqid', uniqid());
      if (!$pay_code) {
        $pay_code = NULL;
        $this->show('无法获取支付方式');
      } else {
        $map['paycode'] = array('eq', $pay_code);
        $payment = $this->payments[$pay_code];
        $this->assign('payment', $payment);
        $this->assign('act', 'edit');
        $this->display();
        unset($map, $payment);
      }
    } else {
      $Public = A('Index', 'Helper');
      $role = $Public->check('Payment', array('c'));
      if ($role < 0) {
        echo $role;
        exit;
      }

      if ($this->service->save()) {
        $this->json();
        echo 1;
      } else {
        echo 0;
      }
    }
  }

  /**
   * 删除数据
   * @param $id  数据Id
   * @examlpe 
   */
  public function del($pay_code) {
    $Public = A('Index', 'Helper');
    $role = $Public->check('Payment', array('d'));
    if ($role < 0) {
      echo $role;
      exit;
    }
    echo $pay_code;exit;
    //main
    if (!$pay_code) {
      echo 0;
    } else {
      $payment = M('Payment');
      $map= [];
      $map['pay_code'] = array('eq', $pay_code);
      $del = $payment->where($map)->delete();
      unset($map);
      if ($del) {
        echo 1;
        $this->json();
      } else {
        echo 0;
      }
      unset($payment);
    }
    unset($Public);
  }

  /**
   * 生成配置文件
   * @examlpe 
   */
  public function json() {
    $Write = A('Write', 'Helper');
    $this->service->build_cache();
    //main
    $payment = M('Payment');
    $info = $payment->field('types,keyword,vals')->select();
    $path = APP_PATH . '/Common/Conf/paycfg.php';
    $ww = $Write->write($path, $info, 'conf');
    if ($ww) {
      echo 1;
    } else {
      echo 0;
    }
    unset($info, $path, $payment, $Write);
  }

}
