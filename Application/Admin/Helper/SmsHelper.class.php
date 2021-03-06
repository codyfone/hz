<?php

namespace Admin\Helper;

use Think\Controller;

//附加类
class SmsHelper extends Controller {
  /*
    发送站内信
    return String
    $data		传入的内容数据，传入数组  array(title=>'标题',description=>'摘要');
    $uid		接收信息的用户ID，传入数组
   */

  public function sendsms($data, $uid) {
    if ($uid) {
      $sms = D('Sms_table');
      $receive = M('Sms_receive_table');
      $datas['user_id'] = $_SESSION['login']['se_id'];
      $datas['title'] = $data['title'];
      $datas['sendtime'] = date("Y-m-d H:i:s", time());
      $datas['baseinfo'] = array(
        'description' => $data['description']
      );
      $add = $sms->relation('baseinfo')->add($datas);
      if ($add > 0) {
        if (is_array($uid)) {
          foreach ($uid as $t) {
            $datau = array(
              'sms_id' => $add,
              'user_id' => $t['user_id']
            );
            $receive->add($datau);
          }
        } else {
          $datau = array(
            'sms_id' => $add,
            'user_id' => $uid
          );
          $receive->add($datau);
        }
        return $add;
      } else {
        return 0;
      }
    } else {
      return 0;
    }
  }

}
