<?php

namespace Common\Model;

use Think\Model\RelationModel;

class Sms_tableModel extends RelationModel {

  protected $_link = array(
    'baseinfo' => array(
      'mapping_type' => self::HAS_ONE,
      'mapping_name' => 'baseinfo',
      'class_name' => 'sms_baseinfo_table',
      'foreign_key' => 'sms_id',
    ),
    'user' => array(
      'mapping_type' => self::BELONGS_TO,
      'mapping_name' => 'user',
      'class_name' => 'user_table',
      'foreign_key' => 'user_id',
      'as_fields' => 'username:username',
    ),
    'receive' => array(
      'mapping_type' => self::HAS_MANY,
      'mapping_name' => 'receive',
      'class_name' => 'sms_receive_table',
      'foreign_key' => 'sms_id',
    ),
  );

}
