<?php

namespace Admin\Helper;

use Think\Controller;

//附加类
class PaymentHelper extends Controller {

  public function _initialize() {
    $this->model = M('Payment');
  }

  public function fetch_all() {
    $entrydir = LIB_PATH . 'Haidao/driver/pay/';
    $folders = glob($entrydir . '*');
    foreach ($folders as $key => $folder) {
      $file = $folder . DIRECTORY_SEPARATOR . 'config.xml';
      if (file_exists($file)) {
        $importtxt = @implode('', file($file));
        $xmldata = xml2array($importtxt);
        $payments[$xmldata['pay_code']] = $xmldata;
        $payments[$xmldata['pay_code']]['pay_install'] = 0;
      }
    }
    $payments = array_merge_multi($payments, $this->get_fetch_all());
    return multi_array_sort($payments, 'pay_name');
  }

  public function get_fetch_all() {
    $result = array();
    $result = $this->model->getField('pay_code,pay_name,pay_fee,pay_desc,enabled,config,dateline,sort,isonline,applie', TRUE);
    foreach ($result as $key => $value) {
      $result[$key]['config'] = unserialize($value['config']);
      $result[$key]['pay_install'] = 1;
    }
    return $result;
  }

  /**
   * [支付方式列表]
   * @return boolean
   */
  public function build_cache() {
    $result_enable = $this->model->where(array('enabled' => 1))->getField('pay_code,pay_name,pay_fee,pay_desc,enabled,config,dateline,sort,isonline,applie');
    S('payment_enable', $result_enable);
    return TRUE;
  }

  /**
   * [启用禁用支付方式]
   * @param string $pay_code 支付方式标识
   * @return TRUE OR ERROR
   */
  public function change_enabled($pay_code) {
    $result = $this->model->where(array('pay_code' => $pay_code))->save(array('enabled' => array('exp', '1-enabled'), 'dateline' => time()));
    if ($result == 1) {
      $result = TRUE;
      $this->build_cache();
    } else {
      $result = $this->model->getError();
    }
    return $result;
  }

  /**
   * [修改支付方式]
   * @param array $data 数据
   * @param bool $valid 是否M验证
   * @return TRUE OR ERROR
   */
  public function save() {
    $data = $this->model->create();
//    print_r($data);exit;
    $data['config'] = serialize(I('post.config'));
//    print_r($data['config']);exit;
    $pay_install = I('post.pay_install');
    if ($pay_install == 0) {
      $result = $this->model->add($data);
    } else {

      $data['id'] = $this->model->where('pay_code=\''.$data['pay_code'].'\'')->getField('id');
      $result = $this->model->where('pay_code=\''.$data['pay_code'].'\'')->save($data);
    }
    if ($result) {
      $result = TRUE;
      $this->build_cache();
    } else {
      $result = $this->model->getError();
    }
    return $result;
  }

  /**
   * 获取已开启支付方式
   * @return array 已开启的支付方式
   */
  public function getpayments($applie = 'pc', $pays = array()) {
    if (FALSE === cache('payment_enable'))
      $this->build_cache();
    $payments = cache('payment_enable');
    foreach ($payments as $key => $pay) {
      if ($applie && $pay['applie'] != $applie)
        unset($payments[$key]);
    }
    $payments = array_intersect_key($payments, array_flip($pays));
    $result = array();
    foreach ($payments as $k => $pay) {
      $pay['pay_ico'] = $pay['pay_code'];
      if ($k == 'bank') {
        $config = unserialize($pay['config']);
        $banks = explode(',', $config['banks']);
        foreach ($banks as $bank) {
          $pay['pay_ico'] = $bank;
          $pay['pay_code'] = 'bank';
          $pay['pay_bank'] = $bank;
          $result[] = $pay;
        }
      } else {
        $result[] = $pay;
      }
    }
    return $result;
  }

  /* 创建支付请求 */

  public function gateway($pay_code, $pay_info, $pay_config = null) {
    $pay_factory = new \Haidao\pay_factory($pay_code, $pay_config);
    return $pay_factory->set_productinfo($pay_info)->gateway();
  }

  /* 同步回调 */

  public function _return($driver) {
    $pay_factory = new \Haidao\pay_factory($driver);
    return $pay_factory->_return();
  }

  /* 异步通知 */

  public function _notify($driver) {
    return $this->_return($driver);
  }

}
