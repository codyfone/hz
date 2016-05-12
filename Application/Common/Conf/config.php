<?php

$document = str_replace("\\", '/', $_SERVER['PHP_SELF']);
$index_end = substr($document, 1);
$index = str_replace('/' . $index_end, '', $document);
$item_end = strstr($document, '/index.php');
$item = str_replace($item_end, '', $document);
define('INDEX', $index);
define('DOMAIN', $_SERVER['SERVER_NAME']);
define('ITEM', $item);
session(array('path' => CONF_PATH . '/Session', 'prefix' => 'map'));
return array(
  'URL_CASE_INSENSITIVE' => true, //url地址区分大小写，true为不区分
  'LOAD_EXT_CONFIG' => 'conn,appcfg', //自动加载其他配置文件
  'LOAD_EXT_FILE' => 'firstpinyin,pinyin,arraysort,arrayiconv,randnum,curl', //自动加载函数
  'ADMIN_IMG' => 'Skin/Admin/Img',
  'MODULE_ALLOW_LIST' => ['Home', 'Admin'],
  'DEFAULT_MODULE' => 'Home',
  'TMPL_PARSE_STRING' => array(
    '__ADMIN.JS__' => 'Skin/Admin/Js',
    '__ADMIN.IMG__' => 'Skin/Admin/Img',
    '__ADMIN.CSS__' => 'Skin/Admin/Css',
    '__ADMIN.UPLOAD__' => 'Uploads/Admin',
    '__UI__' => 'Skin/Public/Easyui',
    '__JS__' => 'Skin/Public/Js',
    '__IMG__' => 'Skin/Public/Img',
    '__CSS__' => 'Skin/Public/Css',
    '__UPLOAD__' => 'Uploads',
    '__RUNTIME__' => 'Application/Runtime',
    '__ITEM__' => $item,
    'COOKIE_PREFIX' => 'map',
  ),
    //'配置项' => '配置值'
);
