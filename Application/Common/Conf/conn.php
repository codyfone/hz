<?php
//数据库配置信息
return array(
	'DB_TYPE' => 'mysql', // 数据库类型
	'DB_HOST' => '127.0.0.1', // 服务器地址
	'DB_NAME' => 'hz8', // 数据库名
	'DB_USER' => 'root', // 用户名
	'DB_PWD' => '', // 密码
	'DB_PORT' => 3306, // 端口
	'DB_PREFIX' => 'hz_', // 数据库表前缀,
  'DB_PARAMS' => array(\PDO::ATTR_CASE => \PDO::CASE_NATURAL),
);