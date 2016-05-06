<?php

namespace Common\Model;

use Think\Model\RelationModel;

class DesignModel extends RelationModel {

  protected $_link = array(
    'designer' => array(
      'mapping_type' => self::BELONGS_TO,
      'mapping_name' => 'designer',
      'class_name' => 'member_designer',
      'foreign_key' => 'mid',
      'as_fields' => 'username:designer',
    ),
    'check' => array(
      'mapping_type' => self::BELONGS_TO,
      'mapping_name' => 'check',
      'class_name' => 'user_table',
      'foreign_key' => 'check_id',
      'as_fields' => 'username:checkname',
    ),
    'main' => array(
      'mapping_type' => self::HAS_ONE,
      'mapping_name' => 'main',
      'class_name' => 'Design_main',
      'foreign_key' => 'des_id',
    ),
    'project' => array(
      'mapping_type' => self::BELONGS_TO,
      'mapping_name' => 'project',
      'class_name' => 'project',
      'foreign_key' => 'pro_id',
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
