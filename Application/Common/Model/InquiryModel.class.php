<?php

namespace Common\Model;

use Think\Model\RelationModel;

class ProjectModel extends RelationModel {

  protected $_link = array(
    'design' => array(
      'mapping_type' => self::BELONGS_TO,
      'mapping_name' => 'design',
      'class_name' => 'design',
      'foreign_key' => 'pro_id',
    ),
  );

}
