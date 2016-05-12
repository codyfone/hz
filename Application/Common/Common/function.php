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

function unicode_decode($name) {
  // 转换编码，将Unicode编码转换成可以浏览的utf-8编码
  $pattern = '/([\w]+)|(\\\u([\w]{4}))/i';
  preg_match_all($pattern, $name, $matches);
  if (!empty($matches)) {
    $name = '';
    for ($j = 0; $j < count($matches[0]); $j++) {
      $str = $matches[0][$j];
      if (strpos($str, '\\u') === 0) {
        $code = base_convert(substr($str, 2, 2), 16, 10);
        $code2 = base_convert(substr($str, 4), 16, 10);
        $c = chr($code) . chr($code2);
        $c = iconv('UCS-2', 'UTF-8', $c);
        $name .= $c;
      } else {
        $name .= $str;
      }
    }
  }
  return $name;
}

function getFullArea($id = '') {
  if (!$id)
    return;
  $area = getFullAreaStr($id);

  $area = explode(',', $area);
  return json_encode($area);
}

function getFullAreaStr($id) {
  if ($id = intval($id)) {
    $area = M('Citys')->field('_parentId, name')->where('linkageid=' . $id)->find();
    if ($area['_parentId'] == 0) {
      return $area['name'];
    }
    return getFullAreaStr($area['_parentId']) . ',' . $area['name'];
  }
}

/**
 * 生成订单号
 */
function build_order_no($suffix = 'o') {
  return $suffix . date('Ymd') . substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8);
}

/**
 * 对多位数组进行排序
 * @param $multi_array 数组
 * @param $sort_key需要传入的键名
 * @param $sort排序类型
 */
function multi_array_sort($multi_array, $sort_key, $sort = SORT_DESC) {
  if (is_array($multi_array)) {
    foreach ($multi_array as $row_array) {
      if (is_array($row_array)) {
        $key_array[] = $row_array[$sort_key];
      } else {
        return FALSE;
      }
    }
  } else {
    return FALSE;
  }
  array_multisort($key_array, $sort, $multi_array);
  return $multi_array;
}

/**
 * XML转数组
 * @param string $arr
 * @param boolean $isnormal
 * @return array
 */
function xml2array(&$xml, $isnormal = FALSE) {
$xml_parser = new \Org\Util\xml($isnormal);
  $data = $xml_parser->parse($xml);
  $xml_parser->destruct();
  return $data;
}

/**
 * 数组转XML
 * @param array $arr
 * @param boolean $htmlon
 * @param boolean $isnormal
 * @param intval $level
 * @return type
 */
function array2xml($arr, $htmlon = TRUE, $isnormal = FALSE, $level = 1) {
  $s = $level == 1 ? "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>\r\n<root>\r\n" : '';
  $space = str_repeat("\t", $level);
  foreach ($arr as $k => $v) {
    if (!is_array($v)) {
      $s .= $space . "<item id=\"$k\">" . ($htmlon ? '<![CDATA[' : '') . $v . ($htmlon ? ']]>' : '') . "</item>\r\n";
    } else {
      $s .= $space . "<item id=\"$k\">\r\n" . array2xml($v, $htmlon, $isnormal, $level + 1) . $space . "</item>\r\n";
    }
  }
  $s = preg_replace("/([\x01-\x08\x0b-\x0c\x0e-\x1f])+/", ' ', $s);
  return $level == 1 ? $s . "</root>" : $s;
}

/**
 * 电子邮箱格式判断
 * @param  string $email 字符串
 * @return boolean
 */
function is_email($email) {
  if (!empty($email)) {
    return preg_match('/^[a-z0-9]+([\+_\-\.]?[a-z0-9]+)*@([a-z0-9]+[\-]?[a-z0-9]+\.)+[a-z]{2,6}$/i', $email);
  }
  return FALSE;
}

/**
 * 手机号码格式判断
 * @param string $string
 * @return boolean
 */
function is_mobile($string) {
  if (!empty($string)) {
    return preg_match('/^1[3|4|5|7|8][0-9]\d{8}$/', $string);
  }
  return FALSE;
}
/**
 * 随机字符串
 * @param int $length 长度
 * @param int $numeric 类型(0：混合；1：纯数字)
 * @return string
 */
