<?php

namespace Common\Model;

use Think\Model\RelationModel;

class Notice_tableModel extends RelationModel {

  protected $_link = array(
    'user' => array(
      'mapping_type' => self::BELONGS_TO,
      'mapping_name' => 'user',
      'class_name' => 'user_table',
      'foreign_key' => 'user_id',
      'as_fields' => 'username',
    ),
  );

}
