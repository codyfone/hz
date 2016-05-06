<?php

namespace Common\Model;

use Think\Model\RelationModel;

class Files_tableModel extends RelationModel {

  protected $_link = array(
    'user' => array(
      'mapping_type' => self::BELONGS_TO,
      'mapping_name' => 'user',
      'class_name' => 'user_table',
      'foreign_key' => 'user_id',
      'as_fields' => 'username:username',
    ),
    'baseinfo' => array(
      'mapping_type' => self::HAS_ONE,
      'mapping_name' => 'baseinfo',
      'class_name' => 'files_baseinfo_table',
      'foreign_key' => 'files_id',
      'as_fields' => 'description:description',
    ),
    'path' => array(
      'mapping_type' => self::HAS_ONE,
      'mapping_name' => 'path',
      'class_name' => 'files_path_table',
      'foreign_key' => 'files_id',
      'as_fields' => 'path:path',
    ),
  );

}
