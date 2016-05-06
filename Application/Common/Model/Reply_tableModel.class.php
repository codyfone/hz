<?php

namespace Common\Model;

use Think\Model\RelationModel;

class Reply_tableModel extends RelationModel {

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
      'class_name' => 'reply_main_table',
      'foreign_key' => 'reply_id',
      'mapping_fields' => 'pro_id,task_id',
    ),
  );

}
