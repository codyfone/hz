<?php

namespace Common\Model;

use Think\Model\RelationModel;

class Worklog_tableModel extends RelationModel {

  protected $_link = array(
    'user' => array(
      'mapping_type' => self::BELONGS_TO,
      'mapping_name' => 'user',
      'class_name' => 'user_table',
      'foreign_key' => 'user_id',
      'as_fields' => 'username:username',
    ),
    'main' => array(
      'mapping_type' => self::HAS_ONE,
      'mapping_name' => 'main',
      'class_name' => 'worklog_main_table',
      'foreign_key' => 'worklog_id',
    ),
    'status' => array(
      'mapping_type' => self::BELONGS_TO,
      'mapping_name' => 'status',
      'class_name' => 'linkage',
      'foreign_key' => 'status',
      'as_fields' => 'val:statusname',
    ),
  );

}
