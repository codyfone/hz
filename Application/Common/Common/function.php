<?php

session(array('path' => CONF_PATH . '/Session', 'prefix' => 'map'));   //设置session前缀

/**
 * 检测用户是否登录
 * @return integer 0-未登录，大于0-当前登录用户ID
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
function is_login() {
  $user = session('user_auth');
  if (empty($user)) {
    return 0;
  } else {
    return session('user_auth_sign') == data_auth_sign($user) ? $user['uid'] : 0;
  }
}

/*
 * 判断输入中有没有非法字符
 */

function is_badword($string) {
  $badwords = array("\\", '&', ' ', "'", '"', '/', '*', ',', '<', '>', "\r", "\t", "\n", "#");
  foreach ($badwords as $value) {
    if (strpos($string, $value) !== FALSE) {
      return TRUE;
    }
  }
  return FALSE;
}

/**
 * 数据签名认证
 * @param  array  $data 被认证的数据
 * @return string       签名
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
function data_auth_sign($data) {
  //数据类型检测
  if (!is_array($data)) {
    $data = (array) $data;
  }
  ksort($data); //排序
  $code = http_build_query($data); //url编码并生成query字符串
  $sign = sha1($code); //生成签名
  return $sign;
}

//去除引号自动转义
/*
  return String
  $str		传入的字符
 */
function slashes($str) {
  if (get_magic_quotes_gpc()) {
    return stripcslashes($str);
  } else {
    return $str;
  }
}

//中文截取函数
/*
  return String
  $str		传入的字符
  $start		起始位置
  $start		结束位置
 */
function cSubstr($str, $start, $len) {
  for ($i = $start; $i < $len; $i++) {
    $temp_str = substr($str, 0, 1);
    if (ord($temp_str) > 127) {
      $i++;
      if ($i < $len) {
        $new_str[] = substr($str, 0, 3);
        $str = substr($str, 3);
      }
    } else {
      $new_str[] = substr($str, 0, 1);
      $str = substr($str, 1);
    }
  }
  return join($new_str);
}

//摘要截取
/*
  return String
  $str		传入的字符
  $start		起始位置
  $end		结束位置
 */
function subtext($str, $start = 0, $end = 180) {
  $str = strip_tags($str);
  $str = trim(str_replace('&nbsp;', '', $str));
  $str = preg_replace("/\s/", "", $str);
  return cSubstr($str, $start, $end);
}

//保留小数点
/*
  return Snumber
  $num		传入的数值
 */
function roundnum($num) {
  $bit = C('CFG_NUM');
  return number_format($num, $bit);
}

//计算日期相差月份
/*
  return Snumber
  $date1		日期1
  $date2		日期2
  $tags		日期分隔符
 */
function getMonthNum($date1, $date2) {
  $date1_stamp = strtotime($date1);
  $date2_stamp = strtotime($date2);
  list($date_1['y'], $date_1['m']) = explode("-", date('Y-m', $date1_stamp));
  list($date_2['y'], $date_2['m']) = explode("-", date('Y-m', $date2_stamp));
  return abs(($date_2['y'] - $date_1['y']) * 12 + $date_2['m'] - $date_1['m']);
}

//计算日期相差月份
/*
  return Snumber
  $num		传入的数字
 */
function num_format($num, $dec = 0) {
  if (C('CFG_NUM')) {
    $dec = C('CFG_NUM');
  }
  if (!is_numeric($num)) {
    return false;
  }
  if ($num == 0) {
    return sprintf("%." . $dec . "f", '0.00');
  }
  $num = sprintf("%." . $dec . "f", $num);
  $num = explode('.', $num); //把整数和小数分开
  $rl = $num[1]; //小数部分的值
  $j = strlen($num[0]) % 3; //整数有多少位
  $sl = substr($num[0], 0, $j); //前面不满三位的数取出来
  $sr = substr($num[0], $j); //后面的满三位的数取出来
  $i = 0;
  while ($i <= strlen($sr)) {
    $rvalue = $rvalue . ',' . substr($sr, $i, 3); //三位三位取出再合并，按逗号隔开
    $i = $i + 3;
  }
  $rvalue = $sl . $rvalue;
  $rvalue = substr($rvalue, 0, strlen($rvalue) - 1); //去掉最后一个逗号
  $rvalue = explode(',', $rvalue); //分解成数组
  if ($rvalue[0] == 0) {
    array_shift($rvalue); //如果第一个元素为0，删除第一个元素
  }
  $rv = $rvalue[0]; //前面不满三位的数
  for ($i = 1; $i < count($rvalue); $i++) {
    $rv = $rv . ',' . $rvalue[$i];
  }
  if (!empty($rl)) {
    $rvalue = $rv . '.' . $rl; //小数不为空，整数和小数合并
  } else {
    $rvalue = $rv; //小数为空，只有整数
  }
  return $rvalue;
}
/*
 * uincode 转中文
 */
function unicode_decode($name)
{
    // 转换编码，将Unicode编码转换成可以浏览的utf-8编码
    $pattern = '/([\w]+)|(\\\u([\w]{4}))/i';
    preg_match_all($pattern, $name, $matches);
    if (!empty($matches))
    {
        $name = '';
        for ($j = 0; $j < count($matches[0]); $j++)
        {
            $str = $matches[0][$j];
            if (strpos($str, '\\u') === 0)
            {
                $code = base_convert(substr($str, 2, 2), 16, 10);
                $code2 = base_convert(substr($str, 4), 16, 10);
                $c = chr($code).chr($code2);
                $c = iconv('UCS-2', 'UTF-8', $c);
                $name .= $c;
            }
            else
            {
                $name .= $str;
            }
        }
    }
    return $name;
}