function random($length, $numeric = 0) {
	 $seed = base_convert(md5(microtime().$_SERVER['DOCUMENT_ROOT']), 16, $numeric ? 10 : 35);
	 $seed = $numeric ? (str_replace('0', '', $seed).'012340567890') : ($seed.'zZ'.strtoupper($seed));
	 if($numeric) {
		  $hash = '';
	 } else {
		  $hash = chr(rand(1, 26) + rand(0, 1) * 32 + 64);
		  $length--;
	 }
	 $max = strlen($seed) - 1;
	 for($i = 0; $i < $length; $i++) {
		  $hash .= $seed{mt_rand(0, $max)};
	 }
	 return $hash;
}


/**
 * 将list_to_tree的树还原成列表
 * @param  array $tree  原来的树
 * @param  string $child 孩子节点的键
 * @param  string $order 排序显示的键，一般是主键 升序排列
 * @param  array  $list  过渡用的中间数组，
 * @return array		  返回排过序的列表数组
 * @author yangweijie <yangweijiester@gmail.com>
 */
function tree_to_list($tree, $child = '_child', $order = 'id', &$list = array()) {
	 if (is_array($tree)) {
		  $refer = array();
		  foreach ($tree as $key => $value) {
				$reffer = $value;
				if (isset($reffer[$child])) {
					 unset($reffer[$child]);
					 tree_to_list($value[$child], $child, $order, $list);
				}
				$list[] = $reffer;
		  }
		  $list = list_sort_by($list, $order, $sortby = 'asc');
	 }
	 return $list;
}


/**
 * 把返回的数据集转换成Tree
 * @param array $list 要转换的数据集
 * @param string $pid parent标记字段
 * @param string $level level标记字段
 * @return array
 * @author
 */
function list_to_tree($list, $pk = 'id', $pid = 'parent_id', $child = '_child', $root = 0) {
	 $tree = array();
	 if (is_array($list)) {
		  // 创建基于主键的数组引用
		  $refer = array();
		  foreach ($list as $key => $data) {
				$refer[$data[$pk]] = & $list[$key];
		  }
		  foreach ($list as $key => $data) {
				// 判断是否存在parent
				$parentId = $data[$pid];
				if ($root == $parentId) {
					 $tree[$data[$pk]] = & $list[$key];
				} else {
					 if (isset($refer[$parentId])) {
						  $parent = & $refer[$parentId];
						  $parent[$child][$data[$pk]] = & $list[$key];
					 }
				}
		  }
	 }
	 return $tree;
}


/**
 * 对查询结果集进行排序
 * @access public
 * @param array $list 查询结果
 * @param string $field 排序的字段名
 * @param array $sortby 排序类型
 * asc正向排序 desc逆向排序 nat自然排序
 * @return array
 */
function list_sort_by($list, $field, $sortby = 'asc') {
	 if (is_array($list)) {
		  $refer = $resultSet = array();
		  foreach ($list as $i => $data)
				$refer[$i] = &$data[$field];
		  switch ($sortby) {
				case 'asc': // 正向排序
					 asort($refer);
					 break;
				case 'desc':// 逆向排序
					 arsort($refer);
					 break;
				case 'nat': // 自然排序
					 natcasesort($refer);
					 break;
		  }
		  foreach ($refer as $key => $val)
				$resultSet[] = &$list[$key];
		  return $resultSet;
	 }
	 return false;
}
/**
 * 格式化金额
 * @param type $money
 * @return type
 */
function money($money, $str = ',') {
    return number_format($money, 2, '.', $str);
}
/*返回文件大小*/
function return_bytes($val) {
    $val = trim($val);
    $last = strtolower($val{strlen($val)-1});
    switch($last) {
        case 'g': $val *= 1024;
        case 'm': $val *= 1024;
        case 'k': $val *= 1024;
    }
    return $val;
}
/**
 * 多维数组合并（支持多数组）
 * @return array
 */
function array_merge_multi () {
    $args = func_get_args();
    $array = array();
    foreach ( $args as $arg ) {
        if ( is_array($arg) ) {
            foreach ( $arg as $k => $v ) {
                if ( is_array($v) ) {
                    $array[$k] = isset($array[$k]) ? $array[$k] : array();
                    $array[$k] = array_merge_multi($array[$k], $v);
                } else {
                    $array[$k] = $v;
                }
            }
        }
    }
    return $array;
}