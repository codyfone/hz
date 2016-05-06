<?php

namespace Common\Model;

use Think\Model\RelationModel;

class ProjectModel extends RelationModel {

  protected $_link = array(
    'baseinfo' => array(
      'mapping_type' => self::HAS_ONE,
      'mapping_name' => 'baseinfo',
      'class_name' => 'project_baseinfo',
      'foreign_key' => 'pro_id',
    ),
    'exhibitor' => array(
      'mapping_type' => self::BELONGS_TO,
      'mapping_name' => 'client',
      'class_name' => 'member',
      'foreign_key' => 'mid',
      'as_fields' => 'username:exhibitor',
    ),
  );

}
