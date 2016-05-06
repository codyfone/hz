<?php

namespace Common\Model;

use Think\Model\RelationModel;

class Log_tableModel extends RelationModel {

  protected $_link = array(
    'user' => array(
      'mapping_type' => self::BELONGS_TO,
      'mapping_name' => 'user',
      'class_name' => 'user_table',
      'foreign_key' => 'user_id',
      'as_fields' => 'username:username',
    ),
    'logmain' => array(
      'mapping_type' => self::HAS_ONE,
      'mapping_name' => 'logmain',
      'class_name' => 'log_main_table',
      'foreign_key' => 'log_id',
    ),
  );

}
