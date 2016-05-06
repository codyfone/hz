<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SmsController
 *
 * @author Administrator
 */

namespace Home\Controller;

/**
 * 用户控制器
 * 包括用户中心，用户登录及注册
 */
class SmsController extends \Think\Controller {

  function verifycode() {
// 图片验证码部分
//        if (empty($_SESSION['code']))
//      exit('-100');
//    if (empty($_GET['session_code']) || preg_match('/^([a-z0-9])$/i', $_GET['session_code']) || $_SESSION['code'] != $_GET['session_code'])
//      exit('-101');
    //$_SESSION['code'] = '';
    $mobile = I('get.mobile');
    $mobile = $mobile ? $mobile : session('mobile');

    if (!session('csms')) {
      session('csms', 0);
    } elseif (session('csms') > 3) {
      exit('-1');
    }
    session('csms', session('csms') + 1);

    if (!preg_match('/^(?:13\d{9}|15[0|1|2|3|5|6|7|8|9]\d{8}|18[0|2|3|5|6|7|8|9]\d{8}|14[5|7]\d{8})$/', $mobile))
      exit('mobile phone error');
    $posttime = NOW_TIME - 86400;
    $where = "`mobile`='$mobile' AND `posttime`>'$posttime'";
    $sms_report = M('Sms_report');
    $num = $sms_report->where($where)->count();
    if ($num > 3) {
      exit('-1'); //当日发送短信数量超过限制 3 条
    }
//同一IP 24小时允许请求的最大数
    $allow_max_ip = 10; //正常注册相当于 10 个人
    $ip = get_client_ip();
    $where = "`ip`='$ip' AND `posttime`>'$posttime'";
    $num = $sms_report->where($where)->count();
    if ($num >= $allow_max_ip) {
      exit('-3'); //当日单IP 发送短信数量超过 $allow_max_ip
    }
    if (C('USER_MOBILE_REGISTER') == 0)
      exit('-99'); //短信功能关闭


    $posttime = NOW_TIME - 600;

    $rs = $sms_report->where("`mobile`='$mobile' AND `posttime`>'$posttime'")->find();
    if ($rs['id_code']) {
      $id_code = $rs['id_code'];
    } else {
      $id_code = randnum(6, 2); //唯一吗，用于扩展验证
    }
    $id_code = '123456'; //测试
//$send_txt = '尊敬的用户您好，您在'.$sitename.'的注册验证码为：'.$id_code.'，验证码有效期为5分钟。';
    $send_txt = $id_code;

    $send_userid = intval(I('get.send_userid')); //操作者id

    $smsapi = A('SmsApi', 'Helper');
//$smsapi->get_price(); //获取短信剩余条数和限制短信发送的ip地址
    $mobile = explode(',', $mobile);

    $tplid = 1;
    $sendtime = I('post.sendtime');
    $sent_time = intval(I('post.sendtype')) == 2 && $sendtime ? trim($sendtime) : date('Y-m-d H:i:s', NOW_TIME);
    $smsapi->send_sms($mobile, $send_txt, $sent_time, CHARSET, $id_code, $tplid); //发送短信
    echo 0;
  }

  /**
   * 短信验证接口
   */
  function id_code($mobile_verify, $mobile = false) {
    exit('1');
    $sms_report_db = M('Sms_report');
    if (preg_match("/[^0-9]+/i", $mobile_verify))
      exit();
    $mobile = $_GET['mobile'];
    if ($mobile) {
      if (!preg_match('/^1([0-9]{10})$/', $mobile))
        exit('0');
      $posttime = NOW_TIME - 600;
      $where = "`mobile`='$mobile' AND `posttime`>'$posttime'";
      $r = $sms_report_db->fields('id,id_code')->where($where)->order('id DESC')->find();
      if ($r && $r['id_code'] == $mobile_verify) {
        if ($_GET['jscheck'] != 1) {//验证通过后，将验证码置为空，防止重复利用！
          $sms_report_db->where($where)->setField('id_code','');
        }
        exit('1');
      } else {
        exit('0');
      }
    } else {
      /* 用户自发短信验证判断，不再传递mobile值，只判断10分钟内这个验证码是否存在，存在即认为此码对应的手机号为你所有 */
      $posttime = NOW_TIME - 600;
      $where = "`id_code`='$mobile_verify' AND `posttime`>'$posttime'";
      $r = $sms_report_db->fields('id_code')->where($where)->order('id DESC')->find();
      if (is_array($r)) {
        exit('1');
      } else {
        exit('0');
      }
    }
  }

}